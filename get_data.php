<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
//print_r($_SESSION);
?>
<?php

    if(isset($_REQUEST['addhotel']) && isset($_REQUEST['city']) && isset($_REQUEST['roomcount']) && isset($_REQUEST['cost']) && isset($_REQUEST['hname'])) {
        require("DBConnection.php");
        $hname=$conn->real_escape_string($_REQUEST['hname']);
        $city=$conn->real_escape_string($_REQUEST['city']);
        $cost=$conn->real_escape_string($_REQUEST['cost']);
        $roomcount=$conn->real_escape_string($_REQUEST['roomcount']);

        $sql="INSERT INTO hotel VALUES(NULL,".$city.",'".$hname."',".$cost.",".$roomcount.")";
        insert($sql);
        $sql="SELECT * FROM hotel where hotelid=".mysqli_insert_id($conn);
        $jsn=json_decode(getJSONFromDB($sql));
        if(sizeof($jsn)>0) {
            echo "true";
            $sql="INSERT INTO facility VALUES(".$jsn[0]->hotelid.",'no','no','no','no','no','no')";
            insert($sql);
        }

    }

    if(isset($_REQUEST['updatehotel']) && isset($_REQUEST['roomcount']) && isset($_REQUEST['cost']) && isset($_REQUEST['hname'])) {
        require("DBConnection.php");
        $hname=$conn->real_escape_string($_REQUEST['hname']);
        $cost=$conn->real_escape_string($_REQUEST['cost']);
        $roomcount=$conn->real_escape_string($_REQUEST['roomcount']);

        $sql="UPDATE hotel SET hotelname='".$hname."', cost=".$cost.", roomcount=".$roomcount." WHERE hotelid=".$_REQUEST['updatehotel'];
        insert($sql);
        if($conn->affected_rows>0) echo 'true';
    }

    if(isset($_REQUEST['updatebooking']) && isset($_REQUEST['status'])) {
        require_once("get_data_methods.php");
        setBookingStatus($_REQUEST['updatebooking'],$_REQUEST['status']);
    }

    if(isset($_REQUEST['deletehotel'])) {
        require("DBConnection.php");
        $sql="DELETE FROM reservation WHERE hotelid=".$_REQUEST['deletehotel'];
        insert($sql);
        $sql="DELETE FROM `facility` WHERE `hotelid` = ".$_REQUEST['deletehotel'];
        insert($sql);
        $sql="DELETE FROM `hotel` WHERE `hotel`.`hotelid` = ".$_REQUEST['deletehotel'];
        insert($sql);
        if($conn->affected_rows>0) echo 'true';
    }

    if(isset($_REQUEST['deletephoto'])) {
        //echo is_dir($_REQUEST['deletephoto']);
        /*$path= dirname($_REQUEST['deletephoto']);
        print_r(scandir($path));
        $img=realpath($_REQUEST['deletephoto']);
        if($img!==FALSE) $img.="";*/
        unlink(__DIR__ ."\\".$_REQUEST['deletephoto']);
    }

    if(isset($_REQUEST['hotel'])) {
        $sql="SELECT * FROM `hotel`";
        require_once("DBConnection.php");
        $json=getJSONFromDB($sql);
        if($_REQUEST['hotel']=='echo') echo $json;
        return $json;
    }

    if(isset($_REQUEST['hotelid'])) {
        require("DBConnection.php");
        $hid=$conn->real_escape_string($_REQUEST['hotelid']);
        $sql="SELECT * FROM `hotel` where hotelid=".$hid;
        echo getJSONFromDB($sql);
    }

	if(isset($_REQUEST['city'])) {
        //print_r($_REQUEST);
		$sql="SELECT * FROM `city`";
		//echo $sql;
		require_once("DBConnection.php");
		$json=getJSONFromDB($sql);
		if($_REQUEST['city']=='echo') echo $json;
		return $json;
		//$jsn=json_decode($json);
		/*for($i=0;$i<sizeof($jsn);$i++) {
			echo $jsn[$i]->cityname;
		}*/
	}

	if(isset($_REQUEST['addcity'])) {
	    $sql="SELECT * FROM city WHERE cityname='".$_REQUEST['addcity']."'";
        require_once("DBConnection.php");
        require_once ("get_data_methods.php");
        $json=getJSONFromDB($sql);
        //print_r($json);
        $jsn=json_decode($json);
        if(sizeof($jsn)>=1) echo "City Already Exists!";
        else {
            addCity($_REQUEST['addcity']);
            echo "City Added Successfully";
        }
    }

    if(isset($_REQUEST['updatecity']) && isset($_REQUEST['update'])) {
        $sql="UPDATE `city` SET `cityname` = '".$_REQUEST['update']."' WHERE `city`.`cityid` = ".$_REQUEST['updatecity'];
        require_once("DBConnection.php");
        insert($sql);
        echo "City Name Changed!";
    }

    if(isset($_REQUEST['deletecity'])) {
        require_once("DBConnection.php");
        $sql="SELECT * FROM hotel WHERE cityid=".$_REQUEST['deletecity'];
        //echo $sql."<br>";
        $data=json_decode(getJSONFromDB($sql));
        //print_r($data);
        for($i=0;$i<sizeof($data);$i++) {
            $sql="DELETE FROM reservation WHERE hotelid=".$data[$i]->hotelid;
            //echo $sql."<br>";
            insert($sql);
            $sql="DELETE FROM `facility` WHERE `hotelid` = ".$data[$i]->hotelid;
            //echo $sql."<br>";
            insert($sql);
            $sql="DELETE FROM `hotel` WHERE `hotel`.`hotelid` = ".$data[$i]->hotelid;
            insert($sql);
        }
	    $sql="DELETE FROM `city` WHERE `city`.`cityid` = ".$_REQUEST['deletecity'];

        insert($sql);
        echo "City Deleted!";
	}

	if(isset($_REQUEST['updateuser']) && isset($_REQUEST['update'])) {
	    //echo $_REQUEST['update'].$_REQUEST['updateuser'];
        $sql="UPDATE `user` SET `status` = '".$_REQUEST['update']."' WHERE `user`.`username` = '".$_REQUEST['updateuser']."'";
        //$sql="UPDATE `user` SET status = '".$_REQUEST['update']."' WHERE `user`.`username` = '".$_REQUEST['updateuser']."''";
        echo $sql;
        require_once ("DBConnection.php");
        insert($sql);
        echo "User Updated";
    }

    if(isset($_REQUEST['deleteuser'])) {
        $sql="DELETE FROM `user` WHERE `username` = '".$_REQUEST['deleteuser']."'";
        require_once("DBConnection.php");
        insert($sql);
        echo "User Deleted!";
    }

    if(isset($_REQUEST['get_photo'])) {
        require_once ("get_data_methods.php");
        $path="uploads/hotels/".$_REQUEST['get_photo'];
        if(folder_exist($path)===FALSE) echo 'FALSE';
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
            echo json_encode($images);
        }
    }

    if(isset($_REQUEST['confirmBooking']) && isset($_REQUEST['hid']) && isset($_REQUEST['checkin']) && isset($_REQUEST['checkout'])
        && isset($_REQUEST['roomcount']) && isset($_REQUEST['trx'])) {
        require_once("DBConnection.php");
        $username=$_SESSION['username'];
        $hid=$conn->real_escape_string($_REQUEST['hid']);
        $checkin=$conn->real_escape_string($_REQUEST['checkin']);
        $checkout=$conn->real_escape_string($_REQUEST['checkout']);
        $count=$conn->real_escape_string($_REQUEST['roomcount']);
        $trx=$conn->real_escape_string($_REQUEST['trx']);
        $sql="INSERT into reservation VALUES(NULL,'".$username."',".$hid.",'".$checkin."','".$checkout."','".$trx."','".$count."',NULL)";
        //echo $sql;
        insert($sql);
        echo $conn->affected_rows;
    }


?>