-- Estructura de tabla para la tabla `acompañante`
--

CREATE TABLE `acompañante` (
  `id_acomp` int(11) NOT NULL,
  `nombrea` varchar(25) DEFAULT NULL,
  `apellidoa` varchar(25) DEFAULT NULL,
  `razonAcomp` tinytext DEFAULT NULL,
  `acomp` tinytext DEFAULT NULL,
  `activo` tinyint(4) DEFAULT NULL,
  `Persona_numCedula` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formulario`
--

CREATE TABLE `formulario` (
  `id_form` int(11) NOT NULL,
  `anotaciones` longtext DEFAULT NULL,
  `fechaCreacion` date DEFAULT NULL,
  `ultimaEdicion` date DEFAULT NULL,
  `motivo` varchar(25) DEFAULT NULL,
  `hospital` tinytext DEFAULT NULL,
  `agencia` varchar(30) DEFAULT NULL,
  `tipo` varchar(30) DEFAULT NULL,
  `comision` tinytext DEFAULT NULL,
  `Persona_numCedula` int(11) NOT NULL,
  `Acompañante_id_acomp` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pasaje`
--

CREATE TABLE `pasaje` (
  `Id_pasaje` int(11) NOT NULL,
  `origen` varchar(20) DEFAULT NULL,
  `localidado` varchar(45) DEFAULT NULL,
  `destino` varchar(20) DEFAULT NULL,
  `localidadd` varchar(45) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `Persona_numCedula` int(11) NOT NULL,
  `formulario_id_form` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `numCedula` int(11) NOT NULL,
  `nombre` varchar(25) DEFAULT NULL,
  `apellido` varchar(25) DEFAULT NULL,
  `genero` varchar(25) DEFAULT NULL,
  `fecnac` date DEFAULT NULL,
  `activo` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `usuario` varchar(30) DEFAULT NULL,
  `correo` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `Persona_numCedula` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `acompañante`
--
ALTER TABLE `acompañante`
  ADD PRIMARY KEY (`id_acomp`),
  ADD KEY `fk_Acompañante_Persona1_idx` (`Persona_numCedula`);

--
-- Indices de la tabla `formulario`
--
ALTER TABLE `formulario`
  ADD PRIMARY KEY (`id_form`),
  ADD KEY `fk_historialClinico.,._Persona1_idx` (`Persona_numCedula`),
  ADD KEY `fk_formulario_Acompañante1_idx` (`Acompañante_id_acomp`);

--
-- Indices de la tabla `pasaje`
--
ALTER TABLE `pasaje`
  ADD PRIMARY KEY (`Id_pasaje`),
  ADD KEY `fk_Pasaje_Persona1_idx` (`Persona_numCedula`),
  ADD KEY `fk_Pasaje_formulario1_idx` (`formulario_id_form`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`numCedula`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`Persona_numCedula`),
  ADD KEY `fk_Usuarios_Persona1_idx` (`Persona_numCedula`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `formulario`
--
ALTER TABLE `formulario`
  MODIFY `id_form` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pasaje`
--
ALTER TABLE `pasaje`
  MODIFY `Id_pasaje` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `acompañante`
--
ALTER TABLE `acompañante`
  ADD CONSTRAINT `fk_Acompañante_Persona1` FOREIGN KEY (`Persona_numCedula`) REFERENCES `persona` (`numCedula`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `formulario`
--
ALTER TABLE `formulario`
  ADD CONSTRAINT `fk_formulario_Acompañante1` FOREIGN KEY (`Acompañante_id_acomp`) REFERENCES `acompañante` (`id_acomp`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_historialClinico.,._Persona1` FOREIGN KEY (`Persona_numCedula`) REFERENCES `persona` (`numCedula`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `pasaje`
--
ALTER TABLE `pasaje`
  ADD CONSTRAINT `fk_Pasaje_Persona1` FOREIGN KEY (`Persona_numCedula`) REFERENCES `persona` (`numCedula`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Pasaje_formulario1` FOREIGN KEY (`formulario_id_form`) REFERENCES `formulario` (`id_form`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_Usuarios_Persona1` FOREIGN KEY (`Persona_numCedula`) REFERENCES `persona` (`numCedula`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
