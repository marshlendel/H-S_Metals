// **************************************************************************
// * Copyright 2020 Marshall Brown, Josiah Schmidt, Micah Withers
// *
// * Unless required by applicable law or agreed to in writing, software
// * distributed under the License is distributed on an "AS IS" BASIS,
// * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or
// * See the License for the specific language governing permissions and
// * limitations under the License.
// **************************************************************************

// Get the pop up
var modal = document.getElementById("addCust");

// Get the button that opens the pop up
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the pop up
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the pop up
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the pop up
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the pop up, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
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
