$(function() {

    $(".container").tooltip({
        selector: "[data-toggle=tooltip]",
        container: "body"
    });

    $(".example-popup").on("click", function(e) {
        var obj = JSON.parse( $(this).parent().children(".example").text() );
        var str = JSON.stringify(obj, undefined, 4);
        bootbox.alert("<pre>"+ syntaxHighlight(str) +"</pre>");
    });

    function syntaxHighlight(json) {
        json = json.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
        return json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, function (match) {
            var cls = 'number';
            if (/^"/.test(match)) {
                if (/:$/.test(match)) {
                    cls = 'key';
                } else {
                    cls = 'string';
                }
            } else if (/true|false/.test(match)) {
                cls = 'boolean';
            } else if (/null/.test(match)) {
                cls = 'null';
            }
            return '<span class="' + cls + '">' + match + '</span>';
        });
    }

});
