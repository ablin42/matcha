function dismissAlert(closeBtn)
{
    var alert = closeBtn.parentElement;
    alert.remove();
}

function addAlert(alert, where)
{
    let node = document.createElement('div'),
        alertDiv = document.getElementById("alert");

    if (alertDiv)
        alertDiv.parentNode.parentNode.removeChild(alertDiv.parentNode);
    node.innerHTML += alert;
    insertAfter(node, where);
}