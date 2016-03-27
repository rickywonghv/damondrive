<?php
session_start();
if(isset($_SESSION['status'])){
  if($_SESSION['status']!="logined"){
    header("Location:login.php?act=nologin");
  }
}
if(empty($_SESSION['username'])){
  header("Location:login.php?act=nologin");
}


require_once 'class.php';
$main=new main;
$result=$main->download();
decrypt($result['hash'],$result['realname'],$result['size']);

function decrypt($filename,$realname,$filesize){
  $passphrase = 'My secret';
  $iv = md5("\x1B\x3C\x58".$passphrase, true).md5("\x1B\x3C\x58".$passphrase, true);
  $key = substr(md5("\x2D\xFC\xD8".$passphrase, true).md5("\x2D\xFC\xD9".$passphrase, true), 0, 25);
  $opts = array('iv' => $iv, 'key' => $key);
  $fp = fopen('../files/'.$filename.'.data', 'rb');
  stream_filter_append($fp, 'mdecrypt.rijndael-256', STREAM_FILTER_READ, $opts);

  header('Content-Type: application/octet-stream');
  header('Content-Transfer-Encoding: binary');
  header('Content-Description: File Transfer');
  header('Content-Disposition: attachment; filename="'.$realname.'"');
  $blocksize = mcrypt_get_block_size(MCRYPT_RIJNDAEL_256, 'cbc');
  echo @substr(stream_get_contents($fp), 0, -($blocksize - ($filesize % $blocksize)));
}

 ?>
