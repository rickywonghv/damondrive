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

  if(isset($_FILES["files"]["name"])&&$_FILES['files']['size']>0){
    $parent=$_POST['parentdirupload'];
    $passphrase = 'My secret';
    $filename = basename($_FILES["files"]["name"]);
    $filehash=rand();
    echo encrypt($passphrase,$filename,$filehash);
    require_once 'class.php';
    $main=new main;
    $main->uploadint($filename,$filehash,$parent);
  }else{
    echo "Please select something to upload.";
  }


        function encrypt($passphrase,$filename,$filehash){
          $iv = md5("\x1B\x3C\x58".$passphrase, true).md5("\x1B\x3C\x58".$passphrase, true);
          $key = substr(md5("\x2D\xFC\xD8".$passphrase, true).md5("\x2D\xFC\xD9".$passphrase, true), 0, 25);
          $opts = array('iv' => $iv, 'key' => $key);
          $fp = fopen($_FILES['files']['tmp_name'], 'rb');
          $dest = fopen('../files/'.$filehash.'.data', 'wb');
          stream_filter_append($dest, 'mcrypt.rijndael-256', STREAM_FILTER_WRITE, $opts);
          stream_copy_to_stream($fp, $dest);
          fclose($fp);
          fclose($dest);
          $mkid = sha1(mt_rand().uniqid());
          //$result = 'success';
          return 'File '.$filename.' has been uploaded.';
        }
?>
