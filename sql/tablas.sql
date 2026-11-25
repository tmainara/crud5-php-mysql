-- =====================================================
-- Base de datos: biblioteca
-- MariaDB 10.x / 11.x
-- Contraseña de todos los usuarios: secret0 (bcrypt)
-- =====================================================

DROP DATABASE IF EXISTS biblioteca;
CREATE DATABASE biblioteca CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci;
USE biblioteca;

-- 
CREATE TABLE generos (
    id      INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre  VARCHAR(50) UNIQUE NOT NULL,
    color   CHAR(7) NOT NULL
);

CREATE TABLE usuarios (
    id        INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    email     VARCHAR(150) unique NOT NULL,
    password  VARCHAR(255) NOT NULL,
    perfil    TINYINT(1)   NOT NULL DEFAULT 0,
    CONSTRAINT ck_usuarios_perfil CHECK (perfil IN (0, 1))
);

-- 
CREATE TABLE libros (
    id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    titulo        VARCHAR(200) NOT NULL,
    sinopsis      TEXT         NOT NULL,
    disponible    ENUM('Si', 'No') NOT NULL DEFAULT 'No',
    portada       VARCHAR(255) NULL,
    created_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    genero_id     INT UNSIGNED NOT NULL,
    usuario_id    INT UNSIGNED NOT NULL,
    CONSTRAINT fk_libros_genero FOREIGN KEY (genero_id)
        REFERENCES generos(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_libros_usuario FOREIGN KEY (usuario_id)
        REFERENCES usuarios(id) ON DELETE CASCADE ON UPDATE CASCADE
);

-- =====================================================
-- DATOS
-- =====================================================

INSERT INTO generos (nombre, color) VALUES
('Novela',          '#E74C3C'),
('Poesía',          '#9B59B6'),
('Ciencia ficción', '#3498DB'),
('Ensayo',          '#27AE60'),
('Informática',     '#F39C12');

-- perfil: 1 = administrador, 0 = usuario normal
INSERT INTO usuarios (email, password, perfil) VALUES
('admin@biblioteca.test',  '$2y$10$JD0ExFiLTyL9S5KuOOvnFO9DhMzVwFH5NAtrSS0Q/1nPNtcTw7KNK', 1),
('lucia@biblioteca.test',  '$2y$10$JD0ExFiLTyL9S5KuOOvnFO9DhMzVwFH5NAtrSS0Q/1nPNtcTw7KNK', 1),
('pedro@biblioteca.test',  '$2y$10$JD0ExFiLTyL9S5KuOOvnFO9DhMzVwFH5NAtrSS0Q/1nPNtcTw7KNK', 0),
('ana@biblioteca.test',    '$2y$10$JD0ExFiLTyL9S5KuOOvnFO9DhMzVwFH5NAtrSS0Q/1nPNtcTw7KNK', 0),
('javier@biblioteca.test', '$2y$10$JD0ExFiLTyL9S5KuOOvnFO9DhMzVwFH5NAtrSS0Q/1nPNtcTw7KNK', 0);

INSERT INTO libros (titulo, sinopsis, disponible, portada, genero_id, usuario_id) VALUES
('Don Quijote de la Mancha',
 'Un hidalgo manchego enloquece leyendo libros de caballerías y sale a recorrer los caminos acompañado de su escudero Sancho Panza.',
 'Si', 'portadas/quijote.jpg', 1, 1),
('Cien años de soledad',
 'La historia de la familia Buendía a lo largo de siete generaciones en el pueblo imaginario de Macondo.',
 'Si', 'portadas/cien-anos.jpg', 1, 2),
('Nada',
 'Andrea llega a Barcelona tras la guerra para estudiar y se instala en casa de sus parientes, en un piso de la calle Aribau.',
 'No', NULL, 1, 3),
('Romancero gitano',
 'Dieciocho romances de Lorca sobre la Andalucía gitana, la luna, la muerte y la Guardia Civil.',
 'Si', 'portadas/romancero.jpg', 2, 2),
('Poeta en Nueva York',
 'Poemas escritos durante la estancia de Lorca en Nueva York entre 1929 y 1930.',
 'No', NULL, 2, 4),
('Fundación',
 'El matemático Hari Seldon prevé la caída del Imperio Galáctico y crea un plan para acortar la época de barbarie que vendrá después.',
 'Si', 'portadas/fundacion.jpg', 3, 3),
('Yo, robot',
 'Relatos sobre robots y las tres leyes de la robótica, contados a través de la robopsicóloga Susan Calvin.',
 'Si', 'portadas/yo-robot.jpg', 3, 5),
('El origen de las especies',
 'Darwin expone su teoría de la evolución por selección natural con ejemplos recogidos durante años.',
 'No', 'portadas/origen-especies.jpg', 4, 1),
('Código limpio',
 'Buenas prácticas para escribir código legible y fácil de mantener: nombres, funciones, comentarios y pruebas.',
 'Si', 'portadas/codigo-limpio.jpg', 5, 4),
('Aprende PHP con ejercicios',
 'Ejercicios resueltos de PHP desde lo básico hasta el acceso a bases de datos con PDO.',
 'No', NULL, 5, 5);