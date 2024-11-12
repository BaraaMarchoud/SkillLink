var reviewButtons = document.querySelectorAll('.btn.review');
  var rmodal = document.getElementById("");

  var span = document.getElementsByClassName("close-button")[0];
  var submitBtn = document.querySelector(".submitrev");

  reviewButtons.forEach(function (btn) {
    btn.addEventListener('click', function () {
      modal.style.display = "block";
      var postIDInput = this.closest('.post-card').querySelector('input[name="post_id"]');
      var postID = postIDInput.value;
      document.getElementById("postid").value = postID;
    });
  });

  span.onclick = function () {
    modal.style.display = "none";
  };

  window.onclick = function(event) {
    var modal = document.getElementById("reviewModal");
    var rmodal = document.getElementById("rateModal");
    if (event.target === modal || event.target === rmodal) {
        modal.style.display = "none";
        rmodal.style.display = "none";
    }
};