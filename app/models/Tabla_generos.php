<?php
require_once(__DIR__ . "/../config/Conecct.php");

class Tabla_generos
{
    private $connect;
    private $table = 'generos';
    private $primary_key = 'id_genero';

    public function __construct()
    {
        $db = new Conecct();
        $this->connect = $db->conecct;
    }

    //---------------------------
    // CRUD: Create | Read | Update | Delete
    //---------------------------

    // Leer todos los géneros registrados
    public function readAllGeneros()
    {
        $sql = "SELECT * FROM " . $this->table . " WHERE estatus_genero = 1 ORDER BY nombre_genero;";
        try {
            $stmt = $this->connect->prepare($sql);
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            $stmt->execute();
            $generos = $stmt->fetchAll();
            return (!empty($generos)) ? $generos : array();
        } catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
            return array();
        }
    }
}
