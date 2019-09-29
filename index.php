<?php require_once __DIR__ . '/base.html'; ?>
<!--<textarea id="consoleOutput" class="consoleOutputSelect" cols="30" rows="10"></textarea>
--><?php
/*$i=0;
while ($i < 10) {
    echo '<script>document.getElementById("consoleOutput").value += "'.$i.'\n";</script>';
    $i++;
    sleep(1);
    flush();
    ob_flush();
}*/?>
<h1>Youtube live stream recorder</h1>
<div class="formBox">
    <form action="record.php" method="post" class="blueForm">
        <label>Stream URL</label>
        <input type="text" name="youtube_url" value="https://www.youtube.com/watch?v=lw81vZ3YLOs">
        <input type="submit" value="Record" class="smallRightSubmitBtn">
        <div class="clearfix"></div>
    </form>
</div>