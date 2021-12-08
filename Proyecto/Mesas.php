<?php
/////////////////////////////////////////////////////////////////////////////////////////CONEXION DE ORACLE
    $conexion = oci_connect("uca", "123", "localhost/nodo"); 
    if (!$conexion) {
        $m = oci_error();
        echo $m['message'], "\n";
    //La función de error devuelve un mensaje de Oracle.
    exit; }
    if (isset($_POST['id_mesa'])){
        $p1 = $_POST['id_mesa'];
        $p2 = $_POST['id_rest'];
        $p3 = $_POST['cant_sillas'];
        $p4 = '';
        $stid = oci_parse($conexion, 'begin PKG_MESA.INSERTAR_MESA(:p1, :p2, :p3, :p4); end;');
        oci_bind_by_name($stid, ':p1', $p1);
        oci_bind_by_name($stid, ':p2', $p2);
        oci_bind_by_name($stid, ':p3', $p3);
        oci_bind_by_name($stid, ':p4', $p4);
        $r = oci_execute($stid);
        if ($r) {
            print "insertada la mesa: ".$p1;
        }
        oci_free_statement($stid);
    }
//////////////////////////////////////////////////////////////////////////////////SELECT DEL CLIENTE
    $consulta = "SELECT * FROM MESA";
    $query = oci_parse($conexion, $consulta);
    $array = oci_execute($query);

    $consulta1 = "SELECT ID_REST, DESC_REST FROM RESTAURANTE";
    $query1 = oci_parse($conexion, $consulta1);
    $array1 = oci_execute($query1);
///////////////////////////////////////////////////////////////////////Eliminar el cliente
    if (isset($_POST['CD_eliminar'])) {
        $p1 = $_POST['CD_eliminar'];
        $p2 = '';
        $stid = oci_parse($conexion, 'begin PKG_MESA.ELIMINAR_MESA(:p1, :p2); end;');
        oci_bind_by_name($stid, ':p1', $p1);
        oci_bind_by_name($stid, ':p2', $p2);
        $r = oci_execute($stid);
        if ($r) {
            print "Eliminada la mesa: ".$p1;
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
        <title>Clientes</title>
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Bitter:wght@400;700&display=swap" rel="stylesheet">
    </head>
    <body>
        <div class="container-fluid">
            <div class="row justify-content-center align-items-center">
                <div class="col-6">
                    <h2 class="text-center">Lista de Mesas</h2>
                    <div class="table-responsive">          
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Codigo de la Mesa</th>
                                    <th>codigo del restaurante</th>
                                    <th>Cantidad de sillas</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                while (($row = oci_fetch_array($query, OCI_BOTH))!=false) {
                                ?> 
                                <tr>
                                    <td><?php echo $row["ID_MESA"]; ?> </td>
                                    <td><?php echo $row["ID_REST"]; ?></td>
                                    <td><?php echo $row["CANT_SILLAS"]; ?></td>
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
                        <form action="Mesas.php" class="form-horizontal" method="post">
                            <fieldset>
                                <h2>Agregar Mesa</h2>
                                <div class="form-group">
                                    <span class="col-md-1 col-md-offset-2 text-center"><i class="fa fa-user bigicon"></i></span>
                                    <div class="col-md-12">
                                        <input id="id_mesa" name="id_mesa" type="text" placeholder="Codigo de la Mesa" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <span class="col-md-1 col-md-offset-2 text-center"><i class="fa fa-phone-square bigicon"></i></span>
                                    <div class="col-md-12">
                                        <input id="cant_sillas" name="cant_sillas" type="text" placeholder="Cantidad de sillas" class="form-control">
                                    </div>
                                </div>
                                <div>
                                    <select class="form-select" id="id_rest" name="id_rest" aria-label="Default select example">
                                        <option selected>Seleccione un restaurante</option>
                                        <tbody>
                                        <?php 
                                        while (($row = oci_fetch_array($query1, OCI_BOTH))!=false) {
                                            ?> 
                                            <tr>
                                                <td><?php echo "<option value='".$row['ID_REST']."' -> ".$row['DESC_REST'].""; ?> </td>
                                            </tr>
                                            </tbody>
                                            <?php 
                                            } 
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-primary btn-md">Guardar Mesa</button>
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
                        <form action="Mesas.php" class="form-horizontal" method="post">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Eliminar Cliente</button>
                        <!-- Modal -->
                        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Eliminar Mesa</h5>
                                <button type="button" class="btn-cerrar" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body">
                                ingrese el numero de codigo de la mesa que desee eliminar
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
            <div class="row justify-content-md-end py-5">
                <div class="col text-center fw-light">
                    <a class="btn" href="Menu.php">Salir</a>
                </div>
            </div>
        </div>
    </div>
        <script src="js/bootstrap.js"></script>
    </body>
</html>
