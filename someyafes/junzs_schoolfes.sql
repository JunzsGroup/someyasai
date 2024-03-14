-- phpMyAdmin SQL Dump
-- version 5.2.1-1.el7.remi
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost
-- 生成日時: 2024 年 3 月 14 日 16:38
-- サーバのバージョン： 10.5.22-MariaDB-log
-- PHP のバージョン: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `junzs_schoolfes`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `class`
--

CREATE TABLE `class` (
  `id` int(11) NOT NULL,
  `name` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- テーブルのデータのダンプ `class`
--

INSERT INTO `class` (`id`, `name`) VALUES
(1, '1年1組'),
(2, '1年2組'),
(3, '1年3組'),
(4, '1年4組'),
(5, '1年5組'),
(6, '1年6組'),
(7, '1年7組'),
(8, '2年1組'),
(9, '2年2組'),
(10, '2年3組'),
(11, '2年4組'),
(12, '2年5組'),
(13, '2年6組'),
(14, '2年7組'),
(15, '3年1組'),
(16, '3年2組'),
(17, '3年3組'),
(18, '3年4組'),
(19, '3年5組'),
(20, '3年6組'),
(21, '3年7組');

-- --------------------------------------------------------

--
-- テーブルの構造 `customer`
--

CREATE TABLE `customer` (
  `customerid` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- テーブルのデータのダンプ `customer`
--

INSERT INTO `customer` (`customerid`) VALUES
('03536b22b857ae0b5fd72c80cf42590f'),
('091c82b4b4ff002e20ebb6451c0338d0'),
('0c5b20fa06c061da7a839a75a2e10dd1'),
('0e9e4750e033a05f13e2e6ee67d7351d'),
('1cd11de889b156eede5d83f560146cc2'),
('2b2b03cb53d533cd398ea05a95eb1754'),
('2e6e4f213c1149ec911675170cca8944'),
('2e7db0378c25e41e08e4f77d8c576221'),
('33c6718bc429f6c7f8ed19cda958622b'),
('33cc6ad11eae7eef2379ad621f3cee43'),
('39eeb48873f468b15559f1ea81ab227c'),
('3b36461c3460a3a5931f07372e25aa37'),
('47245aad0ae9cde3cac081b1405cbc1a'),
('4a9204c2a8bda7727eda8e339e935c95'),
('50b33791ad873f5cd0c5026d51aaba17'),
('527c59365e3d65982a05daade2918c8a'),
('52f8778494489834acbc54a84ff7e4f2'),
('625a987aee3f0d3c43210ee2f7f91cfe'),
('662ebd860a535da4710838aaead2d72f'),
('69f9254314918a179f2a0fb161c33341'),
('6b32a0976d51be294d52f136a560ea49'),
('6c469555921418ccfb3d2c7013ca9ca3'),
('6caf6a8626a2db244c5f644541db9e88'),
('6f321339d9101c2fc53adc0d0f31988f'),
('729f24d44f8ff44bdea40a9a51cdd13b'),
('798df09227b5645b3a2bf0b9970ddd7a'),
('7ddf86e23fc842833b9cb915ffdb1b61'),
('81c367245064f61a9cd0c21ad39a4868'),
('82d59df0d11d69d374da20cb24cad363'),
('91caa5c6d64fdfe6ef7cc704cb79c580'),
('9e84fd87af5324d910099cd578ce9861'),
('a9db29401ea7f0af7fe6c42ce1060271'),
('b08e9f6876783a5ea61762238840a875'),
('b20f36fb89d24780dbd92956447b7f4e'),
('b23cbbe10091aefab03387bb3e1e5d26'),
('b89b1bd62f4f4824771aefdb40c9561a'),
('ba5ed4b3e5399f20bd4b7a79c92d716a'),
('bbb6c7d1e841aba2a1a2444bd95ad683'),
('ce489dd1174d0c4a36d11eb7873095ae'),
('ce9c8f16feba72409ca8cddae5401089'),
('daf1822d634e0f41ed51708178eb6c57'),
('db22435a47a17d914ab4c098f45779d2'),
('df589da5471f08b6bcc9abc6402f290c'),
('e17e752c3ea6d5cf4f03cd916e1a24c2'),
('e215590f18564745d6e9c1ef5df55da5'),
('e88a5a50225a8c21c24f5fee2c4c9580'),
('ec391b4bf5f481fa9e990f3460f8fe99'),
('ec3ce62a1c41c095bb8e4fb68cfc7264'),
('f81a47d2e9fde8214f2f9cb10d6d55ca'),
('fda24906b822d24355a247c414573a6b');

-- --------------------------------------------------------

--
-- テーブルの構造 `maxpeople`
--

CREATE TABLE `maxpeople` (
  `id` int(255) NOT NULL,
  `class` varchar(80) NOT NULL,
  `maxpeople` int(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- テーブルのデータのダンプ `maxpeople`
--

INSERT INTO `maxpeople` (`id`, `class`, `maxpeople`) VALUES
(1, '1年6組', 3),
(2, '1年1組', 3);

-- --------------------------------------------------------

--
-- テーブルの構造 `queue`
--

CREATE TABLE `queue` (
  `id` int(11) NOT NULL,
  `class` text NOT NULL,
  `code` varchar(80) NOT NULL,
  `skipped` varchar(80) DEFAULT NULL,
  `start` timestamp NULL DEFAULT NULL,
  `enter` timestamp NULL DEFAULT NULL,
  `leaving` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `queue`
--

INSERT INTO `queue` (`id`, `class`, `code`, `skipped`, `start`, `enter`, `leaving`) VALUES
(44, '1年1組', 'konnnitiha', NULL, '2024-02-10 04:28:06', '2024-03-14 06:35:54', NULL),
(45, '1年1組', 'konnnnn', NULL, '2024-02-10 04:28:16', '2024-03-12 06:36:00', NULL),
(47, '1年1組', 'ウィーちゃん', '1', '2024-03-13 08:33:23', NULL, NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `reserve`
--

CREATE TABLE `reserve` (
  `count` int(11) NOT NULL,
  `id` varchar(80) NOT NULL,
  `class` text NOT NULL,
  `time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- テーブルのデータのダンプ `reserve`
--

INSERT INTO `reserve` (`count`, `id`, `class`, `time`) VALUES
(27, '4a9204c2a8bda7727eda8e339e935c95', '1年1組', '20:12:00'),
(28, '4a9204c2a8bda7727eda8e339e935c95', '1年1組', '20:14:00'),
(29, '4a9204c2a8bda7727eda8e339e935c95', '1年1組', '20:14:00'),
(30, '4a9204c2a8bda7727eda8e339e935c95', '1年1組', '20:14:00'),
(31, '4a9204c2a8bda7727eda8e339e935c95', '1年1組', '00:14:00'),
(32, '<br />\r\n<b>Warning</b>:  Undefined array key ', '1年1組', '20:18:00'),
(33, '4a9204c2a8bda7727eda8e339e935c95', '1年1組', '00:14:00'),
(34, '<br />\r\n<b>Warning</b>:  Undefined array key ', '1年1組', '17:50:00'),
(35, '', '1年1組', '22:00:00'),
(36, '4a9204c2a8bda7727eda8e339e935c95', '1年1組', '21:32:00'),
(37, '4a9204c2a8bda7727eda8e339e935c95', '1年1組', '21:53:00'),
(38, '4a9204c2a8bda7727eda8e339e935c95', '1年1組', '21:53:00'),
(39, 'b23cbbe10091aefab03387bb3e1e5d26', '1年1組', '23:00:00');

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `userid` varchar(80) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`userid`, `username`, `password`, `url`) VALUES
('someyafes1_1', '1年1組', '2o204s0mey@fes11', 'https://github.com/'),
('someyafes1_2', '1年2組', '2o204s0mey@fes12', ''),
('someyafes1_3', '1年3組', '2o204s0mey@fes13', ''),
('someyafes1_4', '1年4組', '2o204s0mey@fes14', ''),
('someyafes1_5', '1年5組', '2o204s0mey@fes15', ''),
('someyafes1_6', '1年6組', '2o204s0mey@fes16', ''),
('someyafes1_7', '1年7組', '2o204s0mey@fes17', ''),
('someyafes2_1', '2年1組', '2o204s0mey@fes21', ''),
('someyafes2_2', '2年2組', '2o204s0mey@fes22', ''),
('someyafes2_3', '2年3組', '2o204s0mey@fes23', ''),
('someyafes2_4', '2年4組', '2o204s0mey@fes24', ''),
('someyafes2_5', '2年5組', '2o204s0mey@fes25', ''),
('someyafes2_6', '2年6組', '2o204s0mey@fes26', ''),
('someyafes2_7', '2年7組', '2o204s0mey@fes27', ''),
('someyafes3_1', '3年1組', '2o204s0mey@fes31', ''),
('someyafes3_2', '3年2組', '2o204s0mey@fes32', ''),
('someyafes3_3', '3年3組', '2o204s0mey@fes33', ''),
('someyafes3_4', '3年4組', '2o204s0mey@fes34', ''),
('someyafes3_5', '3年5組', '2o204s0mey@fes35', ''),
('someyafes3_6', '3年6組', '2o204s0mey@fes36', ''),
('someyafes3_7', '3年7組', '2o204s0mey@fes37', ''),
('testuser', 'テストユーザー', 'testpswd', '');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customerid`);

--
-- テーブルのインデックス `maxpeople`
--
ALTER TABLE `maxpeople`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `queue`
--
ALTER TABLE `queue`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `reserve`
--
ALTER TABLE `reserve`
  ADD PRIMARY KEY (`count`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `class`
--
ALTER TABLE `class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- テーブルの AUTO_INCREMENT `maxpeople`
--
ALTER TABLE `maxpeople`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- テーブルの AUTO_INCREMENT `queue`
--
ALTER TABLE `queue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- テーブルの AUTO_INCREMENT `reserve`
--
ALTER TABLE `reserve`
  MODIFY `count` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
