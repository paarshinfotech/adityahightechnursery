/*-------------------------------{ Image Upload Preview CSS start }-------------------------------*/
const uploadContainer = document.querySelector('.upload-container');
function generateImg(src, name, col_class='col-6') {
	let col = document.createElement('div');
	col.className = col_class;
	let imgContainer = document.createElement('div');
	imgContainer.className = 'image-container';
	let span = document.createElement('span');
	span.className = 'action';
	span.setAttribute('onclick', `removePhoto(this.parentElement)`);
	span.innerHTML = '<i class="bx bx-trash"></i>';
	let img = document.createElement('img');
	img.className = 'img-preview';
	img.src = src;
	img.setAttribute('data-name', name);
	imgContainer.appendChild(span);
	imgContainer.appendChild(img);
	col.appendChild(imgContainer);
	uploadContainer.before(col);
	updateContainerClass();
}
let pro_photo = document.querySelector('input[name="pro_photo[]"]');
if (pro_photo) {
	pro_photo.addEventListener('change', function(){
		let eximgContainer = document.querySelectorAll('.image-container')
		let filesList = this.files;
		for (var i = 0; i < eximgContainer.length; i++) {
			eximgContainer[i].parentElement.remove();
		}
		for (let i=0; i<filesList.length; i++){
			src = URL.createObjectURL(filesList[i]);
			if (i==0) {
				generateImg(src, filesList[i].name, 'col-12');
			}else{
				generateImg(src, filesList[i].name);
			}
		}
	});
}
function removePhoto(el){
	el.parentElement.remove();
	if (document.querySelectorAll('.image-container').length == 0) {
		pro_photo.value = '';
	}
	updateContainerClass();
}
function updateContainerClass() {
	let uploadPrev = document.querySelector('.upload-preview').children;
	for (var i = 0; i < uploadPrev.length; i++) {
		if (i==0) {
			uploadPrev[i].classList.replace('col-6', 'col-12');
		}else{
			uploadPrev[i].classList.replace('col-12', 'col-6');
		}
	}
}
/*-------------------------------{ Image Upload Preview CSS ends }-------------------------------*/