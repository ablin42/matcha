let account = new Vue({
    el: '#infos',
    data: {
        selectedGender: "",
        selectedOrientation: "",
        currGender: "",
        currOrientation: "",
        currBio: "",
        genderOptions: [
            { text: 'Agender', value: 'Agender' },
            { text: 'Androgyne', value: 'Androgyne' },
            { text: 'Androgynous', value: 'Androgynous' },
            { text: 'Bigender', value: 'Bigender'},
            { text: 'Cis', value: 'Cis'},
            { text: 'Cisgender', value: 'Cisgender'}
        ],
        orientationOptions: [
            { text: 'Heterosexual', value: 'Heterosexual' },
            { text: 'Homosexual', value: 'Homosexual' },
            { text: 'Lesbian', value: 'Lesbian' },
            { text: 'Bisexual', value: 'Bisexual'},
            { text: 'Pansexual', value: 'Pansexual'},
            { text: 'Bicurious', value: 'Bicurious'}
        ],
        bio: ""
    },
    methods: {
        processForm: function () {
            fetch('modify_info.php', {
                method: 'post',
                mode: 'same-origin',
                headers: {'Content-Type': 'application/json'}, //sent
                body: JSON.stringify({
                    gender: this.selectedGender, orientation: this.selectedOrientation, bio: this.bio
                })
            })
                .then((res) => res.text())
                .then((data) => addAlert(data, document.getElementById("header")))
                .catch((error) => console.log(error))
        },
        assignGender: function (gender) {
            this.currGender = gender;
        },
        assignOrientation: function (orientation) {
            this.currOrientation = orientation;
        },
        assignBio: function (bio) {
            this.currBio = bio;
        }
    },
    mounted(){
        this.selectedGender = this.currGender;
        this.selectedOrientation = this.currOrientation;
        this.bio = this.currBio;
    }
});

Vue.component("photo-upload",{
    data: function(){
        return {
            selectedFile: "",
            path: ""
        }
    },
   template: '<form @submit.prevent="processForm" name="upload" action="" method="post" enctype="multipart/form-data" class="text-center">\n' +
       '        <div class="form-group">\n' +
       '            <label for="picture" class="lab file-lab">Pick a file</label>\n' +
       '            <input type="file" name="picture" id="picture" class="inputfile" @change="onFileUpload">\n' +
       '        </div>\n' +
       '<img v-if="path" :src=path style="max-width: 250px; max-height: 250px;"/>\n'+
       '        <div v-if="selectedFile" class="form-group">\n' +
       '            <button type="submit" name="submit_photo" id="submit_photo" class="btn btn-outline-warning btn-sign-in">Upload</button>\n' +
       '        </div>\n' +
       '      </form>',
    methods: {
        processForm: function (){
            console.log(this.selectedFile);
            console.log(JSON.stringify(this.selectedFile));
            let formdata = new FormData();
            formdata.append('picture', this.selectedFile);
            fetch('upload_photo.php', {
                method: 'post',
                mode: 'same-origin',
                body: formdata
                })
                .then((res) => res.text())
                .then((data) => addAlert(data, document.getElementById("header")))
                .catch((error) => console.log(error))
        },
        onFileUpload: function (event){
            this.selectedFile = event.target.files[0];
            this.path = URL.createObjectURL(this.selectedFile);
            console.log(this.selectedFile, this.path);
        }
    }
});

let photo = new Vue({
    el: '#photos'
});