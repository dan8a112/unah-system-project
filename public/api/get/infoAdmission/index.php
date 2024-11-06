<?php

    header("Content-Type: application/json");

    include_once "../../../../src/GenericGet/GenericGet.php";

    //Data Access Object
    $dao = new GenericGetDAO("localhost", "is", "is", "ProyectoIS");
    $degrees = $dao->getDegrees();
    $centers = $dao->getDegreesInCenter();

    $json = [
        "message"=> "Peticion realizada con exito",
        "status"=> true,
        "data"=> [
            "careers" => $degrees,
            "regionalCenters" => $centers,
        ]
            
    ];
    
    echo json_encode($json);

?>