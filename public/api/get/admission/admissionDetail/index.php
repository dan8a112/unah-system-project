<?php
    /**
     * author: dorian.contreras@unah.hn
     * version: 0.1.0
     * date: nov 2024
     * 
     * Servicio para obtener el detalle de un proceso de admision historico
     */

    header("Content-Type: application/json");

    include_once "../../../../../src/DbConnection/DbConnection.php";
    include_once "../../../../../src/Application/Application.php";

    //Data Access Object
    $dao = new ApplicationDAO(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);

    if(isset($_GET["id"])){
        $result = $dao->getInfoHistoricAdmission($_GET["id"]);
        $json = [
            "message"=> "Peticion realizada con exito",
            "status"=> true,
            "data" => $result
                
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