

function ELDiBLehrerNew(){
  console.log("ELDiBLehrerNew");
  if (window.XMLHttpRequest){ xmlhttp=new XMLHttpRequest(); } else { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
xmlhttp.onreadystatechange=function()
{
if (xmlhttp.readyState==4 && xmlhttp.status==200)
  {
    console.log("ELDiBLehrerNew response: " + xmlhttp.responseText);
   ShowELDiBLehrerNew();
  }
}
xmlhttp.open("POST","ELDiBLehrer.php?ELDiBLehrerNew=true",false);
xmlhttp.send();

}
function ShowELDiBEltern_New(){
  console.log("Start ShowELDiBEltern");
    // document.getElementById("ELDiBElterncontent_New").style.display = "block"; 
    // document.getElementById("MainNavigation").style.display = "none";
    // let MyVal = document.getElementById("SelectClient").value;
    if (window.XMLHttpRequest){ xmlhttp=new XMLHttpRequest(); } else { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
  xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
        document.getElementById("Startseite").innerHTML=xmlhttp.responseText;
    }
  }

// xmlhttp.open("POST","ELDiBEltern_New.php?SetELDiBElternNew="+MyVal,false);
xmlhttp.open("POST","ELDiBLehrer.php?SetELDiBEltern=true",false);
xmlhttp.send();
}

function ShowELDiBKind_New(){
  console.log("Start ShowELDiBKind");
    // document.getElementById("ELDiBKindcontent_New").style.display = "block"; 
    // document.getElementById("MainNavigation").style.display = "none";
    // let MyVal = document.getElementById("SelectClient").value;
    if (window.XMLHttpRequest){ xmlhttp=new XMLHttpRequest(); } else { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
  xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
        document.getElementById("Startseite").innerHTML=xmlhttp.responseText;
    }
  }

// xmlhttp.open("POST","ELDiBKind_New.php?SetELDiBKindNew="+MyVal,false);
xmlhttp.open("POST","ELDiBLehrer.php?SetELDiBKind=true",false);
xmlhttp.send();
}

function ShowELDiBLehrer_New(){
  console.log("Start ShowELDiBLehrer");
    // document.getElementById("ELDiBLehrercontent_New").style.display = "block"; 
    // document.getElementById("MainNavigation").style.display = "none";
    // let MyVal = document.getElementById("SelectClient").value;
    if (window.XMLHttpRequest){ xmlhttp=new XMLHttpRequest(); } else { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
  xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
        document.getElementById("Startseite").innerHTML=xmlhttp.responseText;
    }
  }

// xmlhttp.open("POST","ELDiBLehrer_New.php?SetELDiBLehrerNew="+MyVal,false);
xmlhttp.open("POST","ELDiBLehrer.php?SetELDiBLehrer=true",false);
xmlhttp.send();
}

function loadFileIntoElement(filePath, elementId) {
  fetch(filePath)
    .then(response => {
      if (!response.ok) {
        throw new Error("Network response was not ok");
      }
      return response.text();
    })
    .then(data => {
      document.getElementById(elementId).innerHTML = data;
    })
    .catch(error => {
      console.error("Error loading file:", error);
    });
}

// Beispielaufruf


function ShowELDiBLehrer_JSON(){
  console.log("Start ShowELDiBLehrer_JSON");
    
  document.getElementById("AktualClient").style.display = "flex";
    
    if (window.XMLHttpRequest){ xmlhttp=new XMLHttpRequest(); } else { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
  xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
         document.getElementById("Startseite").innerHTML=xmlhttp.responseText;
         loadFileIntoElement("AktualClientBewertungsbogen.php", "AktualClient");
          // document.getElementById("AktualClient").innerHTML = "AktualClientBewertungsbogen.php";
    }
  }

xmlhttp.open("POST","ReadELDiBTable.php",false);
xmlhttp.send();
}
function ELDiBLehrerFirstTemplate(){
  console.log("ELDiBLehrerFirstTemplate");
  if (window.XMLHttpRequest){ xmlhttp=new XMLHttpRequest(); } else { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
xmlhttp.onreadystatechange=function()
{
if (xmlhttp.readyState==4 && xmlhttp.status==200)
  {
    console.log("ELDiBLehrerFirstTemplate response: " + xmlhttp.responseText);
   ShowELDiBLehrerFirstTemplate();
  }
}
xmlhttp.open("POST","ELDiBLehrer.php?ELDiBLehrerFirstTemplate=true",false);
xmlhttp.send();

}
// function showLoadFileDialog() {
//   document.getElementById('fileInput').click();
// }

// function handleFileSelect(event) {
//   var file = event.target.files[0];
//   if (file) {
//       var reader = new FileReader();
//       reader.onload = function(e) {
//           var fileContent = e.target.result;
//           document.getElementById('fileContent').value = fileContent;
//           // Hier können Sie den Inhalt der Datei weiterverarbeiten
//           console.log("Dateiinhalt:", fileContent);
//           document.getElementById('filename').value = fileContent.name;
//           sendJSONToServer(fileContent);
//       };
//       reader.readAsText(file);
//   }
// }

// function sendJSONToServer(jsonData) {
//   var xhr = new XMLHttpRequest();
//   xhr.open("POST", "process_json.php", true);
//   xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
//   xhr.onreadystatechange = function() {
//       if (xhr.readyState === 4 && xhr.status === 200) {
//           console.log("Server response:", xhr.responseText);
//       }
//   };
//   xhr.send(jsonData);
// }

// document.getElementById('fileInput').addEventListener('change', handleFileSelect);

function showSaveFileDialogold() {
  var fileContent = document.getElementById('fileContent').value;
  var Vorname = document.getElementById("validationVorname").value;
  var Nachname = document.getElementById("validationName").value;
  var Klasse = document.getElementById("validationKlasse").value;
  var Filename = Vorname + "_" + Nachname + "_" + Klasse + ".json";
  console.log("Filename = " + Filename);
  var link = document.createElement('a');
  link.href = 'data:text/plain;charset=utf-8,' + encodeURIComponent(fileContent);
  link.download = Filename; // Vorgeschlagener Dateiname

  // Simulieren eines Klicks auf den Link
  link.style.display = 'none';
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
}

function downloadSessionData() {
  var Vorname = document.getElementById("validationVorname").value;
  var Nachname = document.getElementById("validationName").value;
  var Klasse = document.getElementById("validationKlasse").value;
  var Filename = Vorname + "_" + Nachname + "_" + Klasse + ".json";
  console.log("Filename = " + Filename);
  var link = document.createElement('a');
  link.href = 'download_json.php?filename=' + Filename;
  // link.href = 'download_json.php';
  link.download = "data.json"; // Vorgeschlagener Dateiname
  link.download = Filename; // Vorgeschlagener Dateiname

  // Simulieren eines Klicks auf den Link
  link.style.display = 'none';
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
}

function saveNotizen() {
}
function setNewColumn() {
  var xmlhttp = new XMLHttpRequest();
  actfilename = document.getElementById("actfilename").value; 
  console.log("setNewColumn: actfilename = " + actfilename);
  xmlhttp.onreadystatechange = function() {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      actfilename = document.getElementById("actfilename").value; 
      console.log("setNewColumn response: New sheet set successfully");
      console.log("setNewColumn response: actfilename = " + actfilename);
      ShowELDiBLehrerNew(actfilename,false);
    }
  };
  xmlhttp.open("POST", "ELDiBLehrer.php?SetNewColumn=true", true);
  xmlhttp.send();
}
function saveJSON(ArrayCount) {
    // Save Lehrer
    var title = "Einsch\u00e4tzungsbogen Lehrer";
    var content = "Inhalt des Dokuments.";
    var Vorname = document.getElementById("validationVorname").value;
    var Nachname = document.getElementById("validationName").value;
    var Klasse = document.getElementById("validationKlasse").value;
    var Lehrer = document.getElementById("validationLehrer").value;
    var lStufe;
    var lBereich;
    var lZieleNummer;
    var lZieleStichwort;
    var lZieleBeschreibung;

    var lLinie_1;
    var lZieleBeschreibung;
    // var lLinie_3;
    var lNotizen;
    var lDatum_1;


    console.log("saveJSON - Vorname = " + Vorname);
    console.log("saveJSON - Nachname = " + Nachname);  

    var Line2Empty = false;
    var data = {
      title: title,
      content: content,
      Vorname: Vorname,
      Nachname: Nachname,
      Klasse: Klasse,
      Lehrer: Lehrer,
      Head: [
      {
        BereichID: "",
        ZieleBeschreibung: "",
        Datum: []
      }
      ],
      details: [
        {
          Stufe: "",
          BereichID: "",
          ZieleNummer: "",
          ZieleStichwort: "",
          ZieleBeschreibung: "",
          Notizen: "",
          Datum:[
            {
              daten: ""
            }
          ]


        }
      ]
    };

 
    $HeadDatumCounter = 1;
    while (document.getElementById("HeadDatum_" + $HeadDatumCounter)) {
      data['Head'][0].Datum.push(document.getElementById("HeadDatum_" + $HeadDatumCounter).innerText);
      $HeadDatumCounter = $HeadDatumCounter + 1;
    }
    


    
    for (i = 0; i <= ArrayCount; i++) {
        Line2Empty = false;
        if (document.getElementById("Stufe_" + i)){
          console.log("saveJSON: Stufe_" + i + " = " + document.getElementById("Stufe_" + i).innerText+ " Stichwort => " + document.getElementById("ZieleStichwort_" + i).innerText); ;
                lStufe = document.getElementById("Stufe_" + i).innerText;
        }
        if (document.getElementById("BereichID_" + i)){
        lBereichID = document.getElementById("BereichID_" + i).innerText;
        }
        else{
          lBereichID = "";
        }
        // if (document.getElementById("ZieleNummer_" + i)){
        // lZieleNummer = document.getElementById("ZieleNummer_" + i).value;
        // }
        if (document.getElementById("ZieleNummer_" + i)){
        lZieleNummer = document.getElementById("ZieleNummer_" + i).innerText;
        }
        else{
          lZieleNummer = "";
        }
        // if (document.getElementById("ZieleBeschreibung_" + i)){
        // lZieleBeschreibung = document.getElementById("ZieleBeschreibung_" + i).value;
        // }
        if( document.getElementById("ZieleStichwort_" + i)){
        lZieleStichwort = document.getElementById("ZieleStichwort_" + i).innerText;
        }
        else{
          lZieleStichwort = "";
        }
        if( document.getElementById("ZieleBeschreibung_" + i)){
            Line2Empty = false;
            // Line2.push(document.getElementById("ZieleBeschreibung_" + i).innerText);
            lZieleBeschreibung = document.getElementById("ZieleBeschreibung_" + i).innerText;
        }
        else {
            // Line2.push(""); // or handle the missing element case as needed
            lZieleBeschreibung = "";
            Line2Empty = true;
        }

        // if( document.getElementById("Line3_" + i)){
        // lLinie_3 = document.getElementById("Line3_" + i).innerText;
        // } 
        // else {
        //     if (Line2Empty){
        //         lLinie_3 = "" 
        //     }
        //     else {                
        //         lLinie_3 = "später"; 
        //     }
        // }
        if( document.getElementById("output_" + i)){
          lDatum_1 = document.getElementById("output_" + i).innerText;
          // console.log("lDatum_1 = " + lDatum_1);
          }

        if( document.getElementById("Notizen_" + i)){
        lNotizen = document.getElementById("Notizen_" + i).value;
        }
        else{
          lNotizen = "";
        }

        data['details'][i] = {
          Stufe: lStufe,
          BereichID: lBereichID,
          ZieleNummer: lZieleNummer,
          ZieleStichwort: lZieleStichwort,
          ZieleBeschreibung: lZieleBeschreibung,
          Notizen: lNotizen,
          Datum: {
            daten: lDatum_1
          }

        };
    }


    var jsonData = JSON.stringify(data, null, 2);
    var Vorname = document.getElementById("validationVorname").value;
    var Nachname = document.getElementById("validationName").value;
    var Klasse = document.getElementById("validationKlasse").value;
    var Filename = Vorname + "_" + Nachname + "_" + Klasse + ".json";
    // console.log("Filename = " + Filename);
    var link = document.createElement('a');
    link.href = 'data:text/plain;charset=utf-8,' + encodeURIComponent(jsonData);
    // link.href = 'data:text/plain;charset=utf-8,' + encodeURIComponent(jsonData);
    link.download = Filename; // Vorgeschlagener Dateiname
  
    // Simulieren eines Klicks auf den Link
    link.style.display = 'none';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);


    // var xmlhttp = new XMLHttpRequest();
    // xmlhttp.open("POST", "ELDiBLehrer.php?SaveJSONFile&Filename="+Filename, true);
    // xmlhttp.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    // xmlhttp.send(jsonData);
}

function createJSONTemplateFileJS(){
  console.log("createJSONTemplateFileJS ");  

    if (window.XMLHttpRequest){ xmlhttp=new XMLHttpRequest(); } else { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }

xmlhttp.open("POST","ELDiBLehrer.php?CreateTemplateJSONFile=true",false);
xmlhttp.send();
}
function ShowELDiBLehrerNew(Filename, NewColumn){
  console.log("ShowELDiBLehrerNew Filename = "+ Filename);

  if (window.XMLHttpRequest){ xmlhttp=new XMLHttpRequest(); } else { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
xmlhttp.onreadystatechange=function()
{
if (xmlhttp.readyState==4 && xmlhttp.status==200)
  {
      document.getElementById("Startseite").innerHTML=xmlhttp.responseText;
      document.getElementById('actfilename').value = Filename;
  }
}
xmlhttp.open("POST","ELDiBLehrer.php?SetELDiBLehrerJSON=True&Filename="+Filename+"&NewColumn="+NewColumn,false);

xmlhttp.send();
}
function ShowELDiBLehrerFirstTemplate(Filename, NewColumn){
  console.log("ShowELDiBLehrerFirstTemplate Filename = "+ Filename);

  if (window.XMLHttpRequest){ xmlhttp=new XMLHttpRequest(); } else { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
xmlhttp.onreadystatechange=function()
{
if (xmlhttp.readyState==4 && xmlhttp.status==200)
  {
      document.getElementById("Startseite").innerHTML=xmlhttp.responseText;
      document.getElementById('actfilename').value = Filename;
  }
}
xmlhttp.open("POST","ELDiBLehrer.php?SetELDiBLehrerJSONFirstTemplate=True&Filename="+Filename+"&NewColumn="+NewColumn,false);

xmlhttp.send();
}


function HideELDiBLehrer(){
  console.log("Start HideELDiBLehrer");
    document.getElementById("ELDiBLehrercontent").style.display = "none"; 
    document.getElementById("MainNavigation").style.display = "inline-table";
}


function CreateNewTableELDiBLehrer(){
  console.log("Start CreateNewTableELDiBLehrer");
  let MyVal = document.getElementById("SelectClient").value;
  if (window.XMLHttpRequest){ xmlhttp=new XMLHttpRequest(); } else { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
  xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {

      console.log("respone = " + xmlhttp.responseText);
      if (String(xmlhttp.responseText).length >0){
      console.log(" xmlhttp.responseText");
      }
      ShowELDiBLehrer();
    }
  }

xmlhttp.open("POST","ELDiBLehrer.php?CreateNewTableELDiBLehrer="+MyVal,false);
xmlhttp.send();
}
function ChangedSelectionELDiBLehrer(IdZiel,idData,selectedIndex){
  console.log("ChangedSelectionELDiBLehrer");
  

  let MyVal = document.getElementById("SelectClient").value;
  if (window.XMLHttpRequest){ xmlhttp=new XMLHttpRequest(); } else { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
  xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
      // ShowELDiBLehrer();
    }
  }

xmlhttp.open("POST","ELDiBLehrer.php?ChangedSelectionELDiBLehrer="+MyVal+"&IdZiele="+ IdZiel+"&Auswahl="+selectedIndex+"&idData="+idData,false);
xmlhttp.send();

}
function ChangedKeywordELDiBLehrer(IdZiel,idData,text){
  console.log("ChangedKeywordELDiBLehrer");
  

  let MyVal = document.getElementById("SelectClient").value;
  if (window.XMLHttpRequest){ xmlhttp=new XMLHttpRequest(); } else { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
  xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
      // ShowELDiBLehrer();
    }
  }

xmlhttp.open("POST","ELDiBLehrer.php?ChangedKeywordELDiBLehrer="+MyVal+"&IdZiele="+ IdZiel+"&Text="+text+"&idData="+idData,false);
xmlhttp.send();

}

function SaveTableELDiBLehrer(){
  console.log("SaveTableELDiBLehrer");
  let MyVal = document.getElementById("SelectClient").value;
  if (window.XMLHttpRequest){ xmlhttp=new XMLHttpRequest(); } else { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
  xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
      document.getElementById("ELDiBLehrercontent").innerHTML="";
      ShowELDiBLehrer();
    }
  }

xmlhttp.open("POST","ELDiBLehrer.php?SaveTableELDiBLehrer="+MyVal,false);
xmlhttp.send();
}
// ############################################################################################################

