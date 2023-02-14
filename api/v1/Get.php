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
        $ruta = 'http://' . $_SERVER['SERVER_NAME'] . dirname($_SERVER['SCRIPT_NAME']) . '/';
        $rutaSeparada = explode('/', $ruta);
        // var_dump($rutaSeparada);
        $rutaFinal = $rutaSeparada[0] . '//' . $rutaSeparada[2] . '/' . $rutaSeparada[3] . '/';
        // $nuevaRuta=$

        $rutaDestino = explode("/",$_SERVER['REQUEST_URI']);

        if (isset($rutaDestino[5])&&$rutaDestino[5]=="tipos") {

            $consulta=new tipoAnimalDao();
            $tipos=$consulta->select_tipos_api();
            // var_dump($tipos);
            echo $info = json_encode(array("tipos" => $tipos));
            
        }else if (isset($rutaDestino[5])&&$rutaDestino[5]=="cliente"&&is_numeric($rutaDestino[6])&&$rutaDestino[7]=="animal"&&is_numeric($rutaDestino[8])) {
            
            $consulta=new CitasDao();
            $citas=$consulta->select_citas_animal($rutaDestino[8]);
            // var_dump($citas);
            echo $info = json_encode(array("citas" => $citas));

        }else if (isset($_REQUEST['inicio'])&&isset($_REQUEST['cantidad'])) {
            
            $todasFotosAnim=[];

            // var_dump($_REQUEST);
            $inicio=$_REQUEST['inicio'];
            $cantidad=$_REQUEST['cantidad'];

            $consulta=new ClientesAnimalesDao();
            $cli=$consulta->select_clientes();
            // var_dump($cli);

            foreach ($cli as $key => $cliente) {
                $cliente->foto = $rutaFinal . 'web/personas/' . $cliente->foto;
                $consulta = new ClientesAnimalesDao();
                $animales=$consulta->select_animales_cliente_paginado($cliente->idCliente,$inicio,$cantidad);
                
                //foto del animal anterior
                foreach ($animales as $key => $animal) {
                    $consulta = new ClientesAnimalesDao();
                    $fotoAnimal = $consulta->select_fotos_animal($animal->NumHistorial);
                    
                    foreach ($fotoAnimal as $key => $value) {
                        array_push($todasFotosAnim,$rutaFinal . 'web/animales/' . $value['nombreFoto']);
                    }

                    $animal->nombreFoto = $todasFotosAnim;
                    $todasFotosAnim = [];
                }
                $cliente->animales = (array)$animales;
            }
            echo $datos = json_encode(array("clientes" => $cli));


        }else if (isset($_SERVER['PATH_INFO'])) {
            // var_dump($_SERVER['PATH_INFO']);
            // Significa que me llega el id del cliente
            $info = explode("/", $_SERVER['PATH_INFO']);
            $id = $info[1];

            $consulta = new ClientesAnimalesDao();
            $anim = $consulta->select_animales_id($id);
            $animales = [];
            foreach ($anim as $key => $value) {
                // var_dump($value['NomAnimal']);
                array_push($animales,$value['NomAnimal']);
            }
            // var_dump($animales);
            echo $datos = json_encode(array("animales" => $animales));

        } else {
// añaddir condicion de que despues de veterinaria no haya nada
            $todasFotosAnim = [];

            //info de los clientes
            include_once('../../model/ClientesAnimalesDao.php');
            $consulta = new ClientesAnimalesDao();
            $clientes = $consulta->select_clientes();

            //info de los animales
            foreach ($clientes as $key => $cliente) {
                $cliente->foto = $rutaFinal . 'web/personas/' . $cliente->foto;
                $consulta = new ClientesAnimalesDao();
                $animales = $consulta->select_animales_cliente($cliente->idCliente);
                
                //foto del animal anterior
                foreach ($animales as $key => $animal) {
                    $consulta = new ClientesAnimalesDao();
                    $fotoAnimal = $consulta->select_fotos_animal($animal->NumHistorial);
                    
                    foreach ($fotoAnimal as $key => $value) {
                        array_push($todasFotosAnim,$rutaFinal . 'web/animales/' . $value['nombreFoto']);
                    }

                    $animal->nombreFoto = $todasFotosAnim;
                    $todasFotosAnim = [];
                }

                $cliente->animales = (array)$animales;
            }

            echo $datos = json_encode(array("clientes" => $clientes));

            // ------------------

            // $todasFotosAnim = [];

            // include_once('../../model/ClientesAnimalesDao.php');
            // $consulta = new ClientesAnimalesDao();
            // $clientes = $consulta->select_clientes();

            // foreach ($clientes as $key => $cliente) {
            //     $cliente->foto = $rutaFinal . 'web/personas/' . $cliente->foto;
            //     $consulta = new ClientesAnimalesDao();
            //     $animales = $consulta->select_animales_cliente($cliente->idCliente);

            //     var_dump($animales);
            // }

            // echo $datos = json_encode(array("clientes" => $clientes));
        }
    }
}
?>