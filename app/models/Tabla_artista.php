<?php
require_once(__DIR__ . "/../config/Conecct.php");

class Tabla_artista
{
    private $connect;
    private $table = 'artistas';
    private $primary_key = 'id_artista';

    public function __construct()
    {
        $db = new Conecct();
        $this->connect = $db->conecct;
    } //end __construct

    //---------------------------
    // QUERIES : CRUD
    //---------------------------

    public function createArtista($data = array())
    {
        // Configuración de campos dinámicamente
        $fields = implode(", ", array_keys($data));

        // Configuración de valores dinámicamente
        $values = ":" . implode(", :", array_keys($data));

        // SQL QUERY - INSERT
        $sql = "INSERT INTO " . $this->table . " ($fields) VALUES($values)";

        try {
            // Preparar la consulta
            $stmt = $this->connect->prepare($sql);

            // Vincular valores dinámicamente
            foreach ($data as $key => $value) {
                $stmt->bindValue(":" . $key, $value);
            }

            // Ejecutar SQL
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
            return false;
        }
    } //end createArtista

    public function readAllArtists()
    {
        /**
         * QUERY - SELECT
         * SELECT * FROM artistas INNER JOIN generos ON artistas.id_genero = generos.id_genero ORDER BY pseudonimo_artista;
         */
        $sql = "SELECT * FROM " . $this->table . " INNER JOIN generos ON " . $this->table . ".id_genero = generos.id_genero ORDER BY pseudonimo_artista;";
        try {
            // Preparar la consulta
            $stmt = $this->connect->prepare($sql);
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            $stmt->execute();
            $artists = $stmt->fetchAll();
            return (!empty($artists)) ? $artists : array();
        } catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
        }
    } //end readAllArtists

    public function readGetArtist($id_artista = 0)
    {
        /**
         * QUERY - SELECT
         * SELECT * FROM artistas INNER JOIN generos ON artistas.id_genero = generos.id_genero WHERE artistas.id_artista = :id_artista;
         */
        $sql = "SELECT * FROM " . $this->table . " INNER JOIN generos ON " . $this->table . ".id_genero = generos.id_genero 
                WHERE " . $this->table . "." . $this->primary_key . " = :id_artista;";
        try {
            // Preparar la consulta
            $stmt = $this->connect->prepare($sql);
            $stmt->bindValue(":id_artista", $id_artista, PDO::PARAM_INT);
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            $stmt->execute();
            $artist = $stmt->fetch();
            return (!empty($artist)) ? $artist : array();
        } catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
        }
    } //end readGetArtist

    public function updateArtist($id_artista = 0, $data = array())
    {
        /**
         * UPDATE artistas SET pseudonimo_artista = '', nacionalidad_artista = '' WHERE id_artista = ;
         */

        $params = array();
        $fields = array();

        foreach ($data as $key => $value) {
            $params[":" . $key] = $value;
            $fields[] = "$key = :$key";
        }

        try {
            $setParams = implode(", ", $fields);

            // SQL QUERY - UPDATE
            $sql = 'UPDATE ' . $this->table . ' SET ' . $setParams . ' WHERE ' . $this->primary_key . ' = :id;';

            // Preparar la consulta
            $stmt = $this->connect->prepare($sql);

            // Vincular valores dinámicamente
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }

            $stmt->bindValue(":id", $id_artista);

            // Ejecutar SQL
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
            return false;
        }
    } //end updateArtist

    public function deleteArtist($id_artista = 0)
    {
        /**
         * DELETE FROM artistas WHERE id_artista = ;
         */
        try {
            $sql = 'DELETE FROM ' . $this->table . ' WHERE ' . $this->primary_key . ' = :id;';

            // Preparar la consulta
            $stmt = $this->connect->prepare($sql);

            // Vincular el parámetro id
            $stmt->bindValue(":id", $id_artista);

            // Ejecutar SQL
            return $stmt->execute();
        } catch (PDOException $e) {
            echo 'Error en la consulta: ' . $e->getMessage();
            return false;
        }
    } //end deleteArtist

    //---------------------------
    // QUERIES : Consultas específicas
    //---------------------------

    /**
     * Obtener un artista por el ID del usuario
     * @param int $id_usuario ID del usuario     */
    public function getArtistaByUsuario($id_usuario)
    {
        $sql = "SELECT * FROM " . $this->table . " WHERE id_usuario = :id_usuario LIMIT 1;";
        try {
            $stmt = $this->connect->prepare($sql);
            $stmt->bindValue(":id_usuario", $id_usuario, PDO::PARAM_INT);
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
            return null;
        }
    } //end getArtistaByUsuario

    public function getAlbumDetails($id_album)
    {
        // Primera consulta: Obtener título del álbum y las canciones
        $sqlAlbum = "SELECT 
                    a.titulo_album AS Album,
                    c.nombre_cancion AS Cancion
                 FROM 
                    albumes a
                 INNER JOIN 
                    canciones c ON a.id_album = c.id_album
                 WHERE 
                    a.id_album = :id_album
                 ORDER BY 
                    c.nombre_cancion;";

        // Segunda consulta: Obtener título del álbum, artista y canciones
        $sqlAlbumArtist = "SELECT 
                          a.titulo_album AS Album,
                          ar.pseudonimo_artista AS Artista,
                          c.nombre_cancion AS Cancion
                       FROM 
                          albumes a
                       INNER JOIN 
                          artistas ar ON a.id_artista = ar.id_artista
                       INNER JOIN 
                          canciones c ON a.id_album = c.id_album
                       WHERE 
                          a.id_album = :id_album
                       ORDER BY 
                          c.nombre_cancion;";

        try {
            // Preparar la primera consulta
            $stmtAlbum = $this->connect->prepare($sqlAlbum);
            $stmtAlbum->bindValue(":id_album", $id_album, PDO::PARAM_INT);
            $stmtAlbum->setFetchMode(PDO::FETCH_OBJ);
            $stmtAlbum->execute();
            $albumData = $stmtAlbum->fetchAll();

            // Preparar la segunda consulta
            $stmtAlbumArtist = $this->connect->prepare($sqlAlbumArtist);
            $stmtAlbumArtist->bindValue(":id_album", $id_album, PDO::PARAM_INT);
            $stmtAlbumArtist->setFetchMode(PDO::FETCH_OBJ);
            $stmtAlbumArtist->execute();
            $albumArtistData = $stmtAlbumArtist->fetchAll();

            // Retornar ambas consultas en un array
            return [
                "album_details" => $albumData,
                "album_with_artist" => $albumArtistData
            ];
        } catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
            return null;
        }
    } //end getAlbumDetails

    public function getAllAlbumDetails()
    {
        $sql = "SELECT 
                    a.titulo_album AS Album,
                    ar.pseudonimo_artista AS Artista,
                    c.nombre_cancion AS Cancion,
                    c.url_cancion AS UrlCancion,
                    c.mp3_cancion AS Mp3Cancion
                FROM 
                    albumes a
                INNER JOIN 
                    artistas ar ON a.id_artista = ar.id_artista
                INNER JOIN 
                    canciones c ON a.id_album = c.id_album
                ORDER BY 
                    a.titulo_album, c.nombre_cancion";

        try {
            $stmt = $this->connect->prepare($sql);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);

            $results = $stmt->fetchAll();

            // Reorganizar los datos en un array anidado
            $albums = [];
            foreach ($results as $row) {
                $albumKey = $row['Album']; // Agrupar por álbum
                if (!isset($albums[$albumKey])) {
                    $albums[$albumKey] = [
                        'Artista' => $row['Artista'],
                        'Album' => $row['Album'],
                        'Canciones' => []
                    ];
                }

                $albums[$albumKey]['Canciones'][] = [
                    'nombre_cancion' => $row['Cancion'],
                    'url_cancion' => $row['UrlCancion'],
                    'mp3_cancion' => $row['Mp3Cancion'] // Incluir mp3_cancion
                ];
            }

            return array_values($albums); // Reindexar el array
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }




} //end Tabla_artistas
