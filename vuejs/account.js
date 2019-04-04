var imported = document.createElement('script');
imported.src = 'js/functions.js';
document.head.appendChild(imported);

let account = new Vue({
    el: '#infos',
    data: {
        selectedGender: "",
        selectedOrientation: "",
        currGender: "",
        currOrientation: "",
        currBio: "",
        genderOptions: [
            { text: 'Male', value: 'Male' },
            { text: 'Female', value: 'Female' }
            /*{ text: 'Agender', value: 'Agender' },
            { text: 'Androgyne', value: 'Androgyne' },
            { text: 'Androgynous', value: 'Androgynous' },
            { text: 'Bigender', value: 'Bigender'},
            { text: 'Cis', value: 'Cis'},
            { text: 'Cisgender', value: 'Cisgender'}*/
        ],
        orientationOptions: [
            { text: 'Heterosexual', value: 'Heterosexual' },
            { text: 'Homosexual', value: 'Homosexual' },
            { text: 'Bisexual', value: 'Bisexual'}/*,
            { text: 'Lesbian', value: 'Lesbian' },
            { text: 'Pansexual', value: 'Pansexual'},
            { text: 'Bicurious', value: 'Bicurious'}*/
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
    props: {idComponent: Number, dbPath: String, btn: String},
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
       '            <label v-if="!path" v-bind:for="id" class="lab file-lab">{{ btn }}</label>\n' +
       '            <input v-if="!path" type="file" v-bind:name="name" v-bind:id="id" class="inputfile" @change="onFileUpload">\n' +
       '        </div>\n' +
       '<img @click="removePhoto" v-if="path" :src=path style="max-width: 250px; max-height: 250px;" :alt="name"/>\n'+
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

let locat = new Vue({
    el: '#location',
    methods: {
        processLocation: function (){
            let lat = document.getElementById("lat").value,
                lng = document.getElementById("lng").value
            fetch('handlers/update_location.php', {
                method: 'post',
                mode: 'same-origin',
                body: JSON.stringify({
                    lat: lat, lng: lng
                })
            })
                .then((res) => res.text())
                .then((data) => addAlert(data, document.getElementById("header")))
                .catch((error) => console.log(error))
        }
    }
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

let acc = new Vue({
    el: '#account',
    data: {
        firstname: '',
        lastname: '',
        username: '',
        email: '',
        currFirstname: '',
        currLastname: '',
        currUsername: '',
        currEmail: '',
        borderColor: {
            firstname: '',
            lastname: '',
            username: '',
            email: '',
            password: '',
            password2: ''
        },
        errors: {
            firstname: false,
            lastname: false,
            username: false,
            email: false,

        }
    },
    methods: {
        processForm: function () {
            if (this.errors.username === true || this.errors.email === true ||
                this.errors.firstname === true || this.errors.lastname === true) {
                addAlert('<div id="alert" class="alert alert-warning" style="text-align: center;" role="alert"><b>Error:</b> Please fill in the fields properly.\n' +
                    '            <button type="button" class="close" onclick="dismissAlert(this)" data-dismiss="alert" aria-label="Close">\n' +
                    '                <span aria-hidden="true">×</span>\n' +
                    '            </button>\n' +
                    '            </div>', document.getElementById("header"))
            }
            else {
                fetch('handlers/update_account.php', {
                    method: 'post',
                    mode: 'same-origin',
                    headers: {
                        'Content-Type': 'application/json' //sent
                    },
                    body: JSON.stringify({
                        firstname: this.firstname, lastname: this.lastname,
                        username: this.username, email: this.email,
                    })
                })
                    .then((res) => res.text())
                    .then((data) => addAlert(data, document.getElementById("header")))
                    .catch((error) => console.log(error))
            }
        },
        validateFirstname: function () {
            const isValid = isValidLength(this.firstname, 2, 16);
            if (isValid)
                this.borderColor.firstname = "#56c93f";
            else
                this.borderColor.firstname = "#FF0000";

            this.errors.firstname = !isValid;
        },
        validateLastname: function () {
            const isValid = isValidLength(this.lastname, 2, 16);
            if (isValid)
                this.borderColor.lastname = "#56c93f";
            else
                this.borderColor.lastname = "#FF0000";

            this.errors.lastname = !isValid;
        },
        validateUsername: function () {
            const isValid = isValidLength(this.username, 4, 30);
            if (isValid)
                this.borderColor.username = "#56c93f";
            else
                this.borderColor.username = "#FF0000";

            this.errors.username = !isValid;
        },
        validateEmail: function () {
            const isValid = isValidEmail(this.email);
            if (isValid)
                this.borderColor.email = "#56c93f";
            else
                this.borderColor.email = "#FF0000";
            this.errors.email = !isValid;
        },
        assignFirstname: function (firstname) {
            this.currFirstname = firstname;
        },
        assignLastname: function (lastname) {
            this.currLastname = lastname;
        },
        assignUsername: function (username) {
            this.currUsername = username;
        },
        assignEmail: function (email) {
            this.currEmail = email;
        }
    },
    mounted(){
    this.firstname = this.currFirstname;
    this.lastname = this.currLastname;
    this.username = this.currUsername;
    this.email = this.currEmail;
}
});

let register = new Vue({
    el: '#security',
    data: {
        password: '',
        password2: '',
        currpw: '',
        borderColor: {
            password: '',
            password2: ''
        },
        errors: {
            password: false,
            password2: false
        }
    },
    methods: {
        processForm: function () {
            if (this.errors.password === true || this.errors.password2 === true) {
                addAlert('<div id="alert" class="alert alert-warning" style="text-align: center;" role="alert"><b>Error:</b> Please fill in the fields properly.\n' +
                    '            <button type="button" class="close" onclick="dismissAlert(this)" data-dismiss="alert" aria-label="Close">\n' +
                    '                <span aria-hidden="true">×</span>\n' +
                    '            </button>\n' +
                    '            </div>', document.getElementById("header"))
            }
            else {
                fetch('handlers/update_password.php', {
                    method: 'post',
                    mode: 'same-origin',
                    headers: {
                        'Content-Type': 'application/json' //sent
                    },
                    body: JSON.stringify({
                        currpw: this.currpw, password: this.password, password2: this.password2
                    })
                })
                    .then((res) => res.text())
                    .then((data) => addAlert(data, document.getElementById("header")))
                    .catch((error) => console.log(error))
            }
        },
        validatePassword: function () {
            const isValid = isValidPassword(this.password);
            if (isValid)
                this.borderColor.password = "#56c93f";
            else
                this.borderColor.password = "#FF0000";
            this.errors.password = !isValid;
        },
        validatePassword2: function () {
            if (this.password2 !== this.password) {
                this.errors.password2 = true;
                this.borderColor.password2 = "#FF0000";
            }
            else {
                this.errors.password2 = false;
                this.borderColor.password2 = "#56c93f";
            }
        }
    }
});