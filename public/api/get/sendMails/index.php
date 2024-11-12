<?php

    header("Content-Type: application/json");

    include_once "../../../../src/DbConnection/DbConnection.php";
    include_once "../../../../src/MailSender/MailSender.php";

    //Data Access Object
    $dao = new MailSenderDAO(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);
    $result = $dao->sendAllMails();

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

    $dao->closeConnection();
    
    echo json_encode($json);

?>