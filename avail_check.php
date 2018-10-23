<?php
    include('DBConnection.php');
    if(isset($_REQUEST['id']) && isset($_REQUEST['val'])) {
        if($_REQUEST['id']=="uname") {
            if(findUserName($_REQUEST['val'])) echo "true";
            else echo "false";
        }
        else {
            if(findMail($_REQUEST['val'])) echo "true";
            else echo "false";
        }
    }
?>