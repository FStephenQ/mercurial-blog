<?php
echo "<h1>MEMBERS</h1></br>";
echo "<h2>Click a name to send a message to that user</h2></br>";
foreach(glob("/var/web-sensitive/keys/*.pub") as $v){
	echo "<a href='/php/notes.php?return=".substr(basename($v),0,-4)."'>".substr(basename($v),0,-4)."</a></br>";
}
?>

