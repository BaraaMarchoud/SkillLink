var modal = document.getElementById('requestModal');
var btns = document.querySelectorAll('.overlay-button');
var span = document.getElementsByClassName("close-button")[0];
var receivedUsernameInput = document.getElementById("receivedusername");

btns.forEach(function(btn) {
  btn.onclick = function() {
    modal.style.display = "block";
    receivedUsernameInput.value = this.closest('.skiller-card').querySelector('p').textContent;
  };
});

span.onclick = function() {
  modal.style.display = "none";
};

window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
};



const searchIcon = document.getElementById('search-icon');
const searchBox = document.getElementById('search-box');

searchIcon.addEventListener('click', () => {
  searchBox.classList.toggle('active');
});

function Search(str) {
  if (str.length == 0) {
   location.reload();
      return;
  }
  fetch(`../user/ajax/find_search.php?q=${str}`)
      .then(response => response.text())
      .then(data => {
          document.querySelector(".skiller").innerHTML = data;
          
      })
      .catch(error => console.log(error));
}