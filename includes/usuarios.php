<?php

$mensaje = "";
$usuarios = [];
$editando = null;
$totalPaginas = 1;

$pagina = max(0, (int) ($_GET['pagina'] ?? 0));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $accion = $_POST['accion'] ?? '';
    $id = (int) ($_POST['id'] ?? 0);
    $edad = ($_POST['edad'] ?? '') !== '' ? (int) $_POST['edad'] : null;

    try {
        switch ($accion) {
            case 'crear':
                $query = new Query("INSERT INTO usuarios (nombre, email, edad) VALUES (?, ?, ?)", [$_POST['nombre'] ?? '', $_POST['email'] ?? '', $edad]);
                $mensaje = "Usuario registrado correctamente.";
                break;

            case 'actualizar':
                $query = new Query("UPDATE usuarios SET nombre = ?, email = ?, edad = ? WHERE id = ?", [$_POST['nombre'] ?? '', $_POST['email'] ?? '', $edad, $id]);
                if ($query->total > 0) {
                    $mensaje = "Usuario actualizado correctamente.";
                } else {
                    $mensaje = "No se realizaron cambios en el usuario.";
                }
                break;

            case 'eliminar':
                $query = new Query("DELETE FROM usuarios WHERE id = ?", [$id]);
                if ($query->total > 0) {
                    $mensaje = "Usuario eliminado correctamente.";
                } else {
                    $mensaje = "No se encontró el usuario para eliminar.";
                }
                break;
        }
    } catch (mysqli_sql_exception $e) {
        error_log($e->getMessage());
        $mensaje = $e->getCode() === 1062
            ? "Error: El email ya está registrado."
            : "Error: no se pudo procesar la solicitud. Por favor, inténtelo de nuevo.";
    } catch (Exception $e) {
        $mensaje = "Error: " . $e->getMessage();
    }
}

try {
    if (isset($_GET['editar'])) {
        $query = new Query("SELECT * FROM usuarios WHERE id = ?", [(int) $_GET['editar']]);
        $editando = $query->recover();

        if($editando === null && $mensaje === '') {
            $mensaje = "No se encontró el usuario para editar.";
        }
    }

    $query = new Query("SELECT COUNT(*) AS total FROM usuarios");
    $totalUsuarios = (int) $query->recover()['total'];
    $totalPaginas = max(1, (int) ceil($totalUsuarios / TOTAL_PAGINAS_LISTADO));

    $pagina = min($pagina, $totalPaginas - 1);

    $offset = $pagina * TOTAL_PAGINAS_LISTADO;
    $query = new Query("SELECT * FROM usuarios ORDER BY id LIMIT " . TOTAL_PAGINAS_LISTADO . " OFFSET " . $offset);
    while ($fila = $query->recover()) {
        $usuarios[] = $fila;
    } 
} catch (mysqli_sql_exception $e) {
    error_log($e->getMessage());
    $mensaje = "Error: no se pudo recuperar la lista de usuarios. Por favor, inténtelo de nuevo.";
    $usuarios = [];
} catch (Exception $e) {
    $mensaje = "Error: " . $e->getMessage();
    $usuarios = [];
}

$url = "?seccion=usuarios&pagina={$pagina}";

