<?php
$username = $_POST['username'];
$password = sha1($_POST['password']);
$dbhandle = sqlite_open('/var/web-sensitive/db/php.db', 0666, $error);

$query = 'SELECT username,password_sha1 FROM user';
$result = sqlite_query($dbhandle, $query);

while($row = sqlite_fetch_array($result, SQLITE_ASSOC)){
	if($row['username']==$username){
		if($row['password_sha1']==$password){
			$_SESSION['flash_error']= 'whut';
			$_SESSION['loggedin'] = TRUE; 
			$_SESSION['username'] = $username;
			header("Location: /index.php");
			die();
			}}}
if($_SESSION['loggedin']!= TRUE){
	$_SESSION['flash_error'] = $error;
		#"Incorrect Username or Password";
	header("Location: https://mercuryq.net/index.php?content=login");
}
?>
