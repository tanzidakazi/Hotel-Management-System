<?php
/*echo "<pre>";
print_r($GLOBALS);
echo "</pre>";*/
if(isset($_REQUEST['uname']) && isset($_REQUEST['pass'])) {
    require("DBConnection.php");
    $name=$conn->real_escape_string($_REQUEST['uname']);
	$sql="SELECT * from `user` where `username`='".$name."'";
	$jsonData=getJSONFromDB($sql);
	$jsn=json_decode($jsonData);
	$flag=false;
	for($i=0;$i<sizeof($jsn);$i++) {
		//print_r($jsn[$i]);
		if($jsn[$i]->password==$_REQUEST['pass']) {
			//echo "paisi";
			$flag=true;
			if($jsn[$i]->status=="Banned") {
			    echo "banned";
            }
            else echo "ok";
            session_start();
            $_SESSION['login']=true;
            $_SESSION['username']=$_REQUEST['uname'];
            $_SESSION['pass']=$_REQUEST['pass'];
            $_SESSION['fname']=$jsn[$i]->firstname;
            $_SESSION['status']=$jsn[$i]->status;
			//header("location:index.php");
		}
	}
	if($flag==false) echo "Username or Password incorrect";
    /*if(checkLogin($_REQUEST['username'],$_REQUEST['password'])) {
        header("location:index.php");
    }*/
   // else header("location:login.php");
}
?>