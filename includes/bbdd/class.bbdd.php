<?php

    require_once __DIR__ . '/../config.php';

    class BBDD {
        private static ?BBDD $instance = null;

        private mysqli $conexion;

        private function __construct() {
            try {
                $this->conexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                $this->conexion->set_charset("utf8mb4");
            } catch (mysqli_sql_exception $e) {
                error_log("Error de conexión BBDD: " . $e->getMessage());
                throw new Exception("No se pudo conectar a la base de datos.", 0, $e);
            }
        }

        public static function getInstance(): self {
            if (self::$instance === null) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        public function getConexion(): mysqli {
            return $this->conexion;
        }

        public function __clone(){}

    }