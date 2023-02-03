<?php
class ControladorRegistro
{
    public function registro()
    {
        $defecto = null;
        $registroTipo=false;
        $registroNombreAnimal=false;
        $registroClave=false;
        $registroCorreo=false;
        $registroAlias=false;
        $registroNif=false;
        $registroApellidos=false;
        $registroNombre=false;

        if (isset($_REQUEST['registrar'])) {

            // Validamos nombre
            if (isset($_REQUEST['nombre'])) {
                $numero = filter_var($_REQUEST['nombre'], FILTER_VALIDATE_INT);
                if ($_REQUEST['nombre'] != "" && !$numero) {

                    $nombre = $_REQUEST['nombre'];
                    self::filtrar($nombre);

                    //Nombre correcto
                    $_SESSION['Registro_nombre'] = $_REQUEST['nombre'];
                    $registro['nombre']=$_REQUEST['nombre'];
                    $registroNombre = true;
                } else {
                    $registroNombre = false;
                    $registro['nombre']=$_REQUEST['nombre']." NO VALIDO";
                }
            }

            // Validamos apellidos
            if (isset($_REQUEST['apellidos'])) {
                $numero = filter_var($_REQUEST['apellidos'], FILTER_VALIDATE_INT);
                if ($_REQUEST['apellidos'] != "" && !$numero) {

                    $apellidos = $_REQUEST['apellidos'];
                    self::filtrar($apellidos);

                    //Apellidos correcto
                    $_SESSION['Registro_apellidos'] = $_REQUEST['apellidos'];
                    $registro['apellidos'] = $_REQUEST['apellidos'];
                    $registroApellidos = true;
                } else {
                    $registroApellidos = false;
                    $registro['apellidos'] = $_REQUEST['apellidos']." NO VALIDO";
                }
            }

            // Validamos nif
            if (isset($_REQUEST['nif'])) {

                $numero = filter_var($_REQUEST['nif'], FILTER_VALIDATE_INT);

                if ($_REQUEST['nif'] != "" && !$numero) {

                    if (strlen($_REQUEST['nif']) == 9) {

                        $numerosDni = substr($_REQUEST['nif'], 0, 8);
                        $letraDni = substr($_REQUEST['nif'], 8, 1);

                        $esNumero = filter_var($numerosDni, FILTER_VALIDATE_INT);
                        echo($esNumero);
                        $letraEsNumero = filter_var((int)$letraDni, FILTER_VALIDATE_INT);
                        // En vez de devolver false, devuelve 0

                        // if ($esNumero == 0 && $letraEsNumero == 0) {
                        if ($letraEsNumero == 0) {


                            $nif = $numerosDni . "-" . $letraDni;
                            // self::filtrar($nif);

                            // include_once("model/ClientesDao.php");
                            $validar = new ClientesDao();
                            $nifSelect = $validar->select_nif($nif);

                            if (!$nifSelect) {
                                $_SESSION['Registro_nif'] = $nif;
                                $registro['nif'] = $_REQUEST['nif'];
                                $registroNif = true;
                            } else {
                                $registroNif = false;
                                $registro['nif'] = $_REQUEST['nif']." NO VALIDO";
                            }
                        } else {
                            $registroNif = false;
                            $registro['nif'] = $_REQUEST['nif']." NO VALIDO";
                        }
                    } else {
                        $registroNif = false;
                        $registro['nif'] = $_REQUEST['nif']." NO VALIDO";
                    }
                } else {
                    $registroNif = false;
                    $registro['nif'] = $_REQUEST['nif']." NO VALIDO";
                }
            }

            // Validamos alias
            if (isset($_REQUEST['alias'])) {
                $numero = filter_var($_REQUEST['alias'], FILTER_VALIDATE_INT);
                if ($_REQUEST['alias'] != "" && !$numero) {

                    $alias = $_REQUEST['alias'];
                    self::filtrar($alias);

                    // include_once("model/ValidarDao.php");
                    $validar = new ValidarDao();
                    $alias = $validar->select_alias($_REQUEST['alias']);

                    // Significa que no existe
                    if (!$alias) {
                        $_SESSION['Registro_alias'] = $_REQUEST['alias'];
                        $registro['alias']=$_REQUEST['alias'];
                        $registroAlias = true;
                    } else {
                        $registroAlias = false;
                        $registro['alias']=$_REQUEST['alias']." NO VALIDO";
                    }
                } else {
                    $registroAlias = false;
                    $registro['alias']=$_REQUEST['alias']." NO VALIDO";
                }
            }

            // Validamos correo
            if (isset($_REQUEST['correo'])) {

                $correo = filter_var($_REQUEST['correo'], FILTER_VALIDATE_EMAIL);
                // var_dump($correo);
                if ($_REQUEST['correo'] != "" && $correo = !"") {
                    //Correo correcto
                    $_SESSION['Registro_correo'] = $_REQUEST['correo'];
                    $registro['correo']=$_REQUEST['correo'];
                    $registroCorreo = true;
                } else {
                    $registroCorreo = false;
                    $registro['correo']=$_REQUEST['correo']." NO VALIDO";
                }
            }

            // Validamos clave
            if (
                isset($_REQUEST['clave1']) && $_REQUEST['clave1'] != ""
                && isset($_REQUEST['clave2']) && $_REQUEST['clave2'] != ""
                && $_REQUEST['clave1'] == $_REQUEST['clave2']
            ) {
                if (strlen($_REQUEST['clave1']) >= 6) {

                    $clave = $_REQUEST['clave1'];
                    self::filtrar($clave);

                    // Hasheamos la contraseña
                    $hash = password_hash($_REQUEST['clave1'], PASSWORD_DEFAULT);
                    $_SESSION['Registro_claveHash'] = $hash;
                    $registro['clave1'] = $_REQUEST['clave1'];
                    $registro['clave2'] = $_REQUEST['clave2'];
                    $registroClave = true;
                } else {
                    $registroClave = false;
                    $registro['clave1'] = $_REQUEST['clave1']." NO VALIDO";
                    $registro['clave2'] = $_REQUEST['clave2']." NO VALIDO";
                }
            }

            // Cogemos la imagen del usuario
            if ($_FILES['imagenPersona']['name']!='') {

                $foto = $_FILES['imagenPersona']['tmp_name'];
                self::subirImagenPersona($foto);
                $_SESSION['Registro_imagenPersona'] = $_FILES['imagenPersona']['name'];

            } else {
                $_SESSION['Registro_imagenPersona']='personaDefecto.png';
            }

            // Validamos nombre del animal
            if (isset($_REQUEST['nombreAnimal'])) {
                $numero = filter_var($_REQUEST['nombreAnimal'], FILTER_VALIDATE_INT);
                if ($_REQUEST['nombreAnimal'] != "" && !$numero) {
                    
                    $nom = $_REQUEST['nombreAnimal'];
                    self::filtrar($nom);

                    //Nombre correcto
                    $_SESSION['Registro_nombreAnimal'] = $nom;
                    $registro['nombreAnimal'] = $_REQUEST['nombreAnimal'];
                    $registroNombreAnimal = true;
                } else {
                    $registroNombreAnimal = false;
                    $registro['nombreAnimal'] = $_REQUEST['nombreAnimal']." NO VALIDO";
                }
            }

            // Cogemos la imagen del animal
            if ($_FILES['imagenAnimal']['name']!='') {


                $foto = $_FILES['imagenAnimal']['tmp_name'];
                self::subirImagenAnimal($foto);
                $_SESSION['Registro_imagenAnimal'] = $_FILES['imagenAnimal']['name'];
            } else {
                $_SESSION['Registro_imagenAnimal']='animalDefecto.png';
            }

            if (isset($_REQUEST['tipoAnimal'])) {

                // include_once("model/TipoAnimalDao.php");
                $validar = new TipoAnimalDao();
                $tiposAnimales = $validar->select_tipos();

                for ($i = 0; $i < count($tiposAnimales); $i++) {
                    if ($_REQUEST['tipoAnimal'] == $tiposAnimales[$i]['NombreTipo']) {
                        $_SESSION['Registro_tipoAnimal'] = $tiposAnimales[$i]['idTipo'];
                        $defecto = $tiposAnimales[$i]['idTipo'];
                        $registroTipo = true;
                    } else {
                        $registroTipo = false;
                        $defecto = $_REQUEST['tipoAnimal'];
                    }
                }
            }


            if ($registroNombreAnimal && $registroClave
                && $registroCorreo && $registroAlias && $registroNif
                && $registroApellidos && $registroNombre) {

                $token = bin2hex(random_bytes((50 - (50 % 2)) / 2));
                $_SESSION['Registro_token'] = $token;

                // include_once("model/Registro.php");
                $consulta = new Registro();
                $consulta->insertarCliente();

                $direccion = dirname($_SERVER['HTTP_REFERER']);
                $direccion = $direccion . '/index.php?ctl=paginaLogin&activar=' . $_SESSION['Registro_alias'];

                // include_once("model/CorreoAlumnos.php");
                CorreoAlumnos::enviarCorreo($_SESSION['Registro_correo'], $direccion);
                header("Location: index.php?ctl=paginaLogin");

                echo "HOLAAAAAAAAAA";

            } else {

                include('view/headerNoLogin.php');
                include('view/form_registro.php');
                echo $datos;
                echo $registroTipo;
                include('view/footer.php');
            }

        } else {
            $registro['nombre'] = "";
            $registro['apellidos'] = "";
            $registro['nif'] = "";
            $registro['alias'] = "";
            $registro['correo'] = "";
            $registro['clave1'] = "";
            $registro['clave2'] = "";
            $registro['nombreAnimal'] = "";

            // include_once("model/TipoAnimalDao.php");
            $validar = new TipoAnimalDao();
            $tiposAnimales = $validar->select_tipos();

            include('view/headerNoLogin.php');
            include('view/form_registro.php');
            echo $datos;
            include('view/footer.php');
        }
    }
    private function filtrar(&$valor)
    {
        $valor = strip_tags($valor);
        $valor = trim($valor);
        $valor = htmlentities($valor);
    }
    private function subirImagenPersona($foto){

        $info = pathinfo($_FILES['imagenPersona']['name']);

        $nombre = $info['filename'];
        $extension = $info['extension'];

        $origen = $_FILES['imagenPersona']['tmp_name'];
        $destino = "web/personas/" . $nombre .".". $extension;

        move_uploaded_file($origen, $destino);

        $foto = $destino;

        return $foto;
    }
    private function subirImagenAnimal($foto){

        if (isset($_FILES['imagenAnimal'])) {
            $info = pathinfo($_FILES['imagenAnimal']['name']);

            $nombre = $info['filename'];
            $extension = $info['extension'];

            $origen = $_FILES['imagenAnimal']['tmp_name'];
            $destino = "web/animales/" . $nombre .".". $extension;

            move_uploaded_file($origen, $destino);

            $foto = $destino;

            return $foto;
        }
    }
}
?>