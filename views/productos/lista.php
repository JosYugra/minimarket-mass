<?php 
// 1. Cargamos la cabecera HTML común (con tipografía Inter y estilos SaaS)
require __DIR__ . '/../layout/header.php'; 

// 2. Incluimos el componente visual de la barra de usuario (saludo, rol, salir)
require_once __DIR__ . '/../auth/barra_usuario.php'; 
?>

<div style="display: flex; min-height: calc(100vh - 110px);">

    <?php 
    // Incluimos de forma limpia el menú lateral de navegación
    require __DIR__ . '/../layout/sidebar.php'; 
    ?>

    <main style="flex: 1; background-color: #f8fafc; padding: 32px;">

        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <div>
                <h1 style="color: #0066B3; font-weight: 800; font-size: 24px; letter-spacing: -0.5px; margin-bottom: 4px;">
                    Catálogo del Minimarket Mass
                </h1>
                <p style="color: #64748b; font-size: 14px; font-weight: 500;">
                    Monitoreo de inventario y control de precios en cajas registradoras.
                </p>
            </div>
            
            <div style="background-color: #e0f2fe; color: #0369a1; padding: 8px 16px; border-radius: 9999px; font-size: 13px; font-weight: 700; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                📦 <span>Total de productos: <?= count($productos) ?></span>
            </div>
        </div>

        <div style="background: #ffffff; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03); border: 1px solid #e2e8f0; overflow: hidden;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;">
                <thead>
                    <tr style="background-color: #f1f5f9; border-bottom: 2px solid #e2e8f0;">
                        <th style="padding: 16px 20px; font-weight: 700; color: #475569; text-transform: uppercase; font-size: 11px; letter-spacing: 0.5px;">Código</th>
                        <th style="padding: 16px 20px; font-weight: 700; color: #475569; text-transform: uppercase; font-size: 11px; letter-spacing: 0.5px;">Nombre</th>
                        <th style="padding: 16px 20px; font-weight: 700; color: #475569; text-transform: uppercase; font-size: 11px; letter-spacing: 0.5px;">Precio Base</th>
                        <th style="padding: 16px 20px; font-weight: 700; color: #475569; text-transform: uppercase; font-size: 11px; letter-spacing: 0.5px;">Precio con IGV</th>
                        <th style="padding: 16px 20px; font-weight: 700; color: #475569; text-transform: uppercase; font-size: 11px; letter-spacing: 0.5px;">Stock</th>
                        <th style="padding: 16px 20px; font-weight: 700; color: #475569; text-transform: uppercase; font-size: 11px; letter-spacing: 0.5px; text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tbody style="color: #334155;">
                    <?php foreach ($productos as $p): ?>
                    <tr class="fila-tabla" style="border-bottom: 1px solid #f1f5f9; transition: background 0.2s;">
                        
                        <td style="padding: 14px 20px; font-family: monospace; font-size: 13px; color: #64748b; font-weight: 600;">
                            <?= htmlspecialchars($p->getCodigo()) ?>
                        </td>
                        
                        <td style="padding: 14px 20px; font-weight: 600; color: #0f172a;">
                            <?= htmlspecialchars($p->getNombre()) ?>
                        </td>
                        
                        <td style="padding: 14px 20px;" class="precio">
                            S/ <?= number_format($p->getPrecio(), 2) ?>
                        </td>
                        
                        <td style="padding: 14px 20px; font-weight: 700; color: #0066B3;">
                            S/ <?= number_format($p->precioConIGV(), 2) ?>
                        </td>
                        
                        <td style="padding: 14px 20px;">
                            <?php if ($p->getStock() === 0): ?>
                                <span class="sin-stock">0 unidades</span>
                            <?php else: ?>
                                <span style="font-weight: 600; color: #1e293b;">
                                    <?= $p->getStock() ?> <span style="color: #94a3b8; font-weight: 400; font-size: 13px;">unidades</span>
                                </span>
                            <?php endif; ?>
                        </td>
                        
                        <td style="padding: 14px 20px; text-align: center;">
                            <div style="display: flex; gap: 8px; justify-content: center; align-items: center;">
                                
                                <a href="index.php?accion=editar-producto&codigo=<?= urlencode($p->getCodigo()) ?>" 
                                   style="background-color: #FFB81C; color: #0c1f33; text-decoration: none; padding: 6px 12px; border-radius: 8px; font-weight: 700; font-size: 12px; display: inline-block; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                                    ✏️ Editar
                                </a>

                                <a href="index.php?accion=eliminar-producto&codigo=<?= urlencode($p->getCodigo()) ?>" 
                                   onclick="return confirm('¿Está seguro de que desea eliminar el producto <?= htmlspecialchars($p->getNombre()) ?> de las cajas registradoras?');"
                                   style="background-color: #dc2626; color: #ffffff; text-decoration: none; padding: 6px 12px; border-radius: 8px; font-weight: 700; font-size: 12px; display: inline-block; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                                    🗑️ Eliminar
                                </a>
                                
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </main>
</div>

<?php 
// 3. Cargamos el pie de página institucional de Mass
require __DIR__ . '/../layout/footer.php'; 
?>