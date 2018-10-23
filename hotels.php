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
<?php
    if(isset($_REQUEST['search'])) {
        $city=$_REQUEST['search'];
        $cin=$_REQUEST['checkin'];
        $cout=$_REQUEST['checkout'];

        if(!empty($_REQUEST['mincost']))
            $minCost=$_REQUEST['mincost'];
        if(!empty($_REQUEST['maxcost']))
            $maxCost=$_REQUEST['maxcost'];

        require_once("DBConnection.php");
        require_once ("get_data_methods.php");
        $sql="SELECT *FROM reservation";
        $sql2="SELECT * FROM hotel WHERE cityid=(SELECT cityid FROM city WHERE cityname='".$city."')";
        //echo $sql2;
        $res=json_decode(getJSONFromDB($sql));
        $hotel=json_decode(getJSONFromDB($sql2));
        //print_r($res);
        //print_r($hotel);
        for($i=0;$i<sizeof($res);$i++) {
			if($res[$i]->status=="Rejected") continue;
            $dt=$res[$i]->check_in_date;
            $dt2=$res[$i]->check_out_date;
            //echo $dt." "." "."<br>";
            //print_r($cin);
            $dt=strtotime($dt);
            $dt2=strtotime($dt2);

            $idate=strtotime($cin);
            $odate=strtotime($cout);
            //echo $dt." ".strtotime($cin)." ".strtotime($cout)."<br>";
            if(($dt>=$idate && $dt<=$odate) || ($dt2>=$idate && $dt2<=$odate) || ($dt<$idate && $dt2>$odate)) {
                for($j=0;$j<sizeof($hotel);$j++) {
                    if($hotel[$j]->hotelid==$res[$i]->hotelid)
                        $hotel[$j]->roomcount-=$res[$i]->roomcount;
                }
            }
        }
        $data=Array();
        for($i=0;$i<sizeof($hotel);$i++) {
            if($hotel[$i]->roomcount>0) {
                if(isset($minCost) && $hotel[$i]->cost<$minCost) continue;
                if(isset($maxCost) && $hotel[$i]->cost>$maxCost) continue;
                array_push($data,$hotel[$i]);
            }
        }
    }
?>

<html>
<head>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="stylev2.css">
    <link rel="stylesheet" href="styles.css">
    <title>Demo Hotel | Search Results</title>
</head>
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

    <div>
        <div style="float:left;width: 40%;">
            <div class="search_min">
                <form>
                    Name of the City: <br>
                    <input type="text" id="searchinput" name="search"/>
                    Check In Date: <br>
                    <input type="text" name="checkin" id="checkin" class="datepicker" />
                    Check Out Date: <br>
                    <input type="text" name="checkout" id="checkout" class="datepicker" />
                    Minimum Cost: <br>
                    <input type="number" id="mincost" name="mincost"/>
                    Maximum Cost: <br>
                    <input type="number" id="maxcost" name="maxcost"/>
                    <input type="button" value="Refine Search" onclick="validate()"/>
                </form>
                <div class="error_1" id="cityerr" style="color: red;"></div>
            </div>
        </div>
        <div style="float:right;width: 60%;">
            <div class="result">
                <?php
                if(!isset($data)) echo "<h1>Start Searching Hotels</h1>";
                else if(sizeof($data)==0) echo "<h1>Sorry, No Data Found</h1>";
                else {
                    for($i=0;$i<sizeof($data);$i++) {?>
                        <table align="left" width="100%" class="details">

                            <td><img src="<?php echo get_image_of($data[$i]->hotelid);?>" width="150px" height="150px"/></td>
                            <td>
                                <table class="innertable">
                                    <tr>
                                        <td><h2><a href="<?php echo 'facilities.php?hid='.$data[$i]->hotelid.
                                                '&in='.$cin.'&out='.$cout.'&ar='.$data[$i]->roomcount; ?>">
                                                    <?php echo ucwords($data[$i]->hotelname);?></a></h2></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo ucwords($city);?></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo "Available Rooms: ".$data[$i]->roomcount;?></td>
                                    </tr>
                                </table>
                            </td>
                            <td class="hotel_fare">
                                <h2><?php echo "Fare ".$data[$i]->cost." Taka";?></h2>
                            </td>
                        </table>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>

<script>
    function goPanel(){
        var go="<?php echo $_SESSION['status'];?>";
        console.log(go);
        if(go=="Admin" || go=="superadmin") window.location="admin_panel.php";
        else window.location="user_panel.php";
    }
</script>
<script type="text/javascript">
    function validate(){
        var city=document.getElementById("searchinput").value;
        var cin=document.forms[0].elements[1].value;
        var cout=document.forms[0].elements[2].value;
        //alert(city);
        if(city.length<1) {
            document.getElementById("cityerr").innerHTML = "Where do you want to go?";
            document.getElementById("cityerr").style.visibility = "visible";
            return;
        }
        else {
            document.getElementById("cityerr").style.visibility="hidden";
        }

        if(cin.length<1) {
            document.getElementById("cityerr").innerHTML = "Please select a Check In Date!";
            document.getElementById("cityerr").style.visibility = "visible";
            return;
        }
        var d=Date.parse(cin);
        if(isNaN(d)) {
            document.getElementById("cityerr").innerHTML = "Please Input Proper Date!";
            document.getElementById("cityerr").style.visibility = "visible";
            return;
        }
        //console.log("HERE"+d);
        var date=new Date;
        var now=date.getTime();

        if(now>=d) {
            document.getElementById("cityerr").innerHTML="Please select a date in the future!";
            document.getElementById("cityerr").style.visibility="visible";
            return;
        }
        else {
            document.getElementById("cityerr").style.visibility="hidden";
        }

        if(cout.length<1) return;
        var d2=Date.parse(cout);
        if(isNaN(d2)) {
            document.getElementById("cityerr").innerHTML = "Please Input Proper Date!";
            document.getElementById("cityerr").style.visibility = "visible";
            return;
        }
        if(d2<=d) {
            document.getElementById("cityerr").innerHTML="Check Out date should be after check in date!!";
            document.getElementById("cityerr").style.visibility="visible";
            return;
        }
        else {
            document.getElementById("cityerr").style.visibility="hidden";
        }
        document.forms[0].submit();
    }
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<?php
    if(isset($_REQUEST['search'])) {
        echo "<script>".
            '$("#searchinput").val("'.$_REQUEST["search"].'");'.
            '$("#checkin").val("'.$_REQUEST["checkin"].'");'.
            '$("#checkout").val("'.$_REQUEST["checkout"].'");'.
            "</script>";

        if(isset($minCost)) echo "<script>".'$("#mincost").val("'.$_REQUEST["mincost"].'");'."</script>";
        if(isset($maxCost)) echo "<script>".'$("#maxcost").val("'.$_REQUEST["maxcost"].'");'."</script>";
    }
?>
<script>
    $( function() {
        $( ".datepicker" ).datepicker();
    } );
    function assign(){

    }
</script>
</body>
</html>