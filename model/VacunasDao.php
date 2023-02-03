<?php
include_once('database/Conectar.php');
class VacunasDao
{
    private $conexion;
    public function __construct()
    {
        $this->conexion = Conectar::conexion();
    }
    public function select_vacunas($idTipo)
    {
        try {
            $sql = "SELECT idVacuna, nombreVacuna FROM vacunas WHERE tipoAnimal = ?;";
            $consulta = $this->conexion->prepare($sql);
            $consulta->bindParam(1, $idTipo, PDO::PARAM_INT);
            $valor_devuelto = $consulta->execute();
            while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
                $vacunas[] = $fila;
            }
            $consulta->closeCursor();
            $this->cerrar_conexion();
        } catch (PDOException $e) {
            echo "<br>Error:" . $e->getMessage();
            echo "<br>Código del error:" . $e->getCode();
            echo "<br>Fichero error:" . $e->getFile();
            echo "<br>Línea del error:" . $e->getLine();
            exit;
        }
        return $vacunas;
    }
    public function select_vacuna_id($idVacuna)
    {
        try {
            $sql = "SELECT nombreVacuna FROM vacunas WHERE idVacuna = ?;";
            $consulta = $this->conexion->prepare($sql);
            $consulta->bindParam(1, $idVacuna, PDO::PARAM_INT);
            $valor_devuelto = $consulta->execute();
            $vacuna = $consulta->fetch(PDO::FETCH_ASSOC);
            $consulta->closeCursor();
            $this->cerrar_conexion();
        } catch (PDOException $e) {
            echo "<br>Error:" . $e->getMessage();
            echo "<br>Código del error:" . $e->getCode();
            echo "<br>Fichero error:" . $e->getFile();
            echo "<br>Línea del error:" . $e->getLine();
            exit;
        }
        return $vacuna;
    }
    private function cerrar_conexion()
    {
        $this->conexion = NULL;
    }
}
