<?php
include("/var/www/basics.php");
print_head();
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
			echo "<form method='post' name='form2' action='/script/submitNote.php'>";
			echo "<input type='radio' name='method' value='internal' checked>Internal  <input type='radio' name='method' value='external'>External (Email)</br>";
			echo "Recipient: <input type='text' id='recipient' name='recipient' value='".$recip."' >      <a href='/php/members'>Recipient List</a></br>";
			echo "Message Text </br>";
			echo "<textarea name='textarea' rows='5' cols='40' required>";
			echo "</textarea>";
			echo "</br>Passphrase: <input type='password' name='password'>";
			echo "</br><input type='submit' value='Submit'>";
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
print_tail();
?>

		      		
