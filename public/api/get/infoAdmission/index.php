<?php

    header("Content-Type: application/json");

    include_once "../../../../src/DbConnection/DbConnection.php";
    include_once "../../../../src/GenericGet/GenericGet.php";

    //Data Access Object
    $dao = new GenericGetDAO(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);
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

    $dao->closeConnection();
    
    echo json_encode($json);

?>