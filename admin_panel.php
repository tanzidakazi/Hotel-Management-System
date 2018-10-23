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
        <button class="tablinks" id="default" onclick="onTabClick(event,'cities')">Manage Cities</button>
        <button class="tablinks" onclick="onTabClick(event,'hotels')">Manage Hotels</button>
        <button class="tablinks" onclick="onTabClick(event,'bookings')">Manage Bookings</button>
        <button class="tablinks" onclick="onTabClick(event,'users')">Manage Users</button>
        <button class="tablinks" onclick="onTabClick(event,'profile')">Manage Profile</button>
    </div>

    <div id="cities" class="tabcontent">
        <h3>Manage Cities</h3>
        <button class="opener" id="cityadd">Add a New City</button>
        <button class="opener" id="cityupdate">Edit A City</button>
        <button class="opener" id="citydelete">Delete A City</button>
        <div class="modal" id="cityaddmodal">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="close">&times;</span>
                    <h2>Add A New City</h2>
                </div>
                <div class="modal-body">
                    <form id="cityaddform">
                        <input type="text" id="addcitytext"/>
                        <input type="button" value="Add City" onclick="addCity()"/>
                        <div id="cityadderror"></div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal" id="cityupdatemodal">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="close">&times;</span>
                    <h2>Editing A City</h2>
                </div>
                <div class="modal-body">
                    <form id="cityupdateform">
                        <select id="updateselect"> </select>
                        <input type="text" placeholder="New Name" id="updatetext"/>
                        <input type="button" value="Update" onclick="updateCity()"/>
                        <div id="updateerror"></div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal" id="citydeletemodal">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="close">&times;</span>
                    <h2>Delete A City</h2>
                </div>
                <div class="modal-body">
                    <form id="citydeleteform">
                        <select id="deleteselect"></select>
                        <input type="button" value="Delete" onclick="deleteCity()"/>
                        <div class="warning">Deleting A City will also delete all hotels and bookings of that city!</div>
                        <div class="result" id="deleteerror"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="hotels" class="tabcontent">
        <h3>Manage Hotels</h3>
        <button class="opener" id="hoteladd">Add a New Hotel</button>
        <button class="opener" id="hotelupdate">Edit A Hotel</button>
        <button class="opener" id="hoteldelete">Delete A Hotel</button>

        <div class="modal" id="hoteladdmodal">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="close">&times;</span>
                    <h2>Add A New Hotel</h2>
                </div>
                <div class="modal-body">
                    <form id="hoteladdform">
                        Hotel Name:
                        <input type="text" name="hname"/><br>
                        City:
                        <select id="cityinfoselect" name="city"> </select><br>
                        Cost:
                        <input type="number" name="cost"/> <br>
                        Number of Rooms:
                        <input type="number" name="roomcount"/><br>
                        <input type="button" value="Add Hotel" name="addhotel" onclick="addHotel()"/>
                        <div class="result" id="hoteladdresult"></div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal" id="hotelupdatemodal">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="close">&times;</span>
                    <h2>Editing A Hotel</h2>
                </div>
                <div class="modal-body">
                    <form name="hotelupdateform">
                        Hotel:
                        <select id="updatehotelselect" name="hname" onchange="generateHotelInfo(this)"></select><br>
                        Hotel Name:
                        <input type="text" name="hname" id="updatehotelname"/><br>
                        Cost:
                        <input type="number" name="cost" id="updatehotelcost"/> <br>
                        Number of Rooms:
                        <input type="number" name="roomcount" id="updatehotelroom"/><br>
                        <input type="button" value="Update" name="update" onclick="updateHotel()"/>
                        <div class="result" id="hotelupdateresult"></div>
                        <div><a href="add_photo.php">Add Photos of the Hotel.</a></div>
						<input type="button" value="Update Facility" name="Update" onclick="updateFacility()"/>
                   
                    </form>
                </div>
            </div>
        </div>

        <div class="modal" id="hoteldeletemodal">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="close">&times;</span>
                    <h2>Delete A hotel</h2>
                </div>
                <div class="modal-body">
                    <form>
                        <select id="deletehotelselect" name="hname"></select><br>
                        <input type="button" value="Delete" onclick="deleteHotel()"/>
                        <div class="warning">Deleting A Hotel will also delete all bookings of that hotel!</div>
                        <div class="result" id="hoteldeleteresult"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="bookings" class="tabcontent">
        <h3>Manage Bookings</h3>
        <button class="opener" id="bookingupdate">Update Booking Status</button>

        <div class="modal" id="bookingupdatemodal">
            <div class="modal-content" style="margin-left:10%;width: 80%;overflow: auto">
                <div class="modal-header">
                    <span class="close">&times;</span>
                    <h2>Editing A booking</h2>
                </div>
                <div class="modal-body">
                    <form name="manage_booking_form">
                    <table id="update_booking_table" >
                        <tr>
                            <th>Username</th>
                            <th>Hotel Name</th>
                            <th>Check In Date</th>
                            <th>Check Out Date</th>
                            <th>Room Count</th>
                            <th>Transaction Id(Bkash)</th>
                            <th>Status</th>
                            <th>Change Status</th>
                        </tr>
                        <?php
                        require_once("get_data_methods.php");
                        $data=json_decode(getBookings());
                        for($i=0;$i<sizeof($data);$i++) {
                            ?>
                            <tr>
                                <td><?php echo $data[$i]->username;?></td>
                                <td><?php getHotelName($data[$i]->hotelid);?></td>
                                <td><?php echo $data[$i]->check_in_date;?></td>
                                <td><?php echo $data[$i]->check_out_date;?></td>
                                <td><?php echo $data[$i]->roomcount;?></td>
                                <td><?php echo $data[$i]->trxid;?></td>
                                <td id="<?php echo "booking_td_".$data[$i]->reservationid;?>"><?php echo $data[$i]->status;?></td>
                                <td><select class="booking_status_select">
                                        <option disabled selected value="empty">Select</option>
                                        <option value='<?php echo $data[$i]->reservationid;?>' >Accepted</option>
                                        <option value='<?php echo $data[$i]->reservationid;?>'>Rejected</option>
                                    </select></td>
                            </tr>
                            <?php
                        }

                        ?>
                    </table>
                        <input style="margin-top:2%; margin-left: 40%" type="button" value="Update Status" onclick="bookingUpdate()"/>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="users" class="tabcontent">
        <h3>Manage Users</h3>
        <button class="opener" id="useredit">Manage Users</button>
        <button class="opener" id="userdelete" <?php if($_SESSION['status']!='superadmin') echo 'hidden';?> >Manage Admin</button>
        <div class="modal" id="usereditmodal">
            <div class="modal-content" style="margin-left:10%;width: 80%;overflow: auto">
                <div class="modal-header">
                    <span class="close">&times;</span>
                    <h2>Manage Users</h2>
                </div>
                <div class="modal-body">
                    <form name="manage_user_form">
                        <table>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>User Name</th>
                                <th>Email</th>
                                <th>Total Bookings</th>
                                <th>Staus</th>
                                <th>Change Status</th>
                            </tr>
                            <?php
                            require_once("get_data_methods.php");
                            $data=json_decode(getUsers());
                            for($i=0;$i<sizeof($data);$i++) {
                                if($data[$i]->status=="Admin" || $data[$i]->status=="superadmin") continue;
                                ?>
                                <tr>
                                    <td><?php echo $data[$i]->firstname;?></td>
                                    <td><?php echo $data[$i]->lastname;?></td>
                                    <td><?php echo $data[$i]->username;?></td>
                                    <td><?php echo $data[$i]->email;?></td>
                                    <td><?php echo getBookingCount($data[$i]->username);?></td>
                                    <td id="<?php echo "user_td_".$data[$i]->username;?>"><?php echo $data[$i]->status;?></td>
                                    <td><select class="user_status_select">
                                            <option disabled selected value="empty">Select</option>
                                            <option value='<?php echo $data[$i]->username;?>' >Regular</option>
                                            <option value='<?php echo $data[$i]->username;?>'>VIP</option>
                                            <option value='<?php echo $data[$i]->username;?>'>Banned</option>
                                        </select></td>
                                </tr>
                                <?php
                            }?>
                        </table>
                        <input style="margin-top:2%; margin-left: 40%" type="button" value="Update Status" onclick="userUpdate()"/>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal" id="userdeletemodal">
            <div class="modal-content" style="margin-left:10%;width: 80%;overflow: auto">
                <div class="modal-header">
                    <span class="close">&times;</span>
                    <h2>Manage Admin</h2>
                </div>
                <div class="modal-body">
                    <form name="manage_user_form">
                        <table>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>User Name</th>
                                <th>Email</th>
                                <th>Total Bookings</th>
                                <th>Staus</th>
                                <th>Change Status</th>
                            </tr>
                            <?php
                            require_once("get_data_methods.php");
                            $data=json_decode(getUsers());
                            for($i=0;$i<sizeof($data);$i++) {
                                if($data[$i]->status=="superadmin") continue;
                                ?>
                                <tr>
                                    <td><?php echo $data[$i]->firstname;?></td>
                                    <td><?php echo $data[$i]->lastname;?></td>
                                    <td><?php echo $data[$i]->username;?></td>
                                    <td><?php echo $data[$i]->email;?></td>
                                    <td><?php echo getBookingCount($data[$i]->username);?></td>
                                    <td id="<?php echo "admin_td_".$data[$i]->username;?>"><?php echo $data[$i]->status;?></td>
                                    <td><select class= "admin_status_select">
                                            <option disabled selected value="empty">Select</option>
                                            <option value='<?php echo $data[$i]->username;?>' >Admin</option>
                                            <option value='<?php echo $data[$i]->username;?>'>Regular</option>
                                        </select></td>
                                </tr>
                                <?php
                            }?>
                        </table>
                        <input style="margin-top:2%; margin-left: 40%" type="button" value="Update Status" onclick="adminUpdate()"/>
                    </form>
                </div>
            </div>
        </div>

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
        <a style="margin-left: 35%;" href="#">Click Here to Update Profile Info!</a>
    </div>

</div>
<script>
	function updateFacility() {
		var hid=document.getElementById('updatehotelselect').value;
		console.log(hid);
		window.location="hotel_modify.php?hid="+hid;
	}
	
    function bookingUpdate() {
        var selects=document.getElementsByClassName('booking_status_select');
        for(i=0;i<selects.length;i++) {
            //console.log(selects[i].value);
            if(selects[i].value=="empty") continue;
            var text=selects[i].options[selects[i].selectedIndex].text;
            var id=selects[i].value;

            xmlHttp=new XMLHttpRequest();
            xmlHttp.onreadystatechange=function(){
                if(xmlHttp.readyState==4 && xmlHttp.status==200) {
                    console.log(xmlHttp.responseText);
                    var td="#booking_td_"+id;
                    console.log(td+ " "+$(td));
                    $(td).html(text);
                }
            };
            xmlHttp.open("GET","get_data.php?updatebooking="+id+"&status="+text,true);
            xmlHttp.send();
        }
    }

    function adminUpdate() {
        var selects=document.getElementsByClassName('admin_status_select');
        for(i=0;i<selects.length;i++) {
            //console.log(selects[i].value);
            if(selects[i].value=="empty") continue;
            var text=selects[i].options[selects[i].selectedIndex].text;
            var id=selects[i].value;

            xmlHttp=new XMLHttpRequest();
            xmlHttp.onreadystatechange=function(){
                if(xmlHttp.readyState==4 && xmlHttp.status==200) {
                    console.log(xmlHttp.responseText);
                    var td="#admin_td_"+id;
                    console.log($(td));
                    $(td).html(text);
                }
            };
            xmlHttp.open("GET","get_data.php?updateuser="+id+"&update="+text,true);
            xmlHttp.send();
        }
    }

    function userUpdate() {
        var selects=document.getElementsByClassName('user_status_select');
        for(i=0;i<selects.length;i++) {
            //console.log(selects[i].value);
            if(selects[i].value=="empty") continue;
            var text=selects[i].options[selects[i].selectedIndex].text;
            var id=selects[i].value;

            xmlHttp=new XMLHttpRequest();
            xmlHttp.onreadystatechange=function(){
                if(xmlHttp.readyState==4 && xmlHttp.status==200) {
                    console.log(xmlHttp.responseText);
                    var td="#user_td_"+id;
                    console.log($(td));
                    $(td).html(text);
                }
            };
            xmlHttp.open("GET","get_data.php?updateuser="+id+"&update="+text,true);
            xmlHttp.send();
        }
    }

    function generateHotelInfo(elm) {
        hotelid=elm.options[elm.selectedIndex].value;
        xmlHttp=new XMLHttpRequest();
        xmlHttp.onreadystatechange=function(){
            if(xmlHttp.readyState==4 && xmlHttp.status==200) {
                var ret = xmlHttp.responseText;
                console.log(ret);
                var data=JSON.parse(ret);
                $('#updatehotelname').val(data[0].hotelname);
                $("#updatehotelcost").val(data[0].cost);
                $("#updatehotelroom").val(data[0].roomcount);
            }
        };
        xmlHttp.open("GET","get_data.php?hotelid="+hotelid,true);
        xmlHttp.send();
    }

    function updateHotel() {
        var form=document.forms['hotelupdateform'];
        var error=document.getElementById('hotelupdateresult');
        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                //console.log(xhttp.responseText);
                //error.innerHTML=xhttp.responseText;
                if(xhttp.responseText=='true') {
                    error.innerHTML="Hotel Info Updated!";
                    error.style.visibility='block';
                    error.style.color='green';
                }
                else {
                    error.innerHTML="Unable to Update Hotel!";
                    error.style.visibility='block';
                    error.style.color='red';
                }
            }
        };
        var select=form['updatehotelselect'];
        var hotelid=select.options[select.selectedIndex].value;
        var hname=$('#updatehotelname').val();
        var cost=form['cost'].value;
        var roomcount=form['roomcount'].value;

        //console.log(hname);
        if(hname.length<1 || cost.length<1 || roomcount.length<1) {
            error.innerHTML="All fields required!";
            error.style.visibility='block';
            error.style.color='red';
        }

        xhttp.open("GET", "get_data.php?updatehotel="+hotelid+"&cost="+cost+"&hname="+hname+"&roomcount="+roomcount, true);
        xhttp.send();
    }

    function deleteHotel() {
        var hotelid=$('#deletehotelselect').val();
        var xhttp = new XMLHttpRequest();
        var error=document.getElementById('hoteldeleteresult');

        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log(xhttp.responseText);
                //error.innerHTML=xhttp.responseText;
                if(xhttp.responseText=='true') {
                    error.innerHTML="Hotel Deleted!";
                    error.style.visibility='block';
                    error.style.color='green';
                }
                else {
                    error.innerHTML="Unable to Delete Hotel!";
                    error.style.visibility='block';
                    error.style.color='red';
                }
            }
        };
        xhttp.open("GET", "get_data.php?deletehotel="+hotelid);
        xhttp.send();
    }

    function addHotel() {
        var error=document.getElementById('hoteladdresult');
        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                //console.log(xhttp.responseText);
                //error.innerHTML=xhttp.responseText;
                if(xhttp.responseText=="true") {
                    error.innerHTML="Hotel Added!";
                    error.style.visibility='block';
                    error.style.color='green';
                }
                else {
                    error.innerHTML="Unable to Add Hotel!";
                    error.style.visibility='block';
                    error.style.color='red';
                }
            }
        };
        var form=document.forms['hoteladdform'];
        var hname=form['hname'].value;
        var city=form['city'].value;
        var cost=form['cost'].value;
        var roomcount=form['roomcount'].value;

        if(hname.length<1 || cost.length<1 || roomcount.length<1) {
            error.innerHTML="All fields required!";
            error.style.visibility='block';
            error.style.color='red';
        }

        xhttp.open("GET", "get_data.php?addhotel=true&city="+city+"&cost="+cost+"&hname="+hname+"&roomcount="+roomcount, true);
        xhttp.send();
    }

    function userDetails(val) {
        var jsn='<?php
            echo getUsers();
        ?>';
        var details=document.getElementById('userdetail');
        details.innerHTML="";
        var data=JSON.parse(jsn);
        for(x in data) {
            if(data[x].username==val) break;
        }
        for(i in data[x]){
            details.innerHTML+=i+" : "+data[x][i]+"<br>";
        }
    }

    function addCity() {
        var error=document.getElementById('cityadderror');
        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log(xhttp.responseText);
                error.innerHTML=xhttp.responseText;
            }
        };
        var val=document.getElementById('addcitytext');
        xhttp.open("GET", "get_data.php?addcity="+val.value, true);
        xhttp.send();
    }

    function deleteCity() {
        var select=document.getElementById('deleteselect');
        var error=document.getElementById('deleteerror');
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log(xhttp.responseText);
                error.innerHTML=xhttp.responseText;
            }
        };
        xhttp.open("GET", "get_data.php?deletecity="+select.options[select.selectedIndex].value, true);
        xhttp.send();
    }

    function deleteUser() {
        var select=document.getElementById('deleteuserselect');
        var error=document.getElementById('deleteusererror');
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log(xhttp.responseText);
                error.innerHTML=xhttp.responseText;
            }
        };
        xhttp.open("GET", "get_data.php?deleteuser="+select.options[select.selectedIndex].value, true);
        xhttp.send();
    }

    function updateCity() {
        var select=document.getElementById('updateselect');
        var text=document.getElementById('updatetext');
        var error=document.getElementById('updateerror');
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log(xhttp.responseText);
                error.innerHTML=xhttp.responseText;
            }
        };
        var val=document.getElementById('addcitytext');
        xhttp.open("GET", "get_data.php?updatecity="+select.options[select.selectedIndex].value+"&update="+text.value, true);
        xhttp.send();
    }

    function updateUser() {
        var select=document.getElementById('edituserselect');
        var text=document.getElementById('userroleselect');
        var error=document.getElementById('usererror');
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log(xhttp.responseText);
                error.innerHTML=xhttp.responseText;
            }
        };
        var val=document.getElementById('addcitytext');
        xhttp.open("GET", "get_data.php?updateuser="+select.options[select.selectedIndex].value+"&update="+text.options[text.selectedIndex].value, true);
        xhttp.send();
    }
</script>
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

    var cityaddmodal = document.getElementById('cityaddmodal');
    var cityupdatemodal = document.getElementById('cityupdatemodal');
    var citydeletemodal = document.getElementById('citydeletemodal');
    var hoteladdmodal = document.getElementById('hoteladdmodal');
    var hotelupdatemodal = document.getElementById('hotelupdatemodal');
    var hoteldeletemodal = document.getElementById('hoteldeletemodal');
    var bookingupdatemodal = document.getElementById('bookingupdatemodal');
    var editusermodal=document.getElementById('usereditmodal');
    var deleteusermodal=document.getElementById('userdeletemodal');

    // Get the button that opens the modal
    var cityaddbtn = document.getElementById("cityadd");
    var cityupdatebtn = document.getElementById("cityupdate");
    var citydeletebtn = document.getElementById("citydelete");
    var hoteladdbtn = document.getElementById("hoteladd");
    var hotelupdatebtn = document.getElementById("hotelupdate");
    var hoteldeletebtn = document.getElementById("hoteldelete");
    var bookingupdatebtn = document.getElementById("bookingupdate");
    var edituserbtn=document.getElementById("useredit");
    var deleteuserbtn=document.getElementById("userdelete");

    // Get the <span> element that closes the modal
    var span0 = document.getElementsByClassName("close")[0];
    var span1 = document.getElementsByClassName("close")[1];
    var span2 = document.getElementsByClassName("close")[2];
    var span3 = document.getElementsByClassName("close")[3];
    var span4 = document.getElementsByClassName("close")[4];
    var span5 = document.getElementsByClassName("close")[5];
    //var span6 = document.getElementsByClassName("close")[6];
    var span7 = document.getElementsByClassName("close")[6];
    var span9=document.getElementsByClassName("close")[7];
    var span10=document.getElementsByClassName("close")[8];
    //var span9 = document.getElementsByClassName("close")[2];
    
    cityaddbtn.onclick=function () {
        cityaddmodal.style.display="block";
        document.getElementById('cityaddform').reset();
    };
    cityupdatebtn.onclick=function () {
        cityupdatemodal.style.display="block";
        document.getElementById('cityupdateform').reset();
        var select=$("#updateselect");
        SelectCity(select,"get_data.php?city=echo");
    };
    citydeletebtn.onclick=function () {
        citydeletemodal.style.display="block";
        document.getElementById('citydeleteform').reset();
        var select=$("#deleteselect");
        SelectCity(select,"get_data.php?city=echo");
    };

    hoteladdbtn.onclick=function () {
        hoteladdmodal.style.display="block";
        SelectCity($("#cityinfoselect"),"get_data.php?city=echo");
    };
    hotelupdatebtn.onclick=function () {
        hotelupdatemodal.style.display="block";
        SelectHotel($("#updatehotelselect"),"get_data.php?hotel=echo");
    };
    hoteldeletebtn.onclick=function () {
        hoteldeletemodal.style.display="block";
        SelectHotel($('#deletehotelselect'),"get_data.php?hotel=echo");
    };
    bookingupdatebtn.onclick=function () {
        bookingupdatemodal.style.display="block";
    };
    edituserbtn.onclick=function () {
        editusermodal.style.display='block';
    };
    deleteuserbtn.onclick=function () {
        deleteusermodal.style.display="block";
    };
    

    span0.onclick = function() {
        cityaddmodal.style.display = "none";
    };
    span1.onclick = function() {
        cityupdatemodal.style.display = "none";
    };
    span2.onclick = function() {
        citydeletemodal.style.display = "none";
    };
    span3.onclick = function() {
        hoteladdmodal.style.display = "none";
    };
    span4.onclick = function() {
        hotelupdatemodal.style.display = "none";
    };
    span5.onclick = function() {
        hoteldeletemodal.style.display = "none";
    };
    span7.onclick = function() {
        bookingupdatemodal.style.display = "none";
    };
    span9.onclick = function() {
        editusermodal.style.display = "none";
    };
    span10.onclick = function() {
        deleteusermodal.style.display = "none";
    };

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        //console.log(event.target);
        if (event.target == cityaddmodal) {
            cityaddmodal.style.display = "none";
        }
        if (event.target == cityupdatemodal) {
            cityupdatemodal.style.display = "none";
        }
        if (event.target == citydeletemodal) {
            citydeletemodal.style.display = "none";
        }

        if (event.target == hoteladdmodal) {
            hoteladdmodal.style.display = "none";
        }
        if (event.target == hotelupdatemodal) {
            hotelupdatemodal.style.display = "none";
        }
        if (event.target == hoteldeletemodal) {
            hoteldeletemodal.style.display = "none";
        }

        if (event.target == bookingupdatemodal) {
            bookingupdatemodal.style.display = "none";
        }
        if (event.target == editusermodal) {
            editusermodal.style.display = "none";
        }
        if (event.target == deleteusermodal) {
            deleteusermodal.style.display = "none";
        }

    }
</script>
<script>
    function AJAXData(page) {
        xmlHttp=new XMLHttpRequest();
        xmlHttp.onreadystatechange=function(){
            if(xmlHttp.readyState==4 && xmlHttp.status==200) {
                var ret = xmlHttp.responseText;
                console.log(ret);
                return ret;
            }
        };
        //var url=page;
        //console.log(url);
        xmlHttp.open("GET",page,true);
        xmlHttp.send();
    }
    function SelectCity(select, page) {
        xmlHttp=new XMLHttpRequest();
        xmlHttp.onreadystatechange=function(){
            if(xmlHttp.readyState==4 && xmlHttp.status==200) {
                var jsn = xmlHttp.responseText;
                console.log(jsn);
                var data=JSON.parse(jsn);
                console.log(data);
                select.empty();
                var options="";
                for(var i=0;i<data.length; i++) {
                    options += "<option value='"+data[i].cityid+"'>"+ data[i].cityname+"</option>";
                    //console.log(options);
                }
                select.append(options);
            }
        };
        xmlHttp.open("GET",page,true);
        xmlHttp.send();
    }
    function SelectHotel(select, page) {
        xmlHttp=new XMLHttpRequest();
        xmlHttp.onreadystatechange=function(){
            if(xmlHttp.readyState==4 && xmlHttp.status==200) {
                var jsn = xmlHttp.responseText;
                console.log(jsn);
                var data=JSON.parse(jsn);
                console.log(data);
                select.empty();
                var options="";
                for(var i=0;i<data.length; i++) {
                    options += "<option value='"+data[i].hotelid+"'>"+ data[i].hotelname+"</option>";
                    //console.log(options);
                }
                select.append(options);
            }
        };
        xmlHttp.open("GET",page,true);
        xmlHttp.send();
    }
</script>
</body>

</html>