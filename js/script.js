// -------------------[Image Cropper]-------------------
// -------------------[Image Cropper]-------------------
// -------------------[Image Cropper]-------------------
document.addEventListener('DOMContentLoaded', function () {
	const inputImage = document.getElementById('imageToUpload');
	const editImage = document.getElementById('editImage');
	const croppedImage = document.getElementById('outputImage');

	const imageCropperModal = document.getElementById('imageCropperModal');
	const modal = new bootstrap.Modal(imageCropperModal);

	const CropButton = document.getElementById('cropBtn');
	const saveButton = document.getElementById('saveBtn');
	let cropper;

	inputImage.addEventListener('change', function () {
		modal.show();
		const files = inputImage.files;
		if (files && files.length > 0) {
			const file = files[0];
			const url = URL.createObjectURL(file);

			editImage.src = url;

			if (cropper) {
				cropper.destroy();
			}
			cropper = new Cropper(editImage, {
				aspectRatio: 1,
				viewMode: 1,
			});
		}
	});

	CropButton.addEventListener('click', function () {
		if (cropper) {
			const croppedArea = cropper.getCroppedCanvas();
			croppedImage.src = croppedArea.toDataURL('image/jpeg');
		} else {
			alert('Cropper Not Works perfectly');
		}
		saveButton.addEventListener('click', function () {
			const croppedArea = cropper.getCroppedCanvas();
			croppedArea.toBlob(function (blob) {
				const imageObj = new File([blob], 'image.jpg');
				const dataTransfer = new DataTransfer();
				dataTransfer.items.add(imageObj);
				inputImage.files = dataTransfer.files;
				modal.hide();
			}, 'image/jpeg');
		});
	});
});

// -------------------[Highlighter]-------------------

function highlightSpecifiedText(elementClass, keyword) {
	var elements = document.getElementsByClassName(elementClass);
	for (var i = 0; i < elements.length; i++) {
		var element = elements[i];
		var innerHTML = element.innerHTML;
		var index = innerHTML.indexOf(keyword);
		if (index >= 0) {
			innerHTML = innerHTML.substring(0, index) + 
				"<span class='highlight'>" + keyword + '</span>' +
				innerHTML.substring(index + keyword.length);
			element.innerHTML = innerHTML;
		}
	}
}
