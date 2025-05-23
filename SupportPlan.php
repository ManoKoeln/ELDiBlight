<script src="SupportPlan.js"></script>
<link href="CSS/style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" media="screen and (max-aspect-ratio: 4/3)" href="CSS/styleSmal.css" />
<div id="SupportPlan">
</div>
    <?php
    if (session_status() == PHP_SESSION_NONE) {
      session_start(); // Starten der Session nur, wenn keine Session aktiv ist
  }
    $SupportplanNotSaved = 1;
if ( isset($_GET['SetSupportPlan']) ){
    require "content/db.php";
    include "content/helpers.php";
    //Prüfen ob noch ein offener Supportplan besteht
    if ($SupportplanNotSaved < 2){
      if ($_SESSION['LocalChat'] == true){
        $db_link1 = new mysqli($_SESSION["host_nameSchool"], $_SESSION["user_nameSchool"], $_SESSION["passwordSchool"], $_SESSION["databaseSchool"]);
      }
      else{
      $db_link1 = new mysqli($_SESSION["host_name"], $_SESSION["user_name"], $_SESSION["password"], $_SESSION["database"]);
      }
      //INSERT INTO `supportplan`(`id`, `clientID`, `erstellt`, `geaendert`, `gespeichert`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]')
        $sql1 = "SELECT * FROM `supportplan` WHERE `clientID`= ".$_SESSION['ActualClient']." AND `gespeichert` = 0";
        $db_erg1 = mysqli_query( $db_link1, $sql1 );
        if ( ! $db_erg1 )
        {
          echo  'ungültige Bereich SetSupportPlan: Error message: %s\n'. $db_link1->error;
        }
        //$SupportplanNotSaved = 4;
        while ($zeile1 = mysqli_fetch_array($db_erg1, MYSQLI_ASSOC)) {
          if($zeile1['clientID'] > 0){
          $SupportplanNotSaved = 0;
          }
        }
      }


    $Inhalt ="";
    $Inhalt.= '<div class="HeadData">';
    if ($_SESSION['LocalChat'] == true){
      $db_link = new mysqli($_SESSION["host_nameSchool"], $_SESSION["user_nameSchool"], $_SESSION["passwordSchool"], $_SESSION["databaseSchool"]);
      }
    else{
      $db_link = new mysqli($_SESSION["host_name"], $_SESSION["user_name"], $_SESSION["password"], $_SESSION["database"]);
      }

    $sql = "SELECT * FROM client WHERE `id` =  ".$_SESSION['ActualClient']." ";
    $db_erg = mysqli_query( $db_link, $sql );
    if ( ! $db_erg )
      {
        $Inhalt = 'ungültige Bereich Abfrage Ziele: Error message: %s\n'. $db_link->error;
      }
    while ($zeile = mysqli_fetch_assoc( $db_erg))
    {
    
      $_SESSION['Name'] = $zeile['Name'] ;
      $_SESSION['Vorname'] = $zeile['Vorname'] ;
      $_SESSION['Geburtsdatum'] = $zeile['Geburtsdatum'] ;
      $_SESSION['email'] = $zeile['email'] ;
      $_SESSION['id'] = $zeile['id'] ;
      $Inhalt = "";
      $Inhalt.= '<div>';
      $Inhalt.= 'Name : ('.$zeile['id'].'),'.$zeile['Name'].', '.$zeile['Vorname'].' ';
      $Inhalt.=  '</div>';
      $Inhalt.= '<div>';
      $Inhalt.= 'Geburtsdatum : '.$zeile['Geburtsdatum'].' ';
      $Inhalt.=  '</div>';
      $Inhalt.= '<div>';
      $Inhalt.= 'email : '.$zeile['email'].' ';
      $Inhalt.=  '</div>';
      $Inhalt.= '<div>';
      $Inhalt.= 'Geburtsdatum : '.$zeile['Geburtsdatum'].' ';
      $Inhalt.=  '</div>';
      $Inhalt.= '<div>_____________________________________________</div>';
      $Inhalt.= '<div>';
      $Inhalt.= 'Eltern : '.$zeile['Parentvorname'].'  '.$zeile['Parentname'].'  ';
      $Inhalt.=  '</div>';
      $Inhalt.= '<div>';
      $Inhalt.= 'email Eltern : '.$zeile['Parentemail'].' ';
      $Inhalt.=  '</div>';
      $Inhalt.=  '<div><button typ="button" class="btn btn-primary btn-sm m-3" onclick="HideSupportPlan();">schliessen</button><button typ="button" class="btn btn-primary btn-sm" onclick="LoadELDiBTable();">Liste</button>';

       //SaveSupportPlanButton
       if ($SupportplanNotSaved == 0){
        $Inhalt.='<button typ="button" id="SaveSupportPlan"class="btn btn-primary btn-sm m-3" onclick="SaveSupportPlan('.$_GET['SetSupportPlan'].');">Förderplan speichern</button>';
        $Inhalt.='<button typ="button" id="CancelSupportPlan"class="btn btn-primary btn-sm m-3" onclick="CancelSupportPlan('.$_GET['SetSupportPlan'].');">Förderplan verwerfen</button>';
       }
       else if ($SupportplanNotSaved == 1){
        $Inhalt.='<button typ="button" id="NewSupportPlan" class="btn btn-primary btn-sm m-3" onclick="NewSupportPlan('.$_GET['SetSupportPlan'].');">neuen Förderplan erstellen</button>';
        $Inhalt.='<button typ="button" id="CreateSupportPlan" class="btn btn-primary btn-sm m-3" onclick="CreateSupportPlan('.$_GET['SetSupportPlan'].');">Förderplan automatisch erstellen</button>';
       }
       
        $Inhalt.='<button typ="button" id="CloseSelectSupportPlan"class="btn btn-primary btn-sm m-3" onclick="CloseSelectSupportPlan();">gespeicherten Förderplan schließen</button>';
       
       //gespeicherte Förderpläne
       $Inhalt.=  '<label for="SelectSupportPlan"> </label>';
       $Inhalt.=  '<select title="SelectSupportPlan" name="SelectSupportPlan" id="SelectSupportPlan" onchange="ChangedSelectionSupportPlan()">';
       $Inhalt.=  '<option class="optionSupportPlan" value=0>gespeicherten Förderplan auswählen</option>';

       //  Supportplan eintragen
       if ($_SESSION['LocalChat'] == true){
        $db_linkSaved = new mysqli($_SESSION["host_nameSchool"], $_SESSION["user_nameSchool"], $_SESSION["passwordSchool"], $_SESSION["databaseSchool"]);
      }
      else{
      $db_linkSaved = new mysqli($_SESSION["host_name"], $_SESSION["user_name"], $_SESSION["password"], $_SESSION["database"]);
      }
     
       $sqlSaved = "SELECT * FROM `supportplan` WHERE `clientID` = ".$_SESSION['ActualClient']." AND `gespeichert` > 0 ORDER BY `erstellt` DESC";
       $db_ergSaved = mysqli_query( $db_linkSaved, $sqlSaved );
       if ( ! $db_ergSaved )
       {
         $Inhalt = 'ungültige Bereich Abfrage client: Error message: %s\n'. $db_linkSaved->error;
       }
         while ($zeileSaved = mysqli_fetch_assoc( $db_ergSaved))
       {
         // echo '<option class="optionSupportPlan" value="'.$zeile['id'].'">('.$zeile['id'].'),'.$zeile['Name'].', '.$zeile['Vorname'].' - '.$zeile['Geburtsdatum'].'</option>';
         $Inhalt.= '<option class="optionSupportPlan" value="'.$zeileSaved['id'].'">'.$zeileSaved['geaendert'].'</option>';
       }

       $Inhalt.=  '</select>';
       //ENDE
       
      $Inhalt.=  '</div>';
      $Inhalt.=  '</div>';
      
    }

    
    //Inhalt
    //$Inhalt.=  '<div class="tableFixHead" id="ContentTableInhalt">';
    $Inhalt.=  '<div class="ContentTableInhalt tableFixHead" id="ContentTableInhalt">'; //ContentTableInhalt
    //$Inhalt.=  '<table class="tableFixHead">';

    $Inhalt.=  '<table class="table table-bordered table-striped table-hover table-sm ">';
    $Inhalt.=  '<thead>';
    $Inhalt.=  '<tr >';
    $Inhalt.=  '<th class="heading">Entwicklungsbereiche</th>'; //columnSupportHead1
    $Inhalt.=  '<th class="heading">Lernausgangslage</th>';
    $Inhalt.=  '<th class="heading">Formulierungen</th>';
    $Inhalt.=  '<th class="heading">Maßnahmen</th>';
    $Inhalt.=  '</tr>';
    $Inhalt.=  '</thead>';
    $Inhalt.=  '<tbody>';
    if ($_SESSION['LocalChat'] == true){
      $db_linkDat = new mysqli($_SESSION["host_nameSchool"], $_SESSION["user_nameSchool"], $_SESSION["passwordSchool"], $_SESSION["databaseSchool"]);
    }
    else{
    $db_linkDat = new mysqli($_SESSION["host_name"], $_SESSION["user_name"], $_SESSION["password"], $_SESSION["database"]);
    }
    $sqlDat = "SELECT  * FROM supportplanitems JOIN supportplan ON supportplanitems.`supportplanID`=supportplan.id WHERE supportplan.clientID = ".$_SESSION['ActualClient']." AND supportplan.gespeichert = 0 ";
    $db_ergDat = mysqli_query( $db_linkDat, $sqlDat );
    if ( ! $db_ergDat )
    {
      $Inhalt = 'ungültige Bereich supportplanitems: Error message: %s\n'. $db_linkDat->error;
    }
      while ($zeileDat = mysqli_fetch_assoc( $db_ergDat))
    {
 
    $Inhalt.=  '<tr >';
    $Inhalt.=  '<td class="columnSupport1 TabInhalt"><div  class="columnSupportTextarea" id="columnSupport1" >'.$zeileDat['Spalte1'].'</div></td>';
    $Inhalt.=  '<td class="columnSupport2 TabInhalt"><div class="columnSupportTextarea" id="columnSupport2" >'.$zeileDat['Spalte2'].'</div></td>';
    $Inhalt.=  '<td class="columnSupport3 TabInhalt"><div class="columnSupportTextarea" id="columnSupport3" >'.$zeileDat['Spalte3'].'</div></td>';
    $Inhalt.=  '<td class="columnSupport4 TabInhalt"><div class="columnSupportTextarea" id="columnSupport4" >'.$zeileDat['Spalte4'].'</div></td>';
    $Inhalt.=  '<td  class="TabInhalt"><button type="button" class="btn btn-primary btn-sm" onclick="DeleteSupportTextArea('.$zeileDat['idItem'].');">löschen</button></td>';
    $Inhalt.=  '</tr>';
    }
    if ($SupportplanNotSaved == 0){
      $Inhalt.=  '<tr  onclick="?ShowSupportPlanForm();" style="align-items: center;">';
      $Inhalt.=  '<td class="columnSupport1 TabEmpty" height:auto;><div onclick="?ShowSupportPlanForm();" class="columnSupportdiv" id="SupportPlanFormRow1" style="height: fit-content;"> </div></td>';
      $Inhalt.=  '<td class="columnSupport2 TabEmpty" height:auto;><div onclick="?ShowSupportPlanForm();" class="columnSupportdiv" id="SupportPlanFormRow2" style="height: fit-content;"> </div></td>';
      $Inhalt.=  '<td class="columnSupport3 TabEmpty" height:auto;><div contenteditable="true" onclick="?ShowSupportPlanForm();" class="columnSupportdiv" id="SupportPlanFormRow3" style="height: fit-content;"> </div></td>';
      $Inhalt.=  '<td class="columnSupport4 TabEmpty" height:auto;><div contenteditable="true" onclick="?ShowSupportPlanForm();" class="columnSupportdiv" id="SupportPlanFormRow4" style="height: fit-content;"> </div></td>';
      // $Inhalt.=  '<td class="columnSupport1 TabEmpty"><div onclick="?ShowSupportPlanForm();" class="columnSupportdiv" id="SupportPlanFormRow1"> </div></td>';
      // $Inhalt.=  '<td class="columnSupport2 TabEmpty"><div onclick="?ShowSupportPlanForm();" class="columnSupportdiv" id="SupportPlanFormRow2"> </div></td>';
      // $Inhalt.=  '<td class="columnSupport3 TabEmpty"><div contenteditable="true" onclick="?ShowSupportPlanForm();" class="columnSupportdiv" id="SupportPlanFormRow3" > </div></td>';
      // $Inhalt.=  '<td class="columnSupport4 TabEmpty"><div contenteditable="true" onclick="?ShowSupportPlanForm();" class="columnSupportdiv" id="SupportPlanFormRow4" > </div></td>';
      $Inhalt.=  '</tr>';
    }
    $Inhalt.=  '</tbody>';
    $Inhalt.=  '</table class="table table-bordered table-striped table-hover table-sm">';  

    $Inhalt.=  '</div>';
    $Inhalt.='<div style="text-align: center;"><button class="btn btn-primary btn-sm m-3" type="button" onclick="SaveSupportPlanFromData();" >übernehmen</button></div>';   
    // $Inhalt.='<div class="NewLineButtontd"><button typ="button" class="btn btn-primary btn-sm" onclick="NewLineSupportPlan('.$_GET['SetSupportPlan'].');">neue Zeile</button></div>';   

  echo $Inhalt;
}

if ( isset($_GET['TakeOverBereich']) ){
  include ("content/helpers.php");
      	//   Beschreibungen holen
	$db_link = new mysqli($_SESSION["host_name"], $_SESSION["user_name"], $_SESSION["password"] ,$_SESSION["database"]);
	// Bereich
	$sql = "SELECT * FROM bereich WHERE id = '".$_GET['TakeOverBereich']."'";
	$db_erg = mysqli_query( $db_link, $sql );
	if ( ! $db_erg )
	{
		$Inhalt =  'ungültige Bereich Abfrage Chat formulierungen: Error message: %s\n'. $db_link->error;
	}
	$myBereichText ="";
	while ($zeile = mysqli_fetch_array($db_erg, MYSQLI_ASSOC)) {		
		$myBereichText = MyStringHTML($zeile['Text']);		
	}
  ob_end_clean();
  echo $myBereichText;
    }

if ( isset($_GET['TakeOverZiele']) ){
  include ("content/helpers.php");
      	//   Beschreibungen holen
	$db_link = new mysqli($_SESSION["host_name"], $_SESSION["user_name"], $_SESSION["password"] ,$_SESSION["database"]);
  	// Ziele
	$sql = "SELECT * FROM ziele WHERE id = '".$_GET['TakeOverZiele']."'";
	$db_erg = mysqli_query( $db_link, $sql );
	if ( ! $db_erg )
	{
		$Inhalt =  'ungültige Bereich Abfrage Chat formulierungen: Error message: %s\n'. $db_link->error;
	}
  $myZieleNummer = "";
  $myZieleStichwort = "";
  $myZieleBeschreibung = "";
  $myBereichID = "";
	while ($zeile1 = mysqli_fetch_array($db_erg, MYSQLI_ASSOC)) {
    $myZieleNummer = $zeile1['ZieleNummer'];
    $myZieleStichwort = $zeile1['ZieleStichwort'];
    $myZieleBeschreibung = $zeile1['ZieleBeschreibung'];
    $myBereichID = $zeile1['BereichID'];		
		// $myBereichText = MyStringHTML($zeile1['Text']);		
	}
	// Bereich
	$sql = "SELECT * FROM bereich WHERE id = '".$myBereichID."'";
	$db_erg = mysqli_query( $db_link, $sql );
	if ( ! $db_erg )
	{
		$Inhalt =  'ungültige Bereich Abfrage Chat formulierungen: Error message: %s\n'. $db_link->error;
	}
	
	while ($zeile = mysqli_fetch_array($db_erg, MYSQLI_ASSOC)) {		
		$myBereichText = MyStringHTML($zeile['Text']);		
	}
  ob_end_clean();
  echo $myZieleNummer.' '.$myZieleStichwort.'

'.$myZieleBeschreibung;
}
if ( isset($_GET['TakeOverZieleBereich']) ){
  include ("content/helpers.php");
      	//   Beschreibungen holen
	$db_link = new mysqli($_SESSION["host_name"], $_SESSION["user_name"], $_SESSION["password"] ,$_SESSION["database"]);
  	// Ziele
	$sql = "SELECT * FROM ziele WHERE id = '".$_GET['TakeOverZieleBereich']."'";
	$db_erg = mysqli_query( $db_link, $sql );
	if ( ! $db_erg )
	{
		 echo  'ungültige Bereich Abfrage Chat formulierungen: Error message: %s\n'. $db_link->error;
	}
	$MyBereichID ="";
	while ($zeile1 = mysqli_fetch_array($db_erg, MYSQLI_ASSOC)) {
    $MyBereichID = MyStringHTML($zeile1['BereichID']);		
		// $myBereichText = MyStringHTML($zeile1['Text']);		
	}
	// // Bereich
	// $sql = "SELECT * FROM bereich WHERE id = '".$myBereichID."'";
	// $db_erg = mysqli_query( $db_link, $sql );
	// if ( ! $db_erg )
	// {
	// 	$Inhalt =  'ungültige Bereich Abfrage Chat formulierungen: Error message: %s\n'. $db_link->error;
	// }
	
	// while ($zeile = mysqli_fetch_array($db_erg, MYSQLI_ASSOC)) {		
	// 	$myBereichText = MyStringHTML($zeile['Text']);		
	// }
  ob_end_clean();
  echo $MyBereichID;
}
if ( isset($_GET['TakeOverFormulierungen']) ){
  include ("content/helpers.php");
      	//   Beschreibungen holen
        if ($_SESSION['LocalChat'] == true){
          $db_link = new mysqli($_SESSION["host_nameSchool"], $_SESSION["user_nameSchool"], $_SESSION["passwordSchool"], $_SESSION["databaseSchool"]);
        }
        else{
        $db_link = new mysqli($_SESSION["host_name"], $_SESSION["user_name"], $_SESSION["password"], $_SESSION["database"]);
        }
  	// Ziele
	$sql = "SELECT * FROM formulierungen WHERE id = '".$_GET['TakeOverFormulierungen']."'";
	$db_erg = mysqli_query( $db_link, $sql );
	if ( ! $db_erg )
	{
		$Inhalt =  'ungültige Bereich Abfrage Chat formulierungen: Error message: %s\n'. $db_link->error;
	}
	$MyFormulierungen = "";	
    $myZieleID = "";
	while ($zeile1 = mysqli_fetch_array($db_erg, MYSQLI_ASSOC)) {
    $MyFormulierungen = $zeile1['Text'];	
    $myZieleID = $zeile1['ZieleID'];
		// $myBereichText = MyStringHTML($zeile1['Text']);		
	}
  ob_end_clean();
  echo $MyFormulierungen;
}
if ( isset($_GET['TakeOverFormulierungenZiele']) ){
  include ("content/helpers.php");
      	//   Beschreibungen holen
        if ($_SESSION['LocalChat'] == true){
          $db_link = new mysqli($_SESSION["host_nameSchool"], $_SESSION["user_nameSchool"], $_SESSION["passwordSchool"], $_SESSION["databaseSchool"]);
        }
        else{
        $db_link = new mysqli($_SESSION["host_name"], $_SESSION["user_name"], $_SESSION["password"], $_SESSION["database"]);
        }
  	// Ziele
	$sql = "SELECT * FROM formulierungen WHERE id = '".$_GET['TakeOverFormulierungenZiele']."'";
	$db_erg = mysqli_query( $db_link, $sql );
	if ( ! $db_erg )
	{
		 echo  'ungültige Bereich Abfrage Chat formulierungen: Error message: %s\n'. $db_link->error;
	}
	$MyZieleID ="";
	while ($zeile1 = mysqli_fetch_array($db_erg, MYSQLI_ASSOC)) {
    $MyZieleID = MyStringHTML($zeile1['ZieleID']);		
		// $myBereichText = MyStringHTML($zeile1['Text']);		
	}
  ob_end_clean();
  echo $MyZieleID;
}
if ( isset($_GET['TakeOverMassnahmen']) ){
  include ("content/helpers.php");
      	//   Beschreibungen holen
        if ($_SESSION['LocalChat'] == true){
          $db_link = new mysqli($_SESSION["host_nameSchool"], $_SESSION["user_nameSchool"], $_SESSION["passwordSchool"], $_SESSION["databaseSchool"]);
        }
        else{
        $db_link = new mysqli($_SESSION["host_name"], $_SESSION["user_name"], $_SESSION["password"], $_SESSION["database"]);
        }
  	// Ziele
	$sql = "SELECT * FROM massnahmen WHERE id = '".$_GET['TakeOverMassnahmen']."'";
	$db_erg = mysqli_query( $db_link, $sql );
	if ( ! $db_erg )
	{
		$Inhalt =  'ungültige Bereich Abfrage Chat Massnahmen: Error message: %s\n'. $db_link->error;
	}
	$MyMassnahmen = "";	
	while ($zeile1 = mysqli_fetch_array($db_erg, MYSQLI_ASSOC)) {
    $MyMassnahmen = $zeile1['Text'];	
		// $myBereichText = MyStringHTML($zeile1['Text']);		
	}
  ob_end_clean();
  echo $MyMassnahmen;
}
if ( isset($_GET['TakeOverMassnahmenFormulierungen']) ){
  include ("content/helpers.php");
      	//   Beschreibungen holen
        if ($_SESSION['LocalChat'] == true){
          $db_link = new mysqli($_SESSION["host_nameSchool"], $_SESSION["user_nameSchool"], $_SESSION["passwordSchool"], $_SESSION["databaseSchool"]);
        }
        else{
        $db_link = new mysqli($_SESSION["host_name"], $_SESSION["user_name"], $_SESSION["password"], $_SESSION["database"]);
        }
  	// Ziele
	$sql = "SELECT * FROM massnahmen WHERE id = '".$_GET['TakeOverMassnahmenFormulierungen']."'";
	$db_erg = mysqli_query( $db_link, $sql );
	if ( ! $db_erg )
	{
		 echo  'ungültige Bereich Abfrage Chat Massnahmen: Error message: %s\n'. $db_link->error;
	}
	$MyZieleID ="";
	while ($zeile1 = mysqli_fetch_array($db_erg, MYSQLI_ASSOC)) {
    $MyZieleID = MyStringHTML($zeile1['FormulierungenID']);		
		// $myBereichText = MyStringHTML($zeile1['Text']);		
	}
  ob_end_clean();
  echo $MyZieleID;
}

//NewSupportPlan
if ( isset($_GET['NewSupportPlan']) ){
  // include ("content/helpers.php");
  if ($_SESSION['LocalChat'] == true){
    $db_link = new mysqli($_SESSION["host_nameSchool"], $_SESSION["user_nameSchool"], $_SESSION["passwordSchool"], $_SESSION["databaseSchool"]);
  }
  else{
  $db_link = new mysqli($_SESSION["host_name"], $_SESSION["user_name"], $_SESSION["password"], $_SESSION["database"]);
  }
 //INSERT INTO `supportplan`(`id`, `clientID`, `erstellt`, `geaendert`, `gespeichert`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]')
  $sql = "INSERT INTO `supportplan`(`id`, `clientID`) VALUES (NULL,'".$_GET['NewSupportPlan']."')";
	$db_erg = mysqli_query( $db_link, $sql );
	if ( ! $db_erg )
	{
		 echo  'ungültige Bereich NewSupportPlan: Error message: %s\n'. $db_link->error;
	}
}

//CreateSupportPlan
if ( isset($_GET['CreateSupportPlan']) ){
  // include ("content/helpers.php");
  if ($_SESSION['LocalChat'] == true){
    $db_link = new mysqli($_SESSION["host_nameSchool"], $_SESSION["user_nameSchool"], $_SESSION["passwordSchool"], $_SESSION["databaseSchool"]);
  }
  else{
  $db_link = new mysqli($_SESSION["host_name"], $_SESSION["user_name"], $_SESSION["password"], $_SESSION["database"]);
  }
 //INSERT INTO `supportplan`(`id`, `clientID`, `erstellt`, `geaendert`, `gespeichert`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]')
  $sql = "INSERT INTO `supportplan`(`id`, `clientID`) VALUES (NULL,'".$_GET['CreateSupportPlan']."')";
	$db_erg = mysqli_query( $db_link, $sql );
	if ( ! $db_erg )
	{
		 echo  'ungültige Bereich CreateSupportPlan: Error message: %s\n'. $db_link->error;
	}

  // Aufgaben:
  //1. ID der neuen Liste ermitteln*/
  $LastId = $db_link->insert_id;
  //2. neueste EldibLehrerListe des Clients suchen
  //SELECT * FROM eldibdatalehrer where idClient = 37 ORDER BY CreationTime DESC LIMIT 1
  $sql = "SELECT * FROM eldibdatalehrer where idClient = ".$_GET['CreateSupportPlan']." ORDER BY CreationTime DESC LIMIT 1";
  $db_erg = mysqli_query( $db_link, $sql );
	if ( ! $db_erg )
	{
		 echo  'ungültige Bereich CreateSupportPlan: Error message: %s\n'. $db_link->error;
	}
  while ($zeile = mysqli_fetch_array($db_erg, MYSQLI_ASSOC)) {
    $eldibDataLehrerID = $zeile['ID'];
  }
  //3.   in dieser Liste die Einträge "Übt es jetzt" heraussuchen und in SupportItems der erstellten Liste (siehe Punkt 1) eintragen 

}

if ( isset($_GET['SaveSupportPlan']) ){
  // include ("content/helpers.php");
  if ($_SESSION['LocalChat'] == true){
    $db_link = new mysqli($_SESSION["host_nameSchool"], $_SESSION["user_nameSchool"], $_SESSION["passwordSchool"], $_SESSION["databaseSchool"]);
  }
  else{
  $db_link = new mysqli($_SESSION["host_name"], $_SESSION["user_name"], $_SESSION["password"], $_SESSION["database"]);
  }
  //UPDATE `supportplan` SET `gespeichert` = '2' WHERE `supportplan`.`id` = 2
  // UPDATE `supportplan` SET `gespeichert` = '1' WHERE `supportplan`.`id` = ".$_GET['SaveSupportPlan']."
   $sql = "UPDATE `supportplan` SET `gespeichert` = '1' WHERE `supportplan`.`clientID` = ".$_GET['SaveSupportPlan']." AND `gespeichert` = '0'";
	$db_erg = mysqli_query( $db_link, $sql );
	if ( ! $db_erg )
	{
		 echo  'ungültige Bereich SaveSupportPlan: Error message: %s\n'. $db_link->error;
	}
	// $MyZieleID ="";
	// while ($zeile1 = mysqli_fetch_array($db_erg, MYSQLI_ASSOC)) {
  //   $MyZieleID = MyStringHTML($zeile1['FormulierungenID']);		
	// 	// $myBereichText = MyStringHTML($zeile1['Text']);		
	// }
  // ob_end_clean();
  // echo $MyZieleID;
}
//Cancel Supportplan
if ( isset($_GET['CancelSupportPlan']) ){
  // include ("content/helpers.php");
  if ($_SESSION['LocalChat'] == true){
    $db_link = new mysqli($_SESSION["host_nameSchool"], $_SESSION["user_nameSchool"], $_SESSION["passwordSchool"], $_SESSION["databaseSchool"]);
  }
  else{
  $db_link = new mysqli($_SESSION["host_name"], $_SESSION["user_name"], $_SESSION["password"], $_SESSION["database"]);
  }
   $sql = "DELETE FROM `supportplan` WHERE `supportplan`.`clientID` = ".$_GET['CancelSupportPlan']." AND `gespeichert` ='0' ";
	$db_erg = mysqli_query( $db_link, $sql );
	if ( ! $db_erg )
	{
		 echo  'ungültige Bereich CancelSupportPlan: Error message: %s\n'. $db_link->error;
	}
}
//NewLineSupportPlan
if ( isset($_GET['NewLineSupportPlan']) ){
  include ("content/helpers.php");
      	//   Beschreibungen holen
        if ($_SESSION['LocalChat'] == true){
          $db_link = new mysqli($_SESSION["host_nameSchool"], $_SESSION["user_nameSchool"], $_SESSION["passwordSchool"], $_SESSION["databaseSchool"]);
        }
        else{
        $db_link = new mysqli($_SESSION["host_name"], $_SESSION["user_name"], $_SESSION["password"], $_SESSION["database"]);
        }
 //UPDATE `supportplan` SET `clientID` = '37' WHERE `supportplan`.`id` = 1;
	// $sql = "SELECT * FROM massnahmen WHERE id = '".$_GET['TakeOverMassnahmenFormulierungen']."'";
  $sql = "SELECT * FROM massnahmen WHERE id = '".$_GET['TakeOverMassnahmenFormulierungen']."'";
	$db_erg = mysqli_query( $db_link, $sql );
	if ( ! $db_erg )
	{
		 echo  'ungültige Bereich NewLineSupportPlan: Error message: %s\n'. $db_link->error;
	}
	$MyZieleID ="";
	while ($zeile1 = mysqli_fetch_array($db_erg, MYSQLI_ASSOC)) {
    $MyZieleID = MyStringHTML($zeile1['FormulierungenID']);		
		// $myBereichText = MyStringHTML($zeile1['Text']);		
	}
  ob_end_clean();
  echo $MyZieleID;
}

if ( isset($_GET['CheckSupportPlan']) ){
  //Prüfen ob noch ein offener Supportplan besteht
  if ($_SESSION['LocalChat'] == true){
    $db_link1 = new mysqli($_SESSION["host_nameSchool"], $_SESSION["user_nameSchool"], $_SESSION["passwordSchool"], $_SESSION["databaseSchool"]);
  }
  else{
  $db_link1 = new mysqli($_SESSION["host_name"], $_SESSION["user_name"], $_SESSION["password"], $_SESSION["database"]);
  }
  //INSERT INTO `supportplan`(`id`, `clientID`, `erstellt`, `geaendert`, `gespeichert`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]')
    $sql1 = "SELECT * FROM `supportplan` WHERE `clientID`= ".$_SESSION['ActualClient']." AND `gespeichert` = 0";
    $db_erg1 = mysqli_query( $db_link1, $sql1 );
    if ( ! $db_erg1 )
    {
      echo  'ungültige Bereich CheckSupportPlan: Error message: %s\n'. $db_link1->error;
    }
    $SupportplanNotSaved = 1;
    while ($zeile1 = mysqli_fetch_array($db_erg1, MYSQLI_ASSOC)) {
      if($zeile1['clientID'] > 0){
      $SupportplanNotSaved = 0;
      }
    }
    ob_end_clean();
    echo $SupportplanNotSaved;
}
// ChangedSelectionSupportPlan
if ( isset($_GET['ChangedSelectionSupportPlan']) ){
  require ("content/db.php");
  $Inhalt =  '<div class="ContentTableInhalt tableFixHead" id="ContentTableInhalt">'; //ContentTableInhalt
  //$Inhalt.=  '<table class="tableFixHead">';

  $Inhalt.=  '<table class="table table-bordered table-striped table-hover table-sm ">';
  $Inhalt.=  '<thead>';
  $Inhalt.=  '<tr >';
  $Inhalt.=  '<th class="heading">Entwicklungsbereiche</th>'; //columnSupportHead1
  $Inhalt.=  '<th class="heading">Lernausgangslage</th>';
  $Inhalt.=  '<th class="heading">Formulierungen</th>';
  $Inhalt.=  '<th class="heading">Maßnahmen</th>';
  $Inhalt.=  '</tr>';
  $Inhalt.=  '</thead>';
  $Inhalt.=  '<tbody>';

  if ($_SESSION['LocalChat'] == true){
    $db_linkDat = new mysqli($_SESSION["host_nameSchool"], $_SESSION["user_nameSchool"], $_SESSION["passwordSchool"], $_SESSION["databaseSchool"]);
  }
  else{
  $db_linkDat = new mysqli($_SESSION["host_name"], $_SESSION["user_name"], $_SESSION["password"], $_SESSION["database"]);
  }
  $sqlDat = "SELECT  * FROM supportplanitems JOIN supportplan ON supportplanitems.`supportplanID`=supportplan.id WHERE supportplan.id = ".$_GET['ChangedSelectionSupportPlan']." AND supportplan.gespeichert > 0 ";
  $db_ergDat = mysqli_query( $db_linkDat, $sqlDat );
  if ( ! $db_ergDat )
  {
    $Inhalt.= 'ungültige Bereich supportplanitems: Error message: %s\n'. $db_linkDat->error;
  }
    while ($zeileDat = mysqli_fetch_assoc( $db_ergDat))
  {

  $Inhalt.=  '<tr >';
  $Inhalt.=  '<td class="columnSupport1 TabInhalt"><div  class="columnSupportTextarea" id="columnSupport1" >'.$zeileDat['Spalte1'].'</div></td>';
  $Inhalt.=  '<td class="columnSupport2 TabInhalt"><div class="columnSupportTextarea" id="columnSupport2" >'.$zeileDat['Spalte2'].'</div></td>';
  $Inhalt.=  '<td class="columnSupport3 TabInhalt"><div class="columnSupportTextarea" id="columnSupport3" >'.$zeileDat['Spalte3'].'</div></td>';
  $Inhalt.=  '<td class="columnSupport4 TabInhalt"><div class="columnSupportTextarea" id="columnSupport4" >'.$zeileDat['Spalte4'].'</div></td>';
  $Inhalt.=  '</tr>';
  }
  $SupportplanNotSaved = 2;  
  $Inhalt.=  '</tbody>';
  $Inhalt.=  '</table>';     
  $Inhalt.=  '</div>';
  echo $Inhalt;
}
//CloseSelectSupportPlan
if ( isset($_GET['CloseSelectSupportPlan']) ){
  $SupportplanNotSaved = 0; 
}
if ( isset($_GET['DeleteSupportTextArea']) ){
  if ($_SESSION['LocalChat'] == true){
    $db_link = new mysqli($_SESSION["host_nameSchool"], $_SESSION["user_nameSchool"], $_SESSION["passwordSchool"], $_SESSION["databaseSchool"]);
  }
  else{
  $db_link = new mysqli($_SESSION["host_name"], $_SESSION["user_name"], $_SESSION["password"], $_SESSION["database"]);
  }
  $sql = "DELETE FROM supportplanitems WHERE `supportplanitems`.`idItem` = '".$_GET['DeleteSupportTextArea']."' ";
	$db_erg = mysqli_query( $db_link, $sql );
	if ( ! $db_erg )
	{
		 echo  'ungültige Bereich DeleteSupportTextArea: Error message: %s\n'. $db_link->error;
	}
}
//
?>
