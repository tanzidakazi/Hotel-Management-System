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
    if(!(isset($_REQUEST['hid']) || isset($_REQUEST['in']) || isset($_REQUEST['out']) || isset($_REQUEST['ar'])))
        header("location:hotels.php");
    //session_start();
    require_once ("DBConnection.php");
    $sql="SELECT * FROM hotel WHERE hotelid=".$_REQUEST['hid'];
    $data=json_decode(getJSONFromDB($sql));
    $sql="SELECT * FROM facility WHERE hotelid=".$_REQUEST['hid'];
    $fac=json_decode(getJSONFromDB($sql));
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
<h1><?php echo "Hotel ".$data[0]->hotelname;?></h1>
<div>
    <h2>Facilties:</h2><br>
    <ul>
    <?php
    if($fac[0]->central_air_conditioning=="yes" || $fac[0]->central_air_conditioning=="Yes"){
        ?>
        <li>Central Air Conditioning.</li>
        <?php
    }
    if($fac[0]->cable_television=="yes" || $fac[0]->cable_television=="Yes"){
        ?>
        <li>Cable Television.</li>
        <?php
    }
    if($fac[0]->internet_access=="yes" || $fac[0]->internet_access=="Yes"){
        ?>
        <li>Internet Access.</li>
        <?php
    }
    if($fac[0]->room_services=="yes" || $fac[0]->room_services=="Yes"){
        ?>
        <li>Room Services.</li>
        <?php
    }
    if($fac[0]->conference_and_banquet_facility=="yes" || $fac[0]->conference_and_banquet_facility=="Yes"){
        ?>
        <li>Conference and Banquet Facility.</li>
        <?php
    }
    if($fac[0]->swimming_pool=="yes" || $fac[0]->swimming_pool=="Yes"){
        ?>
        <li>Swimming Pool.</li>
        <?php
    }
    ?>
    </ul>
</div>

<div>
    <h2>Photos:</h2><br>
    <?php
    require_once ("get_data_methods.php");
    $images=json_decode(get_photos($_REQUEST['hid']));
    //print_r(scandir("uploads/hotels/".$_REQUEST['hid']."/"));
    if($images!=null) {
        $path="uploads/hotels/".$_REQUEST['hid']."/";
        for($i=0;$i<sizeof($images);$i++) {
            echo '<a target="_blank" href='.$path.$images[$i].'>'.
                '<img src="'.$path.$images[$i].'"alt="Hotel" width="400"></a>';
        }
    }
    ?>
</div>

<div>
    <div class="search_min">
        <form action="confirm.php">
            <input type="text" hidden name="hid" value="<?php echo $_REQUEST['hid'];?>">
            Check In Date: <br>
            <input type="text" name="checkin" class="datepicker" value="<?php echo $_REQUEST['in'];?>" readonly="readonly"/><br>
            Check Out Date: <br>
            <input type="text" name="checkout" class="datepicker" value="<?php echo $_REQUEST['out'];?>" readonly="readonly"/><br>
            Number of Rooms: <br>
            <select name="roomcount">
                <option value="0" disabled selected>0</option>
                <?php
                for($i=1;$i<$_REQUEST['ar']+1;$i++) {
                    ?>
                    <option value="<?php echo $i;?>"><?php echo $i;?></option>
                    <?php
                }
                ?>
            </select><br>
            <input type="submit" value="Confirm Booking"/>
        </form>
        <div class="error" id="cityerr">A</div>
    </div>
</div>
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
</html>