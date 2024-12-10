<?php

    header("Content-Type: application/json");

    include_once "../../../../src/DbConnection/DbConnection.php";
    include_once "../../../../src/Student/StudentHistory.php";

    //Data Access Object
    $dao = new StudentDAO(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);

    if(isset($_GET["searchIndex"])){
        $searchResults = $dao->searchStudents($_GET['searchIndex']);
        if($searchResults != null){
            $json = [
                "message"=> "Peticion realizada con exito",
                "status"=> true,
                "data" => $searchResults     
            ];
        }else{
            $json = [
                "message"=> "No se encontraron coincidencias.",
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