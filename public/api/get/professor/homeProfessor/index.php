<?php

    /**
     * author: dorian.contreras@unah.hn
     * version: 0.1.0
     * date: 6/12/24
     * 
     * Servicio para obtener el home de un docente
     */

    header("Content-Type: application/json");

    include_once "../../../../../src/DbConnection/DbConnection.php";
    include_once "../../../../../src/Professor/Professor.php";

    //Data Access Object
    $dao = new ProfessorDAO(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);

    if(isset($_GET["id"])){
        $json = $dao->homeProfessor($_GET['id']);
    }else{
        $json = [
            "message"=> "No se recibió el parámetro correcto",
            "status"=> false,                
        ];
    }

    $dao->closeConnection();
    
    echo json_encode($json);

?>