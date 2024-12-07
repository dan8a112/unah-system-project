<?php

    header("Content-Type: application/json");

    include_once "../../../../../src/DbConnection/DbConnection.php";
    include_once "../../../../../src/Professor/Professor.php";
    include_once "../../../../../src/Helper/Validator.php";

    $dao = null;

    if(
        isset($_GET["id"]) &&
        isset($_POST["identityNumber"]) &&
        isset($_POST['names'])&&
        isset($_POST['lastNames'])&&
        isset($_POST['phoneNumber'])&&
        isset($_POST['birthDate'])&&
        isset($_POST['address'])&&
        isset($_POST['professorTypeId'])&&
        isset($_POST['departmentId'])&&
        isset($_POST['active'])
    ){
        $id=$_GET['id'];
        $dni = $_POST["identityNumber"];
        $names = $_POST['names'] ?? '';
        $lastNames = $_POST['lastNames'] ?? '';
        $telephoneNumber = $_POST['phoneNumber'] ?? '';
        $address = $_POST['address'] ?? '';
        $dateOfBirth = $_POST['birthDate'] ?? '';
        $professorType = $_POST['professorTypeId'];
        $department = $_POST['departmentId'];
        $active = $_POST['active'];

        $dao = new ProfessorDAO(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);
        $json = $dao->updateProfessor($id, $dni, $names, $lastNames, $telephoneNumber, $address, $dateOfBirth, $professorType, $department, $active);
        
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
