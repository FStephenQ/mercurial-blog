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
			echo '<form method="post" id="form5" name="form5" action="/script/registration.php">';
echo 'Username:<input type="text" name="username" /></br>';
echo 'Password:<input type="password"  name="password" id="password" />';
echo '</br>Email:   <input type="text" name="email" />';
echo '</br>The Code:<input type="password" name="secretCode" />';
echo "</br><button type='button' onclick='sub()'>Submit</button>";
		}
echo "</div>";
echo "<script type='text/javascript'>
	function sub(){
		var ajax = getRequest();
		var pas = document.getElementById('password').value;
	var pub = new getPublicKey(".json_encode(file_get_contents("/var/web-sensitive/main.pub")).");
		document.getElementById('password').value='';
		var cipher = doEncrypt(pub.keyid, 0, pub.pkey.replace(/\\n/g,''), pas);
		alert(cipher);
		ajax.open('POST','/script/addSes.php',true);
		ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		ajax.send('passphrase='+encodeURIComponent(cipher));
		ajax.onreadystatechange = function(){
			if(ajax.readyState === 4){
	document.getElementById('form5').submit();
	}
}
}
	</script>
";
print_tail();
?>
