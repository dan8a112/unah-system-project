<?php

    header("Content-Type: application/json");

    include_once "../../../../src/DbConnection/DbConnection.php";
    include_once "../../../../src/Application/Application.php";

    //Data Access Object
    $dao = new ApplicationDAO(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);
    $result = $dao->isActiveAdmissionProcess();

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