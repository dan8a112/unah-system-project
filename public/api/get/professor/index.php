<?php

    header("Content-Type: application/json");

    include_once "../../../../src/DbConnection/DbConnection.php";
    include_once "../../../../src/Professor/Professor.php";

    //Data Access Object
    $dao = new ProfessorDAO(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);

    if(isset($_GET["id"])){
        $professor = $dao->getProfessor($_GET['id']);
        if($professor != null){
            $json = [
                "message"=> "Peticion realizada con exito",
                "status"=> true,
                "data" => $professor     
            ];
        }else{
            $json = [
                "message"=> "No existe profesor",
                "status"=> false,                
            ];
        }
        
    }else{
        $json = [
            "message"=> "No se recibió el parámetro correcto",
            "status"=> false,                
        ];
    }

    $dao->closeConnection();
    
    echo json_encode($json);

?>