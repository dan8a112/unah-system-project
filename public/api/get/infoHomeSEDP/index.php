<?php

    header("Content-Type: application/json");

    include_once "../../../../src/Professor/Professor.php";

    //Data Access Object
    $dao = new ProfessorDAO("localhost", "is", "is", "ProyectoIS");
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
    
    echo json_encode($json);

?>