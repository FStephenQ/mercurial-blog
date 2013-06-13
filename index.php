<?php
//Define global variables
$GLOBALS['sensitive-dir']= '/var/web-sensitive/';
$GLOBALS['default-display']= 'blog.php';
$GLOBALS['default-method'] = 'foo';

//import php files to be run
foreach(glob('php/*') as $p){ //yes this is stupid
	include($p);
}

//set the content for this page.
$file = $_GET['content'];
	if( $file == null){
		$file = 'blog.php';
	}	
?>
<html>
	<head>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
		<meta content="utf-8" http-equiv="encoding">
		<title>F. Stephen Quaratiello</title>
		<link rel="stylesheet" type="text/css" href="css/menu.css" />
<script src="js/change.js"></script>
	</head>
<body>

<div id="header">
<h1 id=title>F. Stephen Quaratiello's WebPage</h1>
<?php echo file_get_contents("data/menu"); ?>
</div>
</br>
<div id="content" >
<?php 
$ext = substr(strrchr($file,'.'),1);
if($ext == 'php'){
	$file = strstr($file,'.',true);
	$instance = new $file();
	$instance->$GLOBALS['default-method']();
}
elseif($ext == 'txt'){
	echo nl2br(file_get_contents('blogs/'.$file));
}
else{
	echo $_SESSION['flash_error'];
	$_SESSION['flash_error'] = null;
	$outputfile = nl2br(file_get_contents('data/'.$file));
	if($outputfile == null){
		echo "<h2>ERROR: FILE NOT FOUND</h2>";
	}
	else{
		echo $outputfile; 
	}
}?>
</div>
<a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/deed.en_US"><img alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by-sa/3.0/80x15.png" /></a><br /><span xmlns:dct="http://purl.org/dc/terms/" property="dct:title">MercuryQ</span> by <a xmlns:cc="http://creativecommons.org/ns#" href="mercuryq.net" property="cc:attributionName" rel="cc:attributionURL">F. Stephen Quaratiello</a> is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/deed.en_US">Creative Commons Attribution-ShareAlike 3.0 Unported License</a>.
 <script type=text/javascript>
 <?php //If there is a user logged in, hide the things they dont need, and display the ones that they do
 if($_SESSION['loggedin']=='1'){
?>

	replaceStyle(".hideAuth","none");
	replaceStyle(".onlyfstephen","inline");
	
	</script>;
<?php
	}	
?>
<script type=text/javascript src=js/cling.js />
	</body>
</html>
