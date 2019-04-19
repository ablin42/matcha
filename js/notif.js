$(document).ready(function() {
    fetch('utils/fetch_notif.php', {
        method: 'post',
        mode: 'same-origin',
    })
        .then((res) => res.text())
        .then(function(data){
            var lines = data.split('\n');
            document.getElementById('nbnotif').innerText = lines[1];
            lines.splice(1, 1);
            newdata = lines.join('\n');
            document.getElementById('dropdown-notif-content').innerHTML = newdata;
        })
        .catch((error) => console.log(error));
});

var updateNotif = setInterval(function () {
    fetch('utils/fetch_notif.php', {
        method: 'post',
        mode: 'same-origin',
    })
        .then((res) => res.text())
        .then(function(data){
            var lines = data.split('\n');
            document.getElementById('nbnotif').innerText = lines[1];
            lines.splice(1, 1);
            newdata = lines.join('\n');
            document.getElementById('dropdown-notif-content').innerHTML = newdata;
        })
        .catch((error) => console.log(error));
}, 5000);

function dropDown() {
    console.log("'",document.getElementById("dropdown-notif-content").innerHTML,"'", document.getElementById("dropdown-notif-content").innerHTML.localeCompare("  "));
    if (document.getElementById("dropdown-notif-content").innerHTML.localeCompare("  ") !== -1)
        document.getElementById("dropdown-notif-content").classList.toggle("show");
}

function removeNotif(notif){
    let idnotif = notif.id.substr(6);
    fetch('utils/clear_notif.php', {
        method: 'post',
        mode: 'same-origin',
        body: JSON.stringify({
            notif: idnotif
        })
    })
        .then((res) => res.text())
        .then(function(data){
            addAlert(data, document.getElementById("header"));
            if (data.indexOf("deleted") !== -1){
                notif.remove();
                let nbnotif = document.getElementById('nbnotif').innerText - 1;
                if (nbnotif > 0)
                    document.getElementById('nbnotif').innerText = nbnotif;
            }
        })
        .catch((error) => console.log(error));
}