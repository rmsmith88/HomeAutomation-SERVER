<?php

//pattern data was developed as I was looking into predicting energy use
//it is currenly unused but allows for me to generate dayofweek, minutes past 12, status which I was using to feed into weka.

include("../../USERdb.php"); #load ext php file containing password and username
$myconn=mysql_connect("co-project.lboro.ac.uk",$username,$password);
mysql_select_db("USER",$myconn);
header("Content-type: text/json");
if(!$myconn)
{
	die;
}


	#create SQL string for temp
	$strSQL="SELECT status, Unix_Timestamp(datetime) AS datetime , kwh, devicename FROM fypuserpower ";
	$strSQL.="WHERE datetime > DATE_SUB(now(), INTERVAL 7 DAY) ORDER BY id";
	

	//execute sql query
	$result=mysql_query($strSQL, $myconn);

	$i = 0;
	//we get the info from db and put in arrays
    while($row=mysql_fetch_array($result)){
		
		$unix = $row["datetime"];
		$arr = getdate($unix);
		echo $arr[wday] . "," . ($arr[hours]*60 + $arr[minutes]) . "," . (int)$row['status'] . "\n";
		$i++;		
    }



//echo json_encode($data);

?>
