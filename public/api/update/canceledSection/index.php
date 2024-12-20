<?php

    /**
     * author: dorian.contreras@unah.hn
     * version: 0.1.0
     * date: 10/12/24
     * 
     * Servicio cancelar una seccion
     */

    header("Content-Type: application/json");

    include_once "../../../../src/DbConnection/DbConnection.php";
    include_once "../../../../src/Section/Section.php";

    $dao = null;

    if(
        isset($_GET['id'])
    ){
        $id = $_GET['id'];

        $dao = new SectionDAO(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);
        $json = $dao->canceledSection($id);
        
    } else {
        $json = [
            "status" => false,
            "message" => "No se recibió el parámetro correcto"
        ];
    }
   
    if ($dao) {
        $dao->closeConnection();
    }
    
    echo json_encode($json);

?>
