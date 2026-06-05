<?php
declare(strict_types=1);

// La sesión debe arrancar ANTES de cualquier salida al navegador.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../helpers/sesion.php';
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/ProductoController.php';

// Enrutamiento simple por ?accion=
$accion = $_GET['accion'] ?? 'catalogo';
$auth   = new AuthController();

switch ($accion) {

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

    case 'catalogo':
    default:
        requiereLogin();                      // sin sesión → manda al login [cite: 115]
        (new ProductoController())->listar(); // ← llama al método REAL del controller [cite: 50]
        break;
} ?>