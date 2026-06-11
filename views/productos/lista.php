<?php 
// 1. Cargamos la cabecera HTML común (estilos CSS)
require __DIR__ . '/../layout/header.php'; 

// 2. Incluimos el componente visual de la barra de usuario (saludo, rol, salir)
require_once __DIR__ . '/../auth/barra_usuario.php'; 
?>

<div style="display: flex; min-height: calc(100vh - 110px); font-family: 'Inter', sans-serif;">

    <?php 
    // Incluimos de forma limpia el menú lateral de navegación (Catálogo, Nuevo producto)
    require __DIR__ . '/../layout/sidebar.php'; 
    ?>

    <main style="flex: 1; background-color: #f4f6f9; padding: 25px;">

        <h1 style="color: #0066B3; font-weight: 800; margin-bottom: 5px;">Catálogo del Minimarket Mass</h1>
        <p style="color: #5b6677; margin-bottom: 20px;">
            Total de productos: <strong><?= count($productos) ?></strong>
        </p>

        <table style="width: 100%; border-collapse: collapse; background: #ffffff; border: 1px solid #e3e8ef; border-radius: 8px; overflow: hidden;">
            <thead>
                <tr style="background-color: #0066B3; color: #ffffff;">
                    <th style="padding: 12px; text-align: left;">Código</th>
                    <th style="padding: 12px; text-align: left;">Nombre</th>
                    <th style="padding: 12px; text-align: left;">Precio</th>
                    <th style="padding: 12px; text-align: left;">Precio con IGV</th>
                    <th style="padding: 12px; text-align: left;">Stock</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $p): ?>
                <tr style="border-bottom: 1px solid #e3e8ef;">
                    <td style="padding: 12px;"><?= htmlspecialchars($p->getCodigo()) ?></td>
                    <td style="padding: 12px;"><?= htmlspecialchars($p->getNombre()) ?></td>
                    <td style="padding: 12px;" class="precio">S/ <?= number_format($p->getPrecio(), 2) ?></td>
                    <td style="padding: 12px;" class="precio">S/ <?= number_format($p->precioConIGV(), 2) ?></td>
                    <td style="padding: 12px;" <?= $p->getStock() === 0 ? 'class="sin-stock"' : '' ?>>
                        <?= $p->getStock() ?> unidades
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </main>
</div>
<?php 
// 3. Cargamos el pie de página institucional de Mass
require __DIR__ . '/../layout/footer.php'; 
?>