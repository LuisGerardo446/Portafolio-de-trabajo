<?php
include("../../templates/conexion.php");
session_start(); // Inicia la sesión si no ha sido iniciada antes

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    // Si el usuario no ha iniciado sesión, redirigirlo a la página de inicio de sesión
    header('Location: /dual/login.php');
    exit;
}

// Luego, obtenemos los datos del usuario actual utilizando su usuario
$usuario = $_SESSION['usuario']; // Obtén el usuario del usuario actual de la sesión
$query = "SELECT *, idAdministrador FROM administradores WHERE usuario = '$usuario'";
$result = $conn->query($query);

// Verificamos si la consulta se realizó correctamente
if (!$result) {
    die("Error al obtener los datos del usuario: " . $conn->error);
}

// Verificamos si se encontró algún resultado en la consulta
if ($result->num_rows > 0) {
    // Obtenemos los datos del usuario y los guardamos en la variable $usuario
    $usuario = $result->fetch_assoc();
    $_SESSION['idAdministrador'] = $usuario['idAdministrador'];
    // Cerramos la conexión a la base de datos

    // Verificamos si la variable $usuario tiene datos antes de acceder a sus índices
    if ($usuario) {
        $nombres = $usuario['nombres'];
    } else {
        // Manejar el caso en el que $usuario es nulo
        die("Usuario no encontrado");
    }
} else {
    // Manejar el caso en el que no se encontraron resultados
    die("Usuario no encontrado");
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../assets/img/utsc_dual_logo.png" rel="icon">
    <link href="../../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link href="../../assets/vendor/animate.css/animate.min.css" rel="stylesheet">
    <link href="../../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="../../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="../../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="../../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="../../assets/css/style.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
<link href="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/3.0.0/css/buttons.bootstrap4.min.css" rel="stylesheet">

<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/2.0.1/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.0.1/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.0/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.0/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>

    <title>Alumnos</title>
</head>

<body>
    <header id="header" class="fixed-top2 header-inner-pages">
        <div class="container d-flex align-items-center justify-content-between">
            <a href="/dual/index.php" class="logo"><img src="../../assets/img/log-bar2.png" alt=""
                    class="img-fluid"></a>
            <!-- Uncomment below if you prefer to use an image logo -->
            <!-- <a href="index.html" class="logo"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class="scrollto efectoboton" href="crear.php">Agregar alumno</a></li>
                    <li><a class="scrollto efectoboton" href="../../menu_admin.php">Regresar</a></li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav>
        </div>
    </header>
    <main class="container mt-4" style="max-width: 1600px;">
        <br>
        <h1 class="mb-4 text-center" style="font-size: 68px; font-weight:800;">Alumnos Dual</h1>
        <br>
        <br>
        <h2>Generar reporte:</h2>
        <form action="" method="post">
            <select id="selecciondefuncion">
            <option value="funcion1">nombre del alumno, carrera y empresa</option>
            <option value="funcion2">solo carrera ingenieria</option>
            <option value="funcion3">solo carrera TSU</option>
            <option value="funcion4">Por fecha de ingreso </option>
            <option value="funcion5">Por fecha de terminacion </option>
            <option value="funcion6">Por Giro de la empresa </option>
            <option value="funcion7">Por Corporativos </option>
            <option value="funcion8">Por Servicios educativos </option>
            <option value="funcion9">Por Servicios de salud y de asistencia social </option>
            <option value="funcion10">Usuario formador </option>
            <option value="funcion11">Usuario instructor </option>
            <option value="funcion12">Usuario alumnos </option>
            <option value="funcion13">Usuario docentes </option>
            <option value="funcion14">Usuario tutores </option>
            <option value="funcion15">Usuario subdirectores </option>
            <option value="funcion16">Usuario administradores </option>
            </select>
            <button type="button" id="miboton" onclick="ejecutarFuncion()">Generar Archivo</button>
        </form>
        <br>
        <br>
        <form action="visualizar_excel.php" method="post" enctype="multipart/form-data">
        <input type="file" name="excel_file" accept=".xlsx, .xls">
        <button type="submit" name="submit">Visualizar Excel</button>
        </form>
       
        <script>
            function ejecutarFuncion(){
                // Obtenemos el valor selecionado del select
                var seleccion = document.getElementById("selecciondefuncion").value;

                switch (seleccion) {
                case 'funcion1':
                    generarArchivo();
                    break;
                case 'funcion2':
                    generarArchivoCarrera();
                    break;
                case 'funcion3':
                    generarArchivoCarreraTsu();
                    break;
                case 'funcion4':
                    generarArchivoingreso();
                    break;
                case 'funcion5':
                    generarArchivoterminacion();
                break;
                case 'funcion6':
                    generarArchivogiro();
                break;
                case 'funcion7':
                    generarporcorporativos();
                break;
                case 'funcion8':
                    generarporserviciosedu();
                break;
                case 'funcion9':
                    generarporserviciosdesalud();
                break;
                case 'funcion10':
                    generarUsuario();
                break;
                case 'funcion11':
                    generarUsuarioInstructor();
                break;
                case 'funcion12':
                    generarUsuarioAlumnos();
                break;
                case 'funcion13':
                    generarUsuarioDocentes();
                break;
                case 'funcion14':
                    generarUsuarioTutores();
                break;
                case 'funcion15':
                    generarUsuarioSubdirectores();
                break;
                case 'funcion16':
                    generarUsuarioAdministrador();
                break;
                default:
                    console.log('Función no definida');
            }
        }
        // Genera un archivo con los datos del alumno
        function generarArchivo() {
            // Realizar una solicitud al servidor para generar el archivo
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'generar_archivoexcel.php', true);
            xhr.responseType = 'blob'; // Esperamos una respuesta binaria
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Genera un link de descarga del archivo
                    var enlace = document.createElement('a');
                    enlace.href = window.URL.createObjectURL(xhr.response);
                    enlace.download = 'Datos del alumno.xlsx';
                    document.body.appendChild(enlace);
                    enlace.click();
                    document.body.removeChild(enlace);
                }
            };
            xhr.send();
        }
        // Genera un archivo de los alumnos con la carrera de ingenieria
        function generarArchivoCarrera() {
            // Realizar una solicitud al servidor para generar el archivo
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'archivo_solocarrerainge.php', true);
            xhr.responseType = 'blob'; // Esperamos una respuesta binaria
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Genera un link de descarga del archivo
                    var enlace = document.createElement('a');
                    enlace.href = window.URL.createObjectURL(xhr.response);
                    enlace.download = 'Solo carrera ingenieria.xlsx';
                    document.body.appendChild(enlace);
                    enlace.click();
                    document.body.removeChild(enlace);
                }
                
            };
            xhr.send();
        }

        // Genera un archivo de los alumnos con la carrera de TSU
        function generarArchivoCarreraTsu() {
            // Realizar una solicitud al servidor para generar el archivo
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'archivo_solocarreratsu.php', true);
            xhr.responseType = 'blob'; // Esperamos una respuesta binaria
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Genera un link de descarga del archivo
                    var enlace = document.createElement('a');
                    enlace.href = window.URL.createObjectURL(xhr.response);
                    enlace.download = 'Solo carrera TSU.xlsx';
                    document.body.appendChild(enlace);
                    enlace.click();
                    document.body.removeChild(enlace);
                }
                
            };
            xhr.send();
        }

        // Genera un archivo de los alumnos por la fecha de ingreso
        function generarArchivoingreso() {
            // Realizar una solicitud al servidor para generar el archivo
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'archivo_ingreso.php', true);
            xhr.responseType = 'blob'; // Esperamos una respuesta binaria
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Genera un link de descarga del archivo
                    var enlace = document.createElement('a');
                    enlace.href = window.URL.createObjectURL(xhr.response);
                    enlace.download = 'fechas de ingreso.xlsx';
                    document.body.appendChild(enlace);
                    enlace.click();
                    document.body.removeChild(enlace);
                }
                
            };
            xhr.send();
        }

            // Genera un archivo de los alumnos por la fecha de terminacion
        function generarArchivoterminacion() {
            // Realizar una solicitud al servidor para generar el archivo
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'archivo_terminacion.php', true);
            xhr.responseType = 'blob'; // Esperamos una respuesta binaria
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Genera un link de descarga del archivo
                    var enlace = document.createElement('a');
                    enlace.href = window.URL.createObjectURL(xhr.response);
                    enlace.download = 'fecha de terminacion.xlsx';
                    document.body.appendChild(enlace);
                    enlace.click();
                    document.body.removeChild(enlace);
                }
                
            };
            xhr.send();
        }

        // Genera un archivo por giro de la empresa 
        function generarArchivogiro() {
            // Realizar una solicitud al servidor para generar el archivo
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'archivo_giroempresa.php', true);
            xhr.responseType = 'blob'; // Esperamos una respuesta binaria
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Genera un link de descarga del archivo
                    var enlace = document.createElement('a');
                    enlace.href = window.URL.createObjectURL(xhr.response);
                    enlace.download = 'Giro de la empresa.xlsx';
                    document.body.appendChild(enlace);
                    enlace.click();
                    document.body.removeChild(enlace);
                }
                
            };
            xhr.send();
        }

        function generarUsuario() {
            // Realizar una solicitud al servidor para generar el archivo
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'archivo_usuario.php', true);
            xhr.responseType = 'blob'; // Esperamos una respuesta binaria
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Genera un link de descarga del archivo
                    var enlace = document.createElement('a');
                    enlace.href = window.URL.createObjectURL(xhr.response);
                    enlace.download = 'Usuarios Formador.xlsx';
                    document.body.appendChild(enlace);
                    enlace.click();
                    document.body.removeChild(enlace);
                }
            };
            xhr.send();
        }

        function generarUsuarioInstructor() {
            // Realizar una solicitud al servidor para generar el archivo
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'archivo_usuarioinstructor.php', true);
            xhr.responseType = 'blob'; // Esperamos una respuesta binaria
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Genera un link de descarga del archivo
                    var enlace = document.createElement('a');
                    enlace.href = window.URL.createObjectURL(xhr.response);
                    enlace.download = 'Usuarios Instructor.xlsx';
                    document.body.appendChild(enlace);
                    enlace.click();
                    document.body.removeChild(enlace);
                }
            };
            xhr.send();
        }

        function generarUsuarioAlumnos() {
            // Realizar una solicitud al servidor para generar el archivo
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'archivo_usuarioalumno.php', true);
            xhr.responseType = 'blob'; // Esperamos una respuesta binaria
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Genera un link de descarga del archivo
                    var enlace = document.createElement('a');
                    enlace.href = window.URL.createObjectURL(xhr.response);
                    enlace.download = 'Usuarios Alumnos.xlsx';
                    document.body.appendChild(enlace);
                    enlace.click();
                    document.body.removeChild(enlace);
                }
            };
            xhr.send();
        }

        function generarUsuarioDocentes() {
            // Realizar una solicitud al servidor para generar el archivo
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'archivo_usuariodocente.php', true);
            xhr.responseType = 'blob'; // Esperamos una respuesta binaria
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Genera un link de descarga del archivo
                    var enlace = document.createElement('a');
                    enlace.href = window.URL.createObjectURL(xhr.response);
                    enlace.download = 'Usuarios Docentes.xlsx';
                    document.body.appendChild(enlace);
                    enlace.click();
                    document.body.removeChild(enlace);
                }
            };
            xhr.send();
        }

        function generarUsuarioTutores() {
            // Realizar una solicitud al servidor para generar el archivo
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'archivo_usuariotutores.php', true);
            xhr.responseType = 'blob'; // Esperamos una respuesta binaria
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Genera un link de descarga del archivo
                    var enlace = document.createElement('a');
                    enlace.href = window.URL.createObjectURL(xhr.response);
                    enlace.download = 'Usuarios Tutores.xlsx';
                    document.body.appendChild(enlace);
                    enlace.click();
                    document.body.removeChild(enlace);
                }
            };
            xhr.send();
        }

            function generarUsuarioSubdirectores() {
            // Realizar una solicitud al servidor para generar el archivo
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'archivo_usuariosubdirector.php', true);
            xhr.responseType = 'blob'; // Esperamos una respuesta binaria
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Genera un link de descarga del archivo
                    var enlace = document.createElement('a');
                    enlace.href = window.URL.createObjectURL(xhr.response);
                    enlace.download = 'Usuarios Subdirectores.xlsx';
                    document.body.appendChild(enlace);
                    enlace.click();
                    document.body.removeChild(enlace);
                }
            };
            xhr.send();
        }

        function generarUsuarioAdministrador() {
            // Realizar una solicitud al servidor para generar el archivo
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'archivo_usuarioadministrador.php', true);
            xhr.responseType = 'blob'; // Esperamos una respuesta binaria
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Genera un link de descarga del archivo
                    var enlace = document.createElement('a');
                    enlace.href = window.URL.createObjectURL(xhr.response);
                    enlace.download = 'Usuarios Administradores.xlsx';
                    document.body.appendChild(enlace);
                    enlace.click();
                    document.body.removeChild(enlace);
                }
            };
            xhr.send();
        }

        function generarporcorporativos() {
            // Realizar una solicitud al servidor para generar el archivo
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'archivo_girocorporativos.php', true);
            xhr.responseType = 'blob'; // Esperamos una respuesta binaria
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Genera un link de descarga del archivo
                    var enlace = document.createElement('a');
                    enlace.href = window.URL.createObjectURL(xhr.response);
                    enlace.download = 'Giro corporativos.xlsx';
                    document.body.appendChild(enlace);
                    enlace.click();
                    document.body.removeChild(enlace);
                }
            };
            xhr.send();
        }

        function generarporserviciosedu() {
            // Realizar una solicitud al servidor para generar el archivo
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'archivo_giroserviciosedu.php', true);
            xhr.responseType = 'blob'; // Esperamos una respuesta binaria
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Genera un link de descarga del archivo
                    var enlace = document.createElement('a');
                    enlace.href = window.URL.createObjectURL(xhr.response);
                    enlace.download = 'Giro Servicios educativos.xlsx';
                    document.body.appendChild(enlace);
                    enlace.click();
                    document.body.removeChild(enlace);
                }
            };
            xhr.send();
        }

        function generarporserviciosdesalud() {
            // Realizar una solicitud al servidor para generar el archivo
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'archivo_girosalud.php', true);
            xhr.responseType = 'blob'; // Esperamos una respuesta binaria
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Genera un link de descarga del archivo
                    var enlace = document.createElement('a');
                    enlace.href = window.URL.createObjectURL(xhr.response);
                    enlace.download = 'Giro Servicios de salud y de asistencia social.xlsx';
                    document.body.appendChild(enlace);
                    enlace.click();
                    document.body.removeChild(enlace);
                }
            };
            xhr.send();
        }

        </script>


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
                                <th>Carrera</th>
                                <th>Cuatrimestre</th>
                                <th>Estatus</th>
                                <th>Matrícula</th>
                                <th>Alumno</th>
                                <th>Duración</th>
                                <th>Empresa</th>
                                <th style="width: 50px !important;">Fecha de la baja</th>
                                <th style="width: 50px !important;">Ingreso</th>
                                <th style="width: 50px !important;">Fecha Fin</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
include("../../templates/conexion.php");

$query = "SELECT alumnos.*, empresas.nombreEmp AS nombre_empresa FROM alumnos LEFT JOIN empresas ON alumnos.idEmpresa = empresas.idEmpresa ORDER BY alumnos.idAlumno";
$respuesta = mysqli_query($conn, $query);

while ($registro = mysqli_fetch_array($respuesta)) {
    echo ("<tr>");
    echo ("<td>$registro[idAlumno]</td>");
    echo ("<td>$registro[carrera]</td>");
    echo ("<td>$registro[cuatrimestre]</td>");
    $estatus = $registro['estatus_alumno'];
    $color = '';
    if ($estatus == 'Activo') {
        $color = '#70cc06';
    }elseif ($estatus == 'Baja' or $estatus == 'Suspendido') {
        $color = '#FF4444';
    }elseif($estatus == 'Contratado'){
        $color = '#3383FF';
    }elseif ($estatus == 'En proceso') {
        $color = '#FFDD33';
    } elseif ($estatus == 'Finalizado') {
        $color = '#444';
    }
    echo ("<td style='background-color: $color; color: #fff'>$estatus</td>");
    echo ("<td>$registro[matricula]</td>");
    echo ("<td>$registro[apellidos] $registro[nombres]</td>");
    echo ("<td>$registro[duracion]</td>");

    // Verificar si idEmpresa es 0 o nulo
    if ($registro['idEmpresa'] == 0 || $registro['idEmpresa'] == null) {
        echo ("<td>Sin empresa asignada</td>");
    } else {
        echo ("<td>$registro[nombre_empresa]</td>");
    }
    echo ("<td>$registro[fecha_baja]</td>");
    echo ("<td>$registro[ingreso]</td>");
    $fechaFin = $registro['fecha_fin'];
    $hoy = date('Y-m-d');
    $diasRestantes = intval((strtotime($fechaFin) - strtotime($hoy)) / (60 * 60 * 24));

    $recuadroColor = '';
    $textoColor = '';
    if ($diasRestantes < 0) {
        $recuadroColor = '#FF4444'; // Fecha pasada
        $textoColor = '#FFF';
    } elseif ($diasRestantes <= 10) {
        $recuadroColor = '#FFBB33'; // Faltan 10 días o menos
        $textoColor = '#FFF';
    }

    echo ("<td style='background-color: $recuadroColor; color: $textoColor;'>$registro[fecha_fin]</td>");
    echo ("<td>
        <div class='btn-group'>
            <a class='btn btn-primary btn-sm mr-1' href='editar.php?idAlumno=$registro[idAlumno]'>Editar</a>
            <a class='btn btn-secondary btn-sm mr-1' href='cambiar_estatus.php?idAlumno=$registro[idAlumno]'>Estatus</a>
            |
            <a class='btn btn-danger btn-sm mr-1' href='borrar.php?idAlumno=$registro[idAlumno]' onclick='confirmarEliminacion(event)'>Eliminar</a>
        </div>
    </td>");
    echo ("</tr>");
}
?>
                            <script>
                            function confirmarEliminacion(event) {
                                event.preventDefault();

                                Swal.fire({
                                    title: '¿Estás seguro?',
                                    text: 'Esta acción no se puede deshacer',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Sí, eliminar',
                                    cancelButtonText: 'Cancelar'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = event.target.href;
                                    }
                                });
                            }
                            </script>

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </main>
    <?php
    include("../../templates/footer_secciones.php");
    ?>
    <script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="../../assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="../../assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="../../assets/vendor/waypoints/noframework.waypoints.js"></script>


    <!-- DataTables -->
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
    
</body>

</html>