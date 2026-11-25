<?php

class Campo
{
    private static $instance = null;
    private static $val = array();

    private function __construct()
    {
        self::build($_COOKIE);
        self::build($_GET);
        self::build($_POST);

        if(session_status() == PHP_SESSION_NONE)
            session_start();

        self::build($_SESSION);


    }

    private static function build(array $type): void
    {
        foreach ($type as $clave => $valor)
        {
            if(self::comprobar_inyeccion($valor))
                {
                    self::$val[$clave] = $valor;
                }
        }
    }

    public static function getInstancia(): Campo
    {
        if(self::$instance === null)
            self::$instance = new Campo();
            
        return self::$instance;
    }

    static function val($clave, $set_value = null)
    {
        self::getInstancia();                 // primero cargar siempre COOKIE/GET/POST/SESSION

        if ($set_value !== null)
            self::$val[$clave] = $set_value;

        return self::$val[$clave] ?? '';
    }

    public static function comprobar_inyeccion($valor)
    {
        if (!is_string($valor))
            return True;

        if (preg_match('/\b(SELECT\b.+?\bFROM|UPDATE\b.+?\bSET|DELETE\s+FROM|INSERT\s+INTO|DROP\s+TABLE)\b/is', $valor))
            die;

        return True;
    }
}