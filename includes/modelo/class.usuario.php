<?php

class Usuario extends Modelo
{
    protected string $tabla = 'usuarios';

    public $id;
    public $nombre;
    public $email;
    public $edad;
}