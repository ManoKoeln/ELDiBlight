
<?php
session_start(); // Starten der Session
$_SESSION['LocalChat'] = true;
// Datei, in der die Daten gespeichert werden
$counterFile = 'Server/counter.txt';

// Benutzer-IP-Adresse abrufen
$userIp = $_SERVER['REMOTE_ADDR'];

// Überprüfen, ob die Datei existiert
if (!file_exists($counterFile)) {
    file_put_contents($counterFile, ""); // Datei erstellen
}
$geoData = file_get_contents("http://ip-api.com/json/$userIp");
$geoInfo = json_decode($geoData, true);

// IP-Adressen aus der Datei lesen
$entries = file($counterFile, FILE_IGNORE_NEW_LINES);

// Laufende Nummer berechnen
$lastEntry = end($entries);
$lastNumber = 0;
if ($lastEntry) {
    $lastNumber = (int)explode(',', $lastEntry)[0]; // Die laufende Nummer aus der letzten Zeile extrahieren
}
$currentNumber = $lastNumber + 1;

// Datum und Uhrzeit abrufen
$currentDateTime = date('Y-m-d H:i:s');
$Country = $geoInfo['country'] ?? 'Unknown';
$City = $geoInfo['city'] ?? 'Unknown';  

// Neue Zeile erstellen
$newEntry = "$currentNumber,$userIp,$currentDateTime,$Country,$City";

// Prüfen, ob die IP-Adresse bereits existiert
$ipExists = false;
foreach ($entries as $entry) {
    $entryParts = explode(',', $entry);
    if (isset($entryParts[1]) && $entryParts[1] === $userIp) {
        $ipExists = true;
        break;
    }
}

// Nur hinzufügen, wenn die IP-Adresse noch nicht existiert
// if (!$ipExists) {
    file_put_contents($counterFile, $newEntry . PHP_EOL, FILE_APPEND);
// }

// Anzahl der eindeutigen Besucher
$uniqueVisitors = count($entries) + (!$ipExists ? 1 : 0);


?>
<!DOCTYPE html>
<HTML lang="de">
<meta charset="UTF-8">

<head>
    <title>ETEP</title>
    
    
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" media="screen and (max-aspect-ratio: 4/3)" href="css/styleSmal.css" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"> <!-- Font Awesome CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> 
    <script src="Myjs.js"></script>
    <script src="Printer.js"></script>
    <script src="JScript/ELDiBLehrer.js"></script>
    <!-- <script src="JScript/ELDiKind.js"></script> -->
    <script src="JScript/ELDiBEltern.js"></script>
    <script src="JSON_Handling.js"></script>
    <script src="JSON_HandlingETEP.js"></script>
    
    <style>
        .fixed-top-custom {
            top: 0;
            width: 100%;
            height: 20vh;
            background-color: #f8f9fa; /* Beispielhintergrundfarbe */
        }
          #AktualClient{
            display: none;
          }
        .fixed-middle-custom {
          
            top: 20%;
            width: 100%;
            height: 22vh;
            left: 0;
            margin: 0;
            background-color: lightblue; /* Beispielhintergrundfarbe */
        }

        .fixed-bottom-custom {
            top: 33%;
            width: 100%;
            height: 53vh;
            background-color: #dee2e6; /* Beispielhintergrundfarbe */
            overflow: auto; /* Ermöglicht das Scrollen, wenn der Inhalt größer ist als der Container */
        }
    </style>
    <script>
// function googleTranslateElementInit() {
//   new google.translate.TranslateElement({
//     pageLanguage: 'de'
//   }, 'google_translate_element');
// }
</script>

<!-- <script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script> -->
<!-- <script src="Myjs.js"></script> -->

    <!-- <script src="Operator.js"></script>
    <script src="ELDiBEltern.js"></script>
    <script src="JScript/ELDiBLehrer_New.js"></script>
    <script src="ELDiBKind.js"></script>
    <script src="ELDiBLehrer.js"></script>
    <script src="SupportPlan.js"></script>
    <script src="EmailKind.js"></script>
    <script src="EmailEltern.js"></script> -->
    <!-- <script>
              window.onload = function() {
            Start();
        };
    </script> -->
    <!-- <script src="NewClient.js"></script> -->
    <?php


// process_json.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // JSON-Daten aus der Anfrage lesen
  $jsonData = file_get_contents('php://input');
  // JSON-Daten dekodieren
  $data = json_decode($jsonData, true);

  // JSON-Daten in der Session speichern
  $_SESSION['data'] = $data;

  echo "JSON-Daten wurden erfolgreich in der Session gespeichert.";

}

        ?>
</head>
<body onload="StartHead();">

<input type="file" id="fileInput" accept=".json" style="display:none;" onchange="handleFileSelect(event)">
<input type="file" id="fileFoerderplanInput" accept=".json" style="display:none;" onchange="handleFileSelectFoerderplan(event)">
    <textarea id="fileContent" style="display:none;"></textarea>
  


<div id="Header" class="fixed-top-custom ">
  Header
</div>
<div id="AktualClient" class="fixed-middle-custom row m-1">

</div>
<div id="Startseite" class="fixed-bottom-custom p-1">
  Startseite
</div>
</body>
<footer class="fixed-bottom">
  <div class="container">
    <p class="text-center">© 2023 ETEP. Alle Rechte vorbehalten.</p>
    
  </div>
</html>


