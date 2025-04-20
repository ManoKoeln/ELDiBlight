type="text/javascript"
var inhaltZieleRef, ZieleZieleNummerRef, ClipBoardTextRef;
var inhaltFormulierungenRef;
var copyZieleInterval;
var copyFormulierungenInterval;
var TextFormulierungenRef;
var copyFormulierungenLenOld;
var copyZieleLenOld;

var inhaltZieleOld;
var inhaltFormulierungenOld;
var inhaltMassnahmenOld;







function copyMassnahmen(inhalt) {
//  alert ("Massnahmen = " + inhalt);
  const element = inhalt; 
  

copyStringToClipboard(element);

// document.getElementById("DivClipBoard").innerHTML=inhalt;

  

}



function InsertMassnahmen(parent)
{
  eingabe = String(document.getElementById("PopUpTextMassnahmen").value);
  text = parent;
  clip = "";
  
    if (window.XMLHttpRequest){ xmlhttp=new XMLHttpRequest(); } else { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
    xmlhttp.onreadystatechange=function()
    {
    if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
      // xmlhttp.open("POST","content/konfiguration.php?Ziele="+parent,false);
      // xmlhttp.send();

      document.getElementById("PopUpTextMassnahmen").value ="";
      document.getElementById("MyPopUp").style.display = 'none';
      copyFormulierungen(parent,text," ");
    }
  }
  xmlhttp.open("POST","content/konfiguration.php?NewMassnahmen="+parent+"&TextMassnahmen="+encodeURI(eingabe),false);
  xmlhttp.send();
  

}



function deleteMassnahmen(parent)
{
  if (window.XMLHttpRequest){ xmlhttp=new XMLHttpRequest(); } else { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
  xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
  {
  NoDisplayDeletePopUpMassnahmen();
  }
}
xmlhttp.open("POST","content/konfiguration.php?DelMassnahmen="+parent,false);
xmlhttp.send();
// await new Promise(resolve => setTimeout(resolve, 1000));
// copyFormulierungen(refreshId," ");

}



function deleteFormulierungen(parent)
{
  if (window.XMLHttpRequest){xmlhttp=new XMLHttpRequest();}else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
  xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
  {
  NoDisplayDeletePopUpFormulierungen();
  }
}
xmlhttp.open("POST","content/konfiguration.php?DelFormulierungen="+parent,false);
xmlhttp.send();
// await new Promise(resolve => setTimeout(resolve, 1000));
// copyZiele(refreshId," "," "," ");

}



function MyScrollTo () {
	window.scrollTo(0, MyYOffset);
	/* alert(lat); */
}



function InsertFormulierungen(parent)
{
eingabe = String(document.getElementById("PopUpTextFormulierungen").value);
text = parent;
clip = "";
console.log("MyJavascript InsertFormulierungen parent = " + parent + " -- eingabe = " + eingabe);
if (window.XMLHttpRequest){ xmlhttp=new XMLHttpRequest(); } else { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
  xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
      // xmlhttp.open("POST","content/konfiguration.php?Ziele="+parent,false);
      // xmlhttp.send();
      document.getElementById("PopUpTextFormulierungen").value ="";
      document.getElementById("MyPopUp").style.display = 'none';
      copyZiele(parent,text,clip," ");
    }
  }

xmlhttp.open("POST","content/konfiguration.php?NewFormulierungen="+parent+"&TextFormulierungen="+encodeURI(eingabe),false);
xmlhttp.send();


}

function EditZiele(id, parent, text,ziel){
let clip = "";
  let eingabe = prompt('Zieltext : '+text+' ändern! ','');
  if (eingabe === null) {
    return;
  }
  if (window.XMLHttpRequest) {xmlhttp=new XMLHttpRequest();} else {xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}

xmlhttp.open("POST","content/konfiguration.php?EditZiele="+parent+"&ZieleId="+id+"&TextZiele="+eingabe,false);
xmlhttp.send();


copyBereich(parent,ziel);
  
}



function MyScrollTo () {
	window.scrollTo(0, MyYOffset);
	/* alert(lat); */
}



//ChatSendText
function ChatSendText (inhalt){
  console.log('ChatSendText Inhalt = '+inhalt);
  if (inhalt=="")
  {
   document.getElementById("MyChatZieleNummer").innerHTML="keine Eingabe";
  return;
  }
  if (window.XMLHttpRequest)
    {
    // AJAX nutzen mit IE7+, Chrome, Firefox, Safari, Opera
    //alert("AJAX nutzen mit IE7+, Chrome, Firefox, Safari, Opera");
    xmlhttp=new XMLHttpRequest();
    }
  else
    {
    // AJAX mit IE6, IE5
    //alert("AJAX mit IE6, IE5");
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
  xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    // document.getElementById("ChatZieleNummer").innerHTML=xmlhttp.responseText;
    
    document.getElementById("MyChat").innerHTML="Test MyChat text 1234";
    
    }
    document.getElementById("MyChatZieleNummer").innerHTML="Test text 1234";
    xmlhttp.open("POST","content/konfiguration.php?Test="+inhalt,false);
    xmlhttp.send();
    
  }
}


function copyStringToClipboard (str) {
   // Temporäres Element erzeugen
   var el = document.createElement('textarea');
   // Den zu kopierenden String dem Element zuweisen
   el.value = str;
   // Element nicht editierbar setzen und aus dem Fenster schieben
   el.setAttribute('readonly', '');
   el.style = {position: 'absolute', left: '-9999px'};
   document.body.appendChild(el);
   // Text innerhalb des Elements auswählen
   el.select();
   // Ausgewählten Text in die Zwischenablage kopieren
   document.execCommand('copy');
   // Temporäres Element löschen
   document.body.removeChild(el);
}






