-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-11-2024 a las 16:25:11
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
-- Base de datos: `bdcarritocompras`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `idcompra` bigint(20) NOT NULL,
  `cofecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `idusuario` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compraestado`
--

CREATE TABLE `compraestado` (
  `idcompraestado` bigint(20) UNSIGNED NOT NULL,
  `idcompra` bigint(11) NOT NULL,
  `idcompraestadotipo` int(11) NOT NULL,
  `cefechaini` timestamp NOT NULL DEFAULT current_timestamp(),
  `cefechafin` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compraestadotipo`
--

CREATE TABLE `compraestadotipo` (
  `idcompraestadotipo` int(11) NOT NULL,
  `cetdescripcion` varchar(50) NOT NULL,
  `cetdetalle` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `compraestadotipo`
--

INSERT INTO `compraestadotipo` (`idcompraestadotipo`, `cetdescripcion`, `cetdetalle`) VALUES
(1, 'iniciada', 'cuando el usuario : cliente inicia la compra de uno o mas productos del carrito'),
(2, 'aceptada', 'cuando el usuario administrador da ingreso a uno de las compras en estado = 1 '),
(3, 'enviada', 'cuando el usuario administrador envia a uno de las compras en estado =2 '),
(4, 'cancelada', 'un usuario administrador podra cancelar una compra en cualquier estado y un usuario cliente solo en estado=1 ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compraitem`
--

CREATE TABLE `compraitem` (
  `idcompraitem` bigint(20) UNSIGNED NOT NULL,
  `idproducto` bigint(20) NOT NULL,
  `idcompra` bigint(20) NOT NULL,
  `cicantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE `menu` (
  `idmenu` bigint(20) NOT NULL,
  `menombre` varchar(50) NOT NULL COMMENT 'Nombre del item del menu',
  `medescripcion` varchar(124) NOT NULL COMMENT 'Descripcion mas detallada del item del menu',
  `idpadre` bigint(20) DEFAULT NULL COMMENT 'Referencia al id del menu que es subitem',
  `medeshabilitado` timestamp NULL DEFAULT current_timestamp() COMMENT 'Fecha en la que el menu fue deshabilitado por ultima vez',
  `meorden` int(11) NOT NULL DEFAULT 0,
  `roles` varchar(50) DEFAULT NULL COMMENT 'Roles que pueden acceder al menú',
  `link` varchar(150) NOT NULL COMMENT 'Enlace al que redirige el menú'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`idmenu`, `menombre`, `medescripcion`, `idpadre`, `medeshabilitado`, `meorden`, `roles`, `link`) VALUES
(1, 'Inicio', 'Página principal de la tienda', NULL, NULL, 1, NULL, '/'),
(2, 'Productos', 'Listado de productos disponibles en la tienda', NULL, NULL, 2, NULL, '/productos'),
(3, 'Contacto', 'Información de contacto de la tienda', NULL, NULL, 8, NULL, '/contacto'),
(4, 'Login', 'Acceso a la parte privada del sitio', NULL, NULL, 5, NULL, '/login'),
(5, 'Cervezas', 'Listado de cervezas disponibles', 2, NULL, 1, NULL, '/productos'),
(6, 'Vinos', 'Listado de vinos disponibles', 2, NULL, 2, NULL, '/productos'),
(7, 'Administración', 'Opciones para la administración del sistema', NULL, NULL, 3, 'Administrador', '/admin'),
(8, 'Administración Usuarios', 'Opciones para la administración de Usuarios', 7, NULL, 1, 'Administrador', '/admin/usuarios'),
(9, 'Administración Roles', 'Opciones para la administración de Roles', 7, NULL, 2, 'Administrador', '/admin/roles'),
(10, 'Control Stock', 'Administra inventarios', NULL, NULL, 4, 'Administrador, Deposito', '/app/view/pages/store/gestionProducto.php'),
(11, 'Administración de Productos', 'Opciones para la administración de Productos', 10, NULL, 1, 'Administrador, Deposito', '/deposito/productos'),
(12, 'Administración de Compras', 'Opciones para la administración de Compras', 10, NULL, 2, 'Administrador, Deposito', '/deposito/compras'),
(13, 'Tus Compras', 'Ve lo que has comprado', NULL, NULL, 6, 'Cliente', '/cliente'),
(14, 'Carrito', 'Administra tu carrito', 13, NULL, 1, 'Cliente', '/cliente'),
(15, 'Perfil', 'Administra tu perfil', NULL, NULL, 7, 'Administrador, Deposito, Cliente', '/admin/usuarios'),
(16, 'Todos', 'Todos los productos', 2, NULL, 3, NULL, '/productos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menurol`
--

CREATE TABLE `menurol` (
  `idmenu` bigint(20) NOT NULL,
  `idrol` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `idproducto` bigint(20) NOT NULL,
  `pronombre` varchar(100) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `prodetalle` varchar(512) NOT NULL,
  `procantstock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`idproducto`, `pronombre`, `precio`, `prodetalle`, `procantstock`) VALUES
(1, 'Cerveza Artesanal', 300.00, 'Cerveza tipo IPA con 5% de alcohol', 50),
(2, 'Vino Malbec', 1200.00, 'Vino tinto de Mendoza, cosecha 2020', 30),
(3, 'Whisky Escocés', 4500.00, 'Whisky añejo de 12 años', 15),
(4, 'Ron Oscuro', 2100.00, 'Ron añejado en barricas de roble', 25),
(5, 'Tequila Blanco', 1700.00, 'Tequila premium, 100% agave', 20),
(6, 'Vodka Premium', 1300.00, 'Vodka ruso destilado 5 veces', 40),
(7, 'Champagne Brut', 2500.00, 'Espumante francés, 12% alcohol', 10),
(8, 'Licor de Café', 900.00, 'Licor artesanal con esencia de café', 60),
(9, 'Ginebra London Dry', 1900.00, 'Ginebra clásica, 40% alcohol', 35),
(10, 'Sidra de Manzana', 400.00, 'Sidra natural de manzana, 4% alcohol', 50),
(11, 'Mezcal Artesanal', 2200.00, 'Mezcal con toque ahumado, 100% agave', 18),
(12, 'Vermouth Rojo', 800.00, 'Vermouth italiano, ideal para aperitivos', 45),
(13, 'Brandy Español', 3000.00, 'Brandy añejo con notas de caramelo', 12),
(14, 'Absenta Verde', 2700.00, 'Absenta destilada con hierbas', 8),
(15, 'Cerveza Lager', 250.00, 'Cerveza ligera, 4.5% alcohol', 80),
(16, 'Whisky Bourbon', 3800.00, 'Bourbon estadounidense de Kentucky', 20),
(17, 'Sake Japonés', 1500.00, 'Bebida tradicional japonesa, 15% alcohol', 25),
(18, 'Aguardiente Colombiano', 1200.00, 'Aguardiente de anís, 29% alcohol', 40),
(19, 'Vino Chardonnay', 1300.00, 'Vino blanco argentino, cosecha 2021', 35),
(20, 'Espumante Rosado', 2100.00, 'Vino espumante rosado con burbujas finas', 22);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `idrol` bigint(20) NOT NULL,
  `rodescripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`idrol`, `rodescripcion`) VALUES
(1, 'Administrador'),
(2, 'Cliente'),
(3, 'Deposito');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` bigint(20) NOT NULL,
  `usnombre` varchar(50) NOT NULL,
  `uspass` varchar(64) DEFAULT NULL,
  `usmail` varchar(50) NOT NULL,
  `usdeshabilitado` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `usnombre`, `uspass`, `usmail`, `usdeshabilitado`) VALUES
(11, 'Brisa Celayes', 'c3d2b5bb0c9922b4d6c2ae246bba453b3f23cefbecf0e575c1cd451ea1c34f7c', 'brisa.celayes@gmail.com', '2024-11-17 17:32:17'),
(12, 'Rodrigo', '67ef8a3aa0aa0e5d5af58c35e5635ec792036e2682cd5d02d7ac293471371a40', 'carlos.velo@est.fi.uncoma.edu.ar', '2024-11-17 17:34:14'),
(30, 'fea', '750c745e158aa59c866146f83a474d73c552b02e2ea7cee4104597ae07460471', 'feaaa@', '2024-11-18 05:44:39'),
(31, 'Vi', 'ebfa04d72dd9bd8127f7da2f4baf183f983afeaae74b7837da90ab59e4523fdc', 'warwi@ckCapo', '2024-11-18 05:53:15'),
(32, 'Heimerdinger', '66e8f8112d2d9514bb1f8fc52188b1ca904149beef2b68d6a5f3dae0a489ac18', 'hextech@piltover.zaun', NULL),
(33, 'Soraka', '4927fbe3c4c0d9c5286c6faa195936e5f80b50b8960c115d37892c263771dfef', 'banana', NULL),
(34, 'Ciro', '6a006519d3c227afe7de0af631c74bc592ebae81943c12cdfdb5e7a6f7f94a3a', 'persas', NULL),
(40, 'AAAAAAAAA', '45682', 'brisa.celayes@gmail.com', NULL),
(41, 'Catecupecu', '1234', 'machu@d', NULL),
(42, 'pity', '391d27d55456cb75708dafd023bd8bdda473212a8835c95693e09006512fdef5', 'intoxicados@a', NULL),
(43, 'Ezreal', '8e2d8aa7fc877dd8fa46a13a65bb0642dd0d2d18dbd0e6207909506e6a5e1c34', 'littlebitch@lool', NULL),
(44, 'Talon', '559c1a8ec81de9a3ff7305a54bce2b9c46353601ae83219a78d84bef7384bb3f', 'bestoAsesino@aaa', NULL),
(45, 'Itzy', 'b0c4c298a1db382f74224b7e9176ec34833472348d11c8e51f2d434243ce8ee6', 'imaginary@friend', NULL),
(46, 'cocona', 'd059417022c65294c9db75f0e0befe845689922d78a81b10fbac4ce3dd0083d5', 'xg@howl', NULL),
(47, 'probando', '470893d9739a2dff154e5410a2c1d0eef167c5f213084861f1cdefb9630d6b1b', 'probando@probando', NULL),
(48, 'Deposito', '58c468ef36c1b802a48a11034d73cbd008e513e7f00c15dce63c7624f86bc251', 'deposito@aa', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuariorol`
--

CREATE TABLE `usuariorol` (
  `idusuario` bigint(20) NOT NULL,
  `idrol` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `usuariorol`
--

INSERT INTO `usuariorol` (`idusuario`, `idrol`) VALUES
(11, 1),
(11, 2),
(12, 1),
(12, 2),
(30, 1),
(30, 2),
(31, 1),
(31, 2),
(32, 3),
(33, 1),
(33, 2),
(34, 1),
(34, 2),
(40, 1),
(40, 2),
(41, 1),
(41, 2),
(42, 1),
(42, 2),
(43, 1),
(43, 2),
(44, 1),
(44, 2),
(45, 2),
(46, 2),
(47, 2),
(48, 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`idcompra`),
  ADD UNIQUE KEY `idcompra` (`idcompra`),
  ADD KEY `fkcompra_1` (`idusuario`);

--
-- Indices de la tabla `compraestado`
--
ALTER TABLE `compraestado`
  ADD PRIMARY KEY (`idcompraestado`),
  ADD UNIQUE KEY `idcompraestado` (`idcompraestado`),
  ADD KEY `fkcompraestado_1` (`idcompra`),
  ADD KEY `fkcompraestado_2` (`idcompraestadotipo`);

--
-- Indices de la tabla `compraestadotipo`
--
ALTER TABLE `compraestadotipo`
  ADD PRIMARY KEY (`idcompraestadotipo`);

--
-- Indices de la tabla `compraitem`
--
ALTER TABLE `compraitem`
  ADD PRIMARY KEY (`idcompraitem`),
  ADD UNIQUE KEY `idcompraitem` (`idcompraitem`),
  ADD KEY `fkcompraitem_1` (`idcompra`),
  ADD KEY `fkcompraitem_2` (`idproducto`);

--
-- Indices de la tabla `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`idmenu`),
  ADD UNIQUE KEY `idmenu` (`idmenu`),
  ADD KEY `fkmenu_1` (`idpadre`);

--
-- Indices de la tabla `menurol`
--
ALTER TABLE `menurol`
  ADD PRIMARY KEY (`idmenu`,`idrol`),
  ADD KEY `fkmenurol_2` (`idrol`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`idproducto`),
  ADD UNIQUE KEY `idproducto` (`idproducto`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`idrol`),
  ADD UNIQUE KEY `idrol` (`idrol`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`),
  ADD UNIQUE KEY `idusuario` (`idusuario`);

--
-- Indices de la tabla `usuariorol`
--
ALTER TABLE `usuariorol`
  ADD PRIMARY KEY (`idusuario`,`idrol`),
  ADD KEY `idusuario` (`idusuario`),
  ADD KEY `idrol` (`idrol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `idcompra` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `compraestado`
--
ALTER TABLE `compraestado`
  MODIFY `idcompraestado` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `compraitem`
--
ALTER TABLE `compraitem`
  MODIFY `idcompraitem` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `menu`
--
ALTER TABLE `menu`
  MODIFY `idmenu` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `idproducto` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `idrol` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `fkcompra_1` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `compraestado`
--
ALTER TABLE `compraestado`
  ADD CONSTRAINT `fkcompraestado_1` FOREIGN KEY (`idcompra`) REFERENCES `compra` (`idcompra`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fkcompraestado_2` FOREIGN KEY (`idcompraestadotipo`) REFERENCES `compraestadotipo` (`idcompraestadotipo`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `compraitem`
--
ALTER TABLE `compraitem`
  ADD CONSTRAINT `fkcompraitem_1` FOREIGN KEY (`idcompra`) REFERENCES `compra` (`idcompra`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fkcompraitem_2` FOREIGN KEY (`idproducto`) REFERENCES `producto` (`idproducto`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `fkmenu_1` FOREIGN KEY (`idpadre`) REFERENCES `menu` (`idmenu`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `menurol`
--
ALTER TABLE `menurol`
  ADD CONSTRAINT `fkmenurol_1` FOREIGN KEY (`idmenu`) REFERENCES `menu` (`idmenu`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fkmenurol_2` FOREIGN KEY (`idrol`) REFERENCES `rol` (`idrol`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuariorol`
--
ALTER TABLE `usuariorol`
  ADD CONSTRAINT `fkmovimiento_1` FOREIGN KEY (`idrol`) REFERENCES `rol` (`idrol`) ON UPDATE CASCADE,
  ADD CONSTRAINT `usuariorol_ibfk_2` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
