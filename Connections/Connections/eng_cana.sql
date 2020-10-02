-- phpMyAdmin SQL Dump
-- version 4.5.3.1
-- http://www.phpmyadmin.net
--
-- Host: 179.188.16.208
-- Generation Time: Aug 16, 2017 at 04:07 PM
-- Server version: 5.6.33-79.0-log
-- PHP Version: 5.6.30-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eng_cana`
--

-- --------------------------------------------------------

--
-- Table structure for table `agenda_eventos`
--

CREATE TABLE `agenda_eventos` (
  `id_evento` int(11) NOT NULL,
  `nome_evento` varchar(35) COLLATE latin1_general_ci NOT NULL,
  `data_evento` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `hora_evento` varchar(5) COLLATE latin1_general_ci NOT NULL,
  `descri_evento` text COLLATE latin1_general_ci NOT NULL,
  `local_evento` varchar(150) COLLATE latin1_general_ci NOT NULL,
  `end_evento` varchar(150) COLLATE latin1_general_ci NOT NULL,
  `data_cadastro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_evento` varchar(50) COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `depo_cliente`
--

CREATE TABLE `depo_cliente` (
  `id_depo` int(11) NOT NULL,
  `nome_depo` varchar(35) COLLATE latin1_general_ci NOT NULL,
  `email_depo` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `depo_categ` varchar(35) COLLATE latin1_general_ci NOT NULL,
  `depoimento` text COLLATE latin1_general_ci NOT NULL,
  `usu_cadastro` varchar(35) COLLATE latin1_general_ci NOT NULL,
  `data_cadastro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_feeds`
--

CREATE TABLE `email_feeds` (
  `id_email` int(11) NOT NULL,
  `ass_email` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `ass_data` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usu_admin`
--

CREATE TABLE `usu_admin` (
  `id_usu` int(11) NOT NULL,
  `usu_nome` varchar(35) COLLATE latin1_general_ci NOT NULL,
  `usu_senha` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `usu_data` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usu_email` varchar(50) COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `usu_admin`
--

INSERT INTO `usu_admin` (`id_usu`, `usu_nome`, `usu_senha`, `usu_data`, `usu_email`) VALUES
(1, 'Admin', 'adadbecf01430ef3c06e35d34dc16dae3ab04b1a', '2017-07-24 19:00:36', 'contato@engenhodacana.com.br'),
(2, 'WebMaster', '2b2f903f7109146e87e1afdc5e2ec42c205dd206', '2017-07-24 18:25:59', 'webmaster@cachacaengenhodacana.com.br');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agenda_eventos`
--
ALTER TABLE `agenda_eventos`
  ADD PRIMARY KEY (`id_evento`),
  ADD UNIQUE KEY `nome_evento` (`nome_evento`);

--
-- Indexes for table `depo_cliente`
--
ALTER TABLE `depo_cliente`
  ADD PRIMARY KEY (`id_depo`);

--
-- Indexes for table `email_feeds`
--
ALTER TABLE `email_feeds`
  ADD PRIMARY KEY (`id_email`),
  ADD UNIQUE KEY `ass_email` (`ass_email`);

--
-- Indexes for table `usu_admin`
--
ALTER TABLE `usu_admin`
  ADD PRIMARY KEY (`id_usu`),
  ADD UNIQUE KEY `usu_nome` (`usu_nome`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agenda_eventos`
--
ALTER TABLE `agenda_eventos`
  MODIFY `id_evento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `depo_cliente`
--
ALTER TABLE `depo_cliente`
  MODIFY `id_depo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `email_feeds`
--
ALTER TABLE `email_feeds`
  MODIFY `id_email` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `usu_admin`
--
ALTER TABLE `usu_admin`
  MODIFY `id_usu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
