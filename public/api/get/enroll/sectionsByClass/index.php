<?php
    /**
     * @author dochoao@unah.hn
     * @version 0.1.0
     * @date 11-12-2024
     * Servicio que trae las secciones habilitadas para matricula en el periodo actual
     */

     header("Content-Type: application/json");

     include_once "../../../../../src/DbConnection/DbConnection.php";
     include_once "../../../../../src/Enroll/Enroll.php";
     include_once "../../../../../src/Enroll/ClassesBehaviour.php";
 
     //Data Access Object
     $dao = new EnrollDAO(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);
     $classesBehavior = new ClassesBehaviour();

     if(isset($_GET["classId"]) && ($_GET["account"])){

        $approvedClasses = $dao->getApprovedClasses($_GET["account"]);
        $requirements = $dao->getRequisites($_GET["classId"]);

        if($classesBehavior->validateRequirements($approvedClasses,$requirements)){
            $result = $dao->getSections($_GET["classId"]);

            $json = [
                "status"=> true,
                "message"=> "Array obtenido.",
                "data"=> $result
            ];
        }else{
            $json = [
                "status"=> false,
                "message"=> "El estudiante no cumple con los requisitos para matricular esta clase"
            ];
        }
        
    }else{
        $json = [
            "message"=> "No se recibió el parámetro correcto",
            "status"=> false            
        ];
    }

    $dao->closeConnection();
    
    echo json_encode($json);