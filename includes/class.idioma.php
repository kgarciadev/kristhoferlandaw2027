<?php

    class Idioma
    {
        private static $instancia = null;

        public static $lit = array();

        // Idiomas disponibles (tienen su fichero en /lang)
        const IDIOMAS = ['es', 'en', 'de'];

        // Código del idioma activo (para <html lang="...">)
        public static $codigo = 'es';


        private function __construct()
        {
            $idioma =  explode('.',$_SERVER['HTTP_HOST'] ?? '')[0];


            // www, lanzarote, kristho... o cualquier subdominio sin traducción -> español
            if (!in_array($idioma, self::IDIOMAS))
                $idioma = 'es';

            self::$codigo = $idioma;

            // Ruta relativa a este fichero: funciona aunque el proyecto esté en una subcarpeta
            $decriptor= fopen(__DIR__ . '/../lang/'. $idioma .'.txt','r');

            if ($decriptor)
            {

                while ($linea = fgets($decriptor))
                {
                    $linea = trim($linea);

                    if ($linea === '')
                        continue;

                    // Límite 2: el texto traducido puede contener ':'
                    $partes_linea = explode(':',$linea,2);

                    self::$lit[$partes_linea[0]] = trim($partes_linea[1] ?? '');

            
                }

                fclose($decriptor);
            }
        }

        public static function getInstancia(): Idioma {

            if (self::$instancia == null){
         
                self::$instancia = new Idioma();
            }

            return self::$instancia;
        }

        public static function lit($campo)
        {
            self::getInstancia();

            // Si falta la clave, se muestra la propia clave en vez de un warning
            return self::$lit[$campo] ?? $campo;

        }


        public function __clone(){}
    }