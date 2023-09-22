<?php
$servername = "localhost";
$dbusername = "root";
$dbpawword = "";
$dbname = "jarvis";

$conn = mysqli_connect($servername, $dbusername, $dbpawword, $dbname);

if (!$conn) {
    die("connection failed" . mysqli_connect_error());
}