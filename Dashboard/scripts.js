// **************************************************************************
// * Copyright 2020 Marshall Brown, Josiah Schmidt, Micah Withers
// *
// * Unless required by applicable law or agreed to in writing, software
// * distributed under the License is distributed on an "AS IS" BASIS,
// * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or
// * See the License for the specific language governing permissions and
// * limitations under the License.
// **************************************************************************

export function setupPopup(popupId, spanId, btnId) {
    //  JS for Add Customer dialogue when button is clicked (User Story 4.4.1)

    // Get the pop up
    var modal = document.getElementById(popupId);

    // Get the <span> element that closes the pop up
    var span = document.getElementById(spanId);

    // Get button to display popup
    var btn = document.getElementById(btnId);

    // When the user clicks anywhere outside of the pop up, close it
    window.onclick = function(event) {
      if (event.target == modal) {
          modal.style.display = "none";
      }
    }
    // When the user clicks on <span> (x), close the pop up
    span.onclick = function() {
        modal.style.display = "none";
    }

    btn.onclick = function() {
        modal.style.display = "block";
    }
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

// Create containers for data to be viewed
export function createTable(tableId, ncolumns, nrows) {
    console.log("Creating table with "+ncolumns.toString()+" columns and "+nrows.toString()+" rows");
    // Get table container
    let table = document.getElementById(tableId);

    // Create containers for table headers
    for (let col = 0; col < ncolumns; ++col) {
        // Create div element to contain checkboxes
        let contElem = document.createElement('div');
        contElem.setAttribute('class', 'column');
        if (col == 0) {
            contElem.setAttribute('id', 'first');
        }
        // Create div to contain header
        let elem = document.createElement('div');
        elem.setAttribute('class', 'header');
        // elem.setAttribute('style', 'order: '+ col.toString());
        let head = document.createElement('h3');
        head.setAttribute('class', 'field');
        elem.appendChild(head);
        contElem.appendChild(elem);

        for (let row = 0; row < nrows; ++row) {
            // Create div for data
            let elem = document.createElement('div');
            elem.setAttribute('class', 'data');
            // elem.setAttribute('style', 'order: '+ col.toString());
            // Add data div to column
            contElem.appendChild(elem);
        }
        // Add column div to table
        table.appendChild(contElem);
    }
}

export function setColumnNames(tableId, fields) {
    console.log("Filling table with data correspponding to the following fields");
    console.log(fields);
    // Get table, header, and data elements and check that the inputs are valid
    let table = document.getElementById(tableId);
    let headerElems = table.getElementsByClassName('field');
    let numFields = fields.length;
    if (headerElems.length != numFields) {
        console.log("The number of header elements ("+headerElems.length.toString()+
                    ") does not equal the number of fields ("+numFields.toString()+")"
        );
        return;
    }
    // Sets the column fields
    for (let col = 0; col < numFields; ++col) {
        headerElems[col].innerHTML = fields[col];
    }
}

// US 5.3, 7.5: fills table element with headers and data
export function setData(tableId, fields, rows) {
    console.log("Filling table with data correspponding to the following fields");
    console.log(fields);
    // Get table and data elements and check that the inputs are valid
    let table = document.getElementById(tableId);
    let numFields = fields.length;
    let numDataElems = table.getElementsByClassName('data').length;
    let numCells = rows.length*numFields;
    if (numDataElems != numCells) {
        console.log("The number of data elements ("+numDataElems.toString()+
                    ") does not equal the number of rows ("+numCells.toString()+")"
        );
        return;
    }
    let columns = table.getElementsByClassName('column');
    // Sets data in the table
    let elemCount = 0;
    for (let col = 0; col < numFields; ++col) {
        let column = columns[col];
        let dataElems = column.getElementsByClassName('data');
        for (let row = 0; row < rows.length; ++row) {
            dataElems[row].innerHTML = rows[row][fields[col]];
            ++elemCount;
        }
    }
}

// US 5.3: The following functions compare the fields between each row
export function cmpString(field) {
    return function (row1, row2) {
        if (row1[field] < row2[field]) {
            return -1;
        }
        else if (row1[field] > row2[field]) {
            return 1;
        }
        return 0;
    }
}

export function cmpNumber(field) {
    return function (row1, row2) {
        return row1[field] - row2[field];
    }
}

// Helper function for sorting tables
export function resetSortOrder(tableId) {
    console.log("Resetting sort order");
    let fields = document.getElementById(tableId).getElementsByClassName('field');
    for (let index = 0; index < fields.length; ++index) {
        // 'for' attribute is set to 0 when there is no order
        fields[index].setAttribute('for', 0);
    }
}

// US 5.3: Function sorts rows using the comparison function correspponding to the field
export function sortRows(tableId, rows, sortField, reverse=false) {
    console.log("Sorting by "+sortField);
    if (isNaN(rows[0][sortField])) {
        rows.sort(cmpString(sortField));
    }
    else {
        rows.sort(cmpNumber(sortField));
    }
    if (reverse) {
        console.log("reverse");
        rows.reverse();
    }
    else {
        console.log("not reverse");
    }
}

export function makeSortable(tableId, fields, rows, initialSortField) {
    let headerElems = document.getElementById(tableId).getElementsByClassName("field");
    resetSortOrder(tableId);
    // Sets the column fields
    for (let col = 0; col < fields.length; ++col) {
        let field = fields[col];
        if (field == initialSortField) {
            headerElems[col].setAttribute('for', 1);
        }
        let parent = headerElems[col].parentElement;
        parent.addEventListener('click', function (){
                    // Rows are reversed if order is 1, otherwise -1
                    let order = headerElems[col].getAttribute('for') == 1;
                    sortRows(tableId, rows, field, order);
                    setData(tableId, fields, rows);
                    resetSortOrder(tableId);
                    if (order) {
                        headerElems[col].setAttribute('for', -1);
                    }
                    else {
                        headerElems[col].setAttribute('for', 1);
                    }
            }, false);
    }
}

export function makeTable(tableId, fields, rows, headers, initialSortField="") {
    console.log(fields);
    console.log(rows);
    stringifyRows(fields, rows);
    sortRows(tableId, rows, initialSortField, false);
    createTable(tableId, fields.length, rows.length)
    setColumnNames(tableId, headers);
    setData(tableId, fields, rows);
    if (initialSortField) {
        makeSortable(tableId, fields, rows, initialSortField);
    }
}
