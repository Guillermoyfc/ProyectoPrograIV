<?php
session_start();
  $conexion = oci_connect("uca", "123", "localhost/nodo"); 
  if (!$conexion) {
    $m = oci_error();
    echo $m['message'], "\n";
    //La función de error devuelve un mensaje de Oracle.
  exit; }
  $query = "SELECT NOM_USUARIO, ID_USUARIO  FROM USUARIO WHERE NOM_USUARIO=:usuario AND CONTRASENA=:contrasena"; 
  //La consulta se envía a la base de datos para obtener la identificación de la fila.
  $stid = oci_parse($conexion, $query);
  if (isset($_POST['usuario'])||isset($_POST['contrasena'])){           
    $name=$_POST['usuario'];
    $pass=$_POST['contrasena'];
  }
  oci_bind_by_name($stid, ':usuario', $name);
  oci_bind_by_name($stid, ':contrasena', $pass);
  oci_execute($stid);
  $row = oci_fetch_array($stid, OCI_ASSOC);

  if ($row) {
    $_SESSION['usuario']=$_POST['usuario'];
    echo"log in successful";
    }
  else {
  echo("The person " . $name . " is not found .
  Please check the spelling and try again or check password");
  exit;}
  $ID = $row['ID_USUARIO']; 
  oci_free_statement($stid);
  oci_close($conexion);
  header('Location: Menu.php');

?>