<script src="Myjs.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> 
    <!-- <link href="CSS/header.css" rel="stylesheet" type="text/css"> -->
<!-- <link rel="stylesheet" media="screen and (max-aspect-ratio: 4/3)" href="CSS/headerSmal.css" /> -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start(); // Starten der Session nur, wenn keine Session aktiv ist
}
if ( isset($_GET['StartHead']) ){
$Inhalt = '';

$Inhalt.= '<header>';
$Inhalt.= '  <div class="col-sm-10">';
$Inhalt.= '    <div class="row rod-cols-2 row-cols-md-1">';
$Inhalt.= '      <div class="col-12 col-md-8">';
$Inhalt.= '        <div class="d-flex justify-content-between align-items-center">';
$Inhalt.= '        <h3 class="text-center sm-fs2">Entwicklungstherapie/ Entwicklungspädagogik</h3><h3 style="color: #ff8040;">light</h3>';
$Inhalt.= '        <img src="img/ETEPLogo.png" alt="logo" style="height: 16vh; padding: 2vh;></img>';
$Inhalt.= '        <div  id="google_translate_element"></div> ';
$Inhalt.= '        </div>';
$Inhalt.= '      </div>';
$Inhalt.= '    </div>';
$Inhalt.= '  </div>';
$Inhalt.= '</header>';
echo $Inhalt;
}
?>