// **************************************************************************
// * Copyright 2020 Marshall Brown, Josiah Schmidt, Micah Withers
// *
// * Unless required by applicable law or agreed to in writing, software
// * distributed under the License is distributed on an "AS IS" BASIS,
// * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or
// * See the License for the specific language governing permissions and
// * limitations under the License.
// **************************************************************************

function setupAddLot() {
    // Get the pop up
    var modalLot = document.getElementById("addLot");

    // Get the button that opens the pop up
    var btnLot = document.getElementById("myBtnLot");

    // Get the <span> element that closes the pop up
    var spanLot = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the pop up
    btnLot.onclick = function() {
      modalLot.style.display = "block";
    }

    // When the user clicks on <span> (x), close the pop up
    spanLot.onclick = function() {
      modalLot.style.display = "none";
    }

    window.onclick = function(event) {
      if (event.target == modalLot) {
        modalLot.style.display = "none";
      }
    }
}

function setupAddCust() {
    //  JS for Add Customer dialogue when button is clicked (User Story 4.4.1)

    // Get the pop up
    var modalCust = document.getElementById("addCust");

    // Get the <span> element that closes the pop up
    var span = document.getElementsByClassName("close");
    var spanCust = span[span.length-1];

    // When the user clicks on <span> (x), close the pop up
    spanCust.onclick = function() {
      modalCust.style.display = "none";
    }
    var modalLot = document.getElementById("addLot");
    // When the user clicks anywhere outside of the pop up, close it
    if (typeof modalLot != 'undefined') {
        window.onclick = function(event) {
          if (event.target == modalLot) {
            modalLot.style.display = "none";
          }
          if (event.target == modalCust) {
              modalCust.style.display = "none";
              modalLot.style.display = "block";
          }
        }
    }
    else {
        console.log("modalLot is not defined");
        window.onclick = function(event) {
          if (event.target == modalCust) {
              modalCust.style.display = "none";
          }
        }
    }
}

function setupBoth() {
    setupAddLot();
    setupAddCust();
}

var typeVals = ["Ingot", "S", "MS"];
var statusVals = ["Dirty", "Clean", "Finished", "Gone"];
var palletsDivId = "pallets-div";
var lotDivId = "lotbox";
var addCustBtnId = "myBtnCust";
var addPalBtnId = "addPal";
var rmvPalBtnId = "rmvPal";

function createBoldLabel(string) {
    let bold = document.createElement("B");
    bold.innerHTML = string;
    let label = document.createElement("LABEL");
    label.appendChild(bold);
    return label;
}

function addPallet(palletsDivId) {
    let palletsDiv = document.getElementById(palletsDivId);
    let pallet = document.createElement("P");
    let numPallets = palletsDiv.getElementsByTagName("P").length;
    let newNum = numPallets + 1;
    console.log("Adding Pallet "+newNum.toString());
    pallet.setAttribute("id", "pallet"+newNum.toString());
    palletsDiv.appendChild(pallet);
    pallet.appendChild(createBoldLabel("Pallet "+newNum.toString()));
    pallet.appendChild(document.createElement("BR"));

    let amt = createBoldLabel("Amount");
    amt.setAttribute('for', 'amt');
    pallet.appendChild(amt);
    let input = document.createElement("INPUT");
    input.required = true;
    input.setAttribute('type', 'number');
    input.setAttribute('name', 'amt');
    pallet.appendChild(input);
    pallet.appendChild(document.createElement("BR"));

    let typeForm = document.createElement("FORM");
    let formLabel = createBoldLabel("Type");
    formLabel.setAttribute('for', 'type');
    typeForm.appendChild(formLabel);
    let selectType = document.createElement("SELECT");
    selectType.setAttribute('name', 'type');
    selectType.setAttribute('id', 'type');
    let type;
    for (let index = 0; index < typeVals.length; ++index) {
        type = document.createElement("OPTION");
        type.value = typeVals[index];
        type.innerHTML = typeVals[index];
        selectType.appendChild(type);
    }
    typeForm.appendChild(selectType);
    pallet.appendChild(typeForm);

    let statusForm = document.createElement("FORM");
    formLabel = createBoldLabel("Status");
    formLabel.setAttribute('for', 'status');
    statusForm.appendChild(formLabel);
    let selectStatus = document.createElement("SELECT");
    selectStatus.setAttribute('name', 'status');
    selectStatus.setAttribute('id', 'status');
    let status;
    for (let index = 0; index < statusVals.length; ++index) {
        status = document.createElement("OPTION");
        status.setAttribute('value', statusVals[index]);
        status.appendChild(document.createTextNode(statusVals[index]));
        selectStatus.appendChild(status);
    }
    statusForm.appendChild(selectStatus);
    pallet.appendChild(statusForm);

    let rmvBtn = document.getElementById(rmvPalBtnId);
    // Adds an event listener for the remove button
    //    if there was an existing pallet
    if (newNum > 1) {
        rmvBtn.disabled = false;
    }
}

// US 5.2: Removes last pallet in the list
function removePallet(palletsDivId) {
    console.log("Removing Pallet ");
    let palletsDiv = document.getElementById(palletsDivId);
    let size = palletsDiv.getElementsByTagName("P").length;
    console.log(size);
    palletsDiv.getElementsByTagName("P")[size-1].remove();
}

// US 5.1
function createAddLotForm(lotDivId, palletsDivId, addCustBtnId, custVals) {
    console.log("Creating Add Lot Form");
    let lotDiv = document.getElementById(lotDivId);
    let lotForm = document.createElement('FORM');
    lotDiv.appendChild(lotForm);
    let lotNumLabel = createBoldLabel("Lot No.");
    lotNumLabel.setAttribute('for', 'lotnum');
    lotForm.appendChild(lotNumLabel);
    let lotNumInput = document.createElement("INPUT");
    lotNumInput.setAttribute('type', 'number');
    lotNumInput.setAttribute('name', 'lotnum');
    lotNumInput.required = true;
    lotForm.appendChild(lotNumInput);

    let custForm = document.createElement("FORM");
    let formLabel = createBoldLabel("Cust");
    formLabel.setAttribute('for', 'cust');
    custForm.appendChild(formLabel);
    let selectCust = document.createElement("SELECT");
    selectCust.setAttribute('name', 'cust');
    selectCust.setAttribute('id', 'cust');
    let cust;
    let value;
    for (let index = 0; index < custVals.length; ++index) {
        cust = document.createElement("OPTION");
        stringifyRows(cust, ['company']);
        value = custVals[index]['company'];
        cust.setAttribute('value', value);
        cust.innerHTML = value;
        selectCust.appendChild(cust);
    }
    custForm.appendChild(selectCust);
    let addCustBtn = document.createElement("BUTTON");
    addCustBtn.setAttribute('type', 'button');
    addCustBtn.setAttribute('id', addCustBtnId);
    addCustBtn.innerHTML = "+";
    custForm.appendChild(addCustBtn);
    lotForm.appendChild(custForm);
    var modalCust = document.getElementById("addCust");
    // When the user clicks the button, open the pop up
    addCustBtn.onclick = function() {
      modalCust.style.display = "block";
    }
    lotForm.appendChild(document.createElement("BR"));

    let palletsDiv = document.createElement("DIV");
    palletsDiv.setAttribute('id', palletsDivId);
    lotForm.appendChild(palletsDiv);
    let addPalBtn = document.createElement("BUTTON");
    addPalBtn.setAttribute('id', addPalBtnId);
    addPalBtn.setAttribute('type', 'button');
    addPalBtn.innerHTML = "Add Pallet";
    addPalBtn.addEventListener('click', function() {
        console.log("Add Pallet clicked");
        addPallet(palletsDivId);
    }, false);
    let rmvPalBtn = document.createElement("BUTTON");
    rmvPalBtn.setAttribute('id', rmvPalBtnId);
    rmvPalBtn.setAttribute('type', 'button');
    rmvPalBtn.innerHTML = "Remove";
    addPallet(palletsDivId);
    rmvPalBtn.addEventListener('click', function() {
        removePallet(palletsDivId)
    });
    rmvPalBtn.disabled = true;
    lotForm.appendChild(addPalBtn);
    lotForm.appendChild(rmvPalBtn);
    let submitBtn = document.createElement("BUTTON");
    submitBtn.setAttribute('type', 'submit');
    submitBtn.setAttribute('class', 'btnLot');
    submitBtn.innerHTML = "Submit";
    lotForm.appendChild(submitBtn);
}

// US 5.3: Capitalizes each word in string and returns the result
function toUpper(string) {
    let upper = "";
    let list = string.split(" ");
    let word;
    for (let index = 0; index < list.length; ++index) {
        word = list[index];
        upper += isNaN(word) ? word.charAt(0).toUpperCase() + word.slice(1) : word;
        if (index+1 < list.length) {
            upper += " ";
        }
    }

    return upper;
}

// US 5.3: Creates headers for the table for each column name in "headers"
function createHeaders(tableId, headers, rows) {
    console.log("createHeaders called ");
    let table = document.getElementById(tableId);
    let header = table.createTHead();
    header.addEventListener('click', function(ev) {
        sortTable(ev, tableId, headers, rows);
    }, false);
    header.setAttribute('id', 'tHead');
    header.setAttribute('for', -1);
    let row = header.insertRow(0);
    let cell;
    let label;
    for (let cellNum = 0; cellNum < headers.length; ++cellNum) {
        console.log(headers[cellNum]);
        console.log(cellNum);
        cell = row.insertCell(cellNum);
        label = headers[cellNum];
        cell.setAttribute('id', label);
        cell.setAttribute('for', cellNum);
        cell.innerHTML = toUpper(label == 'lotnum' ? 'Lot' : label);
    }
}

// US 5.3: Removes all rows in table (if they exist) and replaces them with
//      values in "rows"
function updateTable(tableId, headers, rows) {
    console.log("updateTable called");
    let table = document.getElementById(tableId);
    let body;
    if (table.tBodies.length < 1) {
        body = table.createTBody();
        body.setAttribute('id', 'tBody');
    }
    else {
        body = table.tBodies[0];
    }
    let nRows = body.getElementsByTagName('tr').length;
    console.log("Rows: " + nRows.toString());
    while (body.getElementsByTagName('tr').length > 0) {
        body.deleteRow(0);
    }
    console.log("Rows deleted: " + nRows.toString());
    let row;
    let cell;
    let head;
    for (let rowNum = 0; rowNum < rows.length; ++rowNum) {
        row = body.insertRow(rowNum);
        for (let cellNum = 0; cellNum < Object.keys(rows[rowNum]).length; ++cellNum) {
            cell = row.insertCell(cellNum);
            head = headers[cellNum]
            cell.innerHTML = rows[rowNum][head];
        }
    }
}

function stringifyRows(fields, rows) {
    console.log("stringifyRows called");
    let field;
    let string;
    for (let rowNum = 0; rowNum < rows.length; ++rowNum) {
        for (let fieldNum = 0; fieldNum < fields.length; ++fieldNum) {
            field = fields[fieldNum];
            string = toUpper(JSON.stringify(rows[rowNum][field]));
            string = string.split('"').length > 1 ? string.split('"')[1] : string;
            rows[rowNum][field] = string;
        }
    }
}

// US 5.3: The following functions compare the fields between
function cmpCust(row1, row2) {
    if (row1['customer'].toUpperCase() < row2['customer'].toUpperCase()) {
        return -1;
    }
    else if (row1['customer'].toUpperCase() > row2['customer'].toUpperCase()) {
        return 1;
    }
    return 0;
}

function cmpDate(row1, row2) {
    if (row1['date'] < row2['date']) {
        return -1;
    }
    else if (row1['date'] > row2['date']) {
        return 1;
    }
    return 0;
}

function cmpStatus(row1, row2) {
    if (row1['status'] < row2['status']) {
        return -1;
    }
    else if (row1['status'] > row2['status']) {
        return 1;
    }
    return 0;
}

function cmpNum(row1, row2) {
    return row1['lotnum'] - row2['lotnum'];
}

function sortRows(rows, sortField, reverse) {
    switch (sortField) {
        case "customer":
            console.log("Sorting by "+ sortField);
            rows.sort(cmpCust);
            break;
        case "date":
            console.log("Sorting by "+ sortField);
            rows.sort(cmpDate);
            break;
        case "status":
            console.log("Sorting by "+ sortField);
            rows.sort(cmpStatus);
            break;
        case "lotnum":
            console.log("Sorting by "+ sortField);
            rows.sort(cmpNum);
            break;
        default:
            console.log("Cannot sort by "+sortField);
            reverse = false;
    }
    if (reverse) {
        console.log("Rows reversed");
        rows.reverse();
    }
}

// Sorts table by the id of the element clicked
// (i.e. if 'Customer' is clicked, table is sorted by 'customer')
function sortTable(ev, tableId, headers, rows) {
    let elmtId = ev.target.id;
    if (ev.target != ev.currentTarget && elmtId != 'type' && elmtId != 'amount') {
        console.log("Element clicked: id='"+elmtId+"'");
        let element = document.getElementById(elmtId);
// If order is ascending, it becomes descending and vise versa
        let header = document.getElementById('tHead');
        let reverse = header.getAttribute('for') == element.getAttribute('for') ? true : false;
        console.log(header.getAttribute('for'));
        console.log(element.getAttribute('for'));
        header.setAttribute('for', element.getAttribute('for'));
        console.log(reverse);
        sortRows(rows, elmtId, reverse);
        if (reverse) {
            header.setAttribute('for', -1);
        }
        updateTable(tableId, headers, rows);
    }

    ev.stopPropagation();
}
