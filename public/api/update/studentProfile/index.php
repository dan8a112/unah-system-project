<?php
/**
 * author: wamorales@unah.hn
 * version: 0.1.0
 * date: 11 dic 2024
 *
 * Servicio para editar la información de perfil de un estudiante.
 */

header("Content-Type: application/json");

include_once "../../../../src/DbConnection/DbConnection.php";
include_once "../../../../src/Student/StudentHistory.php";

$dao = null;

// Obtener el studentId desde los parámetros de la URL
if (isset($_GET["studentId"])) {
    $studentId = $_GET["studentId"];
    $description = $_POST["description"] ?? null;
    $pathProfilePhoto = $_FILES['pathProfilePhoto']['tmp_name'] ?? '';  // Obtener ruta temporal del archivo

    // Validar que se envíen al menos uno de los campos
    if (empty($description) && empty($pathProfilePhoto)) {
        echo json_encode([
            "status" => false,
            "message" => "Debe proporcionar al menos un campo para actualizar.",
            "route" => $pathProfilePhoto
        ]);
        exit;
    }

    // Inicializar conexión y ejecutar el método
    if (!empty($pathProfilePhoto)) {
    $fileData = file_get_contents($pathProfilePhoto);}

    $dao = new StudentDAO(DbConnection::$server, DbConnection::$user, DbConnection::$pass, DbConnection::$dbName);
    $json = $dao->updateStudentProfile($studentId, $description, $fileData);
} else {
    $json = [
        "status" => false,
        "message" => "No se recibió el parámetro 'studentId'."
    ];
}

// Cerrar conexión y retornar la respuesta
if ($dao) {
    $dao->closeConnection();
}

echo json_encode($json);
?>
