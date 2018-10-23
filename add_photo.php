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
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="photostyles.css">
    <link rel="stylesheet" href="message_sheet.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
</head>

<body>
<div class="container" style="width: 80%">
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
    </div>

    <div style="visibility: hidden">
        <div class="notification" align="center"></div>
    </div>

    <form action="upload_photo.php" method="post" enctype="multipart/form-data">
    <span class="textspan">Select A Hotel:</span>
    <select id="hotel_select" onchange="onHotelChoose()" name="hotelid">
        <?php
            require_once ("get_data_methods.php");
            $data=json_decode(getHotels());
        ?>
        <option selected disabled value="empty">Choose One</option>
        <?php
            for($i=0;$i<sizeof($data);$i++) {
                ?>
                <option value="<?php echo $data[$i]->hotelid;?>"><?php echo $data[$i]->hotelname;?></option>
                <?php
            }
        ?>
    </select>
    <div class="uploader">
        <span class="textspan" style="">Upload A New Photo:</span>
        <input type="file" name="file_upload">
        <input type="submit" onclick="return validate()" name="submit" value="Upload">
        <div style="color: red;font-size: 20px" id="photo_result"></div>
        </form>
    </div>
    <span class="textspan">View Uploaded Photos:</span>
    <div class="gallery" id="photo_holder"></div>
</div>
<script>
    function onHotelChoose() {
        var id=document.getElementById('hotel_select').value;
        //console.log(id);
        var folder_path="uploads\\hotels\\"+id+"\\";

        var holder=document.getElementById('photo_holder');
        holder.innerHTML="";

        xmlHttp=new XMLHttpRequest();
        xmlHttp.onreadystatechange=function(){
            if(xmlHttp.readyState==4 && xmlHttp.status==200) {
                var ret = xmlHttp.responseText;
                if(ret=='FALSE') return;
                console.log(ret);
                var data=JSON.parse(ret);

                for(i=0;i<data.length;i++) {
                    holder.innerHTML+='<a target="_blank" href='+folder_path+data[i]+'>'+
                    '<img src="'+folder_path+data[i]+'"alt="Hotel" width="400"></a>';
                    holder.innerHTML+="<button class='photo_button' onclick='deletePhoto(this)' value="+folder_path+data[i]+">Delete</button>";
                }
                console.log(holder);
            }

        };

        xmlHttp.open("GET","get_data.php?get_photo="+id,true);
        xmlHttp.send();
    }

    function validate() {
        if(document.getElementById('hotel_select').value=="empty") {
            $('#photo_result').html("Please Select A Hotel!");
        }
        else if(document.forms[0].elements[1].value.length < 1)
            $('#photo_result').html("Please Select A Picture To Upload!");

        return document.forms[0].elements[1].value.length >= 1 && document.getElementById('hotel_select').value!="empty";
    }

    function deletePhoto(elm) {
        //console.log(elm.value);
        xmlHttp=new XMLHttpRequest();
        xmlHttp.onreadystatechange=function(){
            if(xmlHttp.readyState==4 && xmlHttp.status==200) {
                console.log(xmlHttp.responseText);
                onHotelChoose();
            }
        };
        //var url=page;
        //console.log(url);
        xmlHttp.open("GET","get_data.php?deletephoto="+elm.value,true);
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