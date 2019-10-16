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
<a href="index.php"><button>Home</button></a><br><br>


<div id="thumbnailContainer">
    <div class="nameSearch">
        <input class="nameSearchInput" id="videoNameInput" type="text" placeholder="Search by name">
    </div>
    <?php
    $config = include __DIR__ . '/config/config.php';

    // Get all files from video directory
    $files = array_diff(scandir($config['video_directory']), ['.', '..']);
    foreach ($files as $file) {
        $thumbnailPath = $config['thumbnail_directory'] . pathinfo($file, PATHINFO_FILENAME) . '.jpg';
        if (file_exists($thumbnailPath)) {
            echo '<div class="thumbnail">
             <a href="' . $config['domain'] . 'view.php?video=' . $config['video_directory'] . $file . '">
                 <img class="thumbnailImg" src="' . $thumbnailPath . '" alt="thumbnail">
              
             <span>' . $file . '</span>
             </a>
             </div>';
        }
    }
    ?>
</div>
<script src="js/main.js"></script>
</body>
</html>