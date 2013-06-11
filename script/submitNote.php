<?php
$gnupg_obj = gnupg_init();
$fingerprints = gnupg_import($gnupg_obj,file_get_contents('/var/web-sensitive/public.key'));
$fingerprint =  '14DDF27DC980D82C2700A35F786CEE1A8C4C1E26';
$note = $_POST['textarea'];
if(gnupg_addencryptkey($gnupg_obj,$fingerprint)){
$cyphertext = gnupg_encrypt($gnupg_obj, $note);
file_put_contents('/var/web-sensitive/notes'.time(), $cyphertext);
header("Location: /index.php");
}
else{
	header("Location: /index.php?content=notes.php");
}
?>
