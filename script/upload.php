<?php
if($_SESSION['username']=='fstephen'){
$uploaddir = "./blog/";
$uploadfile = $uploaddir.basename($_FILES['upload']['name']);

move_uploaded_file($_FILES['upload']['tmp_name'], $uploadfile);
}
?>
	
