$(document).ready(function() {
    $("#myImg").on('click', function() {
        $("#myModal").css({'display': "block"});
        $('body').css({'overflow': "hidden"});
        $("#imgModal").attr('src', this.src);
        $("#imgModal").css({"width": "auto", "max-height": "95%", "object-fit": "100%"});
    })
})

$(document).click(function(e) {
    if(e.target.className == 'modal') {          
        $("#myModal").css({'display': "none"});
        $('body').css({'overflow-y': "auto"});
    }

    if(e.target.className == 'deleteUser' || e.target.className == 'cancel') {
        $(".deleteUser").css({'display': "none"});
    }
})


function modal() {
    $(".deleteUser").css({'display': "block"});
}