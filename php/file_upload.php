<?php
require('Uploader.php');

// Directory where we're storing uploaded images
// Remember to set correct permissions or it won't work
// $upload_dir = "../img/".$_REQUEST["dirname"];

$upload_dir = "../upload/";
$uploader = new FileUpload('uploadfile');
// $uploader->newFileName = $_REQUEST["filename"];

// Handle the upload
$result = $uploader->handleUpload($upload_dir);

if (!$result) {
  exit(json_encode(array('success' => false, 'msg' => $uploader->getErrorMsg())));  
}

echo json_encode(array('success' => true));
