<?php
require_once("DBConnection.php");
/*echo "<pre>";
print_r($GLOBALS);
echo "</pre>";*/
if(isset($_REQUEST["firstname"]) && isset($_REQUEST["lastname"]) && isset($_REQUEST["email"]) && isset($_REQUEST["username"])
    && isset($_REQUEST["password"])) {
    $fname=$conn->real_escape_string($_REQUEST['firstname']);
    $lname=$conn->real_escape_string($_REQUEST['lastname']);
    $email=$conn->real_escape_string($_REQUEST['email']);
    $username=$conn->real_escape_string($_REQUEST['username']);
    $pass=$conn->real_escape_string($_REQUEST['password']);
    $sql="INSERT INTO user VALUES('".$fname."','".$lname."','".$username."','".$email."','".$pass."','Regular')";
    insert($sql);

    if($conn->affected_rows>0) header("Location: login.php");
    else header("Location: Signup.php");


    //if(insertDB($_REQUEST["firstname"],$_REQUEST["lastname"],$_REQUEST["email"],$_REQUEST["username"],$_REQUEST["password"])){
        //echo "Hoye geche";
        //header("Location: index.php");
    //}
    //echo "oi nai";
    //else header("Location: Signup.php");
}
else header("Location: Signup.php");
?>