<?php
//readfile("./heroes.json");
$hero_type_id = $_GET["hero_type_id"];

$servername = "localhost";
$username = "root";
$password = "";
$dbname ="heroes";

$conn = new mysqli($servername, $username, $password,$dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql= "SELECT * FROM hero_type WHERE hero_type_id = $hero_type_id";
$result = $conn->query($sql);

if($result){
    $row = $result->fetch_assoc();
    print json_encode($row);
}