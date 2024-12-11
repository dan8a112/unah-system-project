<?php
    /**
     * @author dochoao@unah.hn
     * @version 0.1.0
     * @date 11-12-2024
     * Servicio que trae las clases dependiendo el departamento y la carrera del estudiante
     */

     header("Content-Type: application/json");

     include_once "../../../../../src/DbConnection/DbConnection.php";
     include_once "../../../../../src/Enroll/Enroll.php";
 
     //Data Access Object
     $dao = new EnrollDAO(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);

     if(isset($_GET["account"]) && isset($_GET["departmentId"])){
        $result = $dao->getClasses((int) $_GET["account"], (int) $_GET["departmentId"]);
        $json = [
            "status"=> true,
            "message"=> "Array obtenido.",
            "data"=> $result
        ];
    }else{
        $json = [
            "message"=> "No se recibió el parámetro correcto",
            "status"=> false,                
        ];
    }

    $dao->closeConnection();
    
    echo json_encode($json);