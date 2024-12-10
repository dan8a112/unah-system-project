<?php

header("Content-Type: application/json");

include_once "../../../../../src/DbConnection/DbConnection.php";
include_once "../../../../../src/Student/StudentHistory.php";

// Data Access Object
$dao = new StudentDAO(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);

if (isset($_GET["id"]) && isset($_GET["offset"])) {
    $result = $dao->getStudentAcademicHistory((string)$_GET["id"], (int)$_GET["offset"]);

    
    if ($result['status'] === true) {
        $json = [
            "status" => true,
            "message" => "Historial académico obtenido.",
            "studentInfo" => $result['data']['studentInfo'],
            "amountClasses" => $result['data']['classes']['amountClasses'],
            "data" => $result['data']['classes']['classList']
        ];
    } else {
        $json = [
            "status" => false,
            "message" => $result['message'],  
        ];
    }
} else {
    $json = [
        "message" => "No se recibió el parámetro correcto.",
        "status" => false,
    ];
}

$dao->closeConnection();

echo json_encode($json);

 

?>
