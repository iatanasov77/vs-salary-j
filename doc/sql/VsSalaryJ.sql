-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 17, 2021 at 06:43 PM
-- Server version: 8.0.21
-- PHP Version: 7.4.23

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
-- Table structure for table `VSAPP_Locale`
--

CREATE TABLE `VSAPP_Locale` (
  `id` int NOT NULL,
  `code` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `VSAPP_Locale`
--

INSERT INTO `VSAPP_Locale` (`id`, `code`, `created_at`, `updated_at`) VALUES
(1, 'en_US', '2021-09-17 18:40:57', '2021-09-17 18:40:57'),
(2, 'bg_BG', '2021-09-17 18:42:01', '2021-09-17 18:42:01');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `VSAPP_LogEntries`
--

INSERT INTO `VSAPP_LogEntries` (`id`, `locale`, `action`, `logged_at`, `object_id`, `object_class`, `version`, `data`, `username`) VALUES
(1, 'en_US', 'create', '2021-09-17 18:42:02', '1', 'App\\Entity\\Cms\\Page', 1, 'a:1:{s:4:\"text\";s:27:\"<h1>Under Construction</h1>\";}', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `VSAPP_Migrations`
--

CREATE TABLE `VSAPP_Migrations` (
  `version` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `VSAPP_Migrations`
--

INSERT INTO `VSAPP_Migrations` (`version`, `executed_at`, `execution_time`) VALUES
('VS\\ApplicationBundle\\DoctrineMigrations\\Version20210615143142', '2021-09-17 18:40:15', 12020),
('VS\\ApplicationBundle\\DoctrineMigrations\\Version20210617123114', '2021-09-17 18:40:27', 3800);

-- --------------------------------------------------------

--
-- Table structure for table `VSAPP_Settings`
--

CREATE TABLE `VSAPP_Settings` (
  `id` int NOT NULL,
  `maintenanceMode` tinyint(1) NOT NULL,
  `theme` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `site_id` int DEFAULT NULL,
  `maintenance_page_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `VSAPP_Settings`
--

INSERT INTO `VSAPP_Settings` (`id`, `maintenanceMode`, `theme`, `site_id`, `maintenance_page_id`) VALUES
(1, 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `VSAPP_Sites`
--

CREATE TABLE `VSAPP_Sites` (
  `id` int NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `VSAPP_Taxonomy`
--

INSERT INTO `VSAPP_Taxonomy` (`id`, `code`, `root_taxon_id`, `name`, `description`) VALUES
(1, 'page-categories', 1, 'Page Categories', 'Page Categories');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `VSAPP_Taxons`
--

INSERT INTO `VSAPP_Taxons` (`id`, `tree_root`, `parent_id`, `code`, `tree_left`, `tree_right`, `tree_level`, `position`, `enabled`) VALUES
(1, 1, NULL, 'page-categories', 1, 4, 0, NULL, 1),
(2, 1, 1, 'maintenance-pages', 2, 3, 1, NULL, 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `VSAPP_TaxonTranslations`
--

INSERT INTO `VSAPP_TaxonTranslations` (`id`, `translatable_id`, `locale`, `name`, `slug`, `description`) VALUES
(1, 1, 'en_US', 'Root taxon of Taxonomy: \"Page Categories', 'page-categories', 'Root taxon of Taxonomy: \"Page Categories\"'),
(2, 2, 'en_US', 'Maintenance Pages', 'maintenance-pages', 'Maintenance Pages Description');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `VSAPP_Translations`
--

INSERT INTO `VSAPP_Translations` (`id`, `locale`, `object_class`, `field`, `foreign_key`, `content`) VALUES
(1, 'en_US', 'App\\Entity\\Application\\Taxonomy', 'name', '1', 'Page Categories'),
(2, 'en_US', 'App\\Entity\\Application\\Taxonomy', 'description', '1', 'Page Categories'),
(3, 'en_US', 'App\\Entity\\Cms\\Page', 'title', '1', 'Under Construction'),
(4, 'en_US', 'App\\Entity\\Cms\\Page', 'text', '1', '<h1>Under Construction</h1>');

-- --------------------------------------------------------

--
-- Table structure for table `VSCMS_PageCategories`
--

CREATE TABLE `VSCMS_PageCategories` (
  `id` int NOT NULL,
  `parent_id` int DEFAULT NULL,
  `taxon_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `VSCMS_PageCategories`
--

INSERT INTO `VSCMS_PageCategories` (`id`, `parent_id`, `taxon_id`) VALUES
(1, NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `VSCMS_Pages`
--

CREATE TABLE `VSCMS_Pages` (
  `id` int NOT NULL,
  `published` tinyint(1) NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `text` longtext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `VSCMS_Pages`
--

INSERT INTO `VSCMS_Pages` (`id`, `published`, `slug`, `title`, `text`) VALUES
(1, 1, 'under-construction', 'Under Construction', '<h1>Under Construction</h1>');

-- --------------------------------------------------------

--
-- Table structure for table `VSCMS_Pages_Categories`
--

CREATE TABLE `VSCMS_Pages_Categories` (
  `page_id` int NOT NULL,
  `category_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `VSCMS_Pages_Categories`
--

INSERT INTO `VSCMS_Pages_Categories` (`page_id`, `category_id`) VALUES
(1, 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `VSUM_Users`
--

CREATE TABLE `VSUM_Users` (
  `id` int NOT NULL,
  `info_id` int DEFAULT NULL,
  `api_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `VSUM_Users`
--

INSERT INTO `VSUM_Users` (`id`, `info_id`, `api_token`, `salt`, `password`, `roles`, `username`, `email`, `prefered_locale`, `first_name`, `last_name`, `last_login`, `confirmation_token`, `password_requested_at`, `verified`, `enabled`) VALUES
(1, NULL, 'NOT_IMPLEMETED', 'bb01c68b36316ef05441874342709bc3', '$2y$13$vw.eWboEKPqTKe6uLR9tbu1o.red8s2x7Ppy6HHl2kjWNSVCNbKSy', 'a:1:{i:0;s:16:\"ROLE_SUPER_ADMIN\";}', 'admin', 'admin@salary-j.lh', 'en_US', 'NOT_EDITED_YET', 'NOT_EDITED_YET', NULL, NULL, NULL, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `VSUM_UsersActivities`
--

CREATE TABLE `VSUM_UsersActivities` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `activity` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `VSUM_UsersNotifications`
--

CREATE TABLE `VSUM_UsersNotifications` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `notification` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

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
  ADD KEY `IDX_4A491FD507FAB6A` (`maintenance_page_id`),
  ADD KEY `IDX_4A491FD762596F6` (`site_id`);

--
-- Indexes for table `VSAPP_Sites`
--
ALTER TABLE `VSAPP_Sites`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `VSAPP_Locale`
--
ALTER TABLE `VSAPP_Locale`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `VSAPP_LogEntries`
--
ALTER TABLE `VSAPP_LogEntries`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `VSAPP_Settings`
--
ALTER TABLE `VSAPP_Settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `VSAPP_Sites`
--
ALTER TABLE `VSAPP_Sites`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `VSAPP_Taxonomy`
--
ALTER TABLE `VSAPP_Taxonomy`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `VSAPP_Taxons`
--
ALTER TABLE `VSAPP_Taxons`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `VSAPP_TaxonTranslations`
--
ALTER TABLE `VSAPP_TaxonTranslations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `VSAPP_Translations`
--
ALTER TABLE `VSAPP_Translations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `VSCMS_PageCategories`
--
ALTER TABLE `VSCMS_PageCategories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `VSCMS_Pages`
--
ALTER TABLE `VSCMS_Pages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- Constraints for table `VSAPP_Settings`
--
ALTER TABLE `VSAPP_Settings`
  ADD CONSTRAINT `FK_4A491FD507FAB6A` FOREIGN KEY (`maintenance_page_id`) REFERENCES `VSCMS_Pages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_4A491FD762596F6` FOREIGN KEY (`site_id`) REFERENCES `VSAPP_Sites` (`id`);

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
