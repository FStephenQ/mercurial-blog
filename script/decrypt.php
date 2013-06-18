<?php
include("/var/www/basics.php");
$keydir = "/var/web-sensitive/keys/";
$notedir ="/var/web-sensitive/notes";
$username = "";
$sender = "";
if(isset($_GET['sender'])){
	$keydir ="/var/web-sensitive/keys/external/";
	$notedir = "/var/web-sensitive/notes/external/";
	$username = $_GET['sender'];
	$sender = "&sender=".$username;
}
else{
	$username = $_SESSION['username'];
	$notedir = "/var/web-sensitive/notes/".$username."/";
}
	$target = $_GET['target'];
if($_SESSION['passphrase'] == NULL){
	print_head(true);
		echo "<div id='content'><form method='post' name='form3' id='form3' action='decrypt.php?target=".$target.$sender."'>";
		echo "<input type='password' name='passphrase' id='passphrase'/>";
		echo "<button type='button' onclick='decrypt()' >Submit</button></br>
		<input type='checkbox' id='in_brws' style='display:none;'/></div>";
		echo "<script type='text/javascript'>
			function decrypt(){
				if(!document.getElementById('in_brws').checked===true){
			var ajax = getRequest();
		var pas = document.getElementById('passphrase').value;
	var pub = new getPublicKey(".json_encode(file_get_contents("/var/web-sensitive/main.pub")).");
		document.getElementById('passphrase').value='';
		var cipher = doEncrypt(pub.keyid, 0, pub.pkey.replace(/\\n/g,''), pas);
		ajax.open('POST','/script/addSes.php',true);
		ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		ajax.send('passphrase='+encodeURIComponent(cipher));
		ajax.onreadystatechange = function(){
			if(ajax.readyState === 4){
	document.getElementById('form3').submit();
	}
}				
				}
				else{
					var passphrase = document.getElementById('passphrase').value;
					if(passphrase === ''){
						alert('Please enter a passphrase');
					}
else{
	var a = [];
	var b = [];
	var c = [];
	var d = [];
	doDecrypt(a,b,c,d,key,passphrase);
	alert('almost');
	document.getElementById('content').innerHTML = doDecrypt(a,b,c,d,message,passphrase);
}
}
}
</script>

	";
	print_tail();
	}
	else{
		putenv("GNUPGHOME=/tmp");
		$gnupg_obj = gnupg_init();
		gnupg_setarmor($gnupg_obj, 1);
		$passphrase = $_SESSION['passphrase'];
		$fingerprints = gnupg_import($gnupg_obj, file_get_contents("/var/web-sensitive/main.sec"));
		$pa = file_get_contents("/var/web-sensitive/secret");
		gnupg_adddecryptkey($gnupg_obj, $fingerprints['fingerprint'], $pa);
		$passphrase = gnupg_decrypt($gnupg_obj, $passphrase);
		gnupg_cleardecryptkeys($gnupg_obj);
		$fingerprints = gnupg_import($gnupg_obj,file_get_contents($keydir.$username.".sec"));
		$fingerprint = $fingerprints['fingerprint'];
		if(gnupg_adddecryptkey($gnupg_obj,$fingerprint,$passphrase)){
			$passphrase = NULL;
			$plaintext = "";
			$plaintext = gnupg_decrypt($gnupg_obj,file_get_contents($notedir.$target));
			print_head();
			echo "<div id='content'>";
			echo $plaintext;
			echo "</br></br></br>";
			$sender= substr($target, 1, -10); #Need to implement actual key verification.
			echo "Sent by: ".$sender;
			echo "</br></br></br>";
			if(substr($target,0,1) == "u"){
				exec("mv ".$notedir.$target." ".$notedir."r".substr($target,1));
			}	
			echo "<a href='/index.php'>Home</a></br>
				<a href='/php/notes.php?return=".$sender."'>Reply</a></div>";
			gnupg_cleardecryptkeys($gnupg_obj);
			$_SESSION['passphrase']= NULL;
			print_tail();
		}
		else{
			header("Location: /index.php");
		}
	}

?>
