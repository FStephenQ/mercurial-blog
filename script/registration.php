<?php
$username = sqlite_escape_string($_POST['username']);
$password = $_POST['password'];
$email = sqlite_escape_string($_POST['email']);
$code = sha1($_POST['secretCode']);
if($code == file_get_contents("/var/web-sensitive/code")){
	$dbhandle = sqlite_open('/var/web-sensitive/db/php.db',0777,$error);
	$check = "SELECT username FROM user WHERE username='".$username."';";
	$result1 = sqlite_query($dbhandle, $check);
	if($result1 == $username){
		$_SESSION['flash_error'] = "Username already taken";
		header("Location:/index.php?content=register.php");
	}
	else{
$query = "INSERT INTO \"user\" VALUES('".$username."','".sha1($password)."','".$email."')";
$result = sqlite_query($dbhandle, $query);
$batch ="Key-Type: RSA
	Key-Length: 2048
	Subkey-Type:RSA
	Subkey-Length: 2048
	Name-Real:".$username."
	Name-Email: ".$email."
	Expire-Date: 0
	Passphrase:".$password."
	%pubring /var/web-sensitive/keys/".$username.".pub
	%secring /var/web-sensitive/keys/".$username.".sec
	%commit
	%echo Done
		";
fwrite(fopen("/var/web-sensitive/batch".$username,"w"), $batch);
exec("export HOME='/tmp';gpg --batch --gen-keys /var/web-sensitive/batch".$username);
exec("rm /var/web-sensitive/batch".$username);
exec("mkdir /var/web-sensitive/notes/".$username);
$_SESSION['flash_error']= 'Thank You for registering';
header("Location: /index.php?content=loginform.php");
	}
}
else{
	$_SESSION['flash_error'] = "Incorrect Code.";
	header("Location: https://mercuryq.net/index.php?content=register.php");
	$_SESSION['numtries'] +=1;
}

			
?>
