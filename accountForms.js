new Vue({
    el: '#gender',
    data: {
        selectedGender: "",
        selectedOrientation: "",
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
        }
    }
});