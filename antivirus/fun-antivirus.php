<?php 






function obtenerAntivirus() {
    $antivirus = array();
    $sql = "SELECT id, nombre, descripcion, precio, imagen from antivirus ORDER BY RAND() LIMIT 3"; 
    $db = obtenerConexion();
    $db -> query("SET NAMES 'UTF8' ");
    // obtenemos todos los países
    $result = ejecutarQuery($db, $sql);
    // creamos objetos de la clase país y los agregamos al arreglo
    while($row = $result->fetch_assoc()){
        // $row['nombre_pais'] = mb_convert_encoding($row['nombre_pais'], 'UTF-8', mysqli_character_set_name($db));
        // $row['nacionalidad_pais'] = mb_convert_encoding($row['nacionalidad_pais'], 'UTF-8', mysqli_character_set_name($db));          
        $antiviru = new antiviru($row['id'], $row['nombre'], $row['descripcion'], $row['precio'], $row['imagen']);
        array_push($antivirus, $antiviru);
    }

        cerrarConexion($db, $result);

        // devolvemos el arreglo
        
        return $antivirus;
}

class antiviru {
    public $id;
    public $nombre;
    public $descripcion;
    public $precio;
    public $imagen;

    function __construct($id, $nombre, $descripcion, $precio, $imagen) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
        $this->imagen = $imagen;
    }





 ?>