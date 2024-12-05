<?php
require_once(__DIR__ . "/../config/Conecct.php");

class Tabla_artistas
{
    private $connect;
    private $table = 'artistas';
    private $primary_key = 'id_usuario';
    public function __construct()
    {
        $db = new Conecct();
        $this->connect = $db->conecct;
    }//end __construct
     //---------------------------
    // QUERIES : PETICIONES SQL
    // CRUD: Create | Read | Delete | Update
    //--------------------------
    public function createArtista($data = array())
    {
        //Setting a new value
        if (isset($data["password_usuario"])) {
            $data['password_usuario'] = hash('sha256', $data['password_usuario']);
        }//end isset
        // echo print("<pre>".print_r($data,true)."</pre>");

        /*
            INSERT INTO usuarios 
                (nombre_usuario, ap_usuario, am_usuario, sexo_usuario, email_usuario, password_usuario, imagen_usuario, id_rol) 
                VALUES ('', "", NULL)
                VALUES (:nombre, :ap, :am, :sexo, :email, :pass, :img, :rol)
        */

        //Setting fields dynamically
        $fields = implode(", ", array_keys($data));

        //Setting values dynamically into slq
        $values = ":" . implode(", :", array_keys($data));

        //SQL QUERY - INSERT
        $sql = "INSERT INTO " . $this->table . " ($fields) VALUES($values)";

        try {
            //Prepare the statement   
            $stmt = $this->connect->prepare($sql);

            //Bind values dynamically
            foreach ($data as $key => $value) {
                $stmt->bindValue(":" . $key, $value);
            }//end foreach

            //Execute sql
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error in query: " . $e->getMessage();
            return false;
        }//end catch


        // echo print("<pre>".print_r($values,true)."</pre>");
    }//end createUser

}