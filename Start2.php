
<?php
session_start(); // Starten der Session
$_SESSION['LocalChat'] = true;

// require "content/db.php";


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
    <!-- <script src="JScript/ELDiBEltern.js"></script> -->
    <script src="JSON_Handling.js"></script>
    
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
function googleTranslateElementInit() {
  new google.translate.TranslateElement({
    pageLanguage: 'de'
  }, 'google_translate_element');
}
</script>

<script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
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
    <textarea id="fileContent" style="display:none;"></textarea>
  


<div id="Header" class="fixed-top-custom ">
  Header
</div>
<div id="AktualClient" class="fixed-middle-custom row m-1">
  <div class="col-md-2">
    <label id="DescVorname" for="validationCustom01" class="form-label" onclick="readText(this)">Vorname</label>
    <input type="text" class="form-control" id="validationVorname" value="Vorname" required>
    <div class="valid-feedback">
      Looks good!
    </div>
  </div>
  <div class="col-md-2">
    <label id="DescName" for="validationCustom02" class="form-label" onclick="readText(this)">Name</label>
    <input type="text" class="form-control" id="validationName" value="Name" required>
    <div class="valid-feedback">
      Looks good!
    </div>
  </div>

  <div class="col-md-2">
    <label id="DescKlasse" for="validationCustom03" class="form-label" onclick="readText(this)">Klasse</label>
    <input type="text" class="form-control" id="validationKlasse" required>
    <div class="invalid-feedback">
      Bitte geben Sie die Klasse ein.
    </div>
  </div>

  <div class="col-md-2">
    <label id="DescLehrer" for="validationCustom05" class="form-label" onclick="readText(this)">Lehrer</label>
    <input type="text" class="form-control" id="validationLehrer" required>
    <div class="invalid-feedback">
      Bitte geben Sie den Namen des Lehrers ein.
    </div>
  </div>

  
  <!-- <div class="col-md-10 col-sm-12"> -->
  <!-- <div class="container"> -->
    <!-- <div class="row row-cols-12 row-cols-sm-6 row-cols-md-8 row-cols-xs-2 row-cols-xxl-12 g-2"> -->
    <div class="row row-cols-12">
      <div class="col">
        <button class="btn btn-primary m-1 " onclick="NewJSONLehrer()">Neue Datei (Lehrer)</button>
      </div>
      <div class="col">
        <button class="btn btn-primary m-1 " onclick="NewJSONKind()">Neue Datei (Kind)</button>
      </div>
      <div class="col">
        <button class="btn btn-primary m-1 w-130" onclick="NewJSONEltern()">Neue Datei (Eltern)</button>
      </div>
      <div class="col">
        <button class="btn btn-primary m-1 w-130" onclick="loadJSON()">Datei laden</button>
      </div>
      <div class="col">
        <button class="btn btn-primary m-1 w-130" onclick="saveJSON()">Datei speichern</button>
      </div>
      <div class="col">
        <button class="btn btn-primary m-1 w-130" onclick="exportTableToWord()">
          <i class="fas fa-print"></i>
        </button>
      </div>
      <!-- <div class="col">
      <button class="btn btn-secoundary m-1 w-130" onclick="window.location.href='JsonEditor.php'">JSON Editor öffnen</button>
      </div> -->
      <div class="col">
      <button class="btn btn-primary m-1 w-130" onclick="window.location.href='Start2.php'">Zurück zur Startseite</button>
      </div>
      

      
    </div>
  <!-- </div> -->
  <!-- </div> -->

  <!-- <button class="btn btn-secondary m-1" onclick="saveAsJSON()">Erstelle JSON-Datei</button> -->

  <!-- <button class="btn btn-secoundary m-1" onclick="window.location.href='JsonEditor.php'">JSON Editor öffnen</button>
  <button class="btn btn-primary" onclick="window.location.href='Start2.php'">Zurück zur Startseite</button> -->

  <!-- <button class="btn m-1" onclick="addColumn()">Füge eine Spalte hinzu</button> -->
  <!-- <button class="btn btn-warning m-1" onclick="exportToWord()">Exportiere als Word-Dokument</button> -->
  <!-- <button class="btn btn-secondary m-1" onclick="exportTableToWord()">Tabelle in Word exportieren</button> -->


<!-- </form> -->
</div>
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


