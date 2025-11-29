-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Tempo de geração: 29/11/2025 às 22:28
-- Versão do servidor: 8.0.43
-- Versão do PHP: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `pi2_db`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `Concessionaria`
--

CREATE TABLE `Concessionaria` (
  `concessionaria_id` int NOT NULL,
  `nome_concessionaria` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `Concessionaria`
--

INSERT INTO `Concessionaria` (`concessionaria_id`, `nome_concessionaria`) VALUES
(2, 'Certel'),
(3, 'RGE Sul'),
(4, 'CEE Equatorial'),
(5, 'Coopernorte');

-- --------------------------------------------------------

--
-- Estrutura para tabela `config_custos_kit`
--

CREATE TABLE `config_custos_kit` (
  `id` int NOT NULL,
  `chave` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `valor` decimal(10,2) NOT NULL DEFAULT '0.00',
  `descricao` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `atualizado_em` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `config_custos_kit`
--

INSERT INTO `config_custos_kit` (`id`, `chave`, `valor`, `descricao`, `atualizado_em`) VALUES
(1, 'mao_obra_por_placa', 450.00, 'Custo mão de obra por placa', '2025-11-22 17:51:43'),
(2, 'custo_cabos', 50.00, 'Custo cabos', '2025-11-19 23:20:30'),
(4, 'custo_conectores', 40.00, 'Custo conectores', '2025-11-19 11:30:33'),
(5, 'custos_fixos', 500.00, 'Custos fixos', '2025-11-19 23:18:44'),
(6, 'porcentagem_comissao', 5.00, 'Porcentagem Comissão', '2025-11-19 23:19:05');

-- --------------------------------------------------------

--
-- Estrutura para tabela `Fase`
--

CREATE TABLE `Fase` (
  `fase_id` int NOT NULL,
  `tipo_fase` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `Fase`
--

INSERT INTO `Fase` (`fase_id`, `tipo_fase`) VALUES
(2, 'Bifásico'),
(3, 'Monofásico'),
(4, 'Trifásico');

-- --------------------------------------------------------

--
-- Estrutura para tabela `Inversor`
--

CREATE TABLE `Inversor` (
  `inversor_id` int NOT NULL,
  `marca_inversor` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `potencia_inversor` int NOT NULL,
  `valor_inversor` float NOT NULL,
  `nome_inversor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo_inversor` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `eficiencia` decimal(5,2) DEFAULT NULL,
  `fase` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `entradas` int DEFAULT NULL,
  `mppt` int DEFAULT NULL,
  `overload` int DEFAULT NULL,
  `ativo` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `Inversor`
--

INSERT INTO `Inversor` (`inversor_id`, `marca_inversor`, `potencia_inversor`, `valor_inversor`, `nome_inversor`, `tipo_inversor`, `eficiencia`, `fase`, `entradas`, `mppt`, `overload`, `ativo`) VALUES
(3, 'Solis', 3, 1930, 'INVERSOR SOLIS 3 KW MONO 220V ', 'STRING', 97.10, 'Monofasico', 1, 1, 140, 1),
(4, 'SOLIS', 15, 6750, 'INVERSOR SOLIS 15K TRIF 380V ', 'STRING', 98.60, 'Trifasico', 2, 2, 140, 1),
(5, 'SOLIS', 15, 8999, 'INVERSOR SOLIS 15 KW TRIF  220V ', 'STRING', 97.80, 'Trifasico', 2, 3, 140, 1),
(6, 'GROWATT', 30, 8450, 'INVERSOR GROWATT 30 KW TRIF 380V', 'STRING', 98.70, 'Trifasico', 2, 2, 140, 1),
(7, 'GROWATT', 36, 8780, 'INVERSOR GROWATT 36 KW TRIF 380V', 'STRING', 97.35, 'Trifasico', 3, 3, 140, 1),
(8, 'GROWATT', 25, 9700, 'INVERSOR GROWATT 25 KW TRIF 220V', 'STRING', 98.40, 'Trifasico', 3, 2, 140, 1),
(9, 'SOLIS', 25, 9350, 'INVERSOR SOLIS 25 KW TRIF 380V ', 'STRING', 98.60, 'Trifasico', 3, 2, 140, 1),
(10, 'SOLIS', 25, 12700, 'INVERSOR SOLIS 25 KW TRIF 220V ', 'STRING', 98.60, 'Trifasico', 4, 2, 140, 1),
(11, 'SOLIS', 6, 3050, 'INVERSOR SOLIS 6 KW  220V ', 'STRING', 97.70, 'Monofasico', 2, 2, 140, 1),
(12, 'GROWATT', 5, 2600, 'INVERSOR GROWATT 5 KW 220V ', 'STRING', 97.70, 'Monofasico', 2, 2, 140, 1),
(13, 'GROWATT', 5, 3070, 'INVERSOR GROWATT 5 KW MONO 220V', 'STRING', 97.10, 'Monofasico', 1, 1, 160, 1),
(14, 'Chint', 2, 980, 'INVERSOR GROWATT 1,5 KW MONO 220V', 'STRING', 97.80, 'Monofasico', 1, 1, 140, 0),
(15, 'Chint', 2, 990, 'INVERSOR GROWATT 2 KW MONO 220V', 'STRING', 97.80, 'Monofasico', 1, 1, 140, 0),
(16, 'GROWATT', 3, 1300, 'INVERSOR GROWATT 2,5 KW MONO 220V', 'STRING', 97.70, 'Monofasico', 2, 2, 140, 1),
(17, 'GROWATT', 8, 3400, 'INVERSOR GROWATT 8 KW MONO 220V', 'STRING', 97.70, 'Monofasico', 2, 2, 140, 1),
(18, 'GROWATT', 10, 5100, 'INVERSOR GROWATT 10 KW MONO 220V', 'STRING', 97.00, 'Monofasico', 4, 4, 140, 1),
(19, 'GROWATT', 25, 5650, 'INVERSOR GROWATT 25 KW TRIF 380V', 'STRING', 97.80, 'Trifasico', 1, 1, 140, 1),
(20, 'GROWATT', 20, 5600, 'INVERSOR GROWATT 20 KW TRIF 380V', 'STRING', 97.80, 'Trifasico', 1, 1, 140, 1),
(21, 'GROWATT', 15, 6484, 'INVERSOR GROWATT 15 KW TRIF 380V', 'STRING', 97.30, 'Trifasico', 3, 3, 140, 1),
(22, 'GROWATT', 15, 7600, 'INVERSOR GROWATT 15 KW TRIF 220V', 'STRING', 97.80, 'Trifasico', 1, 1, 140, 1),
(23, 'SOLIS', 60, 15500, 'INVERSOR SOLIS 60 KW  TRIF 380V ', 'STRING', 97.50, 'Trifasico', 4, 4, 140, 1),
(24, 'SOLIS', 50, 15700, 'INVERSOR SOLIS 50 KW TRIF 380V ', 'STRING', 98.50, 'Trifasico', 4, 4, 140, 1),
(25, 'CHINT', 3, 2200, 'INVERSOR CHINT ON GRID MONO 3 KW ', 'STRING', 97.80, 'Monofasico', 1, 1, 160, 1),
(26, 'SOLIS', 4, 2670, 'INVERSOR SOLIS 4 KW MONO 220V ', 'STRING', 97.60, 'Monofasico', 2, 2, 140, 1),
(27, 'SOLIS', 75, 20000, 'INVERSOR SOLIS 75 KW TRIF 380V ', 'STRING', 97.90, 'Trifasico', 6, 6, 140, 1),
(28, 'SOLIS', 100, 25000, 'INVERSOR SOLIS 100 kW TRIF 380V ', 'STRING', 96.20, 'Trifasico', 10, 10, 140, 1),
(29, 'GROWATT', 3, 1690, 'INVERSOR GROWATT 3 KW MONO 220V ', 'STRING', 97.70, 'Monofasico', 2, 2, 140, 1),
(30, 'CHINT', 5, 2850, 'INVERSOR CHINT ON GRID MONO 5 KW ', 'STRING', 97.90, 'Monofasico', 2, 1, 160, 1),
(31, 'GROWATT', 6, 3200, 'INVERSOR GROWATT 6 KW MONO 220V ', 'STRING', 97.70, 'Monofasico', 2, 1, 140, 1),
(32, 'CHINT', 6, 3000, 'INVERSOR CHINT ON GRID MONO 6 KW ', 'STRING', 96.20, 'Monofasico', 2, 1, 160, 1),
(33, 'SOLIS', 20, 7350, 'INVERSOR SOLIS 20 KW TRIF 380V ', 'STRING', 97.70, 'Trifasico', 2, 1, 140, 1),
(34, 'SOLIS', 20, 10479, 'INVEROR SOLIS 20 KW TRIF 220V', 'STRING', 96.20, 'Trifasico', 2, 2, 140, 1),
(35, 'SOLIS', 8, 3600, 'INVERSOR SOLIS 8 KW MONO 220V', 'STRING', 97.70, 'Monofasico', 2, 3, 140, 1),
(36, 'CHINT', 8, 3700, 'INVERSOR CHINT ON GRID MONO 7,5 KW ', 'STRING', 97.90, 'Monofasico', 2, 1, 160, 1),
(37, 'SOLIS', 30, 11200, 'INVERSOR SOLIS 30 KW TRIF 380V ', 'STRING', 98.00, 'Trifasico', 3, 3, 140, 1),
(38, 'SOLIS', 10, 4350, 'INVERSOR SOLIS 10 KW MONO 220V ', 'STRING', 97.80, 'Monofasico', 3, 1, 140, 1),
(39, 'SOLIS', 30, 12950, 'INVERSOR SOLIS 30 KW TRIF 220V ', 'STRING', 98.00, 'Trifasico', 3, 3, 140, 1),
(40, 'SOLIS', 12, 7000, 'INVERSOR SOLIS 12 KW TRIF 380V ', 'STRING', 98.60, 'Trifasico', 2, 2, 140, 1),
(41, 'SOLIS', 38, 10200, 'INVERSOR SOLIS 37,5 KW TRIF 380V ', 'STRING', 98.50, 'Trifasico', 2, 2, 140, 1),
(42, 'CHINT', 10, 4000, 'INVERSOR CHINT ON GRID MONO 10 KW ', 'STRING', 98.20, 'Monofasico', 3, 1, 160, 1),
(43, 'GROWATT', 50, 9900, 'INVERSOR GROWATT 50 KW TRIF 380V', 'STRING', 98.70, 'Trifasico', 5, 5, 140, 1),
(44, 'GROWATT', 75, 17810, 'INVERSOR GROWATT 75 KW TRIF 380V', 'STRING', 98.60, 'Trifasico', 7, 7, 140, 1),
(45, 'GROWATT', 60, 16900, 'INVERSOR GROWATT 60 KW TRIF 380V', 'STRING', 98.60, 'Trifasico', 6, 6, 140, 1),
(46, 'GROWATT', 100, 23000, 'INVERSOR GROWATT 100 KW TRIF 380V', 'STRING', 98.70, 'Trifasico', 10, 10, 140, 1),
(47, 'CHINT', 10, 4550, 'INVERSOR CHINT 10 KW TRIF 380V ', 'STRING', 98.70, 'Trifasico', 2, 2, 160, 1),
(48, 'CHINT', 15, 5000, 'INVERSOR CHINT 15 KW TRIF 380V ', 'STRING', 98.70, 'Trifasico', 3, 3, 160, 1),
(49, 'CHINT', 25, 6000, 'INVERSOR CHINT 25 KW TRIF 380V ', 'STRING', 98.70, 'Trifasico', 4, 4, 160, 1),
(50, 'CHINT', 15, 7500, 'INVERSOR CHINT 15 KW TRIF 220V ', 'STRING', 98.70, 'Trifasico', 4, 4, 160, 1),
(51, 'CHINT', 30, 7370, 'INVERSOR CHINT 30 KW TRIF 380V ', 'STRING', 98.70, 'Trifasico', 6, 6, 160, 1),
(52, 'CHINT', 20, 8200, 'INVERSOR CHINT 20 KW TRIF 220V ', 'STRING', 98.70, 'Trifasico', 5, 5, 160, 1),
(53, 'CHINT', 38, 8455, 'INVERSOR CHINT 37,5 KW TRIF 380V ', 'STRING', 98.70, 'Trifasico', 6, 6, 140, 1),
(54, 'CHINT', 60, 11700, 'INVERSOR CHINT 60 KW TRIF 380V ', 'STRING', 98.70, 'Trifasico', 7, 7, 140, 1),
(55, 'CHINT', 25, 9815, 'INVERSOR CHINT 25 KW TRIF 220V ', 'STRING', 98.70, 'Trifasico', 5, 5, 140, 1),
(56, 'CHINT', 75, 19200, 'INVERSOR CHINT 75 KW TRIF 380V ', 'STRING', 98.70, 'Trifasico', 7, 7, 180, 1),
(57, 'Chint', 50, 9990, 'INVERSOR CHINT 50 KW TRIF 380V ', 'STRING', 98.70, 'Trifasico', 6, 6, 140, 1),
(58, 'SAJ', 5, 2800, 'INVERSOR SAJ 5KW MONO 220V', 'STRING', 96.20, 'Monofasico', 2, 1, 140, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `Orcamento`
--

CREATE TABLE `Orcamento` (
  `orcamento_id` int NOT NULL,
  `usuario_id` int NOT NULL,
  `cidade_cliente` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `consumo_mensal_medio` decimal(10,2) DEFAULT NULL,
  `consumo_mensal_json` json DEFAULT NULL,
  `tarifa` decimal(10,4) DEFAULT NULL,
  `potencia_sistema_kwp` decimal(10,2) DEFAULT NULL,
  `quantidade_placas` int NOT NULL,
  `valor_total_custo` decimal(10,2) DEFAULT NULL,
  `margem_aplicada` decimal(5,2) DEFAULT '0.25',
  `tipo_instalacao` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT 'Residencial',
  `fase_id` int DEFAULT NULL,
  `concessionaria_id` int DEFAULT NULL,
  `inversor_id` int DEFAULT NULL,
  `placa_id` int DEFAULT NULL,
  `telhado_id` int DEFAULT NULL,
  `data_criacao` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `valor_total_final` float NOT NULL,
  `producao_estimada` decimal(10,2) DEFAULT NULL,
  `economia_mensal_estimada` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `Orcamento`
--

INSERT INTO `Orcamento` (`orcamento_id`, `usuario_id`, `cidade_cliente`, `consumo_mensal_medio`, `consumo_mensal_json`, `tarifa`, `potencia_sistema_kwp`, `quantidade_placas`, `valor_total_custo`, `margem_aplicada`, `tipo_instalacao`, `fase_id`, `concessionaria_id`, `inversor_id`, `placa_id`, `telhado_id`, `data_criacao`, `valor_total_final`, `producao_estimada`, `economia_mensal_estimada`) VALUES
(1, 2, 'Rolante', 259.75, '[\"220\", \"350\", \"222\", \"333\", \"222\", \"240\", \"220\", \"310\", \"200\", \"250\", \"350\", \"200\"]', 0.8500, 2.93, 5, 1950.00, 0.25, 'Residencial', 2, 2, 25, 2, 1, '2025-11-10 13:41:56', 2437.5, NULL, NULL),
(2, 2, 'Rolante', 259.75, '[\"220\", \"350\", \"222\", \"333\", \"222\", \"240\", \"220\", \"310\", \"200\", \"250\", \"350\", \"200\"]', 0.8500, 2.93, 5, 1950.00, 0.25, 'Residencial', 2, 2, 25, 2, 1, '2025-11-10 13:43:11', 2437.5, NULL, NULL),
(3, 2, 'Rolante', 1302.08, '[\"900\", \"800\", \"100\", \"1200\", \"3000\", \"520\", \"369\", \"2580\", \"2400\", \"1200\", \"1300\", \"1256\"]', 0.8500, 12.29, 21, 5950.00, 0.25, '0', 2, 2, 25, 2, 1, '2025-11-10 13:46:38', 7437.5, NULL, NULL),
(4, 2, 'Rolante', 1875.00, '[\"2500\", \"3000\", \"1000\", \"2100\", \"1200\", \"3200\", \"1200\", \"1400\", \"3200\", \"1000\", \"1200\", \"1500\"]', 0.8500, 17.69, 29, 7950.00, 0.25, 'Comercial', 2, 2, 25, 2, 1, '2025-11-10 14:11:06', 9937.5, 1910.52, 1623.94),
(5, 2, 'Rolante - RS', 250.00, '[\"250\", \"250\", \"250\", \"250\", \"250\", \"250\", \"250\", \"250\", \"250\", \"250\", \"250\", \"250\"]', 0.8500, 250.10, 410, 461770.00, 0.25, 'Residencial', 3, 3, 25, 2, 3, '2025-11-20 00:47:18', 484858, 250.00, 212.50),
(6, 2, 'Rolante - RS', 300.00, '[\"300\", \"300\", \"300\", \"300\", \"300\", \"300\", \"300\", \"300\", \"300\", \"300\", \"300\", \"300\"]', 0.8500, 0.61, 1, 2660.00, 0.05, 'Residencial', 3, 3, 25, 2, 3, '2025-11-20 01:05:44', 2793, 73.20, 62.22),
(7, 2, 'Rolante - RS', 300.00, '[\"300\", \"300\", \"300\", \"300\", \"300\", \"300\", \"300\", \"300\", \"300\", \"300\", \"300\", \"300\"]', 0.8500, 2.44, 4, 7200.00, 0.05, 'Residencial', 3, 3, 25, 2, 3, '2025-11-20 01:36:29', 7560, 334.01, 283.91),
(8, 2, 'Rolante - RS', 350.00, '[\"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\"]', 0.8500, 3.05, 5, 8380.00, 0.05, 'Residencial', 3, 3, 25, 2, 3, '2025-11-20 01:50:06', 8799, 417.51, 354.89),
(9, 2, 'Rolante - RS', 350.00, '[\"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\"]', 0.8500, 3.05, 5, 8380.00, 0.05, 'Residencial', 3, 3, 25, 2, 3, '2025-11-22 14:07:50', 8799, 417.51, 354.89),
(10, 2, 'Rolante - RS', 350.00, '[\"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\"]', 0.8500, 3.05, 5, 8380.00, 0.05, 'Residencial', 3, 3, 25, 2, 3, '2025-11-22 14:17:06', 8799, 417.51, 354.89),
(11, 2, 'Rolante - RS', 350.00, '[\"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\"]', 0.8500, 3.05, 5, 8380.00, 0.05, 'Residencial', 3, 3, 25, 2, 3, '2025-11-22 14:23:27', 8799, 417.51, 354.89),
(12, 2, 'Rolante - RS', 350.00, '[\"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\"]', 0.8500, 3.05, 5, 8380.00, 0.05, 'Residencial', 3, 3, 25, 2, 3, '2025-11-22 14:34:28', 8799, 417.51, 354.89),
(13, 2, 'Rolante - RS', 350.00, '[\"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\"]', 0.8500, 3.05, 5, 8380.00, 0.05, 'Residencial', 3, 3, 25, 2, 3, '2025-11-22 14:35:09', 8799, 417.51, 354.89),
(14, 2, 'Rolante - RS', 350.00, '[\"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\"]', 0.8500, 6.10, 10, 14620.00, 0.05, 'Residencial', 3, 3, 30, 2, 3, '2025-11-22 14:48:42', 15351, 835.03, 709.77),
(15, 2, 'Rolante - RS', 350.00, '[\"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\"]', 0.8500, 4.27, 7, 11260.00, 0.05, 'Residencial', 3, 3, 30, 2, 3, '2025-11-22 15:06:27', 11823, 584.52, 496.84),
(16, 2, 'Rolante - RS', 350.00, '[\"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\"]', 0.8500, 8.54, 14, 19970.00, 0.05, 'Residencial', 3, 3, 36, 2, 3, '2025-11-22 15:10:29', 20968.5, 1169.04, 993.68),
(17, 5, '', 300.08, '[\"350\", \"400\", \"320\", \"280\", \"240\", \"275\", \"300\", \"280\", \"252\", \"271\", \"283\", \"350\"]', 0.8500, 2.44, 4, 6020.00, 0.05, 'Residencial', 3, 3, 14, 2, 1, '2025-11-26 11:37:02', 6321, 334.01, 283.91),
(18, 5, 'Taquara - RS', 300.08, '[\"350\", \"400\", \"320\", \"280\", \"240\", \"275\", \"300\", \"280\", \"252\", \"271\", \"283\", \"350\"]', 0.8500, 2.44, 4, 6020.00, 0.05, 'Residencial', 3, 3, 14, 2, 1, '2025-11-26 12:24:03', 6321, 334.01, 283.91),
(19, 5, 'Taquara - RS', 300.08, '[\"350\", \"400\", \"320\", \"280\", \"240\", \"275\", \"300\", \"280\", \"252\", \"271\", \"283\", \"350\"]', 0.8500, 4.88, 8, 12180.00, 0.05, 'Residencial', 3, 3, 12, 2, 1, '2025-11-26 12:31:49', 12789, 668.02, 567.82),
(20, 5, 'Taquara - RS', 300.08, '[\"350\", \"400\", \"320\", \"280\", \"240\", \"275\", \"300\", \"280\", \"252\", \"271\", \"283\", \"350\"]', 0.8500, 2.44, 4, 6340.00, 0.05, 'Residencial', 3, 3, 16, 2, 1, '2025-11-26 13:10:52', 6657, 334.01, 283.91),
(21, 2, 'Rolante - RS', 350.00, '[\"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\", \"350\"]', 0.8500, 6.71, 11, 16020.00, 0.05, 'Residencial', 3, 3, 32, 2, 3, '2025-11-28 12:15:48', 16821, 918.53, 780.75),
(22, 11, 'Novo Hamburgo - RS', 1247.50, '[\"1000\", \"100\", \"2500\", \"1200\", \"1100\", \"1300\", \"1200\", \"1500\", \"1150\", \"1200\", \"1320\", \"1400\"]', 0.8500, 9.76, 16, 24280.00, 0.05, 'Residencial', 4, 3, 36, 2, 5, '2025-11-28 12:35:19', 25494, 1336.05, 1135.64),
(23, 11, 'Novo Hamburgo - RS', 1247.50, '[\"1000\", \"100\", \"2500\", \"1200\", \"1100\", \"1300\", \"1200\", \"1500\", \"1150\", \"1200\", \"1320\", \"1400\"]', 0.8500, 6.71, 11, 17340.00, 0.05, 'Residencial', 4, 3, 32, 2, 5, '2025-11-28 13:19:25', 18207, 918.53, 780.75);

-- --------------------------------------------------------

--
-- Estrutura para tabela `Placa`
--

CREATE TABLE `Placa` (
  `placa_id` int NOT NULL,
  `marca_placa` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `potencia_placa` int NOT NULL,
  `valor_placa` float NOT NULL,
  `ativo` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `Placa`
--

INSERT INTO `Placa` (`placa_id`, `marca_placa`, `potencia_placa`, `valor_placa`, `ativo`) VALUES
(2, 'Sunova', 610, 500, 1),
(3, 'TSUN', 570, 470, 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `projeto`
--

CREATE TABLE `projeto` (
  `projeto_id` int NOT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cidade` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantidade_placas` int DEFAULT NULL,
  `placa_id` int DEFAULT NULL,
  `inversor_id` int DEFAULT NULL,
  `economia` decimal(10,2) DEFAULT NULL,
  `conclusao` date DEFAULT NULL,
  `tipo` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `caracteristica` text COLLATE utf8mb4_unicode_ci,
  `imagem` mediumblob,
  `data_criacao` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `projeto`
--

INSERT INTO `projeto` (`projeto_id`, `titulo`, `cidade`, `quantidade_placas`, `placa_id`, `inversor_id`, `economia`, `conclusao`, `tipo`, `caracteristica`, `imagem`, `data_criacao`) VALUES
(3, 'Sistema solar de 29,64kWp', 'Rolante - RS', 52, 3, 55, 2500.00, '2025-01-29', 'Industrial', 'Limpo', 0x363931343965396565313963372e6a7067, '2025-11-12 14:50:06'),
(4, 'Sistema solar de 5,13kWp', 'Rolante - RS', 9, 3, 30, 400.00, '2025-01-20', 'Residencial', 'Amigo do meio ambiente', 0x363932303636633566326166612e6a7067, '2025-11-21 13:19:02'),
(6, 'Sistema solar de 7,41Kwp', 'Gravataí - RS', 13, 3, 32, 750.00, '2024-02-12', 'Residencial', 'Econômico', 0x363932303664353061613738642e6a7067, '2025-11-21 13:46:56'),
(8, 'Sistema solar de 4,56kWp', 'Riozinho - RS', 8, 3, 30, 330.00, '2025-04-03', 'Residencial', 'Limpo', 0x363932373039613135373264662e6a7067, '2025-11-26 14:07:29'),
(9, 'Sistema solar de 5,49kWp', 'Rolante - RS', 9, 2, 30, 350.00, '2025-09-20', 'Residencial', 'Sustentável', 0x363932373039643534313935342e706e67, '2025-11-26 14:08:21'),
(10, 'Sistema solar de 18,30kWp', 'Barão - RS', 30, 2, 50, 2500.00, '2025-06-15', 'Industrial', 'Econômico', 0x363932373063396331666636612e706e67, '2025-11-26 14:20:12'),
(11, 'Sistema solar de 15,59kWp', 'Novo Hamburgo - RS', 19, 2, 36, 1400.00, '2025-07-12', 'Residencial', 'Limpo', 0x363932373064333365373235662e706e67, '2025-11-26 14:22:44');

-- --------------------------------------------------------

--
-- Estrutura para tabela `Telhado`
--

CREATE TABLE `Telhado` (
  `telhado_id` int NOT NULL,
  `tipo_telhado` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto_telhado` blob NOT NULL,
  `valor` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `Telhado`
--

INSERT INTO `Telhado` (`telhado_id`, `tipo_telhado`, `foto_telhado`, `valor`) VALUES
(1, 'Telha Cerâmica', 0x363866306636376234396564322e6a706567, 150.00),
(3, 'Telha Fibrocimento', 0x363931623033656165313964382e6a7067, 150.00),
(4, 'Laje', 0x363931623130313535303931362e77656270, 260.00),
(5, 'Solo', 0x363931623130366537383736372e6a7067, 270.00),
(6, 'Metálico', 0x363931623130616663373333392e77656270, 90.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `Usuario`
--

CREATE TABLE `Usuario` (
  `usuario_id` int NOT NULL,
  `nome_usuario` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefone_usuario` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_usuario` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `senha_usuario` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_usuario` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `Usuario`
--

INSERT INTO `Usuario` (`usuario_id`, `nome_usuario`, `telefone_usuario`, `email_usuario`, `senha_usuario`, `tipo_usuario`) VALUES
(1, 'Administrador', '51999034563', 'janjulia401@gmail.com', '$2y$10$TpvJkKiZGgAwq.Fmyj2LVOHc6FZf4.PP48Z2ZVl2N.vM.15/momce', 1),
(2, 'Julia Sperb Schmidt', '999034563', 'juliasperbschmidt@gmail.com', '$2y$10$xPi6XksdeAR7CZE43WJuZuc0oiHdPtnNhrlNsfhSygpABHcUy9xzO', 0),
(3, 'Julia Sperb Schmidt', '999034563', 'janjulia401@gmail.com', '$2y$10$A93WSydzLIdkJQm2wPW2xuAKLoIe2F/wCylNd9YjZgbHwqB4biozy', 0),
(4, 'Julia Sperb Schmidt', '999034563', 'janjulia401@gmail.com', '$2y$10$0y2GeyOJ/j4PQO/yxrfDYOmTFVqZKxUHoXLCLq.uGhqimpW767Pv6', 0),
(5, 'JANICE CLARICE SPERB', '51995566346', 'janice.spb2@gmail.com', '$2y$10$EdvY66LfYoYG/RpQ3KehDekAL8jLqliGGcbr0Jo/.cwkhrKR4GOzC', 0),
(6, 'Daniel Schmidt', '51999466563', 'danielricardoschimidt@gmail.com', '$2y$10$Y253l4xRspfqKBDgmpAVAeNZ9KfSEG3L.mJ3YtQU7MvOo8IwakzhO', 0),
(7, 'Vini Sperb', '51998885522', 'vinisperb@gmail.com', '$2y$10$pdzdvZmAz2G6tdcBvybvi.BwNYc16iHJmYC7mKYo5TS9aJU5lveFu', 0),
(8, 'Julia Sperb Schmidt', '51999034564', 'janjulia@gmail.com', '$2y$10$.404o5Osgnbu/DsSThpaKu6FhqnqyTSGXvziQEdQUq2ig.1u/y0VW', 0),
(9, 'Julia Sperb Schmidt', '51999999911', 'julia@gmail.com', '$2y$10$hw3PSVXADCAukMfAgeZ7ue2ppqapB02evUvwMdpfhrHPrRW49aT1y', 0),
(10, 'Julia Sperb Schmidt', '55999034562', 'janjulia11@gmail.com', '$2y$10$VW0dCG8KNJ5j8fDvxuMf.uu5JhcyFbMNYHAh.R2a03kPk4JssKRrO', 0),
(11, 'teste', '51995565555', 'teste@gmail.com', '$2y$10$GnMXzazYqKLKGvtgdTM0VOeeN6RCaSdjNhVg0X2iYsxppfLMHqv3q', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `Vendedor`
--

CREATE TABLE `Vendedor` (
  `vendedor_id` int NOT NULL,
  `nome_vendedor` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cargo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descricao` text COLLATE utf8mb4_unicode_ci,
  `telefone_vendedor` char(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link_vendedor` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto_vendedor` blob
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `Vendedor`
--

INSERT INTO `Vendedor` (`vendedor_id`, `nome_vendedor`, `cargo`, `descricao`, `telefone_vendedor`, `link_vendedor`, `foto_vendedor`) VALUES
(1, 'Julia Sperb Schmidt', 'Vendedora Interna', 'Especialista em garantir maior comodidade aos clientes e eficiência em cada projeto', '51999034563', 'https://wa.me/5551999034563', 0x363866383162373864323039332e4a5047),
(3, 'Jonathan Kirsch', 'CEO e Vendedor Interno', 'Em busca da excelência e oferecer o melhor aos clientes', '51995622598', 'https://wa.me/5551995622598', 0x363932366637353131373333652e706e67),
(4, 'MK Energia Solar', 'Empresa', 'Atendimento com excelência', '51998224220', 'https://wa.me/5551998224220', 0x363932366638336138373839302e6a7067);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `Concessionaria`
--
ALTER TABLE `Concessionaria`
  ADD PRIMARY KEY (`concessionaria_id`);

--
-- Índices de tabela `config_custos_kit`
--
ALTER TABLE `config_custos_kit`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `chave` (`chave`);

--
-- Índices de tabela `Fase`
--
ALTER TABLE `Fase`
  ADD PRIMARY KEY (`fase_id`);

--
-- Índices de tabela `Inversor`
--
ALTER TABLE `Inversor`
  ADD PRIMARY KEY (`inversor_id`);

--
-- Índices de tabela `Orcamento`
--
ALTER TABLE `Orcamento`
  ADD PRIMARY KEY (`orcamento_id`),
  ADD KEY `fk_orcamento_usuario` (`usuario_id`),
  ADD KEY `fk_orcamento_fase` (`fase_id`),
  ADD KEY `fk_orcamento_concessionaria` (`concessionaria_id`),
  ADD KEY `fk_orcamento_inversor` (`inversor_id`),
  ADD KEY `fk_orcamento_placa` (`placa_id`),
  ADD KEY `fk_orcamento_telhado` (`telhado_id`);

--
-- Índices de tabela `Placa`
--
ALTER TABLE `Placa`
  ADD PRIMARY KEY (`placa_id`);

--
-- Índices de tabela `projeto`
--
ALTER TABLE `projeto`
  ADD PRIMARY KEY (`projeto_id`),
  ADD KEY `fk_projeto_placa` (`placa_id`),
  ADD KEY `fk_projeto_inversor` (`inversor_id`);

--
-- Índices de tabela `Telhado`
--
ALTER TABLE `Telhado`
  ADD PRIMARY KEY (`telhado_id`);

--
-- Índices de tabela `Usuario`
--
ALTER TABLE `Usuario`
  ADD PRIMARY KEY (`usuario_id`);

--
-- Índices de tabela `Vendedor`
--
ALTER TABLE `Vendedor`
  ADD PRIMARY KEY (`vendedor_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `Concessionaria`
--
ALTER TABLE `Concessionaria`
  MODIFY `concessionaria_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `config_custos_kit`
--
ALTER TABLE `config_custos_kit`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `Fase`
--
ALTER TABLE `Fase`
  MODIFY `fase_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `Inversor`
--
ALTER TABLE `Inversor`
  MODIFY `inversor_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT de tabela `Orcamento`
--
ALTER TABLE `Orcamento`
  MODIFY `orcamento_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de tabela `Placa`
--
ALTER TABLE `Placa`
  MODIFY `placa_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `projeto`
--
ALTER TABLE `projeto`
  MODIFY `projeto_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `Telhado`
--
ALTER TABLE `Telhado`
  MODIFY `telhado_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `Usuario`
--
ALTER TABLE `Usuario`
  MODIFY `usuario_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `Vendedor`
--
ALTER TABLE `Vendedor`
  MODIFY `vendedor_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `Orcamento`
--
ALTER TABLE `Orcamento`
  ADD CONSTRAINT `fk_orcamento_concessionaria` FOREIGN KEY (`concessionaria_id`) REFERENCES `Concessionaria` (`concessionaria_id`),
  ADD CONSTRAINT `fk_orcamento_fase` FOREIGN KEY (`fase_id`) REFERENCES `Fase` (`fase_id`),
  ADD CONSTRAINT `fk_orcamento_inversor` FOREIGN KEY (`inversor_id`) REFERENCES `Inversor` (`inversor_id`),
  ADD CONSTRAINT `fk_orcamento_placa` FOREIGN KEY (`placa_id`) REFERENCES `Placa` (`placa_id`),
  ADD CONSTRAINT `fk_orcamento_telhado` FOREIGN KEY (`telhado_id`) REFERENCES `Telhado` (`telhado_id`),
  ADD CONSTRAINT `fk_orcamento_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `Usuario` (`usuario_id`);

--
-- Restrições para tabelas `projeto`
--
ALTER TABLE `projeto`
  ADD CONSTRAINT `fk_projeto_inversor` FOREIGN KEY (`inversor_id`) REFERENCES `Inversor` (`inversor_id`),
  ADD CONSTRAINT `fk_projeto_placa` FOREIGN KEY (`placa_id`) REFERENCES `Placa` (`placa_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
