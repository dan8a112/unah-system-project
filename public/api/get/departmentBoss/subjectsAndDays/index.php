<?php

    /**
     * author: dorian.contreras@unah.hn
     * version: 0.1.0
     * date: dic 2024
     * 
     * Servicio para obtener los dias y las clases para crear una seccion
     */

    header("Content-Type: application/json");

    include_once "../../../../../src/DbConnection/DbConnection.php";
    include_once "../../../../../src/GenericGet/GenericGet.php";

    //Data Access Object
    $dao = new GenericGetDAO(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);

    if(isset($_GET['id'])){
        $days = $dao->getDays();
        $classes = $dao->getSubjectsDepartment($_GET['id']);

        $json = [
            "message"=> "Peticion realizada con exito",
            "status"=> true,
            'data'=>[
                "classes" => $classes,
                'days'=> $days       
            ]   
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