<?php
    /**
     * author: dorian.contreras@unah.hn
     * version: 0.1.0
     * date: 09/12/24
     * 
     * Servicio para buscar un estudiante por numero de cuenta
     */
    header("Content-Type: application/json");

    include_once "../../../../src/DbConnection/DbConnection.php";
    include_once "../../../../src/Student/StudentHistory.php";

    // Data Access Object
    $dao = new StudentDAO(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);

    // Verificar si se recibe el número de cuenta por POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['searchIndex'])) {
        $searchIndex = trim($_POST['searchIndex']);

        $searchResults = $dao->searchStudents($searchIndex);

        if ($searchResults != null) {
            $json = [
                "message" => "Petición realizada con éxito",
                "status" => true,
                "data" => $searchResults
            ];
        } else {
            $json = [
                "message" => "No se encontraron coincidencias.",
                "status" => false
            ];
        }
    } else {
        $json = [
            "message" => "Parámetro de búsqueda no recibido o método no permitido.",
            "status" => false
        ];
    }

    $dao->closeConnection();
    echo json_encode($json);

?>
