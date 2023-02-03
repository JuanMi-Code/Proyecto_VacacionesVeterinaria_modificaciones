<?php
// use Dompdf\Positioner\Absolute;
require "vendor/autoload.php";
use Dompdf\Dompdf;
class ControladorPDF{

    public function funcionPdf() {

        $info = new ControladorLogged();
        $info->homeLogged();

        $consulta = new RegistroVacunasDao();
        $info = $consulta->select_informacion_cliente_animal($_SESSION['idCliente'],(int)$_REQUEST['anim']);
        var_dump($info);
        $_SESSION['pdf']['nomAnimal'] = $info['NomAnimal'];
        $_SESSION['pdf']['nombreFoto'] = $info['nombreFoto'];

        $consulta = new RegistroVacunasDao();
        $vacunas = $consulta->select_vacunas_animal((int)$_REQUEST['anim']);

        include('view/headerLogin.php');
        self::generarPDF('HojaVacunas'.$_SESSION['pdf']['nomAnimal'].'.pdf',$vacunas);
        unlink('web/cartillas/HojaVacunas'.$_SESSION['pdf']['nomAnimal'].'.pdf');
        
        // Para pruebas con vista
        // $ruta = dirname($_SERVER['HTTP_REFERER']) . '/';
        // include('view/CartillaPdf.php');
    }
    private static function generarPDF($fichero,$vacunas) {

        $ruta = dirname($_SERVER['HTTP_REFERER']) . '/';

        $consulta = new AnimalesDao();
        $info=$consulta->select_animal((int)$_REQUEST['anim']);

        $consulta = new RegistroVacunasDao();
        $infoVet = $consulta->select_ultim_vet((int)$_REQUEST['anim']);

        $fotoAnimal = $ruta.'web/animales/'.$info['nombreFoto'];
        $nombreAnimal=$info['NomAnimal'];
        $razaAnimal=$info['NombreTipo'];
        $idAnimal=$_REQUEST['anim'];
        $nombreVeterinario=$infoVet['NombreCompleto'];
        $numVeterinario=$infoVet['numColegiado'];
        $firmaVeterinario=$ruta.'web/veterinarios/'.$infoVet['FirmaRegistrada'];
        $selloClinica=$ruta.'web/veterinaria/logo.png';

        $consulta = new RegistroVacunasDao();
        $infoVacunas = $consulta->select_vacunas_animal_pdf((int)$_REQUEST['anim']);

        // var_dump($infoVacunas);

        // $fichero es un nombre.pdf

        //Creamos un objeto de la clase DOMPDF y le indicamos que vamos a utilizar direcciones URL
        $dompdf = new Dompdf(array('enable_remote' => true,'isHtml5ParserEnabled' => true));
        //Hemos generado el archivo pdf mediante una vista HTML
        ob_clean();
        ob_start();
        include 'view/CartillaPdf.php';
        $html = ob_get_clean();
        // exit;
        $dompdf->loadHtml($html);
        $dompdf->render();
        $datos = $dompdf->output();
        //guarda el archivo pdf en la ruta indicada en el servidor
        // file_put_contents("web/cartillas/$fichero", $datos);
        header("Content-type:application/pdf");
        header('Content-Disposition:attachment; filename="' . $fichero . '"');
        // header('Content-disposition: inline;');
        // ob_clean();
        echo $datos;
        ob_clean();
    }

}
?>