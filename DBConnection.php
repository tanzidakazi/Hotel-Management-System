<?php
    $conn=mysqli_connect("localhost","root","","hotel_schema");
    if(!$conn) die("Connection failed: ". mysqli_connect_error($conn));
    $GLOBALS['conn']=$conn;
    /*
    function insertDB($fname,$lname,$email,$uname,$pass) {
        //$conn=mysqli_connect("localhost","root","","hotel_schema");
        //if(!$conn) die("Connection failed: ". mysqli_connect_error());
        global $conn;
        $fname=$conn->real_escape_string($fname);
        $lname=$conn->real_escape_string($lname);
        $email=$conn->real_escape_string($email);
        $uname=$conn->real_escape_string($uname);
        $pass=$conn->real_escape_string($pass);

        $query="INSERT INTO `user` (`FirstName`, `LastName`, `UserName`, `Email`, `Password`, `status`)".
            "VALUES ('".$fname."', '".$lname."', '".$uname."', '".$email."', '".$pass."', NULL)";
        //console.log($query);

        if (mysqli_query($conn, $query)) return true;
        else return false;
    }*/

	function getJSONFromDB($sql){
		//$conn = mysqli_connect("localhost", "root", "","hotel_schema");
        //global $conn;
        $conn=$GLOBALS['conn'];
		//$sql=$conn->real_escape_string($sql);
		$result = mysqli_query($conn, $sql)or die(mysqli_error($conn));
		$arr=array();
		while($row = mysqli_fetch_assoc($result)) {
			$arr[]=$row;
		}
		return json_encode($arr);
	}
	
	function findMail($mail) {
		$sql = "SELECT * FROM `user` where email='".$mail."'";
		$jsn=json_decode(getJSONFromDB($sql));
		for($i=0;$i<sizeof($jsn);$i++) {
			if($jsn[$i]->email==$mail) return true;
		}
		return false;
	}
	
	function findUserName($uname) {
		$sql = "SELECT * FROM `user` where username='".$uname."'";
		$jsn=json_decode(getJSONFromDB($sql));
		for($i=0;$i<sizeof($jsn);$i++) {
			if($jsn[$i]->username==$uname) return true;
		}
		return false;
	}


	function insert($sql) {
	    global $conn;
        //$conn=mysqli_connect("localhost","root","","hotel_schema");
        //if(!$conn) die("Connection failed: ". mysqli_connect_error());
        mysqli_query($conn, $sql);
    }

    /*function checkLogin($uname,$pass){
        $conn=mysqli_connect("localhost","root","","hotel_schema");
        if(!$conn) die("Connection failed: ". mysqli_connect_error());

        $sql = "SELECT password FROM `user` where username='".$uname."'";
        $result = mysqli_query($conn, $sql)or die(mysqli_error($conn));
        if($row=mysqli_fetch_assoc($result)){
            if($pass==$row['password']) return true;
        }
        return false;
    }
    function findMail($mail){
        $conn=mysqli_connect("localhost","root","","hotel_schema");
        if(!$conn) die("Connection failed: ". mysqli_connect_error());

        $sql = "SELECT email FROM `user` where email='".$mail."'";
        $result = mysqli_query($conn, $sql)or die(mysqli_error());
        if ($row=mysqli_fetch_assoc($result))
            return true;
        else return false;
    }

    function findUserName($uname){
        $conn=mysqli_connect("localhost","root","","hotel_schema");
        if(!$conn) die("Connection failed: ". mysqli_connect_error());

        $sql = "SELECT username FROM `user` where username='".$uname."'";
        $result = mysqli_query($conn, $sql)or die(mysqli_error());
        return ($row=mysqli_fetch_assoc($result));
    }*/
?>