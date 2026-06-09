<?php

$servername = "sql302.ezyro.com";
$username = "ezyro_42123877";
$password = "4g2pb6wt";
$database_name = "ezyro_42123877_hatchai";

try{
    $conn = new PDO("mysql:host=$servername;dbname=$database_name",$username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();
}

?>