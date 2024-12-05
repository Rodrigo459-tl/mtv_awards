<?php
require_once(__DIR__ . "/../config/Conecct.php");

class Tabla_albumes
{
    private $connect;
    private $table = 'albumes';
    private $primary_key = 'id_album';

    public function __construct()
    {
        $db = new Conecct();
        $this->connect = $db->conecct;
    }

    //---------------------------
    // CRUD: Create | Read | Update | Delete
    //---------------------------
    public function createAlbum($data = array())
    {
        // Configurar campos dinámicamente
        $fields = implode(", ", array_keys($data));
        $values = ":" . implode(", :", array_keys($data));

        // Consulta SQL - INSERT
        $sql = "INSERT INTO " . $this->table . " ($fields) VALUES($values)";

        try {
            // Preparar la consulta
            $stmt = $this->connect->prepare($sql);

            // Vincular valores dinámicamente
            foreach ($data as $key => $value) {
                $stmt->bindValue(":" . $key, $value);
            }

            // Ejecutar consulta
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
            return false;
        }
    }

    public function readAllAlbums()
    {
        $sql = "SELECT * FROM " . $this->table . 
               " INNER JOIN artistas ON " . $this->table . ".id_artista = artistas.id_artista" .
               " INNER JOIN generos ON " . $this->table . ".id_genero = generos.id_genero" .
               " ORDER BY fecha_lanzamiento_album;";
        try {
            $stmt = $this->connect->prepare($sql);
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            $stmt->execute();
            $albums = $stmt->fetchAll();
            return (!empty($albums)) ? $albums : array();
        } catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
        }
    }

    public function readGetAlbum($id_album = 0)
    {
        $sql = "SELECT * FROM " . $this->table . 
               " INNER JOIN artistas ON " . $this->table . ".id_artista = artistas.id_artista" .
               " INNER JOIN generos ON " . $this->table . ".id_genero = generos.id_genero" .
               " WHERE " . $this->primary_key . " = :id_album;";
        try {
            $stmt = $this->connect->prepare($sql);
            $stmt->bindValue(":id_album", $id_album, PDO::PARAM_INT);
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            $stmt->execute();
            $album = $stmt->fetch();
            return (!empty($album)) ? $album : array();
        } catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
        }
    }

    public function updateAlbum($id_album = 0, $data = array())
    {
        $params = array();
        $fields = array();

        foreach ($data as $key => $value) {
            $params[":" . $key] = $value;
            $fields[] = "$key = :$key";
        }

        try {
            $setParams = implode(", ", $fields);
            $sql = 'UPDATE ' . $this->table . ' SET ' . $setParams . ' WHERE ' . $this->primary_key . ' = :id;';
            $stmt = $this->connect->prepare($sql);

            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            $stmt->bindValue(":id", $id_album);

            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
            return false;
        }
    }

    public function deleteAlbum($id_album = 0)
    {
        try {
            $sql = 'DELETE FROM ' . $this->table . ' WHERE ' . $this->primary_key . ' = :id;';
            $stmt = $this->connect->prepare($sql);
            $stmt->bindValue(":id", $id_album);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
            return false;
        }
    }
}
