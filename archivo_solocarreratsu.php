<?php
include("../../templates/conexion.php");
require '../../vendor/autoload.php'; 

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;



// Consulta SQL para obtener datos de la base de datos
$query = "SELECT alumnos.*, 
empresas.nombreEmp AS nombre_empresa 
FROM alumnos 
INNER JOIN empresas ON alumnos.idEmpresa = empresas.idEmpresa 
WHERE carrera IN (7,8,9,10,11,12)
ORDER BY alumnos.idAlumno";
$resultado = $conn->query($query);

// Crear un nuevo objeto PhpSpreadsheet
$spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Se modifica el ancho de la columna
$sheet->getColumnDimension('B')->setWidth(50); // Establecer el ancho de la columna A a 20
$sheet->getColumnDimension('C')->setWidth(20); 
$sheet->getColumnDimension('D')->setWidth(20); 
$sheet->getColumnDimension('E')->setWidth(30); 
$sheet->getColumnDimension('F')->setWidth(20); 
$sheet->getColumnDimension('I')->setWidth(20);
$sheet->getColumnDimension('J')->setWidth(20);
$sheet->getColumnDimension('K')->setWidth(20);

// Agregar encabezados
$sheet->setCellValue('A1', 'ID');
$sheet->setCellValue('B1', 'Carrera');
$sheet->setCellValue('C1', 'Nombre');
$sheet->setCellValue('D1', 'Apellido');
$sheet->setCellValue('E1', 'Empresa');
$sheet->setCellValue('F1', 'Estatus');
$sheet->setCellValue('G1', 'Cuatrimestre');
$sheet->setCellValue('H1', 'Duracion');
$sheet->setCellValue('I1', 'Fecha de la baja');
$sheet->setCellValue('J1', 'Fecha de ingreso');
$sheet->setCellValue('K1', 'Fecha de Terminacion');
// Agregar datos desde la base de datos
$row = 2;
while ($row_data = $resultado->fetch_assoc()) {
    $sheet->setCellValue('A' . $row, $row_data['idAlumno']);
    $sheet->setCellValue('B' . $row, $row_data['carrera']);
    $sheet->setCellValue('C' . $row, $row_data['nombres']);
    $sheet->setCellValue('D' . $row, $row_data['apellidos']);
    if ($row_data['idEmpresa'] == 0 || $row_data['idEmpresa'] == null) {
        $sheet->setCellValue('E', 'Sin empresa asignada');
    } else {
        $sheet->setCellValue('E' . $row, $row_data['nombre_empresa']);
    }
    $sheet->setCellValue('F' . $row, $row_data['estatus_alumno']);
    $sheet->setCellValue('G' . $row, $row_data['cuatrimestre']);
    $sheet->setCellValue('H' . $row, $row_data['duracion']);
    $sheet->setCellValue('I' . $row, $row_data['fecha_baja']);
    $sheet->setCellValue('J' . $row, $row_data['ingreso']);
    $sheet->setCellValue('K' . $row, $row_data['fecha_fin']);
    $row++;
}


//Configurar el encabezado del archivo excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="datos.xlsx"');
header('Cache-Control: max-age=0');

$writer = PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');

// Se cierra la conexion a la base de datos
$conn->close();
?>