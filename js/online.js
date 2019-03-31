$(document).ready(function() {
    fetch('utils/user_online.php', {
        method: 'post',
        mode: 'same-origin',
    })
        .then((res) => res.text())
        .catch((error) => console.log(error));
});

var stillAlive = setInterval(function () {
    fetch('utils/user_online.php', {
        method: 'post',
        mode: 'same-origin',
    })
        .then((res) => res.text())
        .catch((error) => console.log(error));
}, 60000);