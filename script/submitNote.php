<?php
$recipient = $_POST['recipient'];
$pass = $_POST['password'];
$method = $_POST['method'];
$note = $_POST['textarea'];
if(method == "internal"){
	putenv("GNUPGHOME=/tmp");
	$gnupg_obj = gnupg_init();
	$fingerprints = gnupg_import($gnupg_obj,file_get_contents('/var/web-sensitive/keys/'.$recipient.'.pub'));
	$fingerprint = $fingerprints['fingerprint'];
	if($fingerprint == NULL){
		$_SESSION['flash_error'] = "USER NOT FOUND";
		header("Location: /index.php");
	}
	else{
		gnupg_addencryptkey($gnupg_obj,$fingerprint);
		$fingerprints = gnupg_import($gnupg_obj,file_get_contents('/var/web-sensitive/keys/'.$_SESSION['username'].'.sec'));
		$fingerprint =$fingerprints['fingerprint'];
		gnupg_addsignkey($gnupg_obj, $fingerprint, $pass);
		$cyphertext = gnupg_encryptsign($gnupg_obj, $note);
		$filename = fopen('/var/web-sensitive/notes/'.$recipient.'/'.$_SESSION['username'].time(), "w");
		fwrite($filename, $cyphertext);
		fclose($filename);
		header("Location: /index.php");
	}
}
else{
	$username = rand(0,9999999);
	$batch ="Key-Type: RSA
		Key-Length: 2048
		Subkey-Type:RSA
		Subkey-Length: 2048
		Name-Real:".$username."
		Name-Email: ".$recipient."
		Expire-Date: 0
		Passphrase:".$pass."
		%pubring /var/web-sensitive/keys/external/".$username.".pub
		%secring /var/web-sensitive/keys/external/".$username.".sec
		%commit
		%echo Done
		";
	fwrite(fopen("/var/web-sensitive/batch".$username,"w"), $batch);
	exec('export HOME="/tmp";gpg --batch --gen-key /var/web-sensitive/batch'.$username);
	exec("rm /var/web-sensitive/batch".$username);
	$gnupg_obj = gnupg_init();
	$fingerprints = gnupg_import($gnupg_obj,file_get_contents('/var/web-sensitive/keys/external/'.$username.'.pub'));
	$fingerprint = $fingerprints['fingerprint'];
	gnupg_addencryptkey($gnupg_obj,$fingerprint);
	$cyphertext = gnupg_encrypt($gnupg_obj, $note);
	$location = $_SESSION['username'].time();
	$filename = fopen('/var/web-sensitive/notes/external/'.$location,"w");
	fwrite($filename, $cyphertext);
	fclose($filename);
	$link = "https://www.mercuryq.net/script/decrypt.php?target=".$location."&sender=".$username;
	$message = "MercuryQ.net is a simple service to privately exchange information. All messages are secured on
	our server with 2048-bit RSA encryption, via GNUPG. To view the message this person is sending you, simply click
	on the link below and then enter the passphrase you and the sender agreed upon beforehand to see your message. 
	To send a message in return, please make an account from our homepage. 
	Please note that this message will become inaccessible at midnight tonight. Messages between members are never deleted.

	".$link."

	Thank you for using MercuryQ.net!";
	mail($recipient, $_SESSION['username']." is sending you a message at mercuryq.net!", $message);
	header("Location: /index.php");
}
?>
