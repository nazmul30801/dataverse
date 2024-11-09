// Open Cropper

const inputImage = document.getElementById('inputImage');
document.getElementById('fileToUpload').addEventListener('change', function (event) {
	$('#imageCropperModal').modal('toggle');
	var file = event.target.files[0];
	if (file) { 
        const reader = new FileReader(); 
        reader.onload = function(e) { 
            inputImage.src = e.target.result; 
        }
        const cropper = new Cropper(inputImage, {
            aspectRatio: 1 / 1,
            viewMode: 0,
        });
        reader.readAsDataURL(file); }
});




document.getElementById("cropBtn").addEventListener("click",
    function () {
        var croppedImage = cropper.getCroppedCanvas().toDataURL("image/png");
        document.getElementById("output").src = croppedImage;
});

document.getElementById("output").src = cropper.getCroppedCanvas.toDataURL("image/png");

function cropView() {}

setInterval(function () {
	document.getElementById('output').src = cropper
		.getCroppedCanvas()
		.toDataURL('image/png');
}, 50);
