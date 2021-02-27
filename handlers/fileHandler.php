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

$uploadOk = 1;

$fileType = strtolower(pathinfo($_FILES["file-upload"]["name"],PATHINFO_EXTENSION));
$target_file .= '.' . $fileType . generateRandomString(10);

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}

// Check file size
if ($_FILES["file-upload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["file-upload"]["tmp_name"], $target_file)) {
        echo "Súbor '". htmlspecialchars( $_POST['uploadedFileName'] ). '.' . $fileType . "' bol úspešne pridaný.";
    } else {
        echo "Sorry, there was an error uploading your file with path:" . substr($target_file, 0, -10);
    }
}
?>