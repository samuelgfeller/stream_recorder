<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/form.css">
    <link rel="stylesheet" href="style/style.css">
    <title>Stream downloader</title>
</head>
<body>
<?php
require_once __DIR__ . '/logic/Recorder.php';

$config = include __DIR__ . '/config/config.php';
// Instantiate Recorder class with config
$recorder = new Recorder($config);

$url = $_POST['youtube_url'];

$videoName = $recorder->getVideoName($url);

$recorder->createDownloadDirectories();
?>

<h1>Downloading <?= $videoName ?></h1>
<textarea disabled id="consoleOutput" class="consoleOutputSelect" cols="30" rows="20"></textarea>

<script>let textarea = document.getElementById("consoleOutput");
    textarea.scrollTop = textarea.scrollHeight; </script>
<?php
$hlsLink = $recorder->getHLSLink($url);

// Stream name which is used in the filename
$fileName = $recorder->createFileName($videoName);

// Record stream and live output
$recorder->recordStream($hlsLink, $fileName);

$recorder->createThumbnail($fileName);

// After everything is done tell that record is done
echo '<br>Download done. Filename: '. $fileName.'<br><a href="'.$config['domain'].'view.php?video='.$fileName.'">Open</a>';

?>
</body>
</html>