<?php

    /**
     * author: dorian.contreras@unah.hn
     * version: 0.1.0
     * date: nov 2024
     * 
     * Servicio para saber si hay un proceso de inscripcion activo
     */

    header("Content-Type: application/json");

    include_once "../../../../../src/DbConnection/DbConnection.php";
    include_once "../../../../../src/Application/Application.php";

    //Data Access Object
    $dao = new ApplicationDAO(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);
    $result = $dao->isActiveInscriptionProcess();

    if($result){
        $json = [
            "message"=> "Hay un proceso de inscripción actualmente",
            "status"=> $result,            
        ];
    }else{
        $json = [
            "message"=> "No hay un proceso de inscripción actualmente",
            "status"=> $result,            
        ];
    }
    
    $dao->closeConnection();
    
    echo json_encode($json);

?>