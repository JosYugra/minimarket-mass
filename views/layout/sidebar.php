<?php
// Detectamos la acción actual para aplicar el bonus de "Marca el activo"
$accion_actual = $_GET['accion'] ?? 'catalogo';
?>
<aside style="background-color: #0c1f33; width: 200px; min-width: 200px; min-height: calc(100vh - 110px); padding: 15px 10px; font-family: 'Inter', sans-serif;">
  
  <a href="index.php?accion=catalogo" style="display: block; color: #ffffff; text-decoration: none; padding: 10px 12px; border-radius: 7px; margin-bottom: 6px; font-size: 14px; <?= ($accion_actual === 'catalogo') ? 'background-color: #11304d; font-weight: 600;' : '' ?>">
    📦 Catálogo
  </a>
  
  <a href="index.php?accion=nuevo-producto" style="display: block; color: #cdd9e6; text-decoration: none; padding: 10px 12px; border-radius: 7px; margin-bottom: 6px; font-size: 14px; <?= ($accion_actual === 'nuevo-producto') ? 'background-color: #11304d; color: #ffffff; font-weight: 600;' : '' ?>">
    ➕ Nuevo producto
  </a>
  
  <span style="display: block; color: #5b6677; padding: 10px 12px; font-size: 14px; cursor: not-allowed;">
    ✏️ Editar
  </span>
  <span style="display: block; color: #5b6677; padding: 10px 12px; font-size: 14px; cursor: not-allowed;">
    📊 Reportes
  </span>
  
</aside>