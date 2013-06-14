<?php
include("/var/www/basics.php");
print_head();
echo "<div id='content'>";
		if($_SESSION['numtries'] >= 3){
			echo "You have exceeded your login tries. Please come back later";
		}
		else{
			echo $_SESSION['flash_error'];
			$_SESSION['flash_error'] = null;
echo '<form method="post" name="form5" action="/script/registration.php">';
echo 'Username:<input type="text" name="username" /></br>';
echo 'Password:<input type="password"  name="password" />';
echo '</br>Email:   <input type="text" name="email" />';
echo '</br>The Code:<input type="password" name="secretCode" />';
echo '</br><input type="submit" value="Submit" />';
		}
echo "</div>";
print_tail();
?>
