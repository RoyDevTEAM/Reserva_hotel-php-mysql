-- Creación de la base de datos
CREATE DATABASE IF NOT EXISTS hotel_dba;
USE hotel_dba;

-- Creación de la tabla de Usuarios
CREATE TABLE IF NOT EXISTS Usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    apellido VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    telefono VARCHAR(15),
    direccion VARCHAR(255),
    tipo_usuario ENUM('cliente', 'empleado', 'admin') NOT NULL,
    contraseña VARCHAR(255) NOT NULL
);

-- Creación de la tabla de Habitaciones
CREATE TABLE IF NOT EXISTS Habitaciones (
    id_habitacion INT AUTO_INCREMENT PRIMARY KEY,
    numero VARCHAR(50) NOT NULL UNIQUE,
    tipo_habitacion VARCHAR(100) NOT NULL,
    descripcion VARCHAR(255) NOT NULL,
    capacidad INT DEFAULT 2,
    precio_noche DECIMAL(10, 2) NOT NULL,
    estado VARCHAR(50) NOT NULL  -- Ejemplos de estados: 'disponible', 'ocupada', 'limpieza', 'mantenimiento'
);

-- Creación de la tabla de Reservas
CREATE TABLE IF NOT EXISTS Reservas (
    id_reserva INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    id_habitacion INT,
    fecha_entrada DATE NOT NULL,
    fecha_salida DATE NOT NULL,
    costo_total DECIMAL(10, 2) NOT NULL,
    estado_reserva VARCHAR(100) NOT NULL DEFAULT 'pendiente', -- Ejemplos de estados: 'pendiente', 'confirmada', 'cancelada', 'completada'
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario),
    FOREIGN KEY (id_habitacion) REFERENCES Habitaciones(id_habitacion)
);

-- Creación de la tabla de Servicios
CREATE TABLE IF NOT EXISTS Servicios (
    id_servicio INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    descripcion VARCHAR(255),
    precio DECIMAL(10, 2)
);
-- Creación de la tabla de Reserva_Servicios
CREATE TABLE IF NOT EXISTS Reserva_Servicios (
    id_reserva_servicio INT AUTO_INCREMENT PRIMARY KEY,
    id_reserva INT,
    id_servicio INT,
    FOREIGN KEY (id_reserva) REFERENCES Reservas(id_reserva),
    FOREIGN KEY (id_servicio) REFERENCES Servicios(id_servicio)
);

-- Creación de la tabla de Pagos
CREATE TABLE IF NOT EXISTS Pagos (
    id_pago INT AUTO_INCREMENT PRIMARY KEY,
    id_reserva INT,
    fecha_pago DATE NOT NULL,
    monto DECIMAL(10, 2) NOT NULL,
    metodo_pago ENUM('efectivo', 'qr', 'transferencia') NOT NULL,
    estado_pago VARCHAR(100) NOT NULL DEFAULT 'pendiente', -- Ejemplos de estados: 'pendiente', 'completado', 'rechazado'
    FOREIGN KEY (id_reserva) REFERENCES Reservas(id_reserva)
);

-- Insertar datos de ejemplo en la tabla de Usuarios
INSERT INTO Usuarios (nombre, apellido, email, telefono, direccion, tipo_usuario, contraseña) VALUES
('Juan', 'Pérez', 'juan.perez@example.com', '555-0101', '123 Calle Falsa', 'cliente', 'juan123'),
('Ana', 'López', 'ana.lopez@example.com', '555-0202', '456 Calle Real', 'cliente', 'ana456'),
('Carlos', 'García', 'carlos.garcia@example.com', '555-0303', '789 Avenida Principal', 'empleado', 'carlos789'),
('Lucia', 'Martínez', 'lucia.martinez@example.com', '555-0404', '321 Camino Largo', 'cliente', 'lucia321'),
('Miguel', 'Fernandez', 'miguel.fernandez@example.com', '555-0505', '654 Calle Secundaria', 'empleado', 'miguel654');

-- Insertar datos de ejemplo en la tabla de Habitaciones
INSERT INTO Habitaciones (numero, tipo_habitacion, descripcion, capacidad, precio_noche, estado) VALUES
('101', 'Estándar', 'Habitación simple con 1 cama doble', 2, 50.00, 'disponible'),
('102', 'Doble', 'Habitación doble con 2 camas individuales', 2, 75.00, 'ocupada'),
('103', 'Suite', 'Suite con jacuzzi y vista al mar', 2, 150.00, 'disponible'),
('104', 'Familiar', 'Habitación grande con múltiples camas para familias', 4, 100.00, 'limpieza'),
('105', 'Estándar', 'Habitación simple con 1 cama doble', 2, 50.00, 'mantenimiento');

-- Insertar datos de ejemplo en la tabla de Reservas
INSERT INTO Reservas (id_usuario, id_habitacion, fecha_entrada, fecha_salida, costo_total, estado_reserva) VALUES
(1, 1, '2023-05-01', '2023-05-03', 100.00, 'confirmada'),
(2, 3, '2023-05-02', '2023-05-04', 300.00, 'pendiente'),
(4, 2, '2023-05-05', '2023-05-07', 150.00, 'cancelada'),
(1, 4, '2023-05-10', '2023-05-12', 200.00, 'completada'),
(3, 5, '2023-05-15', '2023-05-17', 100.00, 'pendiente');

-- Insertar datos de ejemplo en la tabla de Servicios
INSERT INTO Servicios (nombre, descripcion, precio) VALUES
('Desayuno', 'Desayuno continental incluido', 10.00),
('Gimnasio', 'Acceso al gimnasio 24 horas', 15.00),
('Spa', 'Servicios de spa y masajes', 40.00),
('Parqueadero', 'Parqueadero exclusivo para huéspedes', 5.00),
('Lavandería', 'Servicio de lavandería diario', 20.00);

-- Insertar datos de ejemplo en la tabla de Pagos
INSERT INTO Pagos (id_reserva, fecha_pago, monto, metodo_pago, estado_pago) VALUES
(1, '2023-05-01', 100.00, 'efectivo', 'completado'),
(2, '2023-05-02', 300.00, 'qr', 'pendiente'),
(4, '2023-05-05', 150.00, 'transferencia', 'rechazado'),
(1, '2023-05-10', 200.00, 'efectivo', 'completado'),
(3, '2023-05-15', 100.00, 'transferencia', 'pendiente');
