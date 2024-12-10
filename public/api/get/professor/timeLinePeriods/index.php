<?php
    /**
     * author: dorian.contreras@unah.hn
     * version: 0.1.0
     * date: 10/12/24
     * 
     * Servicio para obtener los periodos en orden de años en los que un docente impartio clases
     */

    header("Content-Type: application/json");

    include_once "../../../../../src/DbConnection/DbConnection.php";
    include_once "../../../../../src/GenericGet/GenericGet.php";

    if(isset($_GET['idProfessor'])){
        $dao = new GenericGetDAO(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);

        $allProcess = $dao->getAllPeriodsInYears($_GET['idProfessor']);
        $response = [
            "message" => "Petición realizada con éxito",
            "status" => true,
            "data" => [
                "previousProcesses" => $allProcess
            ]    
            
        ];

    }else{
        $response = [
            "message" => "Parametro incorrecto",
            "status" => false      
        ];
    }



    $dao->closeConnection();

    echo json_encode($response);

?>
