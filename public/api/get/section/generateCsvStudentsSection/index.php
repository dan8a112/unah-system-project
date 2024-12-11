<?php

    /** author: dorian.contreras@unah.hn
     * version: 0.1.0
     * date: 10/12/24
     * servicio para crear csv con estudiantes matriculados en una seccion
     */

    header("Content-Type: application/json");

    include_once "../../../../../src/DbConnection/DbConnection.php";
    include_once "../../../../../src/Files/CSVExporter.php"; 

    $response = [];
    try {
        if(isset($_GET['id'])){
            $exporter = new CSVExporter(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);

            $sql = 'SELECT b.account, b.name, b.email
                FROM StudentSection a
                INNER JOIN Student b ON (a.studentAccount = b.account)
                WHERE a.section = ? AND a.waiting = false
                ORDER BY b.account ASC;'; 

            $filename = 'estudiantes_matriculados_' . time() . '.csv';

            $exporter->exportToCSV($sql, [$_GET['id']], $filename);

            $exporter->closeConnection();

            $response["status"] = true;
            $response["message"] = "CSV generado exitosamente y descargado.";
        }else{
            $response["status"] = false;
            $response["message"] = 'No se recibio paraetro correcto';
        }
    } catch (Exception $e) {
        $response["status"] = false;
        $response["message"] = "Error: " . $e->getMessage();
    }

    if (!$response["status"]) {
        echo json_encode($response);
    }
?>
