-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 09 Noi 2014 la 18:26
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `gamingplace2`
--

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Salvarea datelor din tabel `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Xbox One Games'),
(2, 'PS4 Games'),
(3, 'Nintendo Wii Games'),
(4, 'Xbox 360 Games'),
(5, 'PS3 Games');

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `address` varchar(255) NOT NULL,
  `address2` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `zipcode` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Salvarea datelor din tabel `orders`
--

INSERT INTO `orders` (`id`, `product_id`, `user_id`, `transaction_id`, `qty`, `price`, `address`, `address2`, `city`, `state`, `zipcode`) VALUES
(1, 1, 1, '0', 1, '59.99', 'Traian Vuia 45', '', 'Timisoara', 'Timis', '300100');

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Salvarea datelor din tabel `products`
--

INSERT INTO `products` (`id`, `category`, `title`, `description`, `image`, `price`) VALUES
(1, 1, 'Destiny', ' In Destiny (from the creators of Halo) you are a Guardian of the last city on Earth. You are able to wield incredible power. Explore the ancient ruins of our solar system, from the vast dunes of Mars to the lush jungles of Venus. Defeat Earth’s enemies. Reclaim all that we have lost. Become legend. Embark on an epic action adventure with rich cinematic storytelling where you unravel the mysteries of our universe and reclaim what we lost at the fall of our Golden Age. The next evolution of the first-person action genre that promises to provide an unprecedented combination of storytelling, cooperative, competitive, and public gameplay, and personal activities that are all woven into an expansive, persistent online world. Venture out alone or join up with friends. The choice is yours. Personalize and upgrade every aspect of how you look and fight with a nearly limitless combination of armor, weapons, and visual customizations. Take your upgraded character into every mode, including campaign, cooperative, social, public, and competitive multiplayer.', 'game1.jpg', '59.99'),
(2, 1, 'Call of Duty Gohts', 'This installment in the Call of Duty series features a fresh dynamic where players are on the side of a crippled nation fighting not for freedom, or liberty, but simply to survive. 10 years after a devastating mass event, the nation''s borders and the balance of global power have been permanently changed. As what''s left of the nation''s Special Operations forces, a mysterious group known only as "Ghosts" leads the fight back against a newly emerged, technologically-superior global power. In Call of Duty: Ghosts you don''t just create a class, you create a soldier. Choose the head, body type, head-gear and equipment, and you can even create a female soldier for the first time. With over 20,000 possible combinations, you can create the soldier you''ve always wanted. And each soldier you create will also have his or her own load outs', 'game2.jpg', '59.99'),
(3, 5, 'Watch Dogs', 'In the modern uber-connected world, Chicago maintains the nation''s most advanced and integrated computer system – one which controls almost every facet of city technology and maintains critical information on all of the city''s residents. Assume the role of Aiden Pearce, a notorious hacker and former thug, whose criminal history lead to a violent family tragedy. Now on the hunt for those people who have hurt your family, you will be able to monitor and hack all who surround you while manipulating the city''s systems to stop traffic lights, download personal and private information, manipulate the electrical grid and more. Use the entire city of Chicago as your personal weapon and exact your signature brand of revenge.', 'game3.jpg', '49.99'),
(4, 1, 'Sniper Elite', 'Sniper Elite 3 continues the story of elite OSS sniper Karl Fairburne during World War II. The title takes players to the unforgiving yet exotic terrain of WWII’s North Africa conflict in a battle against a deadly new foe.', 'game4.jpg', '49.99'),
(5, 2, 'Batman', 'Batman confronts the ultimate threat against the city he has been sworn to protect. The Scarecrow returns to congeal an imposing array of super villains, including The Penguin, Two-Face and Harley Quinn, to summarily destroy The Dark Knight. The game introduces Rocksteady''s uniquely-designed imagining of the Batmobile drivable for the first time in the franchise. Batman: Arkham Knight offers gamers a complete Batman experience as they rip through the streets and soar across the skyline of the iconic Gotham City.', 'game5.jpg', '59.99'),
(6, 2, 'Shadow of Mador', ' Fight your way through Mordor and reveal the truth of the spirit that compels you, discover the origins of the Rings of Power, build your legend and ultimately confront the evil of Sauron in this new story of Middle-earth.', 'game6.jpg', '49.99');

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `join_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Salvarea datelor din tabel `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `username`, `password`, `join_date`) VALUES
(1, 'Brad', 'Travesy', 'techguy@gmail.com', 'brad', 'termopane', '2014-10-20 07:46:33'),
(2, 'blade', 'blade', 'alex.tenche@gmail.com', 'blade', 'a46501298d50abdaab072f2635b6f66b', '2014-11-09 16:13:53');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
