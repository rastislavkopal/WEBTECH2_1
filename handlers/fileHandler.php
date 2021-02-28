<?php
function generateRandomString($length = 10) {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}

$target_dir = "../files/";

if (isset($_POST['uploadedFilePath']) && $_POST['uploadedFilePath'] != '.'){
    $target_dir .= $_POST['uploadedFilePath'] . '/';
}

if (isset($_POST['uploadedFileName']))
    $target_file = $target_dir . $_POST['uploadedFileName'];


$fileType = strtolower(pathinfo($_FILES["file-upload"]["name"],PATHINFO_EXTENSION));
$target_file .= '.' . $fileType . generateRandomString(10);

if (move_uploaded_file($_FILES["file-upload"]["tmp_name"], $target_file)) {
    echo "Súbor '". $_POST['uploadedFileName']. '.' . $fileType . "' bol úspešne pridaný.";
} else {
    echo "Nastala chyba pri uploade súboru: " . substr($target_file, 0, -10);
}