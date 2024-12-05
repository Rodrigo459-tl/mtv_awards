<?php
require_once(__DIR__ . "/../config/Conecct.php");

class Tabla_artistas
{
    private $connect;
    private $table = 'artistas';
    private $primary_key = 'id_artista';

    public function __construct()
    {
        $db = new Conecct();
        $this->connect = $db->conecct;
    }

    //---------------------------
    // QUERIES: CRUD
    //--------------------------

    /**
     * Lee todos los registros de la tabla artistas
     * 
     * @return array Lista de artistas o un array vacío
     */
    public function createArtista($data = array())
    {
        // Verificar que los datos no estén vacíos
        if (empty($data)) {
            throw new InvalidArgumentException("No se proporcionaron datos para insertar.");
        }

        // Generar dinámicamente los campos y los valores
        $fields = implode(", ", array_keys($data));
        $values = ":" . implode(", :", array_keys($data));

        // SQL QUERY - INSERT
        $sql = "INSERT INTO " . $this->table . " ($fields) VALUES($values)";

        try {
            // Preparar la declaración SQL
            $stmt = $this->connect->prepare($sql);

            // Asociar dinámicamente los valores
            foreach ($data as $key => $value) {
                $stmt->bindValue(":" . $key, $value);
            }

            // Ejecutar la declaración
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
            return false;
        }
    }
    public function readAllArtists()
    {
        $sql = "SELECT * FROM " . $this->table . " ORDER BY pseudonimo_artista;";
        try {
            $stmt = $this->connect->prepare($sql);
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            $stmt->execute();
            $artists = $stmt->fetchAll();
            return (!empty($artists)) ? $artists : array();
        } catch (PDOException $e) {
            echo "Error in query: " . $e->getMessage();
        }
    }

    /**
     * Lee un registro específico por su ID
     * 
     * @param int $id_artista ID del artista
     * @return object Información del artista o un array vacío
     */
    public function readGetArtist($id_artista = 0)
    {
        $sql = "SELECT * FROM " . $this->table . " WHERE " . $this->primary_key . " = :id_artista;";
        try {
            $stmt = $this->connect->prepare($sql);
            $stmt->bindValue(":id_artista", $id_artista, PDO::PARAM_INT);
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            $stmt->execute();
            $artist = $stmt->fetch();
            return (!empty($artist)) ? $artist : array();
        } catch (PDOException $e) {
            echo "Error in query: " . $e->getMessage();
        }
    }

    /**
     * Actualiza los datos de un artista
     * 
     * @param int $id_artista ID del artista
     * @param array $data Datos a actualizar
     * @return bool True si se ejecuta correctamente, False si ocurre un error
     */
    public function updateArtist($id_artista = 0, $data = array())
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

            $stmt->bindValue(":id", $id_artista);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error in query: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Elimina un artista por su ID
     * 
     * @param int $id_artista ID del artista
     * @return bool True si se ejecuta correctamente, False si ocurre un error
     */
    public function deleteArtist($id_artista = 0)
    {
        try {
            $sql = 'DELETE FROM ' . $this->table . ' WHERE ' . $this->primary_key . ' = :id;';
            $stmt = $this->connect->prepare($sql);
            $stmt->bindValue(":id", $id_artista);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo 'Error in query: ' . $e->getMessage();
            return false;
        }
    }
}
