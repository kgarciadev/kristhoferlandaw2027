<?php

    require_once "includes/general.php";


    echo Template::header('Kristhofer');

    switch(Campo::val('seccion'))
    {
        case 'usuarios':
            require "includes/usuarios.php";   // lógica: BD, crear/editar/eliminar
            require "vistas/usuarios.php";     // HTML de la sección
        break;

        default:
            echo "
                <div id=\"carouselStacked\" class=\"carousel slide w-100\">
                    <div class=\"carousel-inner rounded-5\">
                        <div class=\"carousel-item active\">
                            <img src=\"img/fondo1.jpeg\" class=\"d-block w-100\" alt=\"...\">
                        </div>
                        <div class=\"carousel-item\">
                            <img src=\"img/fondo2.avif\" class=\"d-block w-100\" alt=\"...\">
                        </div>
                        <div class=\"carousel-item\">
                            <img src=\"img/fondo3.avif\" class=\"d-block w-100\" alt=\"...\">
                        </div>
                    </div>
                    <button class=\"carousel-control-prev\" type=\"button\" data-bs-target=\"#carouselStacked\" data-bs-slide=\"prev\">
                        <span class=\"carousel-control-prev-icon\" aria-hidden=\"true\"></span>
                        <span class=\"visually-hidden\">" . Idioma::lit('anterior') . "</span>
                    </button>
                    <button class=\"carousel-control-next\" type=\"button\" data-bs-target=\"#carouselStacked\" data-bs-slide=\"next\">
                        <span class=\"carousel-control-next-icon\" aria-hidden=\"true\"></span>
                        <span class=\"visually-hidden\">" . Idioma::lit('siguiente') . "</span>
                    </button>
                </div>
            ";
        break;
    }


    echo Template::footer();

/*
lanzarote.lan/usuarios/editar/232


lanzarote.lan?seccion=usuarios&modo=editar&id=232

*/


?>