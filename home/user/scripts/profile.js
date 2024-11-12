var eventsButton = document.getElementById("eventsButton");
var clientButton = document.getElementById("clientButton");
var postButton = document.getElementById("postButton");
var requestButton = document.getElementById("requestButton");
var skillButton = document.getElementById("skillButton");
var offerButton = document.getElementById("offerButton");

var review = document.getElementById("review");


var skillsContent = document.getElementById("skillsContent");
var clientsContent = document.getElementById("clientsContent");
var postContent = document.getElementById("postContent");
var eventContent = document.getElementById("eventContent");
var requestContent = document.getElementById("requestContent");
var skillContent = document.getElementById("skillContent");
var offerContent = document.getElementById("offerContent");


eventsButton.addEventListener("click", function() {
  skillsContent.innerHTML = eventContent.innerHTML;
});



clientButton.addEventListener("click", function() {
  skillsContent.innerHTML = clientsContent.innerHTML;
});



postButton.addEventListener("click", function() {
  skillsContent.innerHTML = postContent.innerHTML;
});



requestButton.addEventListener("click", function() {
  skillsContent.innerHTML = requestContent.innerHTML;
});


skillButton.addEventListener("click", function() {
    skillsContent.innerHTML = skillContent.innerHTML;
  });


  offerButton.addEventListener("click", function() {
    skillsContent.innerHTML = offerContent.innerHTML;
  });



function removereq(id) {
  const xhr = new XMLHttpRequest();
  xhr.open('POST', 'deleterequest.php', true);
  xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4 && xhr.status === 200) {
      console.log(xhr.responseText);
      skillsContent.innerHTML = requestContent.innerHTML;
    }
  };
  xhr.send('id=' + encodeURIComponent(id));
  location.reload();
}





review.addEventListener("click", function() {
    modal.style.display = "display";
  });
  
