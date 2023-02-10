<?php
//composer require firebase/php-jwt
include '../../vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
class Post {
    public static function loginToken()
    {
        $ruta = 'http://' . $_SERVER['SERVER_NAME'] . dirname($_SERVER['SCRIPT_NAME']);
        $data = json_decode(file_get_contents('php://input'), true);

        if (isset($data['alias']) && isset($data['contraseña'])) {
            //Comprobamos credenciales en la BD y enviamos $id, $alias, rol="cliente" o  rol="veterinario"
            $consulta = new ValidarDao();
            $alias = $consulta->select_alias($data['alias']);
            // var_dump($alias);
            if ($alias != false) {
                $consulta = new ValidarDao();
                $passwd = $consulta->select_clave_alias($data['alias']);

                if (password_verify($data['contraseña'], $passwd['clave'])) {
                    $consulta = new ValidarDao();
                    $idCliente=$consulta->select_idcliente_alias($data['alias']);
                    $id=$idCliente['idcliente'];
                    $rol = "cliente";

                    $jwtee=self::crearTokenJWT($id, $alias['alias'], $rol);
                    // var_dump(self::autenticarTokenJWT($jwtee));

                } else {
                    header("HTTP/1.0 400 Bad Request");
                }
            } else {
                //Comprobamos si es veterinario
                $consulta = new VeterinariosDao();
                $aliasVet=$consulta->select_alias($data['alias']);

                if ($aliasVet != false) {
                    $consulta = new VeterinariosDao();
                    $passwd = $consulta->select_clave_alias($data['alias']);

                    if (password_verify($data['contraseña'], $passwd['hash'])) {
                        $consulta = new VeterinariosDao();
                        $numColegiado = $consulta->select_idcliente_alias($data['alias']);
                        // -------------------
                        // var_dump($numColegiado);
                        $id = $numColegiado['numColegiado'];
                        $rol = "veterinario";

                        self::crearTokenJWT($id, $data['alias'], $rol);

                    } else {
                        header("HTTP/1.0 400 Bad Request");
                    }
                } else {
                    header("HTTP/1.0 400 Bad Request");
                }
            }
        } else {
            header("HTTP/1.0 400 Bad Request");
        }
    }
    private static function crearTokenJWT($id, $alias, $rol) {
        $key = 'PalabraSecreta';
        $token = [
            'iat' => time(),  //fecha de creación del token
            'exp' => time() + (60 * 60 * 24), //fecha de expiración del token (1 día)
            // 'exp' => time() + 4, //fecha de expiración del token (5 segundos)
            'id' => $id,
            'alias' => $alias,
            'rol' => $rol
        ];
        //Creando el token JWT
        //Con la información proporcionada en el array $token
        //El token se creará usando la palabra secreta elegida y el algoritmo indicado
        try {
            //el  método encode devuelve un string 
            $jwt = JWT::encode($token, $key, 'HS256');
            // return JWT::encode($token, $key, 'HS256');
            //var_dump($jwt);
            echo json_encode(['token' => $jwt], JSON_FORCE_OBJECT);
        } catch (Exception $e) {
            echo "<h3><br>Fichero: " . $e->getFile();
            echo "<br>Línea: " . $e->getLine() . "</h3><br>";;
            exit("Error: " . $e->getMessage());
        }
    }
    public static function autenticarTokenJWT($jwt) {
        $key = 'PalabraSecreta';
        try {
            $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
            $decoded = (array)$decoded;
            //var_dump((array)$decoded);
            return $decoded;
        } catch (Exception $e) {
            echo "<h3><br>Fichero: " . $e->getFile();
            echo "<br>Línea: " . $e->getLine() . "</h3><br>";
            exit("Error: " . $e->getMessage());
        }
    }
    public static function subirAnimal(){
        //URL para acceder a la carpeta de imágenes desde el navegador
        $ruta = 'http://' . $_SERVER['SERVER_NAME'] . dirname($_SERVER['SCRIPT_NAME']) . '/imgs/';
        //Ruta del servidor dónde se encuentra la carpeta para almacenar las imágenes
        $path = './imgs/';
        $data = json_decode(file_get_contents('php://input'), true);

        // var_dump($_SERVER);

        if (!empty($_SERVER['HTTP_AUTHORIZATION'])) {
            $jwt = $_SERVER['HTTP_AUTHORIZATION'];
            $jwt = explode(' ', $jwt);
            $datos = self::autenticarTokenJWT($jwt[1]);
            
            // var_dump($datos);
            $data = json_decode(file_get_contents('php://input'), true);
            // var_dump($data);

            if ($data['imagenAnimal']=="") {
                $imagen = "animalDefecto.png";
            } else {
                // file_put_contents('pruebas/ficheroBase64.txt', $base64); //mime, peso 1.5mb
                $imagen = self::base64_datos($data['imagenAnimal']);
            }
            $consulta = new AnimalesDao();
            $numHistorial=$consulta->insertarAnimal($datos['id'],$data['nomAnimal'],$data['idTipo'],$imagen);

            exit;
        } else {
            header("HTTP/1.0 401 Unauthorized");
            exit;
        }
    }
    public static function base64_datos($base64_datos, $path="../../web/animales/", $nombre = 'nuevo')
{
	// Extraigo el tipo mime del formato de la imagen
	$mime = mime_content_type($base64_datos);
	//Establezco los tipos permitidos, en este caso, solo imágenes
	$tipos_permitidos = ['image/png', 'image/jpeg', 'image/gif', 'image/bmp', 'image/webp'];
    // FALTA CONTROLAR EL PESO

	if (in_array($mime, $tipos_permitidos)) {
		$extension = explode('/', $mime);
		$extension = $extension[1];
		// $nombre = $nombre . time() . '.' . $extension;
		$nuevo_fichero_ruta = $path . $nombre . time() . '.' . $extension;
        // var_dump($nuevo_fichero_ruta);

		//Debo quitarle la cabecera añadida
		//Por ejemplo:  data:image/jpg;base64,
		$quitarCabecera = explode(',', $base64_datos);

		//Guardo el fichero en la ruta indicada
		file_put_contents($nuevo_fichero_ruta, base64_decode($quitarCabecera[1]));
		//retorno la ruta del fichero en el servidor del fichero		
		return $nuevo_fichero_ruta;
	} else {
		return false;
	}
}
}
?>