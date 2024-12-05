<?php

    header("Content-Type: application/json");

    include_once "../../../../../src/DbConnection/DbConnection.php";
    include_once "../../../../../src/Login/Login.php";

    //Data Access Object
    $dao = new LoginDAO(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);

    if(isset($_POST["mail"]) &&
        isset($_POST["password"])){
              
        //set valores
        $mail= $_POST["mail"];
        $password= $_POST['password'] ?? '';
        $result = $dao->loginDepartmentBoss($mail, $password);

        if($result['status']){
            $json = [
                "message"=> "Credenciales correctas",
                "status"=> 1,
                "data"=>  $result['data']               
            ];
            
            session_start();
            $_SESSION["portals"]["bosses"] = [
                "user" => $result['data']['id']
            ];

        }else{
            $json = [
                "message"=> "No existe el usuario o el usuario que intenta iniciar sesión no es un Jefe de departamento.",
                "status"=> 2,                
            ];
        }

    }else{
        //There's no user autenticated go to login or an error occur
        $json = [
            "status"=> 3,
            "message"=> "No hay ningun usuario autenticado"
        ];
    }

    $dao->closeConnection();
    
    echo json_encode($json);

?>