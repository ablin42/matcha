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
        selectedSort: 'Standard',
        sortOptions: [
            { text: 'Standard', value: 'Standard' },
            { text: 'Age', value: 'Age' },
            { text: 'Location', value: 'Location' },
            { text: 'Popularity', value: 'Popularity' },
            { text: 'Tags', value: 'Tags' }
        ],
        selectedOrder: 'des',
        orderOptions : [
            { text: 'DES', value: 'des'},
            { text: 'ASC', value: 'asc'}
        ],
        borderColor: {
            byStart: '',
            byEnd: '',
            pStart: '',
            pEnd: '',
        },
        errors: {
            byStart: false,
            byEnd: false,
            pStart: false,
            pEnd: false,
        }
    },
    methods: {
        processSort: function () {
            let tagInput = document.getElementsByClassName("label-info"),
                tags = [];
            for (i = 0; i < tagInput.length; i++)
                tags.push(tagInput[i].textContent);
            fetch('handlers/filter_suggestion.php', {
                method: 'post',
                mode: 'same-origin',
                headers: {'Content-Type': 'application/json'}, //sent
                body: JSON.stringify({
                    sort: this.selectedSort, order: this.selectedOrder,
                    bystart: this.byStart, byend: this.byEnd,
                    pstart: this.pStart, pend: this.pEnd,
                    tags: tags//localisation
                })
            })
                .then((res) => res.text())
                .then(function(data){
                    console.log(data);
                    document.getElementById('gen-sugg').remove();
                    let div = document.createElement('div'),
                        parent = document.getElementById("suggestion");
                    div.setAttribute('id', 'gen-sugg');
                    parent.appendChild(div);
                    div.innerHTML += data;
                })
                .catch((error) => console.log(error))
        },
        validateByStart: function () {
            if (this.byStart >= 1940 && this.byStart <= 2001)
                this.borderColor.byStart = "#56c93f";
            else
                this.borderColor.byStart = "#FF0000";
            if (this.byStart < 1940 || this.byStart > 2001)
                this.errors.byStart = true;
            else
                this.errors.byStart = false;
        },
        validateByEnd: function () {
            if (this.byEnd >= 1940 && this.byEnd <= 2001)
                this.borderColor.byEnd = "#56c93f";
            else
                this.borderColor.byEnd = "#FF0000";
            if (this.byEnd < 1940 || this.byEnd > 2001)
                this.errors.byEnd = true;
            else
                this.errors.byEnd = false;
        },
        validatepStart: function () {
            if (this.pStart >= -100000 && this.pStart <= 100000)
                this.borderColor.pStart = "#56c93f";
            else
                this.borderColor.pStart = "#FF0000";
            if (this.pStart < -100000 || this.pStart > 100000)
                this.errors.pStart = true;
            else
                this.errors.pStart = false;
        },
        validatepEnd: function () {
            if (this.pEnd >= -100000 && this.pEnd <= 100000)
                this.borderColor.pEnd = "#56c93f";
            else
                this.borderColor.pEnd = "#FF0000";
            if (this.pEnd < -100000 || this.pEnd > 100000)
                this.errors.pEnd = true;
            else
                this.errors.pEnd = false;
        },
    }
});
