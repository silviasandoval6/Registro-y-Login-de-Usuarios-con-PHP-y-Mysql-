<?php
//Inicializamos las variables servidor, usuario, contraseña y la variable con el nombre de la base da datos que usaremos
$server = 'localhost:3307';
$username = 'root';
$password = '';
$database = 'php_login_database';

//Intentamos realizar la conexión y matamos el proceso en caso de error con la variable $e
try {
  $conn = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
} catch (PDOException $e) {
  die('Connection Failed: ' . $e->getMessage());
}

?>
