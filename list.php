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
<a href="index.php">
    <button>Home</button>
</a><br><br>


<div id="thumbnailContainer">
    <div class="nameSearch">
        <input class="nameSearchInput" id="videoNameInput" type="text" placeholder="Search by name">
    </div>
    <?php
    $config = include __DIR__ . '/config/config.php';
    $record_per_page = 6;
    $url = $config['domain'] . 'list.php';

    // Retrieve all videos in the video directory (remove "." and ".." and reindex array for later)
    $files = array_values(array_diff(scandir($config['video_directory']), ['.', '..']));

    // Set var total_records which shows how many files are
    $total_records = count($files);

    //calculate number of pages (ceil rounds up (5.1 = 6))
    $total_pages = ceil($total_records / $record_per_page);

    if (isset($_GET['page']) && is_numeric($_GET['page']) && !((int)$_GET['page'] < 1)) {
        $page = $_GET['page'];
    } else {
        $page = 1;
    }

    $start_from = ($page - 1) * $record_per_page;
    ?>

    <nav id="paginationNav" aria-label="Page navigation">
        <div class="pagination">
            <?php
            if ($page > 1) {
                echo "<a href='" . $url . "?page=1'><<</a>";
                echo "<a href='" . $url . '?page=' . ($page - 1) . "'><</a>";
            }
            for ($i = 1; $i <= $total_pages; $i++) {
                $class = $i == $page ? 'active' : '';
                echo "<a class='" . $class . "' href='" . $url . '?page=' . $i . "'>" . $i . "</a>";
            }
            if ($page < $total_pages) {
                echo "<a href='" . $url . '?page=' . ($page + 1) . "'>></a>";
                echo "<a href='" . $url . '?page=' . $total_pages . "'>>></a>";
            } ?>

        </div>
    </nav>

    <?php


    // Get all files from video directory


    //    foreach ($files as $file) {
    //        $thumbnailPath = $config['thumbnail_directory'] . pathinfo($file, PATHINFO_FILENAME) . '.jpg';
    //        if (file_exists($thumbnailPath)) {
    //            echo '<div class="thumbnail">
    //             <a href="' . $config['domain'] . 'view.php?video=' . $config['video_directory'] . $file . '">
    //                 <img class="thumbnailImg" src="' . $thumbnailPath . '" alt="thumbnail">
    //
    //             <span>' . $file . '</span>
    //             </a>
    //             </div>';
    //        }
    //    }
    //    var_dump($files);
    //    var_dump($start_from,$record_per_page);
    $filesToIterate = array_slice($files, $start_from, $record_per_page);
    //var_dump($filesToIterate);
    foreach ($filesToIterate as $file) {
        $thumbnailPath = $config['thumbnail_directory'] . pathinfo($file, PATHINFO_FILENAME) . '.jpg';
        if (!file_exists($thumbnailPath)) {
            $thumbnailPath = $config['thumbnail_directory'] . 'thumbnail_not_found.jpg';
        }
        echo '<div class="thumbnail clearfix">
             <a href="' . $config['domain'] . 'view.php?video=' . $config['video_directory'] . $file . '">
                 <img class="thumbnailImg" src="' . $thumbnailPath . '" alt="thumbnail">
              
             <span>' . $file . '</span>
             </a>
             </div>';
    }

    ?>
    <div class="clearfix"></div>

</div>



<script src="js/main.js"></script>
</body>
</html>