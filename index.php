<!DOCTYPE html>
<html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript">
    var imgPath=["banner1.jpg","banner2.jpg","banner3.jpg"];
    var curr=-1;
    var bannerImg=new Array();
    for(i=0;i<imgPath.length;i++) {
        bannerImg[i]=new Image();
        bannerImg[i].src=imgPath[i];
    }
    function changeImage() {
        curr = (curr + 1 < imgPath.length) ? curr + 1 : 0;
        banner.src = bannerImg[curr].src;
        setTimeout(changeImage, 3000);
    }
    window.onload=function () {
        banner=document.getElementById("imgBanner");
        changeImage();
    }

</script>
<head>
    <link rel="stylesheet" href="styles.css">
    <title>Hotel Reservation</title>
</head>
<body>
<div style="width:80%">
<div>
    <nav id="header">
        <img class="header_img" src="logo.png" alt=""/>
        <ul class="nav_links">
            <li><a href="#">Home</a></li>
            <li><a href="hotels.php">Reservation</a></li>
			<?php
				session_start();
				if(isset($_SESSION['login']) && isset($_SESSION['username']) && $_SESSION['login']==true) {
					?>
					<li style="float:right;"><a href="dologout.php">Logout</a></li>
					<li style="float:right;"><a href="#" onclick="goPanel(); return false;"><?php echo ucwords($_SESSION['fname']);?></a></li>
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
    <div class="banner" style="padding: 10pt">
        <img class="banner_img" id="imgBanner" src="" alt=""/>
    </div>
</div>

<div class="search">
    <form action="hotels.php">
        <input id="search_box" type="text" name="search" placeholder="Start by Typing the name of city"/>
		<input class="calendar" type="text" name="checkin" id="calendar1" placeholder="Check In Date"/>
		<input class="calendar" type="text" name="checkout" id="calendar2" placeholder="Check Out Date" style="float: right"/>
        <div class="error" id="cityerr" ></div>
		<input class="find_button" type="button" value="Find Hotels" onclick="validate()"/>
    </form>
</div>
</div>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"/>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script type="text/javascript">
    function validate(){
        var city=document.getElementById("search_box").value;
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

        if(cout.length<1) {
            document.getElementById("cityerr").innerHTML = "Please select a Check Out  Date!";
            document.getElementById("cityerr").style.visibility = "visible";
            return;
        }
        var d2=Date.parse(cout);

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

<script>
	var availableTags='<?php 
		require_once("get_data_methods.php");
		echo getCities();
	?>';
	var cities=[];
	var jsonData=JSON.parse(availableTags);
	for(var i=0;i<jsonData.length;i++) {
		//var city=JSON.parse(availableTags[i]);
		cities.push(jsonData[i].cityname);
		//console.log(jsonData[i]);
	}
	$( function() {
	//alert("JJ");
		$( "#search_box" ).autocomplete({
		  source: cities
		});
	} );
	$(function() {
         $( "#calendar1" ).datepicker();   
		 $( "#calendar2" ).datepicker();   
    }); 
</script>

<script>
    function goPanel(){
        var go="<?php echo $_SESSION['status'];?>";
        console.log(go);
        if(go=="Admin" || go=="superadmin") window.location="admin_panel.php";
        else window.location="user_panel.php";
    }
</script>
</body>
</html>
