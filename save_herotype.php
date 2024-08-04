<?php

$_POST = json_decode(file_get_contents("php://input"), true);
$hero_type_id       = isset($_POST["hero_type_id"]) ? $_POST["hero_type_id"] : null;
$hero_type_name    = isset($_POST["hero_type_name"])? $_POST["hero_type_name"] : exit();

$servername = "localhost";
$username = "root";
$password = "";
$dbname ="heroes";

$conn = new mysqli($servername, $username, $password,$dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($id){
    $sql="UPDATE hero_type SET hero_type_name = '$hero_type_name' WHERE hero_type_id = $hero_type_id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode("Record updated successfully");
    } else {
        echo json_encode("Error updating record: " . $conn->error);
    }
}else{
    $sql="INSERT INTO hero_type VALUES (null, '$hero_type_name')";
    if ($conn->query($sql) === TRUE) {
        echo json_encode("Record inserted successfully");
    } else {
        echo json_encode("Error updating record: " . $conn->error);
    }
}
  
$conn->close();