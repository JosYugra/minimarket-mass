<?php
declare(strict_types=1);
require_once __DIR__ . '/Producto.php';
require_once __DIR__ . '/../config/conexion.php';

/**
 * Repositorio de productos del Minimarket Mass.
 * * SESIÓN 5: lee de MySQL con PDO.
 */
class ProductoRepository {

    /**
     * Devuelve TODOS los productos del catálogo desde la BD.
     * @return Producto[]
     */
    public function obtenerTodos(): array {
        try {
            $pdo = getConexion();

            $stmt = $pdo->query(
                "SELECT codigo_barras AS codigo, nombre, precio, stock
                 FROM productos
                 ORDER BY nombre"
            );

            $productos = [];
            foreach ($stmt->fetchAll() as $f) {
                $productos[] = new Producto(
                    $f['codigo'],
                    $f['nombre'],
                    (float) $f['precio'],   // MySQL devuelve TODO como string
                    (int)   $f['stock']     // por eso casteamos a float/int
                );
            }
            return $productos;

        } catch (PDOException $e) {
            error_log('[ProductoRepository::obtenerTodos] ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Busca UN producto por su código.
     * Usa PREPARED STATEMENT → seguro contra SQL injection.
     */
    public function buscarPorCodigo(string $codigo): ?Producto {
        try {
            $pdo = getConexion();

            $stmt = $pdo->prepare(
                "SELECT codigo_barras AS codigo, nombre, precio, stock
                 FROM productos
                 WHERE codigo_barras = :codigo"
            );
            $stmt->execute([':codigo' => $codigo]);

            $fila = $stmt->fetch();
            if ($fila === false) {
                return null;
            }

            return new Producto(
                $fila['codigo'],
                $fila['nombre'],
                (float) $fila['precio'],
                (int)   $fila['stock']
            );

        } catch (PDOException $e) {
            error_log('[ProductoRepository::buscarPorCodigo] ' . $e->getMessage());
            return null;
        }
    }

    /**
     * MÉTODO 1: Buscar productos por nombre 
     */
    public function buscarPorNombre(string $termino): array {
        try {
            $pdo = getConexion();
            $stmt = $pdo->prepare(
                "SELECT codigo_barras AS codigo, nombre, precio, stock
                 FROM productos
                 WHERE nombre LIKE :termino
                 ORDER BY nombre"
            );
            $stmt->execute([':termino' => '%' . $termino . '%']);

            $productos = [];
            foreach ($stmt->fetchAll() as $f) {
                $productos[] = new Producto(
                    $f['codigo'],
                    $f['nombre'],
                    (float) $f['precio'],
                    (int)   $f['stock']
                );
            }
            return $productos;
        } catch (PDOException $e) {
            error_log('[ProductoRepository::buscarPorNombre] ' . $e->getMessage());
            return [];
        }
    }

    /**
     * MÉTODO 2: Obtener productos por ID de Categoría
     */
    public function obtenerPorCategoria(int $categoriaId): array {
        try {
            $pdo = getConexion();
            $stmt = $pdo->prepare(
                "SELECT codigo_barras AS codigo, nombre, precio, stock
                 FROM productos
                 WHERE categoria_id = :categoriaId
                 ORDER BY nombre"
            );
            $stmt->execute([':categoriaId' => $categoriaId]);

            $productos = [];
            foreach ($stmt->fetchAll() as $f) {
                $productos[] = new Producto(
                    $f['codigo'],
                    $f['nombre'],
                    (float) $f['precio'],
                    (int)   $f['stock']
                );
            }
            return $productos;
        } catch (PDOException $e) {
            error_log('[ProductoRepository::obtenerPorCategoria] ' . $e->getMessage());
            return [];
        }
    }

    /**
     * MÉTODO 3: Obtener productos con bajo stock
     */
    public function obtenerBajoStock(int $umbral): array {
        try {
            $pdo = getConexion();
            $stmt = $pdo->prepare(
                "SELECT codigo_barras AS codigo, nombre, precio, stock
                 FROM productos
                 WHERE stock < :umbral
                 ORDER BY stock ASC"
            );
            $stmt->execute([':umbral' => $umbral]);

            $productos = [];
            foreach ($stmt->fetchAll() as $f) {
                $productos[] = new Producto(
                    $f['codigo'],
                    $f['nombre'],
                    (float) $f['precio'],
                    (int)   $f['stock']
                );
            }
            return $productos;
        } catch (PDOException $e) {
            error_log('[ProductoRepository::obtenerBajoStock] ' . $e->getMessage());
            return [];
        }
    }

    /**
     * MÉTODO 4: Contar la cantidad total de productos
     */
    public function contarTotalProductos(): int {
        try {
            $pdo = getConexion();
            $stmt = $pdo->query("SELECT COUNT(*) FROM productos");
            return (int) $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log('[ProductoRepository::contarTotalProductos] ' . $e->getMessage());
            return 0;
        }
    }

    /**
     *  MÉTODO BONUS: Obtener los productos más caros
     */
    public function obtenerMasCaros(int $limite): array {
        try {
            $pdo = getConexion();
            $limiteSeguro = (int) $limite;
            $stmt = $pdo->query(
                "SELECT codigo_barras AS codigo, nombre, precio, stock
                 FROM productos
                 ORDER BY precio DESC
                 LIMIT $limiteSeguro"
            );

            $productos = [];
            foreach ($stmt->fetchAll() as $f) {
                $productos[] = new Producto(
                    $f['codigo'],
                    $f['nombre'],
                    (float) $f['precio'],
                    (int)   $f['stock']
                );
            }
            return $productos;
        } catch (PDOException $e) {
            error_log('[ProductoRepository::obtenerMasCaros] ' . $e->getMessage());
            return [];
        }
    }
    public function crear(array $d): bool {
        $pdo  = getConexion();
        $stmt = $pdo->prepare(
            "INSERT INTO productos (codigo_barras, nombre, marca, categoria_id, precio, stock)
             VALUES (:codigo, :nombre, :marca, :categoria, :precio, :stock)"
        );
        return $stmt->execute([
            ':codigo'    => $d['codigo'],
            ':nombre'    => $d['nombre'],
            ':marca'     => $d['marca'],
            ':categoria' => $d['categoria'],
            ':precio'    => $d['precio'],
            ':stock'     => $d['stock'],
        ]);
    }
} 