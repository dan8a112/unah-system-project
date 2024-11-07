<?php

    header("Content-Type: application/json");

    include_once "../../../../src/DbConnection/DbConnection.php";
    include_once "../../../../src/GenericGet/GenericGet.php";

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