<?php
class notes{
	function foo(){
		if($_SESSION['loggedin'] != '1'){
			return;
		}
		else{
			echo "<form method='post' name='form2' action='script/submitNote.php'>";
			echo "To: <input type='text' name='recipient'></br>";
			echo "<input type='radio' name='method' value='internal'>Internal  <input type='radio' name='method' value='external'>External (Email)</br>";
			echo "<textarea name='textarea' rows='5' cols='40' required>";
			echo "</textarea>";
			echo "</br> Enter your encryption passphrase: <input type='password' name='password'>";
			echo "<input type='submit' value='Submit'>";
			echo"</form>";
			echo"</br></br</br>";
			echo "<ul>";
			foreach(glob("/var/web-sensitive/notes/".$_SESSION['username']."/*") as $v){
				echo "<li><a href='script/decrypt.php?target=".basename($v)."'>".basename($v)."</a></li>";
			}

		}
	}
}
?>

		      		
