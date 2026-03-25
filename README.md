# EliteSport

Plataforma de comercio electrónico desarrollada con Laravel para la venta de productos deportivos. Los usuarios pueden explorar productos, escribir reseñas, agregar items al carrito y realizar compras utilizando su saldo virtual.

## Requisitos Previos

- **XAMPP** (Apache + MySQL) instalado y corriendo
- **PHP >= 8.2** (compatible con la versión de XAMPP)
- **Composer** instalado globalmente
- **Node.js** (opcional, para assets)

## Instalación

### 1. Clonar el repositorio

```bash
git clone https://github.com/Jjes07/EliteSport.git
cd EliteSport
```

### 2. Instalar Dependencias

```bash
composer install
```

### 3. Configurar el archivo de entorno

```bash
cp .env.example .env
```

### 4. Generar la clave de aplicación

```bash
php artisan key:generate
```

### 5. Ejecutar migraciones

```bash
php artisan migrate
```
### 6. Configurar idioma

Para cambiar el idioma de la aplicación, modifica en tu archivo .env:
```bash
APP_LOCALE=es    # Para español
```
```bash
APP_LOCALE=en    # Para inglés
```

### 7. Ejecutar aplicación

```bash
php artisan serve
```

## Crear manualmente un usuario Administrador

Para acceder al panel de administración, necesitas un usuario con rol admin. Puedes crearlo desde la terminal:
```bash
php artisan tinker
```
En esta shell puedes crear un usuario manualmente:
```bash
$user = new App\Models\User();
$user->setName('NombreDeTuAdministrador');
$user->setEmail('admin@example.com');
$user->setPassword('ContraseñaDelAdmin');
$user->setAddress('Calle Principal 123');
$user->setPhone('31234567890');
$user->setRole('admin');
$user->setBudget(1000000);
$user->save();
exit;
```

## Estructura del Proyecto

| Carpeta | Descripción |
|---------|-------------|
| `app/Models/` | Modelos de datos (Product, Order, Item, Review, Payment, Category) |
| `app/Http/Controllers/` | Controladores de la aplicación |
| `app/Http/Requests/` | Validaciones de formularios |
| `resources/views/` | Vistas Blade |
| `database/migrations/` | Migraciones de base de datos |
| `lang/` | Archivos de traducción (es/en) |
| `routes/web.php` | Definición de rutas |

## Rutas Principales

| Ruta | Descripción |
|------|-------------|
| `/` | Página principal - Lista de productos |
| `/products/{id}/show` | Detalle de un producto |
| `/cart` | Ver carrito de compras |
| `/orders` | Historial de órdenes del usuario |
| `/orders/{id}` | Detalle de una orden |
| `/products/{productId}/reviews` | Ver reseñas de un producto |
| `/products` | Lista de productos (admin) |
| `/products/create` | Crear producto (admin) |
| `/users` | Lista de usuarios (admin) |

## Roles de Usuario

| Rol | Permisos |
|-----|----------|
| **admin** | Crear/editar/eliminar productos y usuarios |
| **customer** | Comprar productos, escribir reseñas, ver historial de órdenes |

## Funcionalidades

### Usuarios
- Registro e inicio de sesión
- Ver saldo disponible en el perfil
- Historial de órdenes de compra

### Productos
- Catálogo de productos deportivos
- Búsqueda por nombre
- Filtrado por categoría
- Visualización de detalles

### Carrito de Compras
- Agregar productos al carrito
- Modificar cantidades
- Eliminar productos individualmente
- Vaciar carrito completo

### Órdenes y Pagos
- Creación de orden a partir del carrito
- Sistema de pago con saldo virtual
- Descuento automático del saldo y stock
- Confirmación de compra exitosa

### Reseñas
- Escribir reseñas para productos
- Calificar con estrellas (1-5)
- Editar y eliminar reseñas propias
- Filtrado de reseñas por calificación (múltiples estrellas a la vez)

### Internacionalización
- Soporte para español e inglés
- Archivos de traducción en `lang/es/` y `lang/en/`

