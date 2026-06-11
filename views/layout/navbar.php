<?php 
// Recuperamos el usuario logueado desde la sesión (helper)
$u = usuarioActual(); 
?>
<nav style="background-color: #0066B3; color: #ffffff; padding: 12px 20px; display: flex; align-items: center; justify-content: space-between; font-family: 'Inter', sans-serif;">
  <div style="font-weight: 800; font-size: 16px; letter-spacing: 0.5px;">
    🛒 MASS · Sistema de Caja
  </div>
  <div style="font-size: 13px; display: flex; align-items: center; gap: 15px;">
    <span>
      👤 <?= htmlspecialchars($u['nombre'] ?? 'Usuario') ?> · 
      <strong><?= htmlspecialchars(ucfirst($u['rol'] ?? 'Cajero')) ?></strong>
    </span>
    <a href="index.php?accion=logout" style="background-color: #FFB81C; color: #0a2540; font-weight: 700; text-decoration: none; padding: 5px 12px; border-radius: 6px; font-size: 12px; transition: background 0.2s;">
      Salir
    </a>
  </div>
</nav>