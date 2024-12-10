<?php

    header("Content-Type: application/json");

    include_once "../../../../../src/DbConnection/DbConnection.php";
    include_once "../../../../../src/Professor/Professor.php";

    //Data Access Object
    $dao = new ProfessorDAO(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);

    if(isset($_GET["idProfessor"]) && isset($_GET["idProcess"])){
        $result = $dao->getAssignedClasses($_GET["idProfessor"], $_GET["idProcess"]);
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

?>