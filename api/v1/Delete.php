<?php
class Delete{
    public static function borrarAnimal(){

        $rutaDestino = explode("/",$_SERVER['REQUEST_URI']);        

        if (!empty($_SERVER['HTTP_AUTHORIZATION'])) {
            $jwt = $_SERVER['HTTP_AUTHORIZATION'];
            $jwt = explode(' ', $jwt);
            $datos = Post::autenticarTokenJWT($jwt[1]);

            if ($rutaDestino[5]=="cliente"&&is_numeric($rutaDestino[6])&&$rutaDestino[7]=="animal"&&is_numeric($rutaDestino[8])) {
                $rutaDestino[6]; // cliente
                $rutaDestino[8]; // animal

                $consulta=new AnimalesDao();
                $info=$consulta->select_animal($rutaDestino[8]);
                // var_dump($info);
    
                if ($info!="") {
                    $consulta=new AnimalesDao();
                    $consulta->eliminarAnimal($rutaDestino[6],$rutaDestino[8]);

// ----------- FALTA HACER QUE SI SE ELIMINA EL ÚLTIMO ANIMAL, SE DESACTIVA CLIENTE

                } else {
                    header("HTTP/1.0 401 Unauthorized");
                    exit;
                }
            }else{
                header("HTTP/1.0 401 Unauthorized");
                exit;
            }
        }else{
            header("HTTP/1.0 401 Unauthorized");
            exit;
        }
    }
}
?>