<?php
include_once('database/Conectar.php');
class CitasDao
{
    private $conexion;
    public function __construct()
    {
        $this->conexion = Conectar::conexion();
    }
    public function select_citas()
    {
        try {
            $sql = "SELECT ci.fecha as fecha, inte.texto as intervalo, an.NomAnimal as nombreAnimal
                    FROM citas as ci
                    JOIN intervalos as inte on inte.idIntervalo = ci.idIntervalo
                    JOIN animales as an on an.NumHistorial = ci.NumHistorial";
            $consulta = $this->conexion->prepare($sql);
            $valor_devuelto = $consulta->execute();
            while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
                $citas[] = $fila;
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
        return $citas;
    }
    public function insert_citas($fecha,$idIntervalo,$numHistorial)
    {
        try {
            $sql = "INSERT INTO citas (fecha, idIntervalo, NumHistorial) VALUES (?,?,?)";
            $consulta = $this->conexion->prepare($sql);
            $consulta->bindParam(1, $fecha);
            $consulta->bindParam(2, $idIntervalo, PDO::PARAM_INT);
            $consulta->bindParam(3, $numHistorial, PDO::PARAM_INT);
            $valor_devuelto = $consulta->execute();
            $consulta->closeCursor();
            $this->cerrar_conexion();
        } catch (PDOException $e) {
            echo "<br>Error:" . $e->getMessage();
            echo "<br>Código del error:" . $e->getCode();
            echo "<br>Fichero error:" . $e->getFile();
            echo "<br>Línea del error:" . $e->getLine();
            exit;
        }
    }
    public function delete_citas($fecha,$idIntervalo,$numHistorial)
    {
        try {
            $sql = "DELETE FROM citas where fecha=? and idIntervalo=? and NumHistorial=?";
            $consulta = $this->conexion->prepare($sql);
            $consulta->bindParam(1, $fecha);
            $consulta->bindParam(2, $idIntervalo, PDO::PARAM_INT);
            $consulta->bindParam(3, $numHistorial, PDO::PARAM_INT);
            $valor_devuelto = $consulta->execute();
            $consulta->closeCursor();
            $this->cerrar_conexion();
        } catch (PDOException $e) {
            echo "<br>Error:" . $e->getMessage();
            echo "<br>Código del error:" . $e->getCode();
            echo "<br>Fichero error:" . $e->getFile();
            echo "<br>Línea del error:" . $e->getLine();
            exit;
        }
    }
    private function cerrar_conexion()
    {
        $this->conexion = NULL;
    }
}
