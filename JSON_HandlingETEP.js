function loadBereichJSON() {
    // Pfad zur JSON-Datei
    const jsonFilePath = 'JSON/bereich.json';

    // Startseite für die Tabellen
    
   
    const Startseite = document.getElementById('Startseite'); // Startseite anzeigen
    Startseite.style.display = 'flex'; // Startseite anzeigen
    Startseite.style.overflow = 'hidden'; // Startseite anzeigen
    Startseite.innerHTML = ''; // Startseite leeren
    // Haupttabelle erstellen
    const table = document.createElement('table');
    table.id = 'BereichTabelle';
    table.border = '1';
    table.style.width = '15%'; // Tabelle anzeigen
    table.style.position = 'relative';
    table.style.borderCollapse = 'collapse';
    Startseite.appendChild(table);


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
    // s_table.style.overflow = 'auto'; // Tabelle anzeigen
    // s_table.style.display = 'flex'; // Tabelle anzeigen
    // s_table.style.position = 'relative';
    // s_table.style.borderCollapse = 'collapse';

    // Zweite Tabelle erstellen
    const zieleTabelle = document.createElement('table');
    zieleTabelle.id = 'ZieleTabelle';
    zieleTabelle.border = '1';
    zieleTabelle.style.width = '60%'; // Tabelle anzeigen
    zieleTabelle.style.overflow = 'auto'; // Tabelle anzeigen
    zieleTabelle.style.position = 'relative';
    zieleTabelle.style.borderCollapse = 'collapse';
    // zieleTabelle.style.display = 'flex'; // Tabelle anzeigen
    Startseite.appendChild(zieleTabelle);
    // Formulierungen Tabelle erstellen
    const formulierungenTabelle = document.createElement('table');
    formulierungenTabelle.id = 'FormulierungenTabelle';
    formulierungenTabelle.border = '1';
    // formulierungenTabelle.style.width = '45%'; // Tabelle anzeigen
    Startseite.appendChild(formulierungenTabelle);
        // Massnahmen Tabelle erstellen
    const massnahmenTabelle = document.createElement('table');
    massnahmenTabelle.id = 'MassnahmenTabelle';
    massnahmenTabelle.border = '1';
    Startseite.appendChild(massnahmenTabelle);
}

// function loadZieleTabelle(bereichId) {
//     // Pfad zur zweiten JSON-Datei
//     const jsonFilePath = 'JSON/ziele.json';
// const zieleTabelle = document.getElementById('ZieleTabelle');
// const tbody = document.createElement('tbody');
        
//     // Apply CSS to fix the header

//     zieleTabelle.innerHTML = ''; // Tabelle leeren

//     // JSON-Datei laden
//     fetch(jsonFilePath)
//         .then(response => {
//             if (!response.ok) {
//                 throw new Error(`HTTP-Fehler! Status: ${response.status}`);
//             }
//             return response.json();
//         })
//         .then(data => {
//             // Zugriff auf die "data"-Eigenschaft des "ziele"-Objekts
//             const tableData = data.find(item => item.type === "table" && item.name === "ziele").data;
//             // Tabellenkopf erstellen
//             const thead = document.createElement('thead');
//             thead.style.position = 'sticky';
//             thead.style.top = '0';
//             thead.style.backgroundColor = '#f1f1f1';
//             thead.style.zIndex = '1';            
//             const headerRow = document.createElement('tr');
//             ['id', 'BereichID', 'ZieleStichwort','ZieleNummer','ZieleBeschreibung'].forEach(key => {
//                 const th = document.createElement('th');
//                 th.textContent = key;
//                 headerRow.appendChild(th);
//             });
//             thead.appendChild(headerRow);
//             zieleTabelle.appendChild(thead);
//             // tbody.appendChild(thead);

//             // // Tabellenkörper erstellen
//             // const tbody = document.createElement('tbody');

//             //             // Tabellenkopf erstellen
//             //             // const thead = document.createElement('thead');
//             //             tbody.style.position = 'sticky';
//             //             tbody.style.top = '0';
//             //             tbody.style.backgroundColor = '#f1f1f1';
//             //             tbody.style.zIndex = '1';
//             //             const headerRow = document.createElement('tr');
//             //             ['id', 'BereichID', 'ZieleStichwort','ZieleNummer','ZieleBeschreibung'].forEach(key => {
//             //                 const th = document.createElement('th');
//             //                 th.textContent = key;
//             //                 headerRow.appendChild(th);
//             //             });
//             //             tbody.appendChild(headerRow);
//             //             zieleTabelle.appendChild(tbody);
//             // // Tabellenkörper erstellen ENDE
//             tableData.forEach(row => {
//                 if (row.BereichID === bereichId) { // Nur Daten mit passender BereichID anzeigen
//                     const tr = document.createElement('tr');

//                     // ID-Spalte
//                     const tdId = document.createElement('td');
//                     tdId.textContent = row.id;
//                     tr.appendChild(tdId);

//                     // BereichID-Spalte
//                     const tdBereichID = document.createElement('td');
//                     tdBereichID.textContent = row.BereichID;
//                     tr.appendChild(tdBereichID);

//                     // ZieleNummer-Spalte
//                     const tdZieleNummer = document.createElement('td');
//                     tdZieleNummer.textContent = row.ZieleNummer;
//                     tr.appendChild(tdZieleNummer);                    

//                     // ZieleStichwort-Spalte
//                     const tdZieleStichwort = document.createElement('td');
//                     tdZieleStichwort.textContent = row.ZieleStichwort;
                   

//                                     // Event-Listener für Klick auf die "Text"-Spalte
//                     tdZieleStichwort.addEventListener('click', () => {
//                         loadFormulierungenTabelle(row.id); // Funktion aufrufen, um zweite Tabelle zu laden
//                     });
//                     tr.appendChild(tdZieleStichwort);
//                     // ZieleBeschreibung-Spalte
//                     const tdZieleBeschreibung = document.createElement('td');
//                     tdZieleBeschreibung.textContent = row.ZieleBeschreibung;
//                     tdZieleBeschreibung.addEventListener('click', () => {
//                         loadFormulierungenTabelle(row.id); // Funktion aufrufen, um zweite Tabelle zu laden
//                     });
//                     tr.appendChild(tdZieleBeschreibung);

//                     tbody.appendChild(tr);
//                 }
//             });
//             zieleTabelle.appendChild(tbody);
//         })
//         .catch(error => {
//             console.error('Fehler beim Laden der ziele JSON-Datei:', error);
//         });

// }
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
            ['id', 'BereichID', 'ZieleStichwort', 'ZieleNummer', 'ZieleBeschreibung'].forEach(key => {
                const th = document.createElement('th');
                th.textContent = key;
                headerRow.appendChild(th);
            });
            thead.appendChild(headerRow);
            zieleTabelle.appendChild(thead);

            // Tabellenkörper erstellen
            // const tbody = document.createElement('tbody');
            // tbody.classList.add('table-scrollable'); // Klasse für Scrollbarkeit
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
                    tr.appendChild(tdZieleBeschreibung);

                    // td.appendChild(tr);
                    zieleTabelle.appendChild(tr);
                }
            });
            // zieleTabelle.appendChild(tbody);
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
    // document.getElementById('Startseite').style.display = 'flex'; // Startseite anzeigen
    document.getElementById('FormulierungenTabelle').style.width = '45%'; // Tabelle anzeigen
    formulierungenTabelle.innerHTML = ''; // Tabelle leeren
    formulierungenTabelle.style.position = 'relative';
    formulierungenTabelle.style.borderCollapse = 'collapse';
    formulierungenTabelle.style.display = 'flow'; // Tabelle anzeigen
    formulierungenTabelle.classList.add('table-scrollable'); // Klasse für Scrollbarkeit
    formulierungenTabelle.style.overflow = 'auto'; // Tabelle anzeigen    

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
            // const tbody = document.createElement('tbody');
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
                    // Event-Listener für Klick auf die "Text"-Spalte
                    tdText.addEventListener('click', () => {
                        loadmassnahmenTabelle(row.id); // Funktion aufrufen, um zweite Tabelle zu laden
                    });
                    tr.appendChild(tdText);                    

                    // tbody.appendChild(tr);
                    formulierungenTabelle.appendChild(tr);
                }
            });
            // formulierungenTabelle.appendChild(tr);
        })
        .catch(error => {
            console.error('Fehler beim Laden der formulierungen JSON-Datei:', error);
        });
}

function loadmassnahmenTabelle(FormulierungenId) {
    // Pfad zur zweiten JSON-Datei
    const jsonFilePath = 'JSON/massnahmen.json';

    // Tabelle für die Details
    const massnahmenTabelle = document.getElementById('MassnahmenTabelle');
    // document.getElementById('Startseite').style.display = 'flex'; // Startseite anzeigen
    document.getElementById('MassnahmenTabelle').style.width = '45%'; // Tabelle anzeigen
    massnahmenTabelle.innerHTML = ''; // Tabelle leeren
    massnahmenTabelle.style.position = 'relative';
    massnahmenTabelle.style.borderCollapse = 'collapse';
    massnahmenTabelle.style.display = 'flow'; // Tabelle anzeigen
    massnahmenTabelle.classList.add('table-scrollable'); // Klasse für Scrollbarkeit
    massnahmenTabelle.style.overflow = 'auto'; // Tabelle anzeigen    

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
            const tableData = data.find(item => item.type === "table" && item.name === "massnahmen").data;
            // Tabellenkopf erstellen
            const thead = document.createElement('thead');
            thead.classList.add('thead-light'); // Bootstrap-Klasse für hellen Tabellenkopf
            thead.style.position = 'sticky';
            thead.style.top = '0';
            thead.style.backgroundColor = '#f1f1f1';
            thead.style.zIndex = '1';
            const headerRow = document.createElement('tr');
            ['id', 'FormulierungenID', 'Text'].forEach(key => {
                const th = document.createElement('th');
                th.textContent = key;
                headerRow.appendChild(th);
            });
            thead.appendChild(headerRow);
            massnahmenTabelle.appendChild(thead);

            // Tabellenkörper erstellen
            // const tbody = document.createElement('tbody');
            tableData.forEach(row => {
                if (row.FormulierungenID === FormulierungenId) { // Nur Daten mit passender BereichID anzeigen
                    const tr = document.createElement('tr');

                    // ID-Spalte
                    const tdId = document.createElement('td');
                    tdId.textContent = row.id;
                    tr.appendChild(tdId);

                    // FormulierungenID-Spalte
                    const tdFormulierungenID = document.createElement('td');
                    tdFormulierungenID.textContent = row.FormulierungenID;
                    tr.appendChild(tdFormulierungenID);

                    // Text-Spalte
                    const tdText = document.createElement('td');
                    tdText.textContent = row.Text;
                    tr.appendChild(tdText);                    

                    // tbody.appendChild(tr);
                    massnahmenTabelle.appendChild(tr);
                }
            });
            // massnahmenTabelle.appendChild(tr);
        })
        .catch(error => {
            console.error('Fehler beim Laden der formulierungen JSON-Datei:', error);
        });
}