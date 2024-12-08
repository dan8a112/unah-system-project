<?php

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
