<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styleLogin.css">
    <title>Login</title>
</head>
<body>
    <div class="wrapper fadeInDown">
        <div id="formContent">
          <!-- Tabs Titles -->
          <h2 class="active"> Ingreso </h2>
          <!-- Login Form -->
          <form action="scrip.php" method="post">
            <input type="text" id="login" class="fadeIn second" name="usuario" placeholder="Usuario">
            <input type="password" id="password" class="fadeIn third" name="contrasena" placeholder="Contrase&ntilde;a">
            <input type="submit" class="fadeIn fourth" value="Ingresar">
          </form>
        </div>
      </div>
</body>
</html>


