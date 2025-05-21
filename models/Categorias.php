<?php

namespace Model;

class Categorias extends ActiveRecord {

    protected static $errores = [];
    public static $tabla = 'categorias';
    public static $columnasDB = [
        'nombre'
    ];

    public static $idTabla = 'id';
    public $id;
    public $nombre;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
    }

    public function validar() {
        if(!$this->nombre) {
            self::$errores[] = 'El nombre de la categoría es obligatorio';
        }
        return self::$errores;
    }

    public function getProductos() {
        $query = "SELECT * FROM productos WHERE categoria_id = " . $this->id . " ORDER BY prioridad_id ASC";
        return Productos::consultarSQL($query);
    }

    public function getProductosPendientes() {
        $query = "SELECT * FROM productos WHERE categoria_id = " . $this->id . " AND comprado = 'f' ORDER BY prioridad_id ASC";
        return Productos::consultarSQL($query);
    }
}