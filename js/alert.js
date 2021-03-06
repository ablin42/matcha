function dismissAlert(closeBtn)
{
    var alert = closeBtn.parentElement,
        wrap = document.getElementById("alertwrapper");
    if (wrap)
        wrap.remove();
    alert.remove();
}

function addAlert(alert, where)
{
    let node = document.createElement('div'),
        alertDiv = document.getElementById("alert"),
        wrap = document.getElementById("alertwrapper");

    node.setAttribute("id", "alertwrapper");
    if (alertDiv){
        if (wrap)
            wrap.remove();
        else
            alertDiv.remove();
    }
    node.innerHTML += alert;
    where.parentNode.appendChild(node);
}