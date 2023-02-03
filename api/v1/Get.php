<?php
include '../../vendor/autoload.php';
//composer require firebase/php-jwt
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
class Get {
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
    public static function getClientesAnimales() {
        $ruta = 'http://' . $_SERVER['SERVER_NAME'] . dirname($_SERVER['SCRIPT_NAME']).'/' ;
        $rutaSeparada = explode('/',$ruta);
        // var_dump($rutaSeparada);
        $rutaFinal = $rutaSeparada[0] . '//' . $rutaSeparada[2] . '/' . $rutaSeparada[3] . '/';
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

            // var_dump($_SERVER);

        include_once('../../model/ClientesAnimalesDao.php');
        $consulta = new ClientesAnimalesDao();
        $clientes=$consulta->select_clientes();

        foreach ($clientes as $key => $cliente) {
            $cliente->foto=$rutaFinal.'web/personas/'.$cliente->foto;
            $consulta = new ClientesAnimalesDao();
            $animales=$consulta->select_animales_cliente($cliente->idCliente);
            
            foreach ($animales as $key => $animal) {
                $consulta = new ClientesAnimalesDao();
                $fotoAnimal=$consulta->select_fotos_animal($animal->NumHistorial);
                
                $animal->nombreFoto = (array) $fotoAnimal;
            }

            $cliente->animales = (array)$animales;
        }
        // var_dump($clientes);
        // var_dump($ruta);

        echo $datos = json_encode($clientes);
    }
}
}
?>