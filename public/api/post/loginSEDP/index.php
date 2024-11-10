<?php

    header("Content-Type: application/json");

    include_once "../../../../src/DbConnection/DbConnection.php";
    include_once "../../../../src/Login/Login.php";
    include_once "../../../../src/Session/Session.php";

    //crear sesion
    $userSession = new UserSession();

    //set valores
    $mail= $_POST["mail"];
    $password= $_POST['password'] ?? '';

    
    if(isset($_SESSION['user'])){
        //There is an open session 
    }else if(
        isset($_POST["mail"]) &&
        isset($_POST["password"])){
            //Data Access Object
        $dao = new LoginDAO(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);
        $status = $dao->loginSEDP($mail, $password);

        $json = [
            "message"=> $status ? "Usuario con permisos par hacer login" : "No existe el usuario",
            "status"=> $status,                
        ];

    }else{
        header("Location: ../assets/views/logins/login_sedp.html");
    }

    $dao->closeConnection();
    
    echo json_encode($json);

?>