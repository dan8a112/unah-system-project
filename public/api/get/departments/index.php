<?php

    header("Content-Type: application/json");

    include_once "../../../../src/GenericGet/GenericGet.php";

    //Data Access Object
    $dao = new GenericGetDAO("localhost", "is", "is", "ProyectoIS");
    $departments = $dao->getDepartments();

    $json = [
        "message"=> "Peticion realizada con exito",
        "status"=> true,
        "departments" => $departments
            
    ];
    
    echo json_encode($json);

?>