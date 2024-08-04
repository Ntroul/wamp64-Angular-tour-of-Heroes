<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname ="heroes";

$conn = new mysqli($servername, $username, $password,$dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql="SELECT COUNT(hero_type_name) AS heroTypeCount FROM hero_type";
$result = $conn->query($sql);
if($result){
  $row = $result->fetch_assoc();
  print json_encode($row);
}

$conn->close();