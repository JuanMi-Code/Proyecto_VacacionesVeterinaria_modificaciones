<?php
include_once('../../database/Conectar.php');
class ClientesAnimalesDao {
    private $conexion;
    public function __construct()
    {
        $this->conexion = Conectar::conexion();
    }
    public function select_clientes() {
        try {
            $sql = "SELECT idCliente, NIF, nomCliente, Apellidos, foto, Correo FROM clientes;";
            $consulta = $this->conexion->prepare($sql);
            $valor_devuelto = $consulta->execute();
            while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
                $info[] = $fila;
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
        return $info;
    }
    // public function select_animales_cliente($idCliente) {
    //     try {
    //         $sql = "SELECT an.NumHistorial, an.NomAnimal, an.idTipo, ti.NombreTipo, fo.nombreFoto 
    //                     FROM animales an
    //                         JOIN tipoanimal ti on ti.idTipo=an.idTipo
    //                         JOIN fotosani fo on fo.NumHistorial=an.NumHistorial
    //                 WHERE idCliente=?;";
    //         $consulta = $this->conexion->prepare($sql);
    //         $consulta->bindParam(1, $idCliente);
    //         $valor_devuelto = $consulta->execute();
    //         while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
    //             $info[] = $fila;
    //         }
    //         $consulta->closeCursor();
    //         $this->cerrar_conexion();
    //     } catch (PDOException $e) {
    //         echo "<br>Error:" . $e->getMessage();
    //         echo "<br>Código del error:" . $e->getCode();
    //         echo "<br>Fichero error:" . $e->getFile();
    //         echo "<br>Línea del error:" . $e->getLine();
    //         exit;
    //     }
    //     return $info;
    // }
    public function select_animales_cliente($idCliente) {
        try {
            $sql = "SELECT an.NumHistorial, an.NomAnimal, an.idTipo, ti.NombreTipo
                        FROM animales an
                            JOIN tipoanimal ti on ti.idTipo=an.idTipo
                    WHERE idCliente=?;";
            $consulta = $this->conexion->prepare($sql);
            $consulta->bindParam(1, $idCliente);
            $valor_devuelto = $consulta->execute();
            while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
                $info[] = $fila;
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
        return $info;
    }
    public function select_fotos_animal($numHistorial) {
        try {
            $sql = "SELECT nombreFoto FROM fotosani WHERE NumHistorial=?;";
            $consulta = $this->conexion->prepare($sql);
            $consulta->bindParam(1, $numHistorial);
            $valor_devuelto = $consulta->execute();
            while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
                $info[] = $fila;
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
        return $info;
    }
    public function select_animales_id($id)
    {
        $info = [];
        try {
            $sql = "SELECT an.NomAnimal 
                    FROM animales an
                        JOIN clientes cl on cl.idCliente =  an.idCliente
                    WHERE cl.idCliente = ?;";
            $consulta = $this->conexion->prepare($sql);
            $consulta->bindParam(1, $id, PDO::PARAM_INT);
            $valor_devuelto = $consulta->execute();
            while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
                $info[] = $fila;
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
        return $info;
    }
    public function select_animales_cliente_paginado($idCliente,$inicio,$cantidad){
        $info = [];
        try {
            $sql = "SELECT an.NumHistorial, an.NomAnimal, an.idTipo, ti.NombreTipo
                        FROM animales an
                            JOIN tipoanimal ti on ti.idTipo=an.idTipo
                    WHERE idCliente=?
                    LIMIT ?,?;";
            $consulta = $this->conexion->prepare($sql);
            $consulta->bindParam(1, $idCliente, PDO::PARAM_INT);
            $consulta->bindParam(2, $inicio, PDO::PARAM_INT);
            $consulta->bindParam(3, $cantidad, PDO::PARAM_INT);
            $valor_devuelto = $consulta->execute();
            while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
                $info[] = $fila;
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
        return $info;
    }
    private function cerrar_conexion() {
        $this->conexion = NULL;
    }
}

?>