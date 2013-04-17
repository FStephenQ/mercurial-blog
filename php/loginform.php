<?php
class loginform{
	function foo(){

		if($_SESSION['numtries'] >= 3){
			echo "You have exceeded your login tries. Please come back later";
		}
		else{
			echo $_SESSION['flash_error'];
			$_SESSION['flash_error'] = null;
echo '<form method="post" name="form1" action="script/login.php">';
echo '<input type="text" name="username" /></br>';
echo '<input type="password"  name="password" />';
echo '<input type="submit" value="Sign in" />';
echo '</br><a href="index.php?content=register.php">Register</a>';
		}
	}
}
?>
