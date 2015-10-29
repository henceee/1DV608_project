-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 29 okt 2015 kl 06:56
-- Serverversion: 5.6.21
-- PHP-version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databas: `memegallery`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `content`
--

CREATE TABLE IF NOT EXISTS `content` (
`ID` int(11) NOT NULL,
  `userID` varchar(50) NOT NULL,
  `Title` varchar(50) NOT NULL,
  `ImgSrc` varchar(100) NOT NULL,
  `Description` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `content`
--

INSERT INTO `content` (`ID`, `userID`, `Title`, `ImgSrc`, `Description`) VALUES
(15, '56159b77236e', 'Your argument is invalid.', 'Doctor_Rock.png', 'Your argument is invalid.'),
(16, '56159b77236e', 'Trust me I''m the Doctor!', '131119141309-11-doctor-who-horizontal-large-gallery.jpg', 'Trust me I''m the Doctor!'),
(17, '56159b77236e', 'Explain!', 'Daleks_appearence.jpg', 'When someone smarter than you says something fancy and you''re all like..'),
(21, '56159b77236e', 'Caffinate!', '5630fad5a2c10Daleks_appearence.jpg', 'Caffinate!'),
(22, '56159b77236e', 'Wibbly wobbly', '5630fb3207cb3131119141309-11-doctor-who-horizontal-large-gallery.jpg', '...Timey wimey'),
(23, '56159b77236e', 'Fezzes are cool!', '5630fc4e5dcbbdoctor-who-fez.jpg', 'Fezzes are cool!'),
(24, '56159b77236e', 'Bowties are cool.', '5630fc98e3e4bimages.jpg', 'Bowties are cool.'),
(25, '56159b77236e', 'Excuse me?', '5630fd4f293aa44.jpg', 'What did you say, b*tch`?');

-- --------------------------------------------------------

--
-- Tabellstruktur `contentcomments`
--

CREATE TABLE IF NOT EXISTS `contentcomments` (
`ID` int(11) NOT NULL,
  `contentID` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `comment` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `contentcomments`
--

INSERT INTO `contentcomments` (`ID`, `contentID`, `name`, `comment`) VALUES
(1, 1, 'asf', 'LOL'),
(2, 3, 'adasda', 'LOL'),
(3, 1, 'dasd', 'LOL XD'),
(6, 1, 'Admin					', '^^'),
(7, 4, 'asd', 'haha'),
(8, 5, 'asd', 'haha XD'),
(9, 6, 'asd', 'ROFL XD'),
(10, 7, 'asd', 'lolicopter XD'),
(11, 7, 'asd', 'lolicopter XD'),
(12, 7, 'asd', 'roflcopter*'),
(13, 8, 'asd', '10th is my doctor!! <3 *fangirl*'),
(14, 14, 'Admin					', 'COFFEE FTW!'),
(15, 14, 'Admin					', 'Daleks need caffeine to have the energy to exterminate the doctor  ^^'),
(16, 15, 'Admin					', 'LOL'),
(17, 16, 'Admin					', '10th is my Doctor!'),
(18, 17, 'Admin					', 'Every day in school lol.'),
(19, 21, 'Admin					', 'Daleks need caffeine to have the energy to exterminate the doctor ^^'),
(20, 15, 'Troll				', 'You spelled guitar wrong you loser!!');

-- --------------------------------------------------------

--
-- Tabellstruktur `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `ID` varchar(12) NOT NULL,
  `Username` varchar(25) NOT NULL,
  `Password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `users`
--

INSERT INTO `users` (`ID`, `Username`, `Password`) VALUES
('56159b77236e', 'Admin', 'dc647eb65e6711e155375218212b3964'),
('56174cd10b06', 'asathor', 'e10adc3949ba59abbe56e057f20f883e'),
('56174d82a26e', 'snorre', 'e10adc3949ba59abbe56e057f20f883e'),
('561ef841f3e5', 'aaaa', '96e79218965eb72c92a549dd5a330112'),
('562586ff8b5b', 'adddddd', 'e10adc3949ba59abbe56e057f20f883e'),
('562590f14725', 'fff', 'eed8cdc400dfd4ec85dff70a170066b7'),
('5625948b73c3', 'aaa', '0b4e7a0e5fe84ad35fb5f95b9ceeac79'),
('5625ad3f1aa3', 'asdasdas', '96e79218965eb72c92a549dd5a330112'),
('5625ade31723', 'asdasdasdasdasdas', '96e79218965eb72c92a549dd5a330112'),
('5625aeb59da7', 'fuu', '96e79218965eb72c92a549dd5a330112'),
('5625af3c77aa', 'fuuasdf', '96e79218965eb72c92a549dd5a330112'),
('5625b0047dc6', 'aaaaaaa', '96e79218965eb72c92a549dd5a330112'),
('5625b0f1eeb6', 'aaaaaaaaaa', '96e79218965eb72c92a549dd5a330112'),
('5625b579345d', 'aaaaaa', '0b4e7a0e5fe84ad35fb5f95b9ceeac79'),
('5625b6443909', 'fuuuuuuu', '96e79218965eb72c92a549dd5a330112'),
('5625b7ea9f66', 'grrr', '96e79218965eb72c92a549dd5a330112');

--
-- Index för dumpade tabeller
--

--
-- Index för tabell `content`
--
ALTER TABLE `content`
 ADD PRIMARY KEY (`ID`);

--
-- Index för tabell `contentcomments`
--
ALTER TABLE `contentcomments`
 ADD PRIMARY KEY (`ID`);

--
-- Index för tabell `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT för dumpade tabeller
--

--
-- AUTO_INCREMENT för tabell `content`
--
ALTER TABLE `content`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT för tabell `contentcomments`
--
ALTER TABLE `contentcomments`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
