<?php
$recipient = $_POST['recipient'];
$pass = $_POST['password'];
$method = $_POST['method'];
$note = $_POST['textarea'];
if($method == "internal"){
		$filename = fopen('/var/web-sensitive/notes/'.$recipient.'/u'.$_SESSION['username'].time(), "w");
		fwrite($filename, $note);
		fclose($filename);
		header("Location: /php/notes.php");
}
else{
	$uname = rand(0,9999999);
	$batch ="Key-Type: RSA
		Key-Length: 2048
		Subkey-Type:RSA
		Subkey-Length: 2048
		Name-Real:".$uname."
		Name-Email: ".$recipient."
		Expire-Date: 0
		Passphrase:".$pass."
		%pubring /var/web-sensitive/keys/external/".$uname.".pub
		%secring /var/web-sensitive/keys/external/".$uname.".sec
		%commit
		%echo Done";
	exec('export HOME="/tmp"; echo "'.$batch.'"| gpg --batch --gen-key');
	putenv("GNUPGHOME=/tmp");
	$gnupg_ob = gnupg_init();
	gnupg_setarmor($gnupg_ob,1);
	$file = file_get_contents('/var/web-sensitive/keys/external/'.$uname.'.pub');
	$fingerprints = gnupg_import($gnupg_ob,$file);
	$fingerprint = $fingerprints['fingerprint'];
	if(gnupg_addencryptkey($gnupg_ob,$fingerprint)){
	$cyphertext = gnupg_encrypt($gnupg_ob, $note);
	$location = "u".$_SESSION['username'].time();
	$filename = fopen('/var/web-sensitive/notes/external/'.$location,"w");
	fwrite($filename, $cyphertext);
	fclose($filename);
	$link = "https://www.mercuryq.net/script/decrypt.php?target=".$location."&sender=".$uname;
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
	else{
		header("Location: /php/notes.php");
	}
}
?>
