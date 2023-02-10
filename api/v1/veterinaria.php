<?php
const DIR = [0 => "../../controller/", 1 => "../../model/", 2 => "../../database/", 3 =>"./"];
spl_autoload_register(function ($clase) {
    if (file_exists(DIR[0] . $clase . ".php")) require_once DIR[0] . $clase . ".php";
    if (file_exists(DIR[1] . $clase . ".php")) require_once DIR[1] . $clase . ".php";
    if (file_exists(DIR[2] . $clase . ".php")) require_once DIR[2] . $clase . ".php";
    if (file_exists(DIR[3] . $clase . ".php")) require_once DIR[3] . $clase . ".php";
});

// include "funciones.php";
cors();
header('Content-Type: application/JSON');

$method = $_SERVER['REQUEST_METHOD'];

// if (isset($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO'] == '/login' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    
//     // loginToken();
    
// } else {
    $rutaDestino = explode("/",$_SERVER['REQUEST_URI']);
    switch ($method) {
        case 'GET': // consulta 
            Get::getClientesAnimales();
            break;
        
            case 'POST': // inserta       
            
            if ($rutaDestino[5]=="login") {
                Post::loginToken();
            }else if ($rutaDestino[5]=="cliente"&&is_numeric($rutaDestino[6])) {
                Post::subirAnimal();
            }
            break;
        
            case 'PUT': // actualiza
            // $rutaDestino = explode("/",$_SERVER['REQUEST_URI']);
            if ($rutaDestino[5]=="cliente"&&is_numeric($rutaDestino[6])&&$rutaDestino[7]=="animal"&&is_numeric($rutaDestino[8])&&isset($rutaDestino[9])&&$rutaDestino[9]=="cita?op=reservar") {
                Put::pedirCita();
            }else if($rutaDestino[5]=="cliente"&&is_numeric($rutaDestino[6])&&$rutaDestino[7]=="animal"&&is_numeric($rutaDestino[8])&&isset($rutaDestino[9])&&$rutaDestino[9]=="cita?op=anular"){
                
            }else if ($rutaDestino[5]=="cliente"&&is_numeric($rutaDestino[6])&&$rutaDestino[7]=="animal"&&is_numeric($rutaDestino[8])) {
                Put::actualizarImagenAnimal();
            }
            break;

        case 'DELETE': // elimina
                Delete::borrarAnimal();
            break;

        default:  // METODO NO SOPORTADO       
            header("HTTP/1.0 400 Bad Request");
            break;
    }
// }

function cors()
{
    // Permitir acceder a la API desde cualquier origen
    if (array_key_exists('HTTP_ORIGIN', $_SERVER)) {
        $origin = $_SERVER['HTTP_ORIGIN'];
    } else if (array_key_exists('HTTP_REFERER', $_SERVER)) {
        $origin = $_SERVER['HTTP_REFERER'];
    } else {
        $origin = $_SERVER['REMOTE_ADDR'];
    }
    header("Access-Control-Allow-Origin: {$origin}");
    header('Access-Control-Allow-Credentials: true');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
    header("Access-Control-Allow-Methods: GET, POST,PUT,DELETE,OPTIONS");
    header("Allow: GET, POST, OPTIONS, PUT, DELETE");
}
