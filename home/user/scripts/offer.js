const searchIcon = document.getElementById('search-icon');
const searchBox = document.getElementById('search-box');

searchIcon.addEventListener('click', () => {
    searchBox.classList.toggle('active');
});

function Search(str) {
    if (str.length == 0) {
        location.reload();
        return;
    }else{
    fetch(`ajax/offer.php?q=${str}`)
        .then(response => response.text())
        .then(data => {
            document.querySelector("#result").innerHTML = data;
            document.querySelector("#or").innerHTML = "";
        })
        .catch(error => console.log(error));
    }
}