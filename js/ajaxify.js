function loadComments(idImg)
{
    var xhttp = new XMLHttpRequest(),
        lastId = document.querySelectorAll('.comment'),
        where = document.getElementById("comments"),
        loader = document.getElementById("loader"),
        div = document.createElement('div');

    loader.setAttribute("style", "display:block;");
    if (lastId.length !== 0)
        lastId = lastId[0].getAttribute("id");
    else
        lastId = 1;

    xhttp.open("POST", "utils/load_comments.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(`id_img=${idImg}&lastid=${lastId}`);

    setTimeout(function (){
        if (xhttp.responseText)//on success
        {
            div.innerHTML += xhttp.responseText;
            where.insertBefore(div, where.childNodes[0]);
            loader.removeAttribute("style");
        }
        else
            loader.removeAttribute("style");
    }, 1500);
}

function loadPictures()
{
    var xhttp = new XMLHttpRequest(),
        lastId = document.querySelectorAll('.your-img'),
        where = document.getElementById("your_pictures"),//where to insert
        loader = document.getElementById("loader"),//loader
        div = document.createElement('div');

    loader.setAttribute("style", "display:block; top:0");
    if (lastId.length !== 0)
        lastId = lastId[0].getAttribute("id").substring(4);
    else
        lastId = 1;

    xhttp.open("POST", "utils/load_pictures.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(`lastid=${lastId}`);

    setTimeout(function (){
        if (xhttp.responseText)//on success
        {
            div.innerHTML += xhttp.responseText;
            insertAfter(div, where);
            loader.removeAttribute("style");
        }
        else
            loader.removeAttribute("style");
    }, 1500);
}

function submitCheckbox(checkbox)
{
    cooldown(checkbox);
    var xhttp = new XMLHttpRequest(),
        target = checkbox.getAttribute("id"),
        checked = 0,
        state = "disabled",
        msg = " mail notifications!",
        alertDiv = document.getElementById("alert"),
        where = document.getElementById("header");

    if (checkbox.checked) {
        checked = 1;
        state = "enabled";
    }
    if (target === "scrolling")
        msg = " infinite scrolling!";
    xhttp.open("POST", `utils/modify_account.php`, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(`form=${target}&state=${checked}`);
    var div = document.createElement('div');
    div.setAttribute("style", "position:fixed; top:5%;z-index:10;width:100%;");
    if (alertDiv)
        alertDiv.remove();

    div.innerHTML +=    `  <div id=\"alert\" class=\"alert alert-info\" style=\"text-align: center;\" role=\"alert\">You <b>${state}</b> ${msg}\n ` +
                        "     <button type=\"button\" class=\"close\" onclick=\"dismissAlert(this)\" data-dismiss=\"alert\" aria-label=\"Close\">\n" +
                        "         <span aria-hidden=\"true\">&times;</span>\n" +
                        "     </button>\n" +
                        "  </div>";
    insertAfter(div, where);
}

function submitForm(form, url)
{
    var xhttp = new XMLHttpRequest(),
        formTarget = form.getAttribute("name"),
        tosend = `form=${formTarget}&`,
        children = form.children,
        childNb = form.childElementCount,
        inputs = [],
        inputId = [],
        inputElem = [],
        inputValue = [],
        alertDiv = document.getElementById("alert"),
        where = document.getElementById("header"),
        div = document.createElement('div');

    cooldown(document.getElementById(`submit_${formTarget}`));
    for (i = 0; i < childNb; i++) {
        if (children[i].getElementsByTagName('input').length !== 0 || children[i].getElementsByTagName('textarea').length !== 0)
        {
            if (children[i].getElementsByTagName('textarea').length !== 0)
                inputs.push(children[i].getElementsByTagName('textarea'));
            else
                inputs.push(children[i].getElementsByTagName('input'));
            inputId.push(inputs[i][0].id);
            inputElem.push(document.getElementById(inputId[i]));
            inputValue.push(inputElem[i].value);
            if (i !== 0)
                tosend += '&';
            tosend += `${inputId[i]}=${inputValue[i]}`;
        }
    }

    xhttp.open("POST", `utils/${url}.php`, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(tosend);

    div.setAttribute("style", "position:fixed; top:5%;z-index:10;width:100%;");
    setTimeout(function (){
        if (alertDiv)
            alertDiv.remove();
        div.innerHTML += xhttp.responseText;
        insertAfter(div, where);
        if (url === "post_comment")
            loadComments(inputValue[1]);
        if (url === "post_picture")
            loadPictures();
        if (xhttp.responseText.search("logged in") !== -1) {
            setTimeout(function (){window.location.href = "/Camagru/";}, 500);}
        if (xhttp.responseText.search("Please, log in") !== -1) {
            setTimeout(function (){window.location.href = "/Camagru/";}, 2000);}
    }, 1500);

    //console.log(inputs); console.log(inputId); console.log(inputElem); console.log(inputValue); console.log(tosend);
    return false;
}

function deleteImg(id)
{
    var xhttp = new XMLHttpRequest(),
        alertDiv = document.getElementById("alert"),
        where = document.getElementById("header"),
        div = document.createElement('div'),
        img = document.getElementById(`img_${id}`);

    xhttp.open("POST", `utils/delete_picture.php`, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(`id=${id}`);

    div.setAttribute("style", "position:fixed; top:5%;z-index:10;width:100%;");
    setTimeout(function (){
        if (img && xhttp.responseText.search("success") !== -1)
            img.remove();
        if (alertDiv)
            alertDiv.remove();
        div.innerHTML += xhttp.responseText;
        insertAfter(div, where);
    }, 1500);
   return false;
}