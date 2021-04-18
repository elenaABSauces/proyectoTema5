<?php
/**
 *   @author: Javier Nieto Lorenzo
 *   @since: 26/11/2020
 *   02. Desarrollo de un control de acceso con identificación del usuario basado en la función header() y en el uso de una tabla “Usuario” de la base de datos. (PDO).
*/
if (!isset($_SERVER['PHP_AUTH_USER']) || (!isset($_SERVER['PHP_AUTH_PW']))) { // si no se ha autentificado el usuario
    header('WWW-Authenticate: Basic Realm="Contenido restringido"'); // redirige con una cabecera de autentificacion
    header('HTTP/1.0 401 Unauthorized'); // redirige con el estado 401 Unauthorized
    echo "Usuario no reconocido!";
    exit;
}
require_once '../config/confDBPDO.php'; // incluyo el fichero de configuracion de conexion a la base de datos

try { // Bloque de código que puede tener excepciones en el objeto PDO
    $miDB = new PDO(DNS, USER, PASSWORD); // creacion de un objeto PDO con la conexion a la base de datos

    $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Establece el atributo para la apariciopn de errores y le pongo el modo para que cuando haya un error se lance una excepcion
    $usuarioIntroducido=$_SERVER['PHP_AUTH_USER']; // le asigno a la variable el valor del usuario introducido
    $passwordIntroducido=$_SERVER['PHP_AUTH_PW']; // le asigno a la variable el alor del password introducido
    $sqlBusqueda = "SELECT T01_CodUsuario,T01_Password FROM T01_Usuario WHERE T01_CodUsuario=:CodUsuario"; // Obtiene el uasuario y password del usuario introducido en la autentificacion

    $consultaBusqueda = $miDB->prepare($sqlBusqueda); // prepara la consulta
    $parametros = [':CodUsuario' => $usuarioIntroducido]; // creacion del array de parametros con el valor de los parametros de la consulta

    $consultaBusqueda->execute($parametros); // ejecuta la consulta pasando los parametros del array de parametros
    $oUsuario = $consultaBusqueda->fetchObject(); // devuelve el resultado de la consulta en un objeto

    if(($oUsuario->T01_CodUsuario == $usuarioIntroducido) && ($oUsuario->T01_Password == hash("sha256",$usuarioIntroducido.$passwordIntroducido))){ // si el usuario y el password no coincide con el usuario y password encriptado de la base de datos
        session_start(); // inicia una sesion, o recupera una existente
        $_SESSION['usuario']=$usuarioIntroducido; // asigno el usuariio introducido en la variable de sesion 'usuario'
        header("Location: programaEjercicio02.php"); // redirige a la pagina del programa del ejercicio
        exit;
    }else{
        header('WWW-Authenticate: Basic Realm="Contenido restringido"'); // redirige con una cabecera de autentificacion
    header('HTTP/1.0 401 Unauthorized'); // redirige con el estado 401 Unauthorized
    echo "Usuario no reconocido!";
        exit;
    }
} catch (PDOException $miExceptionPDO) { // Codigo que se ejecuta si hay alguna excepcion
    echo "<p style='color:red;'>ERROR EN LA CONEXION</p>";
    echo "<p style='color:red;'>Código de error: " . $miExceptionPDO->getCode() . "</p>"; // Muestra el codigo del error
    echo "<p style='color:red;'>Error: " . $miExceptionPDO->getMessage() . "</p>"; // Muestra el mensaje de error
    die(); // Finalizo el script
} finally { // codigo que se ejecuta haya o no errores
    unset($miDB); // destruye la variable 
}

?>