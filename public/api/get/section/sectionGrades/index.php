<?php

    /**
     * author: dorian.contreras@unah.hn
     * version: 0.1.0
     * date: dic 2024
     * 
     * Servicio para obtener las calificaciones d elos estudiantes en una seccion
     */

    header("Content-Type: application/json");

    include_once "../../../../../src/DbConnection/DbConnection.php";
    include_once "../../../../../src/Section/Section.php";

    //Data Access Object
    $dao = new SectionDAO(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);

    if(isset($_GET["id"])){
        $json = $dao->getGradesSection($_GET['id']);        
    }else{
        $json = [
            "message"=> "No se recibió el parámetro correcto",
            "status"=> false,                
        ];
    }

    $dao->closeConnection();
    
    echo json_encode($json);

?>