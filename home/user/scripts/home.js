const searchIcon = document.getElementById('search-icon');
const searchBox = document.getElementById('search-box');

searchIcon.addEventListener('click', () => {
  searchBox.classList.toggle('active');
});

$(document).ready(function() {
    function loadDefaultData() {
        location.reload();
  }

  $('#search_text').keyup(function () {
      var search_text = $(this).val();
      if (search_text != '') {
          $.ajax({
              url: "../home/user/ajax/search.php",
              method: "POST",
              data: { search_text: search_text },
              success: function (data) {
                  $('#result').html(data);
                  $('#or').html('');
              }
          });
      }
       else {
          $('#result').html('');
          loadDefaultData(); 
        }
  });
});