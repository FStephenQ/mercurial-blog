<?php
foreach(glob('php/*') as $p){
	include($p);
}
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

<div id="content" >
<?php 
$ext = substr(strrchr($file,'.'),1);
if($ext == 'php'){
	$file = strstr($file,'.',true);
	$instance = new $file();
	$instance->foo();
}
elseif($ext == 'txt'){
	echo nl2br(file_get_contents('blogs/'.$file));
}
else{
	echo $_SESSION['flash_error'];
	$_SESSION['flash_error'] = null;
	echo file_get_contents('data/'.$file); 
}?>
</div>
 <?php
	if($_SESSION['loggedin']==true){
?>
	<script type=text/javascript>
	document.getElementById('hideAuth').style.display = 'none';
	document.getElementById('onlyfstephen').style.display = 'inline';
	</script>
<?php
	}	
?>
	</body>
</html>
