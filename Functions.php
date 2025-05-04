    <script src="Myjs.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> 
    <!-- <link href="CSS/header.css" rel="stylesheet" type="text/css"> -->
<!-- <link rel="stylesheet" media="screen and (max-aspect-ratio: 4/3)" href="CSS/headerSmal.css" /> -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<script src="Myjs.js"></script>
    <script src="Operator.js"></script>
    <script src="ELDiBEltern.js"></script>
    <script src="JScript/ELDiBLehrer_New.js"></script>
    <script src="ELDiBKind.js"></script>
    <script src="ELDiBLehrer.js"></script>
    <script src="SupportPlan.js"></script>
    <script src="EmailKind.js"></script>
    <script src="EmailEltern.js"></script>

    <?php
      //   require "content/db.php";
      //   include "content/helpers.php";
      //   include "NewClient.php";
      //   include "NewUser.php";
      //   include "ELDiBEltern.php";
      //   include "ELDiBLehrer.php";
      //   include "ELDiBLehrer_New.php";
      //  include "ELDiBKind.php";
       
if (session_status() == PHP_SESSION_NONE) {
  session_start(); // Starten der Session nur, wenn keine Session aktiv ist
}
if ( isset($_GET['Start']) ){
$Inhalt = '';
    $Inhalt.= '<div  >' ; //class="absolute -relativ top-20 start-0"
  $Inhalt.='<div  id="rightSite" >  <!-- class="rightSite" -->';
  $Inhalt.= '<hr class="featurette-divider">';
  $Inhalt.= '<table class="table table-sm table-borderless">';
    $Inhalt.= '<tr>';
    $Inhalt.= '<td><button typ="button" class="btn-primary "  style="display: none;" onclick="ShowELDiBLehrer_New();">ELDiB Lehrer Import von DB nach JSON</button></td>';    
    $Inhalt.= '</tr>';
    $Inhalt.= '<tr>';
    // $Inhalt.= '<td>
    //  <button typ="button" class="btn-primary " style="display: none;"  onclick="ELDiBLehrerNew();">ELDiB Lehrerneu </button>
    //  <button typ="button" class="btn-primary " style="display: none;"  onclick="ELDiBLehrerFirstTemplate();" >ELDiB Lehrer erste Vorlage Stufendaten aus Datenbank</button> 
    //  <button typ="button" class="btn-primary " style="display: none;"  onclick="ELDiBLehrerOpen();">ELDiB Lehrer öffnen</button>
    // <button typ="button" class="btn-primary "  onclick="ShowELDiBLehrer_JSON();">ELDiB  Bewertungsbogen</button>
    // </td>';    //style="display:none;"
    $Inhalt.= '<td>
   <button typ="button" class="btn-primary "  onclick="ShowELDiBLehrer_JSON();">ELDiB  Bewertungsbogen</button>
   </td>';    //style="display:none;"
    $Inhalt.= '</tr>';
    $Inhalt.= '<tr>';
    $Inhalt.= '<td>
   <button typ="button" class="btn-primary "  onclick="loadFoerderplan();">Förderplan</button>
   </td>';    //style="display:none;"
    $Inhalt.= '</tr>';
    $Inhalt.= '<tr>';
    $Inhalt.= '<td><button typ="button" class="btn-primary " style="display: none;"  onclick="ShowELDiBKind_New();">ELDiB Kind Import von DB nach JSON</button></td>';    
    $Inhalt.= '</tr>';
    $Inhalt.= '<tr>';
    // $Inhalt.= '<td>
    // <button typ="button" class="btn-primary "   onclick="ELDiBKindNew();">ELDiB Kindneu </button>
    // <button typ="button" class="btn-primary "   onclick="ELDiBKindFirstTemplate();" >ELDiB Kind erste Vorlage Stufendaten aus Datenbank</button> 
    // <button typ="button" class="btn-primary "   onclick="ELDiBKindOpen();">ELDiB Kind öffnen</button>
    //     </td>';    //style="display:none;"
    // $Inhalt.= '</tr>';
    $Inhalt.= '<tr>';
    $Inhalt.= '<td><button typ="button" class="btn-primary "  style="display: none;" onclick="ShowELDiBEltern_New();">ELDiB Eltern Import von DB nach JSON</button></td>';    
    $Inhalt.= '</tr>';

    // $Inhalt.= '<tr>';
    // $Inhalt.= '<td>
    // <button typ="button" class="btn-primary " style="display: none;"  onclick="ELDiBElternNew();">ELDiB Elternneu </button>
    // <button typ="button" class="btn-primary " style="display: none;"  onclick="ELDiBElternFirstTemplate();" >ELDiB Eltern erste Vorlage Stufendaten aus Datenbank</button> 
    // <button typ="button" class="btn-primary " style="display: none;"  onclick="ELDiBElternOpen();">ELDiB Eltern öffnen</button>
    //     </td>';    //style="display:none;"
    // $Inhalt.= '</tr>';
    $Inhalt.= '<tr>';
      $Inhalt.= '<td><button typ="button" class="btn-primary "  style="display: none;" onclick="ShowELDiBKind();">ELDiB Kind</button></td>';
    $Inhalt.= '</tr>';
    $Inhalt.= '<tr>';
      $Inhalt.= '<td><button typ="button" class="btn-primary "  style="display: none;" onclick="ShowELDiBEltern();">ELDiB Eltern</button></td>';
    $Inhalt.= '</tr>';
    $Inhalt.= '<tr>';
    $Inhalt.= '<td><button typ="button" class="btn-primary "  style="display: none;" onclick="ShowSupportPlan();">Förderplan</button></td>';
    $Inhalt.= '</tr>';
  $Inhalt.= '</table>';
  $Inhalt.= '</div>';

  $Inhalt.= '</div>';

  $Inhalt.='</div>';
  echo $Inhalt;
}
?>