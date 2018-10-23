<?php
 include_once('reservationdb.php');
  
 $rtitle=$_POST['rtitle'];
 $rfname=$_POST['rfname'];
 $rlname=$_POST['rlname'];
 $remail=$_POST['remail'];
 $rcontact=$_POST['rcontact'];
 $raddress=$_POST['raddress'];
 $rcountry=$_POST['rcountry'];
 $roomtype=$_POST['roomtype'];
 $noofroom=$_POST['noofroom'];
 $noofperson=$_POST['noofperson'];
 $special_request=$_POST['special_request'];
 $check_in_date=$_POST['check_in_date'];
 $check_out_date=$_POST['check_out_date'];
  
 $i=mysql_insert_id();
 if(mysql_query("INSERT INTO table1 VALUES('$i','$rtitle','$rfname','$rlname','$remail','$rcontact','$raddress','$rcountry',
                                           '$roomtype','$noofroom','$noofperson','$special_request','$check_in_date,'$check_out_date')"))
	{
	//echo '<script language="javascript">';
	echo 'alert("reservation confirmed!")';
	echo '</script>';
	}
else{
	echo '<script language="javascript">';
	echo 'alert("missing info or sth wrong")';
	echo '</script>';
	}
?>
