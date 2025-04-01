// function ShowELDiBKind(){
//     document.getElementById("ELDiBKind").style.display = "block"; 
// }
function HideELDiBKind(){
  console.log("Start HideELDiBKind");
    document.getElementById("ELDiBKindcontent").style.display = "none"; 
    document.getElementById("MainNavigation").style.display = "inline-table";
}
function ShowELDiBKind(){
  console.log("Start ShowELDiBKind");
    document.getElementById("ELDiBKindcontent").style.display = "block"; 
    document.getElementById("MainNavigation").style.display = "none";
    let MyVal = document.getElementById("SelectClient").value;
    if (window.XMLHttpRequest){ xmlhttp=new XMLHttpRequest(); } else { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
  xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
        document.getElementById("ELDiBKindcontent").innerHTML=xmlhttp.responseText;
    }
  }

xmlhttp.open("POST","ELDiBKind.php?SetELDiBKind="+MyVal,false);
xmlhttp.send();
}
function CreateNewTableELDiBKind(){
  console.log("Start CreateNewTableELDiBKind");
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
      ShowELDiBKind();
    }
  }

xmlhttp.open("POST","ELDiBKind.php?CreateNewTableELDiBKind="+MyVal,false);
xmlhttp.send();
}
function ChangedSelectionELDiBKind(IdZiel,idData,selectedIndex){
  console.log("ChangedSelectionELDiBKind");
  

  let MyVal = document.getElementById("SelectClient").value;
  if (window.XMLHttpRequest){ xmlhttp=new XMLHttpRequest(); } else { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
  xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
      // ShowELDiBKind();
    }
  }

xmlhttp.open("POST","ELDiBKind.php?ChangedSelectionELDiBKind="+MyVal+"&IdZiele="+ IdZiel+"&Auswahl="+selectedIndex+"&idData="+idData,false);
xmlhttp.send();

}
function ChangedKeywordELDiBKind(IdZiel,idData,text){
  console.log("ChangedKeywordELDiBKind");
  

  let MyVal = document.getElementById("SelectClient").value;
  if (window.XMLHttpRequest){ xmlhttp=new XMLHttpRequest(); } else { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
  xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
      // ShowELDiBKind();
    }
  }

xmlhttp.open("POST","ELDiBKind.php?ChangedKeywordELDiBKind="+MyVal+"&IdZiele="+ IdZiel+"&Text="+text+"&idData="+idData,false);
xmlhttp.send();

}

function SaveTableELDiBKind(){
  console.log("SaveTableELDiBKind");
  let MyVal = document.getElementById("SelectClient").value;
  if (window.XMLHttpRequest){ xmlhttp=new XMLHttpRequest(); } else { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
  xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
      document.getElementById("ELDiBKindcontent").innerHTML="";
      ShowELDiBKind();
    }
  }

xmlhttp.open("POST","ELDiBKind.php?SaveTableELDiBKind="+MyVal,false);
xmlhttp.send();
}

