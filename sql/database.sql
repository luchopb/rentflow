-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS rentflow;
USE rentflow;

-- Tabla de propiedades
CREATE TABLE propiedades (
    id INT PRIMARY KEY AUTO_INCREMENT,
    direccion VARCHAR(255) NOT NULL,
    tipo ENUM('Departamento', 'Casa', 'Local') NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    estado ENUM('Disponible', 'Alquilado') NOT NULL DEFAULT 'Disponible',
    caracteristicas TEXT,
    gastos_comunes DECIMAL(10,2) DEFAULT 0.00,
    contribucion_inmobiliaria_cc INT DEFAULT 0,
    contribucion_inmobiliaria_padron INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabla de inquilinos
CREATE TABLE inquilinos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(255) NOT NULL,
    documento VARCHAR(20) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL,
    telefono VARCHAR(20) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabla de contratos
CREATE TABLE contratos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    propiedad_id INT NOT NULL,
    inquilino_id INT NOT NULL,
    fecha_inicio DATE NOT NULL,
    fecha_fin DATE NOT NULL,
    renta_mensual DECIMAL(10,2) NOT NULL,
    estado ENUM('Activo', 'Finalizado', 'Cancelado') NOT NULL DEFAULT 'Activo',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabla de pagos
CREATE TABLE pagos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    contrato_id INT NOT NULL,
    fecha_vencimiento DATE NOT NULL,
    monto DECIMAL(10,2) NOT NULL,
    fecha_pago DATE,
    monto_pagado DECIMAL(10,2),
    estado ENUM('Pendiente', 'Pagado', 'Vencido') NOT NULL DEFAULT 'Pendiente',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Actualizar registros existentes
UPDATE propiedades SET 
    gastos_comunes = 0.00,
    contribucion_inmobiliaria_cc = 0,
    contribucion_inmobiliaria_padron = 0
WHERE gastos_comunes IS NULL 
   OR contribucion_inmobiliaria_cc IS NULL 
   OR contribucion_inmobiliaria_padron IS NULL;

-- Renombrar campo DNI a Documento en la tabla inquilinos
ALTER TABLE inquilinos CHANGE COLUMN dni documento VARCHAR(20) NOT NULL;

-- Convert existing decimal values to integers
UPDATE propiedades SET 
    contribucion_inmobiliaria_cc = CAST(contribucion_inmobiliaria_cc AS UNSIGNED),
    contribucion_inmobiliaria_padron = CAST(contribucion_inmobiliaria_padron AS UNSIGNED); 