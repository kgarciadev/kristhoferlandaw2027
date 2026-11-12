<?php

    class Query {

        private mysqli $conexion;
        private mysqli_result|bool|null $result = null;
        public int $total = 0;

        public function __construct(string $sql, array $params = []) {
            
            $this->conexion = BBDD::getInstance()->getConexion();

            if (empty($params)) {
                // Consulta sin datos externos: se ejecuta directamente
                $this->result = $this->conexion->query($sql);
                $afectadas    = $this->conexion->affected_rows;
            } else {
                // Consulta con datos: en dos pasos
                $stmt = $this->conexion->prepare($sql);
                $stmt->execute($params);
                $this->result = $stmt->get_result();
                $afectadas    = $stmt->affected_rows;
                $stmt->close();
            }

            if ($this->result instanceof mysqli_result) {
                $this->total = $this->result->num_rows;
            } else {
                $this->total = $afectadas;
            }
        }   

        public function recover(): ?array {
            if (!$this->result instanceof mysqli_result) {
                return null;
            }

            $registro = $this->result->fetch_assoc();
            if ($registro === null) {
                $this->result->free();
                $this->result = null;
            }

            return $registro;
        }

        public function getLastInsertId(): int {
            return $this->conexion->insert_id;
        }
    }