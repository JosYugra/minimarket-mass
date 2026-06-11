<?php 
//views/productos/editar.php
require __DIR__ . '/../layout/header.php'; 
require_once __DIR__ . '/../auth/barra_usuario.php'; 
?>

<div style="display: flex; min-height: calc(100vh - 110px); font-family: 'Inter', sans-serif;">
    <?php require __DIR__ . '/../layout/sidebar.php'; ?>

    <main style="flex: 1; background-color: #f4f6f9; padding: 25px;">
        <h1 style="color: #0066B3; font-weight: 800; margin-bottom: 5px;">Editar Producto</h1>
        <p style="color: #5b6677; margin-bottom: 20px;">Modifique los datos del artículo en el sistema de caja.</p>

        <?php if (isset($error)): ?>
            <div style="background-color: #fef2f2; border: 1px solid #e3a8a8; padding: 12px; border-radius: 6px; color: #dc2626; margin-bottom: 15px;">
                ❌ <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <?php if (isset($producto) && $producto !== null): ?>
            <form action="index.php?accion=actualizar-producto" method="POST" style="background: #fff; padding: 20px; border-radius: 8px; border: 1px solid #e3e8ef; max-width: 500px;">
                <input type="hidden" name="codigo" value="<?= htmlspecialchars($producto->getCodigo()) ?>">
                
                <div style="margin-bottom: 15px;">
                    <label style="display:block; font-weight:600; margin-bottom:5px;">Código de Barras (No modificable):</label>
                    <input type="text" value="<?= htmlspecialchars($producto->getCodigo()) ?>" disabled style="width:100%; padding:8px; border:1px solid #e3e8ef; border-radius:6px; background-color: #f4f6f9; cursor: not-allowed;">
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display:block; font-weight:600; margin-bottom:5px;">Nombre del Producto:</label>
                    <input type="text" name="nombre" value="<?= htmlspecialchars($producto->getNombre()) ?>" required style="width:100%; padding:8px; border:1px solid #e3e8ef; border-radius:6px;">
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label style="display:block; font-weight:600; margin-bottom:5px;">Precio Base (S/):</label>
                    <input type="number" step="0.01" name="precio" value="<?= $producto->getPrecio() ?>" required style="width:100%; padding:8px; border:1px solid #e3e8ef; border-radius:6px;">
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display:block; font-weight:600; margin-bottom:5px;">Stock Disponible:</label>
                    <input type="number" name="stock" value="<?= $producto->getStock() ?>" required style="width:100%; padding:8px; border:1px solid #e3e8ef; border-radius:6px;">
                </div>

                <button type="submit" style="background-color: #0066B3; color: white; border: none; padding: 10px 15px; border-radius: 6px; font-weight: 700; cursor: pointer;">
                    💾 Actualizar en Sistema
                </button>
            </form>
        <?php else: ?>
            <div style="background-color: #fff8e6; border: 1px solid #f5e3a8; padding: 15px; border-radius: 8px; color: #b8860b;">
                ⚠️ El producto seleccionado no existe o el código es inválido. Regrese al <a href="index.php?accion=catalogo" style="color: #0066B3; font-weight:700;">Catálogo</a>.
            </div>
        <?php endif; ?>
    </main>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>