var imported = document.createElement('script');
imported.src = 'js/functions.js';
document.head.appendChild(imported);

let account = new Vue({
    el: '#sort',
    data: {
        byStart: '',
        byEnd: '',
        pStart: '',
        pEnd: '',
        location: '',
        selectedSort: 'Location',
        selectedGender: 'ALL',
        selectedOrientation: 'ALL',
        sortOptions: [
            { text: 'Age', value: 'Age' },
            { text: 'Location', value: 'Location' },
            { text: 'Popularity', value: 'Popularity' },
            { text: 'Tags', value: 'Tags' }
        ],
        genderOptions: [
            { text: 'ALL', value: 'ALL' },
            { text: 'Male', value: 'Male' },
            { text: 'Female', value: 'Female' }
        ],
        orientationOptions: [
            { text: 'ALL', value: 'ALL' },
            { text: 'Heterosexual', value: 'Heterosexual' },
            { text: 'Homosexual', value: 'Homosexual' },
            { text: 'Bisexual', value: 'Bisexual' }
        ],
        selectedOrder: 'asc',
        orderOptions : [
            { text: 'DES', value: 'des'},
            { text: 'ASC', value: 'asc'}
        ],
        borderColor: {
            byStart: '',
            byEnd: '',
            pStart: '',
            pEnd: '',
            location: ''
        },
        errors: {
            byStart: false,
            byEnd: false,
            pStart: false,
            pEnd: false,
            location: false
        }
    },
    methods: {
        processSort: function () {
            if ((this.selectedGender !== "Male" && this.selectedGender !== "Female" && this.selectedGender !== "ALL") ||
                (this.selectedOrientation !== "Heterosexual" && this.selectedOrientation !== "Homosexual" && this.selectedOrientation !== "Bisexual" && this.selectedOrientation !== "ALL")){
                addAlert('<div id="alert" class="alert alert-warning" style="text-align: center;" role="alert"><b>Error:</b> Please fill in the fields properly.\n' +
                    '            <button type="button" class="close" onclick="dismissAlert(this)" data-dismiss="alert" aria-label="Close">\n' +
                    '                <span aria-hidden="true">×</span>\n' +
                    '            </button>\n' +
                    '            </div>', document.getElementById("header"));
            }
            else {
                let tagInput = document.getElementsByClassName("label-info"),
                    tags = [];
                for (i = 0; i < tagInput.length; i++)
                    tags.push(tagInput[i].textContent);
                if (this.errors.byStart === true || this.errors.byEnd === true ||
                    this.errors.pStart === true || this.errors.pEnd === true ||
                    this.errors.location === true) {
                    addAlert('<div id="alert" class="alert alert-warning" style="text-align: center;" role="alert"><b>Error:</b> Please fill in the fields properly.\n' +
                        '            <button type="button" class="close" onclick="dismissAlert(this)" data-dismiss="alert" aria-label="Close">\n' +
                        '                <span aria-hidden="true">×</span>\n' +
                        '            </button>\n' +
                        '            </div>', document.getElementById("header"))
                }
                else {
                    fetch('handlers/search_user.php', {
                        method: 'post',
                        mode: 'same-origin',
                        headers: {'Content-Type': 'application/json'}, //sent
                        body: JSON.stringify({
                            sort: this.selectedSort, order: this.selectedOrder,
                            gender: this.selectedGender, orientation: this.selectedOrientation,
                            bystart: this.byStart, byend: this.byEnd,
                            pstart: this.pStart, pend: this.pEnd,
                            tags: tags, location: this.location
                        })
                    })
                        .then((res) => res.text())
                        .then(function (data) {
                            document.getElementById('gen-sugg').remove();
                            let div = document.createElement('div'),
                                parent = document.getElementById("suggestion");
                            div.setAttribute('id', 'gen-sugg');
                            parent.appendChild(div);
                            div.innerHTML += data;
                        })
                        .catch((error) => console.log(error))
                }
            }
        },
        validateByStart: function () {
            if (this.byStart.localeCompare('') !== 0) {
                if (this.byStart >= 1940 && this.byStart <= 2001)
                    this.borderColor.byStart = "#56c93f";
                else
                    this.borderColor.byStart = "#FF0000";
                if (this.byStart < 1940 || this.byStart > 2001)
                    this.errors.byStart = true;
                else
                    this.errors.byStart = false;
            }
            else {
                this.borderColor.byStart = '';
                this.errors.byStart = false;
            }
        },
        validateByEnd: function () {
            if (this.byEnd.localeCompare('') !== 0) {
                if (this.byEnd >= 1940 && this.byEnd <= 2001)
                    this.borderColor.byEnd = "#56c93f";
                else
                    this.borderColor.byEnd = "#FF0000";
                if (this.byEnd < 1940 || this.byEnd > 2001)
                    this.errors.byEnd = true;
                else
                    this.errors.byEnd = false;
            }
            else {
                this.borderColor.byEnd = '';
                this.errors.byEnd = false;
            }
        },
        validatepStart: function () {
            if (this.pStart.localeCompare('') !== 0) {
                if (this.pStart >= -100000 && this.pStart <= 100000)
                    this.borderColor.pStart = "#56c93f";
                else
                    this.borderColor.pStart = "#FF0000";
                if (this.pStart < -100000 || this.pStart > 100000)
                    this.errors.pStart = true;
                else
                    this.errors.pStart = false;
            }
            else {
                this.borderColor.pStart = '';
                this.errors.pStart = false;
            }

        },
        validatepEnd: function () {
            if (this.pEnd.localeCompare('') !== 0) {
                if (this.pEnd >= -100000 && this.pEnd <= 100000)
                    this.borderColor.pEnd = "#56c93f";
                else
                    this.borderColor.pEnd = "#FF0000";
                if (this.pEnd < -100000 || this.pEnd > 100000)
                    this.errors.pEnd = true;
                else
                    this.errors.pEnd = false;
            }
            else {
                this.borderColor.pEnd = '';
                this.errors.pEnd = false;
            }
        },
        validateLocation: function () {
            if (this.location.localeCompare('') !== 0) {
                if (this.location >= 1 && this.location <= 2000)
                    this.borderColor.location = "#56c93f";
                else
                    this.borderColor.location = "#FF0000";
                if (this.location < 1 || this.location > 2000)
                    this.errors.location = true;
                else
                    this.errors.location = false;
            }
            else {
                this.borderColor.location = '';
                this.errors.location = false;
            }
        }
    }
});
