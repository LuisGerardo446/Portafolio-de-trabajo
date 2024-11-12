<?php
// Incluir el autoload de Composer
require '../../vendor/autoload.php'; 

use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_POST['submit'])) {
    if ($_FILES['excel_file']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['excel_file']['tmp_name'])) {
        $excelFilePath = $_FILES['excel_file']['tmp_name'];
        
        // Crear un lector para leer el archivo Excel
        $reader = IOFactory::createReader('Xlsx');
        
        // Cargar el archivo Excel
        $spreadsheet = $reader->load($excelFilePath);
        
        // Definir el tipo de salida como HTML
        header('Content-Type: text/html');
        
        // Salida HTML del archivo Excel
        echo "<!DOCTYPE html>\n<html>\n<head>\n<meta charset='UTF-8'>\n";
        echo "<title>Visualización de Excel en el navegador</title>\n";
        echo "</head>\n<body>\n";
        
        // Obtener la hoja activa del archivo Excel
        $worksheet = $spreadsheet->getActiveSheet();
        
        // Obtener todas las celdas de la hoja activa
        $cells = $worksheet->toArray();
        
        // Crear una tabla HTML para mostrar los datos
        echo "<table border='1'>\n";
        foreach ($cells as $row) {
            echo "<tr>\n";
            foreach ($row as $cell) {
                echo "<td>" . htmlspecialchars($cell) . "</td>\n";
            }
            echo "</tr>\n";
        }
        echo "</table>\n";
        
        echo "</body>\n</html>";
    } else {
        echo "Error al subir el archivo.";
    }
}
?>
