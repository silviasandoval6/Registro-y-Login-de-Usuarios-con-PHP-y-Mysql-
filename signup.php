<?php
  //Llamamos al documento encargado de realizar la conexión con la base de datos
  require 'database.php';
  //Inicializamos una variable mensaje vacía
  $message = '';
  //Comprobamos que las variables obtenidas no estén vacías
  if (!empty($_POST['email']) && !empty($_POST['password'])) {
	//Creamos la consulta sql que introduce al nuevo usuario
	$sql = "INSERT INTO users (email, password) VALUES (:email, :password)";
	//Creamos variable statement para realizar la conexión a la base de datos
    $stmt = $conn->prepare($sql);
	//Vinculamos el parámetro :email con lo que tengamos en la variable con la función POST
    $stmt->bindParam(':email', $_POST['email']);
	//Encriptamos la variable contraseña obtenida por el método post
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
	//Vinculamos el parámetro :password con lo que tengamos en la variable con la función POST
    $stmt->bindParam(':password', $password);
	//Si se ejecuta bien la consulta aparece un mensaje indicándolo y si ocurre lo contrario también
    if ($stmt->execute()) {
      $message = 'Successfully created new user';
    } else {
      $message = 'Sorry there must have been an issue creating your account';
    }
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
	<!--Ponemos el título de la pestaña-->
    <title>SignUp</title>
	<!--Conseguimos la fuente para estilizar-->
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<!--Creamos la referencia a la hoja de estilos para poder usarla-->
    <link rel="stylesheet" href="assets/css/style.css">
  </head>
  <body>
    <!--Hacemos que se vea el header llamando al documento-->
    <?php require 'partials/header.php' ?>
    <!--Comprobamos que el mensaje no esté vacío y lo ponemos en un parágrafo-->
    <?php if(!empty($message)): ?>
      <p> <?= $message ?></p>
    <?php endif; ?>
    <!--Damos a elegir entre registrars o iniciar sesión llamando al archivo php login-->
    <h1>SignUp</h1>
    <span>or <a href="login.php">Login</a></span>
    <!--Creamos un formulario que llame al mismo archivo login para obtener el email, password, confirmar la contraseña 
	y finalmente poner un submit para enviarlo -->
    <form action="signup.php" method="POST">
      <input name="email" type="text" placeholder="Enter your email">
      <input name="password" type="password" placeholder="Enter your Password">
      <input name="confirm_password" type="password" placeholder="Confirm Password">
      <input type="submit" value="Submit">
    </form>

  </body>
</html>
