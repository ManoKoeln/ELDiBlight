let tableData = {};
let additionalColumns = 0;

function loadJSON() {
    const fileInput = document.getElementById('fileInput');
    fileInput.click();
}

function handleFileSelect(event) {
    const file = event.target.files[0];
    console.log("handleFileSelect : Filename= " + file.name + "  event= " + event);
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            tableData = JSON.parse(e.target.result);
            // Anzahl der zusätzlichen Spalten ermitteln
            console.log("handleFileSelect : Filename= " + e.target.result);
            additionalColumns = getMaxAdditionalColumns(tableData.details);
            renderTable();
        };
        reader.readAsText(file);
    }
}
function NewJSONLehrer() {
    fetch('JSON/VorlageLehrer.json')
        .then(response => response.json())
        .then(data => {
            tableData = data;
            // Anzahl der zusätzlichen Spalten ermitteln
            additionalColumns = getMaxAdditionalColumns(tableData.details);
            renderTable();
        })
        .catch(error => console.error('Error loading JSON:', error));
}

function NewJSONKind() {
    fetch('JSON/VorlageKind.json')
        .then(response => response.json())
        .then(data => {
            tableData = data;
            // Anzahl der zusätzlichen Spalten ermitteln
            additionalColumns = getMaxAdditionalColumns(tableData.details);
            renderTable();
        })
        .catch(error => console.error('Error loading JSON:', error));
}
function NewJSONEltern() {
    fetch('JSON/VorlageEltern.json')
        .then(response => response.json())
        .then(data => {
            tableData = data;
            // Anzahl der zusätzlichen Spalten ermitteln
            additionalColumns = getMaxAdditionalColumns(tableData.details);
            renderTable();
        })
        .catch(error => console.error('Error loading JSON:', error));
}


function getMaxAdditionalColumns(rows) {
    let maxColumns = 0;
    rows.forEach(row => {
        let columnCount = 0;
        while (row.hasOwnProperty(`newSelect${columnCount}`)) {
            columnCount++;
        }
        if (columnCount > maxColumns) {
            maxColumns = columnCount;
        }
    });
    return maxColumns;
}

function renderTable() {
    const table = document.getElementById('dataTable');
    table.innerHTML = '';
    let ColumnIndex = 0;  

    document.getElementById("validationVorname").value = tableData.Vorname;
    document.getElementById("validationName").value = tableData.Nachname;
    document.getElementById("validationKlasse").value = tableData.Klasse;
    document.getElementById("validationLehrer").value = tableData.Lehrer;




    // Add table headers


    const thead = document.createElement('thead');
    const trHeader = document.createElement('tr');

    const thZieleStichwort = document.createElement('th');
    thZieleStichwort.textContent = 'Stichwort';
    thZieleStichwort.id = 'HeadZieleStichwort';
    trHeader.appendChild(thZieleStichwort);

    const thZieleBeschreibung = document.createElement('th');
    thZieleBeschreibung.textContent = 'Beschreibung';
    thZieleBeschreibung.id = 'HeadZieleBeschreibung';
    trHeader.appendChild(thZieleBeschreibung);

    const th3 = document.createElement('th');
    th3.textContent = 'Auswahl';
    th3.id = 'HeadAuswahl';
    trHeader.appendChild(th3);

    thead.appendChild(trHeader);
    table.appendChild(thead);

    // Apply CSS to fix the header
    table.style.position = 'relative';
    table.style.borderCollapse = 'collapse';
    thead.style.position = 'sticky';
    thead.style.top = '0';
    thead.style.backgroundColor = '#f1f1f1';
    thead.style.zIndex = '1';
    // thZieleStichwort.textContent = 'Stichwort';
    // thZieleStichwort.id = 'HeadZieleStichwort';
    // table.appendChild(thZieleStichwort);
    // const thZieleBeschreibung = document.createElement('th');
    // thZieleBeschreibung.textContent = 'Beschreibung';
    // thZieleBeschreibung.id = 'HeadZieleBeschreibung';
    // table.appendChild(thZieleBeschreibung);
    // const th3 = document.createElement('th');
    // th3.textContent = 'Auswahl';
    // th3.id = 'HeadAuswahl'; 
    // table.appendChild(th3);


    tableData.details.forEach((row, index) => {
        ColumnIndex = ColumnIndex +1;    

        
        if (row.ZieleBeschreibung === "") {
            const tr = document.createElement('tr');
            const td = document.createElement('td');
            td.colSpan = 4 + additionalColumns;
            td.textContent = row.ZieleStichwort;
            td.classList.add('Stufe');
            td.id = `Stufe${ColumnIndex}`;
            td.ondblclick = function() {
                readText(this);
            };
            tr.appendChild(td);
            table.appendChild(tr);
        } else {
            const tr = document.createElement('tr');
            const tdStufe = document.createElement('td');
            tdStufe.textContent = row.Stufe;
            tdStufe.id = `Stufe_${ColumnIndex}`;

            // const tdZieleNummer = document.createElement('td');
            // tdZieleNummer.textContent = row.ZieleNummer;
            // tdZieleNummer.classList.add(`TabContent${row.BereichID}`);
            // tdZieleNummer.id = `ZieleNummer_${ColumnIndex}`;

            const tdZieleStichwort = document.createElement('td');
            // row.ZieleStichwort = row.ZieleNummer + ' ' + row.ZieleStichwort ;
            tdZieleStichwort.textContent = row.ZieleStichwort ;
            tdZieleStichwort.classList.add(`TabContent${row.BereichID}`);
            tdZieleStichwort.id = `ZieleStichwort_${ColumnIndex}`;
            tdZieleStichwort.ondblclick = function() {
                readText(this);
            };
            const tdZieleBeschreibung = document.createElement('td');
            tdZieleBeschreibung.textContent = row.ZieleBeschreibung;
            tdZieleBeschreibung.classList.add(`TabContent${row.BereichID}`);
            tdZieleBeschreibung.id = `ZieleBeschreibung_${ColumnIndex}`;
            tdZieleBeschreibung.ondblclick = function() {
                readText(this);
            };
            const td3 = document.createElement('td');

            // Div-Element, das den aktuellen Wert anzeigt
            const div = document.createElement('div');
            div.textContent = row.newSelect0;
            div.id = `divSelect_${index}`;
            div.style.cursor = 'pointer';
            setDivBackgroundColor(div, row.newSelect0);
             // Select-Element, das beim Klicken auf das Div-Element angezeigt wird
             const select = document.createElement('select');
             select.style.display = 'none';
             ['später', 'übt es jetzt', 'kann das Kind'].forEach(optionText => {
                 const option = document.createElement('option');
                 option.value = optionText;
                 option.textContent = optionText;
                 option.style.backgroundColor = '#d4edda'; // Hellgrün
                 if (row.newSelect0 === optionText) {
                     option.selected = true;
                 }
                 select.appendChild(option);
             });
 
             // Event-Listener für das Div-Element
             div.addEventListener('click', function() {
                 div.style.display = 'none';
                 select.style.display = 'block';
             });
 
            // Event-Listener für das Select-Element
            select.addEventListener('change', function() {
                row.newSelect0 = select.value;
                div.textContent = select.value;
                setDivBackgroundColor(div, select.value);
                select.style.display = 'none';
                div.style.display = 'block';
            });
 
             td3.appendChild(div);
             td3.appendChild(select);
             td3.id = `tdSelect_${index}`;
            // tr.appendChild(tdStufe);
            // tr.appendChild(tdZieleNummer);
            tr.appendChild(tdZieleStichwort);
            tr.appendChild(tdZieleBeschreibung);
            tr.appendChild(td3);

            // // Dynamisch zusätzliche Spalten hinzufügen
            // for (let i = 0; i < additionalColumns; i++) {
            //     const td = document.createElement('td');
            //     // if (row.hasOwnProperty(`newSelect${i}`)) {
            //     //     td.textContent = row[`newSelect${i}`];
            //     // } else {
            //         const newSelect = document.createElement('select');
            //         ['später', 'übt es jetzt', 'kann das Kind'].forEach(optionText => {
            //             const option = document.createElement('option');
            //             option.value = optionText;
            //             option.textContent = optionText;
            //             option.selected = row.newSelect0;
            //             newSelect.appendChild(option);
            //         });
            //         newSelect.addEventListener('change', function() {
            //             row[`newSelect${i}`] = newSelect.value;
            //         });
            //         td.appendChild(newSelect);
            //     // }
            //     td.id = `newSelect_${index}_${i}`;
            //     tr.appendChild(td);
            // }
            table.appendChild(tr);
            const td4 = document.createElement('td');
            td4.colSpan = 3 ;
            const div2 = document.createElement('div');
            div2.textContent = row.Notizen;
            div2.style.width = '100%';
            // div2.colSpan = 3 ;
            div2.id = `divSelect_${index}`;
            const trN = document.createElement('tr');
            const td = document.createElement('td');
            td.colSpan = 3 + additionalColumns;
                const input = document.createElement('input');
                input.style.display = 'none';
                input.value = row.Notizen;
                input.style.width = '100%';
                input.addEventListener('input', (e) => {
                    row.Notizen = e.target.value;
                });
                td.id = `Notizen${ColumnIndex}`;
                             // Event-Listener für das Div-Element
             div2.addEventListener('click', function() {
                div2.style.display = 'none';
                input.style.display = 'block';
            });

           // Event-Listener für das Select-Element
           input.addEventListener('blur', function() {
               row.Notizen = input.value;
               div2.textContent = input.value;
               input.style.display = 'none';
               div2.style.display = 'block';
           });
           td4.appendChild(div2);
           td4.appendChild(input);
                // td.appendChild(input);
                // trN.appendChild(td);
                // trN.appendChild(div2);
                trN.appendChild(td4);
                table.appendChild(trN);
        }
        // table.appendChild(tr);

    });
}

function setDivBackgroundColor(div, value) {
    switch (value) {
        case 'später':
            div.style.backgroundColor = '#d4edda'; // Hellgrün
            break;
        case 'übt es jetzt':
            div.style.backgroundColor = '#83e6cb'; // Mittelgrün
            break;
        case 'kann das Kind':
            div.style.backgroundColor = '#155724'; // Dunkelgrün
            div.style.color = '#ffffff'; // Weißer Text
            break;
        default:
            div.style.backgroundColor = ''; // Keine Hintergrundfarbe
            div.style.color = ''; // Standardtextfarbe
            break;
    }
}
function saveJSON() {
    validationVorname = document.getElementById("validationVorname").value;
    validationName = document.getElementById("validationName").value;   
    validationKlasse = document.getElementById("validationKlasse").value;
    validationLehrer = document.getElementById("validationLehrer").value;   
    tableData.Vorname = validationVorname;
    tableData.Nachname = validationName;
    tableData.Klasse = validationKlasse;
    tableData.Lehrer = validationLehrer;


    const json = JSON.stringify(tableData, null, 2);
    const blob = new Blob([json], { type: 'application/json' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = validationVorname + ' ' + validationName + ' ' + validationKlasse + ' ' + validationLehrer +'.json';
    a.click();
    URL.revokeObjectURL(url);
}

function addColumn() {
    additionalColumns++;
    tableData.details.forEach(row => {
        if (!row.fullRow) {
            row[`newSelect${additionalColumns - 1}`] = 'später';
        }
    });
    renderTable();
}

function exportToWord() {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = 'exportToWord.php';

    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'tableData';
    input.value = JSON.stringify(tableData);

    form.appendChild(input);
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
}

function exportTableToWord() {
    const tableData = [];
    const rows = document.querySelectorAll('#dataTable tr');
    rows.forEach((row, rowIndex) => {
        const rowData = [];
        row.querySelectorAll('td').forEach((cell, cellIndex) => {
            if (cell.querySelector('select')) {
                const div = cell.querySelector('div');
                // if (div) {
                rowData.push({
                    text: div ? div.textContent : cell.textContent,
                    // text: div ? div.textContent : cell.textContent
                });
            // }
            }
            else if (cell.querySelector('input')) {
                const div = cell.querySelector('div');
                rowData.push({
                    text: div ? div.textContent  : cell.textContent 
                });
            } 
            else {
                rowData.push({
                    id: cell.id,
                    text: cell.textContent 
                });
            }
        });
        if (rowIndex > 0){
        tableData.push(rowData);
        }
    });

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = 'exportTableToWord.php';

    const inputTableData = document.createElement('input');
    inputTableData.type = 'hidden';
    inputTableData.name = 'tableData';
    inputTableData.value = JSON.stringify(tableData);

    const inputHeadZieleStichwort = document.createElement('input');
    inputHeadZieleStichwort.type = 'hidden';
    inputHeadZieleStichwort.name = 'HeadZieleStichwort';
    inputHeadZieleStichwort.value = document.getElementById('HeadZieleStichwort').innerText;

    const inputHeadZieleBeschreibung = document.createElement('input');
    inputHeadZieleBeschreibung.type = 'hidden';
    inputHeadZieleBeschreibung.name = 'HeadZieleBeschreibung';
    inputHeadZieleBeschreibung.value = document.getElementById('HeadZieleBeschreibung').innerText;


    const inputHeadAuswahl = document.createElement('input');
    inputHeadAuswahl.type = 'hidden';
    inputHeadAuswahl.name = 'HeadAuswahl';
    inputHeadAuswahl.value = document.getElementById('HeadAuswahl').innerText;

    const inputVorname = document.createElement('input');
    inputVorname.type = 'hidden';
    inputVorname.name = 'validationVorname';
    inputVorname.value = document.getElementById('validationVorname').value;

    const inputName = document.createElement('input');
    inputName.type = 'hidden';
    inputName.name = 'validationName';
    inputName.value = document.getElementById('validationName').value;

    const inputKlasse = document.createElement('input');
    inputKlasse.type = 'hidden';
    inputKlasse.name = 'validationKlasse';
    inputKlasse.value = document.getElementById('validationKlasse').value;

    const inputLehrer = document.createElement('input');
    inputLehrer.type = 'hidden';
    inputLehrer.name = 'validationLehrer';
    inputLehrer.value = document.getElementById('validationLehrer').value;

    const inputDescVorname = document.createElement('input');
    inputDescVorname.type = 'hidden';
    inputDescVorname.name = 'DescVorname';
    inputDescVorname.value = document.getElementById('DescVorname').innerText;

    const inputDescName = document.createElement('input');
    inputDescName.type = 'hidden';
    inputDescName.name = 'DescName';
    inputDescName.value = document.getElementById('DescName').innerText;

    const inputDescKlasse = document.createElement('input');
    inputDescKlasse.type = 'hidden';
    inputDescKlasse.name = 'DescKlasse';
    inputDescKlasse.value = document.getElementById('DescKlasse').innerText;

    const inputDescLehrer = document.createElement('input');
    inputDescLehrer.type = 'hidden';
    inputDescLehrer.name = 'DescLehrer';
    inputDescLehrer.value = document.getElementById('DescLehrer').innerText;

    form.appendChild(inputTableData);
    form.appendChild(inputVorname);
    form.appendChild(inputName);
    form.appendChild(inputKlasse);
    form.appendChild(inputLehrer);
    form.appendChild(inputDescVorname);
    form.appendChild(inputDescName);
    form.appendChild(inputDescKlasse);
    form.appendChild(inputDescLehrer);
    form.appendChild(inputHeadZieleStichwort);
    form.appendChild(inputHeadZieleBeschreibung);   
    form.appendChild(inputHeadAuswahl);

    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
}

function saveAsJSON() {
    var RowCount = 0;
    var tableData = {
        Vorname: document.getElementById("validationVorname").value,
        Nachname: document.getElementById("validationName").value,
        Klasse: document.getElementById("validationKlasse").value,
        Lehrer: document.getElementById("validationLehrer").value,
        details: []
    };

    // Durchlaufe alle Zeilen und füge die Daten zu tableData.details hinzu
    // while (document.getElementById(`ZieleStichwort_${RowCount}`) && document.getElementById(`ZieleBeschreibung_${RowCount}`)) {
        while (document.getElementById(`ZieleStichwort_${RowCount}`) ) {
            var zieleBeschreibungElement = document.getElementById(`ZieleBeschreibung_${RowCount}`);
            var ZieleNummerElement = document.getElementById(`ZieleNummer_${RowCount}`);
            var NotizenElement = document.getElementById(`Notizen_${RowCount}`);
            var row = {
                Stufe: document.getElementById(`Stufe${RowCount}`).innerText,
                ZieleNummer: ZieleNummerElement ? ZieleNummerElement.innerText : '',
                BereichID: document.getElementById(`BereichID_${RowCount}`).innerText,
                ZieleStichwort: document.getElementById(`ZieleStichwort_${RowCount}`).innerText,
                ZieleBeschreibung: zieleBeschreibungElement ? zieleBeschreibungElement.innerText : '',                
                Notizen: NotizenElement ? NotizenElement.value : '',
                // newSelect0: document.getElementById(`select_${RowCount}`).value
            };
        tableData.details.push(row);
        RowCount++;
    }

    const json = JSON.stringify(tableData, null, 2);
    const blob = new Blob([json], { type: 'application/json' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `${tableData.Vorname}_${tableData.Nachname}_${tableData.Klasse}_${tableData.Lehrer}.json`;
    a.click();
    URL.revokeObjectURL(url);
}
document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('fileInput').addEventListener('change', handleFileSelect);
});