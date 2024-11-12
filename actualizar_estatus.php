<?php
include("../../templates/conexion.php");
if(isset($_POST["idAlumno"])) {
    // Obtener los valores actualizados de los campos de entrada del formulario
    $idAlumno = $_POST["idAlumno"];
    $empresa = $_POST["empresa"];
    $estatus_alumno = $_POST["estatus_alumno"];
    $motivo_baja = $_POST["motivo_baja"];
    $fecha_baja = $_POST["fecha_baja"];
    $observaciones = $_POST["observaciones"];
    // Consulta para actualizar los datos del usuario correspondiente
    
    $query = "INSERT INTO estatus_alumno(idAlumno,idEmpresa,alumno_estatus,fecha_baja,motivo_baja) VALUES ('$idAlumno','$empresa','$estatus_alumno','$fecha_baja','$motivo_baja')";
    mysqli_query($conn, $query);

    $query = "UPDATE alumnos SET 
    estatus_alumno= '$estatus_alumno',
    motivo_baja= '$motivo_baja',
    observaciones= '$observaciones',
    fecha_baja = '$fecha_baja'
    WHERE idAlumno = $idAlumno";
    mysqli_query($conn, $query);
    // Redirigir a la página de inicio
    header("Location: alumnos.php");
    exit();
}
?>

