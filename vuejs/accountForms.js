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
            fetch('handlers/update_info.php', {
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
    props: {idComponent: Number, dbPath: String},
    data: function(){
        return {
            name: "component_photo_name_" + this.idComponent,
            id: "component_photo_id_" + this.idComponent,
            submit: "submit_photo_id_" + this.idComponent,
            selectedFile: "",
            path: this.dbPath
        }
    },
   template: '<form @submit.prevent="processForm" name="upload" action="" method="post" enctype="multipart/form-data" class="text-center">\n' +
       '        <div class="form-group">\n' +
       '            <label v-if="!path" v-bind:for="id" class="lab file-lab">Photo {{ idComponent }}</label>\n' +
       '            <input v-if="!path" type="file" v-bind:name="name" v-bind:id="id" class="inputfile" @change="onFileUpload">\n' +
       '        </div>\n' +
       '<img @click="removePhoto" v-if="path" :src=path style="max-width: 250px; max-height: 250px;"/>\n'+
       '<a v-if="dbPath" @click.prevent="deletePhoto" href=""><i class="fas fa-trash rmv-img"></i></a>\n'+
       '        <div v-if="selectedFile" class="form-group">\n' +
       '            <button type="submit" name="submit" id="submit" class="btn btn-outline-warning btn-sign-in">Upload</button>\n' +
       '        </div>\n' +
       '      </form>',
    methods: {
        processForm: function (){
            console.log(this.selectedFile);
            console.log(JSON.stringify(this.selectedFile));
            let formdata = new FormData();
            formdata.append('picture', this.selectedFile);
            formdata.append('picture-id', this.idComponent);
            fetch('handlers/upload_photo.php', {
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
            console.log(this.idComponent);
        },
        removePhoto: function (){
            this.path = "";
            this.selectedFile = "";
        },
        deletePhoto: function (){
            fetch('handlers/delete_photo.php', {
                method: 'post',
                mode: 'same-origin',
                headers: {'Content-Type': 'application/json'}, //sent
                body: JSON.stringify({
                    photoid: this.idComponent
                })
            })
                .then((res) => res.text())
                .then((data) => addAlert(data, document.getElementById("header")))
                .catch((error) => console.log(error))
        }
    }
});

let photo = new Vue({
    el: '#photos'
});

let tags = new Vue({
    el: '#tags',
    data: {
      selectedTags: ""
    },
    methods: {
        processForm: function () {
            let tagInput = document.getElementsByClassName("label-info"),
                tags = [];
            console.log(tagInput);
            for (i = 0; i < tagInput.length; i++)
                tags.push(tagInput[i].textContent);
            console.log(tags);
            fetch('handlers/update_tags.php', {
                method: 'post',
                mode: 'same-origin',
                headers: {'Content-Type': 'application/json'}, //sent
                body: JSON.stringify({
                    tags: tags
                })
            })
                .then((res) => res.text())
                .then((data) => addAlert(data, document.getElementById("header")))
                .catch((error) => console.log(error))
        }
    }
});