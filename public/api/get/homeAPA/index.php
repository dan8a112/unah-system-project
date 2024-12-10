<?php

    /**
     * author: dorian.contreras@unah.hn
     * version: 0.1.0
     * date: nov 2024
     * 
     * Servicio para obtener toda la informacion necesaria para el home de apa (trae procesos historicos y el actual)
     */

    header("Content-Type: application/json");

    include_once "../../../../src/DbConnection/DbConnection.php";
    include_once "../../../../src/GenericGet/GenericGet.php";

    $dao = new GenericGetDAO(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);

    $currentProcesses = $dao->getCurrentProcess();
    $processSummary = $dao->getSummaryProcess();
    $allProcess = $dao->getAllProcessInYears();



    $response = [
        "message" => "Petición realizada con éxito",
        "status" => true,
        "data" => [
            "currentProces" => $currentProcesses,
            "processSummary" => $processSummary,
            "previousProcesses" => $allProcess
        ]    
        
    ];

    $dao->closeConnection();

    echo json_encode($response);

?>
