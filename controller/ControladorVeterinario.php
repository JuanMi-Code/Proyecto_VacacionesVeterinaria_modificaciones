<?php
use Dompdf\Positioner\Absolute;
class ControladorVeterinario{

    private $nombreVeterinario;
    private $fotoVeterinario;

    private function datosUsuario() {
        $this->nombreVeterinario = $_SESSION['veterinario']['nombreCompleto'];
        $this->fotoVeterinario = 'web/veterinarios/'.$_SESSION['veterinario']['fotoVet'];
    }
    public function mainLogged() {
        self::datosUsuario();
        // Detalles Veterinario
        include('view/headerLoginVet.php');
        include('view/detallesVet.php');
        include('view/footer.php');
    }
    public function vacunar() {
        self::datosUsuario();

        $crearTabla = false;

        $consulta = new ClientesDao();
        $todosClientes=$consulta->select_clientes();
        // var_dump($todosClientes);

        // LLEGADA / ANALISIS DE CLIENTE
        if (isset($_REQUEST['elegirCliente'])||isset($_SESSION['vacunar']['idCliente'])) {
            if (!isset($_SESSION['vacunar']['idCliente'])||isset($_REQUEST['cliente'])&&$_SESSION['vacunar']['idCliente']!=$_REQUEST['cliente']) {
                if (isset($_REQUEST['cliente'])&&$_REQUEST['cliente']!=0) {
                    
// -----------------// LIMPIAMOS PARA QUE NO SE MEZCLEN DATOS (Animales de un usuario con Otro)
                    if (isset($_SESSION['vacunar']['numHistorial'])) {
                        $_SESSION['vacunar'] = null;
                    }
                    if (isset($_SESSION['vacunar']['idVacuna'])) {
                        $_SESSION['vacunar'] = null;
                    }
// -----------------
                    $_SESSION['vacunar']['idCliente'] = (int)$_REQUEST['cliente'];
                }
            }
            // var_dump($idCliente);

            $consulta = new AnimalesDao();
            $animales = $consulta->select_nombreAnimales($_SESSION['vacunar']['idCliente']);
            // var_dump($animales);
        }

        // LLEGADA / ANALISIS DE ANIMAL
        if (isset($_REQUEST['elegirAnimal'])||isset($_SESSION['vacunar']['numHistorial'])) {
            if (!isset($_SESSION['vacunar']['numHistorial'])||isset($_REQUEST['animal'])&&$_SESSION['vacunar']['numHistorial']!=$_REQUEST['animal']) {
                $_SESSION['vacunar']['numHistorial'] = (int)$_REQUEST['animal'];
            }
            // var_dump($numHistorial);

            $consulta = new AnimalesDao();
            $idTipo = $consulta->select_idTipo($_SESSION['vacunar']['numHistorial']);
            
            // var_dump($idTipo);

            $consulta = new VacunasDao();
            $vacunas = $consulta->select_vacunas($idTipo['idTipo']);
            // var_dump($vacunas);

        }

        // LLEGADA / ANALISIS DE VACUNA
        if (isset($_REQUEST['elegirVacuna'])||isset($_SESSION['vacunar']['idVacuna'])) {
            if (!isset($_SESSION['vacunar']['idVacuna'])||isset($_REQUEST['elegirVacuna'])&&$_SESSION['vacunar']['idVacuna']!=$_REQUEST['vacuna']) {
                $_SESSION['vacunar']['idVacuna'] = (int)$_REQUEST['vacuna'];
            }
            // var_dump($numHistorial);

            // var_dump($_SESSION);
            $crearTabla = true;

        }

        include('view/headerLoginVet.php');
        include('view/vacunar.php');
        
        if ($crearTabla) {

            $consulta = new RegistroVacunasDao();
            $info = $consulta->select_informacion_cliente_animal($_SESSION['vacunar']['idCliente'],$_SESSION['vacunar']['numHistorial']);
            // var_dump($info);
            $nombrePropietario=$info['NomCliente'].' '.$info['apellidos'];
            $nombreMascota=$info['NomAnimal'];
            $fotoAnimal = $info['nombreFoto'];
            $consulta = new VacunasDao();
            $nombreVacuna = $consulta->select_vacuna_id($_SESSION['vacunar']['idVacuna']);

            $hoy = getdate();
            $fechaActual = $hoy['mday'] . '-' . $hoy['mon'] . '-' . $hoy['year'];
            $fecha = $hoy['year'] . '-' . $hoy['mon'] . '-' . $hoy['mday'];
            $_SESSION['vacunar']['fecha']=$fecha;
            include('view/tablaVacunar.php');
        }

        include('view/footer.php');

    }
    public function insertar_Vacuna() {
        self::datosUsuario();

        $consulta = new RegistroVacunasDao();
        $consulta->insertar_registro();

        header("Location:index.php?ctl=paginaListaVacunas");

        // include('view/headerLoginVet.php');
        // include('view/vacunar.php');
        // include('view/footer.php');

    }

    public function tabla_lista_vacunacion() {
        self::datosUsuario();

        $consulta = new RegistroVacunasDao();
        $info = $consulta->select_informacion_cliente_animal($_SESSION['vacunar']['idCliente'],$_SESSION['vacunar']['numHistorial']);
        var_dump($info);
        $nomAnimal = $info['NomAnimal'];
        $fotoAnimal = $info['nombreFoto'];

        $consulta = new RegistroVacunasDao();
        $vacunas = $consulta->select_vacunas_animal($_SESSION['vacunar']['numHistorial']);

        include('view/headerLoginVet.php');
        include('view/tablaListaVacunas.php');
        include('view/footer.php');

    }

}
?>