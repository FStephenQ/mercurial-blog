<?php
class archive{
function posts_array(){
$dir =  glob("/var/www/blogs/*");
uasort($dir, array("archive","newest"));
return $dir;
}

function foo(){
$H = $this->posts_array();
echo "<h2> This is the archive of all my blog posts</h2>";
echo"<ul>";
foreach($H as $P){
	if(!is_dir($P)){
		$F = strip_tags(fgets(fopen("$P", "r")));
		echo "<li> <a href='$P'> $F </a> </li>";
	}
}
}
static function newest($a, $b){
	return filemtime($b)-filemtime($a);
}
}
?>
