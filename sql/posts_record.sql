-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2018 年 9 月 28 日 09:10
-- サーバのバージョン： 10.1.34-MariaDB
-- PHP Version: 5.6.37

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Cebufull`
    USE `Cebufull`;
--

-- --------------------------------------------------------

--
-- テーブルの構造 `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `post` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `posts`
--

INSERT INTO `posts` (`id`, `title`, `post`, `user_id`, `category_id`, `created`, `updated`) VALUES
(1, 'ナルスアン島行ってきたレポート', '楽しすぎた〜\r\n桟橋感動した！！', 1, 2, '0000-00-00 00:00:00', '2018-09-23 03:52:23'),
(2, 'ITパークのレストランレポート', 'ピラミッドで買えるマカロンがおすすめ', 2, 1, '0000-00-00 00:00:00', '2018-09-23 03:54:19'),
(3, 'タクシーでぼったくられた話', 'アヤラ付近で止まってたタクシーにのったら２００ペソ取られた', 3, 4, '0000-00-00 00:00:00', '2018-09-23 03:56:04'),
(4, 'バロット食べてみた', '嗚咽止まらんかった', 1, 1, '0000-00-00 00:00:00', '2018-09-23 04:20:05'),
(5, 'オスロブ行ってきたよー', '顔に撒き餌投げられたから一日中頭が魚くさくて最悪だった', 2, 2, '0000-00-00 00:00:00', '2018-09-23 04:21:43'),
(6, 'うまく道路を横断するコツ', '絶対走らない！\r\nゆっくり歩いたほうが割と止まってくれる', 3, 3, '0000-00-00 00:00:00', '2018-09-23 04:23:10'),
(7, 'オランゴでキャンプしてみた話', 'サンクチュアリで一夜明かしてみた。爽快。', 1, 2, '0000-00-00 00:00:00', '2018-09-23 04:24:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
