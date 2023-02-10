<?php
// include_once('database/Conectar.php');
class AnimalesDao
{
    private $conexion;
    public function __construct()
    {
        $this->conexion = Conectar::conexion();
    }
    public function select_nombreAnimales($idCliente)
    {
        try {
            $sql = "SELECT NomAnimal,NumHistorial FROM animales WHERE idCliente = ?;";
            $consulta = $this->conexion->prepare($sql);
            $consulta->bindParam(1, $idCliente, PDO::PARAM_INT);
            $valor_devuelto = $consulta->execute();
            while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
                $animales[] = $fila;
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
        return $animales;
    }
    public function select_idTipo($numHistorial)
    {
        try {
            $sql = "SELECT idTipo FROM animales WHERE NumHistorial = ?;";
            $consulta = $this->conexion->prepare($sql);
            $consulta->bindParam(1, $numHistorial, PDO::PARAM_INT);
            $valor_devuelto = $consulta->execute();
            $tipo = $consulta->fetch(PDO::FETCH_ASSOC);
            $consulta->closeCursor();
            $this->cerrar_conexion();
        } catch (PDOException $e) {
            echo "<br>Error:" . $e->getMessage();
            echo "<br>Código del error:" . $e->getCode();
            echo "<br>Fichero error:" . $e->getFile();
            echo "<br>Línea del error:" . $e->getLine();
            exit;
        }
        return $tipo;
    }
    public function select_animal($numHistorial)
    {
        try {
            $sql = "SELECT an.NomAnimal, ti.NombreTipo, fo.nombreFoto
                    FROM animales an
                        JOIN tipoanimal ti on ti.idTipo = an.idTipo
                        JOIN fotosani fo on fo.NumHistorial=an.NumHistorial
                    WHERE an.NumHistorial = ?;";
            $consulta = $this->conexion->prepare($sql);
            $consulta->bindParam(1, $numHistorial, PDO::PARAM_INT);
            $valor_devuelto = $consulta->execute();
            $info = $consulta->fetch(PDO::FETCH_ASSOC);
            $consulta->closeCursor();
            $this->cerrar_conexion();
        } catch (PDOException $e) {
            echo "<br>Error:" . $e->getMessage();
            echo "<br>Código del error:" . $e->getCode();
            echo "<br>Fichero error:" . $e->getFile();
            echo "<br>Línea del error:" . $e->getLine();
            exit;
        }
        return $info;
    }
    public function insertarAnimal($idCliente,$nombre,$tipo,$imagen) {
        try {
            $sql = "INSERT INTO animales(NumHistorial, NomAnimal, idTipo, idCliente) 
                    VALUES (NumHistorial,?,?,?)";
            
                $this->conexion->beginTransaction();
            $consulta = $this->conexion->prepare($sql);
            $consulta->bindParam(1, $nombre);
            $consulta->bindParam(2, $tipo, PDO::PARAM_INT);
            $consulta->bindParam(3, $idCliente, PDO::PARAM_INT);
            $valor_devuelto = $consulta->execute();
                $numHistorial = $this->conexion->lastInsertId();
            $info = $consulta->fetch(PDO::FETCH_ASSOC);
                self::insertarFotoAnimal($numHistorial,$imagen);
                $this->conexion->commit();
            $consulta->closeCursor();
            $this->cerrar_conexion();

        } catch (PDOException $e) {
                $this->conexion->rollBack();
            echo "<br>Error:" . $e->getMessage();
            echo "<br>Código del error:" . $e->getCode();
            echo "<br>Fichero error:" . $e->getFile();
            echo "<br>Línea del error:" . $e->getLine();
            exit;
        }
    }
    private function insertarFotoAnimal($numHistorial,$imagen){
        try {
            $sql = "INSERT INTO fotosani(idfoto, NumHistorial, nombreFoto) 
                    VALUES (idfoto,?,?)";

            $consulta = $this->conexion->prepare($sql);
            $consulta->bindParam(1, $numHistorial, PDO::PARAM_INT);
            $consulta->bindParam(2, $imagen);
            $valor_devuelto = $consulta->execute();
            $informacion = $consulta->fetch();

        } catch (PDOException $e) {
            $this->conexion->rollBack();
            echo "<br>Error:" . $e->getMessage();
            echo "<br>Código del error:" . $e->getCode();
            echo "<br>Fichero error:" . $e->getFile();
            echo "<br>Línea del error:" . $e->getLine();
            exit;
        }
    }
    public function eliminarAnimal($idCliente,$numHistorial){
        try {
            $sql = "DELETE FROM animales WHERE NumHistorial=? AND idCliente=?";

            $consulta = $this->conexion->prepare($sql);
            $consulta->bindParam(1, $numHistorial, PDO::PARAM_INT);
            $consulta->bindParam(2, $idCliente, PDO::PARAM_INT);
            $valor_devuelto = $consulta->execute();
            $informacion = $consulta->fetch();
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
