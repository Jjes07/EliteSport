# EliteSport

Plataforma de e-commerce deportivo desarrollada con Laravel 12.

## Requisitos Previos

- PHP >= 8.2
- Composer
- XAMPP (Apache y MySQL)

---

## Instalación Rápida

1. **Instalar dependencias:**
```bash
composer install
```

2. **Configurar el proyecto:**
```bash
cp .env.example .env
php artisan key:generate
```

3. **Configurar base de datos en `.env`:**
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=elitesport
DB_USERNAME=root
DB_PASSWORD=
```

4. **Crear e importar base de datos:**
   - Abre phpMyAdmin en `http://localhost/phpmyadmin`
   - Crea la base de datos `elitesport`
   - Ve a "Importar" y selecciona el archivo que se encuentra en la ruta `database/sql/delivery1.sql` del proyecto
   - Selecciona "SQL tradicional" y haz clic en "Importar"

## Ejecutar el Proyecto

**Servidor Laravel:**
```bash
php artisan serve
```
Accede a `http://localhost:8000`

## Rutas Principales

### Públicas
- `GET /` - Página de inicio
- `GET /products/{id}/show` - Ver producto
- `GET /products/search` - Buscar productos
- `GET /products/{productId}/reviews` - Listar reseñas
- `GET /products/{productId}/reviews/{reviewId}` - Ver reseña
- `GET|POST /login` - Iniciar sesión
- `GET|POST /register` - Registrarse
- `POST /logout` - Cerrar sesión

### Carrito (Autenticado)
- `GET /cart` - Ver carrito
- `POST /cart/add/{id}` - Agregar al carrito
- `PUT /cart/update/{id}` - Actualizar cantidad
- `DELETE /cart/remove/{id}` - Eliminar del carrito
- `DELETE /cart/clear` - Vaciar carrito
- `POST /cart/checkout` - Proceder al checkout

### Reseñas (Autenticado)
- `GET /products/{productId}/reviews/create` - Formulario crear reseña
- `POST /products/{productId}/reviews` - Guardar reseña
- `GET /products/{productId}/reviews/{reviewId}/edit` - Editar reseña
- `PUT /products/{productId}/reviews/{reviewId}` - Actualizar reseña
- `DELETE /products/{productId}/reviews/{reviewId}` - Eliminar reseña

### Órdenes (Autenticado)
- `GET /orders` - Listar mis órdenes
- `GET /orders/{id}` - Ver detalles de orden
- `POST /orders` - Crear orden
- `PUT /orders/{id}/cancel` - Cancelar orden
- `GET /orders/{id}/invoice` - Descargar factura PDF

### Pagos (Autenticado)
- `GET /payment/{orderId}/create` - Formulario de pago
- `POST /payment/{orderId}` - Procesar pago
- `GET /payment/{orderId}/success` - Confirmación de pago

### Panel Admin (requiere middleware admin)

**Categorías:**
- `GET /categories/create` - Crear categoría
- `POST /categories/save` - Guardar categoría

**Productos:**
- `GET /products` - Listar productos
- `GET /products/create` - Crear producto
- `POST /products/save` - Guardar producto
- `GET /products/{id}/edit` - Editar producto
- `PUT /products/{id}` - Actualizar producto
- `DELETE /products/{id}` - Eliminar producto

**Usuarios:**
- `GET /users` - Listar usuarios
- `GET /users/create` - Crear usuario
- `POST /users/save` - Guardar usuario
- `GET /users/{id}` - Ver usuario
- `GET /users/{id}/edit` - Editar usuario
- `PUT /users/{id}` - Actualizar usuario
- `DELETE /users/{id}` - Eliminar usuario
