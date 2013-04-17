<?php
class video{
	function foo(){
//$dbhandle = sqlite_open('/var/web-sensitive/db/php.db', 0666, $error);
//$query = 'SELECT username,password_sha1 FROM user';
//$result = sqlite_query($dbhandle, $query);
//while($row = sqlite_fetch_array($result, SQLITE_ASSOC)){
	$music = glob("/home/music/playlist/*.mp3");

		echo '<h2 id="musictitle"></h2>';
		echo '<audio id="music" preload="auto" tabindex="0" controls="" onended="randomSong()" onload="randomSong()">';
		echo '</audio>';
		echo '</br><button type="button" onclick="randomSong()">Random</button>';
		echo '   <a href="#" id="downloadLink" class="onlyfstephen">Download</a></br>';
		echo '<select id="select1" onchange="change(this.value)"  size="1">';
		echo '<option value="">Pick a Song!</option>';
		for($i = 0; $i<=count($music); $i++){
			$name = substr(basename($music[$i]),0,-4);
			echo '</br><option value="'.$name.'">'.$name.'</option>';
		}
		echo '</select>';
		echo '</div>';
if($_SESSION['username']=='fstephen'){
		echo "<div id='content'>";
		echo "<center><video id='video' width='500' height='500' controls></video>";
		echo "<select id='select2' onchange='changeVideo(this.value)'>";
		echo '<option value="">Pick A Video!</option>';
		foreach(glob("videos/*.webm") as $v){
			echo '<option value="'.basename($v).'">'.strstr(basename($v),'.',true).'</option>';
		}
		echo "</select></center>";
		echo "</div>";
}
}
}
?>
