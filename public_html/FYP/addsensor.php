<?php  

include("../../USERdb.php"); #load ext php file containing password and username
$myconn=mysql_connect("co-project.lboro.ac.uk",$username,$password);
mysql_select_db("USER",$myconn);

if(!$myconn)
{
	die('Could not connect to db: ' . mysql_error());
}
	//escape stops SQL injection, gets variables from iPad
	$sensorname = mysql_real_escape_string($_POST['name']);
	$sensorvalue = mysql_real_escape_string($_POST['sensorvalue']);
	$sn = mysql_real_escape_string($_POST['sn']);
	$zn =mysql_real_escape_string($_POST['zn']);
	
	//SQL statement built from variables
	$strSQL="INSERT INTO fypsensor VALUES (NULL, '$sensorname', '$sensorvalue', NOW(), '$sn', '$zn') ";

	//executes sql statment then closes connection
	$result = mysql_query($strSQL, $myconn)
	or die(mysql_error());  
	mysql_close($myconn);

?>