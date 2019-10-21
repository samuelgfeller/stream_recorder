# Stream recorder 

## Installation 
> Beschreibt die Inbetriebnahme detailliert und Betriebssystemunabhängig.    
   
[XAMPP](https://www.apachefriends.org/de/download.html) muss auf dem Computer im Vorfeld installiert sein.
### 1. Code herunterladen
Dieses Repository Klonen oder als ZIP herunterladen und dann in den htdocs Ordner Ziehen. 

### 2. Bibliotheken hinzufügen 
Der **\lib\\** Ordner im Projektordner muss zu den PATH-Umgebungsvariablen hinzugefügt werden. 
#### Windows
Die Installation auf Windows ist anders als diejenige von macOS. Hier ist eine [Windows Anleitung](https://docs.alfresco.com/4.2/tasks/fot-addpath.html) 
um Umgebungsvariablen hinzuzufügen. Dort muss den \lib\\-Ordner hinzugefüt werden. Bei mir sieht er so aus: 
C:\xampp\htdocs\stream_recorder\lib\  
[Hier](https://imgur.com/FjAhH0P) ist eine graphische Sicht der Einstellungen bei mir (auf Windows).

#### macOS
Es ist schwierig für mich eine Anleitung für macOS zu machen da ich keinen Mac besitze und sehr wenig Erfahrung damit habe. 
[Hier](https://www.aptgetupdate.de/2017/08/30/macos-tipp-path-variable-anzeigen-und-ndern/) ist eine Anleitung auf Deutsch welche 
gut aussieht. Es muss der muss der \lib\\-Ordner im Projekt hinzugefüt werden.

### 3. Gerät neustarten

### 4. Frontend aufrufen
Jetzt kann in einem Browser der Pfad des Project roots geöffnet werden. Wenn das Projekt direkt im htdocs abgelegt wurde, 
wird der link so aussehen: http://localhost/stream_recorder/index.php 

## Projektdokumentation
> Kann den Projektantrag in eine Projekt-Dokumentation überführen. In der Projekt-Dokumentation werden die für dieses Modul 
relevanten Funktionen der Applikation beschrieben und erklärt und die Verwendung der Dateiformate begründet.

### Kompetenz 3B und 4B
> Kann Multimedia-Inhalte dynamisch für unterschiedliche Geräte, Betriebssysteme und Browser optimieren. Dabei unterstützt er / sie die wichtigsten Betriebssystem und Browser. 
  
> Zeigt die Multimedia-Inhalte auf
unterschiedlichen Bildschirmgrössen korrekt an.
(Responsive Web Design).

Es kann ein Video abgespielt werden wenn man in der Galerie (/list.php) auf ein Thumbnail drückt.   
Wenn die Seite mit einem Computer aufgerufen wird, ist die Breite 70% vom Browserfenster. Sobald die Breite aber unter **801px** fällt, 
wird das Video auf die (fast) ganze Breite angepasst.   
Dies funktioniert so mit allen modernen Browser und Betriebssysteme.   
Das Dateiformat ist **mp4** weil es sehr gut unterstützt wird (vielleicht sogar am besten für Videos).

### Kompetenz 2C
> Erstellt Multimedia-Inhalte dynamisch mithilfe geigneter Geräten, Bibliotheken, APIs selbst oder ladet Multimedia-Inhalte 
über ein Formular in die Applikation. Beim Upload beachtet er / sie die Filegrösse und schrenkt mögliche Dateiformate ein.
  
Mit einem gegebenen Link von einem laufenden Youtube Livestream nimmt das Script ein Video auf vom Livestream und speichert es 
auf der Festplatte ab als mp4. 

### Kompetenz 3C
> Verabeitet die generierten oder hochgeladenen Multimedia-Inhalte weiter in dem er / sie die Inhalte dynamisch verändert, kombiniert
oder analysiert.

Nachdem das Video aufgenommen wurde, macht das Skript ein Standbild bei der ersten Sekunde welches dann in form eines Thumbnails 
in der Galerie dargestellt wird.  
  
Beim öffnen eines Videos auf der Seite, wird das Videodokument analysiert und infos wie Dateiformat, Pfad und Grösse. 

### Kompetenz 4C
> Achtet auf Usability der Webseite. Dazu bietet er / sie benutzerdefinierte Such- / Filterfunktionen wie Filter, Pagination oder Suche an. Leitet den Benutzer mit sinnvollen Meldungen durch alle Prozesse. Validiert HTML und CSS.
  
Suche: Bei der Galerie gibt es eine Suchfeld welches alle Videos auf der aktuellen Seite durchsucht und die Resultate anzeigen lässt.   
Pagination: Die Videos werden in Seiten unterteilt welche durch Pagination-Knöpfe aufgerufen werden können.   
Meldungen: Ich habe versucht so viel mögliche Fehler wie möglich zu abfangen und Benutzerfreundliche Meldungen anzeigen.   
Nachfolgend sind einige Beispiele:   
* Auf /view.php der Pfad eines Videos zu einem nicht existenten Video führt, wird eine entsprechende Meldung gemacht. 
* Nachdem auf "Record" gedrückt wurde und die Seite geladen hat, gibt es eine Direktausgabe der Konsole also kann der Benutzer (welcher 
etwas von IT versten muss aber das war auch das Ziel, daher ich dieses Skript eigentlich für mich gemacht habe) sehen was und dass etwas 
passiert während das Video aufgenommen wird.   
* Sobald ein Video heruntergeladen wurde wird eine Meldung anzegeit in welcher steht, dass der Download fertig ist, wo es 
abgespeichert wurde und der Dateinamen. 
* Nach dem Download wird vorgeschalgen das Video direkt zu öffnen. 

### Kompetenz 5C
Das Projekt wurde mit GitHub Projects geplant und verfolgt. Es wurde im Zweiten Teil mit issues gearbeitet.  
[Hier](https://github.com/samuelgfeller/stream_recorder/projects/1) ist die Planung zu finden. 
  
**Ausführlichere Informationen über die Umsetzung und dem Inhalt des Projkets sowie dem Featureumfang sind in meinem Lernjournal 
zu finden.**

## Technische Dokumentation
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



