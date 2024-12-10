<?php

header("Content-Type: application/json");

include_once "../../../../../src/DbConnection/DbConnection.php";
include_once "../../../../../src/GenericGet/GenericGet.php";

if(isset($_GET['idProfessor'])){
    $dao = new GenericGetDAO(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);

    $allProcess = $dao->getAllPeriodsInYears($_GET['idProfessor']);
    $response = [
        "message" => "Petición realizada con éxito",
        "status" => true,
        "data" => [
            "previousProcesses" => $allProcess
        ]    
        
    ];

}else{
    $response = [
        "message" => "Parametro incorrecto",
        "status" => false      
    ];
}



$dao->closeConnection();

echo json_encode($response);

?>
