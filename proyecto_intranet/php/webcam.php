<?php

session_start();

$base64Image = ($_POST['image']);
$target_dir = "../fotos/";
$temp_target_dir = "../temp/";
$imageFileType = strtolower(explode('/', getimagesize($base64Image)['mime'])[1]);
$target_file = $target_dir . basename(getDni($_SESSION['userId'])) . "." . $imageFileType;
$temp_target_file = $temp_target_dir . basename(getDni($_SESSION['userId'])) . "." . $imageFileType;

$uploadOk = 1;

// Check if image file is a actual image or fake image
if (isset($_POST["image"])) {
    $check = getimagesize($base64Image);

    if ($check !== false) {
        //es una imagen
        $uploadOk = 1;
    } else {
        //no lo es
        SendJSON('error','El archivo seleccionado no es una imagen');
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    //si existe habra que sobrescribirlo, hay que tener en cuenta los permisos
    $uploadOk = 1;
}

//la guardamos en una carpeta temporal para recoger informacion sobre la foto (tamanyo en bytes)
$base64ImageTemporal = explode(',', $base64Image);
$base64ImageTemporal = str_replace(' ', '+', $base64ImageTemporal[1]);
$decodedImage = base64_decode($base64ImageTemporal);
file_put_contents($temp_target_file, $decodedImage);
$imageSize = filesize($temp_target_file);
if ($imageSize > 250000) {//2MB
    SendJSON ("error","La foto es demasiado grande");
    $uploadOk = 0;
}

//supere el tamanyo o no, borramos la foto de la carpeta temporal
unlink($temp_target_file);

// Allow certain file formats
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    
} else {
    //limpiamos la string para poder generar los bytes de la imagen
    $base64Image = explode(',', $base64Image);
    $base64Image = str_replace(' ', '+', $base64Image[1]);
    $decodedImage = base64_decode($base64Image);

    if (file_put_contents($target_file, $decodedImage)) {
         SendJSON('ok','La foto ha subida al servidor');
         savePhoto($_SESSION['userId'],basename(getDni($_SESSION['userId'])) . "." . $imageFileType);
    } else {
        SendJSON('error','La foto no ha podido ser subida al servidor');
    }
}

function savePhoto($id, $foto){
    include 'config.php';
    require_once "Classes/Class_DB.php";
    $db = new DB($ip, $user, $pass, $db);
    $db->Connect();
    $conn = $db->GetConn();
    $conn->set_charset('utf8');

    if($_SESSION['userType']=="alumno"){
        $query = "UPDATE `alumnos` SET foto='$foto' WHERE id=$id";
    }else{
        $query = "UPDATE `profesores` SET foto='$foto' WHERE codigo=$id";
    }
    $result = $conn->query($query);

}

function getDni($id){
    include 'config.php';
    require_once "Classes/Class_DB.php";
    $db = new DB($ip, $user, $pass, $db);
    $db->Connect();
    $conn = $db->GetConn();
    $conn->set_charset('utf8');
    if($_SESSION['userType']=="alumno"){
        $query = "SELECT dni FROM `alumnos` WHERE id=$id";
    }else{
        $query = "SELECT dni FROM `profesores` WHERE codigo=$id";
    }
    $result = $conn->query($query);
    while($row = $result->fetch_assoc()) {
        return $row['dni'];
    }
    
}

function SendJSON($key, $value) {
    $arr = array($key => $value);
    echo json_encode($arr);
}
