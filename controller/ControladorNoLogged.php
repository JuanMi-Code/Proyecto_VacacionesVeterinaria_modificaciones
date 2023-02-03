<?php
class ControladorNoLogged
{

    public function home() {
        
        include('view/headerNoLogin.php');
        include('view/home.php');
        include('view/footer.php');

    }
    public function login() {
        
        if(isset($_REQUEST['activar'])) {

            // include('model/ValidarDao.php');
            $validar = new ValidarDao();
            $idCliente = $validar->select_idcliente_alias($_REQUEST['activar']);

            $idCliente = (int) $idCliente['idcliente'];

            var_dump($idCliente);

            // include_once('model/Registro.php');
            $consulta = new Registro();
            $consulta->update_cliente($idCliente);

            $error = "";
            include('view/headerNoLogin.php');
            include('view/login.php');
            include('view/footer.php');

        } else if (!isset($_REQUEST['user'])|| !isset($_REQUEST['passwd'])) {
            $error = "";
            include('view/headerNoLogin.php');
            include('view/login.php');
            include('view/footer.php');

        } else if ($_REQUEST['user'] == '' || $_REQUEST['passwd'] == '') {
            $error = 'Usuario o Contraseña incorrectos <br><br>';
            include('view/headerNoLogin.php');
            include('view/login.php');
            include('view/footer.php');
        } else {
            // LLEGA USUARIO Y CONTRASENA
    
            //COMPROBAMOS QUE EXISTE EL USUARIO O QUE ESTÁ ACTIVO
            // include('model/ValidarDao.php');
            $validar = new ValidarDao();
            $alias = $validar->select_alias($_REQUEST['user']);
            
            $validar = new ValidarDao();
            $idCliente = $validar->select_idcliente_alias($_REQUEST['user']);

            // var_dump($idCliente);

            if ($idCliente) {
                // include('model/ClientesDao.php');
                $validar = new ClientesDao();
                $activo = $validar->select_activo($idCliente['idcliente']);
            }
    
            if (!$alias||!$idCliente||$activo['activo']==0) {

                // BUSCAMOS EN LA TABLA DE VETERINARIOS
                $consulta = new VeterinariosDao();
                $aliasVet = $consulta->select_alias($_REQUEST['user']);

                if ($aliasVet) {
                    $consulta = new VeterinariosDao();
                    $hash = $consulta->select_clave_alias($aliasVet['alias']);

                    if (password_verify($_REQUEST['passwd'], $hash['hash'])) {
                        $consulta = new VeterinariosDao();
                        $infoVet = $consulta->select_todo_alias($aliasVet['alias']);
                        var_dump($infoVet);
                        $_SESSION['veterinario']['alias']=$infoVet['alias'];
                        $_SESSION['veterinario']['numColegiado']=$infoVet['numColegiado'];
                        $_SESSION['veterinario']['nombreCompleto']=$infoVet['NombreCompleto'];
                        $_SESSION['veterinario']['firmaRegistrada']=$infoVet['FirmaRegistrada'];
                        $_SESSION['veterinario']['fotoVet']=$infoVet['fotoVet'];

                        header('Location: index.php?ctl=paginaHomeVetLogged');

                    } else {
                        // Datos de login mal
                        $error = 'Usuario o Contraseña incorrectos <br><br>';
                        include('view/headerNoLogin.php');
                        include('view/login.php');
                        include('view/footer.php');
                    }
                } else {
                    // SIGNIFICA QUE NO EXISTE ESE NOMBRE DE USUSARIO EN LA BBDD O QUE NO ESTÁ ACTIVO
                    $error = 'Usuario o Contraseña incorrectos <br><br>';
                    include('view/headerNoLogin.php');
                    include('view/login.php');
                    include('view/footer.php');
                }

            } else {
    
                if ($alias['alias'] == $_REQUEST['user']) {
                    // EL USUARIO ES CORRECTO, COMPROBAMOS PASSWD
    
                    $validar = new ValidarDao();
                    $clave = $validar->select_clave_alias($_REQUEST['user']);
    
                    if (password_verify($_REQUEST['passwd'], $clave['clave'])) {
    
                        $_SESSION['logged'] = true;
    
                        $dao = new ValidarDao();
                        $idcliente = $dao->select_idcliente_alias($_REQUEST['user']);
                        $_SESSION['idCliente'] = $idcliente['idcliente'];
                        // include("index.php?ctl=paginaHomeLogged");
                        header('Location: index.php?ctl=paginaHomeLogged');
                    } else {
    
                        $error = 'Usuario o Contraseña incorrectos <br><br>';
                        include('view/headerNoLogin.php');
                        include('view/login.php');
                        include('view/footer.php');
                    }
                }
            }
        }

    }
}