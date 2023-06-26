

--
-- Estructura de tabla para la tabla `zarest_categories`
--

CREATE TABLE `zarest_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `zarest_categories`
--

INSERT INTO `zarest_categories` (`id`, `name`, `created_at`) VALUES
(22, 'ALIMENTOS', '2020-01-16 09:34:56'),
(23, 'BEBIDAS', '2020-01-16 09:35:12'),
(24, 'OTROS SERVICIOS', '2020-01-16 09:42:46'),
(25, 'Temporada Baja', '2020-01-16 12:50:53'),
(26, 'Temporada Media', '2020-01-16 12:51:23'),
(27, 'Temporada Alta', '2020-01-16 12:51:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zarest_categorie_expences`
--

CREATE TABLE `zarest_categorie_expences` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zarest_combo_items`
--

CREATE TABLE `zarest_combo_items` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zarest_customers`
--

CREATE TABLE `zarest_customers` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `numdocu` varchar(20) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `discount` varchar(5) DEFAULT NULL,
  `created_at` varchar(150) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `zarest_customers`
--

INSERT INTO `zarest_customers` (`id`, `name`, `numdocu`, `phone`, `email`, `discount`, `created_at`) VALUES
(11, 'PRUEBA CLIENTE PUNTO VENTA', '39393993', '2397777', 'DKD@DD.COM', NULL, NULL),
(12, 'UNO NUEVO', '50505050', '92929', 'JDD@DD.CO', NULL, NULL),
(13, 'acompa1', '696969', '044039', 'dd@ww.co', NULL, NULL),
(14, 'fulano de tal ', '78907959', '2020', 'fulano@fulano.com ', NULL, NULL),
(15, 'meli manrique ', '707079', '19199', 'luzmaryrg@gmail.com ', NULL, NULL),
(16, 'FULANO DE TAL ', '6070707', '393939', 'dfifi@dd.com ', NULL, NULL),
(17, 'Luz Mary Rodriguez ', '34997618 ', '19199', 'luzmaryrg@gmail.com ', NULL, NULL),
(18, 'Luz Mary Rodriguez ', '34997618 ', '19199', 'luzmaryrg@gmail.com ', NULL, NULL),
(19, 'Luz Mary Rodriguez ', '34997618 ', '19199', 'luzmaryrg@gmail.com ', NULL, NULL),
(20, 'PRUEBA DE UNA VEZ ', '89909090', '59595', 'dld@dd.com ', NULL, NULL),
(21, 'NUEVAMENTE ENTRO UN CLIENTE', '40494994', '40494949', 'EE@22.CO', NULL, NULL),
(22, 'Luz Mary Rodriguez ', '34997618 ', '19199', 'luzmaryrg@gmail.com ', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zarest_expences`
--

CREATE TABLE `zarest_expences` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `reference` varchar(150) NOT NULL,
  `note` text,
  `amount` float NOT NULL,
  `attachment` varchar(200) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `category_id` int(11) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `created_by` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zarest_holds`
--

CREATE TABLE `zarest_holds` (
  `id` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `time` varchar(10) NOT NULL,
  `register_id` int(11) DEFAULT NULL,
  `table_id` int(11) DEFAULT NULL,
  `waiter_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `zarest_holds`
--

INSERT INTO `zarest_holds` (`id`, `number`, `time`, `register_id`, `table_id`, `waiter_id`, `customer_id`) VALUES
(267, 1, '09:40', 60, 44, 0, 0),
(268, 1, '09:41', 60, 47, 0, 0),
(269, 1, '13:09', 60, 46, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zarest_payements`
--

CREATE TABLE `zarest_payements` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `paid` float NOT NULL,
  `paidmethod` varchar(300) NOT NULL,
  `created_by` varchar(60) NOT NULL,
  `register_id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `waiter_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zarest_posales`
--

CREATE TABLE `zarest_posales` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `price` float NOT NULL,
  `qt` int(6) NOT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `register_id` int(11) DEFAULT NULL,
  `number` int(11) DEFAULT NULL,
  `table_id` int(11) DEFAULT NULL,
  `options` text,
  `time` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `zarest_posales`
--

INSERT INTO `zarest_posales` (`id`, `product_id`, `name`, `price`, `qt`, `status`, `register_id`, `number`, `table_id`, `options`, `time`) VALUES
(1548, 155, 'DESAYUNO', 8000, 1, 0, 60, 1, 46, NULL, '2020-01-16 13:28:15'),
(1547, 156, 'Hab. Doble Temporada Baja', 70000, 1, 0, 60, 1, 44, 'Desayuno, Parqueadero,', '2020-01-16 13:20:09'),
(1549, 156, 'Hab. Doble Temporada Baja', 80000, 1, 0, 60, 1, 46, NULL, '2020-01-16 13:28:37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zarest_products`
--

CREATE TABLE `zarest_products` (
  `id` int(11) NOT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(25) NOT NULL,
  `category` varchar(20) NOT NULL,
  `cost` float NOT NULL,
  `tax` varchar(11) DEFAULT NULL,
  `description` mediumtext,
  `price` float NOT NULL,
  `photo` varchar(200) NOT NULL,
  `photothumb` varchar(500) DEFAULT NULL,
  `color` varchar(10) NOT NULL,
  `created_at` varchar(30) DEFAULT NULL,
  `modified_at` varchar(30) DEFAULT NULL,
  `type` tinyint(4) DEFAULT NULL,
  `alertqt` int(10) DEFAULT NULL,
  `supplier` varchar(200) DEFAULT NULL,
  `unit` varchar(100) DEFAULT NULL,
  `taxmethod` tinyint(4) DEFAULT NULL,
  `h_stores` varchar(300) DEFAULT NULL,
  `options` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `zarest_products`
--

INSERT INTO `zarest_products` (`id`, `code`, `name`, `category`, `cost`, `tax`, `description`, `price`, `photo`, `photothumb`, `color`, `created_at`, `modified_at`, `type`, `alertqt`, `supplier`, `unit`, `taxmethod`, `h_stores`, `options`) VALUES
(155, '1', 'DESAYUNO', 'ALIMENTOS', 0, '', '<p>El desayuno viene con huevos al gusto, bebida caliente o bebida fria y pan<br></p>', 8000, '9b72c49bfbd91f3f1ba4510bd596bbc3.jpg', '9b72c49bfbd91f3f1ba4510bd596bbc3_thumb.jpg', 'color02', '2020-01-16 10:04:16', '2020-01-16 10:04:14', 2, 0, 'Proveedor', '', 1, NULL, 'HUEVOS, JUGO NARANJA, CAFE, PAN, AREPA, CHOCOLATE'),
(156, '2', 'Hab. Doble Temporada Baja', 'Temporada Baja', 80000, '19', '<p>Cama Doble</p>', 80000, '', '', 'color03', '2020-01-16 13:21:01', '2020-01-16 13:21:01', 0, 0, 'Proveedor', '', 0, NULL, 'Desayuno, Parqueadero'),
(157, '3', 'Hab Triple Temporada Baja', 'Temporada Baja', 100000, '', '<p>Cama doble y cama auxiliar, Aire acondicionado.</p>', 140000, '', '', 'color04', '2020-01-16 13:08:01', '2020-01-16 13:08:01', 0, 0, 'Proveedor', '', 0, NULL, ''),
(158, '4', 'Hab. Doble Temporad Media', 'Temporada Media', 100000, '', '<p>Cama doble y aire</p>', 120000, '', '', 'color06', '2020-01-16 13:08:43', '2020-01-16 13:08:43', 0, 0, 'Proveedor', '', 0, NULL, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zarest_purchases`
--

CREATE TABLE `zarest_purchases` (
  `id` int(11) NOT NULL,
  `ref` varchar(11) NOT NULL,
  `date` date NOT NULL,
  `total` float DEFAULT NULL,
  `attachement` varchar(200) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `created_by` int(11) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `note` mediumtext,
  `modified_at` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zarest_purchase_items`
--

CREATE TABLE `zarest_purchase_items` (
  `id` int(11) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qt` int(10) NOT NULL,
  `cost` float NOT NULL,
  `subtot` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zarest_registers`
--

CREATE TABLE `zarest_registers` (
  `id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(4) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cash_total` float DEFAULT NULL,
  `cash_sub` float DEFAULT NULL,
  `cc_total` float DEFAULT NULL,
  `cc_sub` float DEFAULT NULL,
  `cheque_total` float DEFAULT NULL,
  `cheque_sub` float DEFAULT NULL,
  `cash_inhand` float DEFAULT NULL,
  `note` text,
  `closed_at` varchar(150) DEFAULT NULL,
  `closed_by` int(11) DEFAULT NULL,
  `store_id` int(11) NOT NULL,
  `waiterscih` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `zarest_registers`
--

INSERT INTO `zarest_registers` (`id`, `date`, `status`, `user_id`, `cash_total`, `cash_sub`, `cc_total`, `cc_sub`, `cheque_total`, `cheque_sub`, `cash_inhand`, `note`, `closed_at`, `closed_by`, `store_id`, `waiterscih`) VALUES
(60, '2020-01-16 14:36:34', 1, 16, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, 1, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zarest_sales`
--

CREATE TABLE `zarest_sales` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `clientname` varchar(50) NOT NULL,
  `tax` varchar(5) DEFAULT NULL,
  `discount` varchar(10) DEFAULT NULL,
  `subtotal` varchar(15) NOT NULL,
  `total` float NOT NULL,
  `created_at` date NOT NULL,
  `modified_at` varchar(150) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `totalitems` int(20) NOT NULL,
  `paid` varchar(15) DEFAULT NULL,
  `paidmethod` varchar(700) DEFAULT NULL,
  `taxamount` float DEFAULT NULL,
  `discountamount` float DEFAULT NULL,
  `register_id` int(11) DEFAULT NULL,
  `firstpayement` float DEFAULT NULL,
  `waiter_id` int(11) DEFAULT NULL,
  `flaq` varchar(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `zarest_sales`
--

INSERT INTO `zarest_sales` (`id`, `client_id`, `clientname`, `tax`, `discount`, `subtotal`, `total`, `created_at`, `modified_at`, `status`, `created_by`, `totalitems`, `paid`, `paidmethod`, `taxamount`, `discountamount`, `register_id`, `firstpayement`, `waiter_id`, `flaq`) VALUES
(35, 0, 'Cliente sin Registrar', '19', '', '8000.0', 8019, '2020-01-16', NULL, 0, 'Recepcion ', 1, '8019.0', '0', 19, 0, 60, 8019, 0, ''),
(36, 11, 'PRUEBA CLIENTE PUNTO VENTA', NULL, NULL, '0', 0, '0000-00-00', NULL, 0, 'admin', 1, '0', '2~  ', 0, NULL, NULL, NULL, NULL, '1'),
(37, 12, 'UNO NUEVO', NULL, NULL, '0', 0, '0000-00-00', NULL, 0, 'admin', 1, '0', '2~  ', 0, NULL, NULL, NULL, NULL, '1'),
(38, 12, ' Luz Mary Rodriguez ', NULL, NULL, '80000', 80000, '0000-00-00', NULL, 0, 'admin', 1, '80000', '2~  ', 0, NULL, NULL, NULL, NULL, '1'),
(39, 13, 'acompa1', NULL, NULL, '300000', 300000, '0000-00-00', NULL, 127, 'admin', 1, '0', '2~  ', 0, NULL, NULL, NULL, NULL, '1'),
(40, 14, 'fulano de tal ', NULL, NULL, '80000', 80000, '0000-00-00', NULL, 127, 'admin', 1, '40000', '2~ 101 ', 0, NULL, NULL, NULL, NULL, '1'),
(41, 15, 'meli manrique ', NULL, NULL, '431000', 431000, '0000-00-00', NULL, 127, 'admin', 1, '90000', '2~ Hab 102 cama doble, abanico ', 0, NULL, NULL, NULL, NULL, '1'),
(42, 16, 'FULANO DE TAL ', NULL, NULL, '300000', 300000, '0000-00-00', NULL, 127, 'admin', 1, '0', '2~ 101 ', 0, NULL, NULL, NULL, NULL, '1'),
(43, 17, 'Luz Mary Rodriguez ', NULL, NULL, '120000', 120000, '0000-00-00', NULL, 127, 'admin', 1, '0', '2~ Hab 102 cama doble, abanico ', 0, NULL, NULL, NULL, NULL, '1'),
(44, 18, 'Luz Mary Rodriguez ', NULL, NULL, '120000', 120000, '0000-00-00', NULL, 127, 'admin', 1, '0', '2~ Hab 102 cama doble, abanico ', 0, NULL, NULL, NULL, NULL, '1'),
(45, 19, 'Luz Mary Rodriguez ', NULL, NULL, '120000', 120000, '0000-00-00', NULL, 127, 'admin', 1, '0', '2~ Hab 102 cama doble, abanico ', 0, NULL, NULL, NULL, NULL, '1'),
(46, 20, 'PRUEBA DE UNA VEZ ', NULL, NULL, '340000', 340000, '0000-00-00', NULL, 127, 'admin', 1, '0', '2~ 101 ', 0, NULL, NULL, NULL, NULL, '1'),
(47, 21, 'NUEVAMENTE ENTRO UN CLIENTE', NULL, NULL, '780000', 780000, '0000-00-00', NULL, 127, 'admin', 1, '500000', '2~  ', 0, NULL, NULL, NULL, NULL, '1'),
(48, 21, 'Luz Mary Rodriguez ', NULL, NULL, '590000', 590000, '0000-00-00', NULL, 127, 'admin', 1, '400000', '2~  ', 0, NULL, NULL, NULL, NULL, '1'),
(49, 22, 'Luz Mary Rodriguez ', NULL, NULL, '120000', 120000, '0000-00-00', NULL, 127, 'admin', 1, '0', '2~ Hab 102 cama doble, abanico ', 0, NULL, NULL, NULL, NULL, '1'),
(50, 22, 'Luz Mary Rodriguez ', NULL, NULL, '120000', 120000, '0000-00-00', NULL, 127, 'admin', 1, '0', '2~ Hab 102 cama doble, abanico ', 0, NULL, NULL, NULL, NULL, '1'),
(51, 22, 'Luz Mary Rodriguez ', NULL, NULL, '120000', 120000, '0000-00-00', NULL, 127, 'admin', 1, '0', '2~ Hab 102 cama doble, abanico ', 0, NULL, NULL, NULL, NULL, '1'),
(52, 22, 'CARLOS PEREZ', NULL, NULL, '456000', 456000, '0000-00-00', NULL, 127, 'admin', 1, '400000', '2~  ', 0, NULL, NULL, NULL, NULL, '1'),
(53, 22, 'luz mar', NULL, NULL, '345000', 345000, '0000-00-00', NULL, 127, 'admin', 1, '230000', '2~  ', 0, NULL, NULL, NULL, NULL, '1'),
(54, 22, 'CARLOS PEREZ', NULL, NULL, '120000', 120000, '0000-00-00', NULL, 127, 'admin', 1, '0', '2~ Hab 102 cama doble, abanico ', 0, NULL, NULL, NULL, NULL, '1'),
(55, 22, 'Luz Mary Rodriguez ', NULL, NULL, '120000', 120000, '0000-00-00', NULL, 127, 'admin', 1, '0', '2~ Hab 102 cama doble, abanico ', 0, NULL, NULL, NULL, NULL, '1'),
(56, 22, 'Luz Mary Rodriguez ', NULL, NULL, '120000', 120000, '0000-00-00', NULL, 127, 'admin', 1, '0', '2~ Hab 102 cama doble, abanico ', 0, NULL, NULL, NULL, NULL, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zarest_sale_items`
--

CREATE TABLE `zarest_sale_items` (
  `id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `price` float NOT NULL,
  `qt` int(6) NOT NULL,
  `subtotal` varchar(20) NOT NULL,
  `date` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `zarest_sale_items`
--

INSERT INTO `zarest_sale_items` (`id`, `sale_id`, `product_id`, `name`, `price`, `qt`, `subtotal`, `date`) VALUES
(1023, 35, 155, 'DESAYUNO', 8000, 1, '8000', '2020-01-16'),
(1024, 36, 999, 'Servicio de Alojamiento', 0, 1, '0 ', '2020-01-16'),
(1025, 37, 999, 'Servicio de Alojamiento', 0, 1, '0 ', '2020-01-16'),
(1026, 38, 999, 'Servicio de Alojamiento', 80000, 1, '80000', '2020-01-16'),
(1027, 39, 999, 'Servicio de Alojamiento', 300000, 1, '300000', '2020-01-16'),
(1028, 40, 999, 'Servicio de Alojamiento', 80000, 1, '80000 ', '2020-01-16'),
(1029, 41, 999, 'Servicio de Alojamiento', 431000, 1, '431000 ', '2020-01-16'),
(1030, 42, 999, 'Servicio de Alojamiento', 300000, 1, '300000 ', '2020-01-16'),
(1031, 43, 999, 'Servicio de Alojamiento', 120000, 1, '120000 ', '2020-01-16'),
(1032, 44, 999, 'Servicio de Alojamiento', 120000, 1, '120000 ', '2020-01-16'),
(1033, 45, 999, 'Servicio de Alojamiento', 120000, 1, '120000 ', '2020-01-16'),
(1034, 46, 999, 'Servicio de Alojamiento', 340000, 1, '340000 ', '2020-01-16'),
(1035, 47, 999, 'Servicio de Alojamiento', 780000, 1, '780000', '2020-01-16'),
(1036, 48, 999, 'Servicio de Alojamiento', 590000, 1, '590000', '2020-01-16'),
(1037, 49, 999, 'Servicio de Alojamiento', 120000, 1, '120000 ', '2020-01-16'),
(1038, 50, 999, 'Servicio de Alojamiento', 120000, 1, '120000 ', '2020-01-16'),
(1039, 51, 999, 'Servicio de Alojamiento', 120000, 1, '120000 ', '2020-01-16'),
(1040, 52, 999, 'Servicio de Alojamiento', 456000, 1, '456000', '2020-01-17'),
(1041, 53, 999, 'Servicio de Alojamiento', 345000, 1, '345000', '2020-01-17'),
(1042, 54, 999, 'Servicio de Alojamiento', 120000, 1, '120000 ', '2020-01-17'),
(1043, 55, 999, 'Servicio de Alojamiento', 120000, 1, '120000', '2020-01-17'),
(1044, 56, 999, 'Servicio de Alojamiento', 120000, 1, '120000', '2020-01-17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zarest_settings`
--

CREATE TABLE `zarest_settings` (
  `id` int(11) NOT NULL,
  `companyname` varchar(100) NOT NULL,
  `logo` varchar(200) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `currency` varchar(10) DEFAULT NULL,
  `keyboard` tinyint(1) NOT NULL,
  `receiptheader` text,
  `receiptfooter` text NOT NULL,
  `theme` varchar(20) NOT NULL,
  `discount` varchar(5) DEFAULT NULL,
  `tax` varchar(5) DEFAULT NULL,
  `timezone` varchar(400) DEFAULT NULL,
  `language` varchar(30) DEFAULT NULL,
  `stripe` tinyint(4) DEFAULT NULL,
  `stripe_secret_key` varchar(150) DEFAULT NULL,
  `stripe_publishable_key` varchar(150) DEFAULT NULL,
  `decimals` int(2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `zarest_settings`
--

INSERT INTO `zarest_settings` (`id`, `companyname`, `logo`, `phone`, `currency`, `keyboard`, `receiptheader`, `receiptfooter`, `theme`, `discount`, `tax`, `timezone`, `language`, `stripe`, `stripe_secret_key`, `stripe_publishable_key`, `decimals`) VALUES
(1, 'Hotel Soliari', NULL, '3212052749', 'COP', 1, '<p>HOTEL SOLIARI</p><p>NIT.</p><p><br></p><p><br></p>', 'Gracias por contar con nosotros.', 'Light', '', '19', 'America/Bogota', 'spanish', 0, '', '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zarest_stocks`
--

CREATE TABLE `zarest_stocks` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `type` tinyint(4) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `quantity` int(10) DEFAULT NULL,
  `price` float DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `zarest_stocks`
--

INSERT INTO `zarest_stocks` (`id`, `product_id`, `type`, `store_id`, `warehouse_id`, `quantity`, `price`) VALUES
(60, 156, NULL, 1, NULL, 30, 80000),
(61, 157, NULL, 1, NULL, 10, 140000),
(62, 158, NULL, 1, NULL, 10, 120000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zarest_stores`
--

CREATE TABLE `zarest_stores` (
  `id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `email` varchar(40) DEFAULT NULL,
  `phone` varchar(40) DEFAULT NULL,
  `adresse` varchar(400) DEFAULT NULL,
  `footer_text` varchar(400) DEFAULT NULL,
  `city` varchar(20) DEFAULT NULL,
  `country` varchar(20) DEFAULT NULL,
  `created_at` varchar(200) NOT NULL,
  `status` tinyint(4) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `zarest_stores`
--

INSERT INTO `zarest_stores` (`id`, `name`, `email`, `phone`, `adresse`, `footer_text`, `city`, `country`, `created_at`, `status`) VALUES
(1, 'PUNTO DE VENTA HOTEL SOLIARI', 'comercial@deshida.com.co', '3212052749', 'MELGAR', 'Hotel Soliari', 'MELGAR', 'COLOMBIA', '2016-05-10 12:44:33', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zarest_suppliers`
--

CREATE TABLE `zarest_suppliers` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `note` mediumtext,
  `created_at` varchar(150) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zarest_tables`
--

CREATE TABLE `zarest_tables` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `zone_id` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `time` varchar(10) DEFAULT NULL,
  `store_id` int(11) NOT NULL,
  `checked` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `zarest_tables`
--

INSERT INTO `zarest_tables` (`id`, `name`, `zone_id`, `status`, `time`, `store_id`, `checked`) VALUES
(44, 'Bloque 1', 9, 1, '09:37', 1, '2020-01-16 13:26:19'),
(45, 'Bloque 2', 9, NULL, NULL, 1, NULL),
(46, 'Pasa día Mesa 1', 10, 1, '09:41', 1, '2020-01-16 13:26:38');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zarest_users`
--

CREATE TABLE `zarest_users` (
  `id` int(11) NOT NULL,
  `username` varchar(45) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `hashed_password` varchar(128) NOT NULL,
  `email` varchar(60) DEFAULT NULL,
  `role` varchar(20) NOT NULL,
  `last_active` varchar(50) DEFAULT NULL,
  `avatar` varchar(200) DEFAULT NULL,
  `created_at` varchar(300) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `zarest_users`
--

INSERT INTO `zarest_users` (`id`, `username`, `firstname`, `lastname`, `hashed_password`, `email`, `role`, `last_active`, `avatar`, `created_at`, `store_id`) VALUES
(1, 'admin', 'admin', 'Doe', '8091d35190efa5d080867aa44c596d0f269f2d3faee949c7a056fbef12a8a67ffbc7a34efe4ac206b15a2747ca63b6c9684a98d94f376aa929e4ebe04a50c16b', 'admin@dar-elweb.com', 'admin', '2020-01-16 13:32:47', '9fff9cc26e539214e9a5fd3b6a10cde9.jpg', '2016-07-31 09:05:25', NULL),
(16, 'recepcion', 'Recepcion', '', 'bd0b38fc50d69f6a94c03a40e8d4eeaac3c0b4cd8c52e6828db7b01ed85cf2451d25f55323951989396ec8eb3382197a84ec1ead4c57ac49dea8a0236e918cb0', 'comercial@deshida.com.co', 'sales', '2020-01-16 14:21:37', NULL, '2020-01-16 09:03:59', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zarest_variations`
--

CREATE TABLE `zarest_variations` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `price` float DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zarest_waiters`
--

CREATE TABLE `zarest_waiters` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `created_at` varchar(150) DEFAULT NULL,
  `store_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zarest_warehouses`
--

CREATE TABLE `zarest_warehouses` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `adresse` varchar(400) DEFAULT NULL,
  `created_at` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `zarest_warehouses`
--

INSERT INTO `zarest_warehouses` (`id`, `name`, `phone`, `email`, `adresse`, `created_at`) VALUES
(3, 'RESTAURANTE HOTEL SOLIARI', '3212052749', 'comercial@deshida.com.co', 'MELGAR', '2020-01-16 09:24:53'),
(4, 'PARQUEADERO HOTEL SOLIARI', '3212052749', 'comercial@deshida.com.co', 'MELGAR', '2020-01-16 09:25:51');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zarest_zones`
--

CREATE TABLE `zarest_zones` (
  `id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `zarest_zones`
--

INSERT INTO `zarest_zones` (`id`, `store_id`, `name`) VALUES
(9, 1, 'Servicio de Alojamiento y/o Restaurante'),
(10, 1, 'Pasa dia Piscina');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `zarest_categories`
--
ALTER TABLE `zarest_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `zarest_categorie_expences`
--
ALTER TABLE `zarest_categorie_expences`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `zarest_combo_items`
--
ALTER TABLE `zarest_combo_items`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `zarest_customers`
--
ALTER TABLE `zarest_customers`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `zarest_expences`
--
ALTER TABLE `zarest_expences`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `zarest_holds`
--
ALTER TABLE `zarest_holds`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `zarest_payements`
--
ALTER TABLE `zarest_payements`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `zarest_posales`
--
ALTER TABLE `zarest_posales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `zarest_products`
--
ALTER TABLE `zarest_products`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `zarest_purchases`
--
ALTER TABLE `zarest_purchases`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `zarest_purchase_items`
--
ALTER TABLE `zarest_purchase_items`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `zarest_registers`
--
ALTER TABLE `zarest_registers`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `zarest_sales`
--
ALTER TABLE `zarest_sales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `zarest_sale_items`
--
ALTER TABLE `zarest_sale_items`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `zarest_settings`
--
ALTER TABLE `zarest_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `zarest_stocks`
--
ALTER TABLE `zarest_stocks`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `zarest_stores`
--
ALTER TABLE `zarest_stores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `zarest_suppliers`
--
ALTER TABLE `zarest_suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `zarest_tables`
--
ALTER TABLE `zarest_tables`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `zarest_users`
--
ALTER TABLE `zarest_users`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `zarest_waiters`
--
ALTER TABLE `zarest_waiters`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `zarest_warehouses`
--
ALTER TABLE `zarest_warehouses`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `zarest_zones`
--
ALTER TABLE `zarest_zones`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `calendar_data`
--
ALTER TABLE `calendar_data`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT de la tabla `calendar_details`
--
ALTER TABLE `calendar_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `calendar_files`
--
ALTER TABLE `calendar_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `property_blockstatuses`
--
ALTER TABLE `property_blockstatuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT de la tabla `property_types`
--
ALTER TABLE `property_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT de la tabla `sys_config`
--
ALTER TABLE `sys_config`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `sys_language`
--
ALTER TABLE `sys_language`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `sys_log`
--
ALTER TABLE `sys_log`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `sys_mailtemplates`
--
ALTER TABLE `sys_mailtemplates`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `sys_users`
--
ALTER TABLE `sys_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT de la tabla `zarest_categories`
--
ALTER TABLE `zarest_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT de la tabla `zarest_categorie_expences`
--
ALTER TABLE `zarest_categorie_expences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `zarest_combo_items`
--
ALTER TABLE `zarest_combo_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT de la tabla `zarest_customers`
--
ALTER TABLE `zarest_customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT de la tabla `zarest_expences`
--
ALTER TABLE `zarest_expences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT de la tabla `zarest_holds`
--
ALTER TABLE `zarest_holds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=270;
--
-- AUTO_INCREMENT de la tabla `zarest_payements`
--
ALTER TABLE `zarest_payements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT de la tabla `zarest_posales`
--
ALTER TABLE `zarest_posales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1550;
--
-- AUTO_INCREMENT de la tabla `zarest_products`
--
ALTER TABLE `zarest_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;
--
-- AUTO_INCREMENT de la tabla `zarest_purchases`
--
ALTER TABLE `zarest_purchases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `zarest_purchase_items`
--
ALTER TABLE `zarest_purchase_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `zarest_registers`
--
ALTER TABLE `zarest_registers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
--
-- AUTO_INCREMENT de la tabla `zarest_sales`
--
ALTER TABLE `zarest_sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;
--
-- AUTO_INCREMENT de la tabla `zarest_sale_items`
--
ALTER TABLE `zarest_sale_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1045;
--
-- AUTO_INCREMENT de la tabla `zarest_settings`
--
ALTER TABLE `zarest_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `zarest_stocks`
--
ALTER TABLE `zarest_stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;
--
-- AUTO_INCREMENT de la tabla `zarest_stores`
--
ALTER TABLE `zarest_stores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `zarest_suppliers`
--
ALTER TABLE `zarest_suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `zarest_tables`
--
ALTER TABLE `zarest_tables`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT de la tabla `zarest_users`
--
ALTER TABLE `zarest_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT de la tabla `zarest_waiters`
--
ALTER TABLE `zarest_waiters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `zarest_warehouses`
--
ALTER TABLE `zarest_warehouses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `zarest_zones`
--
ALTER TABLE `zarest_zones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
