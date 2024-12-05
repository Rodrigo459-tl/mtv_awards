<?php
require_once(__DIR__ . "/../config/Conecct.php");

class Tabla_canciones
{
    private $connect;
    private $table = 'canciones';
    private $primary_key = 'id_cancion';

    public function __construct()
    {
        $db = new Conecct();
        $this->connect = $db->conecct;
    }

    public function createCancion($data = array())
    {
        // Setting fields dynamically
        $fields = implode(", ", array_keys($data));

        // Setting values dynamically
        $values = ":" . implode(", :", array_keys($data));

        // SQL QUERY - INSERT
        $sql = "INSERT INTO " . $this->table . " ($fields) VALUES($values)";

        try {
            $stmt = $this->connect->prepare($sql);
            foreach ($data as $key => $value) {
                $stmt->bindValue(":" . $key, $value);
            }
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error in query: " . $e->getMessage();
            return false;
        }
    }

    public function readAllCanciones()
    {
        $sql = "SELECT * FROM " . $this->table . " ORDER BY nombre_cancion";
        try {
            $stmt = $this->connect->prepare($sql);
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            $stmt->execute();
            $canciones = $stmt->fetchAll();
            return (!empty($canciones)) ? $canciones : array();
        } catch (PDOException $e) {
            echo "Error in query: " . $e->getMessage();
        }
    }

    public function readGetCancion($id_cancion = 0)
    {
        $sql = "SELECT * FROM " . $this->table . " WHERE " . $this->primary_key . " = :id_cancion";
        try {
            $stmt = $this->connect->prepare($sql);
            $stmt->bindValue(":id_cancion", $id_cancion, PDO::PARAM_INT);
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            $stmt->execute();
            $cancion = $stmt->fetch();
            return (!empty($cancion)) ? $cancion : array();
        } catch (PDOException $e) {
            echo "Error in query: " . $e->getMessage();
        }
    }

    public function updateCancion($id_cancion = 0, $data = array())
    {
        $params = array();
        $fields = array();

        foreach ($data as $key => $value) {
            $params[":" . $key] = $value;
            $fields[] = "$key = :$key";
        }

        try {
            $setParams = implode(", ", $fields);
            $sql = 'UPDATE ' . $this->table . ' SET ' . $setParams . ' WHERE ' . $this->primary_key . ' = :id';
            $stmt = $this->connect->prepare($sql);

            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            $stmt->bindValue(":id", $id_cancion);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error in query: " . $e->getMessage();
            return false;
        }
    }

    public function deleteCancion($id_cancion = 0)
    {
        try {
            $sql = 'DELETE FROM ' . $this->table . ' WHERE ' . $this->primary_key . ' = :id';
            $stmt = $this->connect->prepare($sql);
            $stmt->bindValue(":id", $id_cancion);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo 'Error in query: ' . $e->getMessage();
            return false;
        }
    }
}
