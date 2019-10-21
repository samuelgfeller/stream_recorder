# Technische Dokumentation
technische Projektdokumentation (als PDF)
Beschreibt die technische Umsetzung der im Kompetenzraster geforderten technischen Kompetenzen

### Kompetenz 3B und 4B
Das Video wird mit einem `<video>`-Tag im DOM eingefügt. Der Pfad mit dem subtag `<source>`. Hier könnte man
mehrere Dateiformate angbieten indem mehrere `<source>` hinzugefügt werden in einem Video Tag. Der Browser nimmt
dann den ersten unterstützten. In meinem Fall benutze ich mp4 was schon unterstützt wird durch alle modernen
Browser daher habe ich nur ein `<source>`. 
Die technische Umsetzung sieht so aus `$video` als Pfad:  
```php
<?php 
echo '<div class="videoContainer">
  <video controls>
    <source src="' . $video . '" type="video/mp4">
    Your browser does not support the video tag.
  </video>
</div>';
?>
```  
Die Responsivität wird mit einem `@media`-Tag gesteuert.   
Der Standardzustand vom `videoContainer` ist folgendermassen:  
```css
.videoContainer {
    width: 70%;
    margin: 30px auto;
}
```
Ab `800px` soll die Videobreite auf die ganze Breite angepasst werden (minus den body margins)  
```css
@media screen and (max-width: 800px) {
    .videoContainer {
        width: 100%;
    }
}
``` 

### Kompetenz 2C
Die Kernfunktionalität dieses Skript ist es ein Livestream aufzunehmen und in ein mp4 wandeln.  
Dies wird über die Konsole gemacht; durch php mit der Funktion `shell_exec`.  
Der erste Schritt ist aber von der Youtube-URL ein HTTP Live Streaming (HLS)-Link zu bekommen welcher dann
einfach aufgenommen werden kann. Dafür benutze ich die Bibliothek youtube-dl mit dem Parameter `-g` welches
Nur der HLS-Link zurückgibt und das Video nicht herunterlädt.     
```php
<?php
shell_exec('youtube-dl ' . '-g ' . escapeshellarg($youtubeUrl))
?>
```
Nachdem ich diesen Link habe, kann der Livestream aufgenommen werden. Damit ich dies generisch auf Konsoleebene
machen kann, benutze ich die Bibliothek `ffmpeg` welche sich dafür eignet. Gleichzeitig gebe ich die Konsoleausgabe
in Echtzeit aus daher kann `shell_exec` nicht verwendet werden.  
`proc_open` scheint sich dafür zu eignen. Die Funktion öffnet ein Prozess wo die Ausgabe dann aubefangen werden kann. 
Der `ffmpeg`-Befehl sieht es so aus und wird so ausgeführt:  
```php
<?php
// ffmpeg command
$ffmpeg = 'ffmpeg -re -i "' . $hlsLink . '" -t ' . $this->config['max_record_time'] . ' -c copy ' . escapeshellcmd($fileName);

// Set execution time limit up to the given max record time + 60 seconds for overhead
set_time_limit($this->config['max_record_time'] + 60);

// Execute the command and get the process
$process = proc_open($ffmpeg, $descriptorspec, $pipes);
?>
```
PHP hat eine maximale Ausführzeit von 30 Sekunden, dann wird das Skript mit einer Fatal error gestoppt.
Diese Zeitlimitierung kann man mit der Funktion `set_time_limit` angepasst werden.  
Was `$descriptorspec` ist und wie es benutzt wird erkläre ich im Lernjournal. 

Die Live-Ausgabe erfolgt folgendermassen:  
```php
<?php
if (is_resource($process)) {
    while ($s = fgets($pipes[2])) {
         // Remove newlines because somehow it doesn't get populated if there is a newline
         $s = str_replace(["\r", "\n"], '', $s);
         echo '<script>document.getElementById("consoleOutput").value += "' . $s . '\n";
    document.getElementById("consoleOutput").scrollTop = document.getElementById("consoleOutput").scrollHeight;</script>';
         flush();
         ob_flush();
    }
}
?>
``` 
Grundsätzlich werden die Ausgaben von `pipe[2]` (Lernjournal erklärt) ausgebgen sollange es Ausgaben liefert.
der Inhalt wird in eine `<textarea>` ausgegeben und mit dem generierten Javascript wird automatisch 
herunter "gescrollt". Zwar nicht sehr Layer respektierend aber das ist diese Applikation sowieso überhaupt 
nicht und es ist der einfachste Weg eine Serverausgabe clientseitg zu machen.  
Die Schlüsselfunktionen hier sind `flush` und `ob_flush` welche die Ausgabe zum Client führen. 

### Kompetenz 3C
Nach der Aufnahme wird ein Thumnail erstellt. Dafür habe wird auch `ffmpeg` benutzt.
Die Erstellung sieht so aus:  
```php
<?php
$thumbnail = $this->config['thumbnail_directory'] . $videoNameParts['filename'] . '.jpg';
shell_exec("ffmpeg -i $videoFullName -deinterlace -an -ss 1 -t 00:00:01 -r 1 -y -vcodec mjpeg -f mjpeg $thumbnail 2>&1");
?>
```
Als Format benutze ich `jpeg` da es in Browser sehr weit verbreitet ist und gut unterstützt wird. Es werden
auch keine Durchsichtikeits-Schichten gebraucht also ist png nicht notwendig. 

### Kompetenz 4C
**Suche**   
Es gibt eine Javascript-Suche. Dafür wird auf Änderungen in einem Inputfeld gewartet mit einem Event-Listener
welcher dann die filter-Funktion ausführt. So sieht es aus:  
```html
<div class="nameSearch">
    <input class="nameSearchInput" id="videoNameInput" type="text" placeholder="Search on current page">
</div>
```
```js
document.getElementById('videoNameInput').addEventListener("keyup", filter);

function filter()
{
    let input = document.getElementById('videoNameInput').value.toUpperCase();
    let container = document.getElementById('thumbnailContainer');
    let thumbnails = container.getElementsByClassName('thumbnail');

    for (let i = 0; i < thumbnails.length; i++) {
        // Get (first) p below i'th thumbnail
        let p = thumbnails[i].getElementsByTagName('p')[0];
        let txtValue = p.textContent || p.innerText;
        if (txtValue.toUpperCase().indexOf(input) > -1) {
            thumbnails[i].style.display = "";
        } else {
            thumbnails[i].style.display = "none";
        }
    }
}
```
**Pagination**
Die Pagination wurde mit PHP umgesetzt. Dies ist die Pagination-Funktion:  
```php
<?php
    $record_per_page = 6;

    // Set var total_records which shows how many files are
    $total_records = count($files);

    //calculate number of pages (ceil rounds up (5.1 = 6))
    $total_pages = ceil($total_records / $record_per_page);

    // Find GET parameter which indicates the page number
    if (isset($_GET['page']) && is_numeric($_GET['page']) && !((int)$_GET['page'] < 1)) {
        $page = $_GET['page'];
    } else {
        $page = 1;
    }

    // Define where to start. If the page is 3, the first entry should be the 2 * 6 = 12th
    $start_from = ($page - 1) * $record_per_page;
    ?>

    <nav id="paginationNav" aria-label="Page navigation">
        <div class="pagination">
            <?php
            if ($page > 1) {
                echo "<a href='" . $url . "?page=1'>&lt;&lt;</a>";
                echo "<a href='" . $url . '?page=' . ($page - 1) . "'>&lt;</a>";
            }
            for ($i = 1; $i <= $total_pages; $i++) {
                $class = $i == $page ? 'active' : '';
                echo "<a class='" . $class . "' href='" . $url . '?page=' . $i . "'>" . $i . '</a>';
            }
            if ($page < $total_pages) {
                echo "<a href='" . $url . '?page=' . ($page + 1) . "'>></a>";
                echo "<a href='" . $url . '?page=' . $total_pages . "'>>></a>";
            } ?>

        </div>
    </nav>
```


