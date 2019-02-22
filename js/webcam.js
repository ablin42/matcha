function getActiveFilter()
{
    FILTERS_INFO = [];
    var domFilter = document.getElementsByClassName("applied-filter");
    var nbFilter = document.getElementsByClassName("applied-filter").length;
    var filter = [];
    for (i = 0; i < nbFilter; i++)
    {
        let filterId = domFilter[i].getAttribute("id").substr(7),
            elem = document.getElementById(`filter_${filterId}`),
            left = elem.style.left,
            top = elem.style.top,
            elemInfo = elem.getBoundingClientRect(),
            width = elemInfo.width,
            height = elemInfo.height;
        if (left === "")
            left = 0;
        if (top === "")
            top = 0;
        let filterInfo = {
            "id" : i,
            "left" : left,
            "top" : top,
            "width" : width,
            "height" : height
        };
        FILTERS_INFO.push(filterInfo);
        filter.push(elem.getAttribute('alt'));
    }
    return (filter);
}

(function() {

    var streaming = false,
        video        = document.querySelector('#video'),
        canvas       = document.querySelector('#canvas'),
        startbutton  = document.querySelector('#startbutton'),
        xhttp = new XMLHttpRequest(),
        width = 600,
        height = 0,
        vidInfo =  video.getBoundingClientRect();

        if (video.getAttribute('src') === null)
        {
            width = vidInfo.width;

            navigator.getMedia = (navigator.getUserMedia ||
                                navigator.webkitGetUserMedia ||
                                navigator.mediaDevices.getUserMedia||
                                navigator.msGetUserMedia);

                if (navigator.mediaDevices.getUserMedia)
                {
                    navigator.mediaDevices.getUserMedia(
                        {
                            video: true,
                            audio: false
                        }).then(function(mediaStream) {
                        var video = document.querySelector('video');
                        video.srcObject = mediaStream;
                        video.onloadedmetadata = function(e) {
                            video.play();
                        };
                    })
                        .catch(function(err) { console.log(err.name + ": " + err.message); });

                }
                else
                {
                    navigator.getMedia(
                    {
                        video: true,
                        audio: false
                    },
                        function(stream) {
                            if (navigator.mozGetUserMedia) {
                                video.mozSrcObject = stream;
                            } else {
                                video.srcObject = stream;
                            }
                            video.play();
                        },
                    function(err) {
                        console.log("An error occured! " + err);
                    })}
        };

    video.addEventListener('canplay', function(ev){
        if (!streaming) {
            height = video.videoHeight / (video.videoWidth/width);
            canvas.setAttribute('width', width);
            canvas.setAttribute('height', height);
            streaming = true;
        }
    }, false);

    function takepicture() {
        var filter = getActiveFilter();
        var data;
        canvas.width = width;
        canvas.height = height;
        if (video.getAttribute('src') === null) {
            canvas.getContext('2d').drawImage(video, 0, 0, width, height);
            data = encodeURIComponent(canvas.toDataURL('image/png'));
        }
        else
            data = video.getAttribute('src');

        var vidSize = video.getBoundingClientRect();
        var vidWidth = Math.round(vidSize.width);
        var vidHeight = Math.round(vidSize.height);
        var infos = JSON.stringify(FILTERS_INFO);

        xhttp.open("POST", "utils/merge_img.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(`img_url=${data}&filter=${filter}&infos=${infos}&width=${vidWidth}&height=${vidHeight}`);
        setTimeout(function (){
            if (document.getElementById('photo'))
                document.getElementById('photo').remove();
            var img = document.createElement("img");
            img.setAttribute('src', xhttp.responseText);
            img.setAttribute('id', 'photo');
            img.setAttribute('alt', 'your picture');
            img.setAttribute('style', "width:100%;");
            var where = document.getElementById("img_url").parentElement;
            where.appendChild(img);
            document.getElementById('img_url').value = xhttp.responseText;//data;
        }, 2000);//500 seems to be a good fit < 600px width, 1350 is for fullscreen
    }

    startbutton.addEventListener('click', function(ev){
        takepicture();
        ev.preventDefault();
    }, false);
})();
