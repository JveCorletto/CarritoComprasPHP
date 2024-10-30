# Documentación del Proyecto: Carrito de Compras con PHP e Integración de Pagos con PayPal

Este es un proyecto de Laravel que implementa un sistema de carrito de compras con la funcionalidad de realizar pagos a través de PayPal. Además, incluye la gestión de compras, productos y comprobantes de compra.

## Requisitos

Para ejecutar este proyecto, necesitas tener instalado:

- PHP >= 8.2
- Composer
- MySQL
- Laravel 8 o superior
- Una cuenta de desarrollador de PayPal para obtener las credenciales de API (modo sandbox o producción)

## Instalación

1. **Clona el repositorio**:

   ```bash
   git clone [https://github.com/tu_usuario/tu_proyecto.git](https://github.com/JveCorletto/CarritoComprasPHP.git)
   cd tu_proyecto
   ```

2. **Instala las dependencias del proyecto** usando Composer:

   ```bash
   composer install
   ```

3. **Configura el archivo `.env`**:

   Copia el archivo de ejemplo `.env.example` y renómbralo a `.env`:

   ```bash
   cp .env.example .env
   ```

   Luego, actualiza los siguientes valores:

   - Configuración de la base de datos:
     ```env
     DB_DATABASE=nombre_base_datos
     DB_USERNAME=tu_usuario
     DB_PASSWORD=tu_contraseña
     ```

   - Credenciales de PayPal (debes obtenerlas en https://developer.paypal.com/):
     ```env
     PAYPAL_CLIENT_ID=tu_client_id
     PAYPAL_CLIENT_SECRET=tu_client_secret
     PAYPAL_MODE=sandbox
     ```

4. **Genera la clave de aplicación de Laravel**:

   ```bash
   php artisan key:generate
   ```

5. **Crea la base de datos con el archivo contenido en el repositorio**:

   ```bash
   ~\CarritoCompras_schema_n_data.sql
   ```

6. **Migra la base de datos**:
   Hay tablas que son necesarias para el funcionamiento correcto del sistema que las crea la librería de Blade, crea estas ejecutando las migraciones necesarias.

   ```bash
   php artisan migrate
   ```

6. **Configura el almacenamiento de enlaces simbólicos** (para subir imágenes de productos):

   ```bash
   php artisan storage:link
   ```

7. **Inicia el servidor local de Laravel**:

   ```bash
   php artisan serve
   ```

   El proyecto debería estar corriendo en `http://localhost:8000`.

## Características

- **Carrito de Compras**: Los usuarios pueden agregar productos al carrito y gestionar la cantidad de los productos seleccionados.
- **Procesamiento de pagos con PayPal**: Se integra la API de PayPal para realizar pagos en línea. Al finalizar la compra, se redirige al usuario a PayPal para completar el pago.
- **Gestión de Productos**: El administrador puede agregar, editar y eliminar productos desde el panel de administración.
- **Generación de Comprobantes de Compras**: Al finalizar un pago exitoso, se genera un comprobante que se almacena en la base de datos.
- **Notificaciones**: El sistema muestra mensajes de éxito o error tras completar una acción (compra, agregar productos, etc.).

## Estructura de Base de Datos

### Tabla `compras`

```sql
CREATE TABLE Compras (
    IdCompra BIGINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    IdEstadoCompra INT NOT NULL,
    IdUsuario BIGINT NOT NULL,
    FechaCompra DATETIME NOT NULL,
    TotalCompra DECIMAL(10, 2) NOT NULL,
    IdComprobante BIGINT,
    FOREIGN KEY (IdComprobante) REFERENCES ComprobantesCompras(IdComprobante)
);
```

### Tabla `detalles_compras`

```sql
CREATE TABLE DetallesCompras (
    IdDetalleCompra BIGINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    IdCompra BIGINT NOT NULL,
    IdProducto BIGINT NOT NULL,
    Cantidad INT NOT NULL,
    PrecioUnitario DECIMAL(10, 2) NOT NULL,
    SubTotal DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (IdCompra) REFERENCES Compras(IdCompra),
    FOREIGN KEY (IdProducto) REFERENCES Productos(IdProducto)
);
```

### Tabla `productos`

```sql
CREATE TABLE Productos (
    IdProducto BIGINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    Producto VARCHAR(255) NOT NULL,
    Descripcion TEXT,
    Precio DECIMAL(10, 2) NOT NULL,
    Stock INT NOT NULL,
    Imagen VARCHAR(255)
);
```

### Tabla `comprobantes_compras`

```sql
CREATE TABLE ComprobantesCompras (
    IdComprobante BIGINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    OrdenCompra VARCHAR(255) NOT NULL,
    TokenPago VARCHAR(255) NOT NULL,
    FechaTransaccion DATETIME NOT NULL
);
```

## Rutas Importantes

### Crear Pago con PayPal

**Ruta**: `POST /paypal/crear-pago`

Este método crea una orden de pago en PayPal. Si el carrito no tiene productos, redirige al usuario al dashboard con un mensaje de error. Si se crea el pago correctamente, redirige a PayPal para completar el pago.

### Capturar Pago

**Ruta**: `GET /paypal/capturar-pago`

Este método se utiliza para capturar el pago después de que el usuario haya sido redirigido de PayPal. Si el pago se completa, se guarda la compra en la base de datos y se genera un comprobante de compra.

### Finalizar Compra

**Ruta**: `POST /compras/finalizar`

Este método se ejecuta al capturar el pago. Almacena los detalles de la compra en la base de datos, reduce el stock de los productos y limpia el carrito.

## Créditos

Este proyecto fue desarrollado por [André] y cuenta con integración de la API de PayPal para el procesamiento de pagos.

## Licencia

Este proyecto está bajo la licencia MIT. Consulta el archivo LICENSE para más detalles.

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
