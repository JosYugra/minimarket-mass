<?php
declare(strict_types=1);

function requiereLogin(): void {
    if (!isset($_SESSION['usuario'])) {
        header('Location: index.php?accion=login');
        exit;
    }
}

function usuarioActual(): ?array {
    return $_SESSION['usuario'] ?? null;
}

function requiereRol(string $rol): void {
    // 1. Asegurar que el usuario esté logueado
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Si no hay sesión activa, redirige o detiene
    if (!isset($_SESSION['usuario'])) {
        header("Location: index.php?accion=login");
        exit;
    }

    // 2. Validar si el rol coincide con el solicitado
    if ($_SESSION['usuario']['rol'] !== $rol) {
        // En lugar de colapsar, mostramos un mensaje limpio de rechazo administrativo
        http_response_code(403);
        echo "<div style='font-family:Sans-serif; text-align:center; margin-top:50px;'>";
        echo "<h1 style='color:#dc2626;'>🚫 Acceso Denegado</h1>";
        echo "<p>Lo sentimos, esta sección es exclusiva para el rol: <b>" . htmlspecialchars($rol) . "</b>.</p>";
        echo "<a href='index.php?accion=lista-productos'>Volver al Catálogo</a>";
        echo "</div>";
        exit;
    }
}