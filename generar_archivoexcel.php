<?php
include("../../templates/conexion.php");
require '../../vendor/autoload.php'; 

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Consulta SQL para obtener datos de la base de datos
$query = "SELECT alumnos.*, empresas.nombreEmp AS nombre_empresa FROM alumnos LEFT JOIN empresas ON alumnos.idEmpresa = empresas.idEmpresa ORDER BY alumnos.idAlumno";
$resultado = $conn->query($query);

// Crear un nuevo objeto PhpSpreadsheet
$spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Se modifica el ancho de la columna
$sheet->getColumnDimension('B')->setWidth(50); // Establecer el ancho de la columna A a 20
$sheet->getColumnDimension('C')->setWidth(20); 
$sheet->getColumnDimension('D')->setWidth(20); 
$sheet->getColumnDimension('E')->setWidth(30); 
// Agregar encabezados
$sheet->setCellValue('A1', 'ID');
$sheet->setCellValue('B1', 'Carrera');
$sheet->setCellValue('C1', 'Nombre');
$sheet->setCellValue('D1', 'Apellido');
$sheet->setCellValue('E1', 'Empresa');
// Agregar datos desde la base de datos
$row = 2;
while ($row_data = $resultado->fetch_assoc()) {
    $sheet->setCellValue('A' . $row, $row_data['idAlumno']);
    $sheet->setCellValue('B' . $row, $row_data['carrera']);
    $sheet->setCellValue('C' . $row, $row_data['nombres']);
    $sheet->setCellValue('D' . $row, $row_data['apellidos']);

    if($row_data == 0 || $row_data['idEmpresa']==null){
        $sheet->setCellValue('E' . $row, "Sin empresa asignada");
    }else{
        $sheet->setCellValue('E' . $row, $row_data['nombre_empresa']);
    }
    
    $row++;
}

//Configurar el encabezado del archivo excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="archivo.xlsx"');
header('Cache-Control: max-age=0');

$writer = PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');

// Se cierra la conexion a la base de datos
$conn->close();
?>