<?php
header("Content-Type: application/json");

include_once "../../../../../src/DbConnection/DbConnection.php";
include_once "../../../../../src/Application/Application.php";


// Abrir el archivo en modo lectura
if(isset($_FILES["pathCsvGrades"])){
    $pathCsvGrades = $_FILES['pathCsvGrades']['tmp_name'] ?? '';
    if(file_exists($pathCsvGrades) && !empty($pathCsvGrades)){
        $dao = new ApplicationDAO(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);
        $json = $dao->insertResults($pathCsvGrades);
        
    } else {
        $json = [
            "message" => "No se manda el csv",
            "status" => false
        ];
    }
    
} else {
    $json = [
        "message" => "No se manda el parametro correcto",
        "status" => false
    ];
}

echo json_encode($json);

?>
