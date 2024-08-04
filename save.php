<?php
$_POST = json_decode(file_get_contents("php://input"), true);
$id       = isset($_POST["id"]) ? $_POST["id"] : null;
$name     = isset($_POST["name"])? $_POST["name"] : exit();
$hero_type_id   = isset($_POST["hero_type_id"]) ? $_POST["hero_type_id"] : null;

$servername = "localhost";
$username = "root";
$password = "";
$dbname ="heroes";

$conn = new mysqli($servername, $username, $password,$dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($id){
    $sql="UPDATE heroes SET name = '$name',hero_type_id = '$hero_type_id' WHERE id = $id";
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
  
$conn->close();

/*
$data     = file_get_contents("./heroes.json");
$data_arr = json_decode($data,true);
 foreach($data_arr as &$n){
    if($n['id'] == $id ){
        $n['name'] = $name;
    }
}

for ($idx=0;$idx<count($data_arr);$idx++ ){
    if($n[$idx]['id'] == $id ){
        $n[$idx]['name'] = $name;
    }
}

$data = json_encode($data_arr);
file_put_contents("./heroes.json",$data);
*/