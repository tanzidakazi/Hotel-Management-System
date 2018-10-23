<?php
    if(isset($_REQUEST['hid'])) {
        $sql="UPDATE facility SET central_air_conditioning='".$_REQUEST['1']."',cable_television='".$_REQUEST['2'].
            "',internet_access='".$_REQUEST['3']."',room_services='".$_REQUEST['4']."',conference_and_banquet_facility='".$_REQUEST['5']."',".
            " swimming_pool='".$_REQUEST['6']."' WHERE hotelid=".$_REQUEST['hid'];
        require_once("DBConnection.php");
        insert($sql);
        echo $sql;
        header("location:admin_panel.php");
    }
?>