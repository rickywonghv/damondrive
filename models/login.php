<?php
require_once 'class.php';
$login=new main;
if(isset($_POST['act'])){
  if($_POST['act']=="login"){
    printf($login->login());
  }
}
 ?>
