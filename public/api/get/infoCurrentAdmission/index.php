<?php

    header("Content-Type: application/json");

    include_once "../../../../src/DbConnection/DbConnection.php";
    include_once "../../../../src/Application/Application.php";

    //Data Access Object
    $dao = new ApplicationDAO(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);
    $test = $dao->getInfoCurrentAdmission();

    $json = [
        "message"=> "Peticion realizada con exito",
        "status"=> true,
        "data" => $test
            
    ];

    $dao->closeConnection();
    
    echo json_encode($json);

?>