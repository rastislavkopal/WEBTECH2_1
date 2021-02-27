<?php

$dir ="../files/";

if(isset($_GET['innerdir']) && !is_null($_GET['innerdir']) && $_GET['innerdir'] != '.') {
    $dir.= $_GET['innerdir'];
    $files = array_diff(scandir($dir), array('..'));
} else {
    $files = array_diff(scandir($dir), array('.', '..'));
}

$dir = rtrim($dir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
$dataArr = array();

foreach ($files as $key => $value){
    if (is_dir($dir . $value)){
        if ($value == '.'){
            $dataArr[] = array( "<a href='?innerdir=$value'>..</a>", "", "");
        } else {
            $dataArr[] = array( "<a href='?innerdir=$value'>" . $value . "</a>", "", "");
        }
    } else if (file_exists($dir . $value)) {
        $date = date ("F d Y H:i:s.", filemtime( $dir . $value));
        $fsize = filesize($dir . $value);
        $dataArr[] = array( substr($value, 0, -10) , $fsize, $date);
    }
}

echo json_encode($dataArr);

