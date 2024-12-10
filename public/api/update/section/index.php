<?php

    header("Content-Type: application/json");

    include_once "../../../../src/DbConnection/DbConnection.php";
    include_once "../../../../src/Section/Section.php";

    $dao = null;

    if(
        isset($_POST['id']) &&
        isset($_POST["class"]) &&
        isset($_POST['days'])&&
        isset($_POST['startHour'])&&
        isset($_POST['finishHour'])&&
        isset($_POST['places'])&&
        isset($_POST['professor'])&&
        isset($_POST['classroom'])
    ){
        $id = $_POST['id'];
        $class = $_POST["class"];
        $days = $_POST['days'] ?? '';
        $startHour = $_POST['startHour'] ?? '';
        $finishHour = $_POST['finishHour'] ?? '';
        $places = $_POST['places'];
        $professor = $_POST['professor'];
        $classroom = $_POST['classroom'];

        $dao = new SectionDAO(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);
        $json = $dao->updateSection($id, $class, $professor, $days, $startHour, $finishHour, $classroom, $places);
        
    } else {
        $json = [
            "status" => false,
            "message" => "No se recibió el parámetro correcto"
        ];
    }
   
    if ($dao) {
        $dao->closeConnection();
    }
    
    echo json_encode($json);

?>