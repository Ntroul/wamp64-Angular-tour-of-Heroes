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

$action = $_GET["action"];

switch($action){
  
  case "list": //if ($action == 'list')
    $sql = "SELECT * FROM hero_group ORDER BY hero_group_id ASC";
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
  break;
  case "details": //if ($action == 'details')
    $id = $_GET["hero_group_id"];

    $sql= "SELECT * FROM hero_group WHERE hero_group_id = $id";
    $result = $conn->query($sql);
    if($result){
      $row = $result->fetch_assoc();
      print json_encode($row);
    }
  break;
  case "save": //if ($action == 'save')
    $_POST = json_decode(file_get_contents("php://input"), true);
    $name     = isset($_POST["hero_group_name"])? $_POST["hero_group_name"] : exit();
    $hero_group_id   = isset($_POST["hero_group_id"]) ? $_POST["hero_group_id"] : null;

    if ($hero_group_id){
      $sql="UPDATE hero_group SET name = '$name' WHERE hero_group_id = $hero_group_id";
      if ($conn->query($sql) === TRUE) {
          echo json_encode("Record updated successfully");
      } else {
          echo json_encode("Error updating record: " . $conn->error);
      }
    }else{
      $sql="INSERT INTO hero_group VALUES (null, '$name')";
      if ($conn->query($sql) === TRUE) {
          echo json_encode("Record inserted successfully");
      } else {
          echo json_encode("Error updating record: " . $conn->error);
      }
    }

  break;
    case "count": //if ($action == 'count')
      $sql = "SELECT COUNT(hero_group_name) AS heroCount FROM hero_group";
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
  break;
    
}

$conn->close();