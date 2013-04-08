<?php
class video{
	function foo(){
		echo '</div>';
if($_SESSION['username']=='fstephen'){
	foreach(glob("/home/music/videos/*.webm") as $v){
		echo "<div id='content'>";
		echo "<video id='myvid' width='320' height='250' controls>";
		echo "<source type='video/webm' src='".$v."'>";
		echo "</video>";
		echo "</div>";
	}
}
else{
	echo "404 Does Not Exist";
}
}
}
?>
