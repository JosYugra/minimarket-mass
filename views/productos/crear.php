<?php 
// 1. Cargamos el header común (estilos globales) y la barra superior con los datos del cajero
require __DIR__ . '/../layout/header.php'; 
require_once __DIR__ . '/../auth/barra_usuario.php'; 
?>

<div style="display: flex; min-height: calc(100vh - 110px); font-family: 'Segoe UI', Arial, sans-serif;">

    <?php 
    // 2. Pintamos el menú lateral izquierdo fijo (mantiene resaltada la opción activa)
    require __DIR__ . '/../layout/sidebar.php'; 
    ?>

    <main style="flex: 1; background-color: #f4f6f9; padding: 25px;">
        
        <div style="max-width: 480px; margin: 0 auto; background: #ffffff; border-radius: 12px; padding: 26px; box-shadow: 0 8px 25px rgba(0,0,0,.08); border: 1px solid #e3e8ef;">
            
            <h1 style="color: #0066B3; font-size: 21px; margin-top: 0; margin-bottom: 5px; font-weight: 800;">Registrar nuevo producto</h1>
            <p style="color: #5b6677; font-size: 13px; margin-bottom: 16px;">Ingrese los datos del nuevo artículo para el inventario masivo.</p>
            
            <?php if (!empty($error)): ?>
                <div style="background: #fef2f2; border: 1px solid #f3c2c2; color: #b91c1c; padding: 10px; border-radius: 8px; font-size: 13px; margin-bottom: 15px; font-weight: 500;">
                    ❌ <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="index.php?accion=guardar-producto">
                
                <label style="display: block; font-size: 13px; font-weight: 600; margin: 12px 0 4px; color: #1a2230;">Código de barras</label>
                <input type="text" name="codigo" required style="width: 100%; padding: 10px; border: 1px solid #d7dde6; border-radius: 8px; font-size: 14px;">
                
                <label style="display: block; font-size: 13px; font-weight: 600; margin: 12px 0 4px; color: #1a2230;">Nombre / Descripción</label>
                <input type="text" name="nombre" required style="width: 100%; padding: 10px; border: 1px solid #d7dde6; border-radius: 8px; font-size: 14px;">
                
                <label style="display: block; font-size: 13px; font-weight: 600; margin: 12px 0 4px; color: #1a2230;">Marca</label>
                <input type="text" name="marca" style="width: 100%; padding: 10px; border: 1px solid #d7dde6; border-radius: 8px; font-size: 14px;">
                
                <label style="display: block; font-size: 13px; font-weight: 600; margin: 12px 0 4px; color: #1a2230;">Categoría</label>
                <select name="categoria" style="width: 100%; padding: 10px; border: 1px solid #d7dde6; border-radius: 8px; font-size: 14px; background: #fff;">
                    <option value="1">Abarrotes</option>
                    <option value="2">Bebidas</option>
                    <option value="3">Lácteos</option>
                    <option value="4">Limpieza</option>
                    <option value="5">Aseo Personal</option>
                    <option value="6">Panadería</option>
                    <option value="7">Frutas y Verduras</option>
                </select>
                
                <label style="display: block; font-size: 13px; font-weight: 600; margin: 12px 0 4px; color: #1a2230;">Precio Unitario (S/)</label>
                <input type="number" step="0.01" name="precio" required style="width: 100%; padding: 10px; border: 1px solid #d7dde6; border-radius: 8px; font-size: 14px;">
                
                <label style="display: block; font-size: 13px; font-weight: 600; margin: 12px 0 4px; color: #1a2230;">Stock Inicial</label>
                <input type="number" name="stock" required style="width: 100%; padding: 10px; border: 1px solid #d7dde6; border-radius: 8px; font-size: 14px;">
                
                <button type="submit" style="width: 100%; margin-top: 20px; padding: 11px; border: none; border-radius: 8px; background: #0066B3; color: #fff; font-weight: 700; font-size: 15px; cursor: pointer; transition: background 0.2s;">
                    🚀 Registrar en Catálogo
                </button>
            </form>
            
            <p style="margin-top: 16px; margin-bottom: 0; text-align: center;">
                <a href="index.php?accion=catalogo" style="color: #0066B3; font-size: 13px; text-decoration: none; font-weight: 600;">← Volver al catálogo</a>
            </p>
        </div>

    </main>
</div>

<?php 
// 3. Incluimos el pie de página institucional de Mass
require __DIR__ . '/../layout/footer.php'; 
?>