<?php

    header("Content-Type: application/json");

    include_once "../../../../../src/DbConnection/DbConnection.php";
    include_once "../../../../../src/Section/Section.php";

    //Data Access Object
    $dao = new SectionDAO(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);

    if(isset($_GET["id"]) && isset($_GET["offset"])){
        $result = $dao->getStudentsGrades((int) $_GET["id"], (int) $_GET["offset"]);
        $json = [
            "status"=> true,
            "message"=> "Array obtenido.",
            "data"=> $result['studentsList'],
            "amountStudents"=> $result['amountStudents']
        ];
    }else{
        $json = [
            "message"=> "No se recibió el parámetro correcto",
            "status"=> false,                
        ];
    }

    $dao->closeConnection();
    
    echo json_encode($json);

?>