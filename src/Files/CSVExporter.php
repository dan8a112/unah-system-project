<?php
/**
 * author: afcastillof@unah.hn
 * version: 0.1.0
 * date: 12/11/24
 */
class CSVExporter {
    private $mysqli;
    public function __construct(string $server, string $user, string $pass, string $dbName) {
        $this->mysqli = new mysqli($server, $user, $pass, $dbName);

        if ($this->mysqli->connect_error) {
            die("Error en la conexión: " . $this->mysqli->connect_error);
        }
    }

    // Método para exportar el resultado de una consulta a un archivo CSV
    public function exportToCSV(string $sql, string $filename = "exported_data.csv") {
        // Configurar los encabezados para descargar el archivo
        header('Content-Type: text/csv');
        header("Content-Disposition: attachment; filename=\"$filename\"");

        // Ejecutar la consulta SQL
        $result = $this->mysqli->query($sql);

        // Verificar si hay resultados
        if ($result && $result->num_rows > 0) {
            // Abrir la salida para escribir el CSV
            $file = fopen('php://output', 'w');

            // Obtener y escribir los nombres de las columnas
            $columnNames = array_keys($result->fetch_assoc());
            fputcsv($file, $columnNames);

            // Devolver el cursor a la primera fila y escribir las filas de datos
            $result->data_seek(0);
            while ($row = $result->fetch_assoc()) {
                fputcsv($file, $row);
            }

            fclose($file);
        } else {
            echo "No hay datos para exportar.";
        }
    }

    public function closeConnection() {
        $this->mysqli->close();
    }
}
?>
