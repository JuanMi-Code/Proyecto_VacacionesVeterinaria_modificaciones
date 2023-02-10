<?php
class Put
{
    public static function pedirCita()
    {

        $rutaDestino = explode("/", $_SERVER['REQUEST_URI']);
        $data = json_decode(file_get_contents('php://input'), true);

        if (!empty($_SERVER['HTTP_AUTHORIZATION'])) {
            $jwt = $_SERVER['HTTP_AUTHORIZATION'];
            $jwt = explode(' ', $jwt);
            $datos = Post::autenticarTokenJWT($jwt[1]);

            // var_dump($datos);
            // var_dump($data);

            if ($data['fecha'] == "" || $data['hora'] == "") {
                header("HTTP/1.0 401 Unauthorized");
                exit;
            } else {
                $datos['id']; // id cliente
                $data['fecha']; // fecha
                $data['hora']; // hora
                $rutaDestino[8]; // id animal
                $libre=false;
                $intervalo = null;

                if ($rutaDestino[6] == $datos['id']) {

                    $consulta=new CitasDao();
                    $citas=$consulta->select_citas();
                    // var_dump($citas);

                    foreach ($citas as $key => $value) {
                        // var_dump($value);
                        if ($value['fecha']==$data['fecha']&&$value['intervalo']==$data['hora']) {
                            header("HTTP/1.0 401 Unauthorized");
                            exit;
                        }else{
                            $libre = true;
                        }
                    }

                    // var_dump($libre);

                    if ($libre) {
                        $consulta = new IntervalosDao();
                        $intervalos = $consulta->select_intervalos();

                        foreach ($intervalos as $key => $value) {
                            if ($value['texto'] == $data['hora']) {
                                // ECHO $value['texto'];
                                $intervalo = $value['idIntervalo'];
                            }
                        }

                        $consulta = new CitasDao();
                        $consulta->insert_citas($data['fecha'], (int)$intervalo, $rutaDestino[8]);
                    }else{
                        header("HTTP/1.0 401 Unauthorized");
                        exit;
                    }
                    
                } else {
                    header("HTTP/1.0 401 Unauthorized");
                    exit;
                }
            }
        } else {
            header("HTTP/1.0 401 Unauthorized");
            exit;
        }
    }
    public static function actualizarImagenAnimal()
    {
        //URL para acceder a la carpeta de imágenes desde el navegador
        $ruta = 'http://' . $_SERVER['SERVER_NAME'] . dirname($_SERVER['SCRIPT_NAME']) . '/imgs/';
        //Ruta del servidor dónde se encuentra la carpeta para almacenar las imágenes
        $path = './imgs/';
        $data = json_decode(file_get_contents('php://input'), true);
        
        $rutaDestino = explode("/",$_SERVER['REQUEST_URI']);

        // var_dump($_SERVER);

        if (!empty($_SERVER['HTTP_AUTHORIZATION'])) {
            $jwt = $_SERVER['HTTP_AUTHORIZATION'];
            $jwt = explode(' ', $jwt);
            $datos = POST::autenticarTokenJWT($jwt[1]);

                // $datos['id']; // id cliente
                // $rutaDestino[8]; // id animal
                // $rutaDestino[6]; //idcliente

                // var_dump($data);

                if ($datos['id']==$rutaDestino[6]) {
                    
                    $consulta=new AnimalesDao();
                    $info=$consulta->select_animal($rutaDestino[8]);
                    if ($info!="") {
                        
                        $imagen = POST::base64_datos($data['imagen']);

                        $imgSeparada = explode("/",$imagen);
                        // var_dump($imgSeparada);

// -------------------- Me falta unlink del actual

                        $consulta = new FotosaniDao();
                        $consulta->actualizarFoto((int)$rutaDestino[8],$imgSeparada[4]);

                        // var_dump($rutaDestino[8]);
                        // $consulta = new FotosaniDao();
                        // $inform=$consulta->select_una_foto_ani((int)$rutaDestino[8]);
                        // var_dump($inform);

                    }else{
                        header("HTTP/1.0 401 Unauthorized");
                        exit;
                    }
                }else{
                    header("HTTP/1.0 401 Unauthorized");
                    exit;
                }
        }else {
            header("HTTP/1.0 401 Unauthorized");
            exit;
        }
    }
}
?>