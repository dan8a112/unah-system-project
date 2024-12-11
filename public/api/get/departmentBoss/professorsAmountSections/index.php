<?php

    /**
     * author: dorian.contreras@unah.hn
     * version: 0.1.0
     * date: dic 2024
     * 
     * Servicio para obtener los docentes y aulas disponibles dependiendo del horario
     */

    header("Content-Type: application/json");

    include_once "../../../../../src/DbConnection/DbConnection.php";
    include_once "../../../../../src/DepartmentBoss/DepartmentBoss.php";

    //Data Access Object
    $dao = new DepartmentBossDAO(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);

    if(isset($_GET["idPeriod"])){
        $json = $dao->getProfessorsForEvaluations((int) $_GET['idPeriod']);        
    }else{
        $json = [
            "message"=> "No se recibió el parámetro correcto",
            "status"=> false,                
        ];
    }

    $dao->closeConnection();
    
    echo json_encode($json);

?>