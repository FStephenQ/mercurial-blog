<?php
$username = $_POST['username'];
$password = $_SESSION['passphrase'];
putenv("GNUPGHOME=/tmp");
$gpg_obj = gnupg_init();
gnupg_setarmor($gpg_obj, 1);
$fingerprint = gnupg_import($gpg_obj, file_get_contents("/var/web-sensitive/main.sec"));
$pa = file_get_contents('/var/web-sensitive/secret');
gnupg_adddecryptkey($gpg_obj, $fingerprint['fingerprint'], $pa);
$password = sha1(gnupg_decrypt($gpg_obj, $password));
$dbhandle = sqlite_open('/var/web-sensitive/db/php.db', 0666, $error);
$query = 'SELECT username,password_sha1 FROM user';
$result = sqlite_query($dbhandle, $query);
$_SESSION['loggedin']='false';
while($row = sqlite_fetch_array($result, SQLITE_ASSOC)){
	if($row['username']==$username){
		if($row['password_sha1']==$password){
			#$_SESSION['flash_error']= 'whut';
			$_SESSION['loggedin'] = '1'; 
			$_SESSION['username'] = $username;
			$_SESSION['passphrase'] = NULL;
			header("Location: /index.php");
			}}}
if($_SESSION['loggedin']== 'false'){
	$_SESSION['flash_error'] = $error;
		#"Incorrect Username or Password";
	header("Location: https://mercuryq.net/php/loginform.php");
	$_SESSION['numtries'] += 1;
}
?>
