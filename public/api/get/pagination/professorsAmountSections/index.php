<?php

    /**
     * author: dorian.contreras@unah.hn
     * version: 0.1.0
     * date: dic 2024
     * 
     * Servicio para paginar los profesores para ver sus evaluaciones
     */

    header("Content-Type: application/json");

    include_once "../../../../../src/DbConnection/DbConnection.php";
    include_once "../../../../../src/DepartmentBoss/DepartmentBoss.php";

    //Data Access Object
    $dao = new DepartmentBossDAO(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);

    if(isset($_GET["idPeriod"]) && isset($_GET["offset"])){
        $result = $dao->getProfessorsAmountSections((int) $_GET["idPeriod"], (int) $_GET["offset"]);
        $json = [
            "status"=> true,
            "message"=> "Array obtenido.",
            "data"=> $result['professors'],
            "amountStudents"=> $result['amountProfessors']
        ];
    }else{
        $json = [
            "message"=> "No se recibió el parámetro correcto",
            "status"=> false,                
        ];
    }

    $dao->closeConnection();
    
    echo json_encode($json);

?>