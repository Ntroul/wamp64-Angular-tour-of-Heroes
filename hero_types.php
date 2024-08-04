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

$action = isset($_GET["action"]) ? $_GET["action"] : null;
if (!$action){
  $action = isset($_POST["action"]) ? $_POST["action"] : null;
}
if (!$action){
  json_encode('Invalid action');
  exit();
}

switch($action){
  
  case "list": //if ($action == 'list')
    $sql = "SELECT * FROM hero_type ORDER BY hero_type_id ASC";
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
    $id = $_GET["hero_type_id"];

    $sql= "SELECT * FROM hero_type WHERE hero_type_id = $id";
    $result = $conn->query($sql);
    if($result){
      $row = $result->fetch_assoc();
      print json_encode($row);
    }
  break;
  case "save": //if ($action == 'save')
    $_POST = json_decode(file_get_contents("php://input"), true);
    $id       = isset($_POST["hero_type_id"]) ? $_POST["hero_type_id"] : null;
    $name     = isset($_POST["hero_type_name"])? $_POST["hero_type_name"] : exit();

    if ($id){
      $sql="UPDATE hero_type SET hero_type_name = '$name' WHERE hero_type_id = $id";
      if ($conn->query($sql) === TRUE) {
          echo json_encode("Record updated successfully");
      } else {
          echo json_encode("Error updating record: " . $conn->error);
      }
    }else{
      $sql="INSERT INTO hero_type VALUES (null,'$name')";
      if ($conn->query($sql) === TRUE) {
          echo json_encode("Record inserted successfully");
      } else {
          echo json_encode("Error updating record: " . $conn->error);
      }
    }
  break;
  case "count": //if ($action == 'count')
    $sql="SELECT COUNT(hero_type_name) AS HeroTypeCount FROM hero_type";
    $result = $conn->query($sql);
    if($result){
      $row = $result->fetch_assoc();
      print json_encode($row);
    }
  break;
}

$conn->close();