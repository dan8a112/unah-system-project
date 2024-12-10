<?php

    /**
     * author: dorian.contreras@unah.hn
     * version: 0.1.0
     * date: dic 2024
     * 
     * Servicio actualizar contraseña de un profesor
     */

    header("Content-Type: application/json");

    include_once "../../../../../src/DbConnection/DbConnection.php";
    include_once "../../../../../src/Professor/Professor.php";
    include_once "../../../../../src/Helper/Validator.php";

    $dao = null;

    if(
        isset($_GET["id"]) &&
        isset($_POST["newPassword"]) &&
        isset($_POST['currentPassword'])
    ){
        $id=$_GET['id'];
        $newPassword = $_POST["newPassword"];
        $currentPassword = $_POST['currentPassword'] ?? '';

        $dao = new ProfessorDAO(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);
        $json = $dao->setPassword((int) $id, $newPassword, $currentPassword);
        
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
