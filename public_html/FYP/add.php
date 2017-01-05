<?php  
//this file is responsible for adding data from the iPad app
//to the database
include("../../USERdb.php"); #load ext php file containing password and username
$myconn=mysql_connect("co-project.lboro.ac.uk",$username,$password);
mysql_select_db("USER",$myconn);

if(!$myconn)
{
	die('Could not connect to db: ' . mysql_error());
}

	//retrieve posted variables from ipad
	$name = mysql_real_escape_string($_POST['name']);
	$status = mysql_real_escape_string($_POST['status']);
	$kwh = mysql_real_escape_string($_POST['kwh']);
	$sn = mysql_real_escape_string($_POST['sn']);
	$zn =mysql_real_escape_string($_POST['zn']);
	
	//insert these variables into the db with this sql command
	$strSQL="INSERT INTO fypuserpower VALUES (NULL, '$status', '$name', NOW(), '$kwh', '$sn', '$zn') ";

	//execute and close connection
	$result = mysql_query($strSQL, $myconn)
	or die(mysql_error());  
	mysql_close($myconn);

?>