<?php

abstract class Modelo
{
    protected string $tabla;

    protected function inicializar(array $fila): void
    {
        foreach ($fila as $columna => $valor) {
            if (property_exists($this, $columna)) {
                $this->$columna = $valor;
            }
        }
    }

    public function buscar(int $id): ?static
    {
        $query = new Query("SELECT * FROM {$this->tabla} WHERE id = ?", [$id]);
        $fila = $query->recover();

        if ($fila === null) {
            return null;
        }

        $objeto = new static();
        $objeto->inicializar($fila);
        return $objeto;
    }

    public function contar(): int
    {
        $query = new Query("SELECT COUNT(*) AS total FROM {$this->tabla}");
        return (int) $query->recover()['total'];
    }

    public function listar(int $limite, int $offset): array
    {
        $query = new Query("SELECT * FROM {$this->tabla} ORDER BY id LIMIT {$limite} OFFSET {$offset}");

        $registros = [];
        while ($fila = $query->recover()) {
            $objeto = new static();
            $objeto->inicializar($fila);
            $registros[] = $objeto;
        }
        return $registros;
    }

    public function crear(array $datos): int
    {
        $columnas = implode(', ', array_keys($datos));
        $huecos   = implode(', ', array_fill(0, count($datos), '?'));

        $query = new Query("INSERT INTO {$this->tabla} ({$columnas}) VALUES ({$huecos})", array_values($datos));
        return $query->total;
    }

    public function actualizar(int $id, array $datos): int
    {
        $asignaciones = implode(' = ?, ', array_keys($datos)) . ' = ?';

        $parametros   = array_values($datos);
        $parametros[] = $id;

        $query = new Query("UPDATE {$this->tabla} SET {$asignaciones} WHERE id = ?", $parametros);
        return $query->total;
    }

    public function eliminar(int $id): int
    {
        $query = new Query("DELETE FROM {$this->tabla} WHERE id = ?", [$id]);
        return $query->total;
    }
}