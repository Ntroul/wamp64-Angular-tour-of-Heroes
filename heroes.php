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
    $sql = "SELECT * FROM heroes 
        LEFT JOIN hero_type ON heroes.hero_type_id = hero_type.hero_type_id 
        LEFT JOIN hero_group ON heroes.hero_group_id = hero_group.hero_group_id
        ORDER BY id ASC";
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
    $id = $_GET["id"];

    $sql= "SELECT * FROM heroes 
      LEFT JOIN hero_type ON heroes.hero_type_id = hero_type.hero_type_id 
      LEFT JOIN hero_group ON heroes.hero_group_id = hero_group.hero_group_id
      WHERE id = $id";
    $result = $conn->query($sql);
    if($result){
      $row = $result->fetch_assoc();
      print json_encode($row);
    }
  break;
  case "save":
    $_POST = json_decode(file_get_contents("php://input"), true);
    $id       = isset($_POST["id"]) ? $_POST["id"] : null;
    $name     = isset($_POST["name"])? $_POST["name"] : exit();
    $hero_type_id   = isset($_POST["hero_type_id"]) ? $_POST["hero_type_id"] : null;
    
    $hero   = isset($_POST["hero"]) ? $_POST["hero"] : null;
    $featured = $hero['featured'] ? 1 : 0;
    /*
    if($hero['featured']){
      $featured = 1;
    }else{
      $featured = 0;
    }
    */

    if ($id){
      $sql="UPDATE 
                  heroes 
              SET 
                name='$name', 
                hero_type_id = '$hero_type_id', 
                hero_group_id = ".$hero['hero_group_id'].",
                featured =  ". $featured ."
              WHERE 
                id = $id";
      if ($conn->query($sql) === TRUE) {
          echo json_encode("Record updated successfully");
      } else {
          echo json_encode("Error updating record: " . $conn->error);
      }
    }else{
      $sql="INSERT INTO heroes VALUES (null, '$name',$hero_type_id)";
      if ($conn->query($sql) === TRUE) {
          echo json_encode("Record inserted successfully");
      } else {
          echo json_encode("Error updating record: " . $conn->error);
      }
    }
    break;
    case "count":
      $sql="SELECT COUNT(*) AS heroCount  FROM heroes";
      $result = $conn->query($sql);
      if($result){
        $row = $result->fetch_assoc();
        print json_encode($row);
      }

    break;
    $conn->close();
}

$conn->close();