var imported = document.createElement('script');
imported.src = 'js/functions.js';
document.head.appendChild(imported);

let account = new Vue({
    el: '#sort',
    data: {
        selectedSort: "",
        sortOptions: [
            { text: 'Standard', value: 'Standard' },
            { text: 'Age', value: 'Age' },
            { text: 'Location', value: 'Location' },
            { text: 'Popularity', value: 'Popularity' },
            { text: 'Tags', value: 'Tags' }
        ]
    },
    methods: {
        processSort: function () {
            console.log(this.selectedSort);
            /*fetch('handlers/sort_suggestion.php', {
                method: 'post',
                mode: 'same-origin',
                headers: {'Content-Type': 'application/json'}, //sent
                body: JSON.stringify({
                    sort: this.selectedSort
                })
            })
                .then((res) => res.text())
                .then((data) => addAlert(data, document.getElementById("header")))
                .catch((error) => console.log(error))*/
        }
    }
});
