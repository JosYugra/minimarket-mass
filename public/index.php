<?php
declare(strict_types=1);

// ====================================================================
// 🚨 PASO 1: FOCO DE EMERGENCIA (Activado inmediatamente después del declare)
// ====================================================================
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

// La sesión debe arrancar ANTES de cualquier salida al navegador.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
    $_SESSION['intentos_fallidos'] = 0; // 👈 Línea temporal de desarrollo
}

require_once __DIR__ . '/../helpers/sesion.php';
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/ProductoController.php';

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
        $auth->mostrarLogin();
        break;

    case 'procesar-login':
        if (!isset($_SESSION['intentos_fallidos'])) {
            $_SESSION['intentos_fallidos'] = 0;
        }

        if ($_SESSION['intentos_fallidos'] >= 3) {
            header("Location: index.php?accion=login&error=demasiados_intentos");
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

    // ====================================================================
    //  Instanciación en línea + Guardianes de Seguridad activados
    // ====================================================================
    case 'editar-producto':
        requiereLogin(); // No permite intrusos sin sesión
        (new ProductoController())->editar(); // Instancia directa corregida
        break;

    case 'actualizar-producto':
        requiereLogin();
        (new ProductoController())->actualizar(); // Instancia directa corregida
        break;
        
    case 'eliminar-producto':
        requiereLogin(); // Protector de seguridad
        (new ProductoController())->eliminar(); // Invoca al método del controlador
        break;

    case 'reportes':
        requiereLogin();
        (new ProductoController())->reportes();
        break;
}
?>