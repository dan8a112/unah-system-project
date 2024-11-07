<?php

    header("Content-Type: application/json");

    include_once "../../../../src/DbConnection/DbConnection.php";
    include_once "../../../../src/Application/Application.php";

    if(
        isset($_POST["identityNumber"]) &&
        isset($_POST["idFirstDegreeProgramChoice"]) &&
        isset($_POST["idSecondDegreeProgramChoice"]) &&
        isset($_POST["idRegionalCenterChoice"]) 
    ){
        //set valores
        $identityNumber= $_POST["identityNumber"];
        $firstName= $_POST['firstName'] ?? '';
        $secondName= $_POST['secondName'] ?? '';
        $firstLastName= $_POST['firstLastName'] ?? '';
        $secondLastName= $_POST['secondLastName'] ?? '';
        $pathSchoolCertificate= $_POST['pathSchoolCertificate'] ?? '';
        $telephoneNumber= $_POST['telephoneNumber'] ?? '';
        $personalEmail= $_POST['personalEmail'] ?? '';
        $firstDegreeProgramChoice= $_POST["idFirstDegreeProgramChoice"];
        $secondDegreeProgramChoice= $_POST["idSecondDegreeProgramChoice"];
        $regionalCenterChoice= $_POST["idRegionalCenterChoice"];

        //Data Access Object
        $dao = new ApplicationDAO(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);
        $result = $dao->setApplication($identityNumber, $firstName, $secondName, $firstLastName, $secondLastName, $pathSchoolCertificate, $telephoneNumber, $personalEmail, 
            $firstDegreeProgramChoice, $secondDegreeProgramChoice, $regionalCenterChoice);

        $json = [
            "message"=> $result["message"],
            "status"=> $result["status"],                
        ];

    }else{

        $json = [
            "status"=> false,
            "message"=> "No se recibió el parámetro correcto"
        ];
    }
   
    $dao->closeConnection();
    
    echo json_encode($json);

?>