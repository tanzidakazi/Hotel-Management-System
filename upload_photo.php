<?php
session_start();
print_r($GLOBALS);
if(isset($_REQUEST['hotelid'])) {
    //require_once("get_data.php");
    $path="uploads/hotels/".$_REQUEST['hotelid']."/";
    $filepath=$path.$_FILES['file_upload']['name'];
    print_r($_FILES);
    if(file_exists($filepath)) {
        $_SESSION['fileUploadError']="File Already Exists!!";
        header("location:add_photo.php?error=true");
    }
    else if($_FILES['file_upload']['size']>1024000) {
        $_SESSION['fileUploadError']="File Size Exceeded!!";
        header("location:add_photo.php?error=true");
    }
    //if(folder_exist($path)==FALSE) {
        mkdir($path);
    //}
    if(move_uploaded_file($_FILES['file_upload']['tmp_name'],$filepath)) {
        $_SESSION['fileUploadError']="File Uploaded!!";
        header("location:add_photo.php?error=false");
    }
    else {
        $_SESSION['fileUploadError']="Could not upload file!!";
        //header("location:add_photo.php?error=true");
    }
}

?>