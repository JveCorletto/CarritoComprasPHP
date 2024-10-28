DROP DATABASE IF EXISTS CarritoCompras;

CREATE DATABASE CarritoCompras;

USE CarritoCompras;

CREATE TABLE Estados(
    IdEstado INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    Estado VARCHAR(255) NOT NULL
);

INSERT INTO Estados (Estado)
VALUES 	('Activo'),
        ('Inactivo');

CREATE TABLE Roles (
    IdRol INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    IdEstado INT NOT NULL,
    Rol VARCHAR(255) NOT NULL,
    CONSTRAINT FK_Roles_Estados FOREIGN KEY (IdEstado) REFERENCES Estados(IdEstado)
);

INSERT INTO Roles (IdEstado, Rol)
VALUES 	(1, 'Administrador'),
		(1, 'Empleado'),
        (1, 'Usuario');

CREATE TABLE Usuarios(
     IdUsuario BIGINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
     IdEstado INT NOT NULL,
     IdRol INT NOT NULL,
     Nombre VARCHAR(255) NOT NULL,
     Usuario VARCHAR(255) NOT NULL,
     Contrasenia VARCHAR(255) NOT NULL,

     CONSTRAINT FK_Usuarios_Estados FOREIGN KEY (IdEstado) REFERENCES Estados(IdEstado),
     CONSTRAINT FK_Usuarios_Roles FOREIGN KEY (IdRol) REFERENCES Roles(IdRol)
);

INSERT INTO Usuarios (IdEstado, IdRol, Nombre, Usuario, Contrasenia)
VALUES 	(1, 1, 'Javier', 'Javier', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4'),
        (1, 2, 'Andre', 'Andre', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4');

CREATE TABLE Categorias(
    IdCategoria INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    Categoria VARCHAR(255) NOT NULL
);

INSERT INTO Categorias(Categoria)
VALUES  ('Ropa'),
        ('Zapatos'),
        ('Electrodomésticos');

CREATE TABLE Productos(
    IdProducto BIGINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    IdCategoria INT NOT NULL,
    Producto VARCHAR(255) NOT NULL,
    Descripcion VARCHAR(255) NOT NULL,
    Imagen VARCHAR(255) NULL,
    Precio DOUBLE(14,2) NOT NULL,
    Stock INT NOT NULL,

    -- CAMPOS DE AUDITORIA
    UsuarioCreacion VARCHAR(255) NOT NULL,
    FechaCreacion DATE NOT NULL,
    UsuarioModificacion VARCHAR(255) NULL,
    FechaModificacion DATE NULL,

    CONSTRAINT FK_Productos_Categorias FOREIGN KEY (IdCategoria) REFERENCES Categorias(IdCategoria)
);

CREATE TABLE EstadosCompras (
    IdEstadoCompra INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    EstadoCompra VARCHAR(255) NOT NULL
);

INSERT INTO EstadosCompras(EstadoCompra)
VALUES  ('Pendiente de pago'),
        ('Pagada');

CREATE TABLE Compras(
    IdCompra BIGINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    IdEstadoCompra INT NOT NULL,
    IdComprobante BIGINT NULL,
    IdUsuario BIGINT NOT NULL,

    FechaCompra DATE NOT NULL,
    TotalCompra DOUBLE(14,2) NULL,

    CONSTRAINT FK_Compras_EstadosCompras FOREIGN KEY (IdEstadoCompra) REFERENCES EstadosCompras(IdEstadoCompra),
    CONSTRAINT FK_Compras_Usuarios FOREIGN KEY (IdUsuario) REFERENCES Usuarios(IdUsuario)
);

CREATE TABLE DetallesCompras(
    IdDetalleCompra BIGINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    IdCompra BIGINT NOT NULL,
    IdProducto BIGINT NOT NULL,
    Cantidad INT NOT NULL,
    PrecioUnitario DOUBLE(14,2) NOT NULL,
    SubTotal DOUBLE(14,2) NOT NULL,

    CONSTRAINT FK_DetallesCompras_Compras FOREIGN KEY (IdCompra) REFERENCES Compras(IdCompra),
    CONSTRAINT FK_DetallesCompras_Productos FOREIGN KEY (IdProducto) REFERENCES Productos(IdProducto)
);

CREATE TABLE ComprobantesCompras(
    IdComprobante BIGINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    OrdenCompra VARCHAR(255) NOT NULL,
    TokenPago VARCHAR(255) NOT NULL,
    LinkComprobante VARCHAR(500) NOT NULL,
    FechaTransaccion DATETIME NOT NULL
);