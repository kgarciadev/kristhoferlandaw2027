# kristhoferlandaw2027

Sitio web en PHP con la plantilla **Knight** (Bootstrap 5) y una sección de **gestión de usuarios** (CRUD) conectada a MySQL con `mysqli` orientado a objetos.

## Características

- Plantilla común (cabecera, menú y footer) generada desde la clase `Template`.
- Navegación por secciones con `index.php?seccion=...`; el menú marca la sección activa.
- Portada con carrusel de imágenes.
- Sección **Usuarios**: registrar, listar, editar y eliminar usuarios.
  - Consultas preparadas (`prepare` + `bind_param`).
  - Aviso si el email ya está registrado.
  - Si falla la base de datos, la página se muestra igualmente con un mensaje de error.

## Requisitos

- Apache 2 con PHP 8 (probado con PHP 8.5).
- Extensión `mysqli` de PHP.
- MySQL / MariaDB.

## Instalación

1. **Clonar el repositorio** dentro de la carpeta que sirve Apache:

   ```bash
   git clone https://github.com/kgarciadev/kristhoferlandaw2027.git
   ```

2. **Crear la base de datos y la tabla:**

   ```sql
   CREATE DATABASE gestion_usuarios CHARACTER SET utf8mb4;
   USE gestion_usuarios;

   CREATE TABLE usuarios (
     id     INT NOT NULL AUTO_INCREMENT,
     nombre VARCHAR(50)  NOT NULL,
     email  VARCHAR(100) NOT NULL,
     edad   INT DEFAULT NULL,
     PRIMARY KEY (id),
     UNIQUE KEY email (email)
   ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
   ```

3. **Configurar la conexión.** Copia la plantilla y pon tus datos reales:

   ```bash
   cp includes/config.example.php includes/config.php
   ```

   ```php
   $servidor   = 'localhost';
   $usuario    = 'tu_usuario';
   $contraseña = 'tu_contraseña';
   $base_datos = 'gestion_usuarios';
   ```

   > `includes/config.php` está en `.gitignore`: **nunca se sube al repositorio**, así las credenciales no quedan públicas.

4. Abrir en el navegador, por ejemplo `http://kristho.fer/kristhoferlandaw2027/`.

## Uso

| URL | Qué muestra |
| --- | --- |
| `index.php` | Portada con el carrusel |
| `index.php?seccion=usuarios` | Gestión de usuarios |
| `index.php?seccion=usuarios&editar=3` | Formulario con el usuario 3 cargado para editarlo |

## Estructura

```
kristhoferlandaw2027/
├── index.php                 # Punto de entrada: elige la sección con ?seccion=
├── includes/
│   ├── general.php           # Autocarga de clases (includes/class.<nombre>.php)
│   ├── class.template.php    # Clase Template: header(), navegacion(), footer()
│   ├── usuarios.php          # Lógica de usuarios (conexión mysqli y CRUD)
│   ├── config.example.php    # Plantilla de configuración (sí se sube)
│   └── config.php            # Credenciales reales (NO se sube)
├── vistas/
│   └── usuarios.php          # HTML de la sección usuarios (Bootstrap, tema oscuro)
├── assets/                   # CSS, JS y librerías de la plantilla Knight
├── forms/                    # Scripts de los formularios de la plantilla (newsletter, contacto)
└── img/                      # Imágenes propias (carrusel, etc.)
```

### Cómo funciona una sección

`index.php` pinta la cabecera, carga la sección pedida y pinta el footer:

```php
echo Template::header('Kristhofer');

switch ($_GET['seccion'] ?? '') {
    case 'usuarios':
        require "includes/usuarios.php";   // prepara $mensaje, $usuarios, $editando...
        require "vistas/usuarios.php";     // muestra esos datos
        break;
    default:
        // portada
}

echo Template::footer();
```

Para añadir una sección nueva:

1. Crea su lógica en `includes/` y su HTML en `vistas/`.
2. Añade un `case` en `index.php`.
3. Añade el enlace en `Template::navegacion()`.

## Errores

En el servidor, `display_errors` está desactivado, así que los errores de PHP no aparecen en la página. Se guardan en el log de Apache:

```bash
tail -f /var/log/apache2/kristho.fer.error.log
```

## Créditos

- Plantilla [Knight](https://bootstrapmade.com/knight-free-bootstrap-theme/) de [BootstrapMade](https://bootstrapmade.com/).
- [Bootstrap 5](https://getbootstrap.com/) y [Bootstrap Icons](https://icons.getbootstrap.com/).
