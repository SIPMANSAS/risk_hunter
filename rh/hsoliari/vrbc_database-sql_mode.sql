-- phpMyAdmin SQL Dump
-- version 4.4.15.9
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 09, 2018 at 03:35 PM
-- Server version: 5.6.37
-- PHP Version: 7.1.8


SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


-- --------------------------------------------------------

--
-- Table structure for table `calendar_data`
--

DROP TABLE IF EXISTS `calendar_data`;
CREATE TABLE IF NOT EXISTS `calendar_data` (
  `id` bigint(20) NOT NULL,
  `bookingid` int(11) NOT NULL DEFAULT '0',
  `daypart` tinyint(1) DEFAULT NULL,
  `bookingdate` date DEFAULT NULL,
  `status` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `calendar_details`
--

DROP TABLE IF EXISTS `calendar_details`;
CREATE TABLE IF NOT EXISTS `calendar_details` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL DEFAULT '1',
  `ppttypeid` int(11) DEFAULT NULL,
  `checkin` date NOT NULL DEFAULT '0000-00-00',
  `checkout` date DEFAULT '0000-00-00',
  `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) DEFAULT '0',
  `updated` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updaterid` int(11) NOT NULL DEFAULT '0',
  `guestname` varchar(50) DEFAULT NULL,
  `guestemail` varchar(80) DEFAULT NULL,
  `guestphone` varchar(50) DEFAULT NULL,
  `guestcountry` varchar(20) DEFAULT NULL,
  `guestadult` int(4) DEFAULT '0',
  `guestchild` int(4) DEFAULT '0',
  `note_en` text,
  `amount` decimal(9,2) NOT NULL DEFAULT '0.00',
  `deposit` decimal(9,2) NOT NULL DEFAULT '0.00',
  `balancedue` decimal(9,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `calendar_files`
--

DROP TABLE IF EXISTS `calendar_files`;
CREATE TABLE IF NOT EXISTS `calendar_files` (
  `id` int(11) NOT NULL,
  `bookingid` int(11) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `filetitle` varchar(100) DEFAULT NULL,
  `updated` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `property_blockstatuses`
--

DROP TABLE IF EXISTS `property_blockstatuses`;
CREATE TABLE IF NOT EXISTS `property_blockstatuses` (
  `id` int(11) NOT NULL,
  `status` varchar(50) DEFAULT NULL,
  `title_en` varchar(50) DEFAULT NULL,
  `title_ms` varchar(50) DEFAULT NULL,
  `title_fr` varchar(50) DEFAULT NULL,
  `title_it` varchar(50) DEFAULT NULL,
  `title_pt` varchar(50) DEFAULT NULL,
  `title_nl` varchar(50) DEFAULT NULL,
  `title_es` varchar(50) DEFAULT NULL,
  `title_de` varchar(50) DEFAULT NULL,
  `colorhex` varchar(7) DEFAULT NULL,
  `desc` varchar(20) DEFAULT NULL,
  `inuse` tinyint(1) NOT NULL DEFAULT '0',
  `sort` int(11) DEFAULT NULL,
  `reserved` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `property_blockstatuses`
--

INSERT INTO `property_blockstatuses` (`id`, `status`, `title_en`, `title_ms`, `title_fr`, `title_it`, `title_pt`, `title_nl`, `title_es`, `title_de`, `colorhex`, `desc`, `inuse`, `sort`, `reserved`) VALUES
(1, 'Available', 'Available', 'Tersedia', 'Disponible', 'A Disposizione', 'Acessível', 'Beschikbaar', 'Disponible', 'Verfügbar', '#ffffff', NULL, 1, 0, 1),
(2, 'Hold Tentative', 'Hold Tentative', 'Tentatif', 'Provisoire', 'Provvisorio', 'Tentativa', 'Voorlopig', 'Tentativo', 'Vorläufig', '#ffd700', NULL, 1, 1, 0),
(3, 'Confirmed', 'Confirmed', 'Disahkan', 'Confirmé', 'Confermato', 'Confirmado', 'Bevestigd', 'Confirmado', 'Bestätigt', '#fb8072', NULL, 1, 2, 0),
(4, 'Confirmed with Deposit', 'Confirmed with Deposit', 'Disahkan dengan Deposit', 'Confirmé avec Caution', 'Confermato con Deposito', 'Confirmado com Depósito', 'Bevestigd met Deposito', 'Confirmado con Depósito', 'Bestätigt mit Einzahlung', '#1ddbdb', NULL, 1, 3, 0),
(5, 'Full Paid', 'Full Paid', 'Dibayar Sepenuhnya', 'Entièrement Payé', 'Pagato Interamente', 'Totalmente Pago', 'Volledig Betaald', 'Totalmente Pagado', 'Voll Bezahlt', '#75d586', NULL, 1, 4, 0),
(6, 'Renovation', 'Renovation', 'Pengubahsuaian', 'Rénovation', 'Rinnovamento', 'Renovação', 'Vernieuwing', 'Renovación', 'Renovierung', '#cccccc', NULL, 1, 5, 0),
(7, 'Owner Use', 'Owner Stay', 'Owner Stay', 'Séjour du Propriétaire', 'Proprietario Soggiorno', 'Estada do Proprietário', 'Eigenaar Verblijf', 'Propietario Estancia', 'Besitzer Aufenthalt', '#cb8deb', NULL, 1, 6, 0),
(8, 'Complimentary', 'Complimentary', 'Percuma', 'Complimentary', 'In Omaggio', 'Complimentary', 'Gratis', 'Complementario', 'Kostenlos', '#e5c494', NULL, 1, 7, 0),
(9, 'Booked', 'Not Available', 'Tidak Tersedia', 'Indisponible', 'Non Disponibile', 'Não Disponível', 'Niet Beschikbaar', 'No Disponible', 'Nicht Verfügbar', '#e1e1fa', '(For Standard View)', 1, 8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `property_config`
--

DROP TABLE IF EXISTS `property_config`;
CREATE TABLE IF NOT EXISTS `property_config` (
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `locked` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `property_config`
--

INSERT INTO `property_config` (`name`, `email`, `phone`, `address`, `locked`) VALUES
('Your Property Name', 'mail@yoursite.com', '+887000000', 'Your Property Address', 0);

-- --------------------------------------------------------

--
-- Table structure for table `property_types`
--

DROP TABLE IF EXISTS `property_types`;
CREATE TABLE IF NOT EXISTS `property_types` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `publish` tinyint(1) NOT NULL DEFAULT '0',
  `locked` tinyint(1) NOT NULL DEFAULT '1',
  `sort` int(11) DEFAULT NULL,
  `hideinpub` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `property_types`
--

INSERT INTO `property_types` (`id`, `name`, `publish`, `locked`, `sort`, `hideinpub`) VALUES
(40, 'Example Property Type', 1, 0, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sys_config`
--

DROP TABLE IF EXISTS `sys_config`;
CREATE TABLE IF NOT EXISTS `sys_config` (
  `cid` int(11) NOT NULL,
  `sysappname` varchar(50) DEFAULT NULL,
  `sysappver` varchar(10) DEFAULT NULL,
  `notify_oncreate` tinyint(1) NOT NULL DEFAULT '0',
  `notify_onupdate` tinyint(1) NOT NULL DEFAULT '0',
  `notify_ondelete` tinyint(1) NOT NULL DEFAULT '0',
  `show_publiccal` tinyint(1) NOT NULL DEFAULT '0',
  `expinfo_status` tinyint(1) NOT NULL DEFAULT '0',
  `expinfo_guestname` tinyint(1) NOT NULL DEFAULT '0',
  `expinfo_guestnum` tinyint(1) NOT NULL DEFAULT '0',
  `expinfo_guestcountry` tinyint(1) NOT NULL DEFAULT '0',
  `expinfo_remarks` tinyint(1) NOT NULL DEFAULT '0',
  `expinfo_pptaddress` tinyint(1) NOT NULL DEFAULT '0',
  `publiccal_view` tinyint(3) DEFAULT NULL,
  `publiccal_urlonly` tinyint(1) NOT NULL DEFAULT '0',
  `sysdeflanguage` varchar(5) DEFAULT NULL,
  `sysuicorners` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sys_config`
--

INSERT INTO `sys_config` (`cid`, `sysappname`, `sysappver`, `notify_oncreate`, `notify_onupdate`, `notify_ondelete`, `show_publiccal`, `expinfo_status`, `expinfo_guestname`, `expinfo_guestnum`, `expinfo_guestcountry`, `expinfo_remarks`, `expinfo_pptaddress`, `publiccal_view`, `publiccal_urlonly`, `sysdeflanguage`, `sysuicorners`) VALUES
(1, 'Vacation Rentals Booking Calendar', '1.1.1', 1, 0, 0, 1, 1, 1, 1, 1, 1, 1, 12, 0, 'en', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sys_language`
--

DROP TABLE IF EXISTS `sys_language`;
CREATE TABLE IF NOT EXISTS `sys_language` (
  `id` int(4) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `abbr` varchar(5) DEFAULT NULL,
  `direction` enum('ltr','rtl') DEFAULT 'ltr',
  `publish` tinyint(1) DEFAULT '0',
  `sort` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `sys_language`
--

INSERT INTO `sys_language` (`id`, `name`, `abbr`, `direction`, `publish`, `sort`) VALUES
(1, 'English', 'en', 'ltr', 1, 0),
(2, 'Deutsche', 'de', 'ltr', 1, 2),
(3, 'Español', 'es', 'ltr', 1, 3),
(4, 'Nederlands', 'nl', 'ltr', 1, 7),
(5, 'Português', 'pt', 'ltr', 1, 8),
(6, 'Italiano', 'it', 'ltr', 1, 5),
(7, 'Français', 'fr', 'ltr', 1, 4),
(8, 'Malay', 'ms', 'ltr', 1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `sys_log`
--

DROP TABLE IF EXISTS `sys_log`;
CREATE TABLE IF NOT EXISTS `sys_log` (
  `id` int(6) NOT NULL,
  `user_id` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `failed` tinyint(5) NOT NULL,
  `failed_last` int(11) NOT NULL,
  `type` enum('system','admin','user') NOT NULL,
  `message` text NOT NULL,
  `info_icon` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'default',
  `importance` enum('yes','no') NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `sys_mailtemplates`
--

DROP TABLE IF EXISTS `sys_mailtemplates`;
CREATE TABLE IF NOT EXISTS `sys_mailtemplates` (
  `id` int(5) NOT NULL,
  `name_en` varchar(200) NOT NULL,
  `subject_en` varchar(255) NOT NULL,
  `subject_ms` varchar(255) NOT NULL,
  `subject_fr` varchar(255) NOT NULL,
  `subject_it` varchar(255) NOT NULL,
  `subject_pt` varchar(255) NOT NULL,
  `subject_nl` varchar(255) NOT NULL,
  `subject_es` varchar(255) NOT NULL,
  `subject_de` varchar(255) NOT NULL,
  `help_en` text,
  `body_en` text,
  `body_ms` text,
  `body_fr` text,
  `body_it` text,
  `body_pt` text,
  `body_nl` text,
  `body_es` text,
  `body_de` text,
  `type` enum('news','mailer') DEFAULT 'mailer',
  `typeid` varchar(50) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `sys_mailtemplates`
--

INSERT INTO `sys_mailtemplates` (`id`, `name_en`, `subject_en`, `subject_ms`, `subject_fr`, `subject_it`, `subject_pt`, `subject_nl`, `subject_es`, `subject_de`, `help_en`, `body_en`, `body_ms`, `body_fr`, `body_it`, `body_pt`, `body_nl`, `body_es`, `body_de`, `type`, `typeid`) VALUES
(1, 'Welcome Mail From Admin', 'You Have Been Registered', 'You Have Been Registered', 'You Have Been Registered', 'You Have Been Registered', 'You Have Been Registered', 'You Have Been Registered', 'You Have Been Registered', 'You Have Been Registered', 'This template is used to send welcome email, when user is added by administrator', '&lt;div align=&quot;center&quot;&gt;\n&lt;table style=&quot;border: 2px solid #cccccc; width: 95%; font-family: sans-serif; font-size: 14px;&quot; border=&quot;0&quot; cellspacing=&quot;5&quot; cellpadding=&quot;5&quot;&gt;\n&lt;tbody&gt;\n&lt;tr&gt;\n&lt;td style=&quot;text-align: left;&quot;&gt;\n&lt;p&gt;Dear [NAME],&lt;/p&gt;\n&lt;p&gt;&lt;br /&gt; &lt;br /&gt; You have been registered by the Administrator. You&#039;re now a member of [SITENAME]&lt;br /&gt; &lt;br /&gt; Here are your login details. Please keep them in a safe place:&lt;br /&gt; &lt;/p&gt;\n&lt;p&gt;Email: &lt;strong&gt;[EMAIL]&lt;/strong&gt;&lt;br /&gt;Username: &lt;strong&gt;[USERNAME]&lt;/strong&gt;&lt;br /&gt; Password: &lt;strong&gt;[PASSWORD]&lt;/strong&gt;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr&gt;\n&lt;td style=&quot;text-align: left;&quot;&gt;\n&lt;p&gt;Regards,&lt;em&gt;&lt;br /&gt;&lt;/em&gt;&lt;/p&gt;\n&lt;p&gt;&lt;em&gt;&lt;br /&gt;&lt;/em&gt; [SIGNATURE]&lt;em&gt;&lt;br /&gt; &lt;/em&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;/tbody&gt;\n&lt;/table&gt;\n&lt;/div&gt;', '&lt;div align=&quot;center&quot;&gt;\n&lt;table style=&quot;border: 2px solid #cccccc; width: 95%; font-family: sans-serif; font-size: 14px;&quot; border=&quot;0&quot; cellspacing=&quot;5&quot; cellpadding=&quot;5&quot;&gt;\n&lt;tbody&gt;\n&lt;tr&gt;\n&lt;td style=&quot;text-align: left;&quot;&gt;\n&lt;p&gt;Dear [NAME],&lt;/p&gt;\n&lt;p&gt;&lt;br /&gt; &lt;br /&gt; You have been registered by the Administrator. You&#039;re now a member of [SITENAME]&lt;br /&gt; &lt;br /&gt; Here are your login details. Please keep them in a safe place:&lt;br /&gt; &lt;/p&gt;\n&lt;p&gt;Email: &lt;strong&gt;[EMAIL]&lt;/strong&gt;&lt;br /&gt;Username: &lt;strong&gt;[USERNAME]&lt;/strong&gt;&lt;br /&gt; Password: &lt;strong&gt;[PASSWORD]&lt;/strong&gt;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr&gt;\n&lt;td style=&quot;text-align: left;&quot;&gt;\n&lt;p&gt;Regards,&lt;em&gt;&lt;br /&gt;&lt;/em&gt;&lt;/p&gt;\n&lt;p&gt;&lt;em&gt;&lt;br /&gt;&lt;/em&gt; [SIGNATURE]&lt;em&gt;&lt;br /&gt; &lt;/em&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;/tbody&gt;\n&lt;/table&gt;\n&lt;/div&gt;', '&lt;div align=&quot;center&quot;&gt;\n&lt;table style=&quot;border: 2px solid #cccccc; width: 95%; font-family: sans-serif; font-size: 14px;&quot; border=&quot;0&quot; cellspacing=&quot;5&quot; cellpadding=&quot;5&quot;&gt;\n&lt;tbody&gt;\n&lt;tr&gt;\n&lt;td style=&quot;text-align: left;&quot;&gt;\n&lt;p&gt;Dear [NAME],&lt;/p&gt;\n&lt;p&gt;&lt;br /&gt; &lt;br /&gt; You have been registered by the Administrator. You&#039;re now a member of [SITENAME]&lt;br /&gt; &lt;br /&gt; Here are your login details. Please keep them in a safe place:&lt;br /&gt; &lt;/p&gt;\n&lt;p&gt;Email: &lt;strong&gt;[EMAIL]&lt;/strong&gt;&lt;br /&gt;Username: &lt;strong&gt;[USERNAME]&lt;/strong&gt;&lt;br /&gt; Password: &lt;strong&gt;[PASSWORD]&lt;/strong&gt;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr&gt;\n&lt;td style=&quot;text-align: left;&quot;&gt;\n&lt;p&gt;Regards,&lt;em&gt;&lt;br /&gt;&lt;/em&gt;&lt;/p&gt;\n&lt;p&gt;&lt;em&gt;&lt;br /&gt;&lt;/em&gt; [SIGNATURE]&lt;em&gt;&lt;br /&gt; &lt;/em&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;/tbody&gt;\n&lt;/table&gt;\n&lt;/div&gt;', '&lt;div align=&quot;center&quot;&gt;\n&lt;table style=&quot;border: 2px solid #cccccc; width: 95%; font-family: sans-serif; font-size: 14px;&quot; border=&quot;0&quot; cellspacing=&quot;5&quot; cellpadding=&quot;5&quot;&gt;\n&lt;tbody&gt;\n&lt;tr&gt;\n&lt;td style=&quot;text-align: left;&quot;&gt;\n&lt;p&gt;Dear [NAME],&lt;/p&gt;\n&lt;p&gt;&lt;br /&gt; &lt;br /&gt; You have been registered by the Administrator. You&#039;re now a member of [SITENAME]&lt;br /&gt; &lt;br /&gt; Here are your login details. Please keep them in a safe place:&lt;br /&gt; &lt;/p&gt;\n&lt;p&gt;Email: &lt;strong&gt;[EMAIL]&lt;/strong&gt;&lt;br /&gt;Username: &lt;strong&gt;[USERNAME]&lt;/strong&gt;&lt;br /&gt; Password: &lt;strong&gt;[PASSWORD]&lt;/strong&gt;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr&gt;\n&lt;td style=&quot;text-align: left;&quot;&gt;\n&lt;p&gt;Regards,&lt;em&gt;&lt;br /&gt;&lt;/em&gt;&lt;/p&gt;\n&lt;p&gt;&lt;em&gt;&lt;br /&gt;&lt;/em&gt; [SIGNATURE]&lt;em&gt;&lt;br /&gt; &lt;/em&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;/tbody&gt;\n&lt;/table&gt;\n&lt;/div&gt;', '&lt;div align=&quot;center&quot;&gt;\n&lt;table style=&quot;border: 2px solid #cccccc; width: 95%; font-family: sans-serif; font-size: 14px;&quot; border=&quot;0&quot; cellspacing=&quot;5&quot; cellpadding=&quot;5&quot;&gt;\n&lt;tbody&gt;\n&lt;tr&gt;\n&lt;td style=&quot;text-align: left;&quot;&gt;\n&lt;p&gt;Dear [NAME],&lt;/p&gt;\n&lt;p&gt;&lt;br /&gt; &lt;br /&gt; You have been registered by the Administrator. You&#039;re now a member of [SITENAME]&lt;br /&gt; &lt;br /&gt; Here are your login details. Please keep them in a safe place:&lt;br /&gt; &lt;/p&gt;\n&lt;p&gt;Email: &lt;strong&gt;[EMAIL]&lt;/strong&gt;&lt;br /&gt;Username: &lt;strong&gt;[USERNAME]&lt;/strong&gt;&lt;br /&gt; Password: &lt;strong&gt;[PASSWORD]&lt;/strong&gt;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr&gt;\n&lt;td style=&quot;text-align: left;&quot;&gt;\n&lt;p&gt;Regards,&lt;em&gt;&lt;br /&gt;&lt;/em&gt;&lt;/p&gt;\n&lt;p&gt;&lt;em&gt;&lt;br /&gt;&lt;/em&gt; [SIGNATURE]&lt;em&gt;&lt;br /&gt; &lt;/em&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;/tbody&gt;\n&lt;/table&gt;\n&lt;/div&gt;', '&lt;div align=&quot;center&quot;&gt;\n&lt;table style=&quot;border: 2px solid #cccccc; width: 95%; font-family: sans-serif; font-size: 14px;&quot; border=&quot;0&quot; cellspacing=&quot;5&quot; cellpadding=&quot;5&quot;&gt;\n&lt;tbody&gt;\n&lt;tr&gt;\n&lt;td style=&quot;text-align: left;&quot;&gt;\n&lt;p&gt;Dear [NAME],&lt;/p&gt;\n&lt;p&gt;&lt;br /&gt; &lt;br /&gt; You have been registered by the Administrator. You&#039;re now a member of [SITENAME]&lt;br /&gt; &lt;br /&gt; Here are your login details. Please keep them in a safe place:&lt;br /&gt; &lt;/p&gt;\n&lt;p&gt;Email: &lt;strong&gt;[EMAIL]&lt;/strong&gt;&lt;br /&gt;Username: &lt;strong&gt;[USERNAME]&lt;/strong&gt;&lt;br /&gt; Password: &lt;strong&gt;[PASSWORD]&lt;/strong&gt;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr&gt;\n&lt;td style=&quot;text-align: left;&quot;&gt;\n&lt;p&gt;Regards,&lt;em&gt;&lt;br /&gt;&lt;/em&gt;&lt;/p&gt;\n&lt;p&gt;&lt;em&gt;&lt;br /&gt;&lt;/em&gt; [SIGNATURE]&lt;em&gt;&lt;br /&gt; &lt;/em&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;/tbody&gt;\n&lt;/table&gt;\n&lt;/div&gt;', '&lt;div align=&quot;center&quot;&gt;\n&lt;table style=&quot;border: 2px solid #cccccc; width: 95%; font-family: sans-serif; font-size: 14px;&quot; border=&quot;0&quot; cellspacing=&quot;5&quot; cellpadding=&quot;5&quot;&gt;\n&lt;tbody&gt;\n&lt;tr&gt;\n&lt;td style=&quot;text-align: left;&quot;&gt;\n&lt;p&gt;Dear [NAME],&lt;/p&gt;\n&lt;p&gt;&lt;br /&gt; &lt;br /&gt; You have been registered by the Administrator. You&#039;re now a member of [SITENAME]&lt;br /&gt; &lt;br /&gt; Here are your login details. Please keep them in a safe place:&lt;br /&gt; &lt;/p&gt;\n&lt;p&gt;Email: &lt;strong&gt;[EMAIL]&lt;/strong&gt;&lt;br /&gt;Username: &lt;strong&gt;[USERNAME]&lt;/strong&gt;&lt;br /&gt; Password: &lt;strong&gt;[PASSWORD]&lt;/strong&gt;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr&gt;\n&lt;td style=&quot;text-align: left;&quot;&gt;\n&lt;p&gt;Regards,&lt;em&gt;&lt;br /&gt;&lt;/em&gt;&lt;/p&gt;\n&lt;p&gt;&lt;em&gt;&lt;br /&gt;&lt;/em&gt; [SIGNATURE]&lt;em&gt;&lt;br /&gt; &lt;/em&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;/tbody&gt;\n&lt;/table&gt;\n&lt;/div&gt;', '&lt;div align=&quot;center&quot;&gt;\n&lt;table style=&quot;border: 2px solid #cccccc; width: 95%; font-family: sans-serif; font-size: 14px;&quot; border=&quot;0&quot; cellspacing=&quot;5&quot; cellpadding=&quot;5&quot;&gt;\n&lt;tbody&gt;\n&lt;tr&gt;\n&lt;td style=&quot;text-align: left;&quot;&gt;\n&lt;p&gt;Dear [NAME],&lt;/p&gt;\n&lt;p&gt;&lt;br /&gt; &lt;br /&gt; You have been registered by the Administrator. You&#039;re now a member of [SITENAME]&lt;br /&gt; &lt;br /&gt; Here are your login details. Please keep them in a safe place:&lt;br /&gt; &lt;/p&gt;\n&lt;p&gt;Email: &lt;strong&gt;[EMAIL]&lt;/strong&gt;&lt;br /&gt;Username: &lt;strong&gt;[USERNAME]&lt;/strong&gt;&lt;br /&gt; Password: &lt;strong&gt;[PASSWORD]&lt;/strong&gt;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr&gt;\n&lt;td style=&quot;text-align: left;&quot;&gt;\n&lt;p&gt;Regards,&lt;em&gt;&lt;br /&gt;&lt;/em&gt;&lt;/p&gt;\n&lt;p&gt;&lt;em&gt;&lt;br /&gt;&lt;/em&gt; [SIGNATURE]&lt;em&gt;&lt;br /&gt; &lt;/em&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;/tbody&gt;\n&lt;/table&gt;\n&lt;/div&gt;', 'mailer', NULL),
(2, 'Account Updated From Admin', 'Your Account Has Been Updated', 'Your Account Has Been Updated', 'Your Account Has Been Updated', 'Your Account Has Been Updated', 'Your Account Has Been Updated', 'Your Account Has Been Updated', 'Your Account Has Been Updated', 'Your Account Has Been Updated', 'This template is used to send notification email, when user updated by administrator', '&lt;div align=&quot;center&quot;&gt;\n&lt;table style=&quot;border: 2px solid #cccccc; width: 95%; font-family: sans-serif; font-size: 14px;&quot; border=&quot;0&quot; cellspacing=&quot;5&quot; cellpadding=&quot;5&quot;&gt;\n&lt;tbody&gt;\n&lt;tr&gt;\n&lt;td style=&quot;text-align: left;&quot;&gt;\n&lt;p&gt;Dear [NAME],&lt;/p&gt;\n&lt;p&gt;&lt;br /&gt; &lt;br /&gt; Your account on [SITENAME] has been updated by the Administrator&lt;br /&gt; &lt;br /&gt; Here are your login details. Please keep them in a safe place:&lt;br /&gt; &lt;/p&gt;\n&lt;p&gt;Email: &lt;strong&gt;[EMAIL]&lt;/strong&gt;&lt;br /&gt;Username: &lt;strong&gt;[USERNAME]&lt;/strong&gt;&lt;br /&gt; Password: &lt;strong&gt;[PASSWORD]&lt;/strong&gt;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr&gt;\n&lt;td style=&quot;text-align: left;&quot;&gt;\n&lt;p&gt;Regards,&lt;em&gt;&lt;br /&gt;&lt;/em&gt;&lt;/p&gt;\n&lt;p&gt;&lt;em&gt;&lt;br /&gt;&lt;/em&gt; [SIGNATURE]&lt;em&gt;&lt;br /&gt; &lt;/em&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;/tbody&gt;\n&lt;/table&gt;\n&lt;/div&gt;', '&lt;div align=&quot;center&quot;&gt;\n&lt;table style=&quot;border: 2px solid #cccccc; width: 95%; font-family: sans-serif; font-size: 14px;&quot; border=&quot;0&quot; cellspacing=&quot;5&quot; cellpadding=&quot;5&quot;&gt;\n&lt;tbody&gt;\n&lt;tr&gt;\n&lt;td style=&quot;text-align: left;&quot;&gt;\n&lt;p&gt;Dear [NAME],&lt;/p&gt;\n&lt;p&gt;&lt;br /&gt; &lt;br /&gt; Your account on [SITENAME] has been updated by the Administrator&lt;br /&gt; &lt;br /&gt; Here are your login details. Please keep them in a safe place:&lt;br /&gt; &lt;/p&gt;\n&lt;p&gt;Email: &lt;strong&gt;[EMAIL]&lt;/strong&gt;&lt;br /&gt;Username: &lt;strong&gt;[USERNAME]&lt;/strong&gt;&lt;br /&gt; Password: &lt;strong&gt;[PASSWORD]&lt;/strong&gt;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr&gt;\n&lt;td style=&quot;text-align: left;&quot;&gt;\n&lt;p&gt;Regards,&lt;em&gt;&lt;br /&gt;&lt;/em&gt;&lt;/p&gt;\n&lt;p&gt;&lt;em&gt;&lt;br /&gt;&lt;/em&gt; [SIGNATURE]&lt;em&gt;&lt;br /&gt; &lt;/em&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;/tbody&gt;\n&lt;/table&gt;\n&lt;/div&gt;', '&lt;div align=&quot;center&quot;&gt;\n&lt;table style=&quot;border: 2px solid #cccccc; width: 95%; font-family: sans-serif; font-size: 14px;&quot; border=&quot;0&quot; cellspacing=&quot;5&quot; cellpadding=&quot;5&quot;&gt;\n&lt;tbody&gt;\n&lt;tr&gt;\n&lt;td style=&quot;text-align: left;&quot;&gt;\n&lt;p&gt;Dear [NAME],&lt;/p&gt;\n&lt;p&gt;&lt;br /&gt; &lt;br /&gt; Your account on [SITENAME] has been updated by the Administrator&lt;br /&gt; &lt;br /&gt; Here are your login details. Please keep them in a safe place:&lt;br /&gt; &lt;/p&gt;\n&lt;p&gt;Email: &lt;strong&gt;[EMAIL]&lt;/strong&gt;&lt;br /&gt;Username: &lt;strong&gt;[USERNAME]&lt;/strong&gt;&lt;br /&gt; Password: &lt;strong&gt;[PASSWORD]&lt;/strong&gt;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr&gt;\n&lt;td style=&quot;text-align: left;&quot;&gt;\n&lt;p&gt;Regards,&lt;em&gt;&lt;br /&gt;&lt;/em&gt;&lt;/p&gt;\n&lt;p&gt;&lt;em&gt;&lt;br /&gt;&lt;/em&gt; [SIGNATURE]&lt;em&gt;&lt;br /&gt; &lt;/em&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;/tbody&gt;\n&lt;/table&gt;\n&lt;/div&gt;', '&lt;div align=&quot;center&quot;&gt;\n&lt;table style=&quot;border: 2px solid #cccccc; width: 95%; font-family: sans-serif; font-size: 14px;&quot; border=&quot;0&quot; cellspacing=&quot;5&quot; cellpadding=&quot;5&quot;&gt;\n&lt;tbody&gt;\n&lt;tr&gt;\n&lt;td style=&quot;text-align: left;&quot;&gt;\n&lt;p&gt;Dear [NAME],&lt;/p&gt;\n&lt;p&gt;&lt;br /&gt; &lt;br /&gt; Your account on [SITENAME] has been updated by the Administrator&lt;br /&gt; &lt;br /&gt; Here are your login details. Please keep them in a safe place:&lt;br /&gt; &lt;/p&gt;\n&lt;p&gt;Email: &lt;strong&gt;[EMAIL]&lt;/strong&gt;&lt;br /&gt;Username: &lt;strong&gt;[USERNAME]&lt;/strong&gt;&lt;br /&gt; Password: &lt;strong&gt;[PASSWORD]&lt;/strong&gt;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr&gt;\n&lt;td style=&quot;text-align: left;&quot;&gt;\n&lt;p&gt;Regards,&lt;em&gt;&lt;br /&gt;&lt;/em&gt;&lt;/p&gt;\n&lt;p&gt;&lt;em&gt;&lt;br /&gt;&lt;/em&gt; [SIGNATURE]&lt;em&gt;&lt;br /&gt; &lt;/em&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;/tbody&gt;\n&lt;/table&gt;\n&lt;/div&gt;', '&lt;div align=&quot;center&quot;&gt;\n&lt;table style=&quot;border: 2px solid #cccccc; width: 95%; font-family: sans-serif; font-size: 14px;&quot; border=&quot;0&quot; cellspacing=&quot;5&quot; cellpadding=&quot;5&quot;&gt;\n&lt;tbody&gt;\n&lt;tr&gt;\n&lt;td style=&quot;text-align: left;&quot;&gt;\n&lt;p&gt;Dear [NAME],&lt;/p&gt;\n&lt;p&gt;&lt;br /&gt; &lt;br /&gt; Your account on [SITENAME] has been updated by the Administrator&lt;br /&gt; &lt;br /&gt; Here are your login details. Please keep them in a safe place:&lt;br /&gt; &lt;/p&gt;\n&lt;p&gt;Email: &lt;strong&gt;[EMAIL]&lt;/strong&gt;&lt;br /&gt;Username: &lt;strong&gt;[USERNAME]&lt;/strong&gt;&lt;br /&gt; Password: &lt;strong&gt;[PASSWORD]&lt;/strong&gt;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr&gt;\n&lt;td style=&quot;text-align: left;&quot;&gt;\n&lt;p&gt;Regards,&lt;em&gt;&lt;br /&gt;&lt;/em&gt;&lt;/p&gt;\n&lt;p&gt;&lt;em&gt;&lt;br /&gt;&lt;/em&gt; [SIGNATURE]&lt;em&gt;&lt;br /&gt; &lt;/em&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;/tbody&gt;\n&lt;/table&gt;\n&lt;/div&gt;', '&lt;div align=&quot;center&quot;&gt;\n&lt;table style=&quot;border: 2px solid #cccccc; width: 95%; font-family: sans-serif; font-size: 14px;&quot; border=&quot;0&quot; cellspacing=&quot;5&quot; cellpadding=&quot;5&quot;&gt;\n&lt;tbody&gt;\n&lt;tr&gt;\n&lt;td style=&quot;text-align: left;&quot;&gt;\n&lt;p&gt;Dear [NAME],&lt;/p&gt;\n&lt;p&gt;&lt;br /&gt; &lt;br /&gt; Your account on [SITENAME] has been updated by the Administrator&lt;br /&gt; &lt;br /&gt; Here are your login details. Please keep them in a safe place:&lt;br /&gt; &lt;/p&gt;\n&lt;p&gt;Email: &lt;strong&gt;[EMAIL]&lt;/strong&gt;&lt;br /&gt;Username: &lt;strong&gt;[USERNAME]&lt;/strong&gt;&lt;br /&gt; Password: &lt;strong&gt;[PASSWORD]&lt;/strong&gt;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr&gt;\n&lt;td style=&quot;text-align: left;&quot;&gt;\n&lt;p&gt;Regards,&lt;em&gt;&lt;br /&gt;&lt;/em&gt;&lt;/p&gt;\n&lt;p&gt;&lt;em&gt;&lt;br /&gt;&lt;/em&gt; [SIGNATURE]&lt;em&gt;&lt;br /&gt; &lt;/em&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;/tbody&gt;\n&lt;/table&gt;\n&lt;/div&gt;', '&lt;div align=&quot;center&quot;&gt;\n&lt;table style=&quot;border: 2px solid #cccccc; width: 95%; font-family: sans-serif; font-size: 14px;&quot; border=&quot;0&quot; cellspacing=&quot;5&quot; cellpadding=&quot;5&quot;&gt;\n&lt;tbody&gt;\n&lt;tr&gt;\n&lt;td style=&quot;text-align: left;&quot;&gt;\n&lt;p&gt;Dear [NAME],&lt;/p&gt;\n&lt;p&gt;&lt;br /&gt; &lt;br /&gt; Your account on [SITENAME] has been updated by the Administrator&lt;br /&gt; &lt;br /&gt; Here are your login details. Please keep them in a safe place:&lt;br /&gt; &lt;/p&gt;\n&lt;p&gt;Email: &lt;strong&gt;[EMAIL]&lt;/strong&gt;&lt;br /&gt;Username: &lt;strong&gt;[USERNAME]&lt;/strong&gt;&lt;br /&gt; Password: &lt;strong&gt;[PASSWORD]&lt;/strong&gt;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr&gt;\n&lt;td style=&quot;text-align: left;&quot;&gt;\n&lt;p&gt;Regards,&lt;em&gt;&lt;br /&gt;&lt;/em&gt;&lt;/p&gt;\n&lt;p&gt;&lt;em&gt;&lt;br /&gt;&lt;/em&gt; [SIGNATURE]&lt;em&gt;&lt;br /&gt; &lt;/em&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;/tbody&gt;\n&lt;/table&gt;\n&lt;/div&gt;', '&lt;div align=&quot;center&quot;&gt;\n&lt;table style=&quot;border: 2px solid #cccccc; width: 95%; font-family: sans-serif; font-size: 14px;&quot; border=&quot;0&quot; cellspacing=&quot;5&quot; cellpadding=&quot;5&quot;&gt;\n&lt;tbody&gt;\n&lt;tr&gt;\n&lt;td style=&quot;text-align: left;&quot;&gt;\n&lt;p&gt;Dear [NAME],&lt;/p&gt;\n&lt;p&gt;&lt;br /&gt; &lt;br /&gt; Your account on [SITENAME] has been updated by the Administrator&lt;br /&gt; &lt;br /&gt; Here are your login details. Please keep them in a safe place:&lt;br /&gt; &lt;/p&gt;\n&lt;p&gt;Email: &lt;strong&gt;[EMAIL]&lt;/strong&gt;&lt;br /&gt;Username: &lt;strong&gt;[USERNAME]&lt;/strong&gt;&lt;br /&gt; Password: &lt;strong&gt;[PASSWORD]&lt;/strong&gt;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr&gt;\n&lt;td style=&quot;text-align: left;&quot;&gt;\n&lt;p&gt;Regards,&lt;em&gt;&lt;br /&gt;&lt;/em&gt;&lt;/p&gt;\n&lt;p&gt;&lt;em&gt;&lt;br /&gt;&lt;/em&gt; [SIGNATURE]&lt;em&gt;&lt;br /&gt; &lt;/em&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;/tbody&gt;\n&lt;/table&gt;\n&lt;/div&gt;', 'mailer', NULL),
(3, 'Password Reset Instructions', 'Password Reset Request at [SITENAME]', 'Password Reset Request at [SITENAME]', 'Password Reset Request at [SITENAME]', 'Password Reset Request at [SITENAME]', 'Password Reset Request at [SITENAME]', 'Password Reset Request at [SITENAME]', 'Password Reset Request at [SITENAME]', 'Password Reset Request at [SITENAME]', 'This template is used for retrieving lost user password', '&lt;div align=&quot;center&quot;&gt;\n&lt;table style=&quot;border: 2px solid #cccccc; width: 95%; font-family: sans-serif; font-size: 14px;&quot; border=&quot;0&quot; cellspacing=&quot;5&quot; cellpadding=&quot;5&quot;&gt;\n&lt;tbody&gt;\n&lt;tr&gt;\n&lt;td valign=&quot;top&quot;&gt;\n&lt;p&gt;&lt;br /&gt;Dear [NAME],&lt;/p&gt;\n&lt;p&gt;&lt;br /&gt; &lt;br /&gt;We have received a password reset request for your account at &lt;em&gt;[SITENAME]&lt;/em&gt;&lt;/p&gt;\n&lt;p&gt;Email: [EMAIL]&lt;br /&gt;Username: [USERNAME]&lt;br /&gt; &lt;br /&gt; To reset your password please follow the link below:&lt;br /&gt; &lt;a href=&quot;[LINK]&quot;&gt;[LINK]&lt;/a&gt;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;&lt;br /&gt;&lt;em&gt;Request created [DATE] from IP: [IP]&lt;/em&gt;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr&gt;\n&lt;td style=&quot;text-align: left;&quot;&gt;\n&lt;p&gt;Regards,&lt;em&gt;&lt;br /&gt;&lt;/em&gt;&lt;/p&gt;\n&lt;p&gt;&lt;em&gt;&lt;br /&gt;&lt;/em&gt; [SIGNATURE]&lt;em&gt;&lt;br /&gt; &lt;/em&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;/tbody&gt;\n&lt;/table&gt;\n&lt;/div&gt;', '&lt;div align=&quot;center&quot;&gt;\n&lt;table style=&quot;border: 2px solid #cccccc; width: 95%; font-family: sans-serif; font-size: 14px;&quot; border=&quot;0&quot; cellspacing=&quot;5&quot; cellpadding=&quot;5&quot;&gt;\n&lt;tbody&gt;\n&lt;tr&gt;\n&lt;td valign=&quot;top&quot;&gt;\n&lt;p&gt;&lt;br /&gt;Dear [NAME],&lt;/p&gt;\n&lt;p&gt;&lt;br /&gt; &lt;br /&gt;We have received a password reset request for your account at &lt;em&gt;[SITENAME]&lt;/em&gt;&lt;/p&gt;\n&lt;p&gt;Email: [EMAIL]&lt;br /&gt;Username: [USERNAME]&lt;br /&gt; &lt;br /&gt; To reset your password please follow the link below:&lt;br /&gt; &lt;a href=&quot;[LINK]&quot;&gt;[LINK]&lt;/a&gt;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;&lt;br /&gt;&lt;em&gt;Request created [DATE] from IP: [IP]&lt;/em&gt;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr&gt;\n&lt;td style=&quot;text-align: left;&quot;&gt;\n&lt;p&gt;Regards,&lt;em&gt;&lt;br /&gt;&lt;/em&gt;&lt;/p&gt;\n&lt;p&gt;&lt;em&gt;&lt;br /&gt;&lt;/em&gt; [SIGNATURE]&lt;em&gt;&lt;br /&gt; &lt;/em&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;/tbody&gt;\n&lt;/table&gt;\n&lt;/div&gt;', '&lt;div align=&quot;center&quot;&gt;\n&lt;table style=&quot;border: 2px solid #cccccc; width: 95%; font-family: sans-serif; font-size: 14px;&quot; border=&quot;0&quot; cellspacing=&quot;5&quot; cellpadding=&quot;5&quot;&gt;\n&lt;tbody&gt;\n&lt;tr&gt;\n&lt;td valign=&quot;top&quot;&gt;\n&lt;p&gt;&lt;br /&gt;Dear [NAME],&lt;/p&gt;\n&lt;p&gt;&lt;br /&gt; &lt;br /&gt;We have received a password reset request for your account at &lt;em&gt;[SITENAME]&lt;/em&gt;&lt;/p&gt;\n&lt;p&gt;Email: [EMAIL]&lt;br /&gt;Username: [USERNAME]&lt;br /&gt; &lt;br /&gt; To reset your password please follow the link below:&lt;br /&gt; &lt;a href=&quot;[LINK]&quot;&gt;[LINK]&lt;/a&gt;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;&lt;br /&gt;&lt;em&gt;Request created [DATE] from IP: [IP]&lt;/em&gt;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr&gt;\n&lt;td style=&quot;text-align: left;&quot;&gt;\n&lt;p&gt;Regards,&lt;em&gt;&lt;br /&gt;&lt;/em&gt;&lt;/p&gt;\n&lt;p&gt;&lt;em&gt;&lt;br /&gt;&lt;/em&gt; [SIGNATURE]&lt;em&gt;&lt;br /&gt; &lt;/em&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;/tbody&gt;\n&lt;/table&gt;\n&lt;/div&gt;', '&lt;div align=&quot;center&quot;&gt;\n&lt;table style=&quot;border: 2px solid #cccccc; width: 95%; font-family: sans-serif; font-size: 14px;&quot; border=&quot;0&quot; cellspacing=&quot;5&quot; cellpadding=&quot;5&quot;&gt;\n&lt;tbody&gt;\n&lt;tr&gt;\n&lt;td valign=&quot;top&quot;&gt;\n&lt;p&gt;&lt;br /&gt;Dear [NAME],&lt;/p&gt;\n&lt;p&gt;&lt;br /&gt; &lt;br /&gt;We have received a password reset request for your account at &lt;em&gt;[SITENAME]&lt;/em&gt;&lt;/p&gt;\n&lt;p&gt;Email: [EMAIL]&lt;br /&gt;Username: [USERNAME]&lt;br /&gt; &lt;br /&gt; To reset your password please follow the link below:&lt;br /&gt; &lt;a href=&quot;[LINK]&quot;&gt;[LINK]&lt;/a&gt;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;&lt;br /&gt;&lt;em&gt;Request created [DATE] from IP: [IP]&lt;/em&gt;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr&gt;\n&lt;td style=&quot;text-align: left;&quot;&gt;\n&lt;p&gt;Regards,&lt;em&gt;&lt;br /&gt;&lt;/em&gt;&lt;/p&gt;\n&lt;p&gt;&lt;em&gt;&lt;br /&gt;&lt;/em&gt; [SIGNATURE]&lt;em&gt;&lt;br /&gt; &lt;/em&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;/tbody&gt;\n&lt;/table&gt;\n&lt;/div&gt;', '&lt;div align=&quot;center&quot;&gt;\n&lt;table style=&quot;border: 2px solid #cccccc; width: 95%; font-family: sans-serif; font-size: 14px;&quot; border=&quot;0&quot; cellspacing=&quot;5&quot; cellpadding=&quot;5&quot;&gt;\n&lt;tbody&gt;\n&lt;tr&gt;\n&lt;td valign=&quot;top&quot;&gt;\n&lt;p&gt;&lt;br /&gt;Dear [NAME],&lt;/p&gt;\n&lt;p&gt;&lt;br /&gt; &lt;br /&gt;We have received a password reset request for your account at &lt;em&gt;[SITENAME]&lt;/em&gt;&lt;/p&gt;\n&lt;p&gt;Email: [EMAIL]&lt;br /&gt;Username: [USERNAME]&lt;br /&gt; &lt;br /&gt; To reset your password please follow the link below:&lt;br /&gt; &lt;a href=&quot;[LINK]&quot;&gt;[LINK]&lt;/a&gt;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;&lt;br /&gt;&lt;em&gt;Request created [DATE] from IP: [IP]&lt;/em&gt;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr&gt;\n&lt;td style=&quot;text-align: left;&quot;&gt;\n&lt;p&gt;Regards,&lt;em&gt;&lt;br /&gt;&lt;/em&gt;&lt;/p&gt;\n&lt;p&gt;&lt;em&gt;&lt;br /&gt;&lt;/em&gt; [SIGNATURE]&lt;em&gt;&lt;br /&gt; &lt;/em&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;/tbody&gt;\n&lt;/table&gt;\n&lt;/div&gt;', '&lt;div align=&quot;center&quot;&gt;\n&lt;table style=&quot;border: 2px solid #cccccc; width: 95%; font-family: sans-serif; font-size: 14px;&quot; border=&quot;0&quot; cellspacing=&quot;5&quot; cellpadding=&quot;5&quot;&gt;\n&lt;tbody&gt;\n&lt;tr&gt;\n&lt;td valign=&quot;top&quot;&gt;\n&lt;p&gt;&lt;br /&gt;Dear [NAME],&lt;/p&gt;\n&lt;p&gt;&lt;br /&gt; &lt;br /&gt;We have received a password reset request for your account at &lt;em&gt;[SITENAME]&lt;/em&gt;&lt;/p&gt;\n&lt;p&gt;Email: [EMAIL]&lt;br /&gt;Username: [USERNAME]&lt;br /&gt; &lt;br /&gt; To reset your password please follow the link below:&lt;br /&gt; &lt;a href=&quot;[LINK]&quot;&gt;[LINK]&lt;/a&gt;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;&lt;br /&gt;&lt;em&gt;Request created [DATE] from IP: [IP]&lt;/em&gt;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr&gt;\n&lt;td style=&quot;text-align: left;&quot;&gt;\n&lt;p&gt;Regards,&lt;em&gt;&lt;br /&gt;&lt;/em&gt;&lt;/p&gt;\n&lt;p&gt;&lt;em&gt;&lt;br /&gt;&lt;/em&gt; [SIGNATURE]&lt;em&gt;&lt;br /&gt; &lt;/em&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;/tbody&gt;\n&lt;/table&gt;\n&lt;/div&gt;', '&lt;div align=&quot;center&quot;&gt;\n&lt;table style=&quot;border: 2px solid #cccccc; width: 95%; font-family: sans-serif; font-size: 14px;&quot; border=&quot;0&quot; cellspacing=&quot;5&quot; cellpadding=&quot;5&quot;&gt;\n&lt;tbody&gt;\n&lt;tr&gt;\n&lt;td valign=&quot;top&quot;&gt;\n&lt;p&gt;&lt;br /&gt;Dear [NAME],&lt;/p&gt;\n&lt;p&gt;&lt;br /&gt; &lt;br /&gt;We have received a password reset request for your account at &lt;em&gt;[SITENAME]&lt;/em&gt;&lt;/p&gt;\n&lt;p&gt;Email: [EMAIL]&lt;br /&gt;Username: [USERNAME]&lt;br /&gt; &lt;br /&gt; To reset your password please follow the link below:&lt;br /&gt; &lt;a href=&quot;[LINK]&quot;&gt;[LINK]&lt;/a&gt;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;&lt;br /&gt;&lt;em&gt;Request created [DATE] from IP: [IP]&lt;/em&gt;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr&gt;\n&lt;td style=&quot;text-align: left;&quot;&gt;\n&lt;p&gt;Regards,&lt;em&gt;&lt;br /&gt;&lt;/em&gt;&lt;/p&gt;\n&lt;p&gt;&lt;em&gt;&lt;br /&gt;&lt;/em&gt; [SIGNATURE]&lt;em&gt;&lt;br /&gt; &lt;/em&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;/tbody&gt;\n&lt;/table&gt;\n&lt;/div&gt;', '&lt;div align=&quot;center&quot;&gt;\n&lt;table style=&quot;border: 2px solid #cccccc; width: 95%; font-family: sans-serif; font-size: 14px;&quot; border=&quot;0&quot; cellspacing=&quot;5&quot; cellpadding=&quot;5&quot;&gt;\n&lt;tbody&gt;\n&lt;tr&gt;\n&lt;td valign=&quot;top&quot;&gt;\n&lt;p&gt;&lt;br /&gt;Dear [NAME],&lt;/p&gt;\n&lt;p&gt;&lt;br /&gt; &lt;br /&gt;We have received a password reset request for your account at &lt;em&gt;[SITENAME]&lt;/em&gt;&lt;/p&gt;\n&lt;p&gt;Email: [EMAIL]&lt;br /&gt;Username: [USERNAME]&lt;br /&gt; &lt;br /&gt; To reset your password please follow the link below:&lt;br /&gt; &lt;a href=&quot;[LINK]&quot;&gt;[LINK]&lt;/a&gt;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;&lt;br /&gt;&lt;em&gt;Request created [DATE] from IP: [IP]&lt;/em&gt;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr&gt;\n&lt;td style=&quot;text-align: left;&quot;&gt;\n&lt;p&gt;Regards,&lt;em&gt;&lt;br /&gt;&lt;/em&gt;&lt;/p&gt;\n&lt;p&gt;&lt;em&gt;&lt;br /&gt;&lt;/em&gt; [SIGNATURE]&lt;em&gt;&lt;br /&gt; &lt;/em&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;/tbody&gt;\n&lt;/table&gt;\n&lt;/div&gt;', 'mailer', NULL),
(4, 'Block Create/Update/Delete Notification', 'A Booking Block Just [ACTION] [DATES]', 'A Booking Block Just [ACTION] [DATES]', 'A Booking Block Just [ACTION] [DATES]', 'A Booking Block Just [ACTION] [DATES]', 'A Booking Block Just [ACTION] [DATES]', 'A Booking Block Just [ACTION] [DATES]', 'A Booking Block Just [ACTION] [DATES]', 'A Booking Block Just [ACTION] [DATES]', 'This template is used to notify admin when a booking block added modified deleted', '&lt;div align=&quot;center&quot;&gt;\n&lt;table style=&quot;border: 2px solid #cccccc; width: 95%; font-family: sans-serif; font-size: 14px;&quot; border=&quot;0&quot; cellspacing=&quot;5&quot; cellpadding=&quot;5&quot;&gt;\n&lt;tbody&gt;\n&lt;tr&gt;\n&lt;td valign=&quot;top&quot;&gt;\n&lt;p&gt;&lt;br /&gt;Dear Sir/Madam,&lt;/p&gt;\n&lt;p&gt;&lt;br /&gt; &lt;br /&gt;A Booking Block Just [ACTION] on [SITENAME] by [USERNAME]&lt;/p&gt;\n&lt;p&gt;[DETAILS]&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;&lt;br /&gt;&lt;em&gt;[ACTION] on [DATE] using IP: [IP]&lt;/em&gt;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr&gt;\n&lt;td style=&quot;text-align: left;&quot;&gt;\n&lt;p&gt;Regards,&lt;em&gt;&lt;br /&gt;&lt;/em&gt;&lt;/p&gt;\n&lt;p&gt;&lt;em&gt;&lt;br /&gt;&lt;/em&gt; [SIGNATURE]&lt;em&gt;&lt;br /&gt; &lt;/em&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;/tbody&gt;\n&lt;/table&gt;\n&lt;/div&gt;', '&lt;div align=&quot;center&quot;&gt;\n&lt;table style=&quot;border: 2px solid #cccccc; width: 95%; font-family: sans-serif; font-size: 14px;&quot; border=&quot;0&quot; cellspacing=&quot;5&quot; cellpadding=&quot;5&quot;&gt;\n&lt;tbody&gt;\n&lt;tr&gt;\n&lt;td valign=&quot;top&quot;&gt;\n&lt;p&gt;&lt;br /&gt;Dear Sir/Madam,&lt;/p&gt;\n&lt;p&gt;&lt;br /&gt; &lt;br /&gt;A Booking Block Just [ACTION] on [SITENAME] by [USERNAME]&lt;/p&gt;\n&lt;p&gt;[DETAILS]&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;&lt;br /&gt;&lt;em&gt;[ACTION] on [DATE] using IP: [IP]&lt;/em&gt;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr&gt;\n&lt;td style=&quot;text-align: left;&quot;&gt;\n&lt;p&gt;Regards,&lt;em&gt;&lt;br /&gt;&lt;/em&gt;&lt;/p&gt;\n&lt;p&gt;&lt;em&gt;&lt;br /&gt;&lt;/em&gt; [SIGNATURE]&lt;em&gt;&lt;br /&gt; &lt;/em&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;/tbody&gt;\n&lt;/table&gt;\n&lt;/div&gt;', '&lt;div align=&quot;center&quot;&gt;\n&lt;table style=&quot;border: 2px solid #cccccc; width: 95%; font-family: sans-serif; font-size: 14px;&quot; border=&quot;0&quot; cellspacing=&quot;5&quot; cellpadding=&quot;5&quot;&gt;\n&lt;tbody&gt;\n&lt;tr&gt;\n&lt;td valign=&quot;top&quot;&gt;\n&lt;p&gt;&lt;br /&gt;Dear Sir/Madam,&lt;/p&gt;\n&lt;p&gt;&lt;br /&gt; &lt;br /&gt;A Booking Block Just [ACTION] on [SITENAME] by [USERNAME]&lt;/p&gt;\n&lt;p&gt;[DETAILS]&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;&lt;br /&gt;&lt;em&gt;[ACTION] on [DATE] using IP: [IP]&lt;/em&gt;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr&gt;\n&lt;td style=&quot;text-align: left;&quot;&gt;\n&lt;p&gt;Regards,&lt;em&gt;&lt;br /&gt;&lt;/em&gt;&lt;/p&gt;\n&lt;p&gt;&lt;em&gt;&lt;br /&gt;&lt;/em&gt; [SIGNATURE]&lt;em&gt;&lt;br /&gt; &lt;/em&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;/tbody&gt;\n&lt;/table&gt;\n&lt;/div&gt;', '&lt;div align=&quot;center&quot;&gt;\n&lt;table style=&quot;border: 2px solid #cccccc; width: 95%; font-family: sans-serif; font-size: 14px;&quot; border=&quot;0&quot; cellspacing=&quot;5&quot; cellpadding=&quot;5&quot;&gt;\n&lt;tbody&gt;\n&lt;tr&gt;\n&lt;td valign=&quot;top&quot;&gt;\n&lt;p&gt;&lt;br /&gt;Dear Sir/Madam,&lt;/p&gt;\n&lt;p&gt;&lt;br /&gt; &lt;br /&gt;A Booking Block Just [ACTION] on [SITENAME] by [USERNAME]&lt;/p&gt;\n&lt;p&gt;[DETAILS]&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;&lt;br /&gt;&lt;em&gt;[ACTION] on [DATE] using IP: [IP]&lt;/em&gt;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr&gt;\n&lt;td style=&quot;text-align: left;&quot;&gt;\n&lt;p&gt;Regards,&lt;em&gt;&lt;br /&gt;&lt;/em&gt;&lt;/p&gt;\n&lt;p&gt;&lt;em&gt;&lt;br /&gt;&lt;/em&gt; [SIGNATURE]&lt;em&gt;&lt;br /&gt; &lt;/em&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;/tbody&gt;\n&lt;/table&gt;\n&lt;/div&gt;', '&lt;div align=&quot;center&quot;&gt;\n&lt;table style=&quot;border: 2px solid #cccccc; width: 95%; font-family: sans-serif; font-size: 14px;&quot; border=&quot;0&quot; cellspacing=&quot;5&quot; cellpadding=&quot;5&quot;&gt;\n&lt;tbody&gt;\n&lt;tr&gt;\n&lt;td valign=&quot;top&quot;&gt;\n&lt;p&gt;&lt;br /&gt;Dear Sir/Madam,&lt;/p&gt;\n&lt;p&gt;&lt;br /&gt; &lt;br /&gt;A Booking Block Just [ACTION] on [SITENAME] by [USERNAME]&lt;/p&gt;\n&lt;p&gt;[DETAILS]&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;&lt;br /&gt;&lt;em&gt;[ACTION] on [DATE] using IP: [IP]&lt;/em&gt;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr&gt;\n&lt;td style=&quot;text-align: left;&quot;&gt;\n&lt;p&gt;Regards,&lt;em&gt;&lt;br /&gt;&lt;/em&gt;&lt;/p&gt;\n&lt;p&gt;&lt;em&gt;&lt;br /&gt;&lt;/em&gt; [SIGNATURE]&lt;em&gt;&lt;br /&gt; &lt;/em&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;/tbody&gt;\n&lt;/table&gt;\n&lt;/div&gt;', '&lt;div align=&quot;center&quot;&gt;\n&lt;table style=&quot;border: 2px solid #cccccc; width: 95%; font-family: sans-serif; font-size: 14px;&quot; border=&quot;0&quot; cellspacing=&quot;5&quot; cellpadding=&quot;5&quot;&gt;\n&lt;tbody&gt;\n&lt;tr&gt;\n&lt;td valign=&quot;top&quot;&gt;\n&lt;p&gt;&lt;br /&gt;Dear Sir/Madam,&lt;/p&gt;\n&lt;p&gt;&lt;br /&gt; &lt;br /&gt;A Booking Block Just [ACTION] on [SITENAME] by [USERNAME]&lt;/p&gt;\n&lt;p&gt;[DETAILS]&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;&lt;br /&gt;&lt;em&gt;[ACTION] on [DATE] using IP: [IP]&lt;/em&gt;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr&gt;\n&lt;td style=&quot;text-align: left;&quot;&gt;\n&lt;p&gt;Regards,&lt;em&gt;&lt;br /&gt;&lt;/em&gt;&lt;/p&gt;\n&lt;p&gt;&lt;em&gt;&lt;br /&gt;&lt;/em&gt; [SIGNATURE]&lt;em&gt;&lt;br /&gt; &lt;/em&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;/tbody&gt;\n&lt;/table&gt;\n&lt;/div&gt;', '&lt;div align=&quot;center&quot;&gt;\n&lt;table style=&quot;border: 2px solid #cccccc; width: 95%; font-family: sans-serif; font-size: 14px;&quot; border=&quot;0&quot; cellspacing=&quot;5&quot; cellpadding=&quot;5&quot;&gt;\n&lt;tbody&gt;\n&lt;tr&gt;\n&lt;td valign=&quot;top&quot;&gt;\n&lt;p&gt;&lt;br /&gt;Dear Sir/Madam,&lt;/p&gt;\n&lt;p&gt;&lt;br /&gt; &lt;br /&gt;A Booking Block Just [ACTION] on [SITENAME] by [USERNAME]&lt;/p&gt;\n&lt;p&gt;[DETAILS]&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;&lt;br /&gt;&lt;em&gt;[ACTION] on [DATE] using IP: [IP]&lt;/em&gt;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr&gt;\n&lt;td style=&quot;text-align: left;&quot;&gt;\n&lt;p&gt;Regards,&lt;em&gt;&lt;br /&gt;&lt;/em&gt;&lt;/p&gt;\n&lt;p&gt;&lt;em&gt;&lt;br /&gt;&lt;/em&gt; [SIGNATURE]&lt;em&gt;&lt;br /&gt; &lt;/em&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;/tbody&gt;\n&lt;/table&gt;\n&lt;/div&gt;', '&lt;div align=&quot;center&quot;&gt;\n&lt;table style=&quot;border: 2px solid #cccccc; width: 95%; font-family: sans-serif; font-size: 14px;&quot; border=&quot;0&quot; cellspacing=&quot;5&quot; cellpadding=&quot;5&quot;&gt;\n&lt;tbody&gt;\n&lt;tr&gt;\n&lt;td valign=&quot;top&quot;&gt;\n&lt;p&gt;&lt;br /&gt;Dear Sir/Madam,&lt;/p&gt;\n&lt;p&gt;&lt;br /&gt; &lt;br /&gt;A Booking Block Just [ACTION] on [SITENAME] by [USERNAME]&lt;/p&gt;\n&lt;p&gt;[DETAILS]&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;p&gt;&lt;br /&gt;&lt;em&gt;[ACTION] on [DATE] using IP: [IP]&lt;/em&gt;&lt;/p&gt;\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;tr&gt;\n&lt;td style=&quot;text-align: left;&quot;&gt;\n&lt;p&gt;Regards,&lt;em&gt;&lt;br /&gt;&lt;/em&gt;&lt;/p&gt;\n&lt;p&gt;&lt;em&gt;&lt;br /&gt;&lt;/em&gt; [SIGNATURE]&lt;em&gt;&lt;br /&gt; &lt;/em&gt;&lt;/p&gt;\n&lt;/td&gt;\n&lt;/tr&gt;\n&lt;/tbody&gt;\n&lt;/table&gt;\n&lt;/div&gt;', 'mailer', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sys_users`
--

DROP TABLE IF EXISTS `sys_users`;
CREATE TABLE IF NOT EXISTS `sys_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(60) NOT NULL,
  `fname` varchar(32) NOT NULL,
  `token` varchar(40) NOT NULL DEFAULT '0',
  `userlevel` tinyint(1) NOT NULL DEFAULT '1',
  `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `lastlogin` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `lastip` varchar(16) DEFAULT '0',
  `access` text,
  `notes` tinytext,
  `info` tinytext,
  `active` enum('y','n','t','b') NOT NULL DEFAULT 'n',
  `company` varchar(30) DEFAULT NULL,
  `cphone` varchar(30) DEFAULT NULL,
  `caddress` varchar(255) DEFAULT NULL,
  `akey` varchar(50) DEFAULT NULL,
  `pptassignment` text
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `sys_users`
--

INSERT INTO `sys_users` (`id`, `username`, `password`, `email`, `fname`, `token`, `userlevel`, `created`, `lastlogin`, `lastip`, `access`, `notes`, `info`, `active`, `company`, `cphone`, `caddress`, `akey`, `pptassignment`) VALUES
(1, 'administrator', 'da6a2646ad7616b5ea47d633d87ed7f0e0cf6712', 'owner@yoursite.com', 'Property Owner', '0', 9, '2017-06-28 20:25:58', '2018-02-09 23:24:55', '::1', NULL, NULL, NULL, 'y', 'Your Property Name', '+887000000', 'Your Property Address', '6b6863c538d44100358a18cb2b99b6ea2fa9b0a4', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `calendar_data`
--
ALTER TABLE `calendar_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `calendar_details`
--
ALTER TABLE `calendar_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `calendar_files`
--
ALTER TABLE `calendar_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `property_blockstatuses`
--
ALTER TABLE `property_blockstatuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `property_types`
--
ALTER TABLE `property_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_config`
--
ALTER TABLE `sys_config`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `sys_language`
--
ALTER TABLE `sys_language`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_log`
--
ALTER TABLE `sys_log`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `sys_mailtemplates`
--
ALTER TABLE `sys_mailtemplates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_users`
--
ALTER TABLE `sys_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `calendar_data`
--
ALTER TABLE `calendar_data`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `calendar_details`
--
ALTER TABLE `calendar_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `calendar_files`
--
ALTER TABLE `calendar_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `property_blockstatuses`
--
ALTER TABLE `property_blockstatuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `property_types`
--
ALTER TABLE `property_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `sys_config`
--
ALTER TABLE `sys_config`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `sys_language`
--
ALTER TABLE `sys_language`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `sys_log`
--
ALTER TABLE `sys_log`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sys_mailtemplates`
--
ALTER TABLE `sys_mailtemplates`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `sys_users`
--
ALTER TABLE `sys_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
