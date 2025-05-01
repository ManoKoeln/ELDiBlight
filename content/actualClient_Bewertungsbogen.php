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
        <button class="btn btn-primary m-1 w-130 fas fa-question-circle" onclick="window.open('https://youtu.be/jl3OQjhFEKE', '_blank')"></button>
        </button>
      </div>
      <div class="col">
      <button class="btn btn-primary m-1 w-130" onclick="window.location.href='Start2.php'">Zurück zur Startseite</button>
      </div>            
    </div>
</div>
<?php
echo "Test";
?>