var loadFile = function(event) {
	var image = document.getElementById('showImg');
	image.src = URL.createObjectURL(event.target.files[0]);
    $('#showImg').css({'width': '100%', 'height': '18rem', 'margin': '0.5rem 0', 'object-fit': "contain"})
};