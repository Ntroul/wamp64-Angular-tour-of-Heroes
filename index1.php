<?php

$id = $_GET["id"];


$servername = "localhost";
$username = "root";
$password = "";
$dbname ="heroes";

$conn = new mysqli($servername, $username, $password,$dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql= "SELECT * FROM heroes 
LEFT JOIN hero_type ON hero_type.hero_type_id = heroes.hero_type_id
WHERE id = $id";
$result = $conn->query($sql);
if($result){
    $row = $result->fetch_assoc();
    print json_encode($row);
}

/*
$data     = file_get_contents("./heroes.json");
$data_arr = json_decode($data,true);
foreach($data_arr as $x){

    if ($x['id'] == $id ){
        print json_encode($x);
        exit();
    }
}

    echo "not found";

*/
