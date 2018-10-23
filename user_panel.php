<!DOCTYPE html>
<html>
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
<head>
    <link rel="stylesheet" href="stylesv3.css">
    <link rel="stylesheet" href="styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
</head>

<body>
<div class="container" >
    <div>
        <nav id="header">
            <img class="header_img" src="logo.png" alt=""/>
            <ul class="nav_links">
                <li><a href="index.php">Home</a></li>
                <li><a href="hotels.php">Reservation</a></li>
                <?php
                //session_start();
                if(isset($_SESSION['login']) && isset($_SESSION['username']) && $_SESSION['login']==true) {
                    ?>
                    <li style="float:right;"><a href="dologout.php">Logout</a></li>
                    <li style="float:right;"><a href="#" ><?php echo ucwords($_SESSION['fname']);?></a></li>
                    <?php
                }
                else {
                    ?>
                    <li style="float:right;"><a href="login.php">Login</a></li>
                    <li style="float:right;"><a href="Signup.php">Signup</a></li>
                    <?php
                }
                ?>

            </ul>
        </nav>
    </div>

    <div class="tab">
        <button class="tablinks" id="default" onclick="onTabClick(event,'bookings')">Manage Bookings</button>
        <button class="tablinks" onclick="onTabClick(event,'profile')">Manage Profile</button>
    </div>

    <div id="bookings" class="tabcontent">
        <h3>Manage Bookings</h3>
        <?php
        require_once("get_data.php");
        $data=json_decode(getBooking($_SESSION['username']));
        if(sizeof($data)==0) { ?><h2>No Bookings Found!!</h2><?php
        }
        else{
        ?>
        <table id="update_booking_table" >
            <tr>
                <th>Username</th>
                <th>Hotel Name</th>
                <th>Check In Date</th>
                <th>Check Out Date</th>
                <th>Room Count</th>
                <th>Transaction Id(Bkash)</th>
                <th>Status</th>
            </tr>
            <?php
            for($i=0;$i<sizeof($data);$i++) {
                ?>
                <tr>
                    <td><?php echo $data[$i]->username;?></td>
                    <td><?php getHotelName($data[$i]->hotelid);?></td>
                    <td><?php echo $data[$i]->check_in_date;?></td>
                    <td><?php echo $data[$i]->check_out_date;?></td>
                    <td><?php echo $data[$i]->roomcount;?></td>
                    <td><?php echo $data[$i]->trxid;?></td>
                    <td><?php echo $data[$i]->status;?></td>
                </tr>
                <?php
            } }?>
        </table>
    </div>

    <div id="profile" class="tabcontent">
        <h3>Manage Profile</h3>
        <?php
        require_once("DBConnection.php");
        $data=json_decode(getUser($_SESSION['username']));
        ?>
        <table>
            <tr>
                <td>First Name: </td>
                <td><?php echo $data[0]->firstname;?></td>
            </tr>
            <tr>
                <td>Last Name:</td>
                <td><?php echo $data[0]->lastname;?></td>
            </tr>
            <tr>
                <td>User Name:</td>
                <td><?php echo $data[0]->username;?></td>
            </tr>
            <tr>
                <td>Email: </td>
                <td><?php echo $data[0]->email;?></td>
            </tr>
            <tr>
                <td>Status:</td>
                <td><?php echo $data[0]->status;?></td>
            </tr>
        </table>
        <a style="margin-left: 35%;" href="edit_profile.php">Click Here to Update Profile Info!</a>
    </div>
</div>


<script>
    function onTabClick(evt,name){
        tabcontent=document.getElementsByClassName('tabcontent');
        for(i=0;i<tabcontent.length;i++)
            tabcontent[i].style.display="none";

        tablinks=document.getElementsByClassName('tablinks');
        for (i = 0; i < tablinks.length; i++)
            tablinks[i].className = tablinks[i].className.replace(" active", "");

        document.getElementById(name).style.display = "block";
        evt.currentTarget.className += " active";
    }
    document.getElementById("default").click();
</script>
</body>
</html>