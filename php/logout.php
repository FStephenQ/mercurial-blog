<?php
class logout{
function foo(){
session_destroy();?>
<script type=text/javascript>
document.getElementById('hideAuth').style.display = 'none';
document.getElementById('onlyfstephen').style.display = 'inline';
</script>
<?php
header("Location: /index.php");
}
}
?>
