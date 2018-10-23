<?php
function get_photos($hid) {
    $path="uploads/hotels/".$hid;
    if(folder_exist($path)===FALSE) return null;
    else {
        $file_display = array(
            'jpg',
            'jpeg',
            'png',
            'gif'
        );
        $images=array();
        $contents=scandir($path);
        foreach ($contents as $file) {
            if ($file !== '.' && $file !== '..') {
                //echo $file;
                array_push($images,$file);
            }
        }
        return json_encode($images);
    }
}

function folder_exist($folder) {
    //return is_dir($folder);
    $path = realpath($folder);
    return ($path !== false && is_dir($path)) ? $path : false;
}

function isValidLogin($user,$pass) {
    require_once("DBConnection.php");
    $sql="SELECT * FROM user WHERE username='".$user."'";
    $data=json_decode(getJSONFromDB($sql));
    return sizeof($data)>0 && $data[0]->password==$pass;
}

function get_image_of($hid) {
    $path="uploads/hotels/".$hid;
    $images=json_decode(get_photos($hid));
    //print_r($images);
    if(sizeof($images)==0) return;
    else return $path."/".$images[0];
}

function getCities() {
    $sql="SELECT * FROM `city`";
    require_once("DBConnection.php");
    $json=getJSONFromDB($sql);
    return $json;
}

function addCity($name) {
    require_once("DBConnection.php");
    global $conn;
    $name=$conn->real_escape_string($name);
    $sql="INSERT into `city` VALUES(NULL ,'".$name."')";
    insert($sql);
}

function getHotels() {
    $sql="SELECT * FROM `hotel`";
    require_once("DBConnection.php");
    $json=getJSONFromDB($sql);
    return $json;
}

function getHotelName($id) {
    $sql="SELECT * FROM hotel WHERE hotelid=".$id;
    require_once("DBConnection.php");
    $data=json_decode(getJSONFromDB($sql));
    if(sizeof($data)>0) echo $data[0]->hotelname;
}

function setBookingStatus($id,$status) {
    require_once("DBConnection.php");
    global $conn;
    $status=$conn->real_escape_string($status);
    $sql="UPDATE reservation SET status='".$status."' WHERE reservationid=".$id;
    echo $sql;
    insert($sql);
}

function getBookingCount($username) {
    require_once("DBConnection.php");
    global $conn;
    $username=$conn->real_escape_string($username);
    $sql="SELECT * FROM reservation WHERE username='".$username."'";
    $data=json_decode(getJSONFromDB($sql));
    return  sizeof($data);
}

function getUsers() {
    $sql="SELECT * FROM user";
    require_once("DBConnection.php");
    $json=getJSONFromDB($sql);
    return $json;
}

function getUser($username) {
    $sql="SELECT * FROM user WHERE username='".$username."'";
    require_once("DBConnection.php");
    $json=getJSONFromDB($sql);
    return $json;
}

function getBookings() {
    $sql="SELECT * FROM `reservation`";
    require_once("DBConnection.php");
    $json=getJSONFromDB($sql);
    return $json;
}

function getBooking($username) {
    require_once("DBConnection.php");
    global $conn;
    $username=$conn->real_escape_string($username);
    $sql="SELECT * FROM `reservation` WHERE username='".$username."'";
    $json=getJSONFromDB($sql);
    return $json;
}

?>