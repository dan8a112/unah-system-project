<?php

    /**
     * author: dorian.contreras@unah.hn
     * version: 0.1.0
     * date: nov 2024
     * 
     * Servicio para programar el envio de correos para informar a los aplicantes sus resultados de examenes
     */
    header("Content-Type: application/json");

    include_once "../../../../../src/DbConnection/DbConnection.php";
    include_once "../../../../../src/MailSender/MailSender.php";

    //Data Access Object
    $dao = new MailSenderDAO(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);
    $json = $dao->programEmailSend();

    $dao->closeConnection();
    
    echo json_encode($json);

?>