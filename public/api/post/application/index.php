<?php

    header("Content-Type: application/json");

    include_once "../../../../src/Helper/Validator.php";
    include_once "../../../../src/Application/Application.php";

    //Data Access Object
    $dao = new ApplicationDAO("localhost", "is", "is", "ProyectoIS");

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
        $dao = new ApplicationDAO("localhost", "is", "is", "ProyectoIS");
        $status = $dao->setApplication($identityNumber, $firstName, $secondName, $firstLastName, $secondLastName, $pathSchoolCertificate, $telephoneNumber, $personalEmail, 
            $firstDegreeProgramChoice, $secondDegreeProgramChoice, $regionalCenterChoice);

        $json = [
            "message"=> $status ? "Se proceso la inscripción de admisión satisfactoriamente" : "Error al hacer la inscripción de admisión",
            "status"=> $status,                
        ];

    }else{

        $json = [
            "status"=> false,
            "message"=> "No se recibió el parámetro correcto"
        ];
    }
   
    
    echo json_encode($json);

?>