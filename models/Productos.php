<?php

namespace Model;

class Productos extends ActiveRecord {

    protected static $errores = [];
    public static $tabla = 'productos';
    public static $columnasDB = [
        'nombre',
        'cantidad',
        'categoria_id',
        'prioridad_id',
        'comprado',
        'fecha_creacion'
    ];

    public static $idTabla = 'id';
    public $id;
    public $nombre;
    public $cantidad;
    public $categoria_id;
    public $prioridad_id;
    public $comprado;
    public $fecha_creacion;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->cantidad = $args['cantidad'] ?? 0;
        $this->categoria_id = $args['categoria_id'] ?? 0;
        $this->prioridad_id = $args['prioridad_id'] ?? 0;
        $this->comprado = $args['comprado'] ?? 'f';
        $this->fecha_creacion = $args['fecha_creacion'] ?? null;
    }

    public function validar() {
        if(!$this->nombre) {
            self::$errores[] = 'El nombre del producto es obligatorio';
        }
        if(!$this->cantidad) {
            self::$errores[] = 'La cantidad es obligatoria';
        }
        if(!$this->categoria_id) {
            self::$errores[] = 'La categoría es obligatoria';
        }
        if(!$this->prioridad_id) {
            self::$errores[] = 'La prioridad es obligatoria';
        }
        return self::$errores;
    }

    public function validarDuplicado() {
        $query = "SELECT * FROM " . self::$tabla . " WHERE nombre = '" . 
                 $this->nombre . "' AND categoria_id = " . $this->categoria_id;
        
        if($this->id) {
            $query .= " AND id != " . $this->id;
        }
        
        $resultado = self::consultarSQL($query);
        return !empty($resultado);
    }
}