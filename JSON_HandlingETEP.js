let foerderplanData = {
    details: []

};
// let additionalColumns = 0;

function loadFoerderplanJSON() {
    const fileInput = document.getElementById('fileFoerderplanInput');
    fileInput.click();
}

function handleFileSelectFoerderplan(event) {
    const file = event.target.files[0];
    console.log("handleFileSelectFoerderplan : Filename= " + file.name + "  event= " + event);
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            foerderplanData = JSON.parse(e.target.result);
            // Anzahl der zusätzlichen Spalten ermitteln
            console.log("handleFileSelectFoerderplan : Filename= " + e.target.result);
            additionalColumns = getMaxAdditionalColumns(foerderplanData.details);
            document.getElementById("validationVorname").value = foerderplanData.Vorname;
            document.getElementById("validationName").value = foerderplanData.Nachname;
            document.getElementById("validationKlasse").value = foerderplanData.Klasse;
            document.getElementById("validationLehrer").value = foerderplanData.Lehrer;
            loadFoerderplanTabelle();
            document.getElementById('fileFoerderplanInput').value = ''; // Eingabefeld zurücksetzen
        };
        reader.readAsText(file);
    }
}

function loadFoerderplan() {
    // Pfad zur JSON-Datei
    document.getElementById("AktualClient").style.display = "flex";
    loadFileIntoElement("AktualClientForderplan.php", "AktualClient");
    const jsonFilePath = 'JSON/bereich.json';

    // Startseite für die Tabellen
    
   
    const Startseite = document.getElementById('Startseite'); // Startseite anzeigen

    // Startseite in zwei Bereiche teilen
    const upperSection = document.createElement('div');
    upperSection.style.height = '48%';
    upperSection.style.width = '100%';
    upperSection.style.display = 'flex'; // Flexbox aktivieren
    upperSection.style.flexDirection = 'row'; // Tabellen nebeneinander anordnen
    // upperSection.style.justifyContent = 'space-between'; // Platz zwischen den Tabellen
    upperSection.style.alignItems = 'flex-start'; // Tabellen oben ausrichten
    const middleSection = document.createElement('div');
    middleSection.style.height = '4%';
    middleSection.style.width = '100%'; 
    middleSection.style.border = '1px solid black'; // Border hinzufügen
    middleSection.style.display = 'flex'; // Flexbox aktivieren
    middleSection.style.flexDirection = 'row'; // Tabellen nebeneinander anordnen
    const title = document.createElement('h1');
    title.textContent = 'Förderplan';
    title.style.margin = 'auto';
    title.style.fontSize = '1.5vh';
    title.style.fontWeight = 'bold';
    middleSection.appendChild(title);

    const lowerSection = document.createElement('div');
    lowerSection.style.height = '45%';
    lowerSection.style.width = '100%';
    lowerSection.style.display = 'flex';
    lowerSection.style.flexDirection = 'column';


    // Startseite.style.display = 'flex'; // Startseite anzeigen
    Startseite.style.overflow = 'hidden'; // Startseite anzeigen
    Startseite.innerHTML = ''; // Startseite leeren
    // Haupttabelle erstellen
    const table = document.createElement('table');
    table.id = 'BereichTabelle';
    table.border = '1';
    table.style.width = '10%'; // Tabelle anzeigen
    table.style.position = 'relative';
    table.style.borderCollapse = 'collapse';
    // table.style.height = '50%'; // Tabelle anzeigen

    upperSection.appendChild(table);


    // JSON-Datei laden
    fetch(jsonFilePath)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP-Fehler! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            // Zugriff auf die "data"-Eigenschaft des "bereich"-Objekts
            const tableData = data.find(item => item.type === "table" && item.name === "bereich").data;

            // Tabellenkopf erstellen
            const thead = document.createElement('thead');
            thead.style.position = 'sticky';
            thead.style.top = '0';
            thead.style.backgroundColor = '#f1f1f1';
            thead.style.zIndex = '1';
            const headerRow = document.createElement('tr');
            ['ID', 'Text'].forEach(key => {
                const th = document.createElement('th');
                th.textContent = key;
                headerRow.appendChild(th);
            });
            thead.appendChild(headerRow);
            table.appendChild(thead);

            // Tabellenkörper erstellen
            const tbody = document.createElement('tbody');
            tableData.forEach(row => {
                const tr = document.createElement('tr');

                // ID-Spalte
                const tdId = document.createElement('td');
                tdId.textContent = row.id;
                tr.appendChild(tdId);

                // Text-Spalte
                const tdText = document.createElement('td');
                tdText.textContent = row.Text;
                tdText.style.cursor = 'pointer'; // Zeiger ändern, um Klickbarkeit anzuzeigen

                // Event-Listener für Klick auf die "Text"-Spalte
                tdText.addEventListener('click', () => {
                    loadZieleTabelle(row.id); // Funktion aufrufen, um zweite Tabelle zu laden
                });

                tr.appendChild(tdText);
                tbody.appendChild(tr);
            });
            table.appendChild(tbody);
            // table.style.width = '30%'; // Tabelle anzeigen
        })
        .catch(error => {
            console.error('Fehler beim Laden der JSON-Datei:', error);
        });
    // Tabelle für die Details
  
    const s_table = document.querySelector('table'); // Tabelle anzeigen

    // Ziele Tabelle erstellen
    const zieleTabelle = document.createElement('table');
    zieleTabelle.id = 'ZieleTabelle';
    zieleTabelle.border = '1';
    // zieleTabelle.style.width = '30%'; // Tabelle anzeigen
    zieleTabelle.style.height = '100%';
    zieleTabelle.style.overflow = 'auto'; // Tabelle anzeigen
    zieleTabelle.style.position = 'relative';
    zieleTabelle.style.borderCollapse = 'collapse';
    
    upperSection.appendChild(zieleTabelle);
    // Formulierungen Tabelle erstellen
    const formulierungenTabelle = document.createElement('table');
    formulierungenTabelle.id = 'FormulierungenTabelle';
    // formulierungenTabelle.style.width = '30%'; // Tabelle anzeigen
    formulierungenTabelle.style.height = '100%'; // Tabelle anzeigen
    formulierungenTabelle.style.overflow = 'auto'; // Tabelle anzeigen
    formulierungenTabelle.border = '1';
    upperSection.appendChild(formulierungenTabelle);
    // Massnahmen Tabelle erstellen
    const massnahmenTabelle = document.createElement('table');
    massnahmenTabelle.id = 'MassnahmenTabelle';
    // massnahmenTabelle.style.width = '30%'; // Tabelle anzeigen
    massnahmenTabelle.style.height = '100%'; // Tabelle anzeigen
    massnahmenTabelle.style.overflow = 'auto'; // Tabelle anzeigen
    massnahmenTabelle.border = '1';
    upperSection.appendChild(massnahmenTabelle);

    const foerderplanTabelle = document.createElement('table');
    foerderplanTabelle.id = 'foerderplanTabelle';
    // foerderplanTabelle.style.width = '100%'; // Tabelle anzeigen
    foerderplanTabelle.style.height = '100%'; // Tabelle anzeigen
    foerderplanTabelle.style.overflow = 'auto'; // Tabelle anzeigen
    lowerSection.appendChild(foerderplanTabelle);
    
                Startseite.appendChild(upperSection);
                Startseite.appendChild(middleSection); // Titel hinzufügen
                Startseite.appendChild(lowerSection);
    loadFoerderplanTabelle(); // Funktion aufrufen, um zweite Tabelle zu laden

}

function loadFoerderplanTabelle() {
    const foerderplanTabelle = document.getElementById('foerderplanTabelle');
    foerderplanTabelle.innerHTML = ''; // Tabelle leeren



    foerderplanTabelle.style.position = 'relative';
    foerderplanTabelle.style.borderCollapse = 'collapse';
    foerderplanTabelle.style.display = 'flow'; // Tabelle anzeigen
    foerderplanTabelle.style.overflow = 'auto'; // Tabelle anzeigen    
    foerderplanTabelle.classList.add('table-scrollable'); // Klasse für Scrollbarkeit
    
    //foerderplanTabelle.style.border = '1px solid black'; // Border hinzufügen

    foerderplanTabelle.style.borderCollapse = 'collapse'; // Doppelte Ränder vermeiden



    const thead = document.createElement('thead');
    thead.classList.add('thead-light'); // Bootstrap-Klasse für hellen Tabellenkopf
    thead.style.position = 'sticky';
    thead.style.top = '0';
    thead.style.backgroundColor = '#f1f1f1';
    thead.style.zIndex = '1';
    // thead.style.border = '1px solid black'; // Border hinzufügen
    const headerRow = document.createElement('tr');
    const thBereich = document.createElement('th');
    thBereich.textContent = 'Bereich';
    thBereich.id = 'HeadBereich';
    headerRow.appendChild(thBereich);
    const thZieleStichwort = document.createElement('th');
    thZieleStichwort.textContent = 'ZieleStichwort';
    thZieleStichwort.id = 'HeadZieleStichwort';
    headerRow.appendChild(thZieleStichwort);
    const thZieleBeschreibung = document.createElement('th');
    thZieleBeschreibung.textContent = 'ZieleBeschreibung';  
    thZieleBeschreibung.id = 'HeadZieleBeschreibung';
    headerRow.appendChild(thZieleBeschreibung);
    const thFormulierung = document.createElement('th');
    thFormulierung.textContent = 'Formulierung';
    thFormulierung.id = 'HeadFormulierung';
    headerRow.appendChild(thFormulierung);
    const thMassnahmen = document.createElement('th');
    thMassnahmen.textContent = 'Massnahmen';
    thMassnahmen.id = 'HeadMassnahmen';
    headerRow.appendChild(thMassnahmen);

    // ['Bereich', 'Ziele Stichwort', 'Ziele', 'Formulierung', 'Massnahmen'].forEach(key => {
    //     const th = document.createElement('th');
    //     th.textContent = key;
    //     headerRow.appendChild(th);
    // });
    thead.appendChild(headerRow);
    foerderplanTabelle.appendChild(thead);

    const tbody = document.createElement('tbody');
    const columnCount = 0; // Anzahl der Spalten in der Tabelle
    // Daten aus dem globalen Array in die Tabelle einfügen
    foerderplanData.details.forEach((entry, index) => {
        
        const tr = document.createElement('tr');
        tr.style.border = '1px solid #ddd'; // Rand für die Zeile hinzufügen
        tr.id = `Zeile_${index}`;
        entry.forEach(value => {
            const td = document.createElement('td');
            td.textContent = value;
            td.style.border = '1px solid #ddd'; // Rand für die Zelle hinzufügen
            
            tr.appendChild(td);
        });

        // Spalte für den Lösch-Button hinzufügen
        const deleteTd = document.createElement('td');
        const deleteButton = document.createElement('button');
        deleteButton.textContent = 'Löschen';
        deleteButton.classList.add('btn', 'btn-danger', 'btn-sm'); // Bootstrap-Klassen für Styling
        deleteButton.addEventListener('click', () => {
            // Zeile aus dem Array entfernen
            foerderplanData.details.splice(index, 1);

            // Tabelle neu laden
            loadFoerderplanTabelle();
        });
        deleteTd.appendChild(deleteButton);
        tr.appendChild(deleteTd);

        tbody.appendChild(tr);
    });

    foerderplanTabelle.appendChild(tbody);
}

function loadZieleTabelle(bereichId) {
    // Pfad zur zweiten JSON-Datei
    const jsonFilePath = 'JSON/ziele.json';
    const zieleTabelle = document.getElementById('ZieleTabelle');
    zieleTabelle.innerHTML = ''; // Tabelle leeren

    zieleTabelle.style.position = 'relative';
    zieleTabelle.style.borderCollapse = 'collapse';
    zieleTabelle.style.display = 'flow'; // Tabelle anzeigen
    zieleTabelle.classList.add('table-scrollable'); // Klasse für Scrollbarkeit
    zieleTabelle.style.overflow = 'auto'; // Tabelle anzeigen    


    // JSON-Datei laden
    fetch(jsonFilePath)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP-Fehler! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            // Zugriff auf die "data"-Eigenschaft des "ziele"-Objekts
            const tableData = data.find(item => item.type === "table" && item.name === "ziele").data;

            // Tabellenkopf erstellen
            const thead = document.createElement('thead');
            thead.classList.add('thead-light'); // Bootstrap-Klasse für hellen Tabellenkopf
            thead.style.position = 'sticky';
            thead.style.top = '0';
            thead.style.backgroundColor = '#f1f1f1';
            thead.style.zIndex = '1';

            const headerRow = document.createElement('tr');
            ['id', 'BereichID', 'ZieleNummer', 'ZieleStichwort', 'ZieleBeschreibung'].forEach(key => {
                const th = document.createElement('th');
                th.textContent = key;
                headerRow.appendChild(th);
            });
            thead.appendChild(headerRow);
            zieleTabelle.appendChild(thead);

            tableData.forEach(row => {
                if (row.BereichID === bereichId) { // Nur Daten mit passender BereichID anzeigen
                    const tr = document.createElement('tr');

                    // ID-Spalte
                    const tdId = document.createElement('td');
                    tdId.textContent = row.id;
                    tr.appendChild(tdId);

                    // BereichID-Spalte
                    const tdBereichID = document.createElement('td');
                    tdBereichID.textContent = row.BereichID;
                    tr.appendChild(tdBereichID);

                    // ZieleNummer-Spalte
                    const tdZieleNummer = document.createElement('td');
                    tdZieleNummer.textContent = row.ZieleNummer;
                    tr.appendChild(tdZieleNummer);

                    // ZieleStichwort-Spalte
                    const tdZieleStichwort = document.createElement('td');
                    tdZieleStichwort.textContent = row.ZieleStichwort;
                    tr.appendChild(tdZieleStichwort);

                    // ZieleBeschreibung-Spalte
                    const tdZieleBeschreibung = document.createElement('td');
                    tdZieleBeschreibung.textContent = row.ZieleBeschreibung;
                    // Event-Listener für Klick auf die "Text"-Spalte
                    tdZieleBeschreibung.addEventListener('click', () => {
                        loadFormulierungenTabelle(row.id); // Funktion aufrufen, um zweite Tabelle zu laden
                    });
                    // Doppelklick-Ereignis hinzufügen
                    tr.addEventListener('dblclick', () => {
                        console.log(row); // Überprüfen Sie den Inhalt von row
                        console.log(row.ZieleStichwort, row.ZieleNummer, row.ZieleBeschreibung);
                        const resultArray = getRelatedTextsZiele(
                            `${row.ZieleNummer} ${row.ZieleStichwort}`, // Kombinierte Werte der aktuellen Zeile
                            row.ZieleBeschreibung,
                            row.BereichID // ZieleID der aktuellen Zeile
                        );

                        // Ergebnisse in das globale Array einfügen
                        foerderplanData.details.push(resultArray);

                        // Tabelle aktualisieren
                        loadFoerderplanTabelle();       
                    }
                    );
                    tr.appendChild(tdZieleBeschreibung);

                    // td.appendChild(tr);
                    zieleTabelle.appendChild(tr);
                }
            });
        })
        .catch(error => {
            console.error('Fehler beim Laden der ziele JSON-Datei:', error);
        });
}
function loadFormulierungenTabelle(zieleId) {
    // Pfad zur zweiten JSON-Datei
    const jsonFilePath = 'JSON/formulierungen.json';

    // Tabelle für die Details
    const formulierungenTabelle = document.getElementById('FormulierungenTabelle');
    document.getElementById('FormulierungenTabelle').style.width = '45%'; // Tabelle anzeigen
    formulierungenTabelle.innerHTML = ''; // Tabelle leeren
    formulierungenTabelle.style.position = 'relative';
    formulierungenTabelle.style.borderCollapse = 'collapse';
    formulierungenTabelle.style.display = 'flow'; // Tabelle anzeigen
    formulierungenTabelle.classList.add('table-scrollable'); // Klasse für Scrollbarkeit
    formulierungenTabelle.style.overflow = 'auto'; // Tabelle anzeigen 
    // formulierungenTabelle.style.height = '50%';   

    // JSON-Datei laden
    fetch(jsonFilePath)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP-Fehler! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            // Zugriff auf die "data"-Eigenschaft des "formulierungen"-Objekts
            const tableData = data.find(item => item.type === "table" && item.name === "formulierungen").data;
            // Tabellenkopf erstellen
            const thead = document.createElement('thead');
            thead.classList.add('thead-light'); // Bootstrap-Klasse für hellen Tabellenkopf
            thead.style.position = 'sticky';
            thead.style.top = '0';
            thead.style.backgroundColor = '#f1f1f1';
            thead.style.zIndex = '1';
            const headerRow = document.createElement('tr');
            ['id', 'ZieleID', 'Text'].forEach(key => {
                const th = document.createElement('th');
                th.textContent = key;
                headerRow.appendChild(th);
            });
            thead.appendChild(headerRow);
            formulierungenTabelle.appendChild(thead);

            // Tabellenkörper erstellen
            tableData.forEach(row => {
                if (row.ZieleID === zieleId) { // Nur Daten mit passender BereichID anzeigen
                    const tr = document.createElement('tr');

                    // ID-Spalte
                    const tdId = document.createElement('td');
                    tdId.textContent = row.id;
                    tr.appendChild(tdId);

                    // ZieleID-Spalte
                    const tdZieleID = document.createElement('td');
                    tdZieleID.textContent = row.ZieleID;
                    tr.appendChild(tdZieleID);

                    // Text-Spalte
                    const tdText = document.createElement('td');
                    tdText.textContent = row.Text;
                    tr.appendChild(tdText);
                    // Event-Listener für Klick auf die "Text"-Spalte
                    tdText.textContent = row.Text;
                    tdText.addEventListener('click', () => {
                        loadmassnahmenTabelle(row.id); // Funktion aufrufen, um zweite Tabelle zu laden
                    });
                    tr.appendChild(tdText);
                    // Doppelklick-Ereignis hinzufügen
                    tr.addEventListener('dblclick', () => {
                        const resultArray = getRelatedTextsFormulierungen(
                            row.Text, // Text der aktuellen Zeile
                            row.ZieleID // FormulierungenID der aktuellen Zeile
                        );

                        // Ergebnisse in das globale Array einfügen
                        foerderplanData.details.push(resultArray);

                        // Tabelle aktualisieren
                        loadFoerderplanTabelle();       
                    }
                    ); 

                    // tbody.appendChild(tr);
                    formulierungenTabelle.appendChild(tr);
                }
            });
        })
        .catch(error => {
            console.error('Fehler beim Laden der formulierungen JSON-Datei:', error);
        });
}

function loadmassnahmenTabelle(FormulierungenId) {
    const jsonFilePath = 'JSON/massnahmen.json';
    const massnahmenTabelle = document.getElementById('MassnahmenTabelle');
    document.getElementById('MassnahmenTabelle').style.width = '45%'; // Tabelle anzeigen
    massnahmenTabelle.innerHTML = ''; // Tabelle leeren
    massnahmenTabelle.style.position = 'relative';
    massnahmenTabelle.style.borderCollapse = 'collapse';
    massnahmenTabelle.style.display = 'flow'; // Tabelle anzeigen
    massnahmenTabelle.classList.add('table-scrollable'); // Klasse für Scrollbarkeit
    massnahmenTabelle.style.overflow = 'auto'; // Tabelle anzeigen 
    massnahmenTabelle.innerHTML = ''; // Tabelle leeren

    fetch(jsonFilePath)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP-Fehler! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            const tableData = data.find(item => item.type === "table" && item.name === "massnahmen").data;

            const thead = document.createElement('thead');
            thead.classList.add('thead-light'); // Bootstrap-Klasse für hellen Tabellenkopf
            thead.style.position = 'sticky';
            thead.style.top = '0';
            thead.style.backgroundColor = '#f1f1f1';
            thead.style.zIndex = '1';
            // Tabellenkopf erstellen
            const headerRow = document.createElement('tr');
            ['id', 'FormulierungenID', 'Text'].forEach(key => {
                const th = document.createElement('th');
                th.textContent = key;
                headerRow.appendChild(th);
            });
            thead.appendChild(headerRow);
            massnahmenTabelle.appendChild(thead);

            tableData.forEach(row => {
                if (row.FormulierungenID === FormulierungenId) {
                    const tr = document.createElement('tr');

                    const tdId = document.createElement('td');
                    tdId.textContent = row.id;
                    tr.appendChild(tdId);

                    const tdFormulierungenID = document.createElement('td');
                    tdFormulierungenID.textContent = row.FormulierungenID;
                    tr.appendChild(tdFormulierungenID);

                    const tdText = document.createElement('td');
                    tdText.textContent = row.Text;
                    tr.appendChild(tdText);

                    // Doppelklick-Ereignis hinzufügen
                    tr.addEventListener('dblclick', () => {
                        const resultArray = getRelatedTextsMassnahmen(
                            row.Text, // Text der aktuellen Zeile
                            row.FormulierungenID // FormulierungenID der aktuellen Zeile
                        );

                        // Ergebnisse in das globale Array einfügen
                        foerderplanData.details.push(resultArray);

                        // Tabelle aktualisieren
                        loadFoerderplanTabelle();
                    });

                    massnahmenTabelle.appendChild(tr);
                }
            });
        })
        .catch(error => {
            console.error('Fehler beim Laden der massnahmen JSON-Datei:', error);
        });
}

function getRelatedTextsMassnahmen(massnahmenText, formulierungenId) {
    // Tabelle Formulierungen durchsuchen
    const formulierungenTabelle = document.getElementById('FormulierungenTabelle');
    const formulierungenRow = Array.from(formulierungenTabelle.rows).find(row => {
        const cell = row.cells[0]; // Erste Spalte (ID)
        return cell && cell.textContent === formulierungenId.toString();
    });

    const formulierungenText = formulierungenRow ? formulierungenRow.cells[2].textContent : 'N/A'; // Text-Spalte

    // Tabelle Ziele durchsuchen
    const zieleId = formulierungenRow ? formulierungenRow.cells[1].textContent : null; // ZieleID-Spalte
    const zieleTabelle = document.getElementById('ZieleTabelle');
    const zieleRow = Array.from(zieleTabelle.rows).find(row => {
        const cell = row.cells[0]; // Erste Spalte (ID)
        return cell && cell.textContent === zieleId;
    });

    // const zieleText = zieleRow ? zieleRow.cells[4].textContent : 'N/A'; // ZieleStichwort-Spalte
    // const zieleText = zieleRow ? `${zieleRow.cells[2].textContent} ${zieleRow.cells[3].textContent} ${zieleRow.cells[4].textContent}` : 'N/A'; // Text-Spalten kombiniert
    const zieleText = zieleRow ? zieleRow.cells[4].textContent : 'N/A'; // Text-Spalten kombiniert
    const zieleStichwort = zieleRow ? `${zieleRow.cells[2].textContent} ${zieleRow.cells[3].textContent}`: 'N/A'; // ZieleStichwort-Spalte

    // Tabelle Bereich durchsuchen
    const bereichId = zieleRow ? zieleRow.cells[1].textContent : null; // BereichID-Spalte
    const bereichTabelle = document.getElementById('BereichTabelle');
    const bereichRow = Array.from(bereichTabelle.rows).find(row => {
        const cell = row.cells[0]; // Erste Spalte (ID)
        return cell && cell.textContent === bereichId;
    });

    const bereichText = bereichRow ? bereichRow.cells[1].textContent : 'N/A'; // Text-Spalte

    // Array mit den vier Einträgen erstellen
    return [bereichText, zieleStichwort, zieleText, formulierungenText,massnahmenText ];
}

function getRelatedTextsFormulierungen(formulierungenText, zieleId) {

        // Tabelle Formulierungen durchsuchen
        const zieleTabelle = document.getElementById('ZieleTabelle');
        const zieleRow = Array.from(zieleTabelle.rows).find(row => {
            const cell = row.cells[0]; // Erste Spalte (ID)
            return cell && cell.textContent === zieleId.toString();
        });
    
        const zieleText = zieleRow ? zieleRow.cells[4].textContent : 'N/A'; // Text-Spalten kombiniert
        const zieleStichwort = zieleRow ? `${zieleRow.cells[2].textContent} ${zieleRow.cells[3].textContent}`: 'N/A'; // ZieleStichwort-Spalte
        // const zieleText = zieleRow ? zieleRow.cells[2].textContent & ' ' & zieleRow ? zieleRow.cells[3].textContent & ' ' & zieleRow ? zieleRow.cells[4].textContent: 'N/A'; // Text-Spalte

    // Tabelle Bereich durchsuchen
    const bereichId = zieleRow ? zieleRow.cells[1].textContent : null; // BereichID-Spalte
    const bereichTabelle = document.getElementById('BereichTabelle');
    const bereichRow = Array.from(bereichTabelle.rows).find(row => {
        const cell = row.cells[0]; // Erste Spalte (ID)
        return cell && cell.textContent === bereichId;
    });

    const bereichText = bereichRow ? bereichRow.cells[1].textContent : 'N/A'; // Text-Spalte
    const massnahmenText = ' ';
    // Array mit den vier Einträgen erstellen
    return [bereichText, zieleStichwort, zieleText, formulierungenText,massnahmenText ];
}

function getRelatedTextsZiele(zieleStichwort, zieleText, bereichId) {

    // Tabelle Formulierungen durchsuchen
    const BereichTabelle = document.getElementById('BereichTabelle');
    const bereichRow = Array.from(BereichTabelle.rows).find(row => {
        const cell = row.cells[0]; // Erste Spalte (ID)
        return cell && cell.textContent === bereichId.toString();
    });

    const bereichText = bereichRow ? bereichRow.cells[1].textContent : 'N/A'; // Text-Spalte

const massnahmenText = ' ';
const formulierungenText = ' ';
// Array mit den vier Einträgen erstellen
return [bereichText,zieleStichwort, zieleText, formulierungenText,massnahmenText ];
}
function exportFoerderplanToWord() {
    const tableDataFoerderplan = [];
    const rows = document.querySelectorAll('#foerderplanTabelle tr');
    const headData =[];

    const inputHeadBereich = document.createElement('input');
    inputHeadBereich.type = 'hidden';
    inputHeadBereich.name = 'HeadBereich';
    inputHeadBereich.value = document.getElementById('HeadBereich').innerText;

    const inputHeadZieleStichwort = document.createElement('input');
    inputHeadZieleStichwort.type = 'hidden';
    inputHeadZieleStichwort.name = 'HeadZieleStichwort';
    inputHeadZieleStichwort.value = document.getElementById('HeadZieleStichwort').innerText;

    const inputHeadZieleBeschreibung = document.createElement('input');
    inputHeadZieleBeschreibung.type = 'hidden';
    inputHeadZieleBeschreibung.name = 'HeadZieleBeschreibung';
    inputHeadZieleBeschreibung.value = document.getElementById('HeadZieleBeschreibung').innerText;

    const inputHeadFormulierung = document.createElement('input');
    inputHeadFormulierung.type = 'hidden';
    inputHeadFormulierung.name = 'HeadFormulierung';
    inputHeadFormulierung.value = document.getElementById('HeadFormulierung').innerText;

    const inputHeadMassnahmen = document.createElement('input');
    inputHeadMassnahmen.type = 'hidden';
    inputHeadMassnahmen.name = 'HeadMassnahmen';
    inputHeadMassnahmen.value = document.getElementById('HeadMassnahmen').innerText;


    rows.forEach((row, rowIndex) => {
        const rowData = [];
        row.querySelectorAll('td').forEach((cell, cellIndex) => {
            console.log(cellIndex + " == "+ cell.textContent);

            if ((cellIndex < 5)) { // Nur die ersten 5 Spalten (ohne ID) exportieren
                rowData.push({
                    // id: cell.id,
                    text: cell.textContent 
                });
            }
            // }
        });
        if (rowIndex > 0){
        tableDataFoerderplan.push(rowData);
        }
    });

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = 'exportFoerderplanToWord.php';

    const inputtableDataFoerderplan = document.createElement('input');
    inputtableDataFoerderplan.type = 'hidden';
    inputtableDataFoerderplan.name = 'tableDataFoerderplan';
    inputtableDataFoerderplan.value = JSON.stringify(tableDataFoerderplan);

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

    form.appendChild(inputtableDataFoerderplan);
    form.appendChild(inputVorname);
    form.appendChild(inputName);
    form.appendChild(inputKlasse);
    form.appendChild(inputLehrer);
    form.appendChild(inputDescVorname);
    form.appendChild(inputDescName);
    form.appendChild(inputDescKlasse);
    form.appendChild(inputDescLehrer);
    form.appendChild(inputHeadBereich);
    form.appendChild(inputHeadZieleStichwort);
    form.appendChild(inputHeadZieleBeschreibung);
    form.appendChild(inputHeadFormulierung);
    form.appendChild(inputHeadMassnahmen);

   

    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
}
function saveFoerderplanJSON() {
    validationVorname = document.getElementById("validationVorname").value;
    validationName = document.getElementById("validationName").value;   
    validationKlasse = document.getElementById("validationKlasse").value;
    validationLehrer = document.getElementById("validationLehrer").value;   


        foerderplanData.Vorname = validationVorname;
        foerderplanData.Nachname = validationName;
        foerderplanData.Klasse = validationKlasse;
        foerderplanData.Lehrer = validationLehrer;
        // details: foerderplanData.details



    const json = JSON.stringify(foerderplanData, null, 2);
    const blob = new Blob([json], { type: 'application/json' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = validationVorname + ' ' + validationName + ' ' + validationKlasse + ' ' + validationLehrer +'.json';
    a.click();
    URL.revokeObjectURL(url);
}