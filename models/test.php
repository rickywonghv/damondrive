<?php
// The password
decrypt("364815734","allendisk-master.zip",613808);

function decrypt($filename,$realname,$filesize){
  $passphrase = 'My secret';
  $iv = md5("\x1B\x3C\x58".$passphrase, true).md5("\x1B\x3C\x58".$passphrase, true);
  $key = substr(md5("\x2D\xFC\xD8".$passphrase, true).md5("\x2D\xFC\xD9".$passphrase, true), 0, 24);
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
