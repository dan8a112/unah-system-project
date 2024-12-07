<?php

    //author: afcastillof@unah.hn
    //version: 0.1.0
    //date: 12/11/24

    //servicio para crear csv con estudiantes aprobados

header("Content-Type: application/json");

include_once "../../../../../src/DbConnection/DbConnection.php";
include_once "../../../../../src/Files/CSVExporter.php"; 

$response = [];

try {
    $exporter = new CSVExporter(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);

    $sql = "SELECT 
                a.id AS idApplication,
                CONCAT(b.firstName, ' ', b.secondName, ' ', b.firstLastName, ' ', b.secondLastName) AS name,
                b.personalEmail,
                CASE 
                    WHEN a.approvedFirstChoice = 1 THEN c.description
                    WHEN a.approvedSecondChoice = 1 THEN d.description
                END AS approvedCareer,
                CASE 
                    WHEN a.approvedFirstChoice = 1 THEN c.id
                    WHEN a.approvedSecondChoice = 1 THEN d.id
                END AS approvedCareerId
            FROM 
                Application a
            INNER JOIN 
                Applicant b ON a.idApplicant = b.id
            INNER JOIN 
                DegreeProgram c ON a.firstDegreeProgramChoice = c.id
            INNER JOIN 
                DegreeProgram d ON a.secondDegreeProgramChoice = d.id
            INNER JOIN 
                AcademicEvent e ON a.academicEvent = e.id
            WHERE 
                e.active = 1
                AND (a.approvedFirstChoice = 1 OR a.approvedSecondChoice = 1);

            "; 

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
