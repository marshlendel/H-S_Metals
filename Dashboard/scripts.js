// **************************************************************************
// * Copyright 2020 Marshall Brown, Josiah Schmidt, Micah Withers
// *
// * Unless required by applicable law or agreed to in writing, software
// * distributed under the License is distributed on an "AS IS" BASIS,
// * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or
// * See the License for the specific language governing permissions and
// * limitations under the License.
// **************************************************************************

export function setupAddLot() {
    // Get the pop up
    var modalLot = document.getElementById("addLot");

    // Get the button that opens the pop up
    var btnLot = document.getElementById("myBtnLot");

    // Get the <span> element that closes the pop up
    var spanLot = document.getElementById("spanLot");

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

export function setupAddCust() {
    //  JS for Add Customer dialogue when button is clicked (User Story 4.4.1)

    // Get the pop up
    var modalCust = document.getElementById("addCust");

    // Get the <span> element that closes the pop up
    var spanCust = document.getElementById("spanCust");

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
        // When the user clicks on <span> (x), close the pop up
        spanCust.onclick = function() {
            modalCust.style.display = "none";
            modalLot.style.display = "block";
        }
    }
    else {
        window.onclick = function(event) {
          if (event.target == modalCust) {
              modalCust.style.display = "none";
          }
        }
        // When the user clicks on <span> (x), close the pop up
        spanCust.onclick = function() {
            modalCust.style.display = "none";
        }
    }
}

export function setupBoth() {
    setupAddLot();
    setupAddCust();
}

export var statusVals = ["Dirty", "Clean", "Partially-Shipped", "Shipped"];
export var addCustBtnId = "myBtnCust";

export function createBoldLabel(string) {
    let bold = document.createElement("B");
    bold.innerHTML = string;
    let label = document.createElement("LABEL");
    label.appendChild(bold);
    return label;
}

export function custAdd(elemID, custVals) {
	let inputCust = document.getElementById(elemID);
	let cust;
    let value;
	stringifyRows(['company'], custVals);
    for (let index = 0; index < custVals.length; ++index) {
        cust = document.createElement("OPTION");
        value = custVals[index]['company'];
        cust.setAttribute('value', value);
        cust.innerHTML = value;
        inputCust.appendChild(cust);
    }
}
// US 5.3: Capitalizes each word in string and returns the result
export function toUpper(string) {
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
export function createHeaders(tableId, headers, rows) {
    console.log("createHeaders called ");
    let table = document.getElementById(tableId);
    let header = table.createTHead();
    // Add click listener to sort table by the clicked header
    header.addEventListener('click', function(ev) {
        sortTable(ev, tableId, headers, rows);
    }, false);
    header.setAttribute('id', 'tHead');
    header.setAttribute('for', -1);
    let row = header.insertRow(0);
    let cell;
    let label;
    // Creates header labels
    for (let cellNum = 0; cellNum < headers.length; ++cellNum) {
        // console.log(cellNum);
        cell = document.createElement('TH');
        label = headers[cellNum];
        cell.setAttribute('id', label);
        cell.setAttribute('for', cellNum);
        cell.innerHTML = toUpper(label == 'lotnum' ? 'Lot' : label);
        row.appendChild(cell);
    }
}

// US 5.3: Removes all rows in table (if they exist) and replaces them with
//      values in "rows"
export function updateTable(tableId, headers, rows) {
    console.log("updateTable called");
    // Create table body if one does not exist
    let table = document.getElementById(tableId);
    let body;
    if (table.tBodies.length < 1) {
        body = table.createTBody();
        body.setAttribute('id', 'tBody');
    }
    else {
        body = table.tBodies[0];
    }
    // Create rows and add to table body (tBody)
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

// US 4.2: Helper function for retrieving data from database
export function stringifyRows(fields, rows) {
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

// US 5.3: The following functions compare the fields between each row
export function cmpCust(row1, row2) {
    if (row1['customer'].toUpperCase() < row2['customer'].toUpperCase()) {
        return -1;
    }
    else if (row1['customer'].toUpperCase() > row2['customer'].toUpperCase()) {
        return 1;
    }
    return 0;
}

export function cmpDate(row1, row2) {
    if (row1['date'] < row2['date']) {
        return -1;
    }
    else if (row1['date'] > row2['date']) {
        return 1;
    }
    return 0;
}

export function cmpStatus(row1, row2) {
    if (row1['status'] < row2['status']) {
        return -1;
    }
    else if (row1['status'] > row2['status']) {
        return 1;
    }
    return 0;
}

export function cmpNum(row1, row2) {
    return row1['lotnum'] - row2['lotnum'];
}

// US 5.3: Function sorts rows using the comparison function correspponding to the field
export function sortRows(rows, sortField, reverse) {
    switch (sortField) {
        case "customer":
            // console.log("Sorting by "+ sortField);
            rows.sort(cmpCust);
            break;
        case "date":
            // console.log("Sorting by "+ sortField);
            rows.sort(cmpDate);
            break;
        case "status":
            // console.log("Sorting by "+ sortField);
            rows.sort(cmpStatus);
            break;
        case "lotnum":
            // console.log("Sorting by "+ sortField);
            rows.sort(cmpNum);
            break;
        default:
            // console.log("Cannot sort by "+sortField);
            reverse = false;
    }
    if (reverse) {
        // console.log("Rows reversed");
        rows.reverse();
    }
}

// US 5.3: Sorts table by the id of the element clicked
// (i.e. if 'Customer' is clicked, table is sorted by 'customer')
export function sortTable(ev, tableId, headers, rows) {
    let elmtId = ev.target.id;
    if (ev.target != ev.currentTarget && elmtId != 'type' && elmtId != 'amount') {
        console.log("Element clicked: id='"+elmtId+"'");
        let element = document.getElementById(elmtId);
        if (elmtId == 'status') {
            element.setAttribute('for', 4);

        }
// If order is ascending, it becomes descending and vise versa
        let header = document.getElementById('tHead');
        let reverse = header.getAttribute('for') == element.getAttribute('for') ? true : false;
        header.setAttribute('for', element.getAttribute('for'));
        sortRows(rows, elmtId, reverse);
        if (reverse) {
            header.setAttribute('for', -1);
        }
        updateTable(tableId, headers, rows);
    }

    ev.stopPropagation();
}

export function createTable(elemId, tableId, rows, fields) {
    console.log("createTable called");
    console.log(fields);
    let table = document.createElement("TABLE");
    table.setAttribute("id", tableId);
    document.getElementById(elemId).appendChild(table);
    createHeaders(tableId, fields, rows);
    updateTable(tableId, fields, rows);
}
