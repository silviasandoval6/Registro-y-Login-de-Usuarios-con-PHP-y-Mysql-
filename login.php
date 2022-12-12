<?php
  //Abrimos la sesion de la base de datos
  session_start();
  // Comprobamos si existe la variable sesion y si contiene la variable user_id
  if (isset($_SESSION['user_id'])) {
    header('Location: /php-login');
  }
  //Llamamos al documento encargado de realizar la conexión con la base de datos
  require 'database.php';
  //Comprobamos que las variables obtenidas no estén vacías
  if (!empty($_POST['email']) && !empty($_POST['password'])) {
	//Realizamos una consulta a la base de datos solicitando el id, email y password, guardandolos en la variable records
    $records = $conn->prepare('SELECT id, email, password FROM users WHERE email = :email');
	//Vinculamos el parámetro :email con lo que tengamos en la variable con la función POST
    $records->bindParam(':email', $_POST['email']);
	//Ejecutamos la query
    $records->execute();
	//Creamos la variable results relacionándolo los datos de la consulta
    $results = $records->fetch(PDO::FETCH_ASSOC);

	//Inicializamos una variable mensaje vacía
    $message = '';
    // Comprobamos que la variable resultado esté llena y comparamos las dos contraseñas para ver si coinciden
    if (count($results) > 0 && password_verify($_POST['password'], $results['password'])) {
	  //Guardamos los datos de la consulta en la variable sesión, concretamente el user_id
      $_SESSION['user_id'] = $results['id'];
	  //Ponemos el header
      header("Location: /php-login");
    } else {
	//Ponemos el mensaje en caso de error en las credenciales
      $message = 'Sorry, those credentials do not match';
    }
  }

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
	<!--Ponemos el título de la pestaña-->
    <title>Login</title>
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
	<!--Damos a elegir entre Login o registrarse llamando al archivo php signup-->
    <h1>Login</h1>
    <span>or <a href="signup.php">SignUp</a></span>
	<!--Creamos un formulario que llame al mismo archivo login para obtener el email password y finalmente poner un submit 
	para enviarlo -->
    <form action="login.php" method="POST">
      <input name="email" type="text" placeholder="Enter your email">
      <input name="password" type="password" placeholder="Enter your Password">
      <input type="submit" value="Submit">
    </form>
  </body>
</html>
