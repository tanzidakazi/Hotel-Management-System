<!DOCTYPE html>
<?php
session_start();
require_once("get_data_methods.php");
if(isset($_SESSION['login']) && isset($_SESSION['username']) && $_SESSION['login']==true
    && isset($_SESSION['pass']) && isValidLogin($_SESSION['username'],$_SESSION['pass'])) {
    header("location:index.php");
}
?>
<html>
<head>
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <title>Hotel Reservation | Signup</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div style="width: 80%">
        <nav id="header">
            <img class="header_img" src="logo.png" alt=""/>
            <ul class="nav_links">
                <li><a href="index.php">Home</a></li>
                <li><a href="hotels.php">Reservation</a></li>
                <li style="float:right;"><a href="login.php">Login</a></li>
                <li style="float:right;"><a href="Signup.php">Signup</a></li>
            </ul>
        </nav>
    <div>
        <h1 align="center" style="color:darkgreen">Please Signup to Access all the features!!</h1>
    </div>
    <div class ="forms" id="signup">
        <form id="signup_form" name="signup_form" action="dosignup.php" method="get">
            <div class="form_hint">First Name: <br></div>
            <input type="text" name="firstname" onkeyup="namecheck(this)"/><br>
            <div class="error" id="ferr"></div>

            <div class="form_hint">Last Name: <br></div>
            <input type="text" name="lastname" onkeyup="namecheck(this)"/><br>
            <div class="error" id="lerr"></div>

            <div class="form_hint">Email Address: <br></div>
            <input type="text" name="email" onkeyup="emailcheck(this)"/><br>
            <div class="error" id="eerr"></div>

            <div class="form_hint">User Name: <br></div>
            <input type="text" name="username" onkeyup="usernamecheck(this)"/><br>
            <div class="error" id="uerr"></div>

            <div class="form_hint">Password: <br></div>
            <input type="password" name="password" onkeyup="passcheck(this)"/><br>
            <div class="error" id="perr"></div>

            <div class="form_hint">Confirm Password: <br></div>
            <input type="password" name="password2" onkeyup="confirmcheck(this)"/><br>
            <div class="error" id="cerr"></div>

            <input type="button" value="Signup" onclick="submitcheck()"/>
        </form>
    </div>
    </div>

<script type="text/javascript">
    var fn="",ln="",un="",ps="",em="",cp="";
    function namecheck(elm) {
        var namePattern=/^[A-Za-z]{2,31}$/;
        if(!namePattern.test(elm.value)){
            if(elm.getAttribute("name")=="firstname") {
                document.getElementById("ferr").style.visibility="visible";
                document.getElementById("ferr").innerHTML = "Invalid First Name!";
                document.forms[0].elements[0].style.borderColor="red";
                fn="";
            }
            else if(elm.getAttribute("name")=="lastname") {
                document.getElementById("lerr").style.visibility="visible";
                document.getElementById("lerr").innerHTML="Invalid Last Name!";
                document.forms[0].elements[1].style.borderColor="red";
                ln="";
            }
        }

        else {
            if(elm.getAttribute("name")=="firstname") {
                document.getElementById("ferr").style.visibility="hidden";
                document.forms[0].elements[0].style.borderColor="#f8efe9";
                fn="ok";

            }
            else if(elm.getAttribute("name")=="lastname") {
                document.getElementById("lerr").style.visibility="hidden";
                document.forms[0].elements[1].style.borderColor="#f8efe9";
                ln="ok";
            }
        }
    }

    function emailcheck(elm) {
        var emailPattern=/^[A-Za-z][A-Za-z0-9\.]*@[A-Za-z0-9]+\.[A-Za-z0-9]+$/;
        if(!emailPattern.test(elm.value)){
            document.getElementById("eerr").style.visibility="visible";
            document.getElementById("eerr").innerHTML = "Invalid Email!";
            document.forms[0].elements[2].style.borderColor="red";
            em="";
        }
        else {
            checkAvailable('email',elm.value);
        }
    }

    function usernamecheck(elm) {
        var namePattern=/^[A-Za-z][A-Za-z0-9]{3,31}$/;
        if(!namePattern.test(elm.value)) {
            document.getElementById("uerr").style.visibility="visible";
            document.getElementById("uerr").innerHTML = "Invalid User Name!";
            document.forms[0].elements[3].style.borderColor="red";
            un="";
        }
        else {
            checkAvailable('uname',elm.value);
        }
    }

    function passcheck(elm) {
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
        if(elm.value!=document.forms[0].elements[4].value) {
            document.getElementById("cerr").style.visibility="visible";
            document.getElementById("cerr").innerHTML = "Passwords do not match!";
            document.forms[0].elements[5].style.borderColor="red";
            cp="";
        }
        else {
            document.getElementById("cerr").style.visibility="hidden";
            document.forms[0].elements[5].style.borderColor="#f8efe9";
            cp="ok";
        }
    }
    
    function submitcheck() {
		namecheck(document.forms[0].elements[0]);
		namecheck(document.forms[0].elements[1]);
		emailcheck(document.forms[0].elements[2]);
		usernamecheck(document.forms[0].elements[3]);
		passcheck(document.forms[0].elements[4]);
		confirmcheck(document.forms[0].elements[5]);
        if(fn=="ok" && ln=="ok" && em=="ok" && un=="ok" && ps=="ok" && cp=="ok") {
            document.signup_form.action="dosignup.php";
            document.signup_form.submit();
        }
        //else alert("Error");
    }
</script>

<script>
    xmlHttp=new XMLHttpRequest();
    function checkAvailable(id,val) {
        xmlHttp.onreadystatechange=function(){
            if(xmlHttp.readyState==4 && xmlHttp.status==200) {
                var ret=xmlHttp.responseText;
                //alert(ret);
                if(ret=='true') {
                    if(id=='uname') {
                        document.getElementById("uerr").style.visibility="visible";
                        document.getElementById("uerr").innerHTML = "User Name already in use!!";
                        document.forms[0].elements[3].style.borderColor="red";
                        un="";
                    }
                    else {
                        document.getElementById("eerr").style.visibility="visible";
                        document.getElementById("eerr").innerHTML = "Email Address already in use!!";
                        document.forms[0].elements[2].style.borderColor="red";
                        em="";
                    }
                }
                else {
                    if(id=='uname') {
                        document.getElementById("uerr").style.visibility="hidden";
                        document.forms[0].elements[3].style.borderColor="#f8efe9";
                        un="ok";
                    }
                    else {
                        document.getElementById("eerr").style.visibility="hidden";
                        document.forms[0].elements[2].style.borderColor="#f8efe9";
                        em="ok";
                    }
                    //return true;
                }
                /*text.innerHTML=ret;
                spinner.style.visibility="hidden";*/
            }
        };
        var url="avail_check.php?id="+id+"&val="+val;
        console.log(url);
        xmlHttp.open("GET",url,true);
        xmlHttp.send();
    }
</script>
</body>
</html>