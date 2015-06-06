-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 06-06-2015 a las 11:08:43
-- Versión del servidor: 5.5.41
-- Versión de PHP: 5.3.10-1ubuntu3.15

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `testsolution`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `antivirus`
--

CREATE TABLE IF NOT EXISTS `antivirus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `ram` int(11) NOT NULL,
  `sistemaoperativo` int(11) NOT NULL,
  `caracteristica` int(11) NOT NULL,
  `precio` double NOT NULL,
  `imagen` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Volcado de datos para la tabla `antivirus`
--

INSERT INTO `antivirus` (`id`, `nombre`, `descripcion`, `ram`, `sistemaoperativo`, `caracteristica`, `precio`, `imagen`) VALUES
(1, 'Nod 32', 'Ante las crecientes amenazas informáticas tanto tu información como tu identidad necesitan estar protegidas, es por eso que ESET desarrolló ESET NOD32 Antivirus y ESET Smart Security. Las soluciones de seguridad que brindan una eficaz y veloz protección sin consumir gran cantidad de recursos de tu equipo.', 1, 1, 0, 295, 'NOD32-logo.png'),
(2, 'AVG', 'Analiza el comportamiento de un software en tiempo real para determinar si está seguro. Esta característica ayuda a protegerlo frente a las últimas amenazas y los programas maliciosos que podrían robar sus contraseñas, detalles de su cuenta bancaria y otros datos digitales valiosos.', 1, 2, 0, 320, 'AVG_logo.png'),
(3, 'Kaspersky', 'Kaspersky Internet Security – multidispositivos 2015 es la solución de licencia única que protege tu identidad digital, tus finanzas, tu información confidencial y a tus hijos. Cuando realizas operaciones bancarias, compras o socializas en línea, Internet presenta siempre las mismas amenazas.', 1, 2, 0, 205, 'kaspersky-logo.jpg'),
(4, 'Avast!', 'Es capaz de proteger tu equipo de virus, troyanos y demás malware en tiempo real. También ofrece la posibilidad de realizar análisis del sistema parciales o completos. Incluye la función AutoSandbox para la ejecución de utilidades de dudosa fiabilidad.', 2, 2, 0, 312, 'avast.jpg'),
(5, 'Avira AntiVir', 'Avira AntiVir incluye un potente antivirus para luchar contra las infecciones víricas del PC, y también otras herramientas de seguridad como antiadware, antispyware, sistema antirootkit, detección de enlaces peligrosos y protección antiphishing. Incluye actualizaciones automáticas programables y consume muy pocos recursos del sistema.', 2, 2, 0, 210, 'aviara.jpg'),
(6, 'Panda Antivirus', 'Panda Antivirus es una completa solución de protección frente a virus, spyware y rootkits. También es capaz de detectar las amenazas provenientes de web fraudulentas. Gracias a Panda Safe Browser puedes acceder a las webs sin riesgo. Resulta muy útil el firewall incorporado y la función “modo de juego/multimedia”.', 3, 2, 0, 240, 'panda.jpg'),
(7, 'Norton Internet Security', 'Es el mejor para la seguridad al navegar por internet. Una de sus principales características es la detección de ''malware'', la cual se basa en el análisis de su comportamiento como una amenaza.', 2, 0, 0, 208, 'norton.jpg'),
(8, 'BitDefender Internet Security', 'Se basa en la tecnología que ha recibido el premio de AV-TEST a la Mejor protección durante tres años consecutivos, y al Mejor rendimiento en cuanto a velocidad del sistema. Intuitivo, protege su dispositivo con un solo clic. También impide el acceso no autorizado a su información privada con un cortafuego bidireccional.', 2, 2, 0, 161, 'bitdefender.jpg'),
(9, 'McAfee Internet Security', 'Los virus solo son una pequeña parte del panorama de las amenazas de Internet de la actualidad. Consiga McAfee Total Protection para proteger su PC, red social, identidad, familia y su red doméstica con nuestra última protección frente a piratas informáticos, malware, spyware, phishing y otras amenazas online.', 2, 2, 0, 270, 'mcafee.jpg'),
(10, 'Webroot Internet Security', 'Funciona silenciosamente en segundo plano para proteger sus nombres de usuario, números de cuenta, códigos de seguridad y otra información personal del robo.', 2, 2, 0, 300, 'Webroot.jpg'),
(11, 'Trend Micro Internet Security', 'Trend Micro ™ Internet Security software proporciona protección avanzada y privacidad para su vida digital. Está diseñado para proteger a las redes sociales como Facebook, Google+, Twitter y LinkedIn.', 2, 2, 0, 255, 'TrendMicro.jpg'),
(12, 'Ad-Aware', 'La tecnología de Ad Aware Free Antivirus + ofrece una garantía de confianza, y es utilizado por más personas que cualquier producto de seguridad.', 3, 2, 0, 390, 'ad-aware.png'),
(13, 'Dr. Web', 'Doctor Web es uno de los pocos proveedores de antivirus en el mundo que tienen sus propias tecnologías para detectar y curar malware. Nuestro sistema de protección anti-virus permite a los sistemas de información de nuestros clientes a ser protegidos de cualquier amenaza, incluso los que aún se desconoce.', 2, 1, 0, 210, 'drweb.png'),
(14, 'FortiNet', 'FortiNet es una suite de seguridad integral, diseñado para PCs, portátiles, tabletas y dispositivos móviles. Las características incluyen SSL e IPSec VPN, antivirus / antimalware, filtrado Web, firewall de aplicaciones, optimización WAN y más. FortiClient está totalmente integrado con FortiGate, FortiManager y FortiAnalyzer para la gestión, despliegue y registro / informes central.', 2, 2, 0, 325, 'fortinet.png'),
(15, 'ZoneAlarm', 'Proporciona acceso a la base de datos de firmas de antivirus-actualizada para proteger contra las amenazas emergentes. En tiempo real de la nube de base de datos contiene reputación actualizada de los archivos, recursos web y software de mejora de la protección tradicional Antivirus + Firewall.', 2, 0, 0, 340, 'ZoneAlarm.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sistemaoperativo`
--

CREATE TABLE IF NOT EXISTS `sistemaoperativo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `arquitectura` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `sistemaoperativo`
--

INSERT INTO `sistemaoperativo` (`id`, `nombre`, `arquitectura`) VALUES
(1, 'Windows XP', 32),
(2, 'Windows XP', 64);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
