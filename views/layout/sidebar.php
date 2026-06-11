<?php
// Detectamos la acción enrutada actualmente para inyectar los estilos del Bonus
$accion_actual = $_GET['accion'] ?? 'catalogo';
?>
<aside style="background-color: #0c1f33; width: 200px; min-width: 200px; min-height: calc(100vh - 110px); padding: 15px 10px; font-family: 'Inter', sans-serif;">
  
  <a href="index.php?accion=catalogo" style="display: block; color: #ffffff; text-decoration: none; padding: 10px 12px; border-radius: 7px; margin-bottom: 6px; font-size: 14px; <?= ($accion_actual === 'catalogo') ? 'background-color: #11304d; font-weight: 600;' : '' ?>">
    📦 Catálogo
  </a>
  
  <a href="index.php?accion=nuevo-producto" style="display: block; color: #cdd9e6; text-decoration: none; padding: 10px 12px; border-radius: 7px; margin-bottom: 6px; font-size: 14px; <?= ($accion_actual === 'nuevo-producto') ? 'background-color: #11304d; color: #ffffff; font-weight: 600;' : '' ?>">
    ➕ Nuevo producto
  </a>
  
  <a href="index.php?accion=editar-producto" style="display: block; color: #cdd9e6; text-decoration: none; padding: 10px 12px; border-radius: 7px; margin-bottom: 6px; font-size: 14px; <?= ($accion_actual === 'editar-producto') ? 'background-color: #11304d; color: #ffffff; font-weight: 600;' : '' ?>">
    ✏️ Editar
  </a>
  
  <a href="index.php?accion=reportes" style="display: block; color: #cdd9e6; text-decoration: none; padding: 10px 12px; border-radius: 7px; margin-bottom: 6px; font-size: 14px; <?= ($accion_actual === 'reportes') ? 'background-color: #11304d; color: #ffffff; font-weight: 600;' : '' ?>">
    📊 Reportes
  </a>
  
</aside>