<?php
// include_once('database/Conectar.php');
class VeterinariosDao
{
    private $conexion;
    public function __construct()
    {
        $this->conexion = Conectar::conexion();
    }
    public function select_alias($alias)
    {
        try {
            $sql = "SELECT alias FROM veterinarios WHERE alias = ?;";
            $consulta = $this->conexion->prepare($sql);
            $consulta->bindParam(1, $alias);
            $valor_devuelto = $consulta->execute();
            $aliasdb = $consulta->fetch(PDO::FETCH_ASSOC);
            $consulta->closeCursor();
            $this->cerrar_conexion();
        } catch (PDOException $e) {
            echo "<br>Error:" . $e->getMessage();
            echo "<br>Código del error:" . $e->getCode();
            echo "<br>Fichero error:" . $e->getFile();
            echo "<br>Línea del error:" . $e->getLine();
            exit;
        }
        return $aliasdb;
    }
    public function select_clave_alias($alias)
    {
        try {
            $sql = "SELECT hash FROM veterinarios WHERE alias = ?;";
            $consulta = $this->conexion->prepare($sql);
            $consulta->bindParam(1, $alias);
            $valor_devuelto = $consulta->execute();
            $passwdHash = $consulta->fetch(PDO::FETCH_ASSOC);
            $consulta->closeCursor();
            $this->cerrar_conexion();
        } catch (PDOException $e) {
            echo "<br>Error:" . $e->getMessage();
            echo "<br>Código del error:" . $e->getCode();
            echo "<br>Fichero error:" . $e->getFile();
            echo "<br>Línea del error:" . $e->getLine();
            exit;
        }
        return $passwdHash;
    }
    public function select_todo_alias($alias)
    {
        try {
            $sql = "SELECT alias, numColegiado, NombreCompleto, FirmaRegistrada, fotoVet FROM veterinarios WHERE alias = ?;";
            $consulta = $this->conexion->prepare($sql);
            $consulta->bindParam(1, $alias);
            $valor_devuelto = $consulta->execute();
            $idcliente = $consulta->fetch(PDO::FETCH_ASSOC);
            $consulta->closeCursor();
            $this->cerrar_conexion();
        } catch (PDOException $e) {
            echo "<br>Error:" . $e->getMessage();
            echo "<br>Código del error:" . $e->getCode();
            echo "<br>Fichero error:" . $e->getFile();
            echo "<br>Línea del error:" . $e->getLine();
            exit;
        }
        return $idcliente;
    }
    public function select_idcliente_alias($alias)
    {
        try {
            $sql = "SELECT numColegiado FROM veterinarios WHERE alias = ?;";
            $consulta = $this->conexion->prepare($sql);
            $consulta->bindParam(1, $alias);
            $valor_devuelto = $consulta->execute();
            $idcliente = $consulta->fetch(PDO::FETCH_ASSOC);
            $consulta->closeCursor();
            $this->cerrar_conexion();
        } catch (PDOException $e) {
            echo "<br>Error:" . $e->getMessage();
            echo "<br>Código del error:" . $e->getCode();
            echo "<br>Fichero error:" . $e->getFile();
            echo "<br>Línea del error:" . $e->getLine();
            exit;
        }
        return $idcliente;
    }
    private function cerrar_conexion()
    {
        $this->conexion = NULL;
    }
}
