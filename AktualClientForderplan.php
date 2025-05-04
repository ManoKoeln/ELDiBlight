
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

  <div class="co-md-2"l>
    <label id="DescLehrer" for="validationCustom05" class="form-label" onclick="readText(this)">Lehrer</label>
    <input type="text" class="form-control" id="validationLehrer" required>
    <div class="invalid-feedback">
      Bitte geben Sie den Namen des Lehrers ein.
    </div>
  </div>
  
  <!-- <div class="col-md-10 col-sm-12"> -->
  <!-- <div class="container"> -->
    <!-- <div class="row row-cols-12 row-cols-sm-6 row-cols-md-8 row-cols-xs-2 row-cols-xxl-12 g-2"> -->
      <div class="w-100">
    <div class="row row-cols-12">
      <!-- <div class="col">
        <button class="btn btn-primary m-1 " onclick="NewJSONLehrer()">Neue Datei (Lehrer)</button>
      </div>
      <div class="col">
        <button class="btn btn-primary m-1 " onclick="NewJSONKind()">Neue Datei (Kind)</button>
      </div>
      <div class="col">
        <button class="btn btn-primary m-1 w-130" onclick="NewJSONEltern()">Neue Datei (Eltern)</button>
      </div> -->
      <div class="col-md-2">
        <button class="btn btn-primary m-1 w-130" onclick="loadJSON()">Datei laden</button>
      </div>
      <div class="col-md-2">
        <button class="btn btn-primary m-1 w-130" onclick="saveJSON()">Datei speichern</button>
      </div>
      <div class="col-md-2">
        <button class="btn btn-primary m-1 w-130" onclick="exportFoerderplanToWord()">
          <i class="fas fa-print"></i>
        </button>
        <button class="btn btn-primary m-1 w-130 fas fa-question-circle" onclick="window.open('https://youtu.be/jl3OQjhFEKE', '_blank')"></button>
        </button>
      </div>
      <!-- <div class="col">
      <button class="btn btn-secoundary m-1 w-130" onclick="window.location.href='JsonEditor.php'">JSON Editor öffnen</button>
      </div> -->
      <div class="col-md-2">
      <button class="btn btn-primary m-1 w-130" onclick="window.location.href='Start2.php'">Zurück zur Startseite</button>
      </div>
      
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