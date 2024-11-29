<?php

    header("Content-Type: application/json");

    include_once "../../../../../src/DbConnection/DbConnection.php";
    include_once "../../../../../src/Application/Application.php";

    //Data Access Object
    $dao = new ApplicationDAO(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);

    if(isset($_GET["idProcess"]) && isset($_GET["offset"])){
        $result = $dao->getReviewers((int) $_GET["idProcess"], (int) $_GET["offset"]);
        $json = [
            "status"=> true,
            "message"=> "Array obtenido.",
            "data"=> $result
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