<?php

    /**
     * author: dorian.contreras@unah.hn
     * version: 0.1.0
     * date: 10/12/24
     * 
     * Servicio login de DIPP
     */
    header("Content-Type: application/json");

    include_once "../../../../../src/DbConnection/DbConnection.php";
    include_once "../../../../../src/Login/Login.php";

    //Data Access Object
    $dao = new LoginDAO(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);

    if(
        isset($_POST["mail"]) &&
        isset($_POST["password"])){
              
        //set valores
        $mail= $_POST["mail"];
        $password= $_POST['password'] ?? '';

        $status = $dao->loginDIPP($mail, $password);

        if($status){
            $json = [
                "message"=> "Credenciales correctas",
                "status"=> 1,                
            ];

            /*session_start();
            $_SESSION["portals"]["apa"] = [
                "user" => 1
            ];*/

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
            "message"=> "No hay ningun usuario autenticado"
        ];
    }

    $dao->closeConnection();
    
    echo json_encode($json);

?>