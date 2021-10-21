function textLimit(content, limit, button) {
    var text = $(content);
    $("#length").html(`${text.val().length}/${limit}`);

    text.on('keyup', function() {
        if(text.val().length <= limit) {
            $("#length").html(`${text.val().length}/${limit}`)
            text.css({"border-color": 'transparent', 'border-bottom-color': "#adadad"});
            $(button).prop("disabled", false);
        } else {
            $("#length").html(`<p style="color: crimson">Limit has been exceeded by ${text.val().length - limit}.</p>`)
            text.css({"border-color": 'crimson'});
            $(button).prop("disabled", true);
        }
    })
}