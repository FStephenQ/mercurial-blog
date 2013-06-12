<?php
$username = str_replace(array(' ',';',"'",'"','(',')',','),"",$_POST['username']);
$password = sha1($_POST['password']);
$email = $_POST('email');
$code = sha1($_POST('secretCode'));
if($code == fread(fopen("/var/web-sensitive/code","r"))){
$dbhandle = sqlite_open('/var/web-sensitive/db/php.db', 0666, $error);
$query = 'INSERT INTO user VALUES("'.$username.'","'.$password.'");';
			$_SESSION['flash_error']= 'Thank You for registering';
header("Location: /index.php?content=loginform.php");
die();
			
}
	$_SESSION['flash_error'] = "Incorrect Code.";
	header("Location: https://mercuryq.net/index.php?content=register.php");
	$_SESSION['numtries'] +=1;
?>
