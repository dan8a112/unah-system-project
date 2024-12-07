<?php

    header("Content-Type: application/json");

    include_once "../../../../../src/DbConnection/DbConnection.php";
    include_once "../../../../../src/MailSender/MailSender.php";

    //Data Access Object
    $dao = new MailSenderDAO(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);
    $json = $dao->programEmailSend();

    $dao->closeConnection();
    
    echo json_encode($json);

?>