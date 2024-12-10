<?php
    /**
     * author: dorian.contreras@unah.hn
     * version: 0.1.0
     * date: nov 2024
     * 
     * Servicio hacer insert de una inscripcion en el proceso de admision
     */

    header("Content-Type: application/json");

    include_once "../../../../src/DbConnection/DbConnection.php";
    include_once "../../../../src/Application/Application.php";

    $dao = null;

    if (
        isset($_POST["idFirstDegreeProgramChoice"]) &&
        isset($_POST["idSecondDegreeProgramChoice"]) &&
        isset($_POST["idRegionalCenterChoice"]) &&
        isset($_POST["names"]) &&
        isset($_POST["lastNames"]) &&
        isset($_POST["personalEmail"]) &&
        isset($_POST["telephoneNumber"]) &&
        isset($_POST["identityNumber"]) &&
        isset($_FILES["pathSchoolCertificate"])
    ) {
        $identityNumber = $_POST["identityNumber"];
        $names = $_POST['names'] ?? '';
        $lastNames = $_POST['lastNames'] ?? '';
        $pathSchoolCertificate = $_FILES['pathSchoolCertificate']['tmp_name'] ?? '';  // Obtener ruta temporal del archivo
        $certificateSize = $_FILES['pathSchoolCertificate']['size'] ?? 0;  // Tamaño del archivo en bytes
        $telephoneNumber = $_POST['telephoneNumber'] ?? '';
        $personalEmail = $_POST['personalEmail'] ?? '';
        $firstDegreeProgramChoice = $_POST["idFirstDegreeProgramChoice"];
        $secondDegreeProgramChoice = $_POST["idSecondDegreeProgramChoice"];
        $regionalCenterChoice = $_POST["idRegionalCenterChoice"];

        // Tamaño mínimo en bytes (por ejemplo, 100 KB = 100 * 1024 bytes)
        $minSize = 100 * 1024;
        if (!empty($pathSchoolCertificate) && file_exists($pathSchoolCertificate)) {
            if ($certificateSize >= $minSize) {
                $fileData = file_get_contents($pathSchoolCertificate);

                // Escapar los datos binarios para seguridad
                //$fileData = $conn->real_escape_string($fileData);*/

                $dao = new ApplicationDAO(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);
                $result = $dao->setApplication($identityNumber, $names, $lastNames, $fileData, $telephoneNumber, $personalEmail,
                    $firstDegreeProgramChoice, $secondDegreeProgramChoice, $regionalCenterChoice);

                $json = [
                    "message" => $result["message"],
                    "status" => $result["status"],
                    "exams" => $result["exams"],
                    "code"=> $result['code']
                ];
            } else {
                $json = [
                    "status" => false,
                    "message" => "El archivo del certificado no cumple con el tamaño mínimo de " . ($minSize / 1024) . " KB.",
                    "code"=> 5
                ];
            }
        } else {
            $json = [
                "status" => false,
                "message" => "No se pudo leer el archivo del certificado.",
                "code" => 6
            ];
        }
    } else {
        $json = [
            "status" => false,
            "message" => "No se recibió el parámetro correcto",
            "code"=> 7,
        ];
    }

    if ($dao) {
        $dao->closeConnection();
    }

    echo json_encode($json);

?>
