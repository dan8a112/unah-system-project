<?php

    header("Content-Type: application/json");

    include_once "../../../../src/DbConnection/DbConnection.php";
    include_once "../../../../src/Professor/Professor.php";

    $dao = null;

    if(
        isset($_POST["identityNumber"]) &&
        isset($_POST['firstName'])&&
        isset($_POST['secondName'])&&
        isset($_POST['firstLastName'])&&
        isset($_POST['secondLastName'])&&
        isset($_POST['phoneNumber'])&&
        isset($_POST['birthDate'])&&
        isset($_POST['address'])&&
        isset($_POST['professorTypeSelect'])&&
        isset($_POST['departmentSelect'])
    ){
        $dni = $_POST["identityNumber"];
        $firstName = $_POST['firstName'] ?? '';
        $secondName = $_POST['secondName'] ?? '';
        $firstLastName = $_POST['firstLastName'] ?? '';
        $secondLastName = $_POST['secondLastName'] ?? '';
        $telephoneNumber = $_POST['phoneNumber'] ?? '';
        $address = $_POST['address'];
        $dateOfBirth = $_POST['birthDate'];
        $professorType = $_POST['professorTypeSelect'];
        $department = $_POST['departmentSelect'];

        $dao = new ProfessorDAO(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);
        $result = $dao->setProfessor($dni, $firstName, $secondName, $firstLastName, $secondLastName, $telephoneNumber, $address, $dateOfBirth, $professorType, $department);

        $json = [
            "message" => $result["message"],
            "status" => $result["status"],
            "data" => $result["data"]
        ];
        
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
