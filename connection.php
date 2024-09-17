<?php
session_start();
ob_start();

date_default_timezone_set("Europe/Istanbul");

$sql_type = "mysql";
$sql_servername = "mysql";
$sql_serverport = "3306";
$sql_user = "";
$sql_pass = "";
$sql_database = "cms";
$sql_charset = "utf8";

try {
    $conn = new PDO("$sql_type:host=$sql_servername;port=$sql_serverport;dbname=$sql_database;charset=$sql_charset", $sql_user, $sql_pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
    echo "Bağlantı hatası: " . $e->getMessage();
}

ini_set('user_agent','Mozilla/4.0 (compatible; MSIE 6.0)');
?>