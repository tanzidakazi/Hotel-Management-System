<!DOCTYPE html>
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

<html>
<head>
<link rel="stylesheet" href="styles.css">
<style>
body {
	font-family: "Times New Roman", Georgia, Serif;
	background:	#ebf8eb; text-align:center;
	font-size: 20px;
	font-weight: bold;
	color: slategrey;
	}
label { 
    display: inline-block;
    width: 350px;
	text-align:left
	   }
input {
    display: inline-block;
    width: 350px;
    text-align:left
}
.button {
    background-color: aquamarine;
    border: none;
    color: slategrey;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}
</style>
</head>
<?php
   // echo "<script>LoadData();</script>";
    function Load() {
        $sql="SELECT * from `hotel` INNER JOIN facility ON hotel.hotelid=facility.hotelid 
              AND hotel.hotelid=".$_REQUEST['hid'];
        //echo $sql;
        require_once("DBConnection.php");
        require_once ("get_data_methods.php");
        echo getJSONFromDB($sql);
    }
?>

<body>
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
<form action="dohotel.php?hid=<?php echo $_REQUEST['hid']?>" method="get">
    <input type="hidden" id="hid_hidden" name="hid">
<h2 id="hname"></h2>
<label>Central Air Conditioning: </label> 
	<select name='1' style="width: 170px;">
	<option value="Yes">Yes</option>
	<option value="No">No</option>
	</select><br><br>
<label>Cable television: </label> 
	<select name='2' style="width: 170px;">
	<option value="Yes">Yes</option>
	<option value="No">No</option>
	</select><br><br>
<label>Internet access: </label> 
	<select name='3' style="width: 170px;">
	<option value="Yes">Yes</option>
	<option value="No">No</option>
	</select><br><br>
<label>Room services: </label> 
	<select name='4' style="width: 170px;">
	<option value="Yes">Yes</option>
	<option value="No">No</option>
	</select><br><br>
<label>Conference and Banquet facility: </label> 
	<select name='5' style="width: 170px;">
	<option value="Yes">Yes</option>
	<option value="No">No</option>
	</select><br><br>
<label>Swimming pool: </label> 
	<select name='6' style="width: 170px;">
	<option value="Yes">Yes</option>
	<option value="No">No</option>
	</select><br><br>
<button type="submit" class="button" name="update">SUBMIT</button><br><br>
</form>
</div>
</body>

<script>
    function goPanel(){
        var go="<?php echo $_SESSION['status'];?>";
        console.log(go);
        if(go=="Admin" || go=="superadmin") window.location="admin_panel.php";
        else window.location="user_panel.php";
    }
</script>
<script>
    function loadData() {
        var jsn = '<?php Load()?>';
        console.log(jsn);
        x = -3;
        if (jsn == "") return;
        var data = JSON.parse(jsn);

        for (i in data[0]) {
           if(i=="hotelname") document.getElementById('hname').innerHTML=data[0][i];
            if(i=="hotelid") document.getElementById('hid_hidden').value=data[0][i];
            if (data[0][i] == "no" || data[0][i] == "No") {
                if (i == "central_air_conditioning") document.forms[0]['1'].value = "No";
                if (i == "cable_television") document.forms[0]['2'].value = "No";
                if (i == "internet_access") document.forms[0]['3'].value = "No";
                if (i == "room_services") document.forms[0]['4'].value = "No";
                if (i == "conference_and_banquet_facility") document.forms[0]['5'].value = "No";
                if (i == "swimming_pool") document.forms[0]['6'].value = "No";
            }
        }
    }
</script>

<?php
    echo "<script>loadData();</script>";
?>
</html>