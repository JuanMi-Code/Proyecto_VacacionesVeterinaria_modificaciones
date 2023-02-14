<?php
// include_once('database/Conectar.php');
class tipoAnimalDao
{
    private $conexion;
    public function __construct()
    {
        $this->conexion = Conectar::conexion();
    }
    public function select_tipos()
    {
        try {
            $sql = "SELECT NombreTipo, idTipo FROM tipoanimal;";
            $consulta = $this->conexion->prepare($sql);
            $valor_devuelto = $consulta->execute();
            while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
                $tipos[] = $fila;
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
        return $tipos;
    }
    public function select_tipos_api()
    {
        try {
            $sql = "SELECT NombreTipo FROM tipoanimal;";
            $consulta = $this->conexion->prepare($sql);
            $valor_devuelto = $consulta->execute();
            while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
                $tipos[] = $fila;
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
        return $tipos;
    }
    private function cerrar_conexion()
    {
        $this->conexion = NULL;
    }
}
