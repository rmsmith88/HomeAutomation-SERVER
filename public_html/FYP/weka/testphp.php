<?php

include("../../../cors2db.php"); #load ext php file containing password and username
$myconn=mysql_connect("co-project.lboro.ac.uk",$username,$password);
mysql_select_db("cors2",$myconn);
header("Content-type: text/json");
if(!$myconn)
{
	die;
}

	$returnValue = -1;
	system('java -classpath ./weka.jar weka.classifiers.functions.MultilayerPerceptron -t lights.arff -T lights.arff 2>&1', $returnValue);
	echo "Return Value: $returnValue<br/>\\n";
	

?>
