<?php
class blog{
function foo(){
echo "<a name='top' style='color: black; text-align: center;'><h2>The Mercurial Blog</h2></a>";
echo "</div></br>";
$archive = new archive();
$posts = $archive->posts_array();
$num = 0;
foreach($posts as $p){
	echo '<div id="content"><a name='.basename($p).' style="color: black; size: 18px;"></a>';
	echo nl2br(file_get_contents($p));
	echo '<hr width="80%" size="5">';
	if($num != 0){
		echo "<a href=index.php#".$last.">Previous</a>";
	}
	else{
		echo 'Previous';
	}
	echo "<span style= 'margin: 0px 0px 0px 100px;'><a href=#top>Top</a></span>";
	echo "<apan style='margin: 0px 0px 0px 100px;'><a href=index.php?content=".basename($p).">PermaLink</a></span>";
	echo '</div></br>';
	$num++;
	$last = basename($p);
}
}
}
?>
