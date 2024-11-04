<?php

    header("Content-Type: application/json");

    include_once "../../../../src/ProfessorType/ProfessorType.php";

    //Data Access Object
    $dao = new ProfessorTypeDAO("localhost", "is", "is", "ProyectoIS");
    $types = $dao->getProfessorTypes();

    $json = [
        "status"=> true,
        "message"=> "Tipos de profesores obtenidos",
        "result"=> $types,
    ];
    
    echo json_encode($json);

?>