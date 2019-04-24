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

function notifRedirect(e, notif) {
    e.preventDefault();
    let url = notif.href;
    setTimeout(function () {
        window.location.href = url;
    }, 750);
}


function dropDown() {
    if (document.getElementById("dropdown-notif-content").innerHTML.localeCompare('  ') !== -1)
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
                else if (nbnotif === 0)
                    document.getElementById("dropdown-notif-content").classList.toggle("show");
            }
        })
        .catch((error) => console.log(error));
}