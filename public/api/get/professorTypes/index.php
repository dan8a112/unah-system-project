<?php

    header("Content-Type: application/json");

    include_once "../../../../src/GenericGet/GenericGet.php";

    //Data Access Object
    $dao = new GenericGetDAO("localhost", "is", "is", "ProyectoIS");
    $professorTypes = $dao->getProfessorTypes();

    $json = [
        "message"=> "Peticion realizada con exito",
        "status"=> true,
        "professorTypes" => $professorTypes,
            
    ];
    
    echo json_encode($json);

?>