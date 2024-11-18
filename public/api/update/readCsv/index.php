<?php
header("Content-Type: application/json");

include_once "../../../../../src/DbConnection/DbConnection.php";

// Abrir el archivo en modo lectura
if(isset($_FILES["pathCsvGrades"])){
    $pathCsvGrades = $_FILES['pathCsvGrades']['tmp_name'] ?? '';
    if(file_exists($pathCsvGrades) && !empty($pathCsvGrades)){
        /**if (($handle = fopen($pathCsvGrades, 'r')) !== false) {
            // Leer la primera línea (encabezados)
            $headers = fgetcsv($handle, 1000, ',');
            
            // Leer cada línea del archivo
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                // Mapear los datos a variables
                $dni = $data[0];
                $id_test = $data[1];
                $grade = $data[2];
        
                // Insertar los datos en la base de datos
                $stmt = $pdo->prepare("INSERT INTO estudiantes (id_estudiante, nombre, apellido, nota) VALUES (:id_estudiante, :nombre, :apellido, :nota)");
                $stmt->execute([
                    ':id_estudiante' => $id_estudiante,
                    ':nombre' => $nombre,
                    ':apellido' => $apellido,
                    ':nota' => $nota
                ]);
            }
        
            fclose($handle);
            echo "Datos importados correctamente.";
        } else {
            echo "Error al abrir el archivo.";
        }*/
        $json = [
            "message" => "Existe el csv",
            "status" => true
        ];
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
