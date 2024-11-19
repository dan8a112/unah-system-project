<?php

    header("Content-Type: application/json");

    include_once "../../../../src/DbConnection/DbConnection.php";
    include_once "../../../../src/Professor/Professor.php";

    $dao = null;

    if(
        isset($_GET["id"]) &&
        isset($_POST["identityNumber"]) &&
        isset($_POST['firstName'])&&
        isset($_POST['secondName'])&&
        isset($_POST['firstLastName'])&&
        isset($_POST['secondLastName'])&&
        isset($_POST['phoneNumber'])&&
        isset($_POST['birthDate'])&&
        isset($_POST['address'])&&
        isset($_POST['professorTypeId'])&&
        isset($_POST['departmentId'])&&
        isset($_POST['active'])
    ){
        $id=$_GET['id'];
        $dni = $_POST["identityNumber"];
        $firstName = $_POST['firstName'] ?? '';
        $secondName = $_POST['secondName'] ?? '';
        $firstLastName = $_POST['firstLastName'] ?? '';
        $secondLastName = $_POST['secondLastName'] ?? '';
        $telephoneNumber = $_POST['phoneNumber'] ?? '';
        $address = $_POST['address'] ?? '';
        $dateOfBirth = $_POST['birthDate'] ?? '';
        $professorType = $_POST['professorTypeId'];
        $department = $_POST['departmentId'];
        $active = $_POST['active'];

        $dao = new ProfessorDAO(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);
        $result = $dao->updateProfessor($id, $dni, $firstName, $secondName, $firstLastName, $secondLastName, $telephoneNumber, $address, $dateOfBirth, $professorType, $department, $active);

        $json = $result;
        
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
