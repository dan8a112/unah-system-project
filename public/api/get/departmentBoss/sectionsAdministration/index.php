<?php

    header("Content-Type: application/json");

    include_once "../../../../../src/DbConnection/DbConnection.php";
    include_once "../../../../../src/DepartmentBoss/DepartmentBoss.php";

    //Data Access Object
    $dao = new DepartmentBossDAO(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);

    if(isset($_GET["id"])){
        $json = $dao->sectionAdministration($_GET['id']);        
    }else{
        $json = [
            "message"=> "No se recibió el parámetro correcto",
            "status"=> false,                
        ];
    }

    $dao->closeConnection();
    
    echo json_encode($json);

?>