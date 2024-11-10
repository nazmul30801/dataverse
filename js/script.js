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
			alert(5);
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
