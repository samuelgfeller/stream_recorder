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
<h1>Youtube live stream recorder</h1>
<div class="formBox">
    <form action="record.php" method="post" class="blueForm">
        <label for="urlInput">Stream URL</label>
        <input type="text" id="urlInput" name="youtube_url" value="https://www.youtube.com/watch?v=21X5lGlDOfg">
        <input type="submit" value="Record" class="smallRightSubmitBtn">
        <div class="clearfix"></div>
    </form>
</div>
<p>
    <br>
    Zu Testzwecken werden die Livestreams jeweils nur 20 Sekunden lang aufgenommen.
</p>
</body>
</html>