<?php
include_once('database/Conectar.php');
class Registro
{
    private $conexion;
    public function __construct()
    {
        $this->conexion = Conectar::conexion();
    }
    public function insertarCliente() {
        try {
            $sql = "INSERT INTO clientes (idCliente, NIF, NomCliente, Apellidos, foto, Correo, activo, token) VALUES (idCliente,?,?,?,?,?,?,?)";

            $activo = 0;

            $this->conexion->beginTransaction();
            $consulta = $this->conexion->prepare($sql);
            $consulta->bindParam(1, $_SESSION['Registro_nif']);
            $consulta->bindParam(2, $_SESSION['Registro_nombre']);
            $consulta->bindParam(3, $_SESSION['Registro_apellidos']);
            $consulta->bindParam(4, $_SESSION['Registro_imagenPersona']);
            $consulta->bindParam(5, $_SESSION['Registro_correo']);
            $consulta->bindParam(6, $activo);
            $consulta->bindParam(7, $_SESSION['Registro_token']);
            $valor_devuelto = $consulta->execute();
            //ultima id insertada
            $idCliente = $this->conexion->lastInsertId();
            $informacion = $consulta->fetch();

            //insertar en las otras tablas de la bbdd
            self::insertarValidar($idCliente);
            $NumHistorial=self::insertarAnimal($idCliente);
            self::insertarFotoAni($NumHistorial);

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
    private function insertarValidar($idCliente) {

        try {
            $sql = "INSERT INTO validar (idcliente, clave, alias) VALUES (?,?,?)";

            $consulta = $this->conexion->prepare($sql);
            $consulta->bindParam(1, $idCliente, PDO::PARAM_INT);
            $consulta->bindParam(2, $_SESSION['Registro_claveHash']);
            $consulta->bindParam(3, $_SESSION['Registro_alias']);
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
    private function insertarAnimal($idCliente) {
        try {
            $sql = "INSERT INTO animales (NumHistorial, NomAnimal, idTipo, idCliente) VALUES (NumHistorial,?,?,?)";

            $consulta = $this->conexion->prepare($sql);
            $consulta->bindParam(1, $_SESSION['Registro_nombreAnimal']);
            $consulta->bindParam(2, $_SESSION['Registro_tipoAnimal'], PDO::PARAM_INT);
            $consulta->bindParam(3, $idCliente, PDO::PARAM_INT);
            $valor_devuelto = $consulta->execute();
            $numHistorial = $this->conexion->lastInsertId();
            $informacion = $consulta->fetch();

        } catch (PDOException $e) {
            $this->conexion->rollBack();
            echo "<br>Error:" . $e->getMessage();
            echo "<br>Código del error:" . $e->getCode();
            echo "<br>Fichero error:" . $e->getFile();
            echo "<br>Línea del error:" . $e->getLine();
            exit;
        }
        return $numHistorial;
    }
    private function insertarFotoAni($NumHistorial) {
        try {
            $sql = "INSERT INTO fotosani (idfoto, NumHistorial, nombreFoto) VALUES (idfoto,?,?)";

            $consulta = $this->conexion->prepare($sql);
            $consulta->bindParam(1, $NumHistorial, PDO::PARAM_INT);
            $consulta->bindParam(2, $_SESSION['Registro_imagenAnimal']);

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
    public function update_cliente($idCliente) {
        try {
            $sql = "UPDATE clientes SET activo=? WHERE idCliente=?";

            $activo = 1;
            $consulta = $this->conexion->prepare($sql);
            $consulta->bindParam(1, $activo, PDO::PARAM_INT);
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
