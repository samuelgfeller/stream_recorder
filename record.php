<?php
// Include base.html where style and script is included
require_once __DIR__ . '/base.html';
require_once __DIR__ . '/Recorder.php';

$config = include __DIR__ . '/config/config.php';
// Instantiate Recorder class with config
$recorder = new Recorder($config);

$url = $_POST['youtube_url'];

$videoName = $recorder->getVideoName($url);
?>

<h1><?= $videoName ?></h1>
<textarea disabled id="consoleOutput" class="consoleOutputSelect" cols="30" rows="20"></textarea>

<script>let textarea = document.getElementById("consoleOutput");
    textarea.scrollTop = textarea.scrollHeight; </script>
<?php
$hlsLink = $recorder->getHLSLink($url);

// Stream name which is used in the filename
$fileName = $recorder->createFileName($videoName);

// Record stream and live output
$recorder->recordStream($hlsLink, $fileName);

// After everything is done tell that record is done
echo '<br>Download done. Filename: ' . $fileName;

?>
