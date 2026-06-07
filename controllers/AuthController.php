<?php
declare(strict_types=1);
require_once __DIR__ . '/../models/UsuarioRepository.php';

class AuthController {

    public function mostrarLogin(string $error = ''): void {
         // La variable $error estará disponible automáticamente dentro de login.php
         require __DIR__ . '/../views/auth/login.php';
    }

    public function procesarLogin(): void {
        // Aseguramos que la sesión esté disponible para leer/escribir los intentos
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $username = trim($_POST['username'] ?? '') ?? ''; 
        $password = $_POST['password'] ?? '';

        if ($username === '' || $password === '') {
            $this->mostrarLogin('Completa usuario y contraseña.');
            return;
        }

        $repo    = new UsuarioRepository();
        $usuario = $repo->buscarPorUsername($username);
        
       
        // 🔴 CONTROL DE INTENTOS SI FALLA EL LOGIN (No existe usuario o clave incorrecta)
        if ($usuario === null || !password_verify($password, $usuario->getPasswordHash())) {
            
            // Inicializamos el contador si no existía en la sesión
            if (!isset($_SESSION['intentos_fallidos'])) {
                $_SESSION['intentos_fallidos'] = 0;
            }
            
            // Incrementamos el fallo actual 
            $_SESSION['intentos_fallidos']++;

            // Evaluamos si con este último fallo ya acumuló 3 o más
            if ($_SESSION['intentos_fallidos'] >= 3) {
                $this->mostrarLogin('Demasiados intentos.');
            } else {
                $this->mostrarLogin('Usuario o contraseña incorrectos.');
            }
            exit;
        }

        // ====================================================================
        // 🟢 LOGIN EXITOSO: 
        // ====================================================================
        
        // 1. Reseteamos los intentos a 0 de inmediato 
        $_SESSION['intentos_fallidos'] = 0;

        // 2. Registramos en la Base de Datos el acceso usando el objeto $repo e ID del usuario
        $repo->registrarAcceso($usuario->getId());

        // 3. Guardamos los datos en la sesión 
        $_SESSION['usuario'] = [
            'id'       => $usuario->getId(),
            'username' => $usuario->getUsername(),
            'nombre'   => $usuario->getNombreCompleto(),
            'rol'      => $usuario->getRol(),
            'tienda'   => $usuario->getTienda(),
            'ultimo_acceso' => date('d/m/Y H:i') 
        ];

        // 4. Redirección final segura
        header('Location: index.php?accion=catalogo');
        exit;
    }

    public function logout(): void {
        $_SESSION = [];
        session_destroy();
        header('Location: index.php?accion=login');
        exit;
    }
    
}