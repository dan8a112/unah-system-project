<?php

    header("Content-Type: application/json");

    include_once "../../../../src/DbConnection/DbConnection.php";
    include_once "../../../../src/Application/Application.php";

    $dao = null;

    if(
        isset($_POST["idFirstDegreeProgramChoice"]) &&
        isset($_POST["idSecondDegreeProgramChoice"]) &&
        isset($_POST["idRegionalCenterChoice"]) &&
        isset($_FILES["pathSchoolCertificate"])
    ){
        $identityNumber = $_POST["identityNumber"];
        $firstName = $_POST['firstName'] ?? '';
        $secondName = $_POST['secondName'] ?? '';
        $firstLastName = $_POST['firstLastName'] ?? '';
        $secondLastName = $_POST['SecondLastName'] ?? '';
        $pathSchoolCertificate = $_FILES['pathSchoolCertificate']['tmp_name'] ?? '';  // Obtener ruta temporal del archivo
        $telephoneNumber = $_POST['telephoneNumber'] ?? '';
        $personalEmail = $_POST['personalEmail'] ?? '';
        $firstDegreeProgramChoice = $_POST["idFirstDegreeProgramChoice"];
        $secondDegreeProgramChoice = $_POST["idSecondDegreeProgramChoice"];
        $regionalCenterChoice = $_POST["idRegionalCenterChoice"];

        if (!empty($pathSchoolCertificate) && file_exists($pathSchoolCertificate)) {
            $fileData = file_get_contents($pathSchoolCertificate);

            // Escapar los datos binarios para seguridad
            //$fileData = $conn->real_escape_string($fileData);

            $dao = new ApplicationDAO(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);
            $result = $dao->setApplication($identityNumber, $firstName, $secondName, $firstLastName, $secondLastName, $fileData, $telephoneNumber, $personalEmail, 
                $firstDegreeProgramChoice, $secondDegreeProgramChoice, $regionalCenterChoice);

            $json = [
                "message" => $result["message"],
                "status" => $result["status"],
                "exams" => $result["exams"]
            ];
        } else {
            $json = [
                "status" => false,
                "message" => "No se pudo leer el archivo del certificado."
            ];
        }
    } else {
        $json = [
            "status" => false,
            "message" => "No se recibió el parámetro correcto"
        ];
    }
   
    if ($dao) {
        $dao->closeConnection();
    }
    
    echo json_encode($json);

?>
