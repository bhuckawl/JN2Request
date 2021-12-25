<?php
/* Definição dos dados do banco */
define('DB_SERVER', '127.0.0.1');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'JN2');
 
/* conexão com o banco de dados */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// confere conexão
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>