<?php
// include_once('database/Conectar.php');
class FotosaniDao
{
    private $conexion;
    public function __construct()
    {
        $this->conexion = Conectar::conexion();
    }
    public function select_cantidadFotos($idCliente)
    {
        try {
            $sql = "SELECT count(an.NomAnimal) as cantidad
            FROM fotosani as fo
            JOIN animales as an on an.NumHistorial = fo.NumHistorial
            JOIN clientes as cl on cl.idCliente = an.idCliente
            JOIN tipoanimal as ti on ti.idTipo = an.idTipo
        WHERE cl.idCliente = ?;";
            $consulta = $this->conexion->prepare($sql);
            $consulta->bindParam(1, $idCliente);
            $valor_devuelto = $consulta->execute();
            $cantidad = $consulta->fetch(PDO::FETCH_ASSOC);
            $consulta->closeCursor();
            $this->cerrar_conexion();
        } catch (PDOException $e) {
            echo "<br>Error:" . $e->getMessage();
            echo "<br>Código del error:" . $e->getCode();
            echo "<br>Fichero error:" . $e->getFile();
            echo "<br>Línea del error:" . $e->getLine();
            exit;
        }
        return $cantidad;
    }
    public function select_nombreFoto($idCliente,$limite1,$limite2)
    {
        try {
            $sql = "SELECT an.NomAnimal as nombre, fo.nombreFoto as foto, ti.NombreTIpo as especie
            FROM fotosani as fo
            JOIN animales as an on an.NumHistorial = fo.NumHistorial
            JOIN clientes as cl on cl.idCliente = an.idCliente
            JOIN tipoanimal as ti on ti.idTipo = an.idTipo
        WHERE cl.idCliente = ?
        LIMIT ?,?;";
            $consulta = $this->conexion->prepare($sql);
            $consulta->bindParam(1, $idCliente);
            $consulta->bindParam(2, $limite1, PDO::PARAM_INT);
            $consulta->bindParam(3, $limite2, PDO::PARAM_INT);
            $valor_devuelto = $consulta->execute();
            while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
                $fotos[] = $fila;
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
        return $fotos;
    }
    public function actualizarFoto($numHistorial,$nuevaFoto){
        // var_dump($nuevaFoto);
        try {
            $sql = "UPDATE fotosani SET nombreFoto=? WHERE NumHistorial=?";

            $consulta = $this->conexion->prepare($sql);
            $consulta->bindParam(1, $nuevaFoto);
            $consulta->bindParam(2, $numHistorial, PDO::PARAM_INT);
            $valor_devuelto = $consulta->execute();
            $consulta->fetch(PDO::FETCH_ASSOC);
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
    public function select_una_foto_ani($animal){
        try {
            $sql = "SELECT nombreFoto FROM fotosani WHERE NumHistorial=?";

            $consulta = $this->conexion->prepare($sql);
            $consulta->bindParam(1, $animal, PDO::PARAM_INT);
            $valor_devuelto = $consulta->execute();
            $info=$consulta->fetch(PDO::FETCH_ASSOC);
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
    private function cerrar_conexion()
    {
        $this->conexion = NULL;
    }
}
