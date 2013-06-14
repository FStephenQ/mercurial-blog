<?php

$keydir = "/var/web-sensitive/keys/";
$notedir ="/var/web-sensitive/notes";
$username = "";
$sender = "";
if(isset($_GET['sender'])){
	$keydir ="/var/web-sensitive/keys/external/";
	$notedir = "/var/web-sensitive/notes/external/";
	$username = $_GET['sender'];
	$sender = "&sender=".$username;
}
else{
	$username = $_SESSION['username'];
	$notedir = "/var/web-sensitive/notes/".$username."/";
}
	$target = $_GET['target'];
	if($_POST['passphrase'] == NULL){
		echo "<form method='post' name='form3' action='decrypt.php?target=".$target.$sender."'>";
		echo "<input type='password' name='passphrase' />";
		echo "<input type='submit' value='Submit' />";
		echo "</form>";
	}
	else{
		putenv("GNUPGHOME=/tmp");
		$gnupg_obj = gnupg_init();
		$fingerprints = gnupg_import($gnupg_obj,file_get_contents($keydir.$username.".sec"));
		$fingerprint = $fingerprints['fingerprint'];
		$passphrase = $_POST['passphrase'];
		if(gnupg_adddecryptkey($gnupg_obj,$fingerprint,$passphrase)){
			$_POST['passphrase'] = NULL;
			$passphrase = NULL;
			$plaintext = "";
	$info = gnupg_decryptverify($gnupg_obj,file_get_contents($notedir.$target), $plaintext);
			echo $plaintext;
			echo "</br></br></br>";
			$sender= substr($target, 1, -10); #Need to implement actual key verification.
			echo "Sent by: ".$sender;
			echo "</br></br></br>";
			if(substr($target,0,1) == "u"){
			exec("mv ".$notedir.$target." ".$notedir."r".substr($target,1));
			}	
			echo "<a href='/index.php'>Home</a></br>
				<a href='/php/notes.php?return=".$sender."'>Reply</a>";
			gnupg_cleardecryptkeys($gnupg_obj);
		}
		else{
			header("Location: /index.php");
		}
	}

?>
