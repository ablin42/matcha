window.addEventListener('scroll', infiniteScroll);

function infiniteScroll(){
    var scrollTop = window.scrollY,
        windowHeight = window.innerHeight
                        || document.documentElement.clientHeight
                        || document.body.clientHeight,
        body = document.body,
        html = document.documentElement,
        documentHeight = Math.max( body.scrollHeight, body.offsetHeight,
        html.clientHeight, html.scrollHeight, html.offsetHeight );

    if (scrollTop === documentHeight - windowHeight) {
        var xhttp = new XMLHttpRequest(),
            lastId = document.querySelectorAll('.gallery-img-wrapper'),
            loader = document.getElementById("loader"),
            where = document.getElementById("gallery-wrapper");

        loader.setAttribute("style", "display:block");
        lastId = lastId[lastId.length - 1].getAttribute("id");

        xhttp.open("POST", "utils/load_gallery.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(`lastid=${lastId}`);
        setTimeout(function (){
            if (xhttp.responseText)//on success
            {
                where.innerHTML += xhttp.responseText;
                loader.removeAttribute("style");
            }
            else
                loader.removeAttribute("style");
        }, 1000);
    }
}
