// var rev = document.getElementById("rev");
// var revcon = document.getElementById("revcon");




// rev.addEventListener("click", function() {
//     revcon.style.display = "block";
//   });
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
  revcon.style.display = "none";
};

window.onclick = function(event) {
  if (event.target == modal) {
    revcon.style.display = "none";
  }
};

