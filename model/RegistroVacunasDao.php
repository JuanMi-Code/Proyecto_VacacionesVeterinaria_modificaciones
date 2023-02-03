<?php
include_once('database/Conectar.php');
class RegistroVacunasDao
{
    private $conexion;
    public function __construct()
    {
        $this->conexion = Conectar::conexion();
    }
    public function insertar_registro()
    {
        try {
            $sql = "INSERT INTO registrovacunas (idRegistro, numHistorial, idVacuna, numColegiado, fecha) 
                    VALUES (idRegistro,?,?,?,?);";
            
            $consulta = $this->conexion->prepare($sql);
            $consulta->bindParam(1, $_SESSION['vacunar']['numHistorial'], PDO::PARAM_INT);
            $consulta->bindParam(2, $_SESSION['vacunar']['idVacuna'], PDO::PARAM_INT);
            $consulta->bindParam(3, $_SESSION['veterinario']['numColegiado'], PDO::PARAM_INT);
            $consulta->bindParam(4, $_SESSION['vacunar']['fecha']);
            $valor_devuelto = $consulta->execute();
            var_dump($valor_devuelto);
            $consulta->fetch();
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
    public function select_informacion_cliente_animal($idCliente,$numHistorial)
    {
        try {
            $sql = "SELECT cl.NomCliente, cl.apellidos, an.NomAnimal, fo.nombreFoto
                    FROM clientes cl
                        JOIN animales an on an.idCliente=cl.idCliente
                        JOIN fotosani fo on fo.numHistorial=an.NumHistorial
                    WHERE cl.idCliente=?
                    AND an.NumHistorial=?";
            
            $consulta = $this->conexion->prepare($sql);
            $consulta->bindParam(1, $idCliente, PDO::PARAM_INT);
            $consulta->bindParam(2, $numHistorial, PDO::PARAM_INT);
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
    public function select_vacunas_animal($numHistorial)
    {
        try {
            $sql = "SELECT va.nombreVacuna, re.fecha, ve.NombreCompleto 
                    FROM vacunas va 
                        JOIN registrovacunas re on re.idVacuna = va.idVacuna 
                        JOIN veterinarios ve on ve.numColegiado=re.numColegiado 
                    WHERE re.numHistorial = ? 
                    ORDER BY re.fecha DESC";
            
            $consulta = $this->conexion->prepare($sql);
            $consulta->bindParam(1, $numHistorial, PDO::PARAM_INT);
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
        if (isset($vacunas)) {
            return $vacunas;
        } else {
            return null;
        }
    }
    public function select_ultim_vet($numHistorial)
    {
        try {
            $sql = "SELECT ve.NombreCompleto, ve.numColegiado, ve.FirmaRegistrada
                    FROM veterinarios ve
                        JOIN registrovacunas re on re.numColegiado=ve.numColegiado
                        JOIN animales an on an.NumHistorial=re.NumHistorial
                    WHERE an.numHistorial=?
                    GROUP BY re.idRegistro DESC";
            
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
    public function select_vacunas_animal_pdf($numHistorial)
    {
        try {
            $sql = "SELECT va.nombreVacuna, re.fecha, ve.numColegiado, ve.FirmaRegistrada 
                    FROM vacunas va 
                        JOIN registrovacunas re on re.idVacuna = va.idVacuna 
                        JOIN veterinarios ve on ve.numColegiado=re.numColegiado 
                    WHERE re.numHistorial = ? 
                    ORDER BY re.fecha DESC";
            
            $consulta = $this->conexion->prepare($sql);
            $consulta->bindParam(1, $numHistorial, PDO::PARAM_INT);
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
    private function cerrar_conexion()
    {
        $this->conexion = NULL;
    }
}
