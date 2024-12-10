<?php

    /**
     * author: dorian.contreras@unah.hn
     * version: 0.1.0
     * date: nov 2024
     * 
     * Servicio para obtener todos los tipos de profesores
     */
    header("Content-Type: application/json");

    include_once "../../../../../src/DbConnection/DbConnection.php";
    include_once "../../../../../src/GenericGet/GenericGet.php";

    //Data Access Object
    $dao = new GenericGetDAO(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);
    $professorTypes = $dao->getProfessorTypes();

    $json = [
        "message"=> "Peticion realizada con exito",
        "status"=> true,
        "professorTypes" => $professorTypes,
            
    ];
    
    $dao->closeConnection();
    
    echo json_encode($json);

?>