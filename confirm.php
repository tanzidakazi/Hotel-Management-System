<?php
session_start();
require_once("get_data_methods.php");
if(isset($_SESSION['login']) && isset($_SESSION['username']) && $_SESSION['login']==true
    && isset($_SESSION['pass']) && isValidLogin($_SESSION['username'],$_SESSION['pass'])) {
    //header("location:index.php");
}
else header("location:login.php");
//print_r($_SESSION);
?>

<?php
if(!(isset($_REQUEST['hid']) || isset($_REQUEST['checkin']) || isset($_REQUEST['checkout']) || isset($_REQUEST['roomcount'])))
    header("location:hotels.php");
?>

<?php
//session_start();
require_once ("DBConnection.php");
$sql="SELECT * FROM hotel WHERE hotelid=".$_REQUEST['hid'];
$data=json_decode(getJSONFromDB($sql));
$sql="SELECT * FROM facility WHERE hotelid=".$_REQUEST['hid'];
$fac=json_decode(getJSONFromDB($sql));
$cost;
/*
for($i=0;$i<sizeof($data);$i++) {
    if($data[$i]->hotelid==$_REQUEST['hid']) {
        $cost=$data[$i]->cost;
        break;
    }
}*/

?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="styles.css">
    <title>Hotel Reservation | Confirm Booking</title>
</head>
<body style="text-align: center">
<div style="width: 80%">
    <div>
        <nav id="header">
            <img class="header_img" src="logo.png" alt=""/>
            <ul class="nav_links">
                <li><a href="index.php">Home</a></li>
                <li><a href="hotels.php">Reservation</a></li>
                <li style="float:right;"><a href="dologout.php">Logout</a></li>
                <li style="float:right;"><a href="#" onclick="goPanel(); return false;"><?php echo ucwords($_SESSION['fname']);?></a></li>
            </ul>
        </nav>
    </div>
<h1><?php echo $data[0]->hotelname;?></h1>
<h3>Total Cost= <?php echo $_REQUEST['roomcount']*$data[0]->cost;?></h3>
<h3>Confirm Your Booking by Sending the Specified Amount to 01XXXXXXXX</h3>
<h3>Enter The Transaction ID Below:</h3>
<form>
    <input type="text" id="trx"><br>
    <input type="button" id="btn" value="Confirm Booking" onclick="onConfirm()">
    <h3 id="result"></h3>
</form>
</div>
</body>

<script>
    function onConfirm(){
        val=document.getElementById('trx').value;
        xmlHttp=new XMLHttpRequest();
        xmlHttp.onreadystatechange=function(){
            if(xmlHttp.readyState==4 && xmlHttp.status==200) {
                console.log(xmlHttp.responseText);
                if(xmlHttp.responseText==1) {
                    document.getElementById('btn').disabled = true;
                    document.getElementById('result').innerHTML = "Booking Inserted!!";
                }
                else document.getElementById('result').innerHTML = "Unable To Insert Booking!!!!";
            }
        };
        console.log(<?php echo $_REQUEST['checkin'];?>);
        var url="get_data.php?confirmBooking=1&hid="+ <?php echo $_REQUEST['hid'];?> +"&checkin="+ '<?php echo $_REQUEST['checkin'];?>' +"&checkout="+
        '<?php echo $_REQUEST['checkout'];?>' + "&roomcount=" + '<?php echo $_REQUEST['roomcount'];?>' +"&trx="+ val;
        console.log(url);
        xmlHttp.open("GET",url,true);
        xmlHttp.send();
    }
</script>

<script>
    function goPanel(){
        var go="<?php echo $_SESSION['status'];?>";
        console.log(go);
        if(go=="Admin" || go=="superadmin") window.location="admin_panel.php";
        else window.location="user_panel.php";
    }
</script>
</html>