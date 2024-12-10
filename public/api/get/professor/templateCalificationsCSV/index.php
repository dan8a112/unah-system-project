<?php
/**
 * author: afcastillof@unah.hn
 * version: 0.1.0
 * date: 12/11/24
 */

include_once "../../../../../src/Files/CSVExporter.php";

class SampleCSVGenerator {
    public static function generateSampleTemplate() {
        $filename = "plantilla_calificaciones.csv";
        header('Content-Type: text/csv');
        header("Content-Disposition: attachment; filename=\"$filename\"");

        $sampleData = [
            ["account", "grade", "obs"]
        ];

        $file = fopen('php://output', 'w');
        foreach ($sampleData as $row) {
            fputcsv($file, $row);
        }
        fclose($file);
    }
}

SampleCSVGenerator::generateSampleTemplate();
?>
