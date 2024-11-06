<?php

    header("Content-Type: application/json");

    include_once "../../../../src/Helper/Validator.php";
    include_once "../../../../src/Login/Login.php";

    //Data Access Object
    $dao = new LoginDAO("localhost", "is", "is", "ProyectoIS");

    if(
        isset($_POST["mail"]) &&
        isset($_POST["password"]) 
    ){
        //set valores
        $mail= $_POST["mail"];
        $password= $_POST['password'] ?? '';

        //Data Access Object
        $dao = new LoginDAO("localhost", "is", "is", "ProyectoIS");
        $status = $dao->loginSEDP($mail, $password);

        $json = [
            "message"=> $status ? "Usuario con permisos par hacer login" : "No existe el usuario",
            "status"=> $status,                
        ];

    }else{

        $json = [
            "status"=> false,
            "message"=> "No se recibió el parámetro correcto"
        ];
    }
   
    
    echo json_encode($json);

?>