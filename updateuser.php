<?php
session_start();
if(isset($_REQUEST['fname']) && isset($_REQUEST['lname']) && isset($_REQUEST['pass'])) {
    require("DBConnection.php");
    $fname=$conn->real_escape_string($_REQUEST['fname']);
    $lname=$conn->real_escape_string($_REQUEST['lname']);
    $pass=$conn->real_escape_string($_REQUEST['pass']);

    //$sql="UPDATE `user` SET `firstname` = '".$fname."', `lastname` = '".$fname."' WHERE `user`.`username` = 'a'";
    $sql="UPDATE `user` SET `firstname` = '".$fname."', `lastname` = '".$fname.
        "', `password` = '".$pass."' WHERE `user`.`username` = '".$_SESSION['username']."'";
    echo $sql;
    insert($sql);
    echo "OK";
    $_SESSION['fname']=$fname;
    $_SESSION['pass']=$_REQUEST['pass'];
}
else if(isset($_REQUEST['fname']) && isset($_REQUEST['lname'])){
    require("DBConnection.php");
    $fname=$conn->real_escape_string($_REQUEST['fname']);
    $lname=$conn->real_escape_string($_REQUEST['lname']);
    //$pass=$conn->real_escape_string($_REQUEST['pass']);

    $sql="UPDATE `user` SET `firstname` = '".$fname."', `lastname` = '".$lname."' WHERE `user`.`username` = '".$_SESSION['username']."'";
    insert($sql);
    $_SESSION['fname']=$fname;
    echo "OK";
}

?>