function applyPreview(filter, id_nb)
{
    var path = `filters/${filter}`;
    var id = `filter_${id_nb}`;
    var img = document.createElement("img");
    img.setAttribute('src', path);
    img.setAttribute('class', "applied-filter");
    img.setAttribute('id', id);
    img.setAttribute('alt', filter);
    img.setAttribute('draggable', 'true');
    img.setAttribute('ondragstart', `drag(event, "${id}")`);
    img.setAttribute('ondblclick', "removeFilter(this)");

    var where = document.getElementById("preview");
    where.appendChild(img);
}

function countFilters(amount)
{
    let arr = [];
    if (typeof countFilters.nbCall === 'undefined' ) {
        countFilters.nbCall = 0;}
    if (typeof countFilters.nbFilter === 'undefined' ) {
        countFilters.nbFilter = 0;}
    countFilters.nbFilter += amount;
    countFilters.nbCall++;
    arr.push(countFilters.nbCall);
    arr.push(countFilters.nbFilter);
    return (arr);
}

function applyFilter(filter)
{
    var count = countFilters(1);
    if (count[1] > 0)
        document.getElementById('startbutton').removeAttribute('disabled');
    else
        document.getElementById('startbutton').setAttribute('disabled', '');

    applyPreview(filter, count[0]);
}

function removeFilter(filter)
{
    let count = countFilters(-1);
    if (count[1] > 0)
        document.getElementById('startbutton').removeAttribute('disabled');
    else
        document.getElementById('startbutton').setAttribute('disabled', '');

    filter.remove();
}

function resizePreview()
{
    var video = document.getElementById("video");
    var preview = document.getElementById("preview");
    var vidInfo = video.getBoundingClientRect();
    var height = vidInfo.height;
    var width = vidInfo.width;
    var halfWidth = width / 2;

    preview.setAttribute("style", `min-width: ${width}px; min-height: ${height}px; max-width: ${width}px; max-height: ${height}px; margin-left: -${halfWidth}px`);
    preview.setAttribute("height", height);
}

function hoverFilter(filter, state)
{
    let sizing = 10;
    if (state === "out")
        sizing = -10;
    let width = filter.width + sizing,
        height = filter.height + sizing;

    filter.setAttribute("style", `width: ${width}px; height: ${height}px;`);
}