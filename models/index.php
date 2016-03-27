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

if(isset($_GET['act'])){
  if($_GET['act']=="logout"){
    print_r($main->logout());
  }
}else{
  header("Location:../index.php");
}
if(isset($_POST['act'])){
  if($_POST['act']=="adduser"){
    print_r($main->adduser());
  }
}else{
  header("Location:../index.php");
}

 ?>
