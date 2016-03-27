<?php
session_start();
if(isset($_SESSION['status'])){
  if($_SESSION['status']!="logined"){
    header("Location:../login.php?act=nologin");
  }
}
if(empty($_SESSION['username'])){
  header("Location:../login.php?act=nologin");
}

require_once 'class.php';
$main=new main;
if(isset($_POST['act'])){
  if($_POST['act']=="newdir"){
    $main->mkdir();
  }
  if($_POST['act']=="dirlist"){
    $main->listdir();
  }
  if($_POST['act']=="parentdir"){
    $main->parentdir();
  }

}

 ?>
