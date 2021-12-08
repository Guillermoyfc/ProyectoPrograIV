<?php
/////////////////////////////////////////////////////////////////////////////////////////CONEXION DE ORACLE
    $conexion = oci_connect("uca", "123", "localhost/nodo"); 
    if (!$conexion) {
        $m = oci_error();
        echo $m['message'], "\n";
    //La función de error devuelve un mensaje de Oracle.
    exit; }
    ///////////////////////////////////////////////////////////////////////////////////////////////funciones
    function phpAlert($msg) {
        echo '<script type="text/javascript">alert("' . $msg . '")</script>';
    }
    //////////////////////////////////////////////////////////////////////////////////////////////////Insert DB
    if (isset($_POST['codigo'])){
        $p1 = $_POST['codigo'];
        $p2 = $_POST['rol'];
        $p3 = $_POST['nombre'];
        $p4 = $_POST['contrasena'];
        $p5 = '';
        $stid = oci_parse($conexion, 'begin PKG_USUARIO.INSERTAR_USUARIO(:p1, :p2, :p3, :p4, :p5); end;');
        oci_bind_by_name($stid, ':p1', $p1);
        oci_bind_by_name($stid, ':p2', $p2);
        oci_bind_by_name($stid, ':p3', $p3);
        oci_bind_by_name($stid, ':p4', $p4);
        oci_bind_by_name($stid, ':p5', $p5);
        $r = oci_execute($stid);
        if ($r) {
            phpAlert('Insertado el usuario codigo:  '.$p1);
        }
        oci_free_statement($stid);
    }
//////////////////////////////////////////////////////////////////////////////////SELECT DEL usuario
$consulta = "SELECT * FROM usuario";
$query = oci_parse($conexion, $consulta);
$array = oci_execute($query);
///////////////////////////////////////////////////////////////////////Eliminar el usuario
    if (isset($_POST['CD_eliminar'])) {
        $p1 = $_POST['CD_eliminar'];
        $p2 = '';
        $stid = oci_parse($conexion, 'begin PKG_usuario.ELIMINAR_usuario(:p1, :p2); end;');
        oci_bind_by_name($stid, ':p1', $p1);
        oci_bind_by_name($stid, ':p2', $p2);
        $r = oci_execute($stid);
        if ($r) {
            phpAlert('Eliminado el usuario codigo:  '.$p1);
        }
    }
    $array = oci_execute($query);

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Usuarios</title>
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Bitter:wght@400;700&display=swap" rel="stylesheet">
    </head>
    <body>
        <div class="container-fluid pt-5">
            <div class="row justify-content-center align-items-center">
                <div class="col-6">
                    <h2 class="text-center">Lista de usuarios</h2>
                    <div class="table-responsive">          
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Codigo Usuario</th>
                                    <th>ID rol</th>
                                    <th>Nombre</th>
                                    <th>Contrasena</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                while (($row = oci_fetch_array($query, OCI_BOTH))!=false) {
                                ?> 
                                <tr>
                                    <td><?php echo $row["ID_USUARIO"]; ?> </td>
                                    <td><?php echo $row["ID_ROL"]; ?></td>
                                    <td><?php echo $row["NOM_USUARIO"]; ?></td>
                                    <td><?php echo $row["CONTRASENA"]; ?></td>
                                </tr>
                            </tbody>
                            <?php 
                                } 
                            ?>
                        </table>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="well well-sm">
                        <form action="Usuarios.php" class="form-horizontal" method="post">
                            <fieldset>
                                <h2>Agregar Usuario</h2>
                                <div class="form-group">
                                    <span class="col-md-1 col-md-offset-2 text-center"><i class="fa fa-user bigicon"></i></span>
                                    <div class="col-md-10">
                                        <input id="codigo" name="codigo" type="text" placeholder="Codigo" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <span class="col-md-1 col-md-offset-2 text-center"><i class="fa fa-user bigicon"></i></span>
                                    <div class="col-md-10">
                                        <input id="rol" name="rol" type="text" placeholder="Numero de Rol" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <span class="col-md-1 col-md-offset-2 text-center"><i class="fa fa-phone-square bigicon"></i></span>
                                    <div class="col-md-10">
                                        <input id="nombre" name="nombre" type="text" placeholder="Nombre" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <span class="col-md-1 col-md-offset-2 text-center"><i class="fa fa-envelope-o bigicon"></i></span>
                                    <div class="col-md-10">
                                        <input id="email" name="contrasena" type="text" placeholder="Contrasena" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-primary btn-md">Guardar usuario</button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center align-items-center pt-5">
                <div class="col-2 ">
                <div class="col-md-12">
                    <div class="well well-sm">
                        <form action="usuarios.php" class="form-horizontal" method="post">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Eliminar usuario</button>
                        <!-- Modal -->
                        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Eliminar usuario</h5>
                                <button type="button" class="btn-cerrar" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body">
                                ingrese el numero de codigo de usuario que desee eliminar
                                <input id="CD_eliminar" name="CD_eliminar" type="text" placeholder="Codigo a Eliminar" class="form-control">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Eliminar</button>
                            </div>
                            </div>
                        </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="footer" class="p-5">
        <div class="container w-50 pt-5">
            <div class="row justify-content-md-center py-5">
                <div class="col text-center fw-light">
                    <a class="btn" href="Menu.php">Salir</a>
                </div>
            </div>
        </div>
        <script src="js/bootstrap.js"></script>
    </body>
</html>