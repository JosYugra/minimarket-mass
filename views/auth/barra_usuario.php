<?php
// Aseguramos que la sesión esté activa para leer los datos
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificamos si hay un usuario logueado en la sesión
    if (isset($_SESSION['usuario'])): 
    $usuario = $_SESSION['usuario']; // Array con los datos del cajero [cite: 42]
    $nombre = $usuario['nombre'] ?? 'Cajero';
    $rol = $usuario['rol'] ?? '';
    $tienda = $usuario['tienda'] ?? 'Mass Principal';

    // Definir el saludo según el rol (admin o cajero) [cite: 42]
    $saludo = "";
    if ($rol === 'admin') {
        $saludo = "Modo administrador";
    } elseif ($rol === 'cajero') {
        $saludo = "Caja";
    } else {
        $saludo = "Bienvenido";
    }
?>
    <div style="background-color: #005691; color: white; padding: 10px 20px; display: flex; justify-content: space-between; align-items: center; font-family: Arial, sans-serif; border-bottom: 4px solid #FFD100;">
        <div>
            <strong><?= $saludo ?>:</strong> <?= htmlspecialchars($nombre) ?> 
            <span style="margin-left: 15px; font-size: 0.9em; opacity: 0.9;">
                📍 Tienda: <?= htmlspecialchars($tienda) ?>
            </span>
        </div>
        
        <div style="display: flex; align-items: center; gap: 15px;">
            
            <span style="font-size: 0.9em; opacity: 0.95; font-family: sans-serif;">
                🕒 Último acceso: <b><?= htmlspecialchars($usuario['ultimo_acceso'] ?? 'Primer ingreso') ?></b>
            </span>
            <a href="index.php?accion=logout" style="background-color: #FFD100; color: #005691; padding: 6px 12px; text-decoration: none; font-weight: bold; border-radius: 4px;">
                Salir
            </a>
        </div>
    </div>
<?php endif; ?>