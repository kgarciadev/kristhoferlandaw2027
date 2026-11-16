<?php
/** @var string $metodo */
/** @var string $mensaje */
/** @var array $usuarios */
/** @var array|null $editando */
/** @var int $pagina */
/** @var int $totalPaginas */
/** @var string $url */

?>
<div class="w-100" data-bs-theme="dark">

    <h2 class="text-white fw-bold fs-2 mb-4 pb-3 border-bottom border-secondary-subtle">Gestión de usuarios</h2>

    <?php if ($mensaje !== ''): ?>
        <div class="alert mb-4 <?= str_starts_with($mensaje, 'Error') || str_starts_with($mensaje, 'Conexión') ? 'alert-danger' : 'alert-info' ?>">
            <?= htmlspecialchars($mensaje) ?>
        </div>
    <?php endif; ?>

    <h4 class="text-white fs-5 fw-semibold mb-3"><?= $editando ? 'Editar usuario' : 'Registrar usuario' ?></h4>

    <form action="<?= $url ?>" method="post" class="row g-3 mb-5">
        <?php if ($editando): ?>
            <input type="hidden" name="accion" value="actualizar">
            <input type="hidden" name="id" value="<?= (int) $editando['id'] ?>">
        <?php else: ?>
            <input type="hidden" name="accion" value="crear">
        <?php endif; ?>

        <div class="col-md-4">
            <label for="nombre" class="form-label text-light">Nombre</label>
            <input type="text" id="nombre" name="nombre" maxlength="50" required class="form-control"
                   value="<?= htmlspecialchars($editando['nombre'] ?? '') ?>">
        </div>
        <div class="col-md-5">
            <label for="email" class="form-label text-light">Email</label>
            <input type="email" id="email" name="email" maxlength="100" required class="form-control"
                   value="<?= htmlspecialchars($editando['email'] ?? '') ?>">
        </div>
        <div class="col-md-3">
            <label for="edad" class="form-label text-light">Edad</label>
            <input type="number" id="edad" name="edad" min="0" max="999" required class="form-control"
                   value="<?= htmlspecialchars($editando['edad'] ?? '') ?>">
        </div>

        <div class="col-12 d-flex gap-2 pt-1">
            <button type="submit" class="btn btn-success px-4"><?= $editando ? 'Guardar cambios' : 'Registrar' ?></button>
            <?php if ($editando): ?>
                <a href="<?= $url ?>" class="btn btn-outline-secondary px-4">Cancelar</a>
            <?php endif; ?>
        </div>
    </form>

    <h4 class="text-white fs-5 fw-semibold mb-3">Usuarios registrados</h4>

    <?php if (empty($usuarios)): ?>
        <p class="text-body-secondary fst-italic mb-0">No hay usuarios registrados.</p>
    <?php else: ?>
        <div class="table-responsive rounded-3 border border-secondary-subtle shadow">
            <table class="table table-dark table-striped table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="bg-black text-body-secondary text-uppercase small fw-semibold py-3 px-3">ID</th>
                        <th class="bg-black text-body-secondary text-uppercase small fw-semibold py-3 px-3">Nombre</th>
                        <th class="bg-black text-body-secondary text-uppercase small fw-semibold py-3 px-3">Email</th>
                        <th class="bg-black text-body-secondary text-uppercase small fw-semibold py-3 px-3 text-center">Edad</th>
                        <th class="bg-black text-body-secondary text-uppercase small fw-semibold py-3 px-3 text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($usuarios as $u): ?>
                    <tr>
                        <td class="px-3 py-3 text-body-secondary"><?= (int) $u['id'] ?></td>
                        <td class="px-3 py-3 fw-semibold"><?= htmlspecialchars($u['nombre']) ?></td>
                        <td class="px-3 py-3 text-body-secondary"><?= htmlspecialchars($u['email']) ?></td>
                        <td class="px-3 py-3 text-center"><?= htmlspecialchars($u['edad'] ?? '') ?></td>
                        <td class="px-3 py-3 text-end text-nowrap">
                            <div class="d-inline-flex gap-2">
                            <a href="<?= $url ?>&editar=<?= (int) $u['id'] ?>" class="btn btn-sm btn-outline-success">Editar</a>

                            <form action="<?= $url ?>" method="post" class="d-inline"
                                  onsubmit="return confirm('¿Eliminar este usuario?');">
                                <input type="hidden" name="accion" value="eliminar">
                                <input type="hidden" name="id" value="<?= (int) $u['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                            </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <?php if ($totalPaginas > 1): ?>
        <nav aria-label="Paginación de usuarios" class="mt-4">
            <ul class="pagination justify-content-center">
                <?php if ($pagina > 0): ?>
                    <li class="page-item">
                        <a class="page-link" href="?seccion=usuarios&pagina=<?= $pagina - 1 ?>">Anterior</a>
                    </li>
                <?php endif; ?>
 
                <?php for ($i = 1; $i <= $totalPaginas; $i++) {
                    $classCurrentLink = ($pagina === ($i-1)) ? 'page-item disabled' : 'page-item';
                    ?>
            
                <li class="<?=  $classCurrentLink ?>">
                    <a class="page-link" href="?seccion=usuarios&pagina=<?= $i-1 ?>"><?= $i ?></a>
                </li>
 
                <?php 
                }
                if ($pagina < $totalPaginas - 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?seccion=usuarios&pagina=<?= $pagina + 1 ?>">Siguiente</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    <?php endif; ?>

</div>
