<!DOCTYPE html>
<html>

<?php
    session_start();
    require_once("get_data_methods.php");
    if(isset($_SESSION['login']) && isset($_SESSION['username']) && $_SESSION['login']==true
        && isset($_SESSION['pass']) && isValidLogin($_SESSION['username'],$_SESSION['pass'])) {
        header("location:index.php");
    }
?>
<head>
    <title>Hotel Reservation | Login</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
</head>
<body>
    <div style="width: 80%">
        <div>
            <nav id="header">
                <img class="header_img" src="logo.png" alt=""/>
                <ul class="nav_links">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="hotels.php">Reservation</a></li>
                    <li style="float:right;"><a href="login.php">Login</a></li>
                    <li style="float:right;"><a href="Signup.php">Signup</a></li>
                </ul>
            </nav>
        </div>

        <div>
            <h1 align="center" style="color: red">Please Login to Access all the features!!</h1>
        </div>
        <div class ="forms" id="signup">
            <form action="dologin.php" method="get">
                <input type="text" name="username" placeholder="Username"/><br>
                <div class="error" id="nerror"></div>
                <input type="password" name="password" placeholder="Password"/><br>
                <div class="error" id="perror"></div>
                <input type="button" onclick="login()" value="Login" />
            </form>
        </div>
    </div>

    <script>
        function login() {
            if(document.forms[0].elements[0].value.length<1) {
                document.getElementById("nerror").innerHTML="User Name cannot be empty!!";
                document.getElementById("nerror").style.visibility="visible";
            }
            else if(document.forms[0].elements[1].value.length<1) {
                document.getElementById("nerror").style.visibility="hidden";
                document.getElementById("perror").innerHTML="Password cannot be empty!!";
                document.getElementById("perror").style.visibility="visible";
            }
            else {
                document.getElementById("nerror").style.visibility="hidden";
                document.getElementById("perror").style.visibility="hidden";

                xmlHttp=new XMLHttpRequest();
                xmlHttp.onreadystatechange=function(){
                    if(xmlHttp.readyState==4 && xmlHttp.status==200) {
                        var ret = xmlHttp.responseText;
                        if(ret=="ok") {
                            console.log("OK");
                            window.location="index.php";
                        }
                        else if(ret=="banned") {
                            document.getElementById("perror").innerHTML="You Have Been Banned From This Site!";
                            document.getElementById("perror").style.visibility="visible";
                        }
                        else {
                            document.getElementById("perror").innerHTML=ret;
                            document.getElementById("perror").style.visibility="visible";
                        }
                    }
                };
                var url="dologin.php?uname="+document.forms[0].elements[0].value+"&pass="+document.forms[0].elements[1].value;
                //console.log(url);
                xmlHttp.open("GET",url,true);
                xmlHttp.send();
            }
        }
    </script>

</body>
</html>
