# kristhoferlandaw2027

Web en PHP con la plantilla **Knight** (Bootstrap 5) y una sección para gestionar usuarios (crear, listar, editar y eliminar) guardados en MySQL.

## Requisitos

- Apache con PHP 8 y la extensión `mysqli`.
- MySQL o MariaDB.

## Instalación

1. Clona el repositorio en la carpeta de Apache:

   ```bash
   git clone https://github.com/kgarciadev/kristhoferlandaw2027.git
   ```

2. Crea una base de datos y carga la tabla con datos de ejemplo:

   ```bash
   mysql -u tu_usuario -p tu_base_de_datos < tables/create_table_usuarios.sql
   ```

3. Copia la configuración y pon tus datos:

   ```bash
   cp includes/config.example.php includes/config.php
   ```

   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'tu_usuario');
   define('DB_PASS', 'tu_contraseña');
   define('DB_NAME', 'tu_base_de_datos');
   ```

   `includes/config.php` está en `.gitignore`, así que no se sube al repositorio.

4. Abre la web en el navegador.

## Uso

| URL | Qué muestra |
| --- | --- |
| `index.php` | Portada con carrusel |
| `index.php?seccion=usuarios` | Lista de usuarios (10 por página) |
| `index.php?seccion=usuarios&pagina=1` | Segunda página de la lista |
| `index.php?seccion=usuarios&editar=3` | Formulario para editar el usuario 3 |

## Estructura

```
├── index.php              # Entrada: elige la sección con ?seccion=
├── includes/
│   ├── general.php        # Autocarga de clases y constantes
│   ├── class.template.php # Cabecera, menú y footer
│   ├── bbdd/
│   │   ├── class.bbdd.php  # Conexión a la base de datos
│   │   └── class.query.php # Ejecuta consultas
│   ├── usuarios.php       # Lógica de la sección usuarios
│   └── config.example.php # Plantilla de configuración
├── vistas/
│   └── usuarios.php       # HTML de la sección usuarios
├── tables/
│   └── create_table_usuarios.sql
├── assets/                # CSS, JS y librerías de la plantilla
├── forms/                 # Formularios de la plantilla
└── img/                   # Imágenes propias
```

## Créditos

- Plantilla [Knight](https://bootstrapmade.com/knight-free-bootstrap-theme/) de [BootstrapMade](https://bootstrapmade.com/).
- [Bootstrap 5](https://getbootstrap.com/) y [Bootstrap Icons](https://icons.getbootstrap.com/).
