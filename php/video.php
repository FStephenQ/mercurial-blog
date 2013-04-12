<?php
class video{
	function foo(){
		$music = glob("/home/music/playlist/*.mp3");
		$choice = basename($music[rand(0,count($music))]);
		echo '<h2 id="musictitle">'.$choice.'</h2>';
		echo '<audio id="music" preload="auto" tabindex="0" controls="">';
		echo '<source src="music/playlist/'.$choice.'">';
		echo '</audio>';
		echo '<button type="button" onclick="randomSong()">Random</button>';
		echo '</br>';
		echo '<select id="select1" onchange="change(this.value)" name=select" size="1">';
		echo '<option value="">Pick a Song!</option>';
		for($i = 0; $i<=count($music); $i++){
			echo '</br><option value="'.basename($music[$i]).'">'.basename($music[$i]).'</option>';
		}
		echo '</select>';
		echo '</div>';
if($_SESSION['username']=='fstephen'){
	foreach(glob("videos/*.webm") as $v){
		echo "<div id='content'>";
		echo "<video id='myvid' width='500' height='500' controls>";
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
