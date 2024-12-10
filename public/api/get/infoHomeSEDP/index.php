<?php

    /**
     * author: dorian.contreras@unah.hn
     * version: 0.1.0
     * date: nov 2024
     * 
     * Servicio obtener la informacion para el home de SEDP (trae los profesores)
     */

    header("Content-Type: application/json");


    session_start();

    include_once "../../../../src/DbConnection/DbConnection.php";
    include_once "../../../../src/Professor/Professor.php";

   
    $dao = new ProfessorDAO(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);
    $professors = $dao->getProfessors(0);
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