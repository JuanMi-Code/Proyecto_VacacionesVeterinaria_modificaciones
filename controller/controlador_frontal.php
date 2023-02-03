<?php
// var_dump($_FILES);
var_dump($_REQUEST);

const DIR = [0 => "controller/", 1 => "model/", 2 => "database/"];
spl_autoload_register(function ($clase) {
    if (file_exists(DIR[0] . $clase . ".php")) require_once DIR[0] . $clase . ".php";
    if (file_exists(DIR[1] . $clase . ".php")) require_once DIR[1] . $clase . ".php";
    if (file_exists(DIR[2] . $clase . ".php")) require_once DIR[2] . $clase . ".php";
});


if (!isset($_SESSION)) {
    session_start();
}


// include_once "controller/ControladorNoLogged.php";
// include_once "controller/ControladorLogged.php";
// include_once "controller/ControladorRegistro.php";

$map = array(

    'paginaHomeNoLogged' => array(
        'controller' => 'ControladorNoLogged', //nombre del contralador (nombre de la clase)
        'action' => 'home', //nombre del método de esa clase
    ),
    'paginaLogin' => array(
        'controller' => 'ControladorNoLogged',
        'action' => 'login',
    ),
    'paginaRegistro' => array(
        'controller' => 'ControladorRegistro',
        'action' => 'registro',
    ),
    'paginaHomeLogged' => array(
        'controller' => 'ControladorLogged',
        'action' => 'mainLogged',
    ),
    'paginaAnimalesLogged' => array(
        'controller' => 'ControladorLogged',
        'action' => 'verAnimales',
    ),
    'paginaPedirCitaLogged' => array(
        'controller' => 'ControladorLogged',
        'action' => 'pedirCitaLogged',
    ),
    'paginaAnularCitaLogged' => array(
        'controller' => 'ControladorLogged',
        'action' => 'anularCitaLogged',
    ),
    'paginaCerrarSesionLogged' => array(
        'controller' => 'ControladorLogged',
        'action' => 'cerrarSesionLogged',
    ),
    'paginaHomeVetLogged' => array(
        'controller' => 'ControladorVeterinario',
        'action' => 'mainLogged',
    ),
    'paginaDetallesVeterinario' => array(
        'controller' => 'ControladorVeterinario',
        'action' => 'detalles',
    ),
    'paginaVacunar' => array(
        'controller' => 'ControladorVeterinario',
        'action' => 'vacunar',
    ),
    'anadirVacuna' => array(
        'controller' => 'ControladorVeterinario',
        'action' => 'insertar_Vacuna',
    ),
    'paginaListaVacunas' => array(
        'controller' => 'ControladorVeterinario',
        'action' => 'tabla_lista_vacunacion',
    ),
    'vacunasCliente' => array(
        'controller' => 'ControladorLogged',
        'action' => 'ver_vacunas',
    ),
    'generarPDF' => array(
        'controller' => 'ControladorPDF',
        'action' => 'funcionPdf',
    )
);

// Analizo la ruta recibida
// Del valor recibido extraigo el nombre del controlador
// y el nombre del método que debo ejecutar
// Buscando el valor recibido en el array map

if (isset($_REQUEST['ctl'])) {
    if (isset($map[$_REQUEST['ctl']])) {
        $ruta = $_REQUEST['ctl'];
    } else {
        echo '<p>
<h2>Error 404: No existe la ruta <i>' . $_REQUEST['ctl'] . '</h2>
</p>';
        exit;
    }
} else {
    //si no existe ctl en la url, tomará homo como valor por defecto, la página inicial
    $ruta = 'paginaHomeNoLogged';
}

$controlador = $map[$ruta];

//Ejecución del controlador asociado a la ruta
//utilizando para ello la función call_user_func

if (method_exists($controlador['controller'], $controlador['action'])) {
    call_user_func_array(

        array(
            new $controlador['controller'],
            $controlador['action']
        ),
        array(&$mensaje)
    );
} else {
    echo '<p>
<h2>Error 404: El controlador <i>' . $controlador['controller'] . '->' . $controlador['action'] . '</i> no existe</h2>
</p>';
}
var_dump($_SESSION);
