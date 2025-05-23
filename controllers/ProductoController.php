<?php

namespace Controllers;

use Exception;
use Model\ActiveRecord;
use Model\Productos;
use Model\Categorias;
use Model\Prioridades;
use MVC\Router;

class ProductoController extends ActiveRecord
{
    public function renderizarPagina(Router $router)
    {
        $router->render('productos/index', []);
    }

    public static function guardarAPI()
    {
        getHeadersApi();

        $_POST['nombre'] = htmlspecialchars($_POST['nombre']);
        if (empty($_POST['nombre'])) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El nombre del producto es obligatorio'
            ]);
            return;
        }

        $_POST['cantidad'] = filter_var($_POST['cantidad'], FILTER_VALIDATE_INT);
        if ($_POST['cantidad'] <= 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La cantidad debe ser un número mayor a cero'
            ]);
            return;
        }

        $_POST['categoria_id'] = filter_var($_POST['categoria_id'], FILTER_VALIDATE_INT);
        if ($_POST['categoria_id'] <= 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Debes seleccionar una categoría válida'
            ]);
            return;
        }

        $_POST['prioridad_id'] = filter_var($_POST['prioridad_id'], FILTER_VALIDATE_INT);
        if ($_POST['prioridad_id'] <= 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Debes seleccionar una prioridad válida'
            ]);
            return;
        }

        try {
            $sql = "SELECT * FROM productos WHERE nombre = '" . $_POST['nombre'] . 
                   "' AND categoria_id = " . $_POST['categoria_id'];
            $existente = self::fetchArray($sql);
            
            if (!empty($existente)) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Este producto ya existe en la categoría seleccionada'
                ]);
                return;
            }

            $producto = new Productos([
                'nombre' => $_POST['nombre'],
                'cantidad' => $_POST['cantidad'],
                'categoria_id' => $_POST['categoria_id'],
                'prioridad_id' => $_POST['prioridad_id'],
                'comprado' => 'pendiente de comprar'
            ]);

            $crear = $producto->crear();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'El producto ha sido agregado correctamente'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al guardar el producto',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function buscarAPI()
    {
        try {
            $sql_categorias = "SELECT * FROM categorias ORDER BY id";
            $categorias = self::fetchArray($sql_categorias);
            
            $productos_por_categoria = [];
            
            foreach ($categorias as $categoria) {
                $sql_productos = "SELECT p.*, c.nombre as categoria, pr.nombre as prioridad, pr.valor 
                                 FROM productos p 
                                 JOIN categorias c ON p.categoria_id = c.id 
                                 JOIN prioridades pr ON p.prioridad_id = pr.id 
                                 WHERE p.categoria_id = " . $categoria['id'] . 
                                 " ORDER BY p.comprado, pr.valor ASC";
                
                $productos = self::fetchArray($sql_productos);
                
                if (!$productos) {
                    $productos = [];
                }
                
                $productos_por_categoria[] = [
                    'categoria' => $categoria,
                    'productos' => $productos
                ];
            }

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Productos obtenidos correctamente',
                'data' => $productos_por_categoria
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener los productos',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function modificarAPI()
    {
        getHeadersApi();

        $id = $_POST['id'];

        $_POST['nombre'] = htmlspecialchars($_POST['nombre']);
        if (empty($_POST['nombre'])) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El nombre del producto es obligatorio'
            ]);
            return;
        }

        $_POST['cantidad'] = filter_var($_POST['cantidad'], FILTER_VALIDATE_INT);
        if ($_POST['cantidad'] <= 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La cantidad debe ser un número mayor a cero'
            ]);
            return;
        }

        $_POST['categoria_id'] = filter_var($_POST['categoria_id'], FILTER_VALIDATE_INT);
        if ($_POST['categoria_id'] <= 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Debes seleccionar una categoría válida'
            ]);
            return;
        }

        $_POST['prioridad_id'] = filter_var($_POST['prioridad_id'], FILTER_VALIDATE_INT);
        if ($_POST['prioridad_id'] <= 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Debes seleccionar una prioridad válida'
            ]);
            return;
        }

        try {
            $sql = "SELECT * FROM productos WHERE nombre = '" . $_POST['nombre'] . 
                   "' AND categoria_id = " . $_POST['categoria_id'] . 
                   " AND id != " . $id;
            $existente = self::fetchArray($sql);
            
            if (!empty($existente)) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Ya existe otro producto con este nombre en la categoría seleccionada'
                ]);
                return;
            }

            $sql = "UPDATE productos SET 
                    nombre = ?, 
                    cantidad = ?, 
                    categoria_id = ?, 
                    prioridad_id = ? 
                    WHERE id = ?";

            $stmt = self::$db->prepare($sql);
            $stmt->execute([
                $_POST['nombre'],
                $_POST['cantidad'], 
                $_POST['categoria_id'],
                $_POST['prioridad_id'],
                $id
            ]);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'El producto ha sido actualizado correctamente'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al actualizar el producto',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function cambiarEstadoAPI()
    {
        getHeadersApi();

        $id = $_POST['id'];
        $comprado = $_POST['comprado'] === 'true' ? 'comprado' : 'pendiente de comprar';

        try {
            $sql = "UPDATE productos SET comprado = ? WHERE id = ?";
            $stmt = self::$db->prepare($sql);
            $stmt->execute([$comprado, $id]);

            $mensaje = $comprado === 'comprado' ? 'marcado como comprado' : 'marcado como pendiente de comprar';

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'El producto ha sido ' . $mensaje . ' correctamente'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al cambiar el estado del producto',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function eliminarAPI()
    {
        getHeadersApi();

        $id = $_POST['id'];

        try {
            $producto = Productos::find($id);
            $producto->eliminar();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'El producto ha sido eliminado correctamente'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al eliminar el producto',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function obtenerSeleccionesAPI()
    {
        try {
            $sql_categorias = "SELECT * FROM categorias ORDER BY id";
            $categorias = self::fetchArray($sql_categorias);
            
            $sql_prioridades = "SELECT * FROM prioridades ORDER BY valor ASC";
            $prioridades = self::fetchArray($sql_prioridades);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Datos obtenidos correctamente',
                'categorias' => $categorias,
                'prioridades' => $prioridades
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener los datos',
                'detalle' => $e->getMessage(),
            ]);
        }
    }
}