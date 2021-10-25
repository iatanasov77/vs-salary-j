-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 26, 2021 at 12:06 AM
-- Server version: 8.0.26
-- PHP Version: 7.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `VsSalaryJ`
--

--
-- Dumping data for table `JUN_Models`
--

INSERT INTO `JUN_Models` (`id`, `number`, `name`, `created_at`, `updated_at`, `application_id`, `created_by_id`, `updated_by_id`, `deleted_by_id`, `deleted_at`) VALUES
(1, '111111', 'Test Model', '2021-10-25 10:06:55', '2021-10-25 10:06:55', NULL, NULL, NULL, NULL, NULL);

--
-- Dumping data for table `JUN_Operations`
--

INSERT INTO `JUN_Operations` (`id`, `model_id`, `operation_id`, `operation_name`, `minutes`, `updated_at`, `application_id`, `created_by_id`, `updated_by_id`, `deleted_by_id`, `created_at`, `deleted_at`, `price`) VALUES
(1, 1, '1', 'съединява страничен на четириконечен', 1.3, '2021-10-25 22:01:14', 2, NULL, NULL, NULL, '2021-10-25 22:01:14', NULL, 0);

--
-- Dumping data for table `JUN_Operators`
--

INSERT INTO `JUN_Operators` (`id`, `name`, `created_by_id`, `updated_at`, `application_id`, `updated_by_id`, `deleted_by_id`, `created_at`, `deleted_at`, `group_id`) VALUES
(1, 'Test Operator', NULL, '2021-10-24 12:11:56', NULL, NULL, NULL, '2021-10-24 12:11:56', NULL, 1),
(2, 'Test Operator 2', NULL, '2021-10-24 12:20:15', NULL, NULL, NULL, '2021-10-24 12:20:15', NULL, NULL),
(3, 'Test Operator 3', NULL, '2021-10-24 12:32:23', NULL, NULL, NULL, '2021-10-24 12:32:23', NULL, NULL);

--
-- Dumping data for table `JUN_OperatorsGroups`
--

INSERT INTO `JUN_OperatorsGroups` (`id`, `name`, `taxon_id`, `application_id`) VALUES
(1, 'Test Group', 5, 2);

--
-- Dumping data for table `JUN_Settings`
--

INSERT INTO `JUN_Settings` (`var_name`, `application_id`, `created_by_id`, `updated_by_id`, `deleted_by_id`, `var_value`, `created_at`, `updated_at`) VALUES
('minuteBonus', 2, NULL, NULL, NULL, '20', '2021-10-25 18:27:03', '2021-10-25 18:48:54'),
('minuteRate', 2, NULL, NULL, NULL, '0.065', '2021-10-25 18:27:03', '2021-10-25 18:27:03');

--
-- Dumping data for table `VSAPP_Applications`
--

INSERT INTO `VSAPP_Applications` (`id`, `title`, `hostname`, `code`, `enabled`, `created_at`, `updated_at`) VALUES
(1, 'Admin Panel', 'admin.salary-j.lh', 'admin-panel', 1, '2021-10-13 00:50:24', NULL),
(2, 'SalaryJ Main', 'salary-j.lh', 'salaryj-main', 1, '2021-10-13 22:37:01', NULL);

--
-- Dumping data for table `VSAPP_Migrations`
--

INSERT INTO `VSAPP_Migrations` (`version`, `executed_at`, `execution_time`) VALUES
('App\\DoctrineMigrations\\Version20210928155130', '2021-10-13 21:40:54', 257),
('App\\DoctrineMigrations\\Version20211010193432', '2021-10-13 21:40:54', 695),
('App\\DoctrineMigrations\\Version20211011145348', '2021-10-13 21:40:55', 2248),
('App\\DoctrineMigrations\\Version20211023162540', '2021-10-23 19:26:15', 4161),
('App\\DoctrineMigrations\\Version20211023183531', '2021-10-23 21:36:07', 2214),
('App\\DoctrineMigrations\\Version20211024091112', '2021-10-24 12:11:38', 3403),
('App\\DoctrineMigrations\\Version20211025110003', '2021-10-25 14:00:35', 6303),
('App\\DoctrineMigrations\\Version20211025191550', '2021-10-25 22:16:21', 2297),
('VS\\ApplicationBundle\\DoctrineMigrations\\Version20210615143142', '2021-10-13 21:40:46', 2108),
('VS\\ApplicationBundle\\DoctrineMigrations\\Version20210617123114', '2021-10-13 21:40:48', 599),
('VS\\ApplicationBundle\\DoctrineMigrations\\Version20210702092552', '2021-10-13 21:40:48', 479),
('VS\\ApplicationBundle\\DoctrineMigrations\\Version20210702150353', '2021-10-13 21:40:49', 1053),
('VS\\ApplicationBundle\\DoctrineMigrations\\Version20210703173305', '2021-10-13 21:40:50', 1151),
('VS\\ApplicationBundle\\DoctrineMigrations\\Version20210705031111', '2021-10-13 21:40:51', 921),
('VS\\ApplicationBundle\\DoctrineMigrations\\Version20210707064607', '2021-10-13 21:40:52', 451),
('VS\\ApplicationBundle\\DoctrineMigrations\\Version20211003124448', '2021-10-13 21:40:53', 384),
('VS\\ApplicationBundle\\DoctrineMigrations\\Version20211005095015', '2021-10-13 21:40:53', 384),
('VS\\ApplicationBundle\\DoctrineMigrations\\Version20211009103709', '2021-10-13 21:40:53', 261);

--
-- Dumping data for table `VSAPP_Settings`
--

INSERT INTO `VSAPP_Settings` (`id`, `maintenanceMode`, `theme`, `application_id`, `maintenance_page_id`) VALUES
(1, 0, NULL, NULL, NULL);

--
-- Dumping data for table `VSAPP_Taxonomy`
--

INSERT INTO `VSAPP_Taxonomy` (`id`, `code`, `root_taxon_id`, `name`, `description`) VALUES
(1, 'page-categories', NULL, 'Page Categories', 'Page Categories'),
(2, 'operators-groups', 1, 'Operators Groups', 'Operators Groups');

--
-- Dumping data for table `VSAPP_Taxons`
--

INSERT INTO `VSAPP_Taxons` (`id`, `tree_root`, `parent_id`, `code`, `tree_left`, `tree_right`, `tree_level`, `position`, `enabled`) VALUES
(1, 1, NULL, 'operators-groups', 1, 6, 0, NULL, 1),
(5, 1, 1, 'test-group', 2, 3, 1, NULL, 1);

--
-- Dumping data for table `VSAPP_TaxonTranslations`
--

INSERT INTO `VSAPP_TaxonTranslations` (`id`, `translatable_id`, `locale`, `name`, `slug`, `description`) VALUES
(1, 1, 'en', 'Operators Groups', 'operators-groups', 'Root taxon of Taxonomy: \"Operators Groups\"'),
(5, 5, 'bg_BG', 'Test Group', 'test-group', NULL);

--
-- Dumping data for table `VSAPP_Translations`
--

INSERT INTO `VSAPP_Translations` (`id`, `locale`, `object_class`, `field`, `foreign_key`, `content`) VALUES
(1, 'en', 'App\\Entity\\Application\\Taxonomy', 'name', '2', 'Operators Groups'),
(2, 'en', 'App\\Entity\\Application\\Taxonomy', 'description', '2', 'Operators Groups');

--
-- Dumping data for table `VSUM_Users`
--

INSERT INTO `VSUM_Users` (`id`, `info_id`, `api_token`, `salt`, `password`, `roles`, `username`, `email`, `prefered_locale`, `first_name`, `last_name`, `last_login`, `confirmation_token`, `password_requested_at`, `verified`, `enabled`) VALUES
(1, NULL, 'NOT_IMPLEMETED', '8eca1786603da9c963417f36d7d02ab6', '$2y$13$maxBFr.tQYqNEuWUv8/TmuFfDNzuWuYoqbW0normBKX4LE7Wh09r6', 'a:1:{i:0;s:16:\"ROLE_SUPER_ADMIN\";}', 'admin', 'admin@test-vankosoft-application.lh', 'en_US', 'NOT_EDITED_YET', 'NOT_EDITED_YET', NULL, NULL, NULL, 1, 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
