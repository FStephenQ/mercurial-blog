<?php
include("/var/www/basics.php");
print_head();
echo "<div id='content'>";
$H = posts_array();
echo "<h2> This is the archive of all my blog posts</h2>";
echo"<ul>";
foreach($H as $P){
	if(!is_dir($P)){
		$F = strip_tags(fgets(fopen("$P", "r")));
		echo "<li> <a href='$P'> $F </a> </li>";
	}
}
echo "</div>";
print_tail();
?>
