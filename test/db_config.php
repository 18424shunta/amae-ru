<?php
 $connectstr_dbhost = '';
 $connectstr_dbname = '';
 $connectstr_dbusername = '';
 $connectstr_dbpassword = '';
 
 foreach ($_SERVER as $key => $value) {
 if (strpos($key, "MYSQLCONNSTR_") !== 0) {
 continue;
 }
 
 $connectstr_dbhost = preg_replace("/^.*Data Source=(.+?);.*$/", "\\1", $value);
 $connectstr_dbname = preg_replace("/^.*Database=(.+?);.*$/", "\\1", $value);
 $connectstr_dbusername = preg_replace("/^.*User Id=(.+?);.*$/", "\\1", $value);
 $connectstr_dbpassword = preg_replace("/^.*Password=(.+?)$/", "\\1", $value);
 }
 
 define('DB_DATABASE', 'LAA1293503-2021amaeru');
 define('DB_USERNAME', 'LAA1293503');
 define('DB_PASSWORD', 'Karasugekitai999');
 define('PDO_DSN', 'mysql:host='.'mysql153.phy.lolipop.lan'.';dbname='. DB_DATABASE . ';charset=utf8;');
?>