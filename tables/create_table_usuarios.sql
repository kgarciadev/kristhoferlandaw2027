DROP TABLE IF EXISTS usuarios;
 
CREATE TABLE usuarios(

    id      INT UNSIGNED      NOT NULL AUTO_INCREMENT,
    nombre  VARCHAR(50)       NOT NULL,
    email   VARCHAR(100)      NOT NULL,
    edad    SMALLINT UNSIGNED NULL,

    -- DATOS AUDITORIA  --

    usuario_alta  varchar(255),
    fecha_alta    DATETIME,
    ip_alta       CHAR(15),
    usuario_modi  varchar(255),
    fecha_modi    DATETIME,
    ip_modi       CHAR(15),

    PRIMARY KEY (id),
    UNIQUE KEY uk_usuarios_email (email)
);
 
 
-- ------------------------------------------------------------
--  Datos de ejemplo (33 usuarios → 4 páginas de 10)
-- ------------------------------------------------------------
 
INSERT INTO usuarios (nombre, email, edad) VALUES
('Lucía Martín',      'lucia.martin@example.com',      24),
('Carlos Rodríguez',  'carlos.rodriguez@example.com',  31),
('Ana Torres',        'ana.torres@example.com',        19),
('Javier López',      'javier.lopez@example.com',      45),
('María Fernández',   'maria.fernandez@example.com',   28),
('David Sánchez',     'david.sanchez@example.com',     37),
('Laura Gómez',       'laura.gomez@example.com',       22),
('Pablo Díaz',        'pablo.diaz@example.com',        53),
('Sara Romero',       'sara.romero@example.com',       26),
('Miguel Álvarez',    'miguel.alvarez@example.com',    40),
('Elena Ruiz',        'elena.ruiz@example.com',        33),
('Sergio Moreno',     'sergio.moreno@example.com',     29),
('Carmen Navarro',    'carmen.navarro@example.com',    61),
('Adrián Jiménez',    'adrian.jimenez@example.com',    18),
('Paula Herrera',     'paula.herrera@example.com',     35),
('Raúl Castro',       'raul.castro@example.com',       42),
('Marta Ortega',      'marta.ortega@example.com',      27),
('Alejandro Rubio',   'alejandro.rubio@example.com',   50),
('Irene Molina',      'irene.molina@example.com',      23),
('Hugo Delgado',      'hugo.delgado@example.com',      30),
('Nerea Suárez',      'nerea.suarez@example.com',      21),
('Daniel Morales',    'daniel.morales@example.com',    38),
('Claudia Ramos',     'claudia.ramos@example.com',     25),
('Iván Vega',         'ivan.vega@example.com',         47),
('Alba Medina',       'alba.medina@example.com',       20),
('Rubén Cabrera',     'ruben.cabrera@example.com',     34),
('Noelia Santana',    'noelia.santana@example.com',    29),
('Óscar Hernández',   'oscar.hernandez@example.com',   56),
('Andrea Perdomo',    'andrea.perdomo@example.com',    32),
('Jorge Betancor',    'jorge.betancor@example.com',    44),
('Cristina León',     'cristina.leon@example.com',     39),
('Tomás O''Brien',    'tomas.obrien@example.com',      27),
('Yaiza Curbelo',     'yaiza.curbelo@example.com',     NULL);