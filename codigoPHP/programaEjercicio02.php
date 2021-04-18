<?php
/**
 *   @author: Javier Nieto Lorenzo
 *   @since: 26/11/2020
 *   02. Desarrollo de un control de acceso con identificación del usuario basado en la función header() y en el uso de una tabla “Usuario” de la base de datos. (PDO).
*/
session_start();
if (!isset($_SERVER['PHP_AUTH_USER']) || (!isset($_SERVER['PHP_AUTH_PW']))) {
    header("Location: loginEjercicio02.php");
    exit;
}
if(isset($_REQUEST['cerrarSesion'])){ // si se ha pulsado el botton de cerrar sesion
    session_destroy(); // destruye todos los datos asociados a la sesion
    header("Location: ../indexProyectoTema5.php"); // redirige al index del tema 5
    exit;    
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ejercicio 02 o</title>
    </head>
    <body>
        <h1>Elena de Antón</h1>
        <h2>Hola <?php echo $_SESSION['usuario'];?> </h2>
        <form  name="logout" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
            <button type="submit" name='cerrarSesion' value="Cerrar Sesion" class="volver">Cerrar Sesion</button>
        </form>
        <a href="detallesEjercicio02.php"><button>Detalles</button></a>
        <a href="../indexProyectoTema5.php"><button>Salir</button></a>
        
        
    </body>
</html>