<?php

    header("Content-Type: application/json");

    include_once "../../../../src/DbConnection/DbConnection.php";
    include_once "../../../../src/Login/Login.php";
    include_once "../../../../src/Session/Session.php";

    //crear sesion
    $userSession = new SessionDAO();

    if(isset($_SESSION['user'])){
        //There is an open session 
        $json = [
            "status"=> 0,
            "message"=> "Usuario autenticado puede ir al HomePage"
        ];

    }else if(
        isset($_POST["mail"]) &&
        isset($_POST["password"])){
              
        //set valores
        $mail= $_POST["mail"];
        $password= $_POST['password'] ?? '';

        //Data Access Object
        $dao = new LoginDAO(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);
        $status = $dao->loginSEDP($mail, $password);

        if($status){
            $userSession->setCurrentUser($mail);
            $json = [
                "message"=> "Usuario autenticado",
                "status"=> 1,                
            ];

        }else{
            $json = [
                "message"=> "No existe el usuario",
                "status"=> 2,                
            ];
        }

        

    }else{
        //There's no user autenticated go to login or an error occur
        $json = [
            "status"=> 3,
            "message"=> "Error o no hay ningun usuario autenticado"
        ];
    }

    $dao->closeConnection();
    
    echo json_encode($json);

?>