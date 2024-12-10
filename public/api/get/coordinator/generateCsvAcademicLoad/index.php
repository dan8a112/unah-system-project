<?php

    /**author: dorian.contreras@unah.hn
     * version: 0.1.0
     * date: 10/12/24
     * 
     * servicio para crear csv con estudiantes matriculados en una seccion
     */

    header("Content-Type: application/json");

    include_once "../../../../../src/DbConnection/DbConnection.php";
    include_once "../../../../../src/Files/CSVExporter.php"; 

    $response = [];
    try {
        if(isset($_GET['idPeriod']) && isset($_GET['idCoordinator'])  ){
            $exporter = new CSVExporter(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);

            $sql = 'SELECT  a.subject, b.description as subjectName,LPAD(CAST(a.section AS CHAR), 4, "0") as code, c.description as days, b.uv, CONCAT(a.startHour, ":00") as startHour, 
                    CONCAT(a.finishHour, ":00") as finishHour, CONCAT(d.description, " ", e.description ) as classroom, CONCAT(f.names, " ", f.lastNames) as professorName,
                    a.maximumCapacity
                FROM Section a
                INNER JOIN Subject b ON (a.subject = b.id)
                INNER JOIN Days c ON (a.days = c.id)
                INNER JOIN Classroom d ON (a.classroom = d.id)
                INNER JOIN Building e ON (d.building = e.id)
                INNER JOIN Employee f ON (a.professor = f.id)
                INNER JOIN Professor g ON (g.department = b.department)
                WHERE g.id = ? AND a.academicEvent=?
                ORDER BY b.id ASC;'; 

            $filename = 'carga_academica_' . time() . '.csv';

            $exporter->exportToCSV($sql, [$_GET['idCoordinator'], $_GET['idPeriod']], $filename);

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
