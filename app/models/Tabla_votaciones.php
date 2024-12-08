<?php
require_once(__DIR__ . "/../config/Conecct.php");

class Tabla_votaciones
{
    private $connect;
    private $table = 'votaciones';
    private $primary_key = 'id_votacion';

    public function __construct()
    {
        $db = new Conecct();
        $this->connect = $db->conecct;
    }

    public function createVotacion($data = array())
    {
        $fields = implode(", ", array_keys($data));
        $values = ":" . implode(", :", array_keys($data));

        $sql = "INSERT INTO " . $this->table . " ($fields) VALUES($values)";

        try {
            $stmt = $this->connect->prepare($sql);
            foreach ($data as $key => $value) {
                $stmt->bindValue(":" . $key, $value);
            }
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error in query: " . $e->getMessage();
            echo "<br>SQL: " . $sql;
            return false;
        }
    }

    public function readAllVotaciones($id_usuario)
    {
        $sql = "SELECT v.* 
                FROM " . $this->table . " v
                WHERE v.id_usuario = :id_usuario
                ORDER BY v.id_votacion";
        try {
            $stmt = $this->connect->prepare($sql);
            $stmt->bindValue(":id_usuario", $id_usuario, PDO::PARAM_INT);
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            $stmt->execute();
            $votaciones = $stmt->fetchAll();
            return (!empty($votaciones)) ? $votaciones : array();
        } catch (PDOException $e) {
            echo "Error in query: " . $e->getMessage();
            return array();
        }
    }

    public function countVotacionesByAlbum($id_album)
    {
        $sql = "SELECT COUNT(*) AS total FROM " . $this->table . " WHERE id_album = :id_album";
        try {
            $stmt = $this->connect->prepare($sql);
            $stmt->bindValue(":id_album", $id_album, PDO::PARAM_INT);
            $stmt->execute();

            // Obtén el resultado como un número entero
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int) $result['total'];
        } catch (PDOException $e) {
            echo "Error in query: " . $e->getMessage();
            return 0; // Devuelve 0 en caso de error
        }
    }


    public function readGetVotacion($id_votacion)
    {
        $sql = "SELECT * FROM " . $this->table . " WHERE " . $this->primary_key . " = :id_votacion";
        try {
            $stmt = $this->connect->prepare($sql);
            $stmt->bindValue(":id_votacion", $id_votacion, PDO::PARAM_INT);
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            echo "Error in query: " . $e->getMessage();
            return null;
        }
    }
}
?>