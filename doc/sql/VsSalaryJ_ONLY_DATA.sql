-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 03, 2021 at 09:38 PM
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
(1, 1, '1', 'съединява страничен на четириконечен', 1.3, '2021-10-25 22:01:14', 2, NULL, NULL, NULL, '2021-10-25 22:01:14', NULL, 0),
(2, 1, '2', 'съединява вътрешен ръкав', 0.6, '2021-10-31 15:20:56', 2, NULL, NULL, NULL, '2021-10-31 15:20:56', NULL, 1),
(3, 1, '3', 'прикачва ръкав', 3, '2021-10-31 15:21:29', 2, NULL, NULL, NULL, '2021-10-31 15:21:29', NULL, 1),
(4, 1, '4', 'изработва хастар', 4, '2021-10-31 15:21:47', 2, NULL, NULL, NULL, '2021-10-31 15:21:47', NULL, 1),
(5, 1, '5', 'шие подгъв хастар', 2, '2021-10-31 15:22:11', 2, NULL, NULL, NULL, '2021-10-31 15:22:11', NULL, 1),
(6, 1, '6', 'шие марка фирмена', 1, '2021-10-31 15:22:27', 2, NULL, NULL, NULL, '2021-10-31 15:22:27', NULL, 1),
(7, 1, '7', 'израбтова деколте с ластик', 6, '2021-10-31 15:23:44', 2, NULL, NULL, NULL, '2021-10-31 15:23:44', NULL, 1);

--
-- Dumping data for table `JUN_Operators`
--

INSERT INTO `JUN_Operators` (`id`, `name`, `created_by_id`, `updated_at`, `application_id`, `updated_by_id`, `deleted_by_id`, `created_at`, `deleted_at`, `group_id`) VALUES
(1, 'Test Operator', NULL, '2021-10-24 12:11:56', 2, NULL, NULL, '2021-10-24 12:11:56', NULL, 1),
(2, 'Test Operator 2', NULL, '2021-10-24 12:20:15', 2, NULL, NULL, '2021-10-24 12:20:15', NULL, NULL),
(3, 'Test Operator 3', NULL, '2021-10-24 12:32:23', 2, NULL, NULL, '2021-10-24 12:32:23', NULL, NULL);

--
-- Dumping data for table `JUN_OperatorsGroups`
--

INSERT INTO `JUN_OperatorsGroups` (`id`, `name`, `taxon_id`, `application_id`) VALUES
(1, 'Test Group', 9, 2);

--
-- Dumping data for table `JUN_OperatorsWork`
--

INSERT INTO `JUN_OperatorsWork` (`id`, `application_id`, `date`, `count`, `price`, `created_at`, `updated_at`, `created_by_id`, `updated_by_id`, `deleted_by_id`, `operator_id`, `operation_id`) VALUES
(1, NULL, '2021-10-29', 5, 0.1014, '2021-11-03 09:45:08', '2021-11-03 09:45:08', NULL, NULL, NULL, 3, 1),
(2, NULL, '2021-10-29', 8, 0.0468, '2021-11-03 09:45:08', '2021-11-03 09:45:08', NULL, NULL, NULL, 2, 2);

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
(1, 'Admin Panel', 'admin.salaryj.lh', 'admin-panel', 1, '2021-12-29 06:16:15', '2021-12-29 06:16:15'),
(2, 'Salary J', 'salaryj.lh', 'salary-j', 1, '2021-12-29 06:19:19', '2021-12-29 06:19:19');

--
-- Dumping data for table `VSAPP_Locale`
--

INSERT INTO `VSAPP_Locale` (`id`, `code`, `created_at`, `updated_at`) VALUES
(1, 'en_US', '2021-12-29 06:15:54', '2021-12-29 06:15:54'),
(2, 'bg_BG', '2021-12-29 06:15:54', '2021-12-29 06:15:54');

--
-- Dumping data for table `VSAPP_LogEntries`
--

INSERT INTO `VSAPP_LogEntries` (`id`, `locale`, `action`, `logged_at`, `object_id`, `object_class`, `version`, `data`, `username`) VALUES
(1, 'en_US', 'create', '2021-12-29 06:15:55', NULL, 'App\\Entity\\Cms\\Page', 1, 'a:1:{s:4:\"text\";s:27:\"<h1>Under Construction</h1>\";}', NULL);

--
-- Dumping data for table `VSAPP_Settings`
--

INSERT INTO `VSAPP_Settings` (`id`, `maintenanceMode`, `theme`, `application_id`, `maintenance_page_id`) VALUES
(1, 0, NULL, NULL, NULL);

--
-- Dumping data for table `VSAPP_Taxonomy`
--

INSERT INTO `VSAPP_Taxonomy` (`id`, `code`, `root_taxon_id`, `name`, `description`) VALUES
(1, 'page-categories', 1, 'Page Categories', 'Page Categories'),
(2, 'user-roles', 2, 'User Roles', 'User Roles Taxonomy'),
(3, 'file-managers', 3, 'File Managers', 'FileManagers Taxonomy'),
(4, 'operators-groups', 8, 'Operators Groups', 'Operators Groups');

--
-- Dumping data for table `VSAPP_Taxons`
--

INSERT INTO `VSAPP_Taxons` (`id`, `tree_root`, `parent_id`, `code`, `tree_left`, `tree_right`, `tree_level`, `position`, `enabled`) VALUES
(1, 1, NULL, 'page-categories', 1, 4, 0, NULL, 1),
(2, 2, NULL, 'user-roles', 1, 8, 0, NULL, 1),
(3, 3, NULL, 'file-managers', 1, 2, 0, NULL, 1),
(4, 1, 1, 'maintenance-pages', 2, 3, 1, NULL, 1),
(5, 2, 2, 'role-super-admin', 2, 7, 1, NULL, 1),
(6, 2, 5, 'role-application-admin', 3, 6, 2, NULL, 1),
(7, 2, 6, 'role-salary-j', 4, 5, 3, NULL, 1),
(8, 8, NULL, 'operators-groups', 1, 6, 0, NULL, 1),
(9, 8, 8, 'test-group', 2, 3, 1, NULL, 1);

--
-- Dumping data for table `VSAPP_TaxonTranslations`
--

INSERT INTO `VSAPP_TaxonTranslations` (`id`, `translatable_id`, `locale`, `name`, `slug`, `description`) VALUES
(1, 1, 'en_US', 'Root taxon of Taxonomy: \"Page Categories', 'page-categories', 'Root taxon of Taxonomy: \"Page Categories\"'),
(2, 2, 'en_US', 'Root taxon of Taxonomy: \"User Roles', 'user-roles', 'Root taxon of Taxonomy: \"User Roles\"'),
(3, 3, 'en_US', 'Root taxon of Taxonomy: \"File Managers', 'file-managers', 'Root taxon of Taxonomy: \"File Managers\"'),
(4, 4, 'en_US', 'Maintenance Pages', 'maintenance-pages', 'Maintenance Pages Description'),
(5, 5, 'en_US', 'Role Super Admin', 'role-super-admin', 'Role Super Admin Description'),
(6, 6, 'en_US', 'Role Application Admin', 'role-application-admin', 'Role Application Admin Description'),
(7, 7, 'en_US', 'Role Salary J', 'role-salary-j', 'Salary J'),
(8, 8, 'en_US', 'Operators Groups', 'operators-groups', 'Root taxon of Taxonomy: \"Operators Groups\"'),
(9, 9, 'en_US', 'Test Group', 'test-group', NULL);

--
-- Dumping data for table `VSAPP_Translations`
--

INSERT INTO `VSAPP_Translations` (`id`, `locale`, `object_class`, `field`, `foreign_key`, `content`) VALUES
(1, 'en_US', 'App\\Entity\\Application\\Taxonomy', 'name', '1', 'Page Categories'),
(2, 'en_US', 'App\\Entity\\Application\\Taxonomy', 'description', '1', 'Page Categories'),
(3, 'en_US', 'App\\Entity\\Application\\Taxonomy', 'name', '2', 'User Roles'),
(4, 'en_US', 'App\\Entity\\Application\\Taxonomy', 'description', '2', 'User Roles Taxonomy'),
(5, 'en_US', 'App\\Entity\\Application\\Taxonomy', 'name', '3', 'File Managers'),
(6, 'en_US', 'App\\Entity\\Application\\Taxonomy', 'description', '3', 'FileManagers Taxonomy'),
(7, 'en_US', 'App\\Entity\\Cms\\Page', 'title', '1', 'Under Construction'),
(8, 'en_US', 'App\\Entity\\Cms\\Page', 'text', '1', '<h1>Under Construction</h1>'),
(9, 'en_US', 'App\\Entity\\Application\\Taxonomy', 'name', '4', 'Operators Groups'),
(10, 'en_US', 'App\\Entity\\Application\\Taxonomy', 'description', '4', 'Operators Groups');

--
-- Dumping data for table `VSCMS_PageCategories`
--

INSERT INTO `VSCMS_PageCategories` (`id`, `parent_id`, `taxon_id`) VALUES
(1, NULL, 4);

--
-- Dumping data for table `VSCMS_Pages`
--

INSERT INTO `VSCMS_Pages` (`id`, `published`, `slug`, `title`, `text`, `description`) VALUES
(1, 1, 'under-construction', 'Under Construction', '<h1>Under Construction</h1>', NULL);

--
-- Dumping data for table `VSCMS_Pages_Categories`
--

INSERT INTO `VSCMS_Pages_Categories` (`page_id`, `category_id`) VALUES
(1, 1);

--
-- Dumping data for table `VSUM_AvatarImage`
--

INSERT INTO `VSUM_AvatarImage` (`id`, `owner_id`, `type`, `path`) VALUES
(1, 1, NULL, 'fd/c5/670f9399097b53605412141ffebd.png'),
(2, 2, NULL, '59/45/1d97bb6d421cab009b640d20f008.png');

--
-- Dumping data for table `VSUM_UserRoles`
--

INSERT INTO `VSUM_UserRoles` (`id`, `parent_id`, `taxon_id`, `role`) VALUES
(1, NULL, 5, 'ROLE_SUPER_ADMIN'),
(2, 1, 6, 'ROLE_APPLICATION_ADMIN'),
(3, 2, 7, 'ROLE_SALARY_J_ADMIN');

--
-- Dumping data for table `VSUM_Users`
--

INSERT INTO `VSUM_Users` (`id`, `info_id`, `api_token`, `salt`, `password`, `roles_array`, `username`, `email`, `prefered_locale`, `last_login`, `confirmation_token`, `password_requested_at`, `verified`, `enabled`) VALUES
(1, 1, 'NOT_IMPLEMETED', '38a5cc8252bb0641628e078631a139be', '$2y$13$n7/2r8Cosq8hGVfcp6ECW.mrQh2kLtsLseSIk3Wi6dwEIOkMsWnxK', 'a:1:{i:0;s:16:\"ROLE_SUPER_ADMIN\";}', 'admin', 'admin@salaryj.lh', 'en_US', NULL, NULL, NULL, 1, 1),
(2, 2, 'NOT_IMPLEMETED', '66369273653dfffe87aa2845d08a930a', '$2y$13$GFRS89or1SKTGJ3rVg.NCero/eCWG5pOSTCJJYUzc5z0UjJHzxpvu', 'a:1:{i:0;s:22:\"ROLE_APPLICATION_ADMIN\";}', 'junona', 'junona@salaryj.lh', 'en_US', NULL, NULL, NULL, 1, 1);

--
-- Dumping data for table `VSUM_UsersInfo`
--

INSERT INTO `VSUM_UsersInfo` (`id`, `country`, `birthday`, `mobile`, `website`, `occupation`, `first_name`, `last_name`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, 'Super', 'Admin'),
(2, NULL, NULL, NULL, NULL, NULL, 'Applications', 'Admin');

--
-- Dumping data for table `VSUM_Users_Roles`
--

INSERT INTO `VSUM_Users_Roles` (`user_id`, `role_id`) VALUES
(1, 1),
(2, 2);

-- --------------------------------------------------------
--
-- Structure for view `JUN_OperatorsWorkTotals`
--
DROP TABLE IF EXISTS `JUN_OperatorsWorkTotals`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `JUN_OperatorsWorkTotals`  AS SELECT `JUN_OperatorsWork`.`id` AS `id`, `JUN_OperatorsWork`.`operator_id` AS `operators_id`, `JUN_OperatorsWork`.`operation_id` AS `operations_id`, `JUN_OperatorsWork`.`price` AS `price`, `JUN_OperatorsWork`.`count` AS `count`, round((`JUN_OperatorsWork`.`count` * `JUN_OperatorsWork`.`price`),2) AS `total`, `JUN_OperatorsWork`.`date` AS `date`, `JUN_Operators`.`group_id` AS `group_id`, `JUN_Operators`.`name` AS `operator_name`, `JUN_Operations`.`operation_id` AS `operation_id`, `JUN_Operations`.`operation_name` AS `operation_name`, `JUN_Models`.`id` AS `models_id`, `JUN_Models`.`number` AS `model_number`, `JUN_Models`.`name` AS `model_name` FROM (((`JUN_OperatorsWork` join `JUN_Operators`) join `JUN_Operations`) join `JUN_Models`) WHERE ((`JUN_Operators`.`id` = `JUN_OperatorsWork`.`operator_id`) AND (`JUN_Operations`.`id` = `JUN_OperatorsWork`.`operation_id`) AND (`JUN_Models`.`id` = `JUN_Operations`.`model_id`)) ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
