<?php
declare(strict_types=1);
require_once __DIR__ . '/models/ProductoRepository.php';

$repo = new ProductoRepository();

echo "<h2>1. buscarPorNombre('Inca')</h2>";
foreach ($repo->buscarPorNombre('Inca') as $p) {
    echo $p->getNombre() . " — S/ " . number_format($p->getPrecio(), 2) . "<br>";
}

echo "<h2>2. obtenerPorCategoria(2) — Bebidas</h2>";
foreach ($repo->obtenerPorCategoria(2) as $p) {
    echo $p->getNombre() . " (stock: " . $p->getStock() . ")<br>";
}

echo "<h2>3. obtenerBajoStock(100)</h2>";
foreach ($repo->obtenerBajoStock(100) as $p) {
    echo $p->getNombre() . " — stock: " . $p->getStock() . "<br>";
}

echo "<h2>4. contarTotalProductos()</h2>";
echo "Total de productos en la BD: " . $repo->contarTotalProductos() . "<br>";

echo "<h2>5. BONUS: obtenerMasCaros(3)</h2>";
echo "<p>Muestra el top 3 de los artículos con mayor precio del minimarket.</p>";
foreach ($repo->obtenerMasCaros(3) as $p) {
    echo $p->getNombre() . " — Precio: S/ " . number_format($p->getPrecio(), 2) . "<br>";
}