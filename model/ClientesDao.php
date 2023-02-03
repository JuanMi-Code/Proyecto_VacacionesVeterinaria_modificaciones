<?php
include_once('database/Conectar.php');
class ClientesDao
{
    private $conexion;
    public function __construct()
    {
        $this->conexion = Conectar::conexion();
    }
    public function select_alias($idCliente)
    {
        try {
            $sql = "SELECT NomCliente as nombre, foto FROM clientes WHERE idCliente = ?;";
            $consulta = $this->conexion->prepare($sql);
            $consulta->bindParam(1, $idCliente);
            $valor_devuelto = $consulta->execute();
            $informacion = $consulta->fetch(PDO::FETCH_ASSOC);
            $consulta->closeCursor();
            $this->cerrar_conexion();
        } catch (PDOException $e) {
            echo "<br>Error:" . $e->getMessage();
            echo "<br>Código del error:" . $e->getCode();
            echo "<br>Fichero error:" . $e->getFile();
            echo "<br>Línea del error:" . $e->getLine();
            exit;
        }
        return $informacion;
    }
    public function select_nif($nif) {
        try {
            $sql = "SELECT NIF FROM clientes WHERE NIF = ?;";

            $consulta = $this->conexion->prepare($sql);
            $consulta->bindParam(1, $nif);
            $valor_devuelto = $consulta->execute();
            $informacion = $consulta->fetch(PDO::FETCH_ASSOC);
            $consulta->closeCursor();
            $this->cerrar_conexion();
        } catch (PDOException $e) {
            echo "<br>Error:" . $e->getMessage();
            echo "<br>Código del error:" . $e->getCode();
            echo "<br>Fichero error:" . $e->getFile();
            echo "<br>Línea del error:" . $e->getLine();
            exit;
        }
        return $informacion;
    }
    public function select_activo($idCliente)
    {
        try {
            $sql = "SELECT activo FROM clientes WHERE idCliente = ?;";
            $consulta = $this->conexion->prepare($sql);
            $consulta->bindParam(1, $idCliente);
            $valor_devuelto = $consulta->execute();
            $activo = $consulta->fetch(PDO::FETCH_ASSOC);
            $consulta->closeCursor();
            $this->cerrar_conexion();
        } catch (PDOException $e) {
            echo "<br>Error:" . $e->getMessage();
            echo "<br>Código del error:" . $e->getCode();
            echo "<br>Fichero error:" . $e->getFile();
            echo "<br>Línea del error:" . $e->getLine();
            exit;
        }
        return $activo;
    }
    public function select_clientes()
    {
        try {
            $sql = "SELECT idCliente, NomCliente, apellidos, NIF FROM clientes";
            $consulta = $this->conexion->prepare($sql);
            $valor_devuelto = $consulta->execute();
            while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
                $clientes[] = $fila;
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
        return $clientes;
    }
    private function cerrar_conexion()
    {
        $this->conexion = NULL;
    }
}
