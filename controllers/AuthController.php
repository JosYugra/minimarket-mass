<?php
declare(strict_types=1);
require_once __DIR__ . '/../models/UsuarioRepository.php';

class AuthController {

    public function mostrarLogin(string $error = ''): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Si no viene un error por parámetro, revisamos si viene como mensaje flash en la URL
        if (empty($error) && isset($_GET['error'])) {
            if ($_GET['error'] === 'bloqueado') {
                $error = '🚨 ACCESO BLOQUEADO. Demasiados intentos fallidos.';
            } elseif ($_GET['error'] === 'incorrecto') {
                $error = 'Usuario o contraseña incorrectos.';
            } elseif ($_GET['error'] === 'incompleto') {
                $error = 'Completa usuario y contraseña.';
            }
        }

        // Si la sesión ya registra 3 fallos, forzamos que el error sea siempre el de bloqueo
        $intentos = $_SESSION['intentos_fallidos'] ?? 0;
        if ($intentos >= 3) {
            $error = '🚨 ACCESO BLOQUEADO. Demasiados intentos fallidos.';
        }

        require __DIR__ . '/../views/auth/login.php';
    }

    public function procesarLogin(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // 🛡️ CONTROL INICIAL: Si ya está bloqueado, redirigimos de inmediato al login limpio
        if (($_SESSION['intentos_fallidos'] ?? 0) >= 3) {
            header('Location: index.php?accion=login&error=bloqueado');
            exit;
        }

        $username = trim($_POST['username'] ?? ''); 
        $password = $_POST['password'] ?? '';

        if ($username === '' || $password === '') {
            header('Location: index.php?accion=login&error=incompleto');
            exit;
        }

        $repo    = new UsuarioRepository();
        $usuario = $repo->buscarPorUsername($username);
        
        // 🔴 CONTROL DE INTENTOS SI FALLA EL ACCESO
        if ($usuario === null || !password_verify($password, $usuario->getPasswordHash())) {
            
            if (!isset($_SESSION['intentos_fallidos'])) {
                $_SESSION['intentos_fallidos'] = 0;
            }
            
            $_SESSION['intentos_fallidos']++;

            // Evaluamos el contador después del incremento
            if ($_SESSION['intentos_fallidos'] >= 3) {
                // Redirección limpia cambiando la URL a estado bloqueado
                header('Location: index.php?accion=login&error=bloqueado');
            } else {
                // Redirección limpia para el error común
                header('Location: index.php?accion=login&error=incorrecto');
            }
            exit;
        }

        // ====================================================================
        // 🟢 LOGIN EXITOSO
        // ====================================================================
        $_SESSION['intentos_fallidos'] = 0;
        $repo->registrarAcceso($usuario->getId());

        $_SESSION['usuario'] = [
            'id'           => $usuario->getId(),
            'username'     => $usuario->getUsername(),
            'nombre'       => $usuario->getNombreCompleto(),
            'rol'          => $usuario->getRol(),
            'tienda'       => $usuario->getTienda(),
            'ultimo_acceso'=> date('d/m/Y H:i') 
        ];

        header('Location: index.php?accion=catalogo');
        exit;
    }

    public function logout(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = [];
        session_destroy();
        header('Location: index.php?accion=login');
        exit;
    }
}