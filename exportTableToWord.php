<?php
require 'vendor/autoload.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tableData = json_decode($_POST['tableData'], true);

    // aditional data
    $validationVorname = $_POST['validationVorname'];
    $validationName = $_POST['validationName'];
    $validationKlasse = $_POST['validationKlasse'];
    $validationLehrer = $_POST['validationLehrer'];

    $DescVorname = $_POST['DescVorname'];
    $DescName = $_POST['DescName'];
    $DescKlasse = $_POST['DescKlasse'];
    $DescLehrer = $_POST['DescLehrer'];

    // Headings
    $HeadZieleStichwort = $_POST['HeadZieleStichwort'];
    $HeadZieleBeschreibung = $_POST['HeadZieleBeschreibung'];
    $HeadAuswahl = $_POST['HeadAuswahl'];
    

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
    // Tabellenüberschriften hinzufügen


    foreach ($tableData as $row) {
        $tableRow = $table->addRow();
        if (count($row) === 1) {
            // Wenn die Zeile nur eine Spalte hat, spannen Sie die Zelle über 3 Spalten

            $tableRow->addCell(12000, ['gridSpan' => 3])->addText($row[0]['text']);
            $headerRow = $table->addRow();
             // Tabellenüberschriften hinzufügen
            // $headerRow->addCell(2000)->addText('Nummer', ['bold' => true]);
            $headerRow->addCell(4000)->addText($HeadZieleStichwort, ['bold' => true]);
            $headerRow->addCell(6000)->addText($HeadZieleBeschreibung, ['bold' => true]);
            $headerRow->addCell(2000)->addText($HeadAuswahl, ['bold' => true]);
            // $headerRow->addCell(4000)->addText('Stichwort', ['bold' => true]);
            // $headerRow->addCell(6000)->addText('Beschreibung', ['bold' => true]);
            // $headerRow->addCell(2000)->addText('Auswahl', ['bold' => true]);
        } else {
            foreach ($row as $cell) {
                $cellText = $cell['text'];
                $cellOptions = [];
                $textOptions = [];

                // Hintergrundfarbe und Schriftfarbe abhängig vom Textinhalt ändern
                if ($cellText === 'später') {
                    $cellOptions['bgColor'] = '328127'; // Gelbe Hintergrundfarbe
                    $textOptions['color'] = 'FFFFFF'; // Rote Schriftfarbe
                }
                else if ($cellText === 'übt es jetzt') {
                    $cellOptions['bgColor'] = '45bb34'; // Rote Hintergrundfarbe
                    $textOptions['color'] = 'FFFF00'; // Gelbe Schriftfarbe
                }
                else if ($cellText === 'kann das Kind') {
                    $cellOptions['bgColor'] = '58fd41'; // Grüne Hintergrundfarbe
                    $textOptions['color'] = '0000FF'; // Blaue Schriftfarbe
                }

                $tableRow->addCell(2000, $cellOptions)->addText($cellText, $textOptions);
            }
        }
    }

    $filename = "Tabelle.docx";
    $temp_file = tempnam(sys_get_temp_dir(), $filename);
    $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
    $objWriter->save($temp_file);

    header('Content-Description: File Transfer');
    header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
    header('Content-Disposition: attachment; filename=' . $filename);
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . filesize($temp_file));
    flush();
    readfile($temp_file);
    unlink($temp_file);
    exit;
}
?>
