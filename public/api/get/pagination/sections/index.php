<?php

    /**
     * author: dorian.contreras@unah.hn
     * version: 0.1.0
     * date: dic 2024
     * 
     * Servicio para paginarlas secciones creadas por el jefe de departamento para un periodo 
     */
    header("Content-Type: application/json");

    include_once "../../../../../src/DbConnection/DbConnection.php";
    include_once "../../../../../src/DepartmentBoss/DepartmentBoss.php";

    //Data Access Object
    $dao = new DepartmentBossDAO(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);

    if(isset($_GET["idProcess"]) && isset($_GET["offset"]) && isset($_GET["idBoss"])){
        $result = $dao->getSections((int) $_GET["idProcess"], (int) $_GET["offset"], (int) $_GET["idBoss"] );
        $json = [
            "status"=> true,
            "message"=> "Array obtenido.",
            "data"=> $result['sectionList'],
            "amountSections"=> $result['amountSections']
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