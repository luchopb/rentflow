CREATE TABLE propiedades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    tipo VARCHAR(100),
    direccion VARCHAR(255),
    galeria VARCHAR(255),
    local VARCHAR(100),
    precio DECIMAL(10, 0),
    incluye_gc BOOLEAN,
    gastos_comunes DECIMAL(10, 0),
    estado ENUM('alquilado', 'libre', 'en venta', 'uso propio'),
    anep VARCHAR(100),
    contribucion_inmobiliaria VARCHAR(100),
    comentarios TEXT,
    imagenes TEXT,
    propietario_id INT NULL
);

CREATE TABLE inquilinos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    telefono VARCHAR(20),
    vehiculo VARCHAR(100),
    matricula VARCHAR(50)
);

CREATE TABLE contratos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    propiedad_id INT,
    inquilino_id INT,
    fecha_inicio DATE,
    fecha_fin DATE,
    importe DECIMAL(10, 2),
    garantia VARCHAR(100),
    corredor VARCHAR(100),
    estado ENUM('activo', 'finalizado'),
    -- FOREIGN KEY (inquilino_id) REFERENCES inquilinos(id),
    -- FOREIGN KEY (propiedad_id) REFERENCES propiedades(id)
);

CREATE TABLE pagos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contrato_id INT,
    mes INT,
    anio INT,
    pagado BOOLEAN,
    fecha DATE NOT NULL DEFAULT CURRENT_TIMESTAMP, 
    importe DECIMAL(10,0) NOT NULL,
    comentario VARCHAR(250) NOT NULL, 
    comprobante TEXT NULL;
    -- FOREIGN KEY (contrato_id) REFERENCES contratos(id)
);

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol ENUM('admin', 'usuario_normal')
);

CREATE TABLE propietarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL
);

INSERT INTO propietarios (nombre) VALUES
('Raul Pérez (de todos)'),
('A Medias (Raúl y Todos)'),
('Luis Pérez'),
('Viviana Pérez'),
('Cristina Di Candia');

-- Agregar columna para almacenar el ID del usuario que creó la propiedad
ALTER TABLE propiedades
ADD COLUMN usuario_id INT NOT NULL AFTER comentarios;
-- Agregar columna para almacenar la fecha y hora de creación
ALTER TABLE propiedades
ADD COLUMN fecha_creacion DATETIME NULL AFTER usuario_id;
-- Agregar columna para almacenar la fecha y hora de última modificación
ALTER TABLE propiedades
ADD COLUMN fecha_modificacion DATETIME NULL AFTER fecha_creacion;
-- Opcional: agregar índice para la columna usuario_id para mejora en consultas
CREATE INDEX idx_usuario_id ON propiedades (usuario_id);


ALTER TABLE `inquilinos` ADD `documentos` TEXT NOT NULL AFTER `matricula`, ADD `usuario_id` INT(11) NOT NULL AFTER `documentos`, ADD `fecha_creacion` DATETIME NULL DEFAULT NULL AFTER `usuario_id`, ADD `fecha_modificacion` DATETIME NULL DEFAULT NULL AFTER `fecha_creacion`;



ALTER TABLE inquilinos
ADD COLUMN usuario_id INT NOT NULL AFTER matricula,
ADD COLUMN fecha_creacion DATETIME NULL AFTER usuario_id,
ADD COLUMN fecha_modificacion DATETIME NULL AFTER fecha_creacion;

CREATE INDEX idx_usuario_id ON inquilinos (usuario_id);


ALTER TABLE contratos
ADD COLUMN documentos TEXT NULL AFTER estado;

ALTER TABLE contratos
ADD COLUMN usuario_id INT NOT NULL AFTER documentos,
ADD COLUMN fecha_creacion DATETIME NULL AFTER usuario_id,
ADD COLUMN fecha_modificacion DATETIME NULL AFTER fecha_creacion;

ALTER TABLE pagos
ADD COLUMN periodo VARCHAR(7) NOT NULL AFTER contrato_id;

ALTER TABLE pagos
ADD COLUMN concepto VARCHAR(50) NOT NULL AFTER fecha_recibido;

ALTER TABLE pagos
ADD COLUMN fecha DATE NOT NULL AFTER periodo;


ALTER TABLE propiedades
ADD COLUMN ose VARCHAR(100) DEFAULT NULL,
ADD COLUMN ute VARCHAR(100) DEFAULT NULL,
ADD COLUMN padron VARCHAR(100) DEFAULT NULL,
ADD COLUMN imm_tasa_general VARCHAR(100) DEFAULT NULL,
ADD COLUMN imm_tarifa_saneamiento VARCHAR(100) DEFAULT NULL,
ADD COLUMN imm_instalaciones VARCHAR(100) DEFAULT NULL,
ADD COLUMN imm_adicional_mercantil VARCHAR(100) DEFAULT NULL,
ADD COLUMN convenios VARCHAR(100) DEFAULT NULL
AFTER contribucion_inmobiliaria;


ALTER TABLE pagos ADD COLUMN tipo_pago ENUM('Efectivo', 'Transferencia') NULL AFTER concepto;

-- ALTER TABLE propiedades ADD CONSTRAINT fk_propietario FOREIGN KEY (propietario_id) REFERENCES propietarios(id);

ALTER TABLE propiedades ADD COLUMN propietario_id INT NULL AFTER estado;

ALTER TABLE propiedades ADD COLUMN usuario_id INT NOT NULL AFTER propietario_id;

ALTER TABLE propiedades ADD COLUMN fecha_creacion DATETIME NULL AFTER usuario_id;

ALTER TABLE propiedades ADD COLUMN fecha_modificacion DATETIME NULL AFTER fecha_creacion;

-- Agregar usuario_id y fecha_creacion a la tabla pagos
ALTER TABLE pagos ADD COLUMN usuario_id INT NULL AFTER contrato_id;
ALTER TABLE pagos ADD COLUMN fecha_creacion DATETIME NULL AFTER fecha;

-- Agregar campo email a la tabla inquilinos
ALTER TABLE inquilinos ADD COLUMN email VARCHAR(500) NOT NULL AFTER telefono;

-- Agregar campo email a la tabla propietarios
ALTER TABLE propietarios ADD COLUMN email VARCHAR(500) NOT NULL AFTER nombre;


