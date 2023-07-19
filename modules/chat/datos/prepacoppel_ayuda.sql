-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 13-11-2015 a las 19:42:48
-- Versión del servidor: 5.6.21
-- Versión de PHP: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `prepacoppel`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_eliminar_archivo`(in _id_archivo bigint)
begin
	update ag_ayuda_archivos set eliminado = 1 where id = _id_archivo;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_eliminar_asunto`(in _id_asunto bigint)
begin
	update ag_ayuda_asuntos set eliminado = 1 where id = _id_asunto;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_eliminar_mensaje`(in _id_mensaje bigint)
begin
	update ag_ayuda_mensajes set eliminado = 1 where id = _id_mensaje;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_eliminar_preguntasfrecuentes`(in _id tinyint)
begin
	update ag_ayuda_preguntasfrecuentes set eliminado = 1 where id = _id;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_guardar_archivo`(in _id_asunto bigint)
begin
	insert into ag_ayuda_archivos(id_asunto)values(_id_asunto);
    select last_insert_id() as archivo;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_guardar_asunto`(in _usuario bigint,in _asunto char(80),in _mensaje varchar(255), in _telefono varchar(45))
begin
	declare _id_asunto bigint;
    start transaction;
	insert into ag_ayuda_asuntos(id_usuario,asunto,telefono)values(_usuario,_asunto,_telefono);
    set _id_asunto = last_insert_id();
    insert into ag_ayuda_mensajes(id_usuario,id_asunto,mensaje)values(_usuario,_id_asunto,_mensaje);
    commit;
    select _id_asunto as asunto, last_insert_id() as mensaje;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_guardar_mensaje`(in _usuario bigint, in _id_asunto bigint, in _mensaje varchar(255))
begin
	insert into ag_ayuda_mensajes(id_usuario,id_asunto,mensaje)values(_usuario,_id_asunto,_mensaje);
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_guardar_preguntasfrecuentes`(in _asunto char(80),in _mensaje varchar(255), in _jerarquia tinyint)
begin
	insert into ag_ayuda_preguntasfrecuentes(asunto,mensaje,jerarquia)values(_asunto,_mensaje,_jerarquia);
    select last_insert_id() as id;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_guardar_status`(in _id_asunto bigint, in _status tinyint)
begin
	update ag_ayuda_asunto set status = _status  where id = _id_asunto;
end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ag_ayuda_archivos`
--

CREATE TABLE IF NOT EXISTS `ag_ayuda_archivos` (
`id` bigint(20) NOT NULL,
  `id_asunto` bigint(20) NOT NULL,
  `eliminado` tinyint(1) NOT NULL DEFAULT '0',
  `fecha_registrado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fecha_eliminado` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ag_ayuda_archivos`
--

INSERT INTO `ag_ayuda_archivos` (`id`, `id_asunto`, `eliminado`, `fecha_registrado`, `fecha_actualizado`, `fecha_eliminado`) VALUES
(1, 2, 0, '2015-11-13 16:32:54', '2015-11-13 16:32:54', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ag_ayuda_asuntos`
--

CREATE TABLE IF NOT EXISTS `ag_ayuda_asuntos` (
`id` bigint(20) NOT NULL,
  `id_usuario` bigint(20) NOT NULL,
  `asunto` char(80) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `telefono` varchar(45) DEFAULT NULL,
  `eliminado` tinyint(1) NOT NULL DEFAULT '0',
  `fecha_registrado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fecha_eliminado` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ag_ayuda_asuntos`
--

INSERT INTO `ag_ayuda_asuntos` (`id`, `id_usuario`, `asunto`, `status`, `telefono`, `eliminado`, `fecha_registrado`, `fecha_actualizado`, `fecha_eliminado`) VALUES
(1, 1, 'Como hago esto', 0, '667788', 0, '2015-11-13 15:03:29', '2015-11-13 15:03:29', '0000-00-00 00:00:00'),
(2, 1, 'Asunto 2', 0, '778908765', 0, '2015-11-13 16:32:54', '2015-11-13 16:32:54', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ag_ayuda_mensajes`
--

CREATE TABLE IF NOT EXISTS `ag_ayuda_mensajes` (
`id` bigint(20) NOT NULL,
  `id_asunto` bigint(20) NOT NULL,
  `id_usuario` bigint(20) NOT NULL,
  `mensaje` varchar(255) DEFAULT NULL,
  `hora` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `eliminado` tinyint(1) NOT NULL DEFAULT '0',
  `fecha_registrado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fecha_eliminado` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ag_ayuda_mensajes`
--

INSERT INTO `ag_ayuda_mensajes` (`id`, `id_asunto`, `id_usuario`, `mensaje`, `hora`, `eliminado`, `fecha_registrado`, `fecha_actualizado`, `fecha_eliminado`) VALUES
(1, 1, 1, 'necesito saber como ', '2015-11-13 09:03:29', 0, '2015-11-13 15:03:29', '2015-11-13 15:03:29', '0000-00-00 00:00:00'),
(2, 2, 1, 'mensaje de el usuario', '2015-11-13 10:32:54', 0, '2015-11-13 16:32:54', '2015-11-13 16:32:54', '0000-00-00 00:00:00'),
(3, 2, 1, 'Mensaje w', '2015-11-04 00:00:00', 0, '2015-11-09 06:00:00', '2015-11-13 16:38:34', '0000-00-00 00:00:00'),
(4, 2, 0, NULL, '2015-11-13 10:44:15', 0, '2015-11-13 16:44:15', '2015-11-13 16:44:15', '0000-00-00 00:00:00'),
(5, 1, 2, 'otro mensaje', '2015-11-13 11:25:54', 0, '2015-11-13 17:25:54', '2015-11-13 17:25:54', '0000-00-00 00:00:00'),
(6, 2, 1, 'otro mensaje', '2015-11-13 11:28:09', 0, '2015-11-13 17:28:09', '2015-11-13 17:28:09', '0000-00-00 00:00:00'),
(7, 1, 1, 'otromensaje', '2015-11-13 11:30:16', 0, '2015-11-13 17:30:16', '2015-11-13 17:30:16', '0000-00-00 00:00:00'),
(8, 1, 1, 'yasi', '2015-11-13 11:30:18', 0, '2015-11-13 17:30:18', '2015-11-13 17:30:18', '0000-00-00 00:00:00'),
(9, 2, 1, '123', '2015-11-13 11:36:33', 0, '2015-11-13 17:36:33', '2015-11-13 17:36:33', '0000-00-00 00:00:00'),
(10, 2, 1, 'WDSD', '2015-11-13 11:36:41', 0, '2015-11-13 17:36:41', '2015-11-13 17:36:41', '0000-00-00 00:00:00'),
(11, 2, 1, 'hola', '2015-11-13 11:40:05', 0, '2015-11-13 17:40:05', '2015-11-13 17:40:05', '0000-00-00 00:00:00'),
(12, 2, 1, 'hola2', '2015-11-13 11:42:04', 0, '2015-11-13 17:42:04', '2015-11-13 17:42:04', '0000-00-00 00:00:00'),
(13, 2, 1, '123', '2015-11-13 11:45:54', 0, '2015-11-13 17:45:54', '2015-11-13 17:45:54', '0000-00-00 00:00:00'),
(14, 2, 1, 'qwdasd', '2015-11-13 11:46:02', 0, '2015-11-13 17:46:02', '2015-11-13 17:46:02', '0000-00-00 00:00:00'),
(15, 2, 1, '433', '2015-11-13 11:47:14', 0, '2015-11-13 17:47:14', '2015-11-13 17:47:14', '0000-00-00 00:00:00'),
(16, 2, 1, 'asasas', '2015-11-13 11:48:44', 0, '2015-11-13 17:48:44', '2015-11-13 17:48:44', '0000-00-00 00:00:00'),
(17, 2, 1, 'asasas', '2015-11-13 11:48:47', 0, '2015-11-13 17:48:47', '2015-11-13 17:48:47', '0000-00-00 00:00:00'),
(18, 2, 1, 'holacomoestas', '2015-11-13 12:05:05', 0, '2015-11-13 18:05:05', '2015-11-13 18:05:05', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ag_ayuda_preguntasfrecuentes`
--

CREATE TABLE IF NOT EXISTS `ag_ayuda_preguntasfrecuentes` (
`id` tinyint(4) NOT NULL,
  `asunto` char(80) NOT NULL,
  `mensaje` varchar(255) NOT NULL,
  `jerarquia` tinyint(4) NOT NULL DEFAULT '1',
  `eliminado` tinyint(1) NOT NULL DEFAULT '0',
  `fecha_registrado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fecha_eliminado` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ag_ayuda_preguntasfrecuentes`
--

INSERT INTO `ag_ayuda_preguntasfrecuentes` (`id`, `asunto`, `mensaje`, `jerarquia`, `eliminado`, `fecha_registrado`, `fecha_actualizado`, `fecha_eliminado`) VALUES
(1, '¿Como cargo una materia?', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vitae ex leo. Nulla varius mollis odio, nec iaculis lorem faucibus vel. In nulla sem, auctor pellentesque egestas eu, laoreet eget sapien.', 1, 0, '2015-11-13 17:03:24', '2015-11-13 17:05:54', '0000-00-00 00:00:00'),
(2, '¿Como doy de baja la materia?', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vitae ex leo. Nulla varius mollis odio, nec iaculis lorem faucibus vel. In nulla sem, auctor pellentesque egestas eu, laoreet eget sapien.', 1, 0, '2015-11-13 17:03:24', '2015-11-13 17:05:58', '0000-00-00 00:00:00'),
(3, '¿Pregunta frecuente?', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vitae ex leo. Nulla varius mollis odio, nec iaculis lorem faucibus vel. In nulla sem, auctor pellentesque egestas eu, laoreet eget sapien.', 1, 0, '2015-11-13 17:11:07', '2015-11-13 17:11:07', '0000-00-00 00:00:00'),
(4, '¿Otra pregunta frecuente?', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vitae ex leo. Nulla varius mollis odio, nec iaculis lorem faucibus vel. In nulla sem, auctor pellentesque egestas eu, laoreet eget sapien.', 1, 0, '2015-11-13 17:11:07', '2015-11-13 17:11:07', '0000-00-00 00:00:00'),
(5, '¿Pregunta frecuente?', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vitae ex leo. Nulla varius mollis odio, nec iaculis lorem faucibus vel. In nulla sem, auctor pellentesque egestas eu, laoreet eget sapien.', 1, 0, '2015-11-13 17:12:59', '2015-11-13 17:12:59', '0000-00-00 00:00:00'),
(6, '¿Otra pregunta frecuente?', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse vitae ex leo. Nulla varius mollis odio, nec iaculis lorem faucibus vel. In nulla sem, auctor pellentesque egestas eu, laoreet eget sapien.', 1, 0, '2015-11-13 17:12:59', '2015-11-13 17:12:59', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mdl_user`
--

CREATE TABLE IF NOT EXISTS `mdl_user` (
  `id` bigint(20) NOT NULL,
  `mdl_usercol` varchar(45) DEFAULT NULL,
  `mdl_usercol1` varchar(45) DEFAULT NULL,
  `mdl_usercol2` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `view_archivos`
--
CREATE TABLE IF NOT EXISTS `view_archivos` (
`id` bigint(20)
,`id_asunto` bigint(20)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `view_asuntos`
--
CREATE TABLE IF NOT EXISTS `view_asuntos` (
`id` bigint(20)
,`id_usuario` bigint(20)
,`asunto` char(80)
,`status` tinyint(4)
,`telefono` varchar(45)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `view_mensajes`
--
CREATE TABLE IF NOT EXISTS `view_mensajes` (
`id_asunto` bigint(20)
,`id_usuario` bigint(20)
,`mensaje` varchar(255)
,`hora` datetime
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `view_preguntasfrecuentes`
--
CREATE TABLE IF NOT EXISTS `view_preguntasfrecuentes` (
`id` tinyint(4)
,`asunto` char(80)
,`mensaje` varchar(255)
,`jerarquia` tinyint(4)
);
-- --------------------------------------------------------

--
-- Estructura para la vista `view_archivos`
--
DROP TABLE IF EXISTS `view_archivos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_archivos` AS select `ag_ayuda_archivos`.`id` AS `id`,`ag_ayuda_archivos`.`id_asunto` AS `id_asunto` from `ag_ayuda_archivos` where (`ag_ayuda_archivos`.`eliminado` = 0);

-- --------------------------------------------------------

--
-- Estructura para la vista `view_asuntos`
--
DROP TABLE IF EXISTS `view_asuntos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_asuntos` AS select `ag_ayuda_asuntos`.`id` AS `id`,`ag_ayuda_asuntos`.`id_usuario` AS `id_usuario`,`ag_ayuda_asuntos`.`asunto` AS `asunto`,`ag_ayuda_asuntos`.`status` AS `status`,`ag_ayuda_asuntos`.`telefono` AS `telefono` from `ag_ayuda_asuntos` where (`ag_ayuda_asuntos`.`eliminado` = 0);

-- --------------------------------------------------------

--
-- Estructura para la vista `view_mensajes`
--
DROP TABLE IF EXISTS `view_mensajes`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_mensajes` AS select `ag_ayuda_mensajes`.`id_asunto` AS `id_asunto`,`ag_ayuda_mensajes`.`id_usuario` AS `id_usuario`,`ag_ayuda_mensajes`.`mensaje` AS `mensaje`,`ag_ayuda_mensajes`.`hora` AS `hora` from `ag_ayuda_mensajes` where (`ag_ayuda_mensajes`.`eliminado` = 0);

-- --------------------------------------------------------

--
-- Estructura para la vista `view_preguntasfrecuentes`
--
DROP TABLE IF EXISTS `view_preguntasfrecuentes`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_preguntasfrecuentes` AS select `ag_ayuda_preguntasfrecuentes`.`id` AS `id`,`ag_ayuda_preguntasfrecuentes`.`asunto` AS `asunto`,`ag_ayuda_preguntasfrecuentes`.`mensaje` AS `mensaje`,`ag_ayuda_preguntasfrecuentes`.`jerarquia` AS `jerarquia` from `ag_ayuda_preguntasfrecuentes` where (`ag_ayuda_preguntasfrecuentes`.`eliminado` = 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ag_ayuda_archivos`
--
ALTER TABLE `ag_ayuda_archivos`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ag_ayuda_asuntos`
--
ALTER TABLE `ag_ayuda_asuntos`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ag_ayuda_mensajes`
--
ALTER TABLE `ag_ayuda_mensajes`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ag_ayuda_preguntasfrecuentes`
--
ALTER TABLE `ag_ayuda_preguntasfrecuentes`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mdl_user`
--
ALTER TABLE `mdl_user`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ag_ayuda_archivos`
--
ALTER TABLE `ag_ayuda_archivos`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `ag_ayuda_asuntos`
--
ALTER TABLE `ag_ayuda_asuntos`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `ag_ayuda_mensajes`
--
ALTER TABLE `ag_ayuda_mensajes`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT de la tabla `ag_ayuda_preguntasfrecuentes`
--
ALTER TABLE `ag_ayuda_preguntasfrecuentes`
MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
