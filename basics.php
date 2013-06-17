<?php
function print_head(){
	
$head = "<html>
	<head>
		<meta content='text/html; charset=utf-8' http-equiv='Content-Type'/>
		<meta content='utf-8' http-equiv='encoding'>
		<title>MercuryQ</title>
		<link rel='stylesheet' type='text/css' href='/css/menu.css' />
		<script src='/js/change.js'></script>
		<script src='/js/rsa.js'></script>
		<script src='/js/aes-enc.js'></script>
		<script src='/js/base64.js'></script>
		<script src='/js/PGpubkey.js'></script>
		<script src='/js/mouse.js'></script>
<script src='/js/PGencode.js'></script>
<script src='/js/PGdecode.js'></script>
<script src='/js/cast5.js'></script>
		<script src='/js/sha1.js'></script>";
$body = '</head><body>

<div id="header" class="header">
<h1 id=title>F. Stephen Quaratiello\'s WebPage</h1>
</div>
</br>';

echo $head;
#	if(isset($scripts)){
#	foreach($scripts as $v){
#		eval($v);
#	}
#	}
echo $body;
echo file_get_contents("/var/www/data/menu");
}

function print_tail(){
	if($_SESSION['loggedin']=='1'){

	echo "<script type=text/javascript>";
	echo "replaceStyle('.hideAuth','none');
	replaceStyle('.onlyfstephen','inline');
	
	</script>";
	}	
$tail = "
	</body>
	</html>";

#if(isset($scripts)){
#	foreach($scripts as $v){
#		eval($v);
#	}
#}
echo $tail;
}

function posts_array(){
$dir =  glob("/var/www/blogs/*");
return $dir;
}

?>
