<?php
class ControladorLogged
{

    private $nombreUsuario;
    private $fotoPerfil;

    public function homeLogged() {
        
        // INFORMACIÓN DEL USUARIO
    $idCliente=$_SESSION['idCliente'];

    // include('model/ClientesDao.php');
    $cliente = new ClientesDao();
    $infoCliente = $cliente->select_alias($_SESSION['idCliente']);
    // var_dump($infoCliente);

//    $this->nombreUsuario = $infoCliente['nombre'];
//    $this->fotoPerfil = 'web/personas/'.$infoCliente['foto'];

        $_SESSION['perfil']['nombreUsuario'] = $infoCliente['nombre'];
        $_SESSION['perfil']['fotoPerfil'] = 'web/personas/'.$infoCliente['foto'];;

    // PARA EL SELECT DE LAS CITAS
    // include('model/AnimalesDao.php');
    $consultaAnimales = new AnimalesDao();
    $_SESSION['nombreAnimales'] = $consultaAnimales->select_nombreAnimales($_SESSION['idCliente']);
    // var_dump($nombreAnimales);

    }

    public function mainLogged() {
        $this->homeLogged();

        // HOME
        include('view/headerLogin.php');
        include('view/home.php');
        include('view/footer.php');

    }

    public function verAnimales() {
        $this->homeLogged();

        // LISTA DE ANIMALES / PAGINACIÓN ANIMALES

        // include('model/fotosaniDao.php');
        $fotosani = new FotosaniDao();
        $cantidadFotos = $fotosani->select_cantidadFotos($_SESSION['idCliente']);
        // var_dump($cantidadFotos);
        // echo count($fotos);
        $paginas = ceil($cantidadFotos['cantidad']/2);
        // echo '<br>'.$paginas;

        // COMPROBAMOS LA PÁGINA QUE NOS LLEGA POR LA URL Y ESTABLECEMOS LÍMITES
        if (isset($_REQUEST['pagina'])&&$_REQUEST['pagina']>0&&$_REQUEST['pagina']<=$paginas) {

            // SI TODOS LOS DATOS SON CORRECTOS
            if ($_REQUEST['pagina']==1) {
                $limite1 = 0;
                $actual = 1;
            } else {
                $limite1 = ($_REQUEST['pagina']-1)*2;
                $actual = $_REQUEST['pagina'];
            }
        } else {

            // SI LA PÁGINA SE PASA O SE QUEDA POR DEBAJO DE LO PERMITIDO, PONEMOS VALORES LÍMITE
            if (isset($_REQUEST['pagina'])&&$_REQUEST['pagina']>$paginas) {
                $limite1 = ($paginas-1)*2;
                $actual = $paginas;
            } else {
                $limite1 = 0;
                $actual = 1;
            }
        }

        $limite2 = 2;
        $fotosani = new FotosaniDao();
        $fotos = $fotosani->select_nombreFoto($_SESSION['idCliente'],$limite1,$limite2);
        // var_dump($fotos);
        include('view/headerLogin.php');
        include('view/tablaAnimales.php');
        include('view/footer.php');

    }
    
    public function pedirCitaLogged() {
        $this->homeLogged();
        
        // CALENDARIO DE SOLICITUD DE CITAS

        // PAGINACIÓN
        $d = self::paginacionCalendario();

        // OBTENEMOS LOS INTERVALOS
        // include('model/intervalosDao.php');
        $consultaIntervalos = new IntervalosDao();
        $intervalos = $consultaIntervalos->select_intervalos();
        // var_dump($intervalos);

        //OBTENEMOS LAS RESERVAS
        // include('model/CitasDao.php');
        $consultaCitas = new CitasDao();
        $citas = $consultaCitas->select_citas();
        // var_dump($citas);


        // PARA TENER GUARDADO EL ANIMAL AL QUE QUEREMOS PEDIR CITA
        if ($_REQUEST['solicitarCita']!='') {
            $_SESSION['solicitarCitaAnimal'] = $_REQUEST['solicitarCita'];
        }

        // RECIBIMOS LOS DATOS DE LA RESERVA
        if (isset($_REQUEST['reservar'])) {

            echo('hola');

            $fechaReserva = $_REQUEST['fecha'];
            $animal = $_REQUEST['reservar'];
            $intervalo = $_REQUEST['intervalo'];
            $insertar = false;

            // VERIFICAMOS LOS DATOS RECIBIDOS POR URL
            for ($i=0; $i < count($citas); $i++) {
                if ($citas[$i]['fecha']!=$fechaReserva && $citas[$i]['intervalo']!=$intervalo) {
                    if ($animal == $_SESSION['solicitarCitaAnimal']) {
                        // SI TODO ES CORRECTO INSERTAMOS CITA
                        $insertar = true;
                    }
                }
            }

            if ($insertar) {
                $idIntervalo = '';
                for ($j=0; $j < count($intervalos); $j++) { 
                    if ($intervalos[$j]['idIntervalo']==$intervalo) {
                        $idIntervalo = $intervalos[$j]['idIntervalo'];
                        $idIntervalo = intval($idIntervalo);
                        // var_dump($idIntervalo);
                    }
                }
                for ($j=0; $j < count($_SESSION['nombreAnimales']); $j++) { 
                    if ($_SESSION['nombreAnimales'][$j]['NomAnimal']==$animal) {
                        $numHistorial = $_SESSION['nombreAnimales'][$j]['NumHistorial'];
                    }
                }
                // echo $fechaReserva.' '.$idIntervalo.' '.$numHistorial;
                $consultaCitas = new CitasDao();
                $consultaCitas->insert_citas($fechaReserva,$idIntervalo,$numHistorial);
                header('Location: index.php?ctl=paginaPedirCitaLogged&solicitarCita');
            }
        }
        include('view/headerLogin.php');
        include('view/tablaPedirCita.php');
        include('view/footer.php');
        
    }
    public function anularCitaLogged() {
        $this->homeLogged();

        // CALENDARIO DE AULACIÓN DE CITAS

        // PAGINACIÓN
        $d = self::paginacionCalendario();

        // OBTENEMOS LOS INTERVALOS
        // include('model/intervalosDao.php');
        $consultaIntervalos = new IntervalosDao();
        $intervalos = $consultaIntervalos->select_intervalos();
        // var_dump($intervalos);
        
        //OBTENEMOS LAS RESERVAS
        // include('model/CitasDao.php');
        $consultaCitas = new CitasDao();
        $citas = $consultaCitas->select_citas();
        // var_dump($citas);

        // PARA TENER GUARDADO EL ANIMAL AL QUE QUEREMOS PEDIR CITA
        if ($_REQUEST['anularCita']!='') {
            $_SESSION['anularCitaAnimal'] = $_REQUEST['anularCita'];
        }

        // RECIBIMOS LOS DATOS DE LA ANULACIÓN
        if (isset($_REQUEST['anular'])) {

            $fechaReserva = $_REQUEST['fecha'];
            $animal = $_REQUEST['anular'];
            $intervalo = $_REQUEST['intervalo'];
            $borrar = false;

            // VERIFICAMOS LOS DATOS RECIBIDOS POR URL
            for ($i=0; $i < count($citas); $i++) {
                if ($citas[$i]['fecha']!=$fechaReserva && $citas[$i]['intervalo']!=$intervalo) {
                    if ($animal == $_SESSION['anularCitaAnimal']) {
                        // SI TODO ES CORRECTO ANULAMOS CITA
                        $borrar = true;
                    }
                }
            }

            if ($borrar) {
                $idIntervalo = '';
                for ($j=0; $j < count($intervalos); $j++) { 
                    if ($intervalos[$j]['idIntervalo']==$intervalo) {
                        $idIntervalo = $intervalos[$j]['idIntervalo'];
                        $idIntervalo = intval($idIntervalo);
                        // var_dump($idIntervalo);
                    }
                }
                for ($j=0; $j < count($_SESSION['nombreAnimales']); $j++) { 
                    if ($_SESSION['nombreAnimales'][$j]['NomAnimal']==$animal) {
                        $numHistorial = $_SESSION['nombreAnimales'][$j]['NumHistorial'];
                    }
                }
                // echo $fechaReserva.' '.$idIntervalo.' '.$numHistorial;
                $consultaCitas = new CitasDao();
                $consultaCitas->delete_citas($fechaReserva,$idIntervalo,$numHistorial);
                header('Location: index.php?ctl=paginaAnularCitaLogged&anularCita');
            }
        }

        include('view/headerLogin.php');
        include('view/tablaAnularCita.php');
        include('view/footer.php');
        
    }
    public function cerrarSesionLogged() {
        
        // CERRAR SESIÓN
        session_destroy();
        $_SESSION = NULL;
        header('Location: index.php?ctl=paginaHomeNoLogged');
        
    }
    public function paginacionCalendario() {

        // PAGINACIÓN
        if (isset($_REQUEST['primero'])) {
            $d = strtotime("Monday this week");
            $_SESSION['time'] = $d;
        } else {
            if (isset($_REQUEST['pagina'])) {
                if ($_REQUEST['pagina']=='anterior') {
                    $_SESSION['time']-=604800;
                }else if ($_REQUEST['pagina']=='siguiente') {
                    $_SESSION['time']+=604800;
                }
            }
        }

        $d = $_SESSION['time'];
        return $d;
    }
    public function ver_vacunas(){
        $this->homeLogged();

        $consulta = new RegistroVacunasDao();
        $info = $consulta->select_informacion_cliente_animal($_SESSION['idCliente'],(int)$_REQUEST['generar']);
        // var_dump($info);
        $nomAnimal = $info['NomAnimal'];
        $fotoAnimal = $info['nombreFoto'];

        $consulta = new RegistroVacunasDao();
        $vacunas = $consulta->select_vacunas_animal((int)$_REQUEST['generar']);
        // var_dump($vacunas);

        if ($vacunas==null) {
            include('view/headerLogin.php');
            include('view/noEncontrado.php');
            include('view/footer.php');
        } else {
            include('view/headerLogin.php');
            include('view/tablaListaVacunas.php');
            include('view/footer.php');
        }

    }
}