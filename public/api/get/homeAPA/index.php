<?php

header("Content-Type: application/json");

include_once "../../../../src/DbConnection/DbConnection.php";
include_once "../../../../src/GenericGet/GenericGet.php";

$dao = new GenericGetDAO(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);

$currentProcesses = $dao->getCurrentProcess();

$response = [
    "message" => "Petición realizada con éxito",
    "status" => true,
    "data" => [
        "currentProcesses" => $currentProcesses
    ]
    
];

$dao->closeConnection();

echo json_encode($response);

?>
