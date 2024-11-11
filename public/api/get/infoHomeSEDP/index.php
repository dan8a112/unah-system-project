<?php

    header("Content-Type: application/json");


    session_start();

    include_once "../../../../src/DbConnection/DbConnection.php";
    include_once "../../../../src/Professor/Professor.php";
    include_once "../../../../src/Session/Session.php";

    if(isset($_SESSION['userSEDP'])){
        //There is an open session 
        //Data Access Object
        $dao = new ProfessorDAO(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);
        $professors = $dao->getProfessors();
        $amount = $dao->getAmountProfessors();

        $json = [
            "message"=> "Peticion realizada con exito",
            "status"=> true,
            "data"=> [
                "professorsAmount"=> $amount,
                "professors" => $professors
            ]
                
        ];

        $dao->closeConnection();
    
        echo json_encode($json);

    }else{

        $json = [
            "message"=> $_SESSION['userSEDP'] ,
            "status"=> false
                
        ];
        //echo json_encode($json);

        header("Location: ../assets/views/logins/login_sedp.html");
    }

?>