<?php

//readfile("./heroes.json");

$servername = "localhost";
$username = "root";
$password = "";
$dbname ="heroes";

$conn = new mysqli($servername, $username, $password,$dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql= "SELECT * FROM  hero_type ORDER BY hero_type_id ASC";  
$result = $conn->query($sql);

if ($result) {
  $RET = array();
  while($row = $result->fetch_assoc()) {
    $RET[] = $row;
  }
  print json_encode($RET);
} else {
  echo "0 results";
}
