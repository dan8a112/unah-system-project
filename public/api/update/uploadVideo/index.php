<?php

    /**
     * author: dorian.contreras@unah.hn
     * version: 0.1.0
     * date: 11/12/24
     * 
     * Servicio subir un vidoe
     */
    header("Content-Type: application/json");

    include_once "../../../../src/DbConnection/DbConnection.php";
    include_once "../../../../src/Professor/Professor.php";

    $dao = null;

    if(
        isset($_GET["idSection"]) &&
        isset($_FILES['video'])
    ){
        if($_FILES['video']['error'] == 0) {
            $video = $_FILES['video']['tmp_name'];
            $videoContent = file_get_contents($video);

            $dao = new ProfessorDAO(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);
            $json = $dao->uploadVideo($idSection, $dni, $videoContent);
    

        } else {
            $json = [
                'status'=> false,
                "message"=> "Error al cargar el archivo."
            ];
        }
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
