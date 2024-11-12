<?php
    include("../../templates/conexion.php");
    if(isset($_GET["idAlumno"])) {
        // Obtener el valor del campo idUsuario de la URL
        $idAlumno = $_GET["idAlumno"];

        // Consulta para obtener los datos del usuario correspondiente
        $query = "SELECT * FROM alumnos WHERE idAlumno = $idAlumno";
        $resultado = mysqli_query($conn, $query);
        $usuario = mysqli_fetch_assoc($resultado);
    }
    session_start(); // Inicia la sesión si no ha sido iniciada antes

    // Verificar si el usuario ha iniciado sesión
    if (!isset($_SESSION['usuario'])) {
        // Si el usuario no ha iniciado sesión, redirigirlo a la página de inicio de sesión
        header('Location: /dual/login.php');
        exit;
    }
    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Estatus Alumnos</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="../../assets/img/utsc_dual_logo.png" rel="icon">
    <link href="../../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="../../assets/vendor/animate.css/animate.min.css" rel="stylesheet">
    <link href="../../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="../../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="../../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="../../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <link href="../../assets/css/style.css" rel="stylesheet">

</head>

<body>
    <header id="header" class="fixed-top2 header-inner-pages">
        <div class="container d-flex align-items-center justify-content-between">
            <a href="/dual/index.php" class="logo"><img src="/dual/assets/img/log-bar2.png" alt="" class="img-fluid"></a>
            <!-- Uncomment below if you prefer to use an image logo -->
            <!-- <a href="index.html" class="logo"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class="scrollto efectoboton" href="alumnos.php">Regresar</a></li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->

        </div>
    </header><!-- End Header -->
    <!-- Formulario para editar los datos del usuario -->
    <div class="container">
        <br />
        <br />
        <h1 class="mb-4 text-center" style="font-size: 68px; font-weight:800;">Estatus alumno</h1>
        <hr>
        <form action="actualizar_estatus.php" method="POST">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <input type="hidden" class="form-control mb-3" name="idAlumno"
                        value="<?php echo $usuario['idAlumno']; ?>">

                    <label for="estatus_alumno">Estatus del alumno:</label>
                    <select class="form-select mb-3" name="estatus_alumno" id="country">
                        <?php
    $opciones = array('Activo', 'En proceso', 'Baja', 'Contratado', 'Suspendido', 'Finalizado');
    foreach ($opciones as $opcion) {
        $selected = ($opcion === $usuario['estatus_alumno']) ? 'selected' : '';
        echo "<option $selected>$opcion</option>";
    }
    ?>
                    </select>
                    <label for="motivo_baja">Motivo de baja:</label>
                    <input type="text" class="form-control mb-3" name="motivo_baja"
                        value="<?php echo $usuario['motivo_baja']; ?>">

                    <label for="observaciones">Observaciones:</label>
                    <input type="text" class="form-control mb-3" name="observaciones"
                        value="<?php echo $usuario['observaciones']; ?>">
                    
                    <label>Fecha de baja:</label>
                    <input type="date" class="form-control mb-3" name="fecha_baja" value="<?php echo date('Y-m-d'); ?>">

                    <?php include("../../templates/conexion.php") ?>
                    <label>Empresa:</label>
                    <select class="form-select mb-3" name="empresa" required>
                        <option value="">...</option>
                        <?php
                    // Realizar una consulta para obtener todas las empresas
                     $queryEmpresas = "SELECT * FROM empresas";
                    $respuestaEmpresas = mysqli_query($conn, $queryEmpresas);

  // Iterar sobre los resultados de la consulta y generar las opciones del select
  while ($empresa = mysqli_fetch_array($respuestaEmpresas)) {
    $idEmpresa = $empresa['idEmpresa'];
    $nombreEmpresa = $empresa['nombreEmp'];
    echo "<option value=\"$idEmpresa\">$nombreEmpresa</option>";
  }
  ?>
                    </select>


                    <div class="d-flex justify-content-center">
                        <a href="alumnos.php" class="btn btn-danger boton boton1 mx-1">Cancelar</a>
                        <input type="submit" class="btn btn-primary mx-1" value="Actualizar">
                    </div>
                </div>
            </div>
            <br/>
            <br/>
    <div class="card">
            <div class="card-body">
                <?php
                        if (isset($_GET['msg'])) {
                            $msg = $_GET['msg'];
                            echo("<div class='alert alert-success'>$msg</div>");
                        }
                    ?>

                <div class="table-responsive text-center table-hover">
                    <table class="table table-responsive-sm text-center table-hover"
                        style="text-align: center !important;" id="tabla_id">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Alumno</th>
                                <th>Empresa</th>
                                <th>Estatus</th>
                                <th style="width: 50px !important;">Fecha de Ingreso</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
include("../../templates/conexion.php");


$query = "SELECT alumnos.*,
empresas.nombreEmp AS nombre_empresa,
alumnos.nombres AS nombresalumno,
alumnos.apellidos AS apellidosalumno
FROM alumnos 
INNER JOIN
empresas ON alumnos.idEmpresa = empresas.idEmpresa
WHERE 
alumnos.idAlumno = $idAlumno 
ORDER BY alumnos.idAlumno";

$respuesta = mysqli_query($conn, $query);

while ($registro = mysqli_fetch_array($respuesta)) {
    echo ("<tr>");
    echo ("<td>$registro[idAlumno]</td>");
    echo ("<td>$registro[nombres] $registro[apellidos]</td>");
    if ($registro['idEmpresa'] == 0 || $registro['idEmpresa'] == null) {
        echo ("<td>Sin empresa asignada</td>");
    } else {
        echo ("<td>$registro[nombre_empresa]</td>");
    }
    echo ("<td>$registro[estatus_alumno]</td>");
    echo ("<td>$registro[ingreso]</td>");
    
}
?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>



            <br/>
            <br/>
            <h2 class="mb-4 text-center" style="font-size: 68px; font-weight:800;">Historial del alumno</h2>
            <div class="card">
            <div class="card-body">
                <?php
                        if (isset($_GET['msg'])) {
                            $msg = $_GET['msg'];
                            echo("<div class='alert alert-success'>$msg</div>");
                        }
                    ?>

                <div class="table-responsive text-center table-hover">
                    <table class="table table-responsive-sm text-center table-hover"
                        style="text-align: center !important;" id="tabla_id">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Alumno</th>
                                <th>Empresa</th>
                                <th>Estatus</th>
                                <th>Motivo de baja</th>
                                <th style="width: 50px !important;">Fecha de baja</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
include("../../templates/conexion.php");
$query = "SELECT estatus_alumno.*,
alumnos.nombres AS nombresalumno,
alumnos.apellidos AS apellidosalumno,
empresas.nombreEmp AS nombre_empresa
FROM estatus_alumno
INNER JOIN 
alumnos ON  estatus_alumno.idAlumno = alumnos.idAlumno
INNER JOIN
empresas ON  estatus_alumno.idEmpresa = empresas.idEmpresa
WHERE estatus_alumno.idAlumno = $idAlumno
ORDER BY estatus_alumno.idAlumno";
$respuesta = mysqli_query($conn, $query);

while ($registro = mysqli_fetch_array($respuesta)) {
    echo ("<tr>");
    echo ("<td>$registro[idEstatus]</td>");
    if ($registro['idAlumno'] == 0 || $registro['idAlumno'] == null) {
        echo ("<td>Sin empresa asignada</td>");
    } else {
        echo ("<td>$registro[nombresalumno] $registro[apellidosalumno]</td>");
    }
    if ($registro['idEmpresa'] == 0 || $registro['idEmpresa'] == null) {
        echo ("<td>Sin empresa asignada</td>");
    } else {
        echo ("<td>$registro[nombre_empresa]</td>");
    }
    echo ("<td>$registro[alumno_estatus]</td>");
    echo ("<td>$registro[motivo_baja]</td>");
    echo ("<td>$registro[fecha_baja]</td>");
}
?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    <br />
    <br />







    <?php
                    include("../../templates/footer.php");
                    ?>
    <div id="preloader"></div>


    <!-- Vendor JS Files -->
    <script src="../../assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="../../assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="../../assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="../../assets/vendor/waypoints/noframework.waypoints.js"></script>
    <script src="../../assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="../../assets/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    
    <script src="../../gestion/js/bootstrap.bundle.js"></script>
    <script src="../../gestion/js/bootstrap.bundle.js"></script>

    <!-- Datatables -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>

    <style>
    .dataTables_wrapper .dataTables_paginate .paginate_button.current,
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover,
    .dataTables_wrapper .dataTables_paginate .paginate_button.next:hover,
    .dataTables_wrapper .dataTables_paginate .paginate_button.previous:hover {
        background: none !important;
        border: none !important;
        box-shadow: none !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        display: flex;
        align-items: center;
        justify-content: flex-start;
    }

    .dataTables_wrapper .dataTables_length label,
    .dataTables_wrapper .dataTables_filter label {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .dataTables_wrapper .dataTables_filter input[type="search"] {
        flex: 1;
    }

    .dataTables_wrapper .dataTables_length select {

        padding-right: 30px;

    }

    .table td {
        padding: 20px !important;
        /* Ajusta el espacio en blanco según tus necesidades */
        background: #fff;
    }

    .table th {
        text-align: center !Important;
    }

    .pagination {
        --bs-pagination-padding-x: 0.75rem;
        --bs-pagination-padding-y: 0.375rem;
        --bs-pagination-font-size: 1rem;
        --bs-pagination-color: #fff;
        --bs-pagination-bg: #70cc06;
        --bs-pagination-border-width: 4px;
        --bs-pagination-border-color: #2e9b0f;
        --bs-pagination-border-radius: 0.375rem;
        --bs-pagination-hover-color: #fff;
        --bs-pagination-hover-bg: #70cc06;
        --bs-pagination-hover-border-color: #2e9b0f;
        --bs-pagination-focus-color: #fff;
        --bs-pagination-focus-bg: #70cc06;
        --bs-pagination-focus-box-shadow: #70cc06;
        --bs-pagination-active-color: #fff;
        --bs-pagination-active-bg: #2e9b0f;
        --bs-pagination-active-border-color: #70cc06;
        --bs-pagination-disabled-color: #6c757d;
        --bs-pagination-disabled-bg: #fff;
        --bs-pagination-disabled-border-color: #fff;
        display: flex;
        padding-left: 0;
        list-style: none;
    }
    </style>
        </form>
    </div>

    
    

</body>
</html>
