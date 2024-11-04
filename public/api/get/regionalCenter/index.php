<?php

    header("Content-Type: application/json");

    include_once "../../../../src/RegionalCenter/RegionalCenter.php";

    //Data Access Object
    $dao = new RegionalCenterDAO("localhost", "is", "is", "ProyectoIS");
    $centers = $dao->getCenters();

    $json = [
        "status"=> true,
        "message"=> "Centros regionales obtenidos",
        "result"=> $centers,
    ];
    
    echo json_encode($json);

?>