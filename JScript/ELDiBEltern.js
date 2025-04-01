// function ShowELDiBEltern(){
//     document.getElementById("ELDiBEltern").style.display = "block"; 
// }
function HideELDiBEltern(){
  console.log("Start HideELDiBEltern");
    document.getElementById("").style.display = "none"; 
    document.getElementById("MainNavigation").style.display = "inline-table";
}
function ShowELDiBEltern(){
  console.log("Start ShowELDiBEltern");
    document.getElementById("ELDiBElterncontent").style.display = "block"; 
    document.getElementById("MainNavigation").style.display = "none";
    let MyVal = document.getElementById("SelectClient").value;
    if (window.XMLHttpRequest){ xmlhttp=new XMLHttpRequest(); } else { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
  xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
        document.getElementById("ELDiBElterncontent").innerHTML=xmlhttp.responseText;
    }
  }

xmlhttp.open("POST","ELDiBEltern.php?SetELDiBEltern="+MyVal,false);
xmlhttp.send();
}
function CreateNewTableELDiBEltern(){
  console.log("Start CreateNewTableELDiBEltern");
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
      ShowELDiBEltern();
    }
  }

xmlhttp.open("POST","ELDiBEltern.php?CreateNewTableELDiBEltern="+MyVal,false);
xmlhttp.send();
}
function ChangedSelectionELDiBEltern(IdZiel,idData,selectedIndex){
  console.log("ChangedSelectionELDiBEltern");
  

  let MyVal = document.getElementById("SelectClient").value;
  if (window.XMLHttpRequest){ xmlhttp=new XMLHttpRequest(); } else { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
  xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
      // ShowELDiBEltern();
    }
  }

xmlhttp.open("POST","ELDiBEltern.php?ChangedSelectionELDiBEltern="+MyVal+"&IdZiele="+ IdZiel+"&Auswahl="+selectedIndex+"&idData="+idData,false);
xmlhttp.send();

}
function ChangedKeywordELDiBEltern(IdZiel,idData,text){
  console.log("ChangedKeywordELDiBEltern");
  

  let MyVal = document.getElementById("SelectClient").value;
  if (window.XMLHttpRequest){ xmlhttp=new XMLHttpRequest(); } else { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
  xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
      // ShowELDiBEltern();
    }
  }

xmlhttp.open("POST","ELDiBEltern.php?ChangedKeywordELDiBEltern="+MyVal+"&IdZiele="+ IdZiel+"&Text="+text+"&idData="+idData,false);
xmlhttp.send();

}

function SaveTableELDiBEltern(){
  console.log("SaveTableELDiBEltern");
  let MyVal = document.getElementById("SelectClient").value;
  if (window.XMLHttpRequest){ xmlhttp=new XMLHttpRequest(); } else { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
  xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
      document.getElementById("ELDiBElterncontent").innerHTML="";
      ShowELDiBEltern();
    }
  }

xmlhttp.open("POST","ELDiBEltern.php?SaveTableELDiBEltern="+MyVal,false);
xmlhttp.send();
}

