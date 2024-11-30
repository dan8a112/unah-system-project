<?php

    header("Content-Type: application/json");

    include_once "../../../../../src/DbConnection/DbConnection.php";
    include_once "../../../../../src/MailSender/MailSender.php";

    //Data Access Object
    $dao = new MailSenderDAO(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);
    if(isset($_GET['offset'])){
        $result = $dao->sendAllMails((int) $_GET['offset']);

        if($result){
            $json = [
                "message"=> "Se enviaron los correos",
                "status"=> $result,            
            ];
        }else{
            $json = [
                "message"=> "Lastimosamente no se enviaron los correos, hay un error.",
                "status"=> $result,            
            ];
        }
    }else{
        $json = [
            "message"=> "Parametro incorrecto",
            "status"=> false,            
        ];
    }
    

    $dao->closeConnection();
    
    echo json_encode($json);

?>