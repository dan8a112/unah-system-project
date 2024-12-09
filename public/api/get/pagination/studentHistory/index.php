<?php

header("Content-Type: application/json");

include_once "../../../../../src/DbConnection/DbConnection.php";
include_once "../../../../../src/Student/StudentHistory.php";

// Data Access Object
$dao = new StudentDAO(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);

if (isset($_GET["id"]) && isset($_GET["offset"])) {
    $result = $dao->getStudentAcademicHistory((string)$_GET["id"], (int)$_GET["offset"]);
    $json = [
        "status" => true,
        "message" => "Historial académico obtenido.",
        "studentInfo" => $result['studentInfo'], 
        "classes" => [
            "amountClasses" => $result['amountClasses'], 
            "classList" => $result['classList'], 
        ]
    ];
} else {
    $json = [
        "message" => "No se recibió el parámetro correcto.",
        "status" => false,
    ];
}

$dao->closeConnection();

echo json_encode($json);

?>
