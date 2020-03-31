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
var modal = document.getElementById("addLot");

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

// Get the pop up
var success = document.getElementById("lotAdded");


// Get the <span> element that closes the pop up
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the pop up
span.onclick = function() {
  success.style.display = "none";
}

// When the user clicks anywhere outside of the pop up, close it
window.onclick = function(event) {
  if (event.target == success) {
    success.style.display = "none";
  }
}
