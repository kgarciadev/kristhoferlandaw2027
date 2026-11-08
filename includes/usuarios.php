<?php
/*
 * vista.php
 * ---------
 * Interfaz de usuario compartida por procedimental.php, orientado_objetos.php y pdo.php.
 * Solo contiene HTML y lo mínimo de PHP para mostrar datos. No toca la base de datos.
 *
 * Variables que cada archivo debe preparar ANTES de hacer require 'vista.php':
 *   $metodo    -> string: nombre del método usado (ej. "PDO")
 *   $mensaje   -> string: mensaje de éxito o error ("" si no hay)
 *   $usuarios  -> array de arrays asociativos con id, nombre, email, edad
 *   $editando  -> array con el usuario a editar, o null si se está creando uno nuevo
 */

// Valores por defecto por si alguna variable no se ha definido

mysqli_report(MYSQLI_REPORT_OFF);
require __DIR__ . '/config.php';
$conexion = new mysqli($servidor, $usuario, $contraseña,
$base_datos);
$metodo   = 'Orientado a objetos';
$mensaje  = $mensaje  ?? '';
$editando = $editando ?? null;

if ($conexion->connect_error) {
    // En vez de die(): guardamos el error y salimos de este archivo con return.
    // index.php sigue ejecutándose y la vista muestra el mensaje con la plantilla completa.
    $mensaje  = "Conexión fallida: " . $conexion->connect_error;
    $usuarios = [];
    return;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $accion = $_POST['accion'] ?? '';

    switch ($accion) {
        case 'crear':
            // INSERT preparado con nombre, email, edad
            $edad = ($_POST['edad'] ?? '') !== '' ? (int) $_POST['edad'] : null;
            $query = "INSERT INTO usuarios (nombre, email, edad) VALUES (?, ?, ?)";
            $stmt = $conexion->prepare($query);
            $stmt->bind_param("ssi", $_POST['nombre'], $_POST['email'], $edad);
            if ($stmt->execute()) {
                $mensaje = "Usuario creado exitosamente.";
            } else if($stmt->errno == 1062) {
                $mensaje = "Error: El email ya está registrado.";
            } else {
                $mensaje = "Error al crear el usuario: " . $stmt->error;        
            }
            $stmt->close();
            break;

        case 'actualizar':
            // UPDATE preparado con nombre, email, edad WHERE id = ?
            $id = (int) ($_POST['id'] ?? 0);
            $edad = ($_POST['edad'] ?? '') !== '' ? (int) $_POST['edad'] : null;
            $query = "UPDATE usuarios SET nombre = ?, email = ?, edad = ? WHERE id = ?";
            $stmt = $conexion->prepare($query);
            $stmt->bind_param("ssii", $_POST['nombre'], $_POST['email'], $edad, $id );
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $mensaje = "Usuario actualizado exitosamente.";
                } else {
                    $mensaje = "No se realizaron cambios en el usuario.";
                }
            } else if($stmt->errno == 1062) {
                $mensaje = "Error: El email ya está registrado.";
            } else {
                $mensaje = "Error al actualizar el usuario: " . $stmt->error;
            }
            $stmt->close();
            break;

        case 'eliminar':
            // DELETE preparado WHERE id = ?
            $id = (int) ($_POST['id'] ?? 0);
            $query = "DELETE FROM usuarios WHERE id = ?";
            $stmt = $conexion->prepare($query);
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $mensaje = "Usuario eliminado exitosamente.";
                } else {
                    $mensaje = "No se encontró el usuario para eliminar.";
                }  
            } else {
                $mensaje = "Error al eliminar el usuario: " . $stmt->error;
            }
            $stmt->close();
            break;
            }
}

if (isset($_GET['editar'])) {
    $id = (int) $_GET['editar'];
    $query = "SELECT * FROM usuarios WHERE id = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $editando = $resultado->fetch_assoc();
    $stmt->close();

    if (!$editando) {
        if ($mensaje === '') {
        $mensaje = "Usuario no encontrado para editar.";
        }
        $editando = null;
    }
}

$query = "SELECT * FROM usuarios";
$resultado = $conexion->query($query);
if (!$resultado) {
    // Igual que arriba: mensaje de error y lista vacía, sin cortar la página
    $mensaje  = "Error en la consulta: " . $conexion->error;
    $usuarios = [];
    return;
}
$usuarios = $resultado->fetch_all(MYSQLI_ASSOC);


?>