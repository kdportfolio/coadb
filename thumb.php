<?php
$filename = md5(rand(00000,99999)).'.png';
$base64 = str_replace('data:image/png;base64,', '', $_POST['data']);
file_put_contents('thumbs/'.$filename, base64_decode($base64));
//echo 'https://coadb.com/lookalike/thumbs/'.$filename;
echo $filename;
?>