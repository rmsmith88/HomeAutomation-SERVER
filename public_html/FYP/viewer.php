<?php

//this is the view webpage which is loaded by the ipad and from any browser
//it builds the array of 24/7 light usage manually whereas the other graphs are built from a data source

include("../../USERdb.php"); #load ext php file containing password and username
$myconn=mysql_connect("co-project.lboro.ac.uk",$username,$password);
mysql_select_db("USER",$myconn);

if(!$myconn)
{
	die('Could not connect to db: ' . mysql_error());
}
	
//set device as light
$device = "Light";

	#create SQL string for 24/h
	$strSQL="SELECT status, kwh, Unix_Timestamp(datetime) AS datetime FROM fypuserpower ";
	$strSQL.="WHERE devicename = '$device' AND datetime > DATE_SUB(now(), INTERVAL 1 DAY) ORDER BY id";
	
	$result=mysql_query($strSQL, $myconn);

	$i = 0;
	//we get the info from db and put in arrays
    while($row=mysql_fetch_array($result)){
		$statusArray[$i]=$row["status"];
		$timeArray[$i] = $row["datetime"] * 1000; //JS needs unix*1000
		$kwh[$i] = $row["kwh"];
		$i++;		
    }
	
	//add now time data
	if(sizeof($timeArray) > 1){
		$lastStatus = end(array_values($statusArray)); //get last status
		$statusArray[$i]=$lastStatus;
		$timeArray[$i] = time() * 1000; //strtotime(
		$j = $i-1;
		$kwh[$i] = $kwh[$j];
	}
	
	//we can assume that zigbee and general standby house leakage is 1kw therefore we add this onto all values for the array this is done when the array is created
	
	
	
	
	//create html doc
	echo '	
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<script type="text/javascript" src="jquery.js"></script>
		<script type="text/javascript">


$(function () {

Highcharts.setOptions({
	global: {
			useUTC: false
	}
});

    var chart1;
	var chart2;
	var chart3;
	var chart4;
	var chart5;
	
      $(document).ready(function() {
        chart1 = new Highcharts.Chart({
            chart: {
                renderTo: "container",
				type: "area"
            },
            title: {
                text: "24 Hour Energy Usage"
            },
            subtitle: {
                text: "Based on data received from iPad app"
            },
            xAxis: {
                type: "datetime",
                //dateTimeLabelFormats: { // dont display the dummy year
					//day: "%hh:mm"
                    //month: "%e. %b",
                    //year: "%b"
					//minute: "%l:%M%p",
					//hour: "%b %e<br/>%l:%M%p",
					//day: "%b %e",
                //}
				
				
            },
            yAxis: {
                title: {
                    text: "Total kwh"
                },
                min: 0
            },
            tooltip: {
                formatter: function() {
                        return "<b>"+ this.series.name +"</b><br/>"+
                        Highcharts.dateFormat("%e. %b - %l:%M%p", this.x) +": "+ this.y +" kwh";
                }
            },
            
			plotOptions: {
			area: {fillOpacity: 0.5},
            series: {step: true}
        
			},
			
			
            series: [{
                name: "Light",
                data: [';
				
		$i=0;
	while($i < sizeof($timeArray)-1){
		$outArray[$i] = $statusArray[$i] * $kwh[$i];
		echo "[$timeArray[$i],$outArray[$i]],";
	
		$i++;
	}
		
		$outArray[$i] = $statusArray[$i] * $kwh[$i];
		echo "[$timeArray[$i],$outArray[$i]]";
        echo ']
            }, {
                name: "All",
                data: [';
    $i=0;
	while($i < sizeof($timeArray)-1){
		$outArray[$i] = ($statusArray[$i] * $kwh[$i]) + 1;
		echo "[$timeArray[$i],$outArray[$i]],";	
		$i++;
	}
		
		$outArray[$i] = ($statusArray[$i] * $kwh[$i]) + 1;
		echo "[$timeArray[$i],$outArray[$i]]";
		echo ']
		}]
            
		
        });
		
	chart2 = new Highcharts.Chart({
		chart: {
			renderTo: "container2",
			plotBorderWidth: null
			
		},
		title: {
			text: "Percentage of Total Energy Use"
		},
		tooltip: {
			formatter: function() {
				return "<b>"+ this.point.name +"</b>: "+ this.percentage +" %";
			}
		},
		plotOptions: {
			pie: {
				allowPointSelect: true,
				cursor: "pointer",
				dataLabels: {
					enabled: true,
					color: "#000000",
					connectorColor: "#000000",
					formatter: function() {
						return "<b>"+ this.point.name +"</b>: "+ this.percentage +" %";
					}
				}
			}
		},
		series: [{
			type: "pie",
			name: "Browser share",
			data: [
				
				["Radiator", 68.0],
				{
					name: "Light",
					y: 20.0,
					sliced: true,
					selected: true
				},
				["Other",    12.0]
			]
		}]
	});
	
		chart3 = new Highcharts.Chart({
		chart: {
			renderTo: "container3",
			type: "areaspline",
			events: {
                load: requestTemp
            }
		},
		title: {
			text: "Temperature for the past 5 days"
		},
		
		xAxis: {
                type: "datetime",
                
            },
		
		yAxis: {
			title: {
				text: "Temperature in deg C"
			},
			min: 0
		},
		tooltip: {
			formatter: function() {
				return ""+
				Highcharts.dateFormat("%e. %b - %l:%M%p", this.x) +": "+ this.y +" degrees";
			}
		},
		credits: {
			enabled: false
		},
		plotOptions: {
			areaspline: {
				fillOpacity: 0.5
			}
		},
		series: [{
			name: "Temperature",
			color: "#DB846D",
			data: []
		}]
	});

	chart4 = new Highcharts.Chart({
		chart: {
			renderTo: "container4",
			type: "areaspline",
			events: {
                load: requestHumid
            }
		},
		title: {
			text: "Humidity for the past 5 days"
		},
		xAxis: {
                type: "datetime",
                
            },
		
		yAxis: {
			title: {
				text: "Humidity %"
			},
			min: 0
		},
		tooltip: {
			formatter: function() {
				return ""+
				Highcharts.dateFormat("%e. %b - %l:%M%p", this.x) +": "+ this.y +"%";
			}
		},
		credits: {
			enabled: false
		},
		plotOptions: {
			areaspline: {
				fillOpacity: 0.5
			}
		},
		series: [{
			name: "Humidity",
			color: "#3D96AE",
			data: []
		}]
	});

	chart5 = new Highcharts.Chart({
		chart: {
			renderTo: "container5",
			type: "areaspline",
			events: {
                load: requestLight
            }
		},
		title: {
			text: "Light Levels for the past 5 days"
		},
		xAxis: {
                type: "datetime",
                
            },
		
		yAxis: {
			title: {
				text: "Light Levels / 6"
			},
			min: 0
		},
		tooltip: {
			formatter: function() {
				return ""+
				Highcharts.dateFormat("%e. %b - %l:%M%p", this.x) +": "+ this.y +"/6";
			}
		},
		credits: {
			enabled: false
		},
		plotOptions: {
			areaspline: {
				fillOpacity: 0.5
			}
		},
		series: [{
			name: "Light Levels",
			data: []
		}]
	});
	
    });
	

	
	function requestTemp() {
    $.ajax({
        url: "viewtemp.php",
        success: function(data) {
           chart3.series[0].setData(data,1);
		},
		cache: false
		});
	}
	function requestHumid() {
    $.ajax({
        url: "viewhumid.php",
        success: function(data) {
           chart4.series[0].setData(data,1);
		},
		cache: false
		});
	}
	function requestLight() {
    $.ajax({
        url: "viewlight.php",
        success: function(data) {
           chart5.series[0].setData(data,1);
		},
		cache: false
		});
	}
});


		</script>
	</head>
	<body  background="background.png">
<script src="http://code.highcharts.com/highcharts.js"></script>
<script type="text/javascript" src="graphstyle.js"></script>

<div id="container" style="min-width: 100%; height: 250px; margin: 0 auto"></div>
<div id="container2" style="width: 50%; height: 250px; margin: 0; float:right;"></div>
<div id="container3" style="width: 50%; height: 200px; margin: 0;"></div>
<div id="container4" style="width: 50%; height: 200px; margin: 0;"></div>
<div id="container5" style="width: 50%; height: 200px; margin: 0;"></div>
	</body>
</html>';


?>


