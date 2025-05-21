<?php

namespace Model;

class Prioridades extends ActiveRecord {

    protected static $errores = [];

    public static $tabla = 'prioridades';
    public static $columnasDB = [
        'nombre',
        'valor'
    ];

    public static $idTabla = 'id';
    public $id;
    public $nombre;
    public $valor;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->valor = $args['valor'] ?? 0;
    }

    public function validar() {
        if(!$this->nombre) {
            self::$errores[] = 'El nombre de la prioridad es obligatorio';
        }
        if(!$this->valor) {
            self::$errores[] = 'El valor de la prioridad es obligatorio';
        }
        return self::$errores;
    }

    public static function todas() {
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY valor ASC";
        return static::consultarSQL($query);
    }

    public function getProductos() {
        $query = "SELECT * FROM productos WHERE prioridad_id = " . $this->id;
        return Productos::consultarSQL($query);
    }
}