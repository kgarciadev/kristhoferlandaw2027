<?php

$usuario = new Usuario();

$mensaje = "";
$usuarios = [];
$editando = null;
$totalPaginas = 1;

$pagina = max(0, (int) Campo::val('pagina'));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $accion = Campo::val('accion');
    $id = (int) Campo::val('id');
    $edad = Campo::val('edad') !== '' ? (int) Campo::val('edad') : null;

    $datos = [
        'nombre' => Campo::val('nombre'),
        'email'  => Campo::val('email'),
        'edad'   => $edad,
    ];

    try {
        switch ($accion) {
            case 'crear':
                $usuario->crear($datos);
                $mensaje = "Usuario registrado correctamente.";
                break;

            case 'actualizar':
                if ($usuario->actualizar($id, $datos) > 0) {
                    $mensaje = "Usuario actualizado correctamente.";
                } else {
                    $mensaje = "No se realizaron cambios en el usuario.";
                }
                break;

            case 'eliminar':
                if ($usuario->eliminar($id) > 0) {
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
    if (Campo::val('editar') !== '') {
        $editando = $usuario->buscar((int) Campo::val('editar'));

        if($editando === null && $mensaje === '') {
            $mensaje = "No se encontró el usuario para editar.";
        }
    }

    $totalUsuarios = $usuario->contar();
    $totalPaginas = max(1, (int) ceil($totalUsuarios / TOTAL_PAGINAS_LISTADO));

    $pagina = min($pagina, $totalPaginas - 1);

    $offset = $pagina * TOTAL_PAGINAS_LISTADO;
    $usuarios = $usuario->listar(TOTAL_PAGINAS_LISTADO, $offset);
} catch (mysqli_sql_exception $e) {
    error_log($e->getMessage());
    $mensaje = "Error: no se pudo recuperar la lista de usuarios. Por favor, inténtelo de nuevo.";
    $usuarios = [];
} catch (Exception $e) {
    $mensaje = "Error: " . $e->getMessage();
    $usuarios = [];
}

$url = "?seccion=usuarios&pagina={$pagina}";