var image;
$(document).ready(function() {
    $('#webcam').click(function() {
        useWebcam();
    });
    $('#file').change(function(){
        fileReader();
    });
});
/**
 * Lee el fichero (imagen) seleccionada en el formulario
 * @returns {undefined}
 */
function fileReader() {
    var file = document.querySelector('input[type=file]').files[0];
    var reader = new FileReader();

    reader.addEventListener("load", function() {
        image = reader.result;
        sendFileToServer(image);
    }, false);

    if (file) {
        reader.readAsDataURL(file);
    }
}

/**
 * Habilita el uso de la webcam mediante el navegador utilizado
 * @returns {undefined}
 */
function useWebcam() {
    console.log("loading webcam...");

    // Grab elements, create settings, etc.
    var canvas =
            document.getElementById("canvas"),
            context = canvas.getContext("2d"),
            video = document.getElementById("video"),
            videoObj = {"video": true},
    errBack = function(error) {
        console.log("Video capture error: ", error.code);
    };

    document.getElementById("snap").addEventListener("click", function(evt) {
        evt.preventDefault();
        context.drawImage(video, 0, 0, 220, 160);
        image = canvas.toDataURL();
        sendFileToServer(image);
    });

    // Put video listeners into place
    if (navigator.getUserMedia) { // Standard
        navigator.getUserMedia(videoObj, function(stream) {
            showCameraElements();
            video.src = stream;
            video.play();
        }, errBack);
    } else if (navigator.webkitGetUserMedia) { // WebKit-prefixed
        navigator.webkitGetUserMedia(videoObj, function(stream) {
            showCameraElements();
            video.src = window.webkitURL.createObjectURL(stream);
            video.play();
        }, errBack);
    }
    else if (navigator.mozGetUserMedia) { // Firefox-prefixed
        navigator.mozGetUserMedia(videoObj, function(stream) {
            showCameraElements();
            video.src = window.URL.createObjectURL(stream);
            video.play();
        }, errBack);
    }
}

/**
 * 
 * @param {type} imagen imagen en formato (base64) que sera subida al servidor
 * @returns {undefined}\
 */
function sendFileToServer(imagen) {
    $.post('php/webcam.php', {
        image: imagen
    }, function(dataReceived) {
        dataReceived = JSON.parse(dataReceived);
        var array = $.map(dataReceived, function(array) {
            return array;
        });
        if (dataReceived.hasOwnProperty('error')) {
            showErrors(array, 'error');
        } else {
            showErrors(array, 'ok');
        }
    });
}

/**
 * hara visible los elementos necesarios en caso de que se use la webcam
 * @returns none
 */
function showCameraElements() {
    $("#video").show();
    $("#snap").show();
    $("#canvas").show();
}