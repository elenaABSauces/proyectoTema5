<?php
/**
 *   @author: Javier Nieto Lorenzo
 *   @since: 26/11/2020
 *   01.Desarrollo de un control de acceso con identificación del usuario basado en la función header().
*/
if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])) { // si no se ha autentificado el usuario
    header("Location: loginEjercicio01.php"); // redirige a la pagina de login
    exit;
}

if(!isset($_COOKIE['idioma'])){ // si no existe la cookie 'idioma'
    setcookie('idioma','es',time()+2592000); // crea la cookie 'idioma' con el valor 'es' para 30 dias
    setcookie('saludo','Hola',time()+2592000); // crea la cookie 'saludo' con el valor 'Hola' para 30 dias
}

require_once '../core/libreriaValidacion.php'; // incluyo la libreria de validacion para validar los campos del formulario

$entradaOK=true; // declaro la variable que determina si esta bien la entrada de los campos introducidos por el usuario

$erroresIdioma=null; //declaro e inicializo la variable de errores

$idioma=null; //declaro e inicializo la variable del idioma

if(isset($_REQUEST["Enviar"])){ // compruebo que el usuario le ha dado a al boton de enviar y valido la entrada de todos los campos
    $erroresIdioma= validacionFormularios::validarElementoEnLista($_REQUEST['idioma'], ['es','en','fr']); // valido el campo que ha seleccionado el usuario

    if($erroresIdioma != null){ // compruebo si hay algun mensaje de error 
        $entradaOK=false; // le doy el valor false a $entradaOK
    }
}else{ // si el usuario no le ha dado al boton de enviar
    $entradaOK=false; // le doy el valor false a $entradaOK
}

if($entradaOK){ // si la entrada esta bien recojo los valores introducidos y hago su tratamiento
    $idioma=$_REQUEST['idioma']; // asigno a la variable el valor recibido del formulario
    setcookie('idioma',$idioma,time()+2592000); // modifica la cookie 'idioma' con el valor recibido del formulario para 30 dias
    
    if ($idioma=="en") { // si el idioma seleccionado es 'en'
        setcookie('saludo','Hello',time()+2592000);  // modifica el valor de la cookie 'saludo' para 30 dias
    }
    if ($idioma=="fr") { // si el idioma seleccionado es 'fr'
        setcookie('saludo','Salut',time()+2592000);  // modifica el valor de la cookie 'saludo'  para 30 dias
    }
    if ($idioma=="es"){ // si el idioma seleccionado es 'es'
        setcookie('saludo','Hola',time()+2592000);  // modifica el valor de la cookie 'saludo'  para 30 dias
    }
    header('Location: programaEjercicio01.php'); // redire¡ige a la misma pagina
    exit;
}

?> 
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ejercicio 01</title>
    </head>
    <body>
        <h2><?php echo $_COOKIE['saludo']." ".$_SERVER['PHP_AUTH_USER'];?></h2>
        <form name="formularioIdioma" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div>
                <label for ="idioma">Idioma: </label>
                <select id="idioma" name="idioma">
                  <option value="es" <?php echo (($_COOKIE['idioma'])=='es') ? 'selected': null; ?> >Castellano</option>
                  <option value="en" <?php echo (($_COOKIE['idioma'])=='en') ? 'selected': null; ?> >English</option>
                  <option value="fr" <?php echo (($_COOKIE['idioma'])=='fr') ? 'selected': null; ?> >Français</option>
                </select>
                <?php
                    echo(!is_null($erroresIdioma)) ? "<span style='color:#FF0000'>" . $erroresIdioma . "</span>" : null;   // si el campo es erroneo se muestra un mensaje de error
                ?>
            </div>
            <input type="submit" value="Enviar" name="Enviar">
        </form>   
        <br>
        <a href="../indexProyectoTema5.php"><button>Salir</button></a>
        <a href="detallesEjercicio01.php"><button>Detalles</button></a>
    </body>
</html>