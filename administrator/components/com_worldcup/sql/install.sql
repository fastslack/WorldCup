--
-- Database: `worldcup`
--

-- --------------------------------------------------------

--
-- Table structure for table `#__worldcup_bets`
--

CREATE TABLE IF NOT EXISTS `#__worldcup_bets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `mid` int(11) NOT NULL,
  `local` varchar(11) DEFAULT NULL,
  `visit` varchar(11) DEFAULT NULL,
  `team1` int(11) NOT NULL,
  `team2` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Table structure for table `#__worldcup_groups`
--

CREATE TABLE IF NOT EXISTS `#__worldcup_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `checked_out` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `#__worldcup_groups`
--

INSERT INTO `#__worldcup_groups` VALUES(1, 1, 'A', 0);
INSERT INTO `#__worldcup_groups` VALUES(2, 1, 'B', 0);
INSERT INTO `#__worldcup_groups` VALUES(3, 1, 'C', 0);
INSERT INTO `#__worldcup_groups` VALUES(4, 1, 'D', 0);
INSERT INTO `#__worldcup_groups` VALUES(5, 1, 'E', 0);
INSERT INTO `#__worldcup_groups` VALUES(6, 1, 'F', 0);
INSERT INTO `#__worldcup_groups` VALUES(7, 1, 'G', 0);
INSERT INTO `#__worldcup_groups` VALUES(8, 1, 'H', 0);
INSERT INTO `#__worldcup_groups` VALUES(9, 2, 'A', 0);
INSERT INTO `#__worldcup_groups` VALUES(10, 2, 'B', 0);
INSERT INTO `#__worldcup_groups` VALUES(11, 2, 'C', 0);

-- --------------------------------------------------------

--
-- Table structure for table `#__worldcup_matches`
--

CREATE TABLE IF NOT EXISTS `#__worldcup_matches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `group` int(11) NOT NULL,
  `place` int(11) NOT NULL,
  `team1` varchar(255) NOT NULL,
  `team2` varchar(255) NOT NULL,
  `phase` int(11) NOT NULL,
  `checked_out` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=91 ;

--
-- Dumping data for table `#__worldcup_matches`
--

INSERT INTO `#__worldcup_matches` VALUES(1, 1, '2010-06-11 11:00:00', 1, 1, '1', '2', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(2, 1, '2010-06-11 15:30:00', 1, 6, '3', '4', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(3, 1, '2010-06-12 11:00:00', 2, 1, '7', '8', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(4, 1, '2010-06-12 08:30:00', 2, 4, '5', '6', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(5, 1, '2010-06-12 15:30:00', 3, 3, '9', '10', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(6, 1, '2010-06-13 08:30:00', 3, 7, '11', '12', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(7, 1, '2010-06-13 15:30:00', 4, 5, '15', '16', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(8, 1, '2010-06-13 11:00:00', 4, 8, '13', '14', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(9, 1, '2010-06-14 08:30:00', 5, 1, '17', '18', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(10, 1, '2010-06-14 11:00:00', 5, 2, '19', '20', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(11, 1, '2010-06-14 15:30:00', 6, 6, '21', '22', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(12, 1, '2010-06-15 08:30:00', 6, 3, '23', '24', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(13, 1, '2010-06-15 11:00:00', 7, 4, '25', '26', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(14, 1, '2010-06-15 15:30:00', 7, 1, '27', '28', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(15, 1, '2010-06-16 08:30:00', 8, 9, '29', '30', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(16, 1, '2010-06-16 16:00:00', 8, 5, '31', '32', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(17, 1, '2010-06-16 16:00:00', 1, 8, '1', '3', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(18, 1, '2010-06-17 15:30:00', 1, 7, '4', '2', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(19, 1, '2010-06-17 11:00:00', 2, 2, '6', '8', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(20, 1, '2010-06-17 08:30:00', 2, 1, '7', '5', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(21, 1, '2010-06-18 08:30:00', 4, 4, '15', '13', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(22, 1, '2010-06-18 11:00:00', 3, 1, '12', '10', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(23, 1, '2010-06-18 15:30:00', 3, 6, '9', '11', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(24, 1, '2010-06-19 11:00:00', 4, 3, '14', '16', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(25, 1, '2010-06-19 08:30:00', 5, 5, '17', '19', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(26, 1, '2010-06-19 15:30:00', 5, 8, '20', '18', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(27, 1, '2010-06-20 08:30:00', 6, 2, '24', '22', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(28, 1, '2010-06-20 11:00:00', 6, 9, '21', '23', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(29, 1, '2010-06-20 15:30:00', 7, 1, '27', '25', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(30, 1, '2010-06-21 08:30:00', 7, 6, '26', '28', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(31, 1, '2010-06-21 11:00:00', 8, 4, '30', '32', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(32, 1, '2010-06-21 15:30:00', 8, 1, '31', '29', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(33, 1, '2010-06-22 11:00:00', 1, 3, '2', '3', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(34, 1, '2010-06-22 11:00:00', 1, 2, '4', '1', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(35, 1, '2010-06-22 15:30:00', 2, 5, '8', '5', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(36, 1, '2010-06-22 15:30:00', 2, 7, '6', '7', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(37, 1, '2010-06-23 11:00:00', 3, 4, '12', '9', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(38, 1, '2010-06-23 11:00:00', 3, 8, '10', '11', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(39, 1, '2010-06-23 15:30:00', 4, 1, '14', '15', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(40, 1, '2010-06-23 15:30:00', 4, 9, '16', '13', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(41, 1, '2010-06-24 11:00:00', 6, 1, '24', '21', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(42, 1, '2010-06-24 11:00:00', 6, 7, '22', '23', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(43, 1, '2010-06-24 15:30:00', 5, 3, '18', '19', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(44, 1, '2010-06-24 15:30:00', 5, 6, '20', '17', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(45, 1, '2010-06-25 11:00:00', 7, 5, '26', '27', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(46, 1, '2010-06-25 11:00:00', 7, 9, '28', '25', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(47, 1, '2010-06-25 15:30:00', 8, 8, '30', '31', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(48, 1, '2010-06-25 15:30:00', 8, 2, '32', '29', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(49, 1, '2010-06-26 11:00:00', 0, 4, '1A', '2B', 1, 0);
INSERT INTO `#__worldcup_matches` VALUES(50, 1, '2010-06-26 15:30:00', 0, 3, '1C', '2D', 1, 0);
INSERT INTO `#__worldcup_matches` VALUES(51, 1, '2010-06-27 11:00:00', 0, 2, '1D', '2C', 1, 0);
INSERT INTO `#__worldcup_matches` VALUES(52, 1, '2010-06-27 15:30:00', 0, 1, '1B', '2A', 1, 0);
INSERT INTO `#__worldcup_matches` VALUES(53, 1, '2010-06-28 11:00:00', 0, 5, '1E', '2F', 1, 0);
INSERT INTO `#__worldcup_matches` VALUES(54, 1, '2010-06-28 15:30:00', 0, 1, '1G', '2H', 1, 0);
INSERT INTO `#__worldcup_matches` VALUES(55, 1, '2010-06-29 11:00:00', 0, 8, '1F', '2E', 1, 0);
INSERT INTO `#__worldcup_matches` VALUES(56, 1, '2010-06-29 15:30:00', 0, 6, '1H', '2G', 1, 0);
INSERT INTO `#__worldcup_matches` VALUES(57, 1, '2010-07-02 11:00:00', 0, 4, 'W53', 'W54', 2, 0);
INSERT INTO `#__worldcup_matches` VALUES(58, 1, '2010-07-02 15:30:00', 0, 1, 'W49', 'W50', 2, 0);
INSERT INTO `#__worldcup_matches` VALUES(59, 1, '2010-07-03 11:00:00', 0, 6, 'W52', 'W51', 2, 0);
INSERT INTO `#__worldcup_matches` VALUES(60, 1, '2010-07-03 15:30:00', 0, 1, 'W55', 'W56', 2, 0);
INSERT INTO `#__worldcup_matches` VALUES(61, 1, '2010-07-06 15:30:00', 0, 6, 'W58', 'W57', 3, 0);
INSERT INTO `#__worldcup_matches` VALUES(62, 1, '2010-07-07 15:30:00', 0, 5, 'W59', 'W60', 3, 0);
INSERT INTO `#__worldcup_matches` VALUES(63, 1, '2010-07-10 15:30:00', 0, 4, 'L61', 'L62', 4, 0);
INSERT INTO `#__worldcup_matches` VALUES(64, 1, '2010-07-11 15:30:00', 0, 1, 'W61', 'W62', 5, 0);
INSERT INTO `#__worldcup_matches` VALUES(65, 2, '2011-07-01 21:45:00', 1, 14, '34', '35', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(66, 2, '2011-07-02 15:30:00', 1, 15, '36', '37', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(67, 2, '2011-07-03 16:00:00', 2, 14, '38', '39', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(68, 2, '2011-07-03 18:30:00', 2, 17, '39', '40', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(69, 2, '2011-07-04 19:15:00', 3, 13, '44', '45', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(70, 2, '2011-07-04 21:45:00', 3, 13, '42', '43', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(71, 2, '2011-07-06 21:45:00', 1, 17, '34', '36', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(72, 2, '2011-07-07 19:15:00', 1, 14, '35', '37', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(73, 2, '2011-07-09 16:00:00', 2, 12, '38', '39', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(74, 2, '2011-07-09 18:30:00', 2, 11, '40', '41', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(75, 2, '2011-07-08 19:15:00', 3, 16, '44', '43', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(76, 2, '2011-07-08 21:45:00', 3, 16, '45', '42', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(77, 2, '2011-07-10 16:00:00', 1, 8, '36', '35', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(78, 2, '2011-07-11 21:45:00', 1, 12, '34', '37', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(79, 2, '2011-07-13 19:15:00', 2, 11, '39', '40', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(80, 2, '2011-07-13 21:45:00', 2, 12, '38', '41', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(81, 2, '2011-07-12 19:15:00', 3, 16, '42', '44', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(82, 2, '2011-07-12 21:45:00', 3, 14, '45', '43', 0, 0);
INSERT INTO `#__worldcup_matches` VALUES(83, 2, '2011-07-16 16:00:00', 0, 12, '1A', '13', 1, 0);
INSERT INTO `#__worldcup_matches` VALUES(84, 2, '2011-07-16 19:15:00', 0, 17, '2A', '2C', 1, 0);
INSERT INTO `#__worldcup_matches` VALUES(85, 2, '2011-07-17 16:00:00', 0, 14, '1B', '23', 1, 0);
INSERT INTO `#__worldcup_matches` VALUES(86, 2, '2011-07-17 19:15:00', 0, 13, '1C', '2B', 1, 0);
INSERT INTO `#__worldcup_matches` VALUES(87, 2, '2011-07-19 21:45:00', 0, 14, 'W19', 'W20', 2, 0);
INSERT INTO `#__worldcup_matches` VALUES(88, 2, '2011-07-20 21:45:00', 0, 16, 'W21', 'W22', 2, 0);
INSERT INTO `#__worldcup_matches` VALUES(89, 2, '2011-07-23 16:00:00', 0, 14, 'L23', 'L24', 3, 0);
INSERT INTO `#__worldcup_matches` VALUES(90, 2, '2011-07-24 16:00:00', 0, 10, 'W23', 'W24', 4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `#__worldcup_places`
--

CREATE TABLE IF NOT EXISTS `#__worldcup_places` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `checked_out` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `#__worldcup_places`
--

INSERT INTO `#__worldcup_places` VALUES(1, 1, 'Johannesburgo', 0);
INSERT INTO `#__worldcup_places` VALUES(2, 1, 'Mangaung/Bloemfontein', 0);
INSERT INTO `#__worldcup_places` VALUES(3, 1, 'Rustenburgo', 0);
INSERT INTO `#__worldcup_places` VALUES(4, 1, 'Puerto Elizabeth', 0);
INSERT INTO `#__worldcup_places` VALUES(5, 1, 'Durban', 0);
INSERT INTO `#__worldcup_places` VALUES(6, 1, 'Ciudad del Cabo', 0);
INSERT INTO `#__worldcup_places` VALUES(7, 1, 'Polokwane', 0);
INSERT INTO `#__worldcup_places` VALUES(8, 1, 'Tshwane/Pretoria', 0);
INSERT INTO `#__worldcup_places` VALUES(9, 1, 'Nelspruit', 0);
INSERT INTO `#__worldcup_places` VALUES(10, 2, 'Buenos Aires', 0);
INSERT INTO `#__worldcup_places` VALUES(11, 2, 'Salta', 0);
INSERT INTO `#__worldcup_places` VALUES(12, 2, 'Cordoba', 0);
INSERT INTO `#__worldcup_places` VALUES(13, 2, 'San Juan', 0);
INSERT INTO `#__worldcup_places` VALUES(14, 2, 'La Plata', 0);
INSERT INTO `#__worldcup_places` VALUES(15, 2, 'San Salvador de Jujuy', 0);
INSERT INTO `#__worldcup_places` VALUES(16, 2, 'Mendoza', 0);
INSERT INTO `#__worldcup_places` VALUES(17, 2, 'Santa Fe', 0);

-- --------------------------------------------------------

--
-- Table structure for table `#__worldcup_results`
--

CREATE TABLE IF NOT EXISTS `#__worldcup_results` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL,
  `mid` int(11) NOT NULL,
  `local` int(11) NOT NULL,
  `visit` int(11) NOT NULL,
  `team1` int(11) NOT NULL,
  `team2` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Table structure for table `#__worldcup_score`
--

CREATE TABLE IF NOT EXISTS `#__worldcup_score` (
  `tid` int(11) NOT NULL,
  `uid` int(11) NOT NULL DEFAULT '0',
  `points` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `#__worldcup_teams`
--

CREATE TABLE IF NOT EXISTS `#__worldcup_teams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `group` int(11) NOT NULL,
  `flag` int(11) NOT NULL,
  `checked_out` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=46 ;

--
-- Dumping data for table `#__worldcup_teams`
--

INSERT INTO `#__worldcup_teams` VALUES(1, 1, 'Sudáfrica ', 1, 0, 0);
INSERT INTO `#__worldcup_teams` VALUES(2, 1, 'México', 1, 0, 0);
INSERT INTO `#__worldcup_teams` VALUES(3, 1, 'Uruguay', 1, 0, 0);
INSERT INTO `#__worldcup_teams` VALUES(4, 1, 'Francia', 1, 0, 0);
INSERT INTO `#__worldcup_teams` VALUES(5, 1, 'Corea del Sur', 2, 0, 0);
INSERT INTO `#__worldcup_teams` VALUES(6, 1, 'Grecia', 2, 0, 0);
INSERT INTO `#__worldcup_teams` VALUES(7, 1, 'Argentina', 2, 0, 0);
INSERT INTO `#__worldcup_teams` VALUES(8, 1, 'Nigeria', 2, 0, 0);
INSERT INTO `#__worldcup_teams` VALUES(9, 1, 'Inglaterra', 3, 0, 0);
INSERT INTO `#__worldcup_teams` VALUES(10, 1, 'E.E.U.U', 3, 0, 0);
INSERT INTO `#__worldcup_teams` VALUES(11, 1, 'Argelia', 3, 0, 0);
INSERT INTO `#__worldcup_teams` VALUES(12, 1, 'Eslovenia', 3, 0, 0);
INSERT INTO `#__worldcup_teams` VALUES(13, 1, 'Serbia', 4, 0, 0);
INSERT INTO `#__worldcup_teams` VALUES(14, 1, 'Ghana', 4, 0, 0);
INSERT INTO `#__worldcup_teams` VALUES(15, 1, 'Alemania', 4, 0, 0);
INSERT INTO `#__worldcup_teams` VALUES(16, 1, 'Australia', 4, 0, 0);
INSERT INTO `#__worldcup_teams` VALUES(17, 1, 'Holanda', 5, 0, 0);
INSERT INTO `#__worldcup_teams` VALUES(18, 1, 'Dinamarca', 5, 0, 0);
INSERT INTO `#__worldcup_teams` VALUES(19, 1, 'Japón', 5, 0, 0);
INSERT INTO `#__worldcup_teams` VALUES(20, 1, 'Camerún', 5, 0, 0);
INSERT INTO `#__worldcup_teams` VALUES(21, 1, 'Italia', 6, 0, 0);
INSERT INTO `#__worldcup_teams` VALUES(22, 1, 'Paraguay', 6, 0, 0);
INSERT INTO `#__worldcup_teams` VALUES(23, 1, 'Nueva Zelanda', 6, 0, 0);
INSERT INTO `#__worldcup_teams` VALUES(24, 1, 'Eslovaquia', 6, 0, 0);
INSERT INTO `#__worldcup_teams` VALUES(25, 1, 'Costa de Marfil', 7, 0, 0);
INSERT INTO `#__worldcup_teams` VALUES(26, 1, 'Portugal', 7, 0, 0);
INSERT INTO `#__worldcup_teams` VALUES(27, 1, 'Brasil', 7, 0, 0);
INSERT INTO `#__worldcup_teams` VALUES(28, 1, 'Corea del Norte', 7, 0, 0);
INSERT INTO `#__worldcup_teams` VALUES(29, 1, 'Honduras', 8, 0, 0);
INSERT INTO `#__worldcup_teams` VALUES(30, 1, 'Chile', 8, 0, 0);
INSERT INTO `#__worldcup_teams` VALUES(31, 1, 'España', 8, 0, 0);
INSERT INTO `#__worldcup_teams` VALUES(32, 1, 'Suiza', 8, 0, 0);
INSERT INTO `#__worldcup_teams` VALUES(34, 2, 'Argentina', 1, 0, 0);
INSERT INTO `#__worldcup_teams` VALUES(35, 2, 'Bolivia', 1, 0, 0);
INSERT INTO `#__worldcup_teams` VALUES(36, 2, 'Colombia', 1, 0, 0);
INSERT INTO `#__worldcup_teams` VALUES(37, 2, 'Japon', 1, 0, 0);
INSERT INTO `#__worldcup_teams` VALUES(38, 2, 'Brasil', 2, 0, 0);
INSERT INTO `#__worldcup_teams` VALUES(39, 2, 'Paraguay', 2, 0, 0);
INSERT INTO `#__worldcup_teams` VALUES(40, 2, 'Venezuela', 2, 0, 0);
INSERT INTO `#__worldcup_teams` VALUES(41, 2, 'Ecuador', 2, 0, 0);
INSERT INTO `#__worldcup_teams` VALUES(42, 2, 'Chile', 3, 0, 0);
INSERT INTO `#__worldcup_teams` VALUES(43, 2, 'Mexico', 3, 0, 0);
INSERT INTO `#__worldcup_teams` VALUES(44, 2, 'Peru', 3, 0, 0);
INSERT INTO `#__worldcup_teams` VALUES(45, 2, 'Uruguay', 3, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `#__worldcup_tournaments`
--

CREATE TABLE IF NOT EXISTS `#__worldcup_tournaments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `place` varchar(255) NOT NULL,
  `mode` int(1) NOT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  `checked_out` int(11) NOT NULL,
  `enabled` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `#__worldcup_tournaments`
--

INSERT INTO `#__worldcup_tournaments` VALUES(1, 'World Cup 2010', 'South Africa', 1, '0000-00-00', '0000-00-00', '0000-00-00', 0);
INSERT INTO `#__worldcup_tournaments` VALUES(2, 'Copa America 2011', 'Argentina', 2, '0000-00-00', '0000-00-00', '0000-00-00', 0);
INSERT INTO `#__worldcup_tournaments` VALUES(3, 'World Cup 2014', 'Brazil', 1, '0000-00-00', '0000-00-00', '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `#__worldcup_users`
--

CREATE TABLE IF NOT EXISTS `#__worldcup_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payed` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `#__worldcup_users`
--
