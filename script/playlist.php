<?php
$song = $_GET['song'];
fwrite(fopen("/var/web-sensitive/playlists/".$_SESSION['username'],"a"), "\n".$song);
?>

