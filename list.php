<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Stream downloader</title>
</head>
<body>
<h1>Downloaded streams</h1>
<?php
$config = include __DIR__ . '/config/config.php';

$files = array_diff(scandir($config['download_directory']), ['.', '..']);
foreach($files as $file){
    echo '<br><a href="'.$config['domain'].'view.php?video='.$config['download_directory'].$file.'">'.$file.'</a><br>';
}
?>
<script src="js/main.js"></script>
</body>
</html>