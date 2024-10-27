-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 27 oct. 2024 à 18:10
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `product_api_trial`
--

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20241027164816', '2024-10-27 17:48:35', 97);

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category` varchar(255) NOT NULL,
  `price` double NOT NULL,
  `quantity` int(11) NOT NULL,
  `internal_reference` varchar(255) NOT NULL,
  `shell_id` int(11) NOT NULL,
  `inventory_status` varchar(255) NOT NULL,
  `rating` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `product`
--

INSERT INTO `product` (`id`, `code`, `name`, `description`, `image`, `category`, `price`, `quantity`, `internal_reference`, `shell_id`, `inventory_status`, `rating`, `created_at`, `updated_at`) VALUES
(1, 'P001', 'Product 1', 'Description of the product 1', 'image_of_product1.jpg', 'Category13', 451, 100, 'REF001', 5, 'OUTOFSTOCK', 4, '2024-10-27 17:49:06', '2024-10-27 17:49:06'),
(3, 'P003', 'Product 3', 'Description of the product 3', 'image_of_product3.jpg', 'Category18', 322, 78, 'REF003', 2, 'LOWSTOCK', 5, '2024-10-27 17:49:06', '2024-10-27 17:49:06'),
(4, 'P004', 'Product 4', 'Description of the product 4', 'image_of_product4.jpg', 'Category12', 333, 77, 'REF004', 3, 'INSTOCK', 1, '2024-10-27 17:49:06', '2024-10-27 17:49:06'),
(5, 'P005', 'Product 5', 'Description of the product 5', 'image_of_product5.jpg', 'Category15', 267, 5, 'REF005', 4, 'OUTOFSTOCK', 1, '2024-10-27 17:49:06', '2024-10-27 17:49:06'),
(6, 'P006', 'Product 6', 'Description of the product 6', 'image_of_product6.jpg', 'Category18', 292, 65, 'REF006', 3, 'INSTOCK', 4, '2024-10-27 17:49:06', '2024-10-27 17:49:06'),
(7, 'P007', 'Product 7', 'Description of the product 7', 'image_of_product7.jpg', 'Category13', 107, 78, 'REF007', 1, 'OUTOFSTOCK', 4, '2024-10-27 17:49:06', '2024-10-27 17:49:06'),
(8, 'P008', 'Product 8', 'Description of the product 8', 'image_of_product8.jpg', 'Category17', 420, 12, 'REF008', 4, 'INSTOCK', 5, '2024-10-27 17:49:06', '2024-10-27 17:49:06'),
(9, 'P009', 'Product 9', 'Description of the product 9', 'image_of_product9.jpg', 'Category12', 382, 10, 'REF009', 1, 'LOWSTOCK', 3, '2024-10-27 17:49:06', '2024-10-27 17:49:06'),
(10, 'P0010', 'Product 10', 'Description of the product 10', 'image_of_product10.jpg', 'Category17', 321, 2, 'REF0010', 4, 'INSTOCK', 4, '2024-10-27 17:49:06', '2024-10-27 17:49:06'),
(11, 'P0011', 'Product 11', 'Description of the product 11', 'image_of_product11.jpg', 'Category9', 370, 8, 'REF0011', 2, 'OUTOFSTOCK', 3, '2024-10-27 17:49:06', '2024-10-27 17:49:06'),
(12, 'P0012', 'Product 12', 'Description of the product 12', 'image_of_product12.jpg', 'Category15', 386, 35, 'REF0012', 2, 'INSTOCK', 5, '2024-10-27 17:49:06', '2024-10-27 17:49:06'),
(13, 'P0013', 'Product 13', 'Description of the product 13', 'image_of_product13.jpg', 'Category14', 287, 11, 'REF0013', 2, 'OUTOFSTOCK', 1, '2024-10-27 17:49:06', '2024-10-27 17:49:06'),
(14, 'P0014', 'Product 14', 'Description of the product 14', 'image_of_product14.jpg', 'Category15', 102, 4, 'REF0014', 1, 'INSTOCK', 2, '2024-10-27 17:49:06', '2024-10-27 17:49:06'),
(15, 'P0015', 'Product 15', 'Description of the product 15', 'image_of_product15.jpg', 'Category17', 433, 39, 'REF0015', 1, 'LOWSTOCK', 1, '2024-10-27 17:49:06', '2024-10-27 17:49:06');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
