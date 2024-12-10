<?php

    /**
     * author: dorian.contreras@unah.hn
     * version: 0.1.0
     * date:  10/12/24
     * 
     * Servicio para obtener las secciones asignadas de un docente dependiendo del periodo
     */

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