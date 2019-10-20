# Stream recorder 

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
Das Dateiformat ist **mp4** weil es sehr weit unterstützt wird (vielleicht sogar am besten für Videos).

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
Das Projekt wurde mit GitHub Projects geplant und durchgeführt. Es wurde im Zweiten Teil mit issues gearbeitet.  
[Hier](https://github.com/samuelgfeller/stream_recorder/projects/1) ist die Planung zu finden. 
  
**Ausführlichere Informationen über die Umsetzung und dem Inhalt des Projkets sowie dem Featureumfang sind in meinem Lernjournal 
zu finden.**

## Installation 
Coming soon..
Installationsanleitung
Beschreibt die Inbetriebnahme detailliert und Betriebssystemunabhängig.

## Technical documentation
Coming soon..
technische Projektdokumentation (als PDF)
Beschreibt die technische Umsetzung der im Kompetenzraster geforderten technischen Kompetenzen
