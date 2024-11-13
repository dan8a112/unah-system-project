<?php
header("Content-Type: application/json");

include_once "../../../../src/DbConnection/DbConnection.php";
include_once "../../../../src/Files/CSVExporter.php"; 

$response = [];

try {
    $exporter = new CSVExporter(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);

    $sql = "SELECT * FROM applicant"; 

    $filename = 'estudiantes_aprobados_' . time() . '.csv';

    header('Content-Type: text/csv');
    header("Content-Disposition: attachment; filename=\"$filename\"");

    $exporter->exportToCSV($sql);

    $exporter->closeConnection();

    $response["status"] = true;
    $response["message"] = "CSV generado exitosamente y descargado.";
} catch (Exception $e) {
    $response["status"] = false;
    $response["message"] = "Error: " . $e->getMessage();
}

if (!$response["status"]) {
    echo json_encode($response);
}
?>
