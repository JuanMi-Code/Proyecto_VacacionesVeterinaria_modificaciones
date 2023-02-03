<?php
const DIR = [0 => "../../controller/", 1 => "../../model/", 2 => "../../database/", 3 =>"./v1/"];
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

    switch ($method) {
        case 'GET': // consulta         
            include("Get.php");
            Get::getClientesAnimales();   
            // $get = new Get();
            // $get->getClientesAnimales();
            break;
        case 'POST': // inserta   
            
            $rutaDestino = explode("/",$_SERVER['REQUEST_URI']);
            if ($rutaDestino[5]=="login") {
                include("Post.php");
                // Post::login();
                Post::loginToken();
            }else if ($rutaDestino[5]=="cliente"&&$rutaDestino[6]=="id") {
                include("Post.php");
                Post::subirAnimal();

            }
            break;
        case 'PUT': // actualiza
            //updateAlimento();
            break;
        case 'DELETE': // elimina
            // deleteAlimento();
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
