<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Stream downloader</title>
</head>
<body>
<?php

$video = $_GET['video'];
$info = pathinfo($video);
if(file_exists($video)){
    echo 'Dateiname: '. $info['filename'].
        '<br>Dateiformat: '.$info['extension'].
        '<br>Pfad: '.$info['dirname'].
        '<br>Dateigrösse: '.human_filesize(filesize($video));
    echo '<div class="videoContainer"><video width="100%" controls>
  <source src="'.$video.'" type="video/mp4">
  Your browser does not support the video tag.
</video></div>';
}else{
    echo 'Die gesuchte Datei wurde unter dem Pfad '.$video.' wurde nicht gefunden.';
}



/**
 * https://www.php.net/manual/de/function.filesize.php#106569
 *
 * @param $bytes
 * @param int $decimals
 * @return string
 */
function human_filesize($bytes, $decimals = 2) {
    $sz = 'BKMGTP';
    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%.{$decimals}f", $bytes / (1024 ** $factor)) . @$sz[$factor];
}
