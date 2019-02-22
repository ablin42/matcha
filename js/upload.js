function upload_webcam()
{
    var xhttp = new XMLHttpRequest();
    var imgURL = document.getElementById("photo").src;
    var title = document.getElementById("img_name_cam").value;
    var idUser = document.getElementById("id_user").value;

   // console.log(title);
   // console.log(idUser);
  //  //console.log(imgURL);

    xhttp.open("POST", "utils/upload_webcam.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(`img_url=${imgURL}&id_user=${idUser}&title=${title}`);
}