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
    require_once("DBConnection.php");
    if(isset($_SESSION['login']) && isset($_SESSION['username']) && $_SESSION['login']==true) {
        $sql="SELECT * from user where username='".$_SESSION['username']."'";
        $jsonData=getJSONFromDB($sql);
        //echo $jsonData;
        $jsn=json_decode($jsonData);
    }
    else header("location:login.php");
    ?>
<html>
<head>
    <title>Hotel Reservation | Edit Profile</title>
    <link rel="stylesheet" href="styles.css">

<script>
	function update() {
		
	}
</script>
</head>
<body>
<style>
body {
	background:	#ebf8eb; text-align:center;
	font-weight: bold;
	color: slategrey;
	}
label { 
       display: inline-block;
       width: 300px;
	   text-align:justify;
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
<div style="width: 80%">
    <div>
        <nav id="header">
            <img class="header_img" src="logo.png" alt=""/>
            <ul class="nav_links">
                <li><a href="index.php">Home</a></li>
                <li><a href="hotels.php">Reservation</a></li>
                <li style="float:right;"><a href="dologout.php">Logout</a></li>
                <li style="float:right;"><a  href="#" onclick="goPanel(); return false;"><span id="session_name"><?php echo ucwords($_SESSION['fname']);?></span></a></li>
            </ul>
        </nav>
    </div>
<h1 style="color:crimson;">EDIT PROFILE</h1>
    <h3 id="updateprofile"style="color:green;display: none;">Profile Updated!!</h3>
    <div class ="forms" id="signup">
        <form id="signup_form" name="signup_form" action="dosignup.php" method="get">
            <div class="form_hint">First Name: <br></div>
            <input type="text" name="firstname" onkeyup="namecheck(this)" value="<?php echo ucwords($jsn[0]->firstname);?>"/><br>
            <div class="error" id="ferr"></div>

            <div class="form_hint">Last Name: <br></div>
            <input type="text" name="lastname" onkeyup="namecheck(this)" value="<?php echo ucwords($jsn[0]->lastname);?>"/><br>
            <div class="error" id="lerr"></div>

            <div class="form_hint">Email Address: <br></div>
            <input type="text" name="email" style="background-color: #66757f" value="<?php echo $jsn[0]->email;?>" readonly/><br>
            <div class="error" id="eerr"></div>

            <div class="form_hint">User Name: <br></div>
            <input type="text" name="username" style="background-color: #66757f" value="<?php echo ($jsn[0]->username);?>" readonly/><br>
            <div class="error" id="uerr"></div>

            <div class="form_hint">Change Password: <br></div>
            <input type="password" name="password" onkeyup="passcheck(this)"/><br>
            <div class="error" id="perr"></div>

            <div class="form_hint">Confirm Password: <br></div>
            <input type="password" name="password2" onkeyup="confirmcheck(this)"/><br>
            <div class="error" id="cerr"></div>

            <input type="button" value="Update Profile" onclick="submitcheck()"/>
        </form>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
    var fn="",ln="",ps="",cp="";
    function namecheck(elm) {
        var namePattern = /^[A-Za-z]{2,31}$/;
        if (!namePattern.test(elm.value)) {
            if (elm.getAttribute("name") == "firstname") {
                document.getElementById("ferr").style.visibility = "visible";
                document.getElementById("ferr").innerHTML = "Invalid First Name!";
                document.forms[0].elements[0].style.borderColor = "red";
                fn = "";
            }
            else if (elm.getAttribute("name") == "lastname") {
                document.getElementById("lerr").style.visibility = "visible";
                document.getElementById("lerr").innerHTML = "Invalid Last Name!";
                document.forms[0].elements[1].style.borderColor = "red";
                ln = "";
            }
        }

        else {
            if (elm.getAttribute("name") == "firstname") {
                document.getElementById("ferr").style.visibility = "hidden";
                document.forms[0].elements[0].style.borderColor = "#f8efe9";
                fn = "ok";

            }
            else if (elm.getAttribute("name") == "lastname") {
                document.getElementById("lerr").style.visibility = "hidden";
                document.forms[0].elements[1].style.borderColor = "#f8efe9";
                ln = "ok";
            }
        }
    }

    function passcheck(elm) {
        if(elm.value.length<1) return;
        if(elm.value.length<6) {
            document.getElementById("perr").style.visibility="visible";
            document.getElementById("perr").innerHTML = "Password should be at least of six characters!";
            document.forms[0].elements[4].style.borderColor="red";
            ps="";
        }
        else {
            document.getElementById("perr").style.visibility="hidden";
            document.forms[0].elements[4].style.borderColor="#f8efe9";
            ps="ok";
        }
    }

    function confirmcheck(elm) {
        if (elm.value != document.forms[0].elements[4].value) {
            document.getElementById("cerr").style.visibility = "visible";
            document.getElementById("cerr").innerHTML = "Passwords do not match!";
            document.forms[0].elements[5].style.borderColor = "red";
            cp = "";
        }
        else {
            document.getElementById("cerr").style.visibility = "hidden";
            document.forms[0].elements[5].style.borderColor = "#f8efe9";
            cp = "ok";
        }
    }
    function submitcheck() {
        namecheck(document.forms[0].elements[0]);
        namecheck(document.forms[0].elements[1]);
        passcheck(document.forms[0].elements[4]);
        confirmcheck(document.forms[0].elements[5]);

        //console.log(fn+ln+cp);
        var updater=document.getElementById('updateprofile');
        var name=document.getElementById('session_name');

        if(document.forms[0].elements[4].value.length<6) {
            var url="updateuser.php?fname="+document.forms[0].elements[0].value+"&lname="+document.forms[0].elements[1].value;
            console.log(url);
            var data=AJAXData(url);
            updater.style.display="block";
            name.innerHTML=document.forms[0].elements[0].value;
            //console.log(data);
        }

        if(fn=="ok" && ln=="ok" && ps=="ok" && cp=="ok") {
            //document.signup_form.action="dosignup.php";
            //document.signup_form.submit();
            var url="updateuser.php?fname="+document.forms[0].elements[0].value+"&lname="+document.forms[0].elements[1].value+"&pass="+
                document.forms[0].elements[4].value;
            console.log(url);
            AJAXData(url);
            updater.style.display="block";
        }
        //else alert("Error");
    }
</script>
<script>
    function AJAXData(page) {
        xmlHttp=new XMLHttpRequest();
        xmlHttp.onreadystatechange=function(){
            if(xmlHttp.readyState==4 && xmlHttp.status==200) {
                var ret = xmlHttp.responseText;
                console.log(ret);
                //return ret;
            }
        };
        //var url=page;
        //console.log(url);
        xmlHttp.open("GET",page,true);
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
</body>

</html>