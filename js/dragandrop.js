var CURR_FILTER;
var FILTERS_INFO = [];
function getCursorPosition(e)
{
    let preview = document.getElementById('preview');
    let previewPos = preview.getBoundingClientRect();
    let left = e.clientX - previewPos.left;
    let top = e.clientY - previewPos.top;
    let width = preview.clientWidth;
    let height = preview.clientHeight;
    return [left, top, width, height];
}

function allowDrop(ev) {
    ev.preventDefault();
}

function drag(ev, item) {
    CURR_FILTER = item;
    ev.dataTransfer.setData("text", ev.target.id);
}

function drop(ev) {
    let filter = document.getElementById(CURR_FILTER);
    if (filter === null)
        return ;
    let filterSize = filter.getBoundingClientRect(),
        halfFilterWidth = filterSize.width / 2,
        halfFilterHeight = filterSize.height / 2;

   ;
    if (CURR_FILTER === undefined)
        return;
    ev.preventDefault();
    let pos = getCursorPosition(ev);
    let left = pos[0];
    let top = pos[1];
    if (left < 0)
        left = 0;
    else if (left > pos[2])
        left = left - halfFilterWidth;
    if (top < 0)
        top = 0;
    else if (top > pos[3])
        top = top - halfFilterHeight;

    left = left - halfFilterWidth;
    top = top - halfFilterHeight;
    document.getElementById(CURR_FILTER).setAttribute("style", `left: ${left}px; top: ${top}px;`);
}