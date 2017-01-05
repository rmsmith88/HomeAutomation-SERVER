<?php
//this file just creates a JSON encoded array of data and is called
//by viewer.php

include("../../USERdb.php"); #load ext php file containing password and username
$myconn=mysql_connect("co-project.lboro.ac.uk",$username,$password);
mysql_select_db("USER",$myconn);
header("Content-type: text/json");
if(!$myconn)
{
	die;
}

$device = "Thermometer";

	#create SQL string for temp
	$strSQL="SELECT sensorname, sensorvalue, Unix_Timestamp(datetime) AS datetime FROM fypsensor ";
	$strSQL.="WHERE sensorname = '$device' AND datetime > DATE_SUB(now(), INTERVAL 5 DAY) ORDER BY id";
	


	$result=mysql_query($strSQL, $myconn);

	$i = 0;
	//we get the info from db and put in arrays
    while($row=mysql_fetch_array($result)){
		
		$data[$i] = array($row["datetime"] * 1000, 
						(int)$row["sensorvalue"]);
		$i++;		
    }


echo json_encode($data);

?>
