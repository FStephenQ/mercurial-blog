<?php
//Define global variables
$GLOBALS['sensitive-dir']= '/var/www-sensitive/';
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
		<title>F. Stephen Quaratiello</title>
		<link rel="stylesheet" type="text/css" href="css/menu.css" />
<meta charset="utf-8"/>

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
<script type=text/javascript src=js/cling.js />
 <?php //If there is a user logged in, hide the things they dont need, and display the ones that they do
	if($_SESSION['loggedin']==true){
		echo '<script type=text/javascript>';
		echo "document.getElementById('hideAuth').style.display = 'none';";
	echo "document.getElementById('only".$_SESSION['username']."').style.display = 'inline';";
	echo '</script>';
	}	
?>
	</body>
</html>
