# HomeAutomation-SERVER
A home automation server graphing library to provide collection and display of energy usage. It works in conjunction with my ZigBee home automation iOS app (see my other [HomeAutomation-iOS](https://github.com/rmsmith88/HomeAutomation-iOS) repo). Uses JQuery and Highcharts

## To Install
 1. Ensure that you have a MySQL database setup and a working PHP Server
 2. Execute the `createtable.sql` on the database which will create the table
 3. Ensure that the `USERdb.php` file is in the correct directory above `public_html` and contains the correct username and password
 4. Merge the contents of `public_html` into the existing `public_html` folder on the server
 5. Access dynamic charts by loading `<YOUR WEBURL>/FYP/viewer.php`

Some examples of this can be found below:
![alt tag](https://raw.githubusercontent.com/rmsmith88/HomeAutomation-SERVER/master/img/DSC02122.JPG)
![alt tag](https://raw.githubusercontent.com/rmsmith88/HomeAutomation-SERVER/master/img/IMG_0156.PNG)
![alt tag](https://raw.githubusercontent.com/rmsmith88/HomeAutomation-SERVER/master/img/IMG_0190.PNG)
