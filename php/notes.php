<?php
include("/var/www/basics.php");
print_head(true);
echo "<div id='content'>";
echo $_SESSION['flash_error'];
		if($_SESSION['loggedin'] != '1'){
			return;
		}
		else{
			$recip = "";
			$inbox = true;
			if(isset($_GET['return'])){
				$recip = $_GET['return'];
				$inbox = false;
			}
			echo "<form  id='form2' method='post' name='form2' action='/script/submitNote.php'>";
			echo "<input  id='method' type='radio' name='method' value='internal' onclick='radioSwap()' checked>Internal  <input type='radio' id='method' name='method' value='external' onclick='radioSwap()'>External (Email)</br>";
			echo "Recipient: <input type='text' id='recipient' name='recipient' value='".$recip."' >      <a href='/php/members'>Recipient List</a></br>";
			echo "Message Text </br>";
			echo "<textarea id='textarea' name='textarea' rows='5' cols='40' required>";
			echo "</textarea>";
			echo "</br><span class='hidden' style='display:none;'>Passphrase: <input type='password' name='password'></span>";
			echo "</br><button type='button' onclick='encrypt()'>Submit</button>";
			echo "</form>";
			echo "</br></br</br>";
			echo "</div>";
			echo "<ul id='messages'>";
			if($inbox){
			foreach(glob("/var/web-sensitive/notes/".$_SESSION['username']."/*") as $v){
				$status ="unread";
				if(substr(basename($v),0,1) =="r"){
					$status = "read";
				}
				echo "<div id='content'><li>From <a href='/script/decrypt.php?target=".basename($v)."'>".substr(basename($v),1,-10)."</a></br>
					Sent: ".date('c',substr(basename($v),-10))." GMT</br>
					Status: ".$status."
					</li></div>";
			}
			}

		}
echo "<script type='text/javascript'>
	function encrypt(){
		var ajax = getRequest();
		var recip = document.getElementById('recipient').value;
		if(recip == '') alert('Please Enter a Recipient');
		else{
			var radios = document.getElementsByName('method');
				if(radios[1].checked){
					document.getElementById('form2').submit();
					}
		else{
		var message = document.getElementById('textarea').value+'\\r\\n';
		var key = '';
		ajax.onreadystatechange = function(){
			if(ajax.readyState === 4){
				key = ajax.responseText;
				var pub = new getPublicKey(key);
				document.getElementById('textarea').value= doEncrypt(pub.keyid, 0, pub.pkey.replace(/\\n/g,''), message);
				document.getElementById('form2').submit();
				}
		};
		ajax.open('GET','/script/getPubKey.php?name='+recip,true);
		ajax.send(null);
		}
}}
function radioSwap(){
	var radios = document.getElementsByName('method');
	if(radios[1].checked){
		replaceStyle('.hidden','inline');
		}
else{
	replaceStyle('.hidden','none');
	}
}
</script>";
print_tail();
?>

		      		
