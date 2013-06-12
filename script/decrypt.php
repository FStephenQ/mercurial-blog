<?php
if($_SESSION['username'] != 'fstephen'){
	header("Location: /index.php");
}
else{
	$target = $_GET['target'];
	if($_POST['passphrase'] == NULL){
		echo "<form method='post' name='form3' action='decrypt.php?target=".$target."'>";
		echo "<input type='password' name='passphrase' />";
		echo "<input type='submit' value='Submit' />";
		echo "</form>";
	}
	else{
		putenv("GNUPGHOME=/tmp");
		$gnupg_obj = gnupg_init();
		$fingerprints = gnupg_import($gnupg_obj,file_get_contents("/var/web-sensitive/private.key"));
		$fingerprint = $fingerprints['fingerprint'];
		$passphrase = $_POST['passphrase'];
		if(gnupg_adddecryptkey($gnupg_obj,$fingerprint,$passphrase)){
			$_POST['passphrase'] = NULL;
			$passphrase = NULL;
			echo gnupg_decrypt($gnupg_obj,file_get_contents("/var/web-sensitive/notes/".$target));
			echo "</br></br</br>";
			echo "<a href='https://www.mercuryq.net/index.php'>Home</a>";
			gnupg_cleardecryptkeys($gnupg_obj);
		}
		else{
			header("Location: /index.php");
		}
	}
}

?>
