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

function toUpper(string) {
    console.log("toUpper("+string+")");
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

function createHeaders(id, headers) {
    console.log("Headers: ");
    console.log(headers);
    let table = document.getElementById(id);
    let header = table.createTHead();
    let row = header.insertRow(0);
    let cell;
    let label;
    for (let cellNum = 0; cellNum < headers.length; ++cellNum) {
        cell = row.insertCell(cellNum);
        label = headers[cellNum];
        console.log(label);
        cell.innerHTML = toUpper(label == 'lotnum' ? 'Lot' : label);
    }
}

function updateTable(id, headers, rows) {
    console.log("Rows: ");
    console.log(rows);
    let table = document.getElementById(id);
    let body = table.createTBody();
    while (body.rows.length > 0) {
        body.deleteRow(0);
    }
    let row;
    let cell;
    let head;
    for (let rowNum = 0; rowNum < rows.length; ++rowNum) {
        console.log("Row "+JSON.stringify(rowNum));
        console.log(rows[rowNum]);
        row = body.insertRow(rowNum);
        for (let cellNum = 0; cellNum < Object.keys(rows[rowNum]).length; ++cellNum) {
            cell = row.insertCell(cellNum);
            head = headers[cellNum]
            console.log(head);
            console.log(rows[rowNum][head]);
            cell.innerHTML = toUpper(JSON.stringify(rows[rowNum][head]));
        }
    }
}
