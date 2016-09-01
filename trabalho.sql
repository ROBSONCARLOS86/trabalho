-- Adminer 4.2.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `idadmin` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `senha` varchar(45) NOT NULL,
  `papel` int(11) NOT NULL,
  PRIMARY KEY (`idadmin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `admin` (`idadmin`, `nome`, `email`, `senha`, `papel`) VALUES
(1,	'Gerente',	'gerente@email.com',	'123',	1),
(2,	'cozinheiro',	'cozinheiro@email.com',	'123',	2);

DROP TABLE IF EXISTS `categoria`;
CREATE TABLE `categoria` (
  `idcategoria` int(11) NOT NULL AUTO_INCREMENT,
  `categoria` varchar(45) NOT NULL,
  PRIMARY KEY (`idcategoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `categoria` (`idcategoria`, `categoria`) VALUES
(6,	'PRATO FEITO'),
(7,	'EXECUTIVO'),
(8,	'COMERCIAL'),
(9,	'SERVI-SERVICE'),
(11,	'RODIZIO');

DROP TABLE IF EXISTS `prato`;
CREATE TABLE `prato` (
  `idprato` int(11) NOT NULL AUTO_INCREMENT,
  `nomeprato` varchar(100) NOT NULL,
  `preco` decimal(8,2) DEFAULT NULL,
  `idcategoria` int(11) NOT NULL,
  `idadmin` int(11) NOT NULL,
  PRIMARY KEY (`idprato`),
  KEY `fk_prato_categoria_idx` (`idcategoria`),
  CONSTRAINT `fk_prato_categoria` FOREIGN KEY (`idcategoria`) REFERENCES `categoria` (`idcategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 2016-08-31 19:52:04
