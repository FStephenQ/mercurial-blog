<?php
include("/var/www/basics.php");
print_head(true);
echo "<div id='content'>";
		if($_SESSION['numtries'] >= 3){
			echo "You have exceeded your login tries. Please come back later";
		}
		else{
			echo $_SESSION['flash_error'];
			$_SESSION['flash_error'] = null;
echo '<form method="post" id="form1" name="form1" action="/script/login.php">';
echo '<input type="text" name="username" /></br>';
echo '<input id="password" type="password"  name="password" />';
echo '<button type="button" onclick="sub()">Sign In</button>';
echo '</br><a href="/php/register.php">Register</a>';
		}
echo "</div>";
echo "<script type='text/javascript'>
	function sub(){
		var ajax = getRequest();
		var pas = document.getElementById('password').value;
	var pub = new getPublicKey(".json_encode(file_get_contents("/var/web-sensitive/main.pub")).");
		document.getElementById('password').value='';
		var cipher = doEncrypt(pub.keyid, 0, pub.pkey.replace(/\\n/g,''), pas);
		ajax.open('POST','/script/addSes.php',true);
		ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		ajax.send('passphrase='+encodeURIComponent(cipher));
		ajax.onreadystatechange = function(){
			if(ajax.readyState === 4){
	document.getElementById('form1').submit();
	}
}
}
</script>";
print_tail();
?>
