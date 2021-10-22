function openModal() {
    var menu = $(".hamburger");
    var navigation = $('#mobileNav');

    menu.animate({right: '-10rem'}, 400)
    navigation.animate({bottom: '0'}, 600)
}

function closeModal() {
    var menu = $(".hamburger");
    var navigation = $('#mobileNav');

    navigation.animate({bottom: '-20rem'}, 600)
    menu.animate({right: '-4rem'}, 400)
}