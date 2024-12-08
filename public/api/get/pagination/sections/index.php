<?php

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
            "data"=> $result['sectionList']
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