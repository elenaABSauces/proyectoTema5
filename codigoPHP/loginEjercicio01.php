<?php
/**
 *   @author: Javier Nieto Lorenzo
 *   @since: 26/11/2020
 *   01.Desarrollo de un control de acceso con identificación del usuario basado en la función header().
*/
if ($_SERVER['PHP_AUTH_USER']!="admin" || $_SERVER['PHP_AUTH_PW']!="paso") { // si el usuario no es 'admin' y el password no es 'paso'
    header('WWW-Authenticate: Basic Realm="Contenido restringido"'); // redirige con una cabecera de autentificacion
    header('HTTP/1.0 401 Unauthorized'); // redirige con el estado 401 Unauthorized
    echo "Usuario no reconocido!";
    exit;
}
if(!isset($_COOKIE['idioma'])){ // si no existe la cookie 'idioma'
    setcookie('idioma','es',time()+2592000); // crea la cookie 'idioma' con el valor 'es' para 30 dias
    setcookie('saludo','Hola',time()+2592000); // crea la cookie 'saludo' con el valor 'Hola' para 30 dias
}
header("Location: programaEjercicio01.php"); // redirige a la pagina del programa del ejercicio

?>