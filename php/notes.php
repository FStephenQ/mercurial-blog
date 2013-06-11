<?php
class notes{
	function foo(){
		if($_SESSION['username'] != 'fstephen'){
			return;
		}
		else{
			echo "<form method='post' name='form2' action='script/submitNote.php'>";
			echo "<textarea name='textarea' rows='5' cols='40' required>";
			echo "</textarea>";
			echo "<input type='submit' value='Submit'>";
			echo"</form>";
		}
	}
}


		      		
