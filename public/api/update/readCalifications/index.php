<?php
    /**
     * author: afcastillof@unah.hn
     * version: 0.1.0
     * date: 10/12/2024
     * 
     * Servicio para leer CSV y actualizar las notas de los estudiantes de una seccion
     */
    header("Content-Type: application/json");

    include_once "../../../../src/DbConnection/DbConnection.php";
    include_once "../../../../src/Section/Section.php";


    // Abrir el archivo en modo lectura
    if(isset($_FILES["pathCsvGrades"]) && isset($_POST["idSection"])){
        $pathCsvGrades = $_FILES['pathCsvGrades']['tmp_name'] ?? '';
        if(file_exists($pathCsvGrades) && !empty($pathCsvGrades)){
            $dao = new SectionDAO(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);
            $json = $dao->insertGrades($pathCsvGrades, $_POST["idSection"]);
            
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
