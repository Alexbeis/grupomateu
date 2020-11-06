const PreTableCreator = function (element) {
    this.element = document.querySelector(element);
};

PreTableCreator.prototype.createSuccessTable  = function(data) {

    const tbody = document.createElement('tbody');
    tbody.appendChild(this.createHeaders());

    for (let i = 0; i <  data.length; ++i) {
        this.createRow(tbody, data[i], i)
    }

    this.element.appendChild(tbody);
};

PreTableCreator.prototype.createRow = function(tbody, rowData, i){
    let row = document.createElement('tr');
    tbody.appendChild(
        this.createCells(
            rowData,
            row,
            i+1)
    );
};

PreTableCreator.prototype.createCells = function(element, row, index) {

    let indexCell = document.createElement('td');
    indexCell.appendChild(document.createTextNode(index));
    row.appendChild(indexCell);

    for (let key in element) {
        let td = document.createElement('td');
        switch (key) {
            case 'name':
                td.appendChild(document.createTextNode(`${element[key]} (${element['code']})`));
                row.setAttribute('id', element['code']);
                row.appendChild(td);
                break;
            case 'count':
                let span = document.createElement('span');
                span.classList.add('badge', 'bg-red');
                span.innerHTML = element[key];
                td.appendChild(span);
                row.appendChild(td);
                break;
        }
    }

    let tdButton = document.createElement('td');
    let buttonValidate = document.createElement('button');
    buttonValidate.classList.add('btn', 'btn-warning', 'btn-xs', 'js-validate');
    buttonValidate.appendChild(document.createTextNode('Validar'));
    let buttonGenerate = document.createElement('button');
    buttonGenerate.classList.add('btn', 'btn-warning', 'btn-xs', 'js-generate');
    buttonGenerate.appendChild(document.createTextNode('Generar'));
    tdButton.appendChild(buttonValidate);
    tdButton.appendChild(buttonGenerate);

    row.appendChild(tdButton);

    return row;
};

PreTableCreator.prototype.createHeaders = function() {

    let row = document.createElement('tr');
    let indexCell = document.createElement('th');
    let expCell = document.createElement('th');
    let markedCell = document.createElement('th');
    let actionsCell = document.createElement('th');

    indexCell.style.width='10px';
    expCell.appendChild(document.createTextNode('Explotación'));
    markedCell.style.width='40px';

    markedCell.appendChild(document.createTextNode('#Marcados'));
    actionsCell.appendChild(document.createTextNode('Acciones'));

    row.appendChild(indexCell);
    row.appendChild(expCell);
    row.appendChild(markedCell);
    row.appendChild(actionsCell);

    return row;
};

PreTableCreator.prototype.resetTable = function () {
  this.element.innerHTML = '';
};


export default PreTableCreator;