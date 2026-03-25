-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-03-2026 a las 02:52:37
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `delivery1`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Fútbol', 'Productos y accesorios relacionados con la práctica del fútbol, como balones, guayos, canilleras y uniformes.', '2026-03-25 00:16:38', '2026-03-25 00:16:38'),
(2, 'Running', 'Artículos diseñados para correr, incluyendo tenis, camisetas transpirables, licras y accesorios deportivos.', '2026-03-25 00:16:59', '2026-03-25 00:16:59'),
(3, 'Gym', 'Productos para entrenamiento en gimnasio, musculación y acondicionamiento físico, como guantes, bandas, pesas y ropa deportiva.', '2026-03-25 00:17:35', '2026-03-25 00:17:35'),
(4, 'Baloncesto', 'Implementos y ropa para jugar baloncesto, incluyendo balones, zapatillas, camisetas y accesorios.', '2026-03-25 00:17:54', '2026-03-25 00:17:54'),
(5, 'Voleibol', 'Productos orientados a la práctica de voleibol, como balones, rodilleras, uniformes y calzado.', '2026-03-25 00:18:35', '2026-03-25 00:18:35'),
(6, 'Ciclismo', 'Artículos para ciclismo recreativo o profesional, como cascos, guantes, gafas, ropa y accesorios.', '2026-03-25 00:18:50', '2026-03-25 00:18:50'),
(7, 'Natación', 'Productos para actividades acuáticas, incluyendo gafas, trajes de baño, gorros y accesorios de entrenamiento.', '2026-03-25 00:19:03', '2026-03-25 00:19:03'),
(8, 'Accesorios Deportivos', 'Complementos deportivos de uso general, como termos, mochilas, toallas, cronómetros y cintas de entrenamiento.', '2026-03-25 00:19:28', '2026-03-25 00:19:28'),
(9, 'Ropa Deportiva', 'Prendas deportivas para distintas disciplinas, como camisetas, sudaderas, shorts, joggers y chaquetas.', '2026-03-25 00:19:45', '2026-03-25 00:19:45'),
(10, 'Calzado Deportivo', 'Zapatos y tenis deportivos para diferentes actividades, como running, entrenamiento, fútbol y uso casual deportivo.', '2026-03-25 00:20:00', '2026-03-25 00:20:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `items`
--

CREATE TABLE `items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `items`
--

INSERT INTO `items` (`id`, `order_id`, `product_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, 120000, '2026-03-25 00:41:08', '2026-03-25 00:41:08'),
(2, 2, 3, 1, 45000, '2026-03-25 02:43:17', '2026-03-25 02:43:17'),
(3, 3, 9, 3, 110000, '2026-03-25 06:47:02', '2026-03-25 06:47:02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_02_23_124152_create_products_table', 1),
(5, '2026_02_24_000000_create_categories_table', 1),
(6, '2026_03_22_193949_create_reviews_table', 1),
(7, '2026_03_22_200110_add_user_id_and_product_id_to_reviews_table', 1),
(8, '2026_03_23_013317_create_orders_table', 1),
(9, '2026_03_23_013318_create_payments_table', 1),
(10, '2026_03_23_013319_create_items_table', 1),
(11, '2026_03_23_030915_add_budget_to_users_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `total` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `date`, `status`, `total`, `created_at`, `updated_at`) VALUES
(1, 2, '2026-03-24', 'paid', 240000, '2026-03-25 00:41:08', '2026-03-25 00:41:43'),
(2, 2, '2026-03-24', 'cancelled', 45000, '2026-03-25 02:43:17', '2026-03-25 02:43:21'),
(3, 4, '2026-03-25', 'paid', 330000, '2026-03-25 06:47:02', '2026-03-25 06:47:16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `amount` int(11) NOT NULL,
  `method` varchar(255) NOT NULL DEFAULT 'budget',
  `status` varchar(255) NOT NULL DEFAULT 'completed',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `amount`, `method`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 240000, 'budget', 'completed', '2026-03-25 00:41:43', '2026-03-25 00:41:43'),
(2, 3, 330000, 'budget', 'completed', '2026-03-25 06:47:16', '2026-03-25 06:47:16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `stock`, `image`, `created_at`, `updated_at`, `category_id`) VALUES
(1, 'Balón Nike Premier', 'Balón de fútbol resistente, ideal para entrenamientos y partidos recreativos en césped natural o sintético.', 120000, 10, 'https://images.unsplash.com/photo-1517466787929-bc90951d0974', '2026-03-25 00:20:53', '2026-03-25 06:52:12', 1),
(2, 'Guayos Adidas Predator Club', 'Guayos cómodos y ligeros para jugadores que buscan buen agarre y control del balón.', 280000, 8, 'https://images.unsplash.com/photo-1542291026-7eec264c27ff', '2026-03-25 00:22:49', '2026-03-25 00:22:49', 1),
(3, 'Canilleras Pro Shield', 'Canilleras de protección con ajuste ergonómico, ideales para entrenamientos y competencia.', 45000, 20, 'https://images.unsplash.com/photo-1574629810360-7efbbe195018', '2026-03-25 00:24:18', '2026-03-25 00:24:18', 1),
(4, 'Tenis Running Air Motion', 'Tenis Running Air Motion', 320000, 12, 'https://images.unsplash.com/photo-1542291026-7eec264c27ff', '2026-03-25 00:25:13', '2026-03-25 00:25:13', 2),
(5, 'Camiseta DryFit Runner', 'Camiseta transpirable de secado rápido, perfecta para entrenamientos y sesiones de running.', 85000, 18, 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f', '2026-03-25 00:25:57', '2026-03-25 00:25:57', 2),
(6, 'Licra Deportiva Performance', 'Licra ajustada de alta elasticidad para mejorar la movilidad y comodidad durante el ejercicio.', 95000, 10, 'https://images.unsplash.com/photo-1506629905607-d9d6f39a68d0', '2026-03-25 00:26:31', '2026-03-25 00:26:31', 2),
(7, 'Guantes de Gym PowerGrip', 'Guantes acolchados para entrenamiento de fuerza, diseñados para mejorar el agarre y proteger las manos.', 65000, 14, 'https://images.unsplash.com/photo-1517836357463-d25dfeac3438', '2026-03-25 00:28:09', '2026-03-25 00:28:09', 3),
(8, 'Banda Elástica StrongFit', 'Banda de resistencia ideal para ejercicios funcionales, rehabilitación y entrenamiento en casa.', 35000, 10, 'https://images.unsplash.com/photo-1518611012118-696072aa579a', '2026-03-25 00:28:41', '2026-03-25 00:28:41', 3),
(9, 'Mancuerna Hexagonal 10kg', 'Mancuerna de alta durabilidad con recubrimiento resistente, ideal para rutinas de fuerza.', 110000, 13, 'https://images.unsplash.com/photo-1583454110551-21f2fa2afe61', '2026-03-25 00:29:17', '2026-03-25 06:47:16', 3),
(10, 'Balón Spalding Street', 'Balón de baloncesto para uso en exteriores, con excelente agarre y resistencia al desgaste.', 135000, 11, 'https://images.unsplash.com/photo-1546519638-68e109498ffc', '2026-03-25 00:29:49', '2026-03-25 00:29:49', 4),
(11, 'Zapatillas Court Jump', 'Calzado deportivo para baloncesto con soporte lateral y amortiguación reforzada.', 360000, 11, 'https://images.unsplash.com/photo-1514996937319-344454492b37', '2026-03-25 00:30:52', '2026-03-25 00:30:52', 4),
(12, 'Rodilleras Voley Protect', 'Rodilleras acolchadas para voleibol, diseñadas para brindar seguridad y comodidad.', 55000, 13, 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b', '2026-03-25 00:31:31', '2026-03-25 00:31:31', 5),
(13, 'Balón Mikasa Training', 'Balón de voleibol liviano y resistente, ideal para prácticas y competencias recreativas.', 125000, 9, 'https://images.unsplash.com/photo-1612872087720-bb876e2e67d1', '2026-03-25 00:33:08', '2026-03-25 00:33:08', 5),
(14, 'Casco BikeSafe Pro', 'Casco de ciclismo con ventilación avanzada y ajuste de seguridad para trayectos urbanos o deportivos.', 170000, 6, 'https://images.unsplash.com/photo-1558981806-ec527fa84c39', '2026-03-25 00:33:42', '2026-03-25 00:33:42', 6),
(15, 'Guantes Ciclismo RideFlex', 'Guantes ligeros con palma acolchada para mayor comodidad y agarre durante el recorrido.', 70000, 10, 'https://images.unsplash.com/photo-1508609349937-5ec4ae374ebf', '2026-03-25 00:34:17', '2026-03-25 00:34:17', 6),
(16, 'Gafas Natación AquaVision', 'Gafas de natación antivaho con ajuste ergonómico para entrenamiento en piscina.', 48000, 19, 'https://images.unsplash.com/photo-1560090995-01632a28895b', '2026-03-25 00:34:52', '2026-03-25 00:34:52', 7),
(17, 'Gorro de Natación SwimCap', 'Gorro de silicona resistente y cómodo, diseñado para proteger el cabello durante la natación.', 25000, 30, 'https://images.unsplash.com/photo-1438029071396-1e831a7fa6d8', '2026-03-25 00:35:25', '2026-03-25 00:35:25', 7),
(18, 'Termo Deportivo EliteSport', 'Termo reutilizable con diseño ergonómico, ideal para mantener la hidratación durante el entrenamiento.', 40000, 22, 'https://images.unsplash.com/photo-1602143407151-7111542de6e8', '2026-03-25 00:35:55', '2026-03-25 00:35:55', 8),
(19, 'Mochila Sport Training', 'Mochila amplia con compartimentos para ropa, calzado y accesorios deportivos.', 130000, 9, 'https://images.unsplash.com/photo-1542291026-7eec264c27ff', '2026-03-25 00:36:32', '2026-03-25 00:36:32', 8),
(20, 'Sudadera Deportiva Urban Fit', 'Sudadera cómoda y moderna para entrenamiento o uso casual, fabricada en tela suave y resistente.', 150000, 12, 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab', '2026-03-25 00:36:58', '2026-03-25 00:36:58', 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `comment` varchar(255) NOT NULL,
  `rating` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `product_id`, `comment`, `rating`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'Super bueno, la mejor calidad', 5, '2026-03-25 00:39:26', '2026-03-25 00:39:26'),
(2, 3, 1, 'Me fue mal con el producto, se pincho muy rapido', 1, '2026-03-25 00:45:33', '2026-03-25 00:45:33'),
(3, 4, 1, 'Me fue bien con el producto, pero el material se descocio muy rapido', 4, '2026-03-25 06:46:12', '2026-03-25 06:46:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('I2MQEdsEI3hWYi9cYQigZjqFvDtTvUVX5iN4VZO5', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiclQ5bTRGUFhNbHBOUHdtWkVwQjhUZkJNZW5OS21WUkh5eUhIY1lVQyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wcm9kdWN0cy8xL3Nob3ciO3M6NToicm91dGUiO3M6MTI6InByb2R1Y3Quc2hvdyI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czo0OiJhdXRoIjthOjE6e3M6MjE6InBhc3N3b3JkX2NvbmZpcm1lZF9hdCI7aToxNzc0NDAzNTIxO319', 1774403535);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'customer',
  `budget` int(11) NOT NULL DEFAULT 1000000,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `address`, `phone`, `role`, `budget`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Juan', 'juanmagalo0812@gmail.com', NULL, '$2y$12$QsbAZB2lbwQEhFz5rf8.muxsAoJfmAblULUefT0wtcB6Gnu1UGJR6', 'Calle 64 # 40-27', '321 4842344', 'admin', 1000000, 'szDDtAQOsUWzo5ZlIffBmlxJSlTLGQ12sDQMNOcyBeqfwWVlWFFCvPBjFmaH', '2026-03-25 00:13:02', '2026-03-25 00:13:02'),
(2, 'cliente', 'cliente@data.com', NULL, '$2y$12$fM2xWyy.GieaBM2vyAlJGeM.GT/JeIXKcT4uyGt/CJMXj9KASF2z6', 'Calle 60#50 - 60', '32456785', 'customer', 760000, 'DkLHiTWDgUZIOBsdHNlMXMHrTLKW6DSnZLhYSguoV4SLzAPrVEK5HEHMCCwR', '2026-03-25 00:38:31', '2026-03-25 00:41:43'),
(3, 'Cliente2', 'cliente2@datapet.com', NULL, '$2y$12$RJBzqlCKwF09vEqs0b7Mkuc7nMF9CGf.f73s.3bG1Pj2xsE6C.pYu', 'Calle 40#01-02', '324553521', 'customer', 1000000, 'DyO8LbhqusjazPj3pZMNlVgiOFDJEWOMEZM6mhizIn9u0jLUBTj4tk797vAh', '2026-03-25 00:43:49', '2026-03-25 00:43:49'),
(4, 'Cliente3', 'cliente3@datapet.com', NULL, '$2y$12$fwUgtc6Eb0kCFi./Mxu4E.6Ax73JkWA2sq137cuq9wXb49JdBPXCu', 'Calle 50#10 - 10', '43321155', 'customer', 670000, NULL, '2026-03-25 06:45:21', '2026-03-25 06:47:16');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_name_unique` (`name`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `items_order_id_foreign` (`order_id`),
  ADD KEY `items_product_id_foreign` (`product_id`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_order_id_foreign` (`order_id`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indices de la tabla `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`),
  ADD KEY `reviews_product_id_foreign` (`product_id`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `items`
--
ALTER TABLE `items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
