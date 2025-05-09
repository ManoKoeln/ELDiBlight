<?php
require 'vendor/autoload.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

if (isset($_POST['tableDataFoerderplan'])) {
    $tableDataFoerderplan = json_decode($_POST['tableDataFoerderplan'], true);


    // // Headings
    $HeadBereich = $_POST['HeadBereich'];
    $HeadZieleStichwort = $_POST['HeadZieleStichwort'];
    $HeadZieleBeschreibung = $_POST['HeadZieleBeschreibung'];
    $HeadFormulierung = $_POST['HeadFormulierung'];
    $HeadMassnahmen = $_POST['HeadMassnahmen'];

    // $HeadZieleBeschreibung = $_POST['HeadZieleBeschreibung'];
    // $HeadAuswahl = $_POST['HeadAuswahl'];
        // aditional data
        $validationVorname = $_POST['validationVorname'];
        $validationName = $_POST['validationName'];
        $validationKlasse = $_POST['validationKlasse'];
        $validationLehrer = $_POST['validationLehrer'];
    
        $DescVorname = $_POST['DescVorname'];
        $DescName = $_POST['DescName'];
        $DescKlasse = $_POST['DescKlasse'];
        $DescLehrer = $_POST['DescLehrer'];

    $phpWord = new PhpWord();
    $section = $phpWord->addSection();

  // Text hinzufügen
    $section->addText("$DescVorname: $validationVorname");
    $section->addText("$DescName: $validationName");
    $section->addText("$DescKlasse: $validationKlasse");
    $section->addText("$DescLehrer: $validationLehrer");
    // Tabelle hinzufügen
    $tableStyle = [
        'borderSize' => 6,
        'borderColor' => '000000',
        'cellMargin' => 50,
        'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER,
        'cantSplit' => true,
    ];
    $phpWord->addTableStyle('myTable', $tableStyle);
    $table = $section->addTable('myTable');

    $headerRow = $table->addRow();
    //             // // Tabellenüberschriften hinzufügen
    
                $headerRow->addCell(2000)->addText($HeadBereich, ['bold' => true]);
                $headerRow->addCell(2000)->addText($HeadZieleStichwort, ['bold' => true]);
                $headerRow->addCell(2000)->addText($HeadZieleBeschreibung, ['bold' => true]);
                $headerRow->addCell(2000)->addText($HeadFormulierung, ['bold' => true]);
                $headerRow->addCell(2000)->addText($HeadMassnahmen, ['bold' => true]);
                
    foreach ($tableDataFoerderplan as $row) {
    //     // $tableRow = $table->addRow();
    //     if (count($row) === 1) {
            
    //         // Wenn die Zeile nur eine Spalte hat, spannen Sie die Zelle über 3 Spalten

    //         // $tableRow->addCell(12000, ['gridSpan' => 3])->addText($row[0]['text']); //ORIGINAL
    //         // if ($row[0]['text']) {
    //         //     $tableRow->addCell(12000, ['gridSpan' => 3])->addText($row[0]['text']);
    //         // } else {
    //         //     $tableRow->addCell(12000, ['gridSpan' => 3])->addText(' ');
    //         // }
    //         // $tableRow->addCell(12000, ['gridSpan' => 3])->addText($row[0]['text'], ['bold' => true, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
    //         if (!empty($row[0]['text'])) {
                
    //             $cellText = isset($row[0]['text']) ? htmlspecialchars($row[0]['text'], ENT_QUOTES, 'UTF-8') : ' ';
    //             if ($cellText != ' '){
    //             $tableRow = $table->addRow();
    //             $tableRow->addCell(12000, ['gridSpan' => 4])->addText($cellText);



    //             // $headerRow->addCell(6000)->addText($HeadZieleBeschreibung, ['bold' => true]);
    //             // $headerRow->addCell(2000)->addText($HeadAuswahl, ['bold' => true]);
    //             }

    //         } 

    //     } 
    //     // else {
            $tableRow = $table->addRow();
            foreach ($row as $cell) {
                $cellText = $cell['text'];
                $cellOptions = [];
                $textOptions = [];

                // // Hintergrundfarbe und Schriftfarbe abhängig vom Textinhalt ändern
                // if ($cellText === 'später') {
                //     $cellOptions['bgColor'] = '328127'; // Gelbe Hintergrundfarbe
                //     $textOptions['color'] = 'FFFFFF'; // Rote Schriftfarbe
                // }
                // else if ($cellText === 'übt es jetzt') {
                //     $cellOptions['bgColor'] = '45bb34'; // Rote Hintergrundfarbe
                //     $textOptions['color'] = 'FFFF00'; // Gelbe Schriftfarbe
                // }
                // else if ($cellText === 'kann das Kind') {
                //     $cellOptions['bgColor'] = '58fd41'; // Grüne Hintergrundfarbe
                //     $textOptions['color'] = '0000FF'; // Blaue Schriftfarbe
                // }
                if ($cellText != '') {

                    $tableRow->addCell(2000, $cellOptions)->addText($cellText, $textOptions);
                }
            }
        }
    // }

    $footer = $section->addFooter();

    // $footer->addPreserveText('erstellt {DATE}',[], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
    $footer->addPreserveText('Förderplan: '.$validationVorname. ' '.$validationName.' '.' - erstellt '.date('d.m.Y'), ['italic' => true, 'size' => 10], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
    $footer->addPreserveText('Seite {PAGE} von {NUMPAGES}', [], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::RIGHT]);

    $filename = $validationVorname.' '.$validationName.' '.$validationKlasse.' '.$validationLehrer."_Förderplan.docx";
    // $filename = "Test.docx";validationName
    $temp_file = tempnam(sys_get_temp_dir(), $filename);
    $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
    $objWriter->save($temp_file);

    header('Content-Description: File Transfer');
    header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
    header(header: 'Content-Disposition: attachment; filename=' . $filename);
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . filesize($temp_file));
    flush();
    readfile($temp_file);
    unlink($temp_file);
    exit;
// } else {
//     echo 'Fehler: tableDataFoerderplan wurde nicht übergeben.';
}
?>
