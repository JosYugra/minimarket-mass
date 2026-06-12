<?php
declare(strict_types=1);

// ====================================================================
// 🚨 PASO 1: FOCO DE EMERGENCIA (Configuración de errores)
// ====================================================================
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

// La sesión debe arrancar ANTES de cualquier salida al navegador.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 🔑 CORRECCIÓN: Si NO existe la variable en el servidor, la inicializamos en 0.
// Ya no se sobreescribe en cada recarga de página.
if (!isset($_SESSION['intentos_fallidos'])) {
    $_SESSION['intentos_fallidos'] = 0;
}

require_once __DIR__ . '/../helpers/sesion.php';
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/ProductoController.php';
require_once __DIR__ . '/../controllers/ReporteController.php';

// Enrutamiento simple por ?accion=
$accion = $_GET['accion'] ?? 'catalogo';
$auth   = new AuthController();

switch ($accion) {

    case 'panel-admin':
        // Invocamos al guardián del rol estricto
        requiereRol('admin');
        
        // Si pasa el filtro, cargamos los componentes visuales de Tiendas Mass
        $usuario = usuarioActual();
        require_once __DIR__ . '/../views/layout/header.php';
        require_once __DIR__ . '/../views/auth/barra_usuario.php';
        
        echo "<main style='padding: 40px; max-width: 800px; margin: 0 auto; font-family: Sans-serif;'>";
        echo "  <div style='background: #fff8e6; border: 1px solid #f5e3a8; padding: 24px; border-radius: 8px;'>";
        echo "      <h2 style='color: #0066B3; margin-bottom: 10px;'>💼 Panel de Administración</h2>";
        echo "      <p>Bienvenido al centro de control del Minimarket, <b>" . htmlspecialchars($usuario['nombre']) . "</b>.</p>";
        echo "      <p style='font-size: 14px; color: #5b6677; margin-top: 5px;'>Tienda asignada: " . htmlspecialchars($usuario['tienda']) . "</p>";
        echo "  </div>";
        echo "</main>";
        
        require_once __DIR__ . '/../views/layout/footer.php';
        break;

    case 'login':
        // 🛡️ Si el cajero ya acumuló 3 o más fallos, le mandamos el aviso de bloqueo directo a la vista
        if ($_SESSION['intentos_fallidos'] >= 3) {
            $auth->mostrarLogin('🚨 ACCESO BLOQUEADO. Demasiados intentos fallidos.');
        } else {
            $auth->mostrarLogin();
        }
        break;

    case 'procesar-login':
        // 🛡️ Redirección de seguridad inmediata si la sesión en el servidor ya está congelada
        if ($_SESSION['intentos_fallidos'] >= 3) {
            header("Location: index.php?accion=login");
            exit;
        }

        $auth->procesarLogin();
        break;

    case 'logout':
        $auth->logout();
        break;

    case 'nuevo-producto':
        requiereLogin();
        (new ProductoController())->nuevo();
        break;

    case 'guardar-producto':
        requiereLogin();
        (new ProductoController())->guardar();
        break;
        
    case 'catalogo':
        requiereLogin();
        (new ProductoController())->listar();
        break;

    case 'editar-producto':
        requiereLogin(); 
        (new ProductoController())->editar(); 
        break;

    case 'actualizar-producto':
        requiereLogin();
        (new ProductoController())->actualizar(); 
        break;
    
    case 'reporte-pdf':
        requiereLogin();
        (new ReporteController())->catalogoPdf();
        break;
        
    case 'eliminar-producto':
        requiereLogin(); 
        (new ProductoController())->eliminar(); 
        break;
}
?>