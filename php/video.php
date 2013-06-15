<?php
include("/var/www/basics.php");
print_head();
echo "<div id='content'>";
		//$dbhandle = sqlite_open('/var/web-sensitive/db/php.db', 0666, $error);
		//
//$query = 'SELECT username,password_sha1 FROM user';
//$result = sqlite_query($dbhandle, $query);
//while($row = sqlite_fetch_array($result, SQLITE_ASSOC)){
	$music = glob("/home/music/playlist/*.mp3");

		echo '<h2 id="musictitle"></h2>';
		echo '<audio id="music" preload="auto" tabindex="0" controls="" onended="randomSong()" onload="randomSong()">';
		echo '</audio>';
		echo '</br><button type="button" onclick="randomSong()">Random</button>';
		echo '   <a href="#" id="downloadLink" class="onlyfstephen">Download</a>';
		echo '    <button id="playlistButton" type="button" onclick="addPlaylist()" class="onlyfstephen"> Add to playlist!</button></br>';
		echo '<select id="select1" onchange="change(this.value)"  size="1">';
		echo '<option value="">Pick a Song!</option>';
		for($i = 0; $i<=count($music); $i++){
			$name = ''.substr(basename($music[$i]),0,-4);
			echo '</br><option value="'.$name.'">'.$name.'</option>';
		}
		echo '</select>';
		echo '</div>';
if($_SESSION['loggedin']=='1'){
		echo "<div id='content'>";
		echo "<center><video id='video' width='500' height='500' controls></video>";
		echo "<select id='select2' onchange='changeVideo(this.value)'>";
		echo '<option value="">Pick A Video!</option>';
		foreach(glob("/var/www/videos/*.webm") as $v){
			echo '<option value="'.basename($v).'">'.strstr(basename($v),'.',true).'</option>';
		}
		echo "</select></center>";
		echo "</div>";
}
echo "<script type='text/javascript'>
	function addPlaylist(){
		var ajax = getRequest();
		var song = document.getElementById('musictitle').innerHTML;
		ajax.onreadystatechange = function(){
			if(ajax.readystate == 4){
				}
		}
		ajax.open('GET','/script/playlist.php?song='+song, true);
		ajax.send(null);
		document.getElementById('playlistButton').style.visibility='hidden';
		}
</script>
	";
print_tail();
?>
