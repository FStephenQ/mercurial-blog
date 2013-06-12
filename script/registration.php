<?php
$username = $_POST['username'];
$password = sha1($_POST['password']);
$email = $_POST['email'];
$code = sha1($_POST['secretCode']);
if($code == file_get_contents("/var/web-sensitive/code")){
$dbhandle = sqlite_open('/var/web-sensitive/db/php.db',0777,$error);
$query = "INSERT INTO \"user\" VALUES('".$username."','".$password."','".$email."')";
$result = sqlite_query($dbhandle, $query);
#$batch = make_batch($password);
#fwrite(fopen("/var/web-sensitive/batch","w"),$batch);
#exec("gpg --batch --gen-keys /var/web-sensitive/batch");
$_SESSION['flash_error']= 'Thank You for registering';
header("Location: /index.php?content=loginform.php");
}
else{
	$_SESSION['flash_error'] = "Incorrect Code.";
	header("Location: https://mercuryq.net/index.php?content=register.php");
	$_SESSION['numtries'] +=1;
}

	function make_batch(string $passphrase){
	$batch ="Key-Type: RSA
		Key-Length: 1024
		Name:testing
		Name-Email: test@test.com
		Expire-Date: 0
		Passphrase:".$passphrase."
		%pubring /var/web-sensitive/keys/test.pub
		%secring /var/web-sensitive/keys/test.sec
		%commit
		";
	return batch;
}		
			
?>
