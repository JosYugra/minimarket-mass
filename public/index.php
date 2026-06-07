<?php
declare(strict_types=1);

// La sesión debe arrancar ANTES de cualquier salida al navegador.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
$_SESSION['intentos_fallidos'] = 0; // 👈 AGREGA ESTA LÍNEA TEMPORALMENTE
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
        // 1. Inicializar el contador de intentos si no existe
        if (!isset($_SESSION['intentos_fallidos'])) {
            $_SESSION['intentos_fallidos'] = 0;
        }

        // 2. Si ya falló 3 veces, bloqueamos antes de hacer cualquier consulta a la BD [cite: 11]
        if ($_SESSION['intentos_fallidos'] >= 3) {
            header("Location: index.php?accion=login&error=demasiados_intentos");
            exit;
        }

        // 3. ¡Delegación Correcta! El controlador se encarga de verificar las credenciales 
        // Dentro de este método procesarLogin(), si las credenciales fallan, 
        // debes aumentar el contador con $_SESSION['intentos_fallidos']++
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
    default:
        requiereLogin();                      // sin sesión → manda al login [cite: 115]
        (new ProductoController())->listar(); // ← llama al método REAL del controller [cite: 50]
        break;
} ?>