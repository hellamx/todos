const path = window.location.protocol + '//' + window.location.hostname;
const todo_id = $('#todo_id').val();

var items = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.whitespace,
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    remote: {
        wildcard: "%QUERY",
        url: path + "/item/search?todo_id=" + todo_id + "&s=%QUERY"
    }
});

items.initialize();

$("#typeahead").typeahead({
    highlight: true
}, {
    name: "items",
    display: "title",
    limit: 20,
    source: items
});

$("#typeahead").bind("typeahead:select", function(ev, suggestion) {
    window.location = path + "/item/search?todo_id=" + todo_id + "&s=" + encodeURIComponent(suggestion.title);
});