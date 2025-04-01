<?php
// <!-- <script src="Myjs.js"></script>
// <script src="ELDiBLehrer.js"></script>

// <div id="ELDiBLehrercontent">
// </div>
// <script src="Printer.js"></script> -->


// <?php

if (session_status() == PHP_SESSION_NONE) {
  session_start(); // Starten der Session nur, wenn keine Session aktiv ist
}

$_SESSION['LehrerArrayCounter'] = 0;
$Stichwort = " stichwort";
include "content/db.php";
include_once "content/helpers.php";
// include "printer.php";

// Eltern Liste aus Datenbank laden
if ( isset($_GET['SetELDiBEltern']) ){
  echo '<script>console.log("SetELDiBEltern");</script>';
  $Inhalt =  '<div  id="ELDiBElternhead">';
  $Inhalt.=  '  <h1>ELDiB Bewertungsbogen Eltern</h1>';
  $Inhalt.=  '<div ><button type="button" onclick="HideELDiBEltern();" class="btn btn-primary btn-sm">zurück</button></div>';
  $Inhalt.=  '<div class="Schuelerdaten">';    
  $Inhalt.=  '<div>';
  $Inhalt.=  'Name : Name ';
  $Inhalt.=   '</div>';
  $Inhalt.=  '<div>';
  $Inhalt.=  'Name : Vorname ';
  $Inhalt.=   '</div>';
  $Inhalt.=  '<div>';
  $Inhalt.=  'Name : Klasse ';
  $Inhalt.=   '</div>';
  $Inhalt.=  '<div>';
  $Inhalt.=  'Name : Eltern ';
  $Inhalt.=   '</div>';
  $Inhalt.=   '</div>';
  $Inhalt.=  '<div>';

  $Inhalt.= '</div>';
  $Inhalt.= '<div id="ELDiBElterncontainer" class="tableFixHead">';
  $Inhalt.= '<table class="table table-bordered table-striped table-hover table-sm">';
  $Inhalt.= '<thead>';
  $Inhalt.= '<tr class="BeschreibungHead">';
  $Inhalt.= '<th class="KELZielBeschreibungHead">Beschreibung</th><th class="KELZielNummerHead">Bereich</th>'; 

  $Inhalt.= '</tr>';
  $Inhalt.= '</thead>';
//alle 4 Bereiche durchgehen
    // Ensure "details" array exists in the JSON structure
    $existingData['titel'] = 'Einschätzungsbogen Eltern';
    $existingData['content'] = 'Inhalt des Dokuments.';
    $existingData['Vorname'] = 'Vorname';
    $existingData['Nachname'] = 'Name';
    $existingData['Klasse'] = 'Klasse';
    $existingData['Eltern'] = 'Eltern';

    if (!isset($existingData['details'])) {
      $existingData['details'] = [];
    }
for($BereichID = 1; $BereichID <=4; $BereichID++)
  {
  $Stufe = 0;

  $db_link = new mysqli($_SESSION["host_name"], $_SESSION["user_name"], $_SESSION["password"], $_SESSION["database"]);
  $sql = "SELECT * FROM zieleeldibeltern WHERE BereichID = '".$BereichID."'";
  $db_erg = mysqli_query( $db_link, $sql );
  if ( ! $db_erg )
  {
    echo  'ungültige Bereich Abfrage Ziele: Error message: %s\n'. $db_link->error;
  }
  while ($zeile = mysqli_fetch_assoc( $db_erg))
    {
      //Stufe anzeigen
    if ($Stufe != $zeile['Stufe']){
      $Inhalt.= '<tr>';
    
      //Stufe Beschreibung
      $Inhalt.= '<td class="ZielStufe" >Stufe :'.$zeile['Stufe'];
      $db_link = new mysqli($_SESSION["host_name"], $_SESSION["user_name"], $_SESSION["password"], $_SESSION["database"]);
      $sqls = "SELECT * FROM stufenbeschreibungen WHERE BereichID = '1' AND Stufe = ".$zeile['Stufe']." ";
      $db_ergs = mysqli_query( $db_link, $sqls );
      if ( ! $db_ergs )
        {
          echo 'ungültige Bereich Abfrage Ziele: Error message: %s\n'. $db_link->error;
        }
        
        while ($zeiles = mysqli_fetch_assoc( $db_ergs))
        {
          $Inhalt.= '  '.MyStringHTML($zeiles['Beschreibung1']).'<br> '.MyStringHTML($zeiles['Beschreibung2']).'</td>';
              // Prepare data to write into JSON
          $zielData = [
            'Stufe' => $zeile['Stufe'],
            'BereichID' => $zeile['BereichID'],
            'ZieleNummer' => '',
            'ZieleStichwort' => 'Stufe :'.$zeile['Stufe'].' '.MyStringHTML($zeiles['Beschreibung1']).MyStringHTML($zeiles['Beschreibung2']),
            'ZieleBeschreibung' => '',
            'Notizen' => '',
            // 'newSelect0' => 'später'
          ];

          // Append the new data to the "details" array
          $existingData['details'][] = $zielData;
        }
        $Inhalt.=  "</tr>";
      $Stufe = $zeile['Stufe'];
    }
    // Beschreibung und Stichwort Ziele eintragem
    
    // Prepare data to write into JSON
    $zielData = [
      'Stufe' => $zeile['Stufe'],
      'BereichID' => $zeile['BereichID'],
      'ZieleNummer' => $zeile['ZieleNummer'],
      'ZieleStichwort' => $zeile['ZieleNummer'].' '.$zeile['ZieleStichwort'],
      'ZieleBeschreibung' => $zeile['ZieleBeschreibung'],
      'Notizen' => 'Notizen',
      'newSelect0' => 'später'
    ];



    // Append the new data to the "details" array
    $existingData['details'][] = $zielData;



    // Generate the table cell
    $Inhalt.= '<td class="KELZielNummer TabContent'.$BereichID.'" ondblclick="readText(this)">'.$zeile['ZieleNummer'].' '.MyStringHTML($zeile['ZieleStichwort']).'</td>';
    $Inhalt.= '<td class="KELZielBeschreibung TabContent'.$BereichID.'" ondblclick="readText(this)"> '.MyStringHTML($zeile['ZieleBeschreibung']).'</td>';
     


      $Inhalt.=  "</tr>";
      $Inhalt.= '<tr>';
      $Inhalt.=  "</tr>";
    }

}
$Inhalt.=  "</table>";			
$Inhalt.=  "</div>";	
  echo $Inhalt;
      // Define the JSON file path
      $jsonFilePath = 'JSON/VorlageElternNew.json';

      // Read existing data from the JSON file
      // $existingData = [];
      if (file_exists($jsonFilePath)) {
        // Overwrite the file by clearing its content
        file_put_contents($jsonFilePath, '');
        // $existingData = [];
      }
  
      // // Append the new data
      // $existingData[] = $zielData;
  
      // Write the updated data back to the JSON file
      file_put_contents($jsonFilePath, json_encode($existingData, JSON_PRETTY_PRINT));

}

// Kind Liste aus Datenbank laden
if ( isset($_GET['SetELDiBKind']) ){
  echo '<script>console.log("SetELDiBKind");</script>';
  $Inhalt =  '<div  id="ELDiBKindhead">';
  $Inhalt.=  '  <h1>ELDiB Bewertungsbogen Kind</h1>';
  $Inhalt.=  '<div ><button type="button" onclick="HideELDiBKind();" class="btn btn-primary btn-sm">zurück</button></div>';
  $Inhalt.=  '<div class="Schuelerdaten">';    
  $Inhalt.=  '<div>';
  $Inhalt.=  'Name : Name ';
  $Inhalt.=   '</div>';
  $Inhalt.=  '<div>';
  $Inhalt.=  'Name : Vorname ';
  $Inhalt.=   '</div>';
  $Inhalt.=  '<div>';
  $Inhalt.=  'Name : Klasse ';
  $Inhalt.=   '</div>';
  $Inhalt.=  '<div>';
  $Inhalt.=  'Name : Kind ';
  $Inhalt.=   '</div>';
  $Inhalt.=   '</div>';
  $Inhalt.=  '<div>';

  $Inhalt.= '</div>';
  $Inhalt.= '<div id="ELDiBKindcontainer" class="tableFixHead">';
  $Inhalt.= '<table class="table table-bordered table-striped table-hover table-sm">';
  $Inhalt.= '<thead>';
  $Inhalt.= '<tr class="BeschreibungHead">';
  $Inhalt.= '<th class="KELZielBeschreibungHead">Beschreibung</th><th class="KELZielNummerHead">Bereich</th>'; 

  $Inhalt.= '</tr>';
  $Inhalt.= '</thead>';
//alle 4 Bereiche durchgehen
    // Ensure "details" array exists in the JSON structure
    $existingData['titel'] = 'Einschätzungsbogen Kind';
    $existingData['content'] = 'Inhalt des Dokuments.';
    $existingData['Vorname'] = 'Vorname';
    $existingData['Nachname'] = 'Name';
    $existingData['Klasse'] = 'Klasse';
    $existingData['Kind'] = 'Kind';

    if (!isset($existingData['details'])) {
      $existingData['details'] = [];
    }
for($BereichID = 1; $BereichID <=4; $BereichID++)
  {
  $Stufe = 0;

  $db_link = new mysqli($_SESSION["host_name"], $_SESSION["user_name"], $_SESSION["password"], $_SESSION["database"]);
  $sql = "SELECT * FROM zieleeldibkind WHERE BereichID = '".$BereichID."'";
  $db_erg = mysqli_query( $db_link, $sql );
  if ( ! $db_erg )
  {
    echo  'ungültige Bereich Abfrage Ziele: Error message: %s\n'. $db_link->error;
  }
  while ($zeile = mysqli_fetch_assoc( $db_erg))
    {
      //Stufe anzeigen
    if ($Stufe != $zeile['Stufe']){
      $Inhalt.= '<tr>';
    
      //Stufe Beschreibung
      $Inhalt.= '<td class="ZielStufe" >Stufe :'.$zeile['Stufe'];
      $db_link = new mysqli($_SESSION["host_name"], $_SESSION["user_name"], $_SESSION["password"], $_SESSION["database"]);
      $sqls = "SELECT * FROM stufenbeschreibungen WHERE BereichID = '1' AND Stufe = ".$zeile['Stufe']." ";
      $db_ergs = mysqli_query( $db_link, $sqls );
      if ( ! $db_ergs )
        {
          echo 'ungültige Bereich Abfrage Ziele: Error message: %s\n'. $db_link->error;
        }
        
        while ($zeiles = mysqli_fetch_assoc( $db_ergs))
        {
          $Inhalt.= '  '.MyStringHTML($zeiles['Beschreibung1']).'<br> '.MyStringHTML($zeiles['Beschreibung2']).'</td>';
              // Prepare data to write into JSON
          $zielData = [
            'Stufe' => $zeile['Stufe'],
            'BereichID' => $zeile['BereichID'],
            'ZieleNummer' => '',
            'ZieleStichwort' => 'Stufe :'.$zeile['Stufe'].' '.MyStringHTML($zeiles['Beschreibung1']).MyStringHTML($zeiles['Beschreibung2']),
            'ZieleBeschreibung' => '',
            'Notizen' => '',
            // 'newSelect0' => 'später'
          ];

          // Append the new data to the "details" array
          $existingData['details'][] = $zielData;
        }
        $Inhalt.=  "</tr>";
      $Stufe = $zeile['Stufe'];
    }
    // Beschreibung und Stichwort Ziele eintragem
    
    // Prepare data to write into JSON
    $zielData = [
      'Stufe' => $zeile['Stufe'],
      'BereichID' => $zeile['BereichID'],
      'ZieleNummer' => $zeile['ZieleNummer'],
      'ZieleStichwort' => $zeile['ZieleNummer'].' '.$zeile['ZieleStichwort'],
      'ZieleBeschreibung' => $zeile['ZieleBeschreibung'],
      'Notizen' => 'Notizen',
      'newSelect0' => 'später'
    ];



    // Append the new data to the "details" array
    $existingData['details'][] = $zielData;



    // Generate the table cell
    $Inhalt.= '<td class="KELZielNummer TabContent'.$BereichID.'" ondblclick="readText(this)">'.$zeile['ZieleNummer'].' '.MyStringHTML($zeile['ZieleStichwort']).'</td>';
    $Inhalt.= '<td class="KELZielBeschreibung TabContent'.$BereichID.'" ondblclick="readText(this)"> '.MyStringHTML($zeile['ZieleBeschreibung']).'</td>';
     


      $Inhalt.=  "</tr>";
      $Inhalt.= '<tr>';
      $Inhalt.=  "</tr>";
    }

}
$Inhalt.=  "</table>";			
$Inhalt.=  "</div>";	
  echo $Inhalt;
      // Define the JSON file path
      $jsonFilePath = 'JSON/VorlageKindNew.json';

      // Read existing data from the JSON file
      // $existingData = [];
      if (file_exists($jsonFilePath)) {
        // Overwrite the file by clearing its content
        file_put_contents($jsonFilePath, '');
        // $existingData = [];
      }
  
      // // Append the new data
      // $existingData[] = $zielData;
  
      // Write the updated data back to the JSON file
      file_put_contents($jsonFilePath, json_encode($existingData, JSON_PRETTY_PRINT));

}

// Lehrer Liste aus Datenbank laden
if ( isset($_GET['SetELDiBLehrer']) ){
  echo '<script>console.log("SetELDiBLehrer");</script>';
  $Inhalt =  '<div  id="ELDiBLehrerhead">';
  $Inhalt.=  '  <h1>ELDiB Bewertungsbogen Lehrer</h1>';
  $Inhalt.=  '<div ><button type="button" onclick="HideELDiBLehrer();" class="btn btn-primary btn-sm">zurück</button></div>';
  $Inhalt.=  '<div class="Schuelerdaten">';    
  $Inhalt.=  '<div>';
  $Inhalt.=  'Name : Name ';
  $Inhalt.=   '</div>';
  $Inhalt.=  '<div>';
  $Inhalt.=  'Name : Vorname ';
  $Inhalt.=   '</div>';
  $Inhalt.=  '<div>';
  $Inhalt.=  'Name : Klasse ';
  $Inhalt.=   '</div>';
  $Inhalt.=  '<div>';
  $Inhalt.=  'Name : Lehrer ';
  $Inhalt.=   '</div>';
  $Inhalt.=   '</div>';
  $Inhalt.=  '<div>';

  $Inhalt.= '</div>';
  $Inhalt.= '<div id="ELDiBLehrercontainer" class="tableFixHead">';
  $Inhalt.= '<table class="table table-bordered table-striped table-hover table-sm">';
  $Inhalt.= '<thead>';
  $Inhalt.= '<tr class="BeschreibungHead">';
  $Inhalt.= '<th class="KELZielBeschreibungHead">Beschreibung</th><th class="KELZielNummerHead">Bereich</th>'; 

  $Inhalt.= '</tr>';
  $Inhalt.= '</thead>';
//alle 4 Bereiche durchgehen
    // Ensure "details" array exists in the JSON structure
    $existingData['titel'] = 'Einschätzungsbogen Lehrer';
    $existingData['content'] = 'Inhalt des Dokuments.';
    $existingData['Vorname'] = 'Vorname';
    $existingData['Nachname'] = 'Name';
    $existingData['Klasse'] = 'Klasse';
    $existingData['Lehrer'] = 'Lehrer';

    if (!isset($existingData['details'])) {
      $existingData['details'] = [];
    }
for($BereichID = 1; $BereichID <=4; $BereichID++)
  {
  $Stufe = 0;

  $db_link = new mysqli($_SESSION["host_name"], $_SESSION["user_name"], $_SESSION["password"], $_SESSION["database"]);
  $sql = "SELECT * FROM zieleeldiblehrer WHERE BereichID = '".$BereichID."'";
  $db_erg = mysqli_query( $db_link, $sql );
  if ( ! $db_erg )
  {
    echo  'ungültige Bereich Abfrage Ziele: Error message: %s\n'. $db_link->error;
  }
  while ($zeile = mysqli_fetch_assoc( $db_erg))
    {
      //Stufe anzeigen
    if ($Stufe != $zeile['Stufe']){
      $Inhalt.= '<tr>';
    
      //Stufe Beschreibung
      $Inhalt.= '<td class="ZielStufe" >Stufe :'.$zeile['Stufe'];
      $db_link = new mysqli($_SESSION["host_name"], $_SESSION["user_name"], $_SESSION["password"], $_SESSION["database"]);
      $sqls = "SELECT * FROM stufenbeschreibungen WHERE BereichID = '1' AND Stufe = ".$zeile['Stufe']." ";
      $db_ergs = mysqli_query( $db_link, $sqls );
      if ( ! $db_ergs )
        {
          echo 'ungültige Bereich Abfrage Ziele: Error message: %s\n'. $db_link->error;
        }
        
        while ($zeiles = mysqli_fetch_assoc( $db_ergs))
        {
          $Inhalt.= '  '.MyStringHTML($zeiles['Beschreibung1']).'<br> '.MyStringHTML($zeiles['Beschreibung2']).'</td>';
              // Prepare data to write into JSON
          $zielData = [
            'Stufe' => $zeile['Stufe'],
            'BereichID' => $zeile['BereichID'],
            'ZieleNummer' => '',
            'ZieleStichwort' => 'Stufe :'.$zeile['Stufe'].' '.MyStringHTML($zeiles['Beschreibung1']).MyStringHTML($zeiles['Beschreibung2']),
            'ZieleBeschreibung' => '',
            'Notizen' => '',
            // 'newSelect0' => 'später'
          ];

          // Append the new data to the "details" array
          $existingData['details'][] = $zielData;
        }
        $Inhalt.=  "</tr>";
      $Stufe = $zeile['Stufe'];
    }
    // Beschreibung und Stichwort Ziele eintragem
    
    // Prepare data to write into JSON
    $zielData = [
      'Stufe' => $zeile['Stufe'],
      'BereichID' => $zeile['BereichID'],
      'ZieleNummer' => $zeile['ZieleNummer'],
      'ZieleStichwort' => $zeile['ZieleNummer'].' '.$zeile['ZieleStichwort'],
      'ZieleBeschreibung' => $zeile['ZieleBeschreibung'],
      'Notizen' => 'Notizen',
      'newSelect0' => 'später'
    ];



    // Append the new data to the "details" array
    $existingData['details'][] = $zielData;



    // Generate the table cell
    $Inhalt.= '<td class="KELZielNummer TabContent'.$BereichID.'" ondblclick="readText(this)">'.$zeile['ZieleNummer'].' '.MyStringHTML($zeile['ZieleStichwort']).'</td>';
    $Inhalt.= '<td class="KELZielBeschreibung TabContent'.$BereichID.'" ondblclick="readText(this)"> '.MyStringHTML($zeile['ZieleBeschreibung']).'</td>';
     


      $Inhalt.=  "</tr>";
      $Inhalt.= '<tr>';
      $Inhalt.=  "</tr>";
    }

}
$Inhalt.=  "</table>";			
$Inhalt.=  "</div>";	
  echo $Inhalt;
      // Define the JSON file path
      $jsonFilePath = 'JSON/VorlageLehrerNew.json';

      // Read existing data from the JSON file
      // $existingData = [];
      if (file_exists($jsonFilePath)) {
        // Overwrite the file by clearing its content
        file_put_contents($jsonFilePath, '');
        // $existingData = [];
      }
  
      // // Append the new data
      // $existingData[] = $zielData;
  
      // Write the updated data back to the JSON file
      file_put_contents($jsonFilePath, json_encode($existingData, JSON_PRETTY_PRINT));

}

if ( isset($_GET['SetNewColumn']) ){
  $_SESSION['NewColumn'] = 1;
}

function CreateJSONFile($filename)
{
  $fp = fopen($filename, 'w');
  fwrite($fp, json_encode($_SESSION['data']));  // here it will print the array pretty
  fclose($fp);
}
function ReadJSONFile($filename)
{
  $_SESSION['data'] = file_get_contents($filename);
  return json_decode($_SESSION['data'], true);
}

// function SaveJSONFile($filename, $_SESSION['data'])
if ( isset($_GET['SaveJSONFile']) ){
  $filename = $_GET['filename'];
  $filename = 'A_DateiEltern.json';
  $_SESSION['data'] = json_decode(file_get_contents('php://input'), true);
  echo '<textarea id="fileContent" style="display:none;"><?php echo $jsonData; ?></textarea>';
  if (json_last_error() === JSON_ERROR_NONE) {
    if (file_put_contents($filename, json_encode($_SESSION['data'], JSON_PRETTY_PRINT))) {
      echo "Die JSON-Datei wurde erfolgreich gespeichert.";
    } else {
      echo "Fehler beim Speichern der JSON-Datei.";
    }
  } else {
    echo "Ungültige JSON-Daten.";
  }
}

// leeres Blatte erzeugen aus JSON
if ( isset($_GET['ELDiBLehrerNew']) ){
  $filename = "JSON/FirstTemplateEltern.json";
  $jsonContent = file_get_contents($filename);
  $_SESSION['data'] = json_decode($jsonContent, true);
    //       echo '<pre>';
    // print_r($_SESSION['data']);
    // echo '</pre>';
} 

// Erstelle Vorlage - Stufendaten aus Datenbank laden aus JSON
if ( isset($_GET['ELDiBLehrerFirstTemplate']) ){
  $filename = "JSON/VorlageEltern.json";
  $jsonContent = file_get_contents($filename);
  $_SESSION['data'] = json_decode($jsonContent, true);
    //       echo '<pre>';
    // print_r($_SESSION['data']);
    // echo '</pre>';
} 


// if ( isset($_GET['ReadHeadData']) ){
//   $Inhalt = '';
// $Inhalt.= $_SESSION['data']['Vorname'];
// $Inhalt.= $_SESSION['data']['Nachname'];
// $Inhalt.=$_SESSION['data']['Klasse'];
// $Inhalt.=$_SESSION['data']['Lehrer'];
// echo $Inhalt;

// }

//Seitenansicht erstellen aus JSON-Templatedatei
if ( isset($_GET['SetELDiBLehrerJSON'])){
    $Inhalt = '';
    $filename = $_GET['Filename'];
    $_SESSION['ActFilename'] = $filename;
    $NewColumn = $_GET['NewColumn'];
    // echo '<pre>';
    // print_r($_SESSION['data']);
    // echo '</pre>';
    $Inhalt.= '<textarea id="actfilename" style="display:none;">'.$filename.'</textarea>';

    $ValuesArray = array("Key");
    $ArrayCounter = 1;
    $ValueCounter = 1;
    $ValueSum = 0;

    $Inhalt.= '<div id="ELDiBLehrercontainer" class="tableFixHead overflow-auto">';
    $Inhalt.= '<table class="table table-bordered table-striped table-hover table-sm">';
    $Inhalt.= '<thead>';
    $Inhalt.= '<tr class="BeschreibungHead">';
    $Inhalt.= '<th id="HeadBereich" class="KELZielBeschreibungHead">'.$_SESSION['data']['Head'][0]['BereichID'].'</th>
    <th id="HeadBeschreibung" class="KELZielNummerHead">'.$_SESSION['data']['Head'][0]['ZieleBeschreibung'].'</th>';

    // foreach ($_SESSION['data']['details'][0]['Datum'] as $datum => $value) {
    //   $Inhalt .= '<th>' . $datum . ' + '.$value.' </th>';
    // }
    $DatumNummer = 1;
    foreach ($_SESSION['data']['Head'][0]['Datum'] as $datum) {
     
      $Inhalt .= '<th id="HeadDatum_'.$DatumNummer.'">' . $datum . '</th>';
      $DatumNummer = $DatumNummer + 1;
      // $Inhalt .= '<th>' . $datum . ' (' . implode(", ", array_keys($_SESSION['data']['details'][0]['Datum'], $datum)) . ')</th>';
    }
    // if ($_SESSION['NewColumn'] == 1){
    //   $Inhalt.= '<th id="HeadDatum_'.$DatumNummer.'" class="KELZielNummerHead">'.date('Y-m-d').'</th>';
    // }
    //      foreach($_SESSION['data']['details'][0]['Datum'] as $Datum){
    //     $Inhalt.= '<th>'.$Datum['Daten'].'</th>'; 
    // }
    // $Inhalt.= '<th>'.$_SESSION['data']['details'][0]['Datum'][0]['Daten'].'</th>';
    $Inhalt.= '</tr>';
    $Inhalt.= '</thead>';
    $ArrayCounter = -1;

    $Stufe = "Stufe";
    foreach($_SESSION['data']['details'] as $ziele)
      {
          //Stufe anzeigen
          $ArrayCounter = $ArrayCounter + 1;
          //Stufe anzeigen
        // if ($Stufe != $ziele['Stufe'] and  $NewColumn == true){

        //   $Inhalt.= '<tr>';
        //   // if ($Stufe != "Stufe"){
        //     //Stufe Beschreibung
        //     $Inhalt.= '<td id="ZieleStichwort_'.$ArrayCounter.'" class="ZielStufe" >Stufe :'.intval($ziele['Stufe']);
        //     $db_link = new mysqli($_SESSION["host_name"], $_SESSION["user_name"], $_SESSION["password"], $_SESSION["database"]);
        //     $sqls = "SELECT * FROM stufenbeschreibungen WHERE BereichID = ".$ziele['BereichID']." AND Stufe = ".$ziele['Stufe']." ";
        //     $db_ergs = mysqli_query( $db_link, $sqls );
        //     if ( ! $db_ergs )
        //       {
        //         echo 'ungültige Bereich Abfrage Ziele: Error message: %s\n'. $db_link->error;
        //       }
              
        //       while ($zeiles = mysqli_fetch_assoc( $db_ergs))
        //       {
        //         $Inhalt.= '  '.MyStringHTML($zeiles['Beschreibung1']).'<br> '.MyStringHTML($zeiles['Beschreibung2']).'</td>';
        //       }
        //       $Inhalt.= '<td id="Stufe_'.$ArrayCounter.'" style="display: none;">'.$ziele['Stufe'].'</td>';
        //       $Inhalt.= '<td id="BereichID_'.$ArrayCounter.'" style="display: none;">'.$ziele['BereichID'].'</td>';

        //       $Inhalt.=  "</tr>";

        //       $ArrayCounter = $ArrayCounter + 1;
        //     // }
        //   $Stufe = $ziele['Stufe'];
        // }
        // if ($Stufe != "Stufe"){
        // Beschreibung und Stichwort Ziele eintragem
        $Inhalt.=  "<tr>";
        $Inhalt.= '<td id="Stufe_'.$ArrayCounter.'" style="display: none;">'.$ziele['Stufe'].'</td>';
        $Inhalt.= '<td id="BereichID_'.$ArrayCounter.'" style="display: none;">'.$ziele['BereichID'].'</td>';
        if($ziele['ZieleNummer'] ==""){
          $Inhalt.= '<td id="ZieleStichwort_'.$ArrayCounter.'" class="ZielStufe" ondblclick="readText(this)">'.$ziele['ZieleNummer'].' '.MyStringHTML($ziele['ZieleStichwort']).'</td>';
        }
        else{
        $Inhalt.= '<td id="ZieleStichwort_'.$ArrayCounter.'" class="KELZielNummer TabContent'.$ziele['BereichID'].'" ondblclick="readText(this)">'.$ziele['ZieleNummer'].' '.MyStringHTML($ziele['ZieleStichwort']).'</td>';
        }
        $Inhalt.= '<td id="ZieleNummer_'.$ArrayCounter.'"style="display:none;">'.MyStringHTML($ziele['ZieleNummer']).'</td>';
        $Inhalt.= '<td id="ZieleStichwort_'.$ArrayCounter.'"style="display:none;">'.MyStringHTML($ziele['ZieleStichwort']).'</td>';

        if($ziele['ZieleNummer'] ==""){
        $Inhalt.= '<td id="ZieleBeschreibung_'.$ArrayCounter.'" class="ZielStufe" ondblclick="readText(this)"> '.MyStringHTML($ziele['ZieleBeschreibung']).'</td>';
        }
        else{
          $Inhalt.= '<td id="ZieleBeschreibung_'.$ArrayCounter.'" class="KELZielBeschreibung TabContent'.$ziele['BereichID'].'" ondblclick="readText(this)"> '.MyStringHTML($ziele['ZieleBeschreibung']).'</td>';
        }
        //wenn Datum eingetragen ist dann in nächste Spalte rücken
        $DatumBelegt = 1;
        if($ziele['ZieleNummer'] !=""){
        foreach($ziele['Datum'] as $daten){
          $Inhalt.= '<td >
          <label for="Auswahl"> </label>
            <select class="form-select" name="Auswahl" id="Selected_'.$ArrayCounter.'" onchange="getSelectedOption('.$ArrayCounter.');">';

            $selected = (implode(", ", $ziele['Datum']) == 'später') ? 'selected' : '';
            $Inhalt.= "<option class=\"option3\" value=\"später\" $selected>später</option>";

            $selected = (implode(", ", $ziele['Datum']) == 'übt es jetzt') ? 'selected' : '';
            $Inhalt.= "<option class=\"option3\" value=\"übt es jetzt\" $selected>übt es jetzt</option>";

            $selected = (implode(", ", $ziele['Datum']) == 'kann das Kind') ? 'selected' : '';
            $Inhalt.= "<option class=\"option3\" value=\"kann das Kind\" $selected>kann das Kind</option>";          
          $Inhalt.= '</select>
            <p id="output_'.$ArrayCounter.'" style="display:none;">'.implode(", ", $ziele['Datum']).'</p>
          </td>';        
        }
      }
        // leere Spalte ##################################################################
        // if ($_SESSION['NewColumn'] == 1){
        // $Inhalt.= '<td >
        // <label for="Auswahl"> </label>
        // <select class="form-select" name="Auswahl" id="Selected_'.$ArrayCounter.'" onchange="getSelectedOption('.$ArrayCounter.');">';

        //   $Inhalt.= '<option class="option1 " value="später" >später</option>';

        //   $Inhalt.= '<option class="option2" value="übt es jetzt">Übt es jetzt</option>';


        //     $Inhalt.= '<option class="option3" value="kann das Kind" >Kann das Kind</option>';
        // // } <p style="display: none;" id="output_'.$ArrayCounter.'"></p>
        // $Inhalt.= '</select>
        // <p id="output_'.$ArrayCounter.'"></p>
        // </td>';        
        // }
        //###############################################################################
        $Inhalt.=  "</tr>";
        $Inhalt.=  "<tr>";
        $Inhalt.= '<td  class="KELZielNotizen TabContent'.$ziele['BereichID'].'" colspan="6"><textarea id="Notizen_'.$ArrayCounter.'" name="Notizen" id="Notizen_'.$ArrayCounter.'" style="width: 100%; resize: none; overflow: hidden;" rows="1" oninput="autoResize(this);" onchange="saveNotizen('.$ArrayCounter.');">'.$ziele['Notizen'].'</textarea></td>';
        $Inhalt.=  "</tr>";
        // }
    $_SESSION['LehrerArrayCounter'] = $ArrayCounter;

    
    }
    $Inhalt.=  "</table>";			
    $Inhalt.=  "</div>";	
    $Inhalt.= '<button class="btn-primary m-1" type="button" onclick="PrintLehrerHTML();">Print Lehrer HTML</button>';
    $Inhalt.= '<button class="btn-primary m-1" type="button" onclick="PrintLehrer('.$ArrayCounter.');">Print Lehrer</button>';
    // $Inhalt.= '<button type="button" onclick="createJSONTemplateFileJS('.$JSONOutputFile.');">Create JSON File</button>';
    // $Inhalt.= '<button class="btn-primary m-1" type="button" onclick="createJSONTemplateFileJS();">Create JSON File</button>';
    $Inhalt.= '<button class="btn-primary m-1" type="button" onclick="saveJSON('.$ArrayCounter.');">Speichern</button>';
    $Inhalt.= '<button class="btn-primary m-1" type="button" onclick="setNewColumn();">Neue Bewertung</button>';
    // $Inhalt.= '<button class="btn-primary m-1" type="button" onclick="();">Datei speichern</button>';
    // $Inhalt.= '<button class="btn-primary m-1" type="button" onclick="downloadSessionData();">Daten herunterladen</button>';
  

      echo $Inhalt;
}


//Seitenansicht erstellen aus JSON-Templatedatei Stufendaten aus Datenbank
if ( isset($_GET['SetELDiBLehrerJSONFirstTemplate']))
  {
  $Inhalt = '';
  $filename = $_GET['Filename'];
  $_SESSION['ActFilename'] = $filename;
  $NewColumn = $_GET['NewColumn'];
    // echo '<pre>';
    // print_r($_SESSION['data']);
    // echo '</pre>';
    $Inhalt.= '<textarea id="actfilename" style="display:none;">'.$filename.'</textarea>';

    $ValuesArray = array("Key");
    $ArrayCounter = 1;
    $ValueCounter = 1;
    $ValueSum = 0;

    $Inhalt.= '<div id="ELDiBLehrercontainer" class="tableFixHead overflow-auto">';
    $Inhalt.= '<table class="table table-bordered table-striped table-hover table-sm">';
    $Inhalt.= '<thead>';
    $Inhalt.= '<tr class="BeschreibungHead">';
    $Inhalt.= '<th id="HeadBereich" class="KELZielBeschreibungHead">'.$_SESSION['data']['Head'][0]['BereichID'].'</th>
    <th id="HeadBeschreibung" class="KELZielNummerHead">'.$_SESSION['data']['Head'][0]['ZieleBeschreibung'].'</th>';

    // foreach ($_SESSION['data']['details'][0]['Datum'] as $datum => $value) {
    //   $Inhalt .= '<th>' . $datum . ' + '.$value.' </th>';
    // }
    $DatumNummer = 1;
    foreach ($_SESSION['data']['Head'][0]['Datum'] as $datum) {
     
      $Inhalt .= '<th id="HeadDatum_'.$DatumNummer.'">' . $datum . '</th>';
      $DatumNummer = $DatumNummer + 1;
      // $Inhalt .= '<th>' . $datum . ' (' . implode(", ", array_keys($_SESSION['data']['details'][0]['Datum'], $datum)) . ')</th>';
  }
  // if ($_SESSION['NewColumn'] == 1){
  //   $Inhalt.= '<th id="HeadDatum_'.$DatumNummer.'" class="KELZielNummerHead">'.date('Y-m-d').'</th>';
  // }
  //      foreach($_SESSION['data']['details'][0]['Datum'] as $Datum){
  //     $Inhalt.= '<th>'.$Datum['Daten'].'</th>'; 
  // }
    // $Inhalt.= '<th>'.$_SESSION['data']['details'][0]['Datum'][0]['Daten'].'</th>';
    $Inhalt.= '</tr>';
    $Inhalt.= '</thead>';
    $ArrayCounter = -1;

  $Stufe = "Stufe";
  foreach($_SESSION['data']['details'] as $ziele)
    {
        //Stufe anzeigen
          $ArrayCounter = $ArrayCounter + 1;
          //Stufe anzeigen
        if ($Stufe != $ziele['Stufe'] and  $NewColumn == true){

          $Inhalt.= '<tr>';
          // if ($Stufe != "Stufe"){
            //Stufe Beschreibung
            $Inhalt.= '<td id="ZieleStichwort_'.$ArrayCounter.'" class="ZielStufe" >Stufe :'.intval($ziele['Stufe']);
            $db_link = new mysqli($_SESSION["host_name"], $_SESSION["user_name"], $_SESSION["password"], $_SESSION["database"]);
            $sqls = "SELECT * FROM stufenbeschreibungen WHERE BereichID = ".$ziele['BereichID']." AND Stufe = ".$ziele['Stufe']." ";
            $db_ergs = mysqli_query( $db_link, $sqls );
            if ( ! $db_ergs )
              {
                echo 'ungültige Bereich Abfrage Ziele: Error message: %s\n'. $db_link->error;
              }
              
              while ($zeiles = mysqli_fetch_assoc( $db_ergs))
              {
                $Inhalt.= '  '.MyStringHTML($zeiles['Beschreibung1']).'<br> '.MyStringHTML($zeiles['Beschreibung2']).'</td>';
              }
              $Inhalt.= '<td id="Stufe_'.$ArrayCounter.'" style="display: none;">'.$ziele['Stufe'].'</td>';
              $Inhalt.= '<td id="BereichID_'.$ArrayCounter.'" style="display: none;">'.$ziele['BereichID'].'</td>';
              
              $Inhalt.=  "</tr>";
              $ArrayCounter = $ArrayCounter + 1;
            // }
          $Stufe = $ziele['Stufe'];
        }
        if ($Stufe != "Stufe"){
        // Beschreibung und Stichwort Ziele eintragem
        $Inhalt.=  "<tr>";
        $Inhalt.= '<td id="Stufe_'.$ArrayCounter.'" style="display: none;">'.$ziele['Stufe'].'</td>';
        $Inhalt.= '<td id="BereichID_'.$ArrayCounter.'" style="display: none;">'.$ziele['BereichID'].'</td>';
        $Inhalt.= '<td id="ZieleStichwort_'.$ArrayCounter.'" class="KELZielNummer TabContent'.$ziele['BereichID'].'" ondblclick="readText(this)">'.$ziele['ZieleNummer'].' '.MyStringHTML($ziele['ZieleStichwort']).'</td>';
        $Inhalt.= '<td id="ZieleNummer_'.$ArrayCounter.'"style="display:none;">'.MyStringHTML($ziele['ZieleNummer']).'</td>';
        $Inhalt.= '<td id="ZieleStichwort_'.$ArrayCounter.'"style="display:none;">'.MyStringHTML($ziele['ZieleStichwort']).'</td>';
        $Inhalt.= '<td id="ZieleBeschreibung_'.$ArrayCounter.'" class="KELZielBeschreibung TabContent'.$ziele['BereichID'].'" ondblclick="readText(this)"> '.MyStringHTML($ziele['ZieleBeschreibung']).'</td>';
        //wenn Datum eingetragen ist dann in nächste Spalte rücken
        $DatumBelegt = 1;
        foreach($ziele['Datum'] as $daten){
          $Inhalt.= '<td >
          <label for="Auswahl"> </label>
            <select class="form-select" name="Auswahl" id="Selected_'.$ArrayCounter.'" onchange="getSelectedOption('.$ArrayCounter.');">';

            $selected = (implode(", ", $ziele['Datum']) == 'später') ? 'selected' : '';
            $Inhalt.= "<option class=\"option3\" value=\"später\" $selected>später</option>";

            $selected = (implode(", ", $ziele['Datum']) == 'übt es jetzt') ? 'selected' : '';
            $Inhalt.= "<option class=\"option3\" value=\"übt es jetzt\" $selected>übt es jetzt</option>";

            $selected = (implode(", ", $ziele['Datum']) == 'kann das Kind') ? 'selected' : '';
            $Inhalt.= "<option class=\"option3\" value=\"kann das Kind\" $selected>kann das Kind</option>";          
          $Inhalt.= '</select>
            <p id="output_'.$ArrayCounter.'" style="display:none;">'.implode(", ", $ziele['Datum']).'</p>
          </td>';        
        }
        // leere Spalte ##################################################################
        // if ($_SESSION['NewColumn'] == 1){
        // $Inhalt.= '<td >
        // <label for="Auswahl"> </label>
        // <select class="form-select" name="Auswahl" id="Selected_'.$ArrayCounter.'" onchange="getSelectedOption('.$ArrayCounter.');">';

        //   $Inhalt.= '<option class="option1 " value="später" >später</option>';

        //   $Inhalt.= '<option class="option2" value="übt es jetzt">Übt es jetzt</option>';


        //     $Inhalt.= '<option class="option3" value="kann das Kind" >Kann das Kind</option>';
        // // } <p style="display: none;" id="output_'.$ArrayCounter.'"></p>
        // $Inhalt.= '</select>
        // <p id="output_'.$ArrayCounter.'"></p>
        // </td>';        
        // }
        //###############################################################################
        $Inhalt.=  "</tr>";
        $Inhalt.=  "<tr>";
        $Inhalt.= '<td  class="KELZielNotizen TabContent'.$ziele['BereichID'].'" colspan="6"><textarea id="Notizen_'.$ArrayCounter.'" name="Notizen" id="Notizen_'.$ArrayCounter.'" style="width: 100%; resize: none; overflow: hidden;" rows="1" oninput="autoResize(this);" onchange="saveNotizen('.$ArrayCounter.');">'.$ziele['Notizen'].'</textarea></td>';
        $Inhalt.=  "</tr>";
        }
    $_SESSION['LehrerArrayCounter'] = $ArrayCounter;

    
  }
  $Inhalt.=  "</table>";			
  $Inhalt.=  "</div>";	
  $Inhalt.= '<button class="btn-primary m-1" type="button" onclick="PrintLehrerHTML();">Print Lehrer HTML</button>';
  $Inhalt.= '<button class="btn-primary m-1" type="button" onclick="PrintLehrer('.$ArrayCounter.');">Print Lehrer</button>';
  // $Inhalt.= '<button type="button" onclick="createJSONTemplateFileJS('.$JSONOutputFile.');">Create JSON File</button>';
  // $Inhalt.= '<button class="btn-primary m-1" type="button" onclick="createJSONTemplateFileJS();">Create JSON File</button>';
  $Inhalt.= '<button class="btn-primary m-1" type="button" onclick="saveJSON('.$ArrayCounter.');">Speichern</button>';
  $Inhalt.= '<button class="btn-primary m-1" type="button" onclick="setNewColumn();">Neue Bewertung</button>';
  // $Inhalt.= '<button class="btn-primary m-1" type="button" onclick="();">Datei speichern</button>';
  // $Inhalt.= '<button class="btn-primary m-1" type="button" onclick="downloadSessionData();">Daten herunterladen</button>';
  

      echo $Inhalt;
}



















// //   //CreateNewTable neuen Abfragebogen erstellen
// if ( isset($_GET['CreateNewTableELDiBLehrer']) ){
//   include_once("content/db.php");
//   $host_name = $_SESSION["host_name"]; 
//   $database = $_SESSION["database"]; 
//   $user_name = $_SESSION["user_name"]; 
//   $password = $_SESSION["password"];
//   $DataDetailsID = 0;

//   //Abfrage ob schom ein Eintrag in eldibdatalehrer besteht
//   if ($_SESSION['LocalChat'] == true){
//     $db_linkExist = new mysqli($_SESSION["host_nameSchool"], $_SESSION["user_nameSchool"], $_SESSION["passwordSchool"], $_SESSION["databaseSchool"]);
//   }
//   else{
//   $db_linkExist = new mysqli($_SESSION["host_name"], $_SESSION["user_name"], $_SESSION["password"], $_SESSION["database"]);
//   }
//   $sqlExist = "SELECT * FROM `eldibdatalehrer` ";
//   $db_ergExist = mysqli_query( $db_linkExist, $sqlExist );
//   if ( ! $db_ergExist )
//   {
//     echo  'ungültige CreateNewTableELDiBLehrer: Error message: %s\n'. $db_linkExist->error;
//   }
//   $LehrerExist = 0;
//   while ($zeileExist = mysqli_fetch_assoc( $db_ergExist))
//   {
//     $LehrerExist = 1;
//   }
//   if($LehrerExist > 0){
//     //INSERT INTO `eldibdatalehrer` (`id`, `idClient`, `Status`, `CreationTime`, `OperatorReadWrite`, `OperatorReadonly`, `Änderung`) VALUES (NULL, '99', '0', current_timestamp(), '', '', current_timestamp())
//     if ($_SESSION['LocalChat'] == true){
//       $db_linkNewOp = new mysqli($_SESSION["host_nameSchool"], $_SESSION["user_nameSchool"], $_SESSION["passwordSchool"], $_SESSION["databaseSchool"]);
//     }
//     else{
//     $db_linkNewOp = new mysqli($_SESSION["host_name"], $_SESSION["user_name"], $_SESSION["password"], $_SESSION["database"]);
//     }
//     $sqlNewOp = "INSERT INTO `eldibdatalehrer` (`id`, `idClient`, `Status`)VALUES (NULL, '".$_GET['CreateNewTableELDiBLehrer']."', '0')";
//     $db_ergNewOp = mysqli_query( $db_linkNewOp, $sqlNewOp );
//     if ( ! $db_ergNewOp )
//     {
//       echo  'ungültige CreateNewTableELDiBLehrer insert new Lehrer: Error message: %s\n'. $db_linkNewOp->error;
//     }
//     $LastId = $db_linkNewOp->insert_id;

//   }
//   //Data Details Tabelle anlegen


//   //Alle Bereiche anlegen
//   $BereichID = 1;
//   if ($_SESSION['LocalChat'] == true){
//     $db_linkData = new mysqli($_SESSION["host_nameSchool"], $_SESSION["user_nameSchool"], $_SESSION["passwordSchool"], $_SESSION["databaseSchool"]);
//   }
//   else{
//   $db_linkData = new mysqli($_SESSION["host_name"], $_SESSION["user_name"], $_SESSION["password"], $_SESSION["database"]);
//   }
//   for($BereichID=1;$BereichID<=4;$BereichID++){

//     $db_link = new mysqli($_SESSION["host_name"], $_SESSION["user_name"], $_SESSION["password"], $_SESSION["database"]);

//     $sql = "SELECT * FROM zieleeldiblehrer WHERE BereichID = '".$BereichID."'";
//     $db_erg = mysqli_query( $db_link, $sql );
//     if ( ! $db_erg )
//       {
//         echo  'ungültige zieleeldibLehrer: %s\n'. $db_link->error ;
//       }
//     while ($zeileData = mysqli_fetch_assoc( $db_erg))
//     {
//       $sqlData = "INSERT INTO `eldibdatadetailslehrer` (`id`, `idData`,`idDatas`, `idZiele`, `Value`,`stichwort`) VALUES (NULL, '".$_GET['CreateNewTableELDiBLehrer']."', '".$LastId."', '".$zeileData['id']."', '0',' ')";
//       $db_ergData = mysqli_query( $db_linkData, $sqlData );
//       if ( ! $db_ergData )
//       {
//         echo  'ungültige eldibdatadetailslehrer'. $db_linkData->error;
//       }

//     }
//     //Status Tabelle angelegt eintragen
//     if ($_SESSION['LocalChat'] == true){
//       $db_link = new mysqli($_SESSION["host_nameSchool"], $_SESSION["user_nameSchool"], $_SESSION["passwordSchool"], $_SESSION["databaseSchool"]);
//     }
//     else{
//       $db_link = new mysqli($_SESSION["host_name"], $_SESSION["user_name"], $_SESSION["password"], $_SESSION["database"]);
//     }
//     $sql = "UPDATE `eldibdatalehrer` SET `Status` = '1' WHERE `eldibdatalehrer`.`idClient` = ".$_GET['CreateNewTableELDiBLehrer']."";
//     $db_erg = mysqli_query( $db_link, $sql );
//     if ( ! $db_erg )
//     {
//       echo  'ungültige CreateNewTableELDiBLehrer: Error message: %s\n'. $db_link->error;
//     }
//     //id ermitteln
//     if ($_SESSION['LocalChat'] == true){
//       $db_linkReq = new mysqli($_SESSION["host_nameSchool"], $_SESSION["user_nameSchool"], $_SESSION["passwordSchool"], $_SESSION["databaseSchool"]);
//     }
//     else{
//       $db_linkReq = new mysqli($_SESSION["host_name"], $_SESSION["user_name"], $_SESSION["password"], $_SESSION["database"]);
//     }
//     $sql = "SELECT * FROM `eldibdatalehrer` WHERE `idClient`=".$_GET['CreateNewTableELDiBLehrer']."";
//     $db_erg = mysqli_query( $db_linkReq, $sql );
//     if ( ! $db_erg )
//     {
//       echo  'ungültige CreateNewTableELDiBLehrer Status eintragen in eldibdatalehrer: Error message: %s\n'. $db_linkReq->error;
//     }
//   }
// }

// //Auswahlfeld Änderung eintragen
// if ( isset($_GET['ChangedSelectionELDiBLehrer']) ){
//   if ($_SESSION['LocalChat'] == true){
//     $db_link = new mysqli($_SESSION["host_nameSchool"], $_SESSION["user_nameSchool"], $_SESSION["passwordSchool"], $_SESSION["databaseSchool"]);
//   }
//   else{
//   $db_link = new mysqli($_SESSION["host_name"], $_SESSION["user_name"], $_SESSION["password"], $_SESSION["database"]);
//   }
//   $sql = "UPDATE `eldibdatadetailslehrer` SET `Value` = '".$_GET['Auswahl']."' WHERE `eldibdatadetailslehrer`.`idZiele` = ".$_GET['IdZiele']." AND `eldibdatadetailslehrer`.`idData` = ".$_GET['ChangedSelectionELDiBLehrer'].";";
//   $db_erg = mysqli_query( $db_link, $sql );
//   if ( ! $db_erg )
//   {
//     echo  'ungültige Bereich Abfrage Ziele: Error message: %s\n'. $db_link->error;
//   }

// }

// //stichwort Änderung eintragen
// if ( isset($_GET['ChangedKeywordELDiBLehrer']) ){
//   if ($_SESSION['LocalChat'] == true){
//     $db_link = new mysqli($_SESSION["host_nameSchool"], $_SESSION["user_nameSchool"], $_SESSION["passwordSchool"], $_SESSION["databaseSchool"]);
//   }
//   else{
//   $db_link = new mysqli($_SESSION["host_name"], $_SESSION["user_name"], $_SESSION["password"], $_SESSION["database"]);
//   }
//   $sql = "UPDATE `eldibdatadetailslehrer` SET `stichwort` = '".$_GET['Text']."' WHERE `eldibdatadetailslehrer`.`idZiele` = ".$_GET['IdZiele']." AND `eldibdatadetailslehrer`.`idData` = ".$_GET['ChangedKeywordELDiBLehrer'].";";
//   $db_erg = mysqli_query( $db_link, $sql );
//   if ( ! $db_erg )
//   {
//     echo  'ungültige Bereich Abfrage Ziele: Error message: %s\n'. $db_link->error;
//   }

// }

// //SaveTableELDiBLehrer
// if ( isset($_GET['SaveTableELDiBLehrer']) ){
//     //clienthistory Tabelle erstellen
//   //Ziele auslesen
//   // $Stichwort = " stichwort";
//   if ($_SESSION['LocalChat'] == true){
//     $db_linkZiel = new mysqli($_SESSION["host_nameSchool"], $_SESSION["user_nameSchool"], $_SESSION["passwordSchool"], $_SESSION["databaseSchool"]);
//   }
//   else{
//   $db_linkZiel = new mysqli($_SESSION["host_name"], $_SESSION["user_name"], $_SESSION["password"], $_SESSION["database"]);
//   }
//   // $position = "ChangeTime";
//   //Client eintragen
//   if ($_SESSION['LocalChat'] == true){
//     $db_linkChild = new mysqli($_SESSION["host_nameSchool"], $_SESSION["user_nameSchool"], $_SESSION["passwordSchool"], $_SESSION["databaseSchool"]);
//   }
//   else{
//   $db_linkChild = new mysqli($_SESSION["host_name"], $_SESSION["user_name"], $_SESSION["password"], $_SESSION["database"]);
//   }
//   $sqlChild = "INSERT INTO `clienthistoryeldiblehrer` (`id`,`idChild`) VALUES (NULL,'".$_GET['SaveTableELDiBLehrer']."')";
//   $db_ergChild = mysqli_query( $db_linkChild, $sqlChild );
//   if ( !$db_ergChild )
//   {
//     echo  'ungültige Bereich Abfrage Ziele: Error message: %s\n'. $db_linkChild->error;
//   }

//   $LastId = $db_linkChild->insert_id;

//   for($BereichID = 1; $BereichID <=4; $BereichID++){
//     if ($_SESSION['LocalChat'] == true){
//       $db_link = new mysqli($_SESSION["host_nameSchool"], $_SESSION["user_nameSchool"], $_SESSION["passwordSchool"], $_SESSION["databaseSchool"]);
//     }
//     else{
//     $db_link = new mysqli($_SESSION["host_name"], $_SESSION["user_name"], $_SESSION["password"], $_SESSION["database"]);
//     }
//     $sql = "SELECT * FROM eldibdatadetailslehrer WHERE idData = '".$_SESSION['ActualClient']."'";
//     $db_erg = mysqli_query( $db_link, $sql );
//     if ( !$db_erg )
//     {
//       echo  'ungültige Bereich Abfrage Ziele: Error message: %s\n'. $db_link->error;
//     }
//     while ($zeile = mysqli_fetch_assoc( $db_erg))
//       {

      
        
//       $sqlZiel = "UPDATE `clienthistoryeldiblehrer` SET `".$zeile['idZiele']."` = '".$zeile['Value']."', `".$zeile['idZiele'].$Stichwort."` = '".$zeile['stichwort']."'  WHERE `clienthistoryeldiblehrer`.`id` = ".$LastId."";
      
//       $db_ergZiel = mysqli_query( $db_linkZiel, $sqlZiel );
//       // $position = $zeile['ZieleNummer'];
//       if ( !$db_ergZiel )
//       {
//         echo  'ungültige Bereich Abfrage Ziele: Error message: %s\n'. $db_linkZiel->error;
//       }

//       }
      
//     }
//     //
//     //Status Tabelle angelegt austragen
//     if ($_SESSION['LocalChat'] == true){
//       $db_link = new mysqli($_SESSION["host_nameSchool"], $_SESSION["user_nameSchool"], $_SESSION["passwordSchool"], $_SESSION["databaseSchool"]);
//     }
//     else{
//     $db_link = new mysqli($_SESSION["host_name"], $_SESSION["user_name"], $_SESSION["password"], $_SESSION["database"]);
//     }
//     $sql = "UPDATE `eldibdatalehrer` SET `Status` = '0' WHERE `eldibdatalehrer`.`idClient` = ".$_GET['SaveTableELDiBLehrer']."";
//     $db_erg = mysqli_query( $db_link, $sql );
//     if ( ! $db_erg )
//     {
//       echo  'ungültige SaveTableELDiBLehrer Status 0 setzen: Error message: %s\n'. $db_link->error;
//     }
  
// }
?>
</body>
