function OpenBereich() {
    fetch('JSON/bereich.json')
        .then(response => response.json())
        .then(data => {
            tableData = data;
            console.log("OpenBereich : Filename= " + response);
            // Anzahl der zusätzlichen Spalten ermitteln
            // additionalColumns = getMaxAdditionalColumns(tableData.details);
        //  renderTableBereich();
        })
        .catch(error => console.error('Error loading Bereich.JSON:', error));
}

function renderTableBereich() {
    const table = document.getElementById('dataTable');
    table.innerHTML = '';
    let ColumnIndex = 0; 
    // Add table headers


    const thead = document.createElement('thead');
    const trHeader = document.createElement('tr');

    const thBereich = document.createElement('th');
    thBereich.textContent = 'Text';
    thBereich.id = 'HeadBereich';
    trHeader.appendChild(thBereich);

    // const thZieleBeschreibung = document.createElement('th');
    // thZieleBeschreibung.textContent = 'Ziele';
    // thZieleBeschreibung.id = 'HeadZiele';
    // trHeader.appendChild(thZieleBeschreibung);

    // const th3 = document.createElement('th');
    // th3.textContent = 'Auswahl';
    // th3.id = 'HeadAuswahl';
    // trHeader.appendChild(th3);

    thead.appendChild(trHeader);
    table.appendChild(thead);

    // Apply CSS to fix the header
    table.style.position = 'relative';
    table.style.borderCollapse = 'collapse';
    thead.style.position = 'sticky';
    thead.style.top = '0';
    thead.style.backgroundColor = '#f1f1f1';
    thead.style.zIndex = '1';

}