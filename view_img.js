const modal = document.getElementById("myModal");
const span = document.getElementsByClassName("close")[0];
const img = document.getElementById("myImg");
const imgModal = document.getElementById("imgModal");

img.onclick = function(){
    modal.style.display = 'block';
    imgModal.src = this.src;
}

span.onclick = function(){
    modal.style.display = 'none';
}