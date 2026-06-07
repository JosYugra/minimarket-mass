<?php
declare(strict_types=1);
require_once __DIR__ . '/Usuario.php';
require_once __DIR__ . '/../config/conexion.php';

class UsuarioRepository {

    public function buscarPorUsername(string $username): ?Usuario {
        try {
            $pdo  = getConexion();
            $stmt = $pdo->prepare(
                "SELECT id, username, nombres, apellidos, rol, tienda, password_hash
                 FROM usuarios
                 WHERE username = :username AND activo = 1"
            );
            $stmt->execute([':username' => $username]);
            $f = $stmt->fetch();
            if ($f === false) return null;
            return new Usuario(
                (int) $f['id'], $f['username'], $f['nombres'], $f['apellidos'],
                $f['rol'], $f['tienda'], $f['password_hash']
            );
        } catch (PDOException $e) {
            error_log('[UsuarioRepository] ' . $e->getMessage());
            return null;
        }
    }

    public function registrarAcceso(int $id): void {
        try {
            // 🟢 CORRECCIÓN: Usamos getConexion() nativo de Laragon para enlazar la BD
            $pdo = getConexion();
            
            $sql = "UPDATE usuarios 
                    SET ultimo_acceso = NOW(), 
                        contador_accesos = contador_accesos + 1 
                    WHERE id = :id";
                    
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            
        } catch (PDOException $e) {
            // Log de errores en modo silencioso para desarrollo
            error_log("Error al registrar acceso del usuario ID {$id}: " . $e->getMessage());
        }
    }
}