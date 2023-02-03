<?php
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

/*  Respuesta al cliente:
        1. 200 : OK → La solicitud ha tenido éxito
        2. 201 : Created → La solicitud ha tenido éxito y se ha creado un nuevo recurso
        3. 204 : No Content → La petición se ha completado con éxito, pero su respuesta no tiene ningún contenido
        4. 400 : Bad Request → La solicitud contiene sintaxis errónea y no debería repetirse
        5. 401 : Unauthorized → La solicitud no se ha procesado, faltan de credenciales de autenticación válidas
        5. 404 : Not Found → El servidor no pudo encontrar el contenido solicitado
        6. 422 : Unprocessable Entity → Entidad no procesable
        7. 500 : Internal Server Error → Se ha producido un error interno
   */
function getClientesAnimales() {
        $ruta = 'http://' . $_SERVER['SERVER_NAME'] . dirname($_SERVER['SCRIPT_NAME']).'/' ;
        $rutaSeparada = explode('/',$ruta);
        // var_dump($rutaSeparada);
        $rutaFinal = $rutaSeparada[0] . '//' . $rutaSeparada[2] . '/' . $rutaSeparada[3] . '/' . $rutaSeparada[4] . '/' . $rutaSeparada[5].'/';
        // $nuevaRuta=$

    if (isset($_SERVER['PATH_INFO'])) {
        // Significa que me llega el id del cliente
        // $info = explode("/", $_SERVER['PATH_INFO']);
        // $id = $info[1];

        // include_once('./modelo/alimentosDao.php');
        // $consulta = new AlimentosDao();
        // $alimentos=$consulta->select_alimentos_id($id);
        // var_dump($alimentos);

        // foreach ($alimentos as $key => $value) {
        //     $alimentos[$key]['imagen'] = $ruta.'imgs/'.$value['imagen'];
        // }
        // echo $datos = json_encode($alimentos);

    } else {

        include_once('../../model/ClientesAnimalesDao.php');
        $consulta = new ClientesAnimalesDao();
        $clientes=$consulta->select_clientes();
        // var_dump($clientes);

        
        foreach ($clientes as $key => $cliente) {
            $cliente->foto=$rutaFinal.'web/personas/'.$cliente->foto;
            $consulta = new ClientesAnimalesDao();
            $animales=$consulta->select_animales_cliente($cliente->idCliente);
            
            foreach ($animales as $key => $animal) {
                $consulta = new ClientesAnimalesDao();
                $fotoAnimal=$consulta->select_fotos_animal($animal->NumHistorial);
                
                $animal->nombreFoto = (array) $fotoAnimal;

                // foreach ($animal as $key => $value) {
                //     var_dump($animal->nombreFoto);
                // }
                // $animal->nombreFoto=$rutaFinal.'web/animales/'.$animal->nombreFoto;

                
            }

            $cliente->animales = (array)$animales;
        }
        // var_dump($clientes);
        // var_dump($ruta);

        echo $datos = json_encode($clientes);
    }
}
























// function loginToken()
// {
//     $ruta = 'http://' . $_SERVER['SERVER_NAME'] . dirname($_SERVER['SCRIPT_NAME']);
//     $data = json_decode(file_get_contents('php://input'), true);
//     if (isset($data['alias']) && isset($data['contraseña'])) {
//         //Comprobamos credenciales en la BD y enviamos $id, $alias, rol="cliente" o  rol="veterinario"
//         crearTokenJWT();
//     }
// }
// function crearTokenJWT($id = NULL, $alias = NULL, $rol = NULL)
// {
//     $key = 'PalabraSecreta';
//     $id = 365;
//     $alias = 'vet1';
//     $rol = 'veterinario';
//     $token = [
//         'iat' => time(),  //fecha de creación del token
//         'exp' => time() + (60 * 60 * 24), //fecha de expiración del token (1 día)
//         // 'exp' => time() + 4, //fecha de expiración del token (5 segundos)
//         'id' => $id,
//         'alias' => $alias,
//         'rol' => $rol
//     ];
//     //Creando el token JWT
//     //Con la información proporcionada en el array $token
//     //El token se creará usando la palabra secreta elegida y el algoritmo indicado
//     try {
//         //el  método encode devuelve un string 
//         $jwt = JWT::encode($token, $key, 'HS256');
//         //var_dump($jwt);
//         echo json_encode(['token' => $jwt], JSON_FORCE_OBJECT);
//     } catch (Exception $e) {
//         echo "<h3><br>Fichero: " . $e->getFile();
//         echo "<br>Línea: " . $e->getLine() . "</h3><br>";;
//         exit("Error: " . $e->getMessage());
//     }
// }
// function autenticarTokenJWT($jwt)
// {
//     $key = 'PalabraSecreta';
//     try {
//         $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
//         $decoded = (array)$decoded;
//         //var_dump((array)$decoded);
//         return $decoded;
//     } catch (Exception $e) {
//         echo "<h3><br>Fichero: " . $e->getFile();
//         echo "<br>Línea: " . $e->getLine() . "</h3><br>";
//         exit("Error: " . $e->getMessage());
//     }
// }
// function saveAlimento()
// {
//     //URL para acceder a la carpeta de imágenes desde el navegador
//     $ruta = 'http://' . $_SERVER['SERVER_NAME'] . dirname($_SERVER['SCRIPT_NAME']) . '/imgs/';
//     //Ruta del servidor dónde se encuentra la carpeta para almacenar las imágenes
//     $path = './imgs/';
//     $data = json_decode(file_get_contents('php://input'), true);

//     if (!empty($_SERVER['HTTP_AUTHORIZATION'])) {
//         $jwt = $_SERVER['HTTP_AUTHORIZATION'];
//         $jwt = explode(' ', $jwt);
//         $datos = autenticarTokenJWT($jwt[1]);
//         var_dump($datos);
//         exit;
//     } else {
//         header("HTTP/1.0 401 Unauthorized");
//         exit;
//     }
//     $data = json_decode(file_get_contents('php://input'), true);
// }
