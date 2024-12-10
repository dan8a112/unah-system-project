<?php
    /**
     * author: dorian.contreras@unah.hn
     * version: 0.1.0
     * date: nov 2024
     * 
     * Servicio login de CRI
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

        $result = $dao->loginCRI($mail, $password);

        if($result['status']){
            $json = [
                "message"=> $result['message'],
                "id"=> $result['id'],
                "status"=> 1,                
            ];

            session_start();
            $_SESSION["portals"]["cri"] = [
                "user" => $result['id']
            ];

        }else{
            $json = [
                "message"=> $result['message'],
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