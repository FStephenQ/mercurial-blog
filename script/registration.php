<?php
$usernames = preg_split("/[\s;|>]+/",sqlite_escape_string($_POST['username']));
$username = $usernames[0];
$password = $_SESSION['passphrase'];
putenv("GNUPGHOME=/tmp");
$gpg_obj = gnupg_init();
gnupg_setarmor($gpg_obj, 1);
$fingerprint = gnupg_import($gpg_obj, file_get_contents("/var/web-sensitive/main.sec"));
$pa = file_get_contents('/var/web-sensitive/secret');
gnupg_adddecryptkey($gpg_obj, $fingerprint['fingerprint'], $pa);
$password1 = gnupg_decrypt($gpg_obj, $password);
$email = sqlite_escape_string($_POST['email']);
$code = sha1($_POST['secretCode']);
if($code == file_get_contents("/var/web-sensitive/code")){
	$dbhandle = sqlite_open('/var/web-sensitive/db/php.db',0777,$error);
	$check = "SELECT username FROM user WHERE username='".$username."';";
	$result1 = sqlite_query($dbhandle, $check);
	if($result1 == $username){
		$_SESSION['flash_error'] = "Username already taken";
		header("Location:/php/register.php");
	}
	else{
$query = "INSERT INTO \"user\" VALUES('".$username."','".sha1($password)."','".$email."')";
$result = sqlite_query($dbhandle, $query);
$batch ='"Key-Type: RSA
	Key-Length: 2048
	Subkey-Type:RSA
	Subkey-Length: 2048
	Name-Real:'.$username.'
	Name-Email: '.$email.'
	Expire-Date: 0
	Passphrase:'.$password.'
	%pubring /var/web-sensitive/keys/'.$username.'.pub
	%secring /var/web-sensitive/keys/'.$username.'.sec
	%commit
	%echo Done"'
		;
exec("export HOME='/tmp'; echo ".$batch."| gpg --batch --gen-key");
exec("mkdir /var/web-sensitive/notes/".$username);
$_SESSION['flash_error']= 'Thank You for registering';
header("Location: /php/loginform.php");
	}
}
else{
	$_SESSION['flash_error'] = "Incorrect Code.";
	header("Location: https://mercuryq.net/php/register.php");
	$_SESSION['numtries'] +=1;
}
?>
