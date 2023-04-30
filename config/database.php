<?php
header('Content-Type: application/json; charset=utf-8');
$server = "localhost";
$dbusername = "root";
$dbpassword = "";
$database = "android_db";


try {

    //  $dns = "mysql:host=" . $server . "$;dbname=". $database;
    $dns = "mysql:host=$server;dbname=$database";
    $pdo = new PDO($dns, $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
}

?>