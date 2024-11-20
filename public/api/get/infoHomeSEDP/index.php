<?php

    header("Content-Type: application/json");


    session_start();

    include_once "../../../../src/DbConnection/DbConnection.php";
    include_once "../../../../src/Professor/Professor.php";

   
    $dao = new ProfessorDAO(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);
    $professors = $dao->getProfessors();
    $amount = $dao->getAmountProfessors();

    $json = [
        "message"=> "Peticion realizada con exito",
        "status"=> true,
        "data"=> [
            "professorsAmount"=> $amount,
            "professors" => $professors
        ]
            
    ];

    $dao->closeConnection();

    echo json_encode($json);

?>