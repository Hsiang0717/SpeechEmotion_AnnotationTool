-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- 主機: localhost
-- 產生時間： 2022-05-30 05:41:52
-- 伺服器版本: 5.7.17-log
-- PHP 版本： 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `github`
--

-- --------------------------------------------------------

--
-- 資料表結構 `comprehensive_form`
--

CREATE TABLE `comprehensive_form` (
  `Sample` int(255) NOT NULL,
  `SentenceID` varchar(30) NOT NULL,
  `Sentiment` int(10) NOT NULL,
  `MarkerID` varchar(30) NOT NULL,
  `MarkTime` time NOT NULL,
  `Status` text NOT NULL,
  `Remark` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `emotion_label`
--

CREATE TABLE `emotion_label` (
  `id` int(10) NOT NULL,
  `word` text NOT NULL,
  `emotion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `information`
--

CREATE TABLE `information` (
  `VideoID` varchar(100) NOT NULL,
  `Num` int(11) NOT NULL,
  `EpisodeID` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `marker`
--

CREATE TABLE `marker` (
  `MarkerID` varchar(10) NOT NULL,
  `Recoders` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `sentence`
--

CREATE TABLE `sentence` (
  `Id` int(255) NOT NULL,
  `SentenceID` varchar(30) NOT NULL,
  `Sentence` text NOT NULL,
  `SpeakerGender` varchar(10) DEFAULT NULL,
  `SentenceTime` int(255) NOT NULL,
  `ShowID` varchar(50) NOT NULL,
  `EpisodeID` varchar(50) NOT NULL,
  `DialogID` varchar(10) DEFAULT NULL,
  `Sentiment` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `comprehensive_form`
--
ALTER TABLE `comprehensive_form`
  ADD PRIMARY KEY (`Sample`);

--
-- 資料表索引 `emotion_label`
--
ALTER TABLE `emotion_label`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `information`
--
ALTER TABLE `information`
  ADD PRIMARY KEY (`VideoID`);

--
-- 資料表索引 `marker`
--
ALTER TABLE `marker`
  ADD PRIMARY KEY (`MarkerID`);

--
-- 資料表索引 `sentence`
--
ALTER TABLE `sentence`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `SentenceID` (`SentenceID`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `comprehensive_form`
--
ALTER TABLE `comprehensive_form`
  MODIFY `Sample` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8522;
--
-- 使用資料表 AUTO_INCREMENT `sentence`
--
ALTER TABLE `sentence`
  MODIFY `Id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4792;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
