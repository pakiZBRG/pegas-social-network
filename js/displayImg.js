var loadFile = function(event) {
	var image = document.getElementById('showImg');
	image.src = URL.createObjectURL(event.target.files[0]);
	$('.home-card-img').css({'height': '27rem'})
    $('#showImg').css({'width': '100%', 'height': '100%', 'margin': '0.5rem 0', 'object-fit': "contain"})
};