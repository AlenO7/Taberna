-- Base de datos para Sistema de Almacén
CREATE DATABASE SistemaTaberna;
USE SistemaTaberna;

-- drop database sistemataberna;


-- Tabla de Usuarios
CREATE TABLE Usuarios (
    UsuarioID INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(100) NOT NULL,
    Correo VARCHAR(100) NOT NULL UNIQUE,
    Contraseña VARCHAR(255) NOT NULL,
    Rol ENUM('Administrador', 'Vendedor', 'Almacenero') NOT NULL,
    FechaCreacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de Marcas
CREATE TABLE Marcas (
    MarcaID INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(100) NOT NULL UNIQUE,
    Descripcion TEXT,
    FechaCreacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de Productos
CREATE TABLE Productos (
    ProductoID INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(100) NOT NULL,
    Descripcion TEXT,
    Precio DECIMAL(10,2) NOT NULL,
    Stock INT NOT NULL DEFAULT 0,
    MarcaID INT NOT NULL,
    FechaCreacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (MarcaID) REFERENCES Marcas(MarcaID) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Tabla de Ventas
CREATE TABLE Ventas (
    VentaID INT AUTO_INCREMENT PRIMARY KEY,
    UsuarioID INT,
    FechaVenta TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Total DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (UsuarioID) REFERENCES Usuarios(UsuarioID)
    ON DELETE SET NULL
    ON UPDATE CASCADE
) ENGINE = InnoDB;

-- Tabla de Detalles de Ventas
CREATE TABLE DetallesVentas (
    DetalleID INT AUTO_INCREMENT PRIMARY KEY,
    VentaID INT NOT NULL,
    ProductoID INT NOT NULL,
    Cantidad INT NOT NULL,
    PrecioUnitario DECIMAL(10,2) NOT NULL,
    Subtotal DECIMAL(10,2) AS (Cantidad * PrecioUnitario) STORED,
    FOREIGN KEY (VentaID) REFERENCES Ventas(VentaID) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (ProductoID) REFERENCES Productos(ProductoID) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Tabla de Facturas
CREATE TABLE Facturas (
    FacturaID INT AUTO_INCREMENT PRIMARY KEY,
    VentaID INT NOT NULL,
    NumeroFactura VARCHAR(50) NOT NULL UNIQUE,
    FechaEmision TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    MontoTotal DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (VentaID) REFERENCES Ventas(VentaID) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Tabla para Historial de Stock
CREATE TABLE HistorialStock (
    HistorialID INT AUTO_INCREMENT PRIMARY KEY,
    ProductoID INT NOT NULL,
    Movimiento ENUM('Entrada', 'Salida') NOT NULL,
    Cantidad INT NOT NULL,
    FechaMovimiento TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ProductoID) REFERENCES Productos(ProductoID) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Triggers para control de Stock
DELIMITER $$

-- Trigger para reducir el stock en venta
CREATE TRIGGER RestarStock AFTER INSERT ON DetallesVentas
FOR EACH ROW
BEGIN
    UPDATE Productos
    SET Stock = Stock - NEW.Cantidad
    WHERE ProductoID = NEW.ProductoID;

    -- Registrar salida en el historial
    INSERT INTO HistorialStock (ProductoID, Movimiento, Cantidad)
    VALUES (NEW.ProductoID, 'Salida', NEW.Cantidad);
END; $$

-- Trigger para agregar el stock cuando se elimine un detalle de venta
CREATE TRIGGER ReponerStock AFTER DELETE ON DetallesVentas
FOR EACH ROW
BEGIN
    UPDATE Productos
    SET Stock = Stock + OLD.Cantidad
    WHERE ProductoID = OLD.ProductoID;

    -- Registrar entrada en el historial
    INSERT INTO HistorialStock (ProductoID, Movimiento, Cantidad)
    VALUES (OLD.ProductoID, 'Entrada', OLD.Cantidad);
END; $$


DELIMITER ;
INSERT INTO Usuarios (Nombre, Correo, Contraseña, Rol)
VALUES ('Alen', 'alenozacariz7@gmail.com', 'Alen123', 'Administrador');

INSERT INTO Marcas (Nombre)
VALUES ('COCA-COLA');

INSERT INTO Marcas (Nombre)
VALUES ('BRAHAMA');

INSERT INTO Productos (Nombre, Descripcion, Precio, Stock, MarcaID)
VALUES ('Coca-Cola ', 'Coca Cola 2,25ml', 3500, 50, 1);
INSERT INTO Productos (Nombre, Descripcion, Precio, Stock, MarcaID)
VALUES ('Coca-Cola ', 'Coca Cola 1,5ml', 2500, 50, 1);
INSERT INTO Productos (Nombre, Descripcion, Precio, Stock, MarcaID)
VALUES ('Coca-Cola ', 'Coca Cola 500ml', 1200, 50, 1);

INSERT INTO Productos (Nombre, Descripcion, Precio, Stock, MarcaID)
VALUES ('BRAHAMA ', 'BRAHAMA 1L', 3000, 50, 2);



select * from Productos;


