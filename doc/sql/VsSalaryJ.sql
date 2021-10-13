-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 13, 2021 at 10:38 PM
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

-- --------------------------------------------------------

--
-- Table structure for table `JUN_Models`
--

CREATE TABLE `JUN_Models` (
  `id` int NOT NULL,
  `number` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `application_id` int DEFAULT NULL,
  `created_by_id` int DEFAULT NULL,
  `updated_by_id` int DEFAULT NULL,
  `deleted_by_id` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `JUN_Operations`
--

CREATE TABLE `JUN_Operations` (
  `id` int NOT NULL,
  `model_id` int NOT NULL,
  `operation_id` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `operation_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `minutes` double NOT NULL,
  `updated_at` datetime NOT NULL,
  `application_id` int DEFAULT NULL,
  `created_by_id` int DEFAULT NULL,
  `updated_by_id` int DEFAULT NULL,
  `deleted_by_id` int DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `JUN_Operators`
--

CREATE TABLE `JUN_Operators` (
  `id` int NOT NULL,
  `groups_id` int NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_by_id` int DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `application_id` int DEFAULT NULL,
  `updated_by_id` int DEFAULT NULL,
  `deleted_by_id` int DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `JUN_OperatorsGroups`
--

CREATE TABLE `JUN_OperatorsGroups` (
  `id` int NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `taxon_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `JUN_OperatorsWork`
--

CREATE TABLE `JUN_OperatorsWork` (
  `id` int NOT NULL,
  `application_id` int DEFAULT NULL,
  `operators_id` int NOT NULL,
  `operations_id` int NOT NULL,
  `date` date NOT NULL,
  `count` int NOT NULL,
  `price` double NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by_id` int DEFAULT NULL,
  `updated_by_id` int DEFAULT NULL,
  `deleted_by_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `VSAPP_Applications`
--

CREATE TABLE `VSAPP_Applications` (
  `id` int NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hostname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `VSAPP_Applications`
--

INSERT INTO `VSAPP_Applications` (`id`, `title`, `hostname`, `code`, `enabled`, `created_at`, `updated_at`) VALUES
(1, 'Salary J', 'salary-j.lh', 'salary-j', 1, '2021-10-13 22:37:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `VSAPP_InstalationInfo`
--

CREATE TABLE `VSAPP_InstalationInfo` (
  `id` int NOT NULL,
  `version` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `VSAPP_Locale`
--

CREATE TABLE `VSAPP_Locale` (
  `id` int NOT NULL,
  `code` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `VSAPP_LogEntries`
--

CREATE TABLE `VSAPP_LogEntries` (
  `id` int NOT NULL,
  `locale` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `action` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `logged_at` datetime NOT NULL,
  `object_id` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `object_class` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `version` int NOT NULL,
  `data` longtext COLLATE utf8_unicode_ci COMMENT '(DC2Type:array)',
  `username` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `VSAPP_Migrations`
--

CREATE TABLE `VSAPP_Migrations` (
  `version` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `VSAPP_Migrations`
--

INSERT INTO `VSAPP_Migrations` (`version`, `executed_at`, `execution_time`) VALUES
('App\\DoctrineMigrations\\Version20210928155130', '2021-10-13 21:40:54', 257),
('App\\DoctrineMigrations\\Version20211010193432', '2021-10-13 21:40:54', 695),
('App\\DoctrineMigrations\\Version20211011145348', '2021-10-13 21:40:55', 2248),
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

-- --------------------------------------------------------

--
-- Table structure for table `VSAPP_Settings`
--

CREATE TABLE `VSAPP_Settings` (
  `id` int NOT NULL,
  `maintenanceMode` tinyint(1) NOT NULL,
  `theme` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `application_id` int DEFAULT NULL,
  `maintenance_page_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `VSAPP_Settings`
--

INSERT INTO `VSAPP_Settings` (`id`, `maintenanceMode`, `theme`, `application_id`, `maintenance_page_id`) VALUES
(1, 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `VSAPP_Taxonomy`
--

CREATE TABLE `VSAPP_Taxonomy` (
  `id` int NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `root_taxon_id` int DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `VSAPP_Taxons`
--

CREATE TABLE `VSAPP_Taxons` (
  `id` int NOT NULL,
  `tree_root` int DEFAULT NULL,
  `parent_id` int DEFAULT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tree_left` int NOT NULL,
  `tree_right` int NOT NULL,
  `tree_level` int NOT NULL,
  `position` int DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `VSAPP_TaxonTranslations`
--

CREATE TABLE `VSAPP_TaxonTranslations` (
  `id` int NOT NULL,
  `translatable_id` int DEFAULT NULL,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `VSAPP_Translations`
--

CREATE TABLE `VSAPP_Translations` (
  `id` int NOT NULL,
  `locale` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `object_class` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `field` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `foreign_key` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `VSCMS_MultiPageToc`
--

CREATE TABLE `VSCMS_MultiPageToc` (
  `id` int NOT NULL,
  `toc_root_page_id` int NOT NULL,
  `toc_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `main_page_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `VSCMS_PageCategories`
--

CREATE TABLE `VSCMS_PageCategories` (
  `id` int NOT NULL,
  `parent_id` int DEFAULT NULL,
  `taxon_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `VSCMS_Pages`
--

CREATE TABLE `VSCMS_Pages` (
  `id` int NOT NULL,
  `published` tinyint(1) NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `text` longtext COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `VSCMS_Pages_Categories`
--

CREATE TABLE `VSCMS_Pages_Categories` (
  `page_id` int NOT NULL,
  `category_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `VSCMS_TocPage`
--

CREATE TABLE `VSCMS_TocPage` (
  `id` int NOT NULL,
  `page_id` int DEFAULT NULL,
  `tree_root` int DEFAULT NULL,
  `parent_id` int DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lft` int NOT NULL,
  `rgt` int NOT NULL,
  `lvl` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `VSUM_ResetPasswordRequests`
--

CREATE TABLE `VSUM_ResetPasswordRequests` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `selector` varchar(24) COLLATE utf8_unicode_ci NOT NULL,
  `hashedToken` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `requestedAt` datetime NOT NULL,
  `expiresAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `VSUM_Users`
--

CREATE TABLE `VSUM_Users` (
  `id` int NOT NULL,
  `info_id` int DEFAULT NULL,
  `api_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `prefered_locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `confirmation_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `verified` tinyint(1) DEFAULT NULL,
  `enabled` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `VSUM_Users`
--

INSERT INTO `VSUM_Users` (`id`, `info_id`, `api_token`, `salt`, `password`, `roles`, `username`, `email`, `prefered_locale`, `first_name`, `last_name`, `last_login`, `confirmation_token`, `password_requested_at`, `verified`, `enabled`) VALUES
(1, NULL, 'NOT_IMPLEMETED', '8eca1786603da9c963417f36d7d02ab6', '$2y$13$maxBFr.tQYqNEuWUv8/TmuFfDNzuWuYoqbW0normBKX4LE7Wh09r6', 'a:1:{i:0;s:16:\"ROLE_SUPER_ADMIN\";}', 'admin', 'admin@test-vankosoft-application.lh', 'en_US', 'NOT_EDITED_YET', 'NOT_EDITED_YET', NULL, NULL, NULL, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `VSUM_UsersActivities`
--

CREATE TABLE `VSUM_UsersActivities` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `activity` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `VSUM_UsersInfo`
--

CREATE TABLE `VSUM_UsersInfo` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `profile_picture` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `birthday` datetime DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `occupation` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `VSUM_UsersNotifications`
--

CREATE TABLE `VSUM_UsersNotifications` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `notification` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `JUN_Models`
--
ALTER TABLE `JUN_Models`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_E9E5263B3E030ACD` (`application_id`),
  ADD KEY `IDX_E9E5263BB03A8386` (`created_by_id`),
  ADD KEY `IDX_E9E5263B896DBBDE` (`updated_by_id`),
  ADD KEY `IDX_E9E5263BC76F1F52` (`deleted_by_id`);

--
-- Indexes for table `JUN_Operations`
--
ALTER TABLE `JUN_Operations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `model_id` (`model_id`),
  ADD KEY `IDX_E047A52D3E030ACD` (`application_id`),
  ADD KEY `IDX_E047A52DB03A8386` (`created_by_id`),
  ADD KEY `IDX_E047A52D896DBBDE` (`updated_by_id`),
  ADD KEY `IDX_E047A52DC76F1F52` (`deleted_by_id`);

--
-- Indexes for table `JUN_Operators`
--
ALTER TABLE `JUN_Operators`
  ADD PRIMARY KEY (`id`),
  ADD KEY `groups_id` (`groups_id`),
  ADD KEY `IDX_5C13F283E030ACD` (`application_id`),
  ADD KEY `IDX_5C13F28B03A8386` (`created_by_id`),
  ADD KEY `IDX_5C13F28896DBBDE` (`updated_by_id`),
  ADD KEY `IDX_5C13F28C76F1F52` (`deleted_by_id`);

--
-- Indexes for table `JUN_OperatorsGroups`
--
ALTER TABLE `JUN_OperatorsGroups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F775DFC2DE13F470` (`taxon_id`);

--
-- Indexes for table `JUN_OperatorsWork`
--
ALTER TABLE `JUN_OperatorsWork`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_1B46F0423E030ACD` (`application_id`),
  ADD KEY `IDX_1B46F042B03A8386` (`created_by_id`),
  ADD KEY `IDX_1B46F042896DBBDE` (`updated_by_id`),
  ADD KEY `IDX_1B46F042C76F1F52` (`deleted_by_id`);

--
-- Indexes for table `VSAPP_Applications`
--
ALTER TABLE `VSAPP_Applications`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_7797295A77153098` (`code`),
  ADD KEY `IDX_7797295AE551C011` (`hostname`);

--
-- Indexes for table `VSAPP_InstalationInfo`
--
ALTER TABLE `VSAPP_InstalationInfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `VSAPP_Locale`
--
ALTER TABLE `VSAPP_Locale`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_3DB0A7DB77153098` (`code`);

--
-- Indexes for table `VSAPP_LogEntries`
--
ALTER TABLE `VSAPP_LogEntries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `versions_lookup_unique_idx` (`object_class`,`object_id`,`version`),
  ADD KEY `versions_lookup_idx` (`object_class`,`object_id`);

--
-- Indexes for table `VSAPP_Migrations`
--
ALTER TABLE `VSAPP_Migrations`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `VSAPP_Settings`
--
ALTER TABLE `VSAPP_Settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_4A491FD3E030ACD` (`application_id`),
  ADD KEY `IDX_4A491FD507FAB6A` (`maintenance_page_id`);

--
-- Indexes for table `VSAPP_Taxonomy`
--
ALTER TABLE `VSAPP_Taxonomy`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_1CF3890577153098` (`code`),
  ADD UNIQUE KEY `UNIQ_1CF38905A54E9E96` (`root_taxon_id`);

--
-- Indexes for table `VSAPP_Taxons`
--
ALTER TABLE `VSAPP_Taxons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_2661B30B77153098` (`code`),
  ADD KEY `IDX_2661B30BA977936C` (`tree_root`),
  ADD KEY `IDX_2661B30B727ACA70` (`parent_id`);

--
-- Indexes for table `VSAPP_TaxonTranslations`
--
ALTER TABLE `VSAPP_TaxonTranslations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug_uidx` (`locale`,`slug`),
  ADD UNIQUE KEY `VSAPP_TaxonTranslations_uniq_trans` (`translatable_id`,`locale`),
  ADD KEY `IDX_AFE16CB02C2AC5D3` (`translatable_id`);

--
-- Indexes for table `VSAPP_Translations`
--
ALTER TABLE `VSAPP_Translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lookup_unique_idx` (`locale`,`object_class`,`field`,`foreign_key`),
  ADD KEY `translations_lookup_idx` (`locale`,`object_class`,`foreign_key`);

--
-- Indexes for table `VSCMS_MultiPageToc`
--
ALTER TABLE `VSCMS_MultiPageToc`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_B262621CB4CE9742` (`toc_root_page_id`),
  ADD KEY `IDX_B262621CF80DCA0D` (`main_page_id`);

--
-- Indexes for table `VSCMS_PageCategories`
--
ALTER TABLE `VSCMS_PageCategories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_98A43648727ACA70` (`parent_id`),
  ADD KEY `IDX_98A43648DE13F470` (`taxon_id`);

--
-- Indexes for table `VSCMS_Pages`
--
ALTER TABLE `VSCMS_Pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_345A075A989D9B62` (`slug`);

--
-- Indexes for table `VSCMS_Pages_Categories`
--
ALTER TABLE `VSCMS_Pages_Categories`
  ADD PRIMARY KEY (`page_id`,`category_id`),
  ADD KEY `IDX_88D3BD76C4663E4` (`page_id`),
  ADD KEY `IDX_88D3BD7612469DE2` (`category_id`);

--
-- Indexes for table `VSCMS_TocPage`
--
ALTER TABLE `VSCMS_TocPage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_6B1FF241C4663E4` (`page_id`),
  ADD KEY `IDX_6B1FF241A977936C` (`tree_root`),
  ADD KEY `IDX_6B1FF241727ACA70` (`parent_id`);

--
-- Indexes for table `VSUM_ResetPasswordRequests`
--
ALTER TABLE `VSUM_ResetPasswordRequests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D6C66D0A76ED395` (`user_id`);

--
-- Indexes for table `VSUM_Users`
--
ALTER TABLE `VSUM_Users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_CAFDCD035D8BC1F8` (`info_id`);

--
-- Indexes for table `VSUM_UsersActivities`
--
ALTER TABLE `VSUM_UsersActivities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_54103277A76ED395` (`user_id`);

--
-- Indexes for table `VSUM_UsersInfo`
--
ALTER TABLE `VSUM_UsersInfo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_3ADA80CAA76ED395` (`user_id`);

--
-- Indexes for table `VSUM_UsersNotifications`
--
ALTER TABLE `VSUM_UsersNotifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_8D75FA15A76ED395` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `JUN_Models`
--
ALTER TABLE `JUN_Models`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `JUN_Operations`
--
ALTER TABLE `JUN_Operations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `JUN_Operators`
--
ALTER TABLE `JUN_Operators`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `JUN_OperatorsGroups`
--
ALTER TABLE `JUN_OperatorsGroups`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `JUN_OperatorsWork`
--
ALTER TABLE `JUN_OperatorsWork`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `VSAPP_Applications`
--
ALTER TABLE `VSAPP_Applications`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `VSAPP_InstalationInfo`
--
ALTER TABLE `VSAPP_InstalationInfo`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `VSAPP_Locale`
--
ALTER TABLE `VSAPP_Locale`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `VSAPP_LogEntries`
--
ALTER TABLE `VSAPP_LogEntries`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `VSAPP_Settings`
--
ALTER TABLE `VSAPP_Settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `VSAPP_Taxonomy`
--
ALTER TABLE `VSAPP_Taxonomy`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `VSAPP_Taxons`
--
ALTER TABLE `VSAPP_Taxons`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `VSAPP_TaxonTranslations`
--
ALTER TABLE `VSAPP_TaxonTranslations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `VSAPP_Translations`
--
ALTER TABLE `VSAPP_Translations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `VSCMS_MultiPageToc`
--
ALTER TABLE `VSCMS_MultiPageToc`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `VSCMS_PageCategories`
--
ALTER TABLE `VSCMS_PageCategories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `VSCMS_Pages`
--
ALTER TABLE `VSCMS_Pages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `VSCMS_TocPage`
--
ALTER TABLE `VSCMS_TocPage`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `VSUM_ResetPasswordRequests`
--
ALTER TABLE `VSUM_ResetPasswordRequests`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `VSUM_Users`
--
ALTER TABLE `VSUM_Users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `VSUM_UsersActivities`
--
ALTER TABLE `VSUM_UsersActivities`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `VSUM_UsersInfo`
--
ALTER TABLE `VSUM_UsersInfo`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `VSUM_UsersNotifications`
--
ALTER TABLE `VSUM_UsersNotifications`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `JUN_Models`
--
ALTER TABLE `JUN_Models`
  ADD CONSTRAINT `FK_E9E5263B3E030ACD` FOREIGN KEY (`application_id`) REFERENCES `VSAPP_Applications` (`id`),
  ADD CONSTRAINT `FK_E9E5263B896DBBDE` FOREIGN KEY (`updated_by_id`) REFERENCES `VSUM_Users` (`id`),
  ADD CONSTRAINT `FK_E9E5263BB03A8386` FOREIGN KEY (`created_by_id`) REFERENCES `VSUM_Users` (`id`),
  ADD CONSTRAINT `FK_E9E5263BC76F1F52` FOREIGN KEY (`deleted_by_id`) REFERENCES `VSUM_Users` (`id`);

--
-- Constraints for table `JUN_Operations`
--
ALTER TABLE `JUN_Operations`
  ADD CONSTRAINT `FK_E047A52D3E030ACD` FOREIGN KEY (`application_id`) REFERENCES `VSAPP_Applications` (`id`),
  ADD CONSTRAINT `FK_E047A52D7975B7E7` FOREIGN KEY (`model_id`) REFERENCES `JUN_Models` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_E047A52D896DBBDE` FOREIGN KEY (`updated_by_id`) REFERENCES `VSUM_Users` (`id`),
  ADD CONSTRAINT `FK_E047A52DB03A8386` FOREIGN KEY (`created_by_id`) REFERENCES `VSUM_Users` (`id`),
  ADD CONSTRAINT `FK_E047A52DC76F1F52` FOREIGN KEY (`deleted_by_id`) REFERENCES `VSUM_Users` (`id`);

--
-- Constraints for table `JUN_Operators`
--
ALTER TABLE `JUN_Operators`
  ADD CONSTRAINT `FK_5C13F283E030ACD` FOREIGN KEY (`application_id`) REFERENCES `VSAPP_Applications` (`id`),
  ADD CONSTRAINT `FK_5C13F28896DBBDE` FOREIGN KEY (`updated_by_id`) REFERENCES `VSUM_Users` (`id`),
  ADD CONSTRAINT `FK_5C13F28B03A8386` FOREIGN KEY (`created_by_id`) REFERENCES `VSUM_Users` (`id`),
  ADD CONSTRAINT `FK_5C13F28C76F1F52` FOREIGN KEY (`deleted_by_id`) REFERENCES `VSUM_Users` (`id`);

--
-- Constraints for table `JUN_OperatorsGroups`
--
ALTER TABLE `JUN_OperatorsGroups`
  ADD CONSTRAINT `FK_F775DFC2DE13F470` FOREIGN KEY (`taxon_id`) REFERENCES `VSAPP_Taxons` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `JUN_OperatorsWork`
--
ALTER TABLE `JUN_OperatorsWork`
  ADD CONSTRAINT `FK_1B46F0423E030ACD` FOREIGN KEY (`application_id`) REFERENCES `VSAPP_Applications` (`id`),
  ADD CONSTRAINT `FK_1B46F042896DBBDE` FOREIGN KEY (`updated_by_id`) REFERENCES `VSUM_Users` (`id`),
  ADD CONSTRAINT `FK_1B46F042B03A8386` FOREIGN KEY (`created_by_id`) REFERENCES `VSUM_Users` (`id`),
  ADD CONSTRAINT `FK_1B46F042C76F1F52` FOREIGN KEY (`deleted_by_id`) REFERENCES `VSUM_Users` (`id`);

--
-- Constraints for table `VSAPP_Settings`
--
ALTER TABLE `VSAPP_Settings`
  ADD CONSTRAINT `FK_4A491FD3E030ACD` FOREIGN KEY (`application_id`) REFERENCES `VSAPP_Applications` (`id`),
  ADD CONSTRAINT `FK_4A491FD507FAB6A` FOREIGN KEY (`maintenance_page_id`) REFERENCES `VSCMS_Pages` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `VSAPP_Taxonomy`
--
ALTER TABLE `VSAPP_Taxonomy`
  ADD CONSTRAINT `FK_1CF38905A54E9E96` FOREIGN KEY (`root_taxon_id`) REFERENCES `VSAPP_Taxons` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `VSAPP_Taxons`
--
ALTER TABLE `VSAPP_Taxons`
  ADD CONSTRAINT `FK_2661B30B727ACA70` FOREIGN KEY (`parent_id`) REFERENCES `VSAPP_Taxons` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_2661B30BA977936C` FOREIGN KEY (`tree_root`) REFERENCES `VSAPP_Taxons` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `VSAPP_TaxonTranslations`
--
ALTER TABLE `VSAPP_TaxonTranslations`
  ADD CONSTRAINT `FK_AFE16CB02C2AC5D3` FOREIGN KEY (`translatable_id`) REFERENCES `VSAPP_Taxons` (`id`);

--
-- Constraints for table `VSCMS_MultiPageToc`
--
ALTER TABLE `VSCMS_MultiPageToc`
  ADD CONSTRAINT `FK_69A01BB5B4CE9742` FOREIGN KEY (`toc_root_page_id`) REFERENCES `VSCMS_TocPage` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_B262621CF80DCA0D` FOREIGN KEY (`main_page_id`) REFERENCES `VSCMS_Pages` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `VSCMS_PageCategories`
--
ALTER TABLE `VSCMS_PageCategories`
  ADD CONSTRAINT `FK_98A43648727ACA70` FOREIGN KEY (`parent_id`) REFERENCES `VSCMS_PageCategories` (`id`),
  ADD CONSTRAINT `FK_98A43648DE13F470` FOREIGN KEY (`taxon_id`) REFERENCES `VSAPP_Taxons` (`id`);

--
-- Constraints for table `VSCMS_Pages_Categories`
--
ALTER TABLE `VSCMS_Pages_Categories`
  ADD CONSTRAINT `FK_88D3BD7612469DE2` FOREIGN KEY (`category_id`) REFERENCES `VSCMS_PageCategories` (`id`),
  ADD CONSTRAINT `FK_88D3BD76C4663E4` FOREIGN KEY (`page_id`) REFERENCES `VSCMS_Pages` (`id`);

--
-- Constraints for table `VSCMS_TocPage`
--
ALTER TABLE `VSCMS_TocPage`
  ADD CONSTRAINT `FK_F8BA64CA727ACA70` FOREIGN KEY (`parent_id`) REFERENCES `VSCMS_TocPage` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_F8BA64CAA977936C` FOREIGN KEY (`tree_root`) REFERENCES `VSCMS_TocPage` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_F8BA64CAC4663E4` FOREIGN KEY (`page_id`) REFERENCES `VSCMS_Pages` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `VSUM_ResetPasswordRequests`
--
ALTER TABLE `VSUM_ResetPasswordRequests`
  ADD CONSTRAINT `FK_D6C66D0A76ED395` FOREIGN KEY (`user_id`) REFERENCES `VSUM_Users` (`id`);

--
-- Constraints for table `VSUM_Users`
--
ALTER TABLE `VSUM_Users`
  ADD CONSTRAINT `FK_CAFDCD035D8BC1F8` FOREIGN KEY (`info_id`) REFERENCES `VSUM_UsersInfo` (`id`);

--
-- Constraints for table `VSUM_UsersActivities`
--
ALTER TABLE `VSUM_UsersActivities`
  ADD CONSTRAINT `FK_54103277A76ED395` FOREIGN KEY (`user_id`) REFERENCES `VSUM_Users` (`id`);

--
-- Constraints for table `VSUM_UsersInfo`
--
ALTER TABLE `VSUM_UsersInfo`
  ADD CONSTRAINT `FK_3ADA80CAA76ED395` FOREIGN KEY (`user_id`) REFERENCES `VSUM_Users` (`id`);

--
-- Constraints for table `VSUM_UsersNotifications`
--
ALTER TABLE `VSUM_UsersNotifications`
  ADD CONSTRAINT `FK_8D75FA15A76ED395` FOREIGN KEY (`user_id`) REFERENCES `VSUM_Users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
