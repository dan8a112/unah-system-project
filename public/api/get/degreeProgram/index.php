<?php

    header("Content-Type: application/json");

    include_once "../../../../src/DegreeProgram/DegreeProgram.php";

    //Data Access Object
    $dao = new DegreeProgramDAO("localhost", "is", "is", "ProyectoIS");
    $degrees = $dao->getDegrees();

    $json = [
        "status"=> true,
        "message"=> "Carreras obtenidas",
        "result"=> $degrees,
    ];
    
    echo json_encode($json);

?>