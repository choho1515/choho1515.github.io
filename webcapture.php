<?php

function uuid() {
  return sprintf('%08x', mt_rand(0, 0xffffffff));
}

function resize_image ($file, $newfile, $w, $h) {
   list($width, $height) = getimagesize($file);
   $src = imagecreatefromstring(file_get_contents($file));
   $dst = imagecreatetruecolor($w, $h);
   imagecopyresampled($dst, $src, 0, 0, 0, 0, $w, $h, $width, $height);
   imagejpeg($dst, $newfile);
}

$key = '7d0d6208d7d290df42830269fcfbd39e';
$url = $_POST["url"];
$delay = $_POST["delay"];
$wh = $_POST["wh"];

if ($url) {
  $url2 = "http://api.screenshotlayer.com/api/capture?access_key=".$key."&url=".$url;
  if ($delay) $url2 = $url2."&delay=".$delay;
  $rand = uuid();
  $uppath = "./img/".$rand.".jpg";
  $ch = curl_init($url2);
  $fp = fopen($uppath, 'wb') or die("ERROR");
  curl_setopt($ch, CURLOPT_FILE, $fp);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_exec($ch);
  curl_close($ch);
  fclose($fp);
  if ($wh) {
    $wh = json_decode($wh);
    resize_image($uppath, $uppath, $wh[0], $wh[1]);
  }
  echo "http://choho0328.dothome.co.kr/img/".$rand.".jpg";
}
            

?>