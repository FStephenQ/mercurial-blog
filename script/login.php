<?php
$username = $_POST['username'];
$password = sha1($_POST['password']);
$dbhandle = sqlite_open('/var/web-sensitive/db/php.db', 0666, $error);

$query = 'SELECT username,password_sha1 FROM user';
$result = sqlite_query($dbhandle, $query);
$_SESSION['loggedin']='false';
while($row = sqlite_fetch_array($result, SQLITE_ASSOC)){
	if($row['username']==$username){
		if($row['password_sha1']==$password){
			#$_SESSION['flash_error']= 'whut';
			$_SESSION['loggedin'] = 'TRUE'; 
			$_SESSION['username'] = $username;
			header("Location: /index.php");
			}}}
if($_SESSION['loggedin']== 'false'){
	$_SESSION['flash_error'] = $error;
		#"Incorrect Username or Password";
	header("Location: https://mercuryq.net/index.php?content=loginform.php");
	$_SESSION['numtries'] += 1;
}
?>
