<?php


class Template{

    public $templateDir;


    public function __construct($templateDir = __DIR__ . '/../tpl')
    {
        $this->templateDir = rtrim($templateDir,'/');
    }


    // Carga tpl/{$file}.tpl y sustituye:
    //   {{ clave }}      -> $vars['clave']
    //   {{ lit:clave }}  -> Idioma::lit('clave')
    public function render($file,$vars=[])
    {
        $path = "{$this->templateDir}/{$file}.tpl";

        if (!file_exists($path))
            throw new Exception("La plantilla {$file} no existe en {$this->templateDir}");

        $contenido = file_get_contents($path);

        // Literales de idioma
        $contenido = preg_replace_callback(
            '/\{\{\s*lit:([a-zA-Z0-9_]+)\s*\}\}/',
            fn($m) => htmlspecialchars(Idioma::lit($m[1])),
            $contenido
        );

        // Variables
        foreach($vars as $key => $valor)
        {
            $contenido = preg_replace(
                '/\{\{\s*'.preg_quote($key,'/').'\s*\}\}/',
                htmlspecialchars((string)$valor),
                $contenido
            );
        }

        return $contenido;
    }



    static function header($titulo,$descripcion='')
    {
        Idioma::getInstancia();          // carga el fichero de idioma y fija Idioma::$codigo

        $template = new Template();

        return $template->render('header',[
                    'codigo'      => Idioma::$codigo
                    ,'titulo'      => $titulo
                    ,'descripcion' => $descripcion
            ])
            . self::navegacion(Campo::val('seccion'))
            . "\n<section class=\"hero\">\n<div class=\"container\">\n";
    }


    static function navegacion($seccion = '')
    {
        $template = new Template();

        return $template->render('nav',[
                    'activoHome'      => $seccion === ''         ? 'active' : ''
                    ,'activoUsuarios' => $seccion === 'usuarios' ? 'active' : ''
            ]);
    }


    static function footer()
    {
        $template = new Template();

        return $template->render('footer');
    }

}
