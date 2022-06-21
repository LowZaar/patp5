CREATE TABLE `Solicitacoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT NULL,
  `id_solicitante` int(11) DEFAULT NULL,
  `titulo` varchar(100) DEFAULT NULL,
  `mensagem` varchar(200) DEFAULT NULL,
  `datainicio` datetime DEFAULT NULL,
  `datafim` datetime DEFAULT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_Usuario` (`id_usuario`),
  KEY `idSolicitante` (`id_solicitante`),
  CONSTRAINT `Solicitacoes_ibfk_1` FOREIGN KEY (`id_Usuario`) REFERENCES `Usuarios` (`id`),
  CONSTRAINT `Solicitacoes_ibfk_2` FOREIGN KEY (`id_solicitante`) REFERENCES `Usuarios` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `Usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `cpfcnpj` varchar(20) NOT NULL,
  `telefone` varchar(70) NOT NULL,
  `email` varchar(50) NOT NULL,
  `senha` varchar(50) NOT NULL,
  `titulo` int(50) NOT NULL,
  `cor` varchar(50) NOT NULL,
  `horario` int(50) NOT NULL,
  `fimDeSemana` int(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;
