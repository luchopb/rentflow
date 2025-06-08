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
    garantia VARCHAR(100),
    corredor VARCHAR(100),
    anep VARCHAR(100),
    contribucion_inmobiliaria VARCHAR(100),
    comentarios TEXT,
    imagenes TEXT,
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
    estado ENUM('activo', 'finalizado'),
    FOREIGN KEY (inquilino_id) REFERENCES inquilinos(id),
    FOREIGN KEY (propiedad_id) REFERENCES propiedades(id)
);

CREATE TABLE pagos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contrato_id INT,
    mes INT,
    anio INT,
    pagado BOOLEAN,
    FOREIGN KEY (contrato_id) REFERENCES contratos(id)
);

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol ENUM('admin', 'usuario_normal')
);