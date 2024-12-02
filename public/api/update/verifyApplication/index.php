<?php
header("Content-Type: application/json");

include_once "../../../../src/DbConnection/DbConnection.php";
include_once "../../../../src/Application/Application.php";


// Abrir el archivo en modo lectura
if(
    isset($_POST["idApplication"]) &&
    isset($_POST["idReviewer"]) &&
    isset($_POST["approved"]) &&
    isset($_POST['name']) &&
    isset($_POST['mail'])
){
    $dao = new ApplicationDAO(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);
    $json = $dao->setApprovedApplication($_POST["idApplication"], $_POST["idReviewer"], $_POST["approved"], $_POST['name'], $_POST['mail']);
    
} else {
    $json = [
        "message" => "No se manda el parametro correcto",
        "status" => false
    ];
}

echo json_encode($json);

?>
