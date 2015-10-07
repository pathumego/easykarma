<?php

phpinfo();
/*
require_once ("config.php");
$db = config::dbconfig();   
$fileTemp = "C:\\ss.txt.csv";
$fp = fopen($fileTemp,'r');
$datas = array();
while (($data = fgetcsv($fp)) !== FALSE)
{
$col1 = trim($data[0]);
$col2 = trim($data[1]);
$col3 = trim($data[2]);
$col4 = trim($data[3]);

echo $sql = "INSERT INTO tbl_language(LangTag, English, Sinhala, Tamil) VALUES ('$col1', '$col2', '$col3', '$col4')";
// Insert Data
mysql_query ($sql)
or die (mysql_error());

}
*/


?>