# Stream recorder 

## Installation 
> Beschreibt die Inbetriebnahme detailliert und Betriebssystemunabhängig.    
   
[XAMPP](https://www.apachefriends.org/de/download.html) muss auf dem Computer im Vorfeld installiert sein.
### 1. Code herunterladen
Dieses Repository klonen oder als ZIP herunterladen und dann in den htdocs Ordner ziehen. 

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

