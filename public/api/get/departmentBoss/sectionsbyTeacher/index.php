<?php
/**
 * author: wamorales@unah.hn
 * version: 0.1.0
 * date: dic 2024
 *
 * Servicio para obtener las secciones asignadas a un docente.
 */

header("Content-Type: application/json");

include_once "../../../../../src/DbConnection/DbConnection.php";
include_once "../../../../../src/DepartmentBoss/DepartmentBoss.php";

// Data Access Object
$dao = new DepartmentBossDAO(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);

if (isset($_GET["professorId"])) {
    $professorId = (int)$_GET["professorId"];

    $result = $dao->getProfessorSections($professorId);

    if ($result["status"]) {
        $json = [
            "status" => true,
            "message" => "Secciones obtenidas.",
            "data" => [
                "professorName" => $result['data']['professorName'],
                "sections" => $result['data']['sections']
            ]
        ];
    } else {
        $json = [
            "status" => false,
            "message" => "No se pudo obtener la información del profesor."
        ];
    }
} else {
    $json = [
        "message" => "No se recibió el parámetro 'professorId'.",
        "status" => false,
    ];
}

$dao->closeConnection();

echo json_encode($json);

?>
