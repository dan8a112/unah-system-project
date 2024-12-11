<?php
/**
 * author: wamorales@unah.hn
 * version: 0.1.0
 * date: dic 2024
 * 
 * Servicio para obtener la carga académica de un coordinador en un periodo específico.
 */

header("Content-Type: application/json");

include_once "../../../../../src/DbConnection/DbConnection.php";
include_once "../../../../../src/CareerCoordinator/CareerCoordinator.php";

// Data Access Object
$dao = new CoordinatorDAO(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);

if (isset($_GET["coordinatorId"]) && isset($_GET["periodId"])) {
    $coordinatorId = (int)$_GET["coordinatorId"];
    $periodId = (int)$_GET["periodId"];
    $offset = isset($_GET["offset"]) ? (int)$_GET["offset"] : 0;

    $result = $dao->getAcademicLoad($coordinatorId, $periodId, $offset);

    if (!empty($result)) {
        $json = [
            "status" => true,
            "message" => "Carga académica obtenida.",
            "periods" => $result['periods'],
            "currentPeriod" => $result['currentPeriod'],
            "sections" => [
                "amountSections" => $result['sections']['amountSections'],
                "sectionList" => $result['sections']['sectionList']
            ],
            "career" => $result['career']
        ];
    } else {
        $json = [
            "status" => false,
            "message" => "No se pudo obtener la carga académica.",
        ];
    }
} else {
    $json = [
        "message" => "No se recibieron los parámetros correctos.",
        "status" => false,
    ];
}

$dao->closeConnection();

echo json_encode($json);

?>
