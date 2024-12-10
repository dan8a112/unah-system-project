<?php
    /**
     * author: dorian.contreras@unah.hn
     * version: 0.1.0
     * date: nov 2024
     * 
     * Servicio para obtener el detalle de un proceso de admision activo
     */

    header("Content-Type: application/json");

    include_once "../../../../../src/DbConnection/DbConnection.php";
    include_once "../../../../../src/Application/Application.php";

    //Data Access Object
    $dao = new ApplicationDAO(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);
    $test = $dao->getInfoCurrentAdmission();

    $json = [
        "message"=> $test['message'],
        "status"=> $test['status'],
        "data" => $test['data']
            
    ];

    $dao->closeConnection();
    
    echo json_encode($json);

?>