-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 24, 2019 at 10:09 AM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id10260566_medixa`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `user_id` mediumint(8) UNSIGNED NOT NULL,
  `doctor_id` mediumint(8) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `approved` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `viewed` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `created_on` int(11) UNSIGNED NOT NULL,
  `start_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `end_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `user_id`, `doctor_id`, `title`, `message`, `approved`, `viewed`, `created_on`, `start_date`, `end_date`) VALUES
(1, 30, 128, 'Placeat vel voluptas sit est aperiam. Odit velit dignissimos harum doloribus exercitationem dolores ', 'Omnis dignissimos hic odit deleniti est. Reprehenderit nihil voluptatem qui et. Iste odit laborum ad aperiam expedita ad. Quia qui dicta et est nostrum.', 1, 0, 1564425989, '2019-10-01 22:10:31', '2019-10-01 23:10:31'),
(12, 26, 82, 'Sapiente aut dolorem magnam fugiat cum. Quaerat molestiae mollitia quam quisquam qui eaque. Nemo tem', 'Velit cum accusantium fugiat ipsum. Necessitatibus sed quia qui. Libero aut autem est voluptatum. Consequatur suscipit ut sint.', 0, 0, 1564425989, '2019-08-14 09:08:30', '2019-08-14 10:08:30'),
(16, 29, 69, 'Ea ut esse asperiores maxime quod velit quas. Vel iste tenetur et. Laboriosam voluptatem eaque volup', 'Tenetur voluptas reiciendis doloremque dolore id. Ut dolorem molestiae voluptas illum error. Sed totam voluptas ab repudiandae at praesentium. Cupiditate natus culpa est enim magnam eum perferendis.', 0, 0, 1564425989, '2019-10-22 14:10:10', '2019-10-22 15:10:10'),
(18, 28, 126, 'Id voluptate consequatur accusamus illo. Ducimus illum iste cupiditate porro sunt. Dolor autem minim', 'Consectetur totam praesentium voluptas excepturi est. Vitae unde illo culpa voluptas repellat voluptatibus. Molestiae id rerum asperiores numquam et qui voluptatem. Quo voluptatibus sit voluptate.', 0, 1, 1564425989, '2019-08-25 16:08:53', '2019-08-25 17:08:53'),
(29, 16, 65, 'Ut unde qui veniam earum sunt. Doloremque ullam saepe quae enim quia labore. Expedita odio laborum q', 'Voluptatem ut doloribus maxime voluptatem accusamus quisquam esse. Voluptate harum laudantium eum tempore atque. Aut veritatis necessitatibus vel ut.', 1, 1, 1564425989, '2019-08-07 07:08:16', '2019-08-07 08:08:16'),
(35, 7, 64, 'Ullam numquam et quisquam quod reiciendis officia. Et qui rem molestiae asperiores doloremque except', 'Voluptatem assumenda consequuntur eius sint tempore praesentium. Numquam velit excepturi voluptas maiores. Est dolorem nostrum explicabo iure cupiditate explicabo officia. Blanditiis omnis beatae cum facilis in non.', 0, 1, 1564425989, '2019-11-15 11:11:36', '2019-11-15 12:11:36'),
(39, 28, 126, 'Ab minus cum excepturi harum ut enim. Sunt quod ex accusantium molestias nostrum rerum quis. Exercit', 'Earum ratione odio consequatur occaecati quasi. Natus non sapiente voluptate fugit expedita ea molestiae. Modi modi blanditiis iusto recusandae fuga.', 1, 1, 1564425989, '2019-08-11 21:08:17', '2019-08-11 22:08:17'),
(41, 46, 64, 'Qui illum minima eos distinctio ab in. Quo repellendus qui officia rem cumque. Consequuntur iste qua', 'Provident eius voluptatum enim. Dolor rem eius saepe dolorem ut. Tempore ipsum eius voluptas ad temporibus. Quibusdam vel necessitatibus quia molestiae consequatur neque.', 0, 0, 1564425989, '2019-10-01 02:10:23', '2019-10-01 03:10:23'),
(45, 22, 78, 'Nostrum magnam harum sed sapiente eos pariatur. Doloremque sed dolorem atque ut aliquid iure volupta', 'Commodi distinctio nulla aut qui nihil voluptas. Ratione magnam quaerat odit repellat animi. Nam mollitia modi reprehenderit in. Officiis ut et nesciunt. Dolorem aut similique velit at sequi at expedita.', 0, 0, 1564425989, '2019-08-28 17:08:34', '2019-08-28 18:08:34'),
(49, 28, 63, 'Aliquid et est quae eos. Non aut voluptatem repudiandae nulla. Fugiat quia sit aut consequatur ea. M', 'Error dolorem sint magni sunt fugiat. Et excepturi aut velit consequatur qui commodi. Qui quidem voluptas eligendi voluptas eos eligendi. Aut dolor quam quos error commodi est.', 0, 0, 1564425989, '2019-08-06 23:08:47', '2019-08-07 00:08:47'),
(51, 54, 54, '', 'I need to see you about my child\'s hyperness', 0, 0, 0, '2019-08-29 12:00:00', '2019-08-10 22:09:27'),
(52, 61, 61, '', 'checkup', 0, 0, 0, '2019-08-23 12:00:00', '2019-08-23 11:57:55');

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('2ci7ni7arh2rh4nq7upusa3tcv1mpfe9', '180.190.183.33', 1566483289, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363438333030383b6c6f67696e5f72656469726563747c733a33323a22687474703a2f2f6d65646978612e303030776562686f73746170702e636f6d2f223b646f634361726473547970657c733a343a2274696c65223b),
('5esibcslc6i76lp2vi1pm4t6v9ospgvn', '218.81.184.52', 1566396647, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363339363634373b6c6f67696e5f72656469726563747c733a33323a22687474703a2f2f6d65646978612e303030776562686f73746170702e636f6d2f223b),
('8l784vre13b3n20l2ffqn48adc20g22d', '120.29.85.25', 1566561610, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363536313535303b6c6f67696e5f72656469726563747c733a36363a22687474703a2f2f6d65646978612e303030776562686f73746170702e636f6d2f70687973696369616e732f35323531352f436c696e746f6e2d4f706567616e627370223b6964656e746974797c733a31363a2275736572406d616e616765722e636f6d223b656d61696c7c733a31363a2275736572406d616e616765722e636f6d223b757365725f69647c733a323a223431223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231353636353631323438223b646f634361726473547970657c733a343a2274696c65223b),
('a9icrsil8hi9ksh85a3irnsu0fgh0vql', '187.189.151.85', 1566412927, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363431323836393b6c6f67696e5f72656469726563747c733a33323a22687474703a2f2f6d65646978612e303030776562686f73746170702e636f6d2f223b6964656e746974797c733a31353a2261646d696e4061646d696e2e636f6d223b656d61696c7c733a31353a2261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2231223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231353636323534313831223b616c6572747c613a323a7b733a343a2274797065223b733a373a2273756363657373223b733a373a226d657373616765223b733a32333a22204c6f636174696f6e7320776572652075706461746564223b7d5f5f63695f766172737c613a313a7b733a353a22616c657274223b733a333a226e6577223b7d),
('d3ss6avpg862fbnt4b1ekh7jv3lu7grj', '120.29.85.25', 1566561106, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363536313130363b),
('pa0ehhsfet0i8pb4teultn1418dk2khj', '176.254.107.101', 1566574243, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363537343138323b6c6f67696e5f72656469726563747c733a33323a22687474703a2f2f6d65646978612e303030776562686f73746170702e636f6d2f223b6964656e746974797c733a31353a2261646d696e4061646d696e2e636f6d223b656d61696c7c733a31353a2261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2231223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231353636353734313238223b),
('pkul83387inbv1vaj72trpqmm5g5jhgv', '120.29.85.25', 1566561552, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363536313535303b6c6f67696e5f72656469726563747c733a34313a22687474703a2f2f6d65646978612e303030776562686f73746170702e636f6d2f686f73706974616c73223b6964656e746974797c733a31363a2275736572406d616e616765722e636f6d223b656d61696c7c733a31363a2275736572406d616e616765722e636f6d223b757365725f69647c733a323a223431223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231353636353631323438223b646f634361726473547970657c733a343a226c697374223b),
('pm90bu78rhvb3f02ll74o99pf6jh2vr5', '5.108.27.70', 1566296952, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363239363739303b6c6f67696e5f72656469726563747c733a34313a22687474703a2f2f6d65646978612e303030776562686f73746170702e636f6d2f686f73706974616c73223b646f634361726473547970657c733a343a2274696c65223b),
('qfv64g2j9rpt2eb814b8dth7m9okpdu1', '178.220.51.202', 1566560051, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363536303035303b6c6f67696e5f72656469726563747c733a33323a22687474703a2f2f6d65646978612e303030776562686f73746170702e636f6d2f223b),
('r66b246m2uqovh1darqphb54dhr6juhl', '176.43.200.139', 1566346886, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363334363832313b6c6f67696e5f72656469726563747c733a36363a22687474703a2f2f6d65646978612e303030776562686f73746170702e636f6d2f70687973696369616e732f35323531352f436c696e746f6e2d4f706567616e627370223b646f634361726473547970657c733a343a2274696c65223b),
('uum0g8fu5l7vcu9morj6k8u6hphtv31e', '110.249.201.62', 1566546886, 0x5f5f63695f6c6173745f726567656e65726174657c693a313536363534363838363b6c6f67696e5f72656469726563747c733a33323a22687474703a2f2f6d65646978612e303030776562686f73746170702e636f6d2f223b);

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `location_id` smallint(5) UNSIGNED DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `logo` varchar(220) DEFAULT NULL,
  `preview` varchar(220) DEFAULT NULL,
  `slogan` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` varchar(220) DEFAULT NULL,
  `latitude` varchar(20) DEFAULT NULL,
  `longitude` varchar(20) DEFAULT NULL,
  `open_hrs` varchar(100) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_on` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `location_id`, `name`, `slug`, `logo`, `preview`, `slogan`, `description`, `phone`, `email`, `address`, `latitude`, `longitude`, `open_hrs`, `active`, `created_on`) VALUES
(67449, 8, 'Ankunda, Kateregga and Barigye', 'ankunda-kateregga-and-barigye', 'd154c71f586313db0af30b4961a58785.png', '3e07a5f0249ee8d428e0db80b449b79c.jpg', 'Voluptate qui vel accusantium mollitia.', 'Blanditiis molestiae hic tenetur amet. Reprehenderit qui quos qui aut. Corrupti labore est minus dolores atque omnis. Totam occaecati quas in omnis quod laboriosam sed qui.', '0482 226 170', 'rowland19@gmail.com', 'Nakasongola', '0.54180466516614', '30.976298181406', '8:00am to 5:00pm', 1, 0),
(67451, 5, 'Ahebwe Inc', 'ahebwe-inc', '300-150.png', '94a1f81bf8fe58c50661d5e9414fecff.jpg', 'Qui sunt ipsam tempore debitis nam architecto.', 'Ea libero similique aut ut quidem aliquam. Cumque velit velit aut tempora doloremque labore. Accusantium mollitia enim fugit sed dolorum.', '+256 469 617 934', 'jacquelyn.tumusiime@gmail.com', NULL, NULL, NULL, '8:00am to 5:00pm', 1, 0),
(67452, 7, 'Kirabira-Kagambira', 'kirabira-kagambira', 'c07233005fbf1d587b7d241f1da0978f.png', '141986ef0eea3c894da96c8a991f8b36.png', 'Ab soluta adipisci aut dignissimos corporis vitae quo.', 'Quia aut et omnis et. Doloremque quidem vitae quae distinctio est repellendus corrupti. Consequatur aut qui est reprehenderit. Quaerat deserunt quis itaque.', '0442 908 032', 'joseph90@yahoo.com', NULL, NULL, NULL, '8:00am to 5:00pm', 1, 0),
(67453, 3, 'Muyambi-Bukenya', 'muyambi-bukenya', '3b2745996cc28885796f8602b9ef6690.png', 'f12b9f3f12ac8ca46b4994feb5a9fdac.png', 'Doloremque corrupti autem est iusto recusandae voluptatem et.', 'Sint voluptatem eligendi nihil explicabo laboriosam. Sint quaerat accusamus voluptatibus sit nostrum voluptatem rerum. Facere hic quis sit a esse.', '0753 629 537', 'jane31@nabasa.co.ug', NULL, NULL, NULL, '8:00am to 5:00pm', 1, 0),
(67455, 4, 'Rwabyoma-Ijaga', 'rwabyoma-ijaga', '1e412718f896eb6840e07021a0f3d884.png', 'ce35fcf489d34d50a4adf9f116b2a820.png', 'Possimus quo distinctio omnis non.', 'Sit a eligendi eligendi autem numquam ea quos laboriosam. Cumque modi possimus velit. Quia et saepe est delectus.', '+256730973413', 'kyambadde.georgiana@tizikara.org', NULL, NULL, NULL, '8:00am to 5:00pm', 1, 0),
(67456, 9, 'Kabanda Inc', 'kabanda-inc', '3bf9c9e66c988cb73dee38b9fb988919.png', '8791b95bde1e23d53873e8ea25690c5b.jpg', 'Error laudantium est repellendus ad.', 'Dolores dignissimos ut incidunt eos placeat maxime. Enim voluptatem voluptatibus quidem est molestiae. Consequuntur est rerum aliquam consequatur voluptatem consequatur quod ut.', '0736227596', 'naomi.kanshabe@hotmail.co.ug', NULL, NULL, NULL, '8:00am to 5:00pm', 1, 0),
(67457, 3, 'Munyagwa and Sons', 'munyagwa-and-sons', 'c6cfb52ae262493f64f57649c31a73a8.png', '782bacfe205f9f2edf980088bd810c66.png', 'Voluptas ut laboriosam facere autem qui perferendis.', 'Et odit corporis sed accusantium rerum. Et qui adipisci repellat ut eveniet. Ad eveniet exercitationem magni ratione nemo.', '+256789658452', 'mutabuza.chris@nabimanya.info', NULL, NULL, NULL, '8:00am to 5:00pm', 1, 0),
(67462, 4, 'Mushabe-Akashabe', 'mushabe-akashabe', '2d099c15789a6538ab8513cb6c32cbb0.png', '82519bd0716564419798f8d96fc19933.png', 'Et dignissimos dolores est eveniet rerum velit.', 'Consequatur autem neque qui odit dolores. Molestiae et iste qui repellat aut. Incidunt optio eum ex id sunt dolor excepturi.', '0499 756 080', 'salma08@gmail.co.ug', NULL, NULL, NULL, '8:00am to 5:00pm', 1, 0),
(67463, 4, 'Kateregga-Byanyima', 'kateregga-byanyima45', '300-150.png', '300-150.png', 'Natus amet quo quaerat fuga eos laborum.', 'In deleniti dolorem hic sit distinctio vel. Laudantium necessitatibus non repudiandae nihil similique nostrum hic sit.', '+256 721 272 874', 'qouma@gmail.com', 'Buikwe', '0.34020126947102', '30.327044576604', '8:00am to 5:00pm', 1, 0),
(67464, 3, 'Orishaba-Rubalema', 'orishaba-rubalema', 'e3e9d32e5da5cb464c9665a5db1e5b7f.png', 'b4c0355a7e0615897a0724db4dde5423.png', 'Rerum voluptatibus voluptate ad laboriosam.', 'Veritatis aut quae et delectus iusto veniam. Ea quo accusamus consequatur aut aliquid laudantium assumenda ea. Voluptate dolore omnis ut. Eos illum laboriosam perferendis animi.', '0761087907', 'bnyeko@nkoojo.com', NULL, NULL, NULL, '8:00am to 5:00pm', 1, 0),
(67465, 1, 'Migisha, Tizikara and Tizikara', 'migisha-tizikara-and-tizikara45', '300-150.png', '300-150.png', 'Voluptate quia blanditiis quidem.', 'Ut amet eos quis maiores. Iusto aliquid reprehenderit molestiae ea nihil praesentium. Necessitatibus voluptatum ratione sint dolore sunt corporis. Omnis atque hic ut placeat itaque.', '+256 447 832 668', 'isabel.bakabulindi@barigye.com', 'Busolwe', '0.69035237616773', '31.05590400249', '8:00am to 5:00pm', 1, 0),
(67466, 6, 'Tumwiine, Kanshabe and Atwine', 'tumwiine-kanshabe-and-atwine45', '300-150.png', '300-150.png', 'Soluta error iste est unde ut.', 'Aperiam omnis nam et perferendis sunt corporis tempora. Ullam corrupti et est omnis fuga quo expedita. Aut rerum quos laboriosam consequatur enim amet. Voluptas quisquam eaque ab molestiae repellendus exercitationem aspernatur.', '+256 457 502 489', 'felix27@gmail.com', 'Lwengo', '0.46663726517693', '31.535192320281', '8:00am to 5:00pm', 1, 0),
(67467, 9, 'Mulalira-Kitovu', 'mulalira-kitovu', '768d79f2b82159fc10bc26bfb0a4ad17.png', 'e260a1117ab4c4f13bd5bb42053d3f8c.png', 'Et illum officia dolorem dolores ipsum voluptates eaque sed.', 'Amet nulla cupiditate magnam quo dolore iste laboriosam. Sit aspernatur labore dolore tenetur. Illo beatae quis rerum pariatur. Enim qui recusandae ut ipsam dignissimos.', '+256 765 828 438', 'sandy82@gmail.co.ug', NULL, NULL, NULL, '8:00am to 5:00pm', 1, 0),
(67468, 6, 'Kirigwajjo and Sons', 'kirigwajjo-and-sons', '0b07151b0995b20d3797e4966cec53de.png', '26ddcc47e32b46a30383d4c9377b1860.png', 'Doloremque magnam voluptas quas ratione et.', 'Quis ad alias molestias. Est quaerat consequatur nam est aspernatur consequatur vero. Molestiae ducimus voluptatibus dolorum tempora incidunt ipsam. Tenetur vel et blanditiis tempore.', '+256476936444', 'mathias78@gmail.com', NULL, NULL, NULL, '8:00am to 5:00pm', 1, 0),
(67470, 3, 'Kabanda-Nankunda', 'kabanda-nankunda', 'f5415f89afe8049006e232665b728b50.png', 'c1185ec0539e3cabcf9101c76c4075e5.png', 'Asperiores in repellendus porro facere.', 'In ipsa at dolore atque sit ut. Quos dolorem eaque ratione laudantium. Inventore excepturi minima sit et omnis est placeat.', '+256 767 546 674', 'kansiime.vivienne@hotmail.co.ug', NULL, NULL, NULL, '8:00am to 5:00pm', 1, 0),
(67471, 3, 'Kanyesigye-Kibirige', 'kanyesigye-kibirige45', '300-150.png', '300-150.png', 'Nisi accusamus nobis voluptas corrupti saepe facere modi optio.', 'Consequatur minima tenetur non porro ipsam amet qui sed. Veritatis eius eum illo et commodi mollitia quam. Eos culpa repudiandae est natus odit culpa quis dicta.', '+256789407255', 'mutabuza.aurelia@yahoo.co.ug', 'Kanoni', '0.29013931582563', '31.073055309716', '8:00am to 5:00pm', 1, 0),
(67473, 1, 'Twasiima-Kitovu', 'twasiima-kitovu45', '300-150.png', '300-150.png', 'Maxime eligendi vero beatae autem sequi unde.', 'Ut at ut suscipit illo hic odit sit. Molestiae ipsum accusamus tempore corrupti.', '+256427862161', 'kayemba.jasper@gmail.com', 'Buikwe', '0.40274420922769', '30.56851477554', '8:00am to 5:00pm', 1, 0),
(67475, 9, 'Akankwasa LLC', 'akankwasa-llc45', '300-150.png', '300-150.png', 'Neque dolores reiciendis quia voluptatum deleniti.', 'Tempora sapiente illum nihil quos magnam tenetur laborum. Dolorum aut est magnam eius est sit quisquam. Et ea explicabo deserunt quia impedit libero.', '0707692948', 'stuart66@yahoo.com', 'Ngora', '0.39374203967294', '31.721753826309', '8:00am to 5:00pm', 1, 0),
(67480, 4, 'Munyagwa, Bbosa and Wasswa', 'munyagwa-bbosa-and-wasswa45', '300-150.png', '300-150.png', 'Et commodi ducimus vero mollitia eum.', 'Quos unde voluptatibus enim reprehenderit rem provident alias. Nemo nesciunt tenetur sed illum eum. Non voluptatem iste est nam distinctio et expedita. Illum optio perspiciatis tempore non consectetur.', '+256405852551', 'pmunyagwa@gmail.com', 'Kamwenge', '0.55904378482307', '31.410714799756', '8:00am to 5:00pm', 1, 0),
(67482, 3, 'Wasswa-Buyinza', 'wasswa-buyinza', '4299d46f594b91b9d59510bf5bf04ce4.png', 'ac97823d5b163ec1db5aacfe0e274eae.png', 'Provident distinctio quis omnis neque autem nobis.', 'Sunt doloremque perferendis corrupti ex. Blanditiis officia enim maxime in quisquam non sint.', '0440 264 957', 'sierra86@twasiima.co.ug', NULL, NULL, NULL, '8:00am to 5:00pm', 1, 0),
(67483, 4, 'Gamwera, Lunyoro and Asasira', 'gamwera-lunyoro-and-asasira45', '300-150.png', '300-150.png', 'Aliquam aut magnam veritatis consequatur magnam consequatur.', 'Sit ad optio deserunt nesciunt occaecati. Dolorem in tenetur consectetur quis dicta quis quia. Natus nostrum aliquam id aspernatur hic. Vel voluptatibus qui consequatur minima autem omnis qui.', '0461638710', 'gladys66@twasiima.com', 'Malaba', '0.28737790127925', '31.913835568541', '8:00am to 5:00pm', 1, 0),
(67485, 4, 'Mugisa-Munyagwa', 'mugisa-munyagwa', 'fb9e626ce80c57aac421260252f2aa1d.png', 'bc28582bac255ab0a6cd5326eff8411d.png', 'Saepe omnis fugit autem ipsam.', 'Laudantium omnis a labore. Est quia repudiandae voluptatibus quis omnis. Inventore ducimus ratione ratione inventore quidem quos temporibus ut. Molestiae impedit unde qui ut magni.', '0446421257', 'morris90@bukenya.co.ug', NULL, NULL, NULL, '8:00am to 5:00pm', 1, 0),
(67486, 7, 'Tusiime PLC', 'tusiime-plc', '00c263417dea35d387a32ca16edb464c.png', '3590088df5475e56fca7af2edade1467.png', 'Facilis numquam consequuntur explicabo qui exercitationem aut vitae.', 'Voluptas vel quos odit temporibus. Quas optio consequatur quia soluta non. Ut harum praesentium assumenda deserunt cum ducimus. Minus voluptatem facere voluptatem architecto a culpa velit.', '+256408609167', 'mariam.atwine@yahoo.co.ug', NULL, NULL, NULL, '8:00am to 5:00pm', 1, 0),
(67488, 4, 'Kawuki LLC', 'kawuki-llc', 'cd744e79db764cb3b368cec5fa3a3bca.png', '9150fa5b0bad0d3103b729b9acb83550.png', 'Ut quia natus voluptate similique libero veritatis voluptas rerum.', 'Quasi sit qui optio aperiam. Ut maiores illum in magnam quaerat distinctio. Debitis tempore optio aut ad quia accusantium et. Sint maxime et est facilis omnis corporis vitae provident.', '0794 423 799', 'christopher.kabuye@gmail.com', NULL, NULL, NULL, '8:00am to 5:00pm', 1, 0),
(67489, 3, 'Tumwiine PLC', 'tumwiine-plc', '0fb7a7a0650c2e427262708cf8349ecb.png', '939fec116604419f387c84fbc005d47a.png', 'Itaque nisi iste minima non ipsam dolore.', 'Sed fugiat velit sunt quia impedit. Id et porro aut et placeat ad. Aspernatur amet unde inventore quisquam rerum omnis doloribus voluptatem. Vitae soluta praesentium consectetur.', '0487396556', 'alice73@barigye.com', NULL, NULL, NULL, '8:00am to 5:00pm', 1, 0),
(67490, 5, 'Baguma, Kijjoba and Atukunda', 'baguma-kijjoba-and-atukunda', 'ce26c7b63e318172f689a46430e9fa9f.png', 'b024b489a2ac7f5c87e9450346f043d5.png', 'Non et animi beatae voluptatem eveniet autem labore eveniet.', 'Enim at omnis sapiente quod. Dolore iure magni dolorem. Rerum fuga atque occaecati libero dicta deserunt distinctio aut.', '0485 199 277', 'michele.wasswa@hotmail.com', NULL, NULL, NULL, '8:00am to 5:00pm', 1, 0),
(67491, 2, 'Natukunda Inc', 'natukunda-inc', '306b65240a697910ed92022f557ac448.png', 'dc8cbeb09ff5eb80a2064f986dc82cc8.png', 'Quas delectus eveniet quibusdam odit nostrum velit quam.', 'Harum incidunt natus soluta optio facere aspernatur ex impedit. Ab et ipsam quaerat suscipit soluta explicabo sed. Vel consequatur vel iure et. Occaecati facilis a ducimus et.', '+256789272395', 'amanda.munyagwa@odeke.co.ug', NULL, NULL, NULL, '8:00am to 5:00pm', 1, 0),
(67492, 4, 'Kawooya-Opega', 'kawooya-opega', '85ab890c2049ea22824631161e35b445.png', 'ca56f4025df141f277ff75626eaea6cc.png', 'Repudiandae quod iste et explicabo dignissimos enim officia.', 'Ad eum quas rem quod. Eum voluptatibus maxime ea eligendi necessitatibus tempore voluptatem. Soluta hic dicta sed dolorum tempora voluptates rerum.', '0738 459 246', 'bethany40@yahoo.co.ug', NULL, NULL, NULL, '8:00am to 5:00pm', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `companies_facilities`
--

CREATE TABLE `companies_facilities` (
  `id` int(11) UNSIGNED NOT NULL,
  `company_id` mediumint(8) UNSIGNED DEFAULT NULL,
  `company_facility_id` smallint(5) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `companies_facilities`
--

INSERT INTO `companies_facilities` (`id`, `company_id`, `company_facility_id`) VALUES
(151009, 67451, 2),
(151010, 67451, 4),
(151011, 67451, 1),
(151012, 67452, 1),
(151013, 67453, 1),
(151016, 67455, 2),
(151017, 67455, 5),
(151018, 67456, 2),
(151019, 67456, 4),
(151020, 67456, 3),
(151021, 67457, 4),
(151022, 67457, 2),
(151031, 67462, 5),
(151032, 67464, 4),
(151033, 67464, 3),
(151034, 67464, 2),
(151035, 67467, 3),
(151036, 67467, 5),
(151037, 67468, 4),
(151038, 67468, 3),
(151040, 67470, 4),
(151046, 67475, 5),
(151058, 67482, 4),
(151060, 67485, 3),
(151061, 67485, 5),
(151062, 67485, 2),
(151063, 67485, 4),
(151064, 67486, 2),
(151067, 67488, 4),
(151068, 67488, 2),
(151069, 67489, 1),
(151070, 67490, 2),
(151071, 67490, 5),
(151072, 67491, 5),
(151073, 67491, 4),
(151074, 67492, 5),
(151075, 67492, 4),
(151077, 67449, 2),
(151078, 67449, 3),
(151079, 67449, 4),
(151080, 67449, 1),
(151081, 67449, 5);

-- --------------------------------------------------------

--
-- Table structure for table `companies_files`
--

CREATE TABLE `companies_files` (
  `id` int(11) UNSIGNED NOT NULL,
  `company_id` mediumint(8) UNSIGNED DEFAULT NULL,
  `url` varchar(220) NOT NULL,
  `type` varchar(10) NOT NULL,
  `caption` varchar(220) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `companies_files`
--

INSERT INTO `companies_files` (`id`, `company_id`, `url`, `type`, `caption`) VALUES
(134888, 67449, '71b369a774e0778461a8367286b6a9a7.jpg', '', 'A clean environment'),
(134889, 67449, '90b15516c2feb5f50a2dd2504c05bc13.jpg', '', 'Mordern environment'),
(134892, 67451, '71b369a774e0778461a8367286b6a9a7.jpg', '', 'A clean environment'),
(134893, 67451, '90b15516c2feb5f50a2dd2504c05bc13.jpg', '', 'Mordern environment'),
(134894, 67452, '71b369a774e0778461a8367286b6a9a7.jpg', '', 'A clean environment'),
(134895, 67452, '90b15516c2feb5f50a2dd2504c05bc13.jpg', '', 'Mordern environment'),
(134896, 67453, '71b369a774e0778461a8367286b6a9a7.jpg', '', 'A clean environment'),
(134897, 67453, '90b15516c2feb5f50a2dd2504c05bc13.jpg', '', 'Mordern environment'),
(134900, 67455, '71b369a774e0778461a8367286b6a9a7.jpg', '', 'A clean environment'),
(134901, 67455, '90b15516c2feb5f50a2dd2504c05bc13.jpg', '', 'Mordern environment'),
(134902, 67456, '71b369a774e0778461a8367286b6a9a7.jpg', '', 'A clean environment'),
(134903, 67456, '90b15516c2feb5f50a2dd2504c05bc13.jpg', '', 'Mordern environment'),
(134904, 67457, '71b369a774e0778461a8367286b6a9a7.jpg', '', 'A clean environment'),
(134905, 67457, '90b15516c2feb5f50a2dd2504c05bc13.jpg', '', 'Mordern environment'),
(134914, 67462, '71b369a774e0778461a8367286b6a9a7.jpg', '', 'A clean environment'),
(134915, 67462, '90b15516c2feb5f50a2dd2504c05bc13.jpg', '', 'Mordern environment'),
(134916, 67463, '71b369a774e0778461a8367286b6a9a7.jpg', '', 'A clean environment'),
(134917, 67463, '90b15516c2feb5f50a2dd2504c05bc13.jpg', '', 'Mordern environment'),
(134918, 67464, '71b369a774e0778461a8367286b6a9a7.jpg', '', 'A clean environment'),
(134919, 67464, '90b15516c2feb5f50a2dd2504c05bc13.jpg', '', 'Mordern environment'),
(134920, 67465, '71b369a774e0778461a8367286b6a9a7.jpg', '', 'A clean environment'),
(134921, 67465, '90b15516c2feb5f50a2dd2504c05bc13.jpg', '', 'Mordern environment'),
(134922, 67466, '71b369a774e0778461a8367286b6a9a7.jpg', '', 'A clean environment'),
(134923, 67466, '90b15516c2feb5f50a2dd2504c05bc13.jpg', '', 'Mordern environment'),
(134924, 67467, '71b369a774e0778461a8367286b6a9a7.jpg', '', 'A clean environment'),
(134925, 67467, '90b15516c2feb5f50a2dd2504c05bc13.jpg', '', 'Mordern environment'),
(134926, 67468, '71b369a774e0778461a8367286b6a9a7.jpg', '', 'A clean environment'),
(134927, 67468, '90b15516c2feb5f50a2dd2504c05bc13.jpg', '', 'Mordern environment'),
(134930, 67470, '71b369a774e0778461a8367286b6a9a7.jpg', '', 'A clean environment'),
(134931, 67470, '90b15516c2feb5f50a2dd2504c05bc13.jpg', '', 'Mordern environment'),
(134932, 67471, '71b369a774e0778461a8367286b6a9a7.jpg', '', 'A clean environment'),
(134933, 67471, '90b15516c2feb5f50a2dd2504c05bc13.jpg', '', 'Mordern environment'),
(134936, 67473, '71b369a774e0778461a8367286b6a9a7.jpg', '', 'A clean environment'),
(134937, 67473, '90b15516c2feb5f50a2dd2504c05bc13.jpg', '', 'Mordern environment'),
(134940, 67475, '71b369a774e0778461a8367286b6a9a7.jpg', '', 'A clean environment'),
(134941, 67475, '90b15516c2feb5f50a2dd2504c05bc13.jpg', '', 'Mordern environment'),
(134950, 67480, '71b369a774e0778461a8367286b6a9a7.jpg', '', 'A clean environment'),
(134951, 67480, '90b15516c2feb5f50a2dd2504c05bc13.jpg', '', 'Mordern environment'),
(134954, 67482, '71b369a774e0778461a8367286b6a9a7.jpg', '', 'A clean environment'),
(134955, 67482, '90b15516c2feb5f50a2dd2504c05bc13.jpg', '', 'Mordern environment'),
(134956, 67483, '71b369a774e0778461a8367286b6a9a7.jpg', '', 'A clean environment'),
(134957, 67483, '90b15516c2feb5f50a2dd2504c05bc13.jpg', '', 'Mordern environment'),
(134960, 67485, '71b369a774e0778461a8367286b6a9a7.jpg', '', 'A clean environment'),
(134961, 67485, '90b15516c2feb5f50a2dd2504c05bc13.jpg', '', 'Mordern environment'),
(134962, 67486, '71b369a774e0778461a8367286b6a9a7.jpg', '', 'A clean environment'),
(134963, 67486, '90b15516c2feb5f50a2dd2504c05bc13.jpg', '', 'Mordern environment'),
(134966, 67488, '71b369a774e0778461a8367286b6a9a7.jpg', '', 'A clean environment'),
(134967, 67488, '90b15516c2feb5f50a2dd2504c05bc13.jpg', '', 'Mordern environment'),
(134968, 67489, '71b369a774e0778461a8367286b6a9a7.jpg', '', 'A clean environment'),
(134969, 67489, '90b15516c2feb5f50a2dd2504c05bc13.jpg', '', 'Mordern environment'),
(134970, 67490, '71b369a774e0778461a8367286b6a9a7.jpg', '', 'A clean environment'),
(134971, 67490, '90b15516c2feb5f50a2dd2504c05bc13.jpg', '', 'Mordern environment'),
(134972, 67491, '71b369a774e0778461a8367286b6a9a7.jpg', '', 'A clean environment'),
(134973, 67491, '90b15516c2feb5f50a2dd2504c05bc13.jpg', '', 'Mordern environment'),
(134974, 67492, '71b369a774e0778461a8367286b6a9a7.jpg', '', 'A clean environment'),
(134975, 67492, '90b15516c2feb5f50a2dd2504c05bc13.jpg', '', 'Mordern environment');

-- --------------------------------------------------------

--
-- Table structure for table `companies_types`
--

CREATE TABLE `companies_types` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `company_id` mediumint(8) UNSIGNED DEFAULT NULL,
  `company_type_id` smallint(5) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `companies_types`
--

INSERT INTO `companies_types` (`id`, `company_id`, `company_type_id`) VALUES
(67445, 67449, 1),
(67447, 67451, 4),
(67448, 67452, 3),
(67449, 67453, 4),
(67451, 67455, 4),
(67452, 67456, 4),
(67453, 67457, 3),
(67458, 67462, 3),
(67459, 67463, 3),
(67460, 67464, 1),
(67461, 67465, 1),
(67462, 67466, 4),
(67463, 67467, 4),
(67464, 67468, 2),
(67466, 67470, 3),
(67467, 67471, 4),
(67469, 67473, 3),
(67471, 67475, 1),
(67476, 67480, 4),
(67478, 67482, 4),
(67479, 67483, 2),
(67481, 67485, 2),
(67482, 67486, 3),
(67484, 67488, 1),
(67485, 67489, 4),
(67486, 67490, 3),
(67487, 67491, 1),
(67488, 67492, 1);

-- --------------------------------------------------------

--
-- Table structure for table `companies_users`
--

CREATE TABLE `companies_users` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `user_id` mediumint(8) UNSIGNED NOT NULL,
  `company_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `companies_users`
--

INSERT INTO `companies_users` (`id`, `user_id`, `company_id`) VALUES
(235365, 60, 67451),
(235366, 69, 67451),
(235367, 52, 67451),
(235368, 63, 67451),
(235376, 54, 67453),
(235377, 60, 67453),
(235379, 85, 67453),
(235385, 60, 67455),
(235388, 87, 67455),
(235391, 75, 67456),
(235392, 65, 67456),
(235393, 89, 67456),
(235395, 67, 67457),
(235397, 57, 67457),
(235398, 75, 67457),
(235399, 58, 67457),
(235420, 52, 67462),
(235422, 65, 67462),
(235426, 53, 67463),
(235427, 71, 67463),
(235429, 82, 67463),
(235431, 66, 67464),
(235432, 78, 67464),
(235433, 64, 67464),
(235437, 75, 67465),
(235438, 59, 67465),
(235444, 61, 67466),
(235445, 59, 67467),
(235446, 75, 67467),
(235450, 67, 67468),
(235451, 63, 67468),
(235452, 52, 67468),
(235453, 75, 67468),
(235460, 58, 67470),
(235463, 56, 67470),
(235464, 71, 67470),
(235466, 82, 67471),
(235469, 59, 67471),
(235477, 85, 67473),
(235479, 72, 67473),
(235485, 61, 67475),
(235486, 85, 67475),
(235489, 62, 67475),
(235514, 55, 67480),
(235521, 63, 67482),
(235522, 61, 67482),
(235524, 62, 67482),
(235526, 75, 67483),
(235528, 58, 67483),
(235529, 61, 67483),
(235535, 53, 67485),
(235537, 54, 67485),
(235538, 82, 67485),
(235542, 62, 67486),
(235543, 72, 67486),
(235551, 60, 67488),
(235553, 53, 67488),
(235555, 53, 67489),
(235556, 55, 67489),
(235559, 64, 67489),
(235560, 82, 67490),
(235562, 75, 67490),
(235563, 56, 67490),
(235564, 66, 67490),
(235565, 67, 67491),
(235566, 58, 67491),
(235572, 85, 67492),
(235574, 63, 67492),
(235583, 41, 67449),
(235585, 52, 67449),
(235587, 54, 67449),
(235588, 57, 67449),
(235590, 59, 67449),
(235591, 61, 67449);

-- --------------------------------------------------------

--
-- Table structure for table `company_facilities`
--

CREATE TABLE `company_facilities` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `code` varchar(50) NOT NULL,
  `description` varchar(220) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `company_facilities`
--

INSERT INTO `company_facilities` (`id`, `name`, `code`, `description`) VALUES
(1, 'Dental facility', 'DNTL', 'An experienced Dental surgeon provides procedures like Dental Extractions, RCT, Scaling /Cleaning, Fillings, Local curettage.'),
(2, 'Ambulance Services', 'AMBL', 'Hospital has a patient transport vehicle available'),
(3, 'Pharmacy', 'PHM', 'Quality medicines are available to patients on doctor prescription'),
(4, 'Laboratory services', 'LAB', 'Trained laboratory staff are available for carrying out specialised tests'),
(5, 'Radiology/X-ray facility', 'XRAY', 'Facility for diagnosing and treating injuries and diseases using medical imaging (radiology) procedures');

-- --------------------------------------------------------

--
-- Table structure for table `company_types`
--

CREATE TABLE `company_types` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `parent_id` smallint(5) UNSIGNED DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `code` varchar(50) NOT NULL,
  `description` varchar(220) DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `company_types`
--

INSERT INTO `company_types` (`id`, `parent_id`, `name`, `code`, `description`, `created_on`) VALUES
(1, NULL, 'General Hospital', 'GHSP', 'A non-specialized hospital, treating patients suffering from all types of medical condition', 1565632282),
(2, NULL, 'Specialty Hospital', 'SHSP', 'A hospital that is primarily or exclusively engaged in the care and treatment of patients with a cardiac condition, orthopedic condition, a condition requiring a surgical procedure and “any other specialized category of ', 1565632282),
(3, NULL, 'College/ University Hospital', 'CHSP', 'A university hospital is an institution which combines the services of a hospital with the education of medical students and with medical research', 1565632282),
(4, NULL, 'Government Hospital', 'CHSP', 'A public hospital or government hospital is a hospital which is owned by a government and receives government funding', 1565632282);

-- --------------------------------------------------------

--
-- Table structure for table `doctors_profiles`
--

CREATE TABLE `doctors_profiles` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `user_id` mediumint(8) UNSIGNED NOT NULL,
  `location_id` smallint(5) UNSIGNED DEFAULT NULL,
  `speciality_id` smallint(5) UNSIGNED DEFAULT NULL,
  `reg_no` varchar(40) NOT NULL,
  `description` text DEFAULT NULL,
  `first_qualification` varchar(220) NOT NULL,
  `other_qualification` text NOT NULL,
  `is_mobile` tinyint(1) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `doctors_profiles`
--

INSERT INTO `doctors_profiles` (`id`, `user_id`, `location_id`, `speciality_id`, `reg_no`, `description`, `first_qualification`, `other_qualification`, `is_mobile`) VALUES
(1, 52, NULL, 2, '52515', 'Corrupti aperiam molestiae nihil ut voluptas. Voluptatem a officiis atque nemo aut. Quas architecto dolores qui est exercitationem. Saepe accusamus quia earum esse accusamus beatae explicabo.', 'Molestias optio reprehenderit eum ut.', 'Dolores impedit est qui ipsa et sunt est tempore.', 1),
(2, 53, NULL, 3, '53590', 'Qui reiciendis non amet fugiat. Quod id velit sed voluptas quia ipsum. Explicabo nihil nobis minus fugiat quam ipsam officiis. Neque et et voluptate est.', 'Maxime officia et asperiores veniam.', 'Animi vero harum exercitationem commodi ut enim.', 1),
(3, 54, NULL, 4, '54361', 'Vel et est sapiente id quia mollitia. Soluta rerum nemo sunt nesciunt. Iste eum eos eum temporibus veritatis animi aut.', 'Dolores neque asperiores earum voluptatem laboriosam facilis.', 'Atque maiores fugiat occaecati omnis nesciunt dicta et.', 1),
(4, 55, NULL, 4, '55793', 'Et consequuntur sit velit fugiat est. Quibusdam odio cum ut distinctio accusantium error. Sunt nihil facere eos rem blanditiis repellendus.', 'Voluptate deserunt quis odit reprehenderit minima explicabo nihil.', 'Cupiditate repellat aut facilis est voluptatem minima mollitia ex.', 0),
(5, 56, NULL, 4, '56567', 'Aut temporibus voluptatum unde asperiores dolor fugit. Sapiente sit quidem nesciunt aut temporibus ut. Magni similique voluptatum illo sint omnis.', 'Quis odio eos et illum.', 'Corporis eveniet delectus distinctio dolores ea voluptatum eum.', 1),
(6, 57, NULL, 5, '57414', 'Ipsa reprehenderit amet eos aperiam provident. Doloribus et qui expedita voluptas aut beatae. Aut enim repudiandae autem qui porro sit.', 'Quaerat optio neque molestias neque soluta et.', 'Enim dolorem nihil vero.', 1),
(7, 58, NULL, 1, '58497', 'Error ut quos veniam impedit vitae distinctio aut. Aut quo qui temporibus. Dolor itaque dolor delectus velit quia deserunt. Necessitatibus quaerat aut nulla deleniti ipsa impedit.', 'Nisi ut saepe consectetur sint et eligendi est.', 'Sequi sit sequi quae et.', 0),
(8, 59, NULL, 4, '59208', 'Et labore quasi accusantium in. Voluptas quasi quaerat praesentium animi ex. Nostrum voluptas tenetur inventore iusto ducimus hic dolores. Aut sapiente possimus quidem eveniet voluptates recusandae inventore.', 'Voluptatibus reiciendis a neque iure animi.', 'Inventore modi ut ut autem tempore velit non.', 1),
(9, 60, NULL, 4, '60742', 'Porro sapiente aperiam rerum harum modi qui atque id. Sint aut repellat earum dolorem. Et rerum illum ipsum quasi.', 'Sunt sequi perspiciatis eos voluptates fugit nobis.', 'Omnis architecto hic deleniti ut.', 0),
(10, 61, NULL, 2, '61637', 'Vel ut nemo temporibus id culpa ipsum maxime. Commodi reprehenderit impedit illo in ratione consectetur voluptas omnis. Voluptatem praesentium veritatis fugit commodi.', 'Possimus libero ullam perspiciatis incidunt.', 'Nulla laboriosam natus voluptas non odit.', 1),
(11, 62, NULL, 5, '62326', 'Aut ipsa neque harum ut. Omnis est sit optio quia nemo aut dolore. Sint sit libero necessitatibus cupiditate.', 'Labore sit autem sunt ea quia.', 'Pariatur dolor ut ut vel rerum sit.', 1),
(12, 63, NULL, 3, '63481', 'Laboriosam ea est aut neque aliquid vitae. Debitis beatae incidunt dolorem earum voluptatibus ipsa distinctio. Corporis eum saepe iusto corporis dolorem possimus omnis nostrum. Officia quos minus quis aspernatur.', 'Quo quia dolorem ullam tempora asperiores.', 'Pariatur suscipit illo laboriosam dolorem nesciunt reprehenderit.', 0),
(13, 64, NULL, 4, '64592', 'Voluptatem ex distinctio velit nostrum dolorem commodi. Dolores aut numquam non. Libero est quod earum voluptates ipsam velit corporis quia.', 'Quis harum nisi libero.', 'Vitae qui laboriosam error maxime pariatur ea.', 0),
(14, 65, NULL, 3, '65478', 'Praesentium quia deleniti quam dolor quo. Aliquam veritatis quia omnis necessitatibus aut dolorum. Nulla natus voluptatibus temporibus temporibus animi rem. Esse quaerat sequi labore molestiae natus eum reprehenderit magnam.', 'Optio et dicta eum illum dolorum qui sapiente.', 'Quaerat labore porro harum deserunt ut.', 1),
(15, 66, NULL, 2, '66584', 'Doloribus omnis voluptates dolor ipsam suscipit in. Id aut explicabo iusto et magni.', 'Enim quaerat eos commodi quidem voluptatem ullam nulla consectetur.', 'Ut atque cum cumque consequatur ut.', 1),
(16, 67, NULL, 2, '67975', 'Modi dicta consequatur nemo repellendus maiores. Debitis sapiente non reprehenderit in libero autem. Sapiente corrupti voluptatum voluptatem qui. Autem quis ut commodi velit qui natus.', 'Totam est laudantium dolore qui ut adipisci.', 'Officia quia fugit ipsam laborum sed quidem similique.', 0),
(18, 69, NULL, 4, '69983', 'Vel vel sed rerum similique deserunt amet. Quasi nam facilis odit sint. Omnis dolores ipsa voluptas vel. Asperiores deserunt consectetur deleniti quo et mollitia praesentium.', 'Recusandae laborum molestias quos ut libero aliquam.', 'Incidunt temporibus doloremque dolorem non et excepturi nobis.', 1),
(20, 71, NULL, 5, '71526', 'Vel et fuga ad nulla vel. Non et perspiciatis ut neque quasi quos ea rerum. Quaerat ea accusamus quaerat impedit sed consequatur ipsum.', 'Corporis exercitationem sit consequatur iusto delectus ut ut.', 'Debitis deserunt mollitia non perspiciatis occaecati.', 0),
(21, 72, NULL, 4, '72170', 'Eum sed eos ut ut consectetur sint quod eaque. Sed ut quo alias autem molestiae. Aut modi praesentium laboriosam. Eos consequuntur illum dolore qui.', 'Error molestiae sed est libero et ab odio.', 'Eum perferendis animi illo dolorum.', 0),
(22, 73, NULL, 2, '73516', 'Magnam corrupti magnam doloremque necessitatibus. Non voluptates impedit est aut repellat perspiciatis est. Quae ut alias iste.', 'Et enim fugit atque rem sint id ut.', 'Natus sed quasi sit.', 1),
(24, 75, NULL, 1, '75545', 'Eos sed vel in. Quis molestiae non et repudiandae aut maiores. Nam et perferendis cum consequuntur debitis totam.', 'Est ut ad aut odit et exercitationem doloremque.', 'Quam placeat sit qui voluptas eaque et.', 1),
(27, 78, NULL, 5, '78247', 'Quos aspernatur repellat totam est magnam voluptatibus nesciunt neque. Consequatur libero a est modi autem. Unde unde et cumque eaque ducimus. Eveniet explicabo commodi tempora cum iusto qui ratione.', 'Dolores atque reprehenderit eveniet aliquam tempore voluptate molestias.', 'Quos facere ad sed reprehenderit.', 1),
(31, 82, NULL, 4, '82906', 'Error autem quo quia perferendis ex et non. Voluptas consectetur maxime amet porro quod. Qui illum odio et aut dolorem. Beatae provident quis eos tempore.', 'Nesciunt impedit laboriosam qui.', 'Alias iste incidunt qui quis eum.', 1),
(34, 85, NULL, 5, '85113', 'Ut voluptas nam nulla asperiores provident. Rem vel dolorum et voluptas. Fugiat vel animi ratione expedita.', 'Velit itaque corrupti in eum.', 'Dolorum debitis quaerat porro officiis animi quaerat et.', 1),
(36, 87, NULL, 3, '87286', 'Earum sint vel odit qui animi est. Omnis recusandae et numquam est. Ratione qui excepturi id possimus in et non consequuntur.', 'In vel expedita at.', 'Et quod quae dolorem facere dolore autem.', 0),
(38, 89, NULL, 1, '89622', 'Voluptates ratione dolores illo. Enim laboriosam dicta molestiae quia necessitatibus ullam. Veritatis adipisci enim id veniam quis. Voluptas qui inventore tempora.', 'Alias aspernatur amet ipsa in accusamus unde beatae aut.', 'Et repellendus illum aut provident.', 1),
(70, 121, NULL, 5, '121654', 'Delectus illo modi vero quia velit sunt. Sit velit sint officia sapiente voluptate. Quibusdam tempora unde voluptates laudantium nemo.', 'Ut ab ad neque aut doloremque est labore.', 'Nihil sed animi eos ex eos qui.', 0),
(75, 126, 6, 4, '126541', 'Nesciunt commodi dolor doloremque. Minima voluptatibus possimus id rerum dolorem. Facilis iure eveniet iste enim.', 'Non qui molestias et temporibus eius consectetur.', 'Aliquid dolorem eos ullam nulla explicabo.', 1),
(77, 128, NULL, 4, '128729', 'Impedit praesentium quo vero explicabo et eligendi ut. Porro quisquam autem et culpa veniam.', 'Est sed voluptas et et nam.', 'Dolor inventore quaerat cupiditate hic cum.', 0);

-- --------------------------------------------------------

--
-- Table structure for table `doctor_specialities`
--

CREATE TABLE `doctor_specialities` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `code` varchar(20) NOT NULL,
  `description` varchar(220) DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `doctor_specialities`
--

INSERT INTO `doctor_specialities` (`id`, `name`, `code`, `description`, `created_on`) VALUES
(1, 'Dermatologist', 'DMT', 'Dermatologists are physicians who treat adult and pediatric patients with disorders of the skin, hair, nails, and adjacent mucous membranes.', 1565632282),
(2, 'Optician', 'OPT', 'Physicians specializing in ophthalmology develop comprehensive medical and surgical care of the eyes', 1565632282),
(3, 'Pediatrician', 'PDT', 'Physicians specializing in pediatrics work to diagnose and treat patients from infancy through adolescence', 1565632282),
(4, 'Psychiatrist', 'PSYC', 'Physicians specializing in psychiatry devote their careers to mental health and its associated mental and physical ramifications.', 1565632282),
(5, 'Dentist', 'DST', 'Physicians specializing in treatment of diseases affecting the teeth, mouth and gums.', 1565632282);

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'doctors', 'Medical Practitioner'),
(3, 'manager', 'Hospital Administrator'),
(4, 'users', 'General User');

-- --------------------------------------------------------

--
-- Table structure for table `groups_permissions`
--

CREATE TABLE `groups_permissions` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL,
  `perm_id` mediumint(8) UNSIGNED NOT NULL,
  `value` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` mediumint(8) NOT NULL,
  `language` varchar(100) NOT NULL DEFAULT 'malay',
  `created_on` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `language`, `created_on`) VALUES
(1, 'english', 1565632295),
(2, 'spanish', 1565632295);

-- --------------------------------------------------------

--
-- Table structure for table `lang_sets`
--

CREATE TABLE `lang_sets` (
  `id` mediumint(8) NOT NULL,
  `set` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lang_translations`
--

CREATE TABLE `lang_translations` (
  `id` int(11) NOT NULL,
  `key` varchar(100) NOT NULL,
  `language_id` mediumint(8) NOT NULL,
  `set` varchar(100) DEFAULT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lang_translations`
--

INSERT INTO `lang_translations` (`id`, `key`, `language_id`, `set`, `text`) VALUES
(1, 'dash_title', 1, 'titles', 'Dashboard'),
(2, 'dash_login_title', 1, 'titles', 'Login to the admin dashboard'),
(3, 'dash_welcome_msg', 1, 'titles', 'Logged in as %s'),
(4, 'dash_latest_users', 1, 'titles', 'Latest users'),
(5, 'dash_latest_hospitals', 1, 'titles', 'Latest hospitals'),
(6, 'dash_inactive_accounts', 1, 'titles', '%s inactive accounts'),
(7, 'dash_hospital_most_doctors', 1, 'titles', 'hospital with the most doctors?'),
(8, 'dash_hospital_most_doctors_tooltip', 1, 'titles', '%s has the most with a total of %s doctors'),
(9, 'dash_doctors_count', 1, 'titles', '%s registered doctors'),
(10, 'dash_appointment_info', 1, 'titles', '%s booked with %s doctors'),
(11, 'title_user', 1, 'titles', 'User'),
(12, 'title_doctor', 1, 'titles', 'Doctor'),
(13, 'title_create_user', 1, 'titles', 'Create a user'),
(14, 'subtitle_create_user', 1, 'titles', 'Enter your details below'),
(15, 'title_update_user', 1, 'titles', 'Update user data'),
(16, 'subtitle_update_user', 1, 'titles', 'Update your details below'),
(17, 'title_assign_users', 1, 'titles', 'Assign users'),
(18, 'subtitle_assign', 1, 'titles', 'Assign users to %s'),
(19, 'subtitle_assign_users', 1, 'titles', 'Assign users to group %s'),
(20, 'title_update_group', 1, 'titles', 'Update group details'),
(21, 'title_create_hospital', 1, 'titles', 'Create a hospital'),
(22, 'title_create_images', 1, 'titles', 'Add hospital images'),
(23, 'subtitle_create_images', 1, 'titles', 'You can upload up to %s images'),
(24, 'title_select_location', 1, 'titles', 'Select location'),
(25, 'table_action', 1, 'titles', 'Action'),
(26, 'title_lang_select', 1, 'titles', 'Select language to translate'),
(27, 'title_lang_confirm', 1, 'titles', 'Confirm this translation'),
(28, 'title_lang_select_module', 1, 'titles', 'Select file to translate'),
(29, 'title_product', 1, 'titles', 'Manage products'),
(30, 'title_product_add', 1, 'titles', 'Add a new product'),
(31, 'title_product_edit', 1, 'titles', 'Edit product details'),
(32, 'title_categories', 1, 'titles', 'Manage Categories'),
(33, 'title_categories_add', 1, 'titles', 'Add a new category'),
(34, 'title_categories_edit', 1, 'titles', 'Edit category details'),
(35, 'menu_profile', 1, 'menus', 'Profile'),
(36, 'menu_logout', 1, 'menus', 'Logout'),
(37, 'menu_settings', 1, 'menus', 'Settings'),
(38, 'menu_general', 1, 'menus', 'General'),
(39, 'menu_privacy', 1, 'menus', 'Privacy policy'),
(40, 'menu_terms', 1, 'menus', 'Terms & conditions'),
(41, 'menu_languages', 1, 'menus', 'Languages'),
(42, 'menu_details', 1, 'menus', 'Details'),
(43, 'menu_users_th', 1, 'menus', 'User management'),
(44, 'menu_users', 1, 'menus', 'Users'),
(45, 'menu_user_profile', 1, 'menus', 'Profile'),
(46, 'menu_user_profession', 1, 'menus', 'Profession'),
(47, 'menu_groups', 1, 'menus', 'Groups'),
(48, 'menu_group_users', 1, 'menus', 'Group users'),
(49, 'menu_hospitals_th', 1, 'menus', 'Hospital management'),
(50, 'menu_hospitals', 1, 'menus', 'Hospitals'),
(51, 'menu_doctors', 1, 'menus', 'Doctors'),
(52, 'menu_facilities', 1, 'menus', 'Hospital facilities'),
(53, 'menu_types', 1, 'menus', 'Hospital types'),
(54, 'menu_types_facilities', 1, 'menus', 'Types & Facilities'),
(55, 'menu_specialities', 1, 'menus', 'Specialties'),
(56, 'menu_locations_th', 1, 'menus', 'Locations'),
(57, 'menu_location_zones', 1, 'menus', 'Location Zones'),
(58, 'menu_location_shipping', 1, 'menus', 'Shipping rules'),
(59, 'menu_location', 1, 'menus', 'Location'),
(60, 'menu_locations_levels', 1, 'menus', 'Levels'),
(61, 'menu_locations_places', 1, 'menus', 'Places'),
(62, 'menu_locations_places_in', 1, 'menus', 'Places under %s'),
(63, 'menu_images', 1, 'menus', 'Images'),
(64, 'menu_appointments', 1, 'menus', 'Appointments'),
(65, 'menu_products', 1, 'menus', 'Products'),
(66, 'menu_categories', 1, 'menus', 'Categories'),
(67, 'alert_warning', 1, 'alerts', 'Warning'),
(68, 'alert_success_general', 1, 'alerts', 'Operation was successful'),
(69, 'alert_fail_general', 1, 'alerts', 'Operation failed'),
(70, 'alert_confirm_action', 1, 'alerts', 'Confirm action'),
(71, 'alert_confrim_delete_txt', 1, 'alerts', 'This action cannot be reversed. All information will be lost.'),
(72, 'alert_modifying_missing_item', 1, 'alerts', 'The item you are trying to modify does not exist'),
(73, 'alert_access_denied', 1, 'alerts', 'Access denied'),
(74, 'alert_logged_in', 1, 'alerts', 'You are now logged in'),
(75, 'alert_form_errors', 1, 'alerts', 'Correct the errors in the form and try again'),
(76, 'alert_enter_old_password', 1, 'alerts', 'Please enter your old password'),
(77, 'alert_password_incorrect', 1, 'alerts', 'Sorry, the password you provide is incorrect'),
(78, 'alert_login_required', 1, 'alerts', 'Please login to proceed'),
(79, 'alert_activate_email_sent', 1, 'alerts', 'An activation email was been set to %s'),
(80, 'alert_account_invisible', 1, 'alerts', 'An inactive account is not visible to the public'),
(81, 'alert_account_created', 1, 'alerts', 'Your user account has been created successfully'),
(82, 'alert_hospital_add_success', 1, 'alerts', 'Hospital was created successfully. Continue to update more details'),
(83, 'alert_hospital_add_fail', 1, 'alerts', 'We could not create this hospital'),
(84, 'alert_lang_no_file_match', 1, 'alerts', 'This language does not have a corresponding file'),
(85, 'alert_lang_file_location', 1, 'alerts', 'Language files are located in application/language directory'),
(86, 'alert_lang_create_file', 1, 'alerts', 'Create this file and refresh the page'),
(87, 'alert_appointment_unapproved', 1, 'alerts', 'This appointment is not yet approved'),
(88, 'btn_view', 1, 'buttons', 'View'),
(89, 'btn_view_all', 1, 'buttons', 'View all'),
(90, 'btn_assign', 1, 'buttons', 'Assign'),
(91, 'btn_select', 1, 'buttons', 'Select'),
(92, 'btn_edit', 1, 'buttons', 'Edit'),
(93, 'btn_create', 1, 'buttons', 'Create'),
(94, 'btn_delete', 1, 'buttons', 'Delete'),
(95, 'btn_update', 1, 'buttons', 'Update'),
(96, 'btn_save', 1, 'buttons', 'Save'),
(97, 'btn_login', 1, 'buttons', 'Login'),
(98, 'btn_register', 1, 'buttons', 'Register'),
(99, 'btn_confirm', 1, 'buttons', 'Confirm'),
(100, 'btn_submit', 1, 'buttons', 'submit'),
(101, 'btn_delete_selected', 1, 'buttons', 'Delete selected'),
(102, 'btn_remove_selected', 1, 'buttons', 'Remove selected'),
(103, 'btn_assign_users', 1, 'buttons', 'Assign users'),
(104, 'form_edit_head', 1, 'buttons', 'Edit form details below'),
(105, 'form_create_head', 1, 'buttons', 'Enter form details below'),
(106, 'form_forgot_password', 1, 'buttons', 'I forgot my password.'),
(107, 'form_remember_me', 1, 'buttons', 'Remember me'),
(108, 'form_input_placeholder', 1, 'buttons', 'Type your text here'),
(109, 'form_name', 1, 'buttons', 'Name'),
(110, 'form_code', 1, 'buttons', 'Code'),
(111, 'form_email', 1, 'buttons', 'Email'),
(112, 'form_password', 1, 'buttons', 'Password'),
(113, 'form_status', 1, 'buttons', 'Active'),
(114, 'form_date', 1, 'buttons', 'Date'),
(115, 'form_description', 1, 'buttons', 'Description'),
(116, 'form_phone', 1, 'buttons', 'phone'),
(117, 'form_address', 1, 'buttons', 'Address'),
(118, 'form_location', 1, 'buttons', 'Location'),
(119, 'form_settings_sitename', 1, 'buttons', 'Site name'),
(120, 'form_settings_sitename_txt', 1, 'buttons', 'Name of your website'),
(121, 'form_settings_description', 1, 'buttons', 'Site description'),
(122, 'form_settings_description_txt', 1, 'buttons', 'Description of your website'),
(123, 'form_settings_language', 1, 'buttons', 'Site language'),
(124, 'form_settings_language_txt', 1, 'buttons', 'Your default language. users may later choose a different one.'),
(125, 'form_settings_noreply', 1, 'buttons', 'noreply email address'),
(126, 'form_settings_noreply_txt', 1, 'buttons', 'Email address for sending automated messages to your users'),
(127, 'form_settings_paginate', 1, 'buttons', 'Pagination limit'),
(128, 'form_settings_paginate_txt', 1, 'buttons', 'Number of items to show per page'),
(129, 'form_settings_uploads', 1, 'buttons', 'Upload limit'),
(130, 'form_settings_uploads_txt', 1, 'buttons', 'Number of uploads allowed for users'),
(131, 'form_group_name', 1, 'buttons', 'Group name'),
(132, 'form_group_description', 1, 'buttons', 'Description'),
(133, 'form_users_avatar', 1, 'buttons', 'Profile photo'),
(134, 'form_users_fname', 1, 'buttons', 'First name'),
(135, 'form_users_lname', 1, 'buttons', 'Last name'),
(136, 'form_users_username', 1, 'buttons', 'username'),
(137, 'form_users_email', 1, 'buttons', 'Email'),
(138, 'form_users_password', 1, 'buttons', 'Password'),
(139, 'form_users_change_password', 1, 'buttons', 'Change password'),
(140, 'form_users_old_password', 1, 'buttons', 'Old password'),
(141, 'form_users_address', 1, 'buttons', 'Address'),
(142, 'form_users_phone', 1, 'buttons', 'Phone'),
(143, 'form_users_status', 1, 'buttons', 'Status'),
(144, 'form_users_status_txt', 1, 'buttons', 'Activate user account'),
(145, 'form_location_level', 1, 'buttons', 'Location level'),
(146, 'form_location_place', 1, 'buttons', 'Name of place'),
(147, 'form_location_parent', 1, 'buttons', 'Parent location'),
(148, 'form_location_code', 1, 'buttons', 'Location code'),
(149, 'form_location_zone', 1, 'buttons', 'Location zone'),
(150, 'form_hospital_name', 1, 'buttons', 'Hospital name'),
(151, 'form_hospital_slug', 1, 'buttons', 'Hospital slug'),
(152, 'form_hospital_type', 1, 'buttons', 'Hospital type'),
(153, 'form_hospital_slogan', 1, 'buttons', 'Hospital slogan'),
(154, 'form_hospital_description', 1, 'buttons', 'Hospital description'),
(155, 'form_hospital_hours', 1, 'buttons', 'Working hours'),
(156, 'form_hospital_about', 1, 'buttons', 'Brief description about this hospital'),
(157, 'form_image_caption', 1, 'buttons', 'Image caption'),
(158, 'form_image_placeholder', 1, 'buttons', 'No file selected'),
(159, 'form_doctor_reg_no', 1, 'buttons', 'Registration Number'),
(160, 'form_doctor_speciality', 1, 'buttons', 'Speciality'),
(161, 'form_doctor_description', 1, 'buttons', 'Description'),
(162, 'form_doctor_description_txt', 1, 'buttons', 'A brief portifolio about yourself and your practice'),
(163, 'form_doctor_qualification', 1, 'buttons', 'Qualification'),
(164, 'form_doctor_qualification_txt', 1, 'buttons', 'Highest education or training level'),
(165, 'form_doctor_qualification_2', 1, 'buttons', 'Other qualifications'),
(166, 'form_doctor_qualification_2_txt', 1, 'buttons', 'Any other certificates or awards'),
(167, 'form_doctor_mobile_service', 1, 'buttons', 'Mobile Services'),
(168, 'form_doctor_mobile_service_txt', 1, 'buttons', 'You may be required to travel to your patients'),
(169, 'form_category_name', 1, 'buttons', 'Category name'),
(170, 'form_category_parent', 1, 'buttons', 'Parent category'),
(171, 'form_category_parent_txt', 1, 'buttons', 'Parent category attributes will also be inherited'),
(172, 'form_category_no_parent', 1, 'buttons', 'None'),
(173, 'form_translate_to', 1, 'buttons', 'Translate to %s'),
(174, 'form_error_value_missing', 1, 'buttons', 'The %s is required'),
(175, 'form_error_type_mismatch', 1, 'buttons', 'This is not a valid %s'),
(176, 'form_error_pattern_alpha_min', 1, 'buttons', 'The %s must be alpha numeric with a minimum of %s characters'),
(177, 'form_error_range_underflow', 1, 'buttons', 'The %s must be greater than %s'),
(178, 'form_error_range_overflow', 1, 'buttons', 'The %s must be less than %s'),
(179, 'form_error_too_long', 1, 'buttons', 'The %s must not exceed %s characters');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `parent_id` smallint(5) UNSIGNED DEFAULT NULL,
  `location_type_id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `code` varchar(50) NOT NULL,
  `created_on` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `parent_id`, `location_type_id`, `name`, `code`, `created_on`) VALUES
(1, NULL, 1, 'United States', 'US', 1565632279),
(2, 1, 2, 'California', 'CLF', 1565632279),
(3, 1, 2, 'Florida', 'FLD', 1565632279),
(4, 1, 2, 'New York', 'NY', 1565632279),
(5, 2, 3, 'Los Angeles', 'LA', 1565632279),
(6, 2, 3, 'San Francisco', 'SA', 1565632279),
(7, 3, 3, 'Miami', 'MIM', 1565632279),
(8, 4, 3, 'Albany', 'ALB', 1565632279),
(9, 4, 3, 'New York City', 'NYC', 1565632279);

-- --------------------------------------------------------

--
-- Table structure for table `location_types`
--

CREATE TABLE `location_types` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `parent_id` smallint(5) UNSIGNED DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `code` varchar(50) NOT NULL,
  `created_on` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `location_types`
--

INSERT INTO `location_types` (`id`, `parent_id`, `name`, `code`, `created_on`) VALUES
(1, NULL, 'Country', 'CNT', 1565632278),
(2, 1, 'State', 'STT', 1565632279),
(3, 2, 'City', 'CTY', 1565632279);

-- --------------------------------------------------------

--
-- Table structure for table `location_zones`
--

CREATE TABLE `location_zones` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` longtext DEFAULT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `ip_address` varchar(16) NOT NULL,
  `login` varchar(100) DEFAULT NULL,
  `time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `version` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`version`) VALUES
(700);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `perm_key` varchar(30) NOT NULL,
  `perm_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `perm_key`, `perm_name`) VALUES
(1, 'OP', 'All permissions'),
(2, 'UD1', 'Read doctors'),
(3, 'UD2', 'Create doctors'),
(4, 'UD4', 'Update doctors'),
(5, 'UD8', 'Delete doctors');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` tinyint(1) NOT NULL,
  `site_logo` varchar(220) NOT NULL DEFAULT 'static/images/logo.png',
  `site_name` varchar(100) NOT NULL DEFAULT 'MEDDS',
  `site_description` varchar(100) DEFAULT 'Online Medical Directory and Services',
  `site_language` varchar(40) NOT NULL DEFAULT 'english',
  `pagination_limit` mediumint(8) NOT NULL DEFAULT 24,
  `upload_limit` tinyint(4) NOT NULL DEFAULT 5,
  `no_reply` varchar(100) DEFAULT NULL,
  `privacy_policy` text DEFAULT NULL,
  `terms_of_service` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `site_logo`, `site_name`, `site_description`, `site_language`, `pagination_limit`, `upload_limit`, `no_reply`, `privacy_policy`, `terms_of_service`) VALUES
(1, 'assets/images/logo.png', 'Med', 'Online Medical Directory and Services', 'english', 24, 5, '', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `ip_address` varchar(16) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(80) NOT NULL,
  `salt` varchar(40) NOT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) UNSIGNED DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED NOT NULL,
  `avatar` varchar(220) DEFAULT NULL,
  `thumbnail` varchar(220) DEFAULT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `address` varchar(220) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `avatar`, `thumbnail`, `first_name`, `last_name`, `address`, `phone`) VALUES
(1, '127.0.0.1', 'admin', '$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36', '', 'admin@admin.com', '', NULL, NULL, NULL, 1268889823, 1566574214, 1, NULL, NULL, '', '', NULL, NULL),
(2, '192.168.33.1', 'hellen.gamwera', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'nuwagaba.charlie@yahoo.co.ug', NULL, NULL, NULL, NULL, 1563996275, NULL, 1, 'user.png', 'user.png', 'Bernard', 'Kaaya', '30 Osiki Street 4051 Sironko', '0735438114'),
(3, '192.168.33.1', 'anne.murungi', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'lisa98@akashaba.com', 'e20fc95ad60652df56e610f6c1263cc41847e51b', NULL, NULL, NULL, 1563996275, NULL, 0, 'user.png', 'user.png', 'Gerald', 'Rubalema', '77 Kakooza Street 21 Kyotera', '+256782483792'),
(4, '192.168.33.1', 'boyd17', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'gaston.tumusiime@gmail.com', '751adcdfe5757c9ac9c4a4222da51318e6ba2a77', NULL, NULL, NULL, 1563996275, NULL, 0, 'user.png', 'user.png', 'Richie', 'Atuhire', '50 Mukalazi Street 7895 Luwero', '0458019421'),
(5, '192.168.33.1', 'nkurunungi.gaston', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'clifford.akankunda@hotmail.co.ug', '8fc26365ccc3d8cf8b601382a92c666ecfa38c52', NULL, NULL, NULL, 1563996275, NULL, 0, 'user.png', 'user.png', 'Sandy', 'Kiconco', '70 Turyasingura Street 99 Bombo', '0416796123'),
(6, '192.168.33.1', 'kanyesigye.howard', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'kiwanuka.ashly@mwesige.co.ug', '8dabf35574f06eee78c52d8270ef2a0ad82841da', NULL, NULL, NULL, 1563996275, NULL, 0, 'user.png', 'user.png', 'Luther', 'Odeke', '50 Abayisenga Street 9205 Moyo', '+256 482 196 306'),
(7, '192.168.33.1', 'nabasa.allan', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'eva.buyinza@hotmail.co.ug', NULL, NULL, NULL, NULL, 1563996275, NULL, 1, 'user.png', 'user.png', 'Barry', 'Opega', '03 Kirigwajjo Street 86845 Lyantonde', '0773661396'),
(8, '192.168.33.1', 'vaisu', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'kgamwera@kiconco.org', NULL, NULL, NULL, NULL, 1563996275, NULL, 1, 'user.png', 'user.png', 'Ken', 'Bukenya', '45 Ampumuza Street 4753 Nebbi', '+256712539615'),
(9, '192.168.33.1', 'wanda91', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'johnson43@gmail.co.ug', NULL, NULL, NULL, NULL, 1563996275, NULL, 1, 'user.png', 'user.png', 'Destiny', 'Rwabyoma', '29 Ddamulira Street 600 Ntungamo', '0403213811'),
(10, '192.168.33.1', 'mgamwera', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'willy.munyagwa@hotmail.co.ug', NULL, NULL, NULL, NULL, 1563996275, NULL, 1, 'user.png', 'user.png', 'Peter', 'Nuwamanya', '97 Kirigwajjo Street 60 Kayunga', '+256748673062'),
(11, '192.168.33.1', 'erica.kakooza', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'twasiima.naomi@yahoo.com', NULL, NULL, NULL, NULL, 1563996275, NULL, 1, 'user.png', 'user.png', 'Wilma', 'Okumu', '38 Nabasa Street 192 Lugazi', '0498 706 701'),
(12, '192.168.33.1', 'mariana87', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'byaruhanga.samson@hotmail.com', NULL, NULL, NULL, NULL, 1563996275, NULL, 1, 'user.png', 'user.png', 'Erica', 'Twesigomwe', '93 Kareiga Street 5 Moroto', '0421890545'),
(13, '192.168.33.1', 'lawrence.natukunda', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'norbert75@okumu.biz', NULL, NULL, NULL, NULL, 1563996275, NULL, 1, 'user.png', 'user.png', 'Josephine', 'Kafeero', '26 Were Street 17 Luwero', '0486 904 163'),
(14, '192.168.33.1', 'tuhame.eunice', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'kisitu.isabell@gmail.com', 'e3ca16e4063c9dfaafe858d28d3a507fe9f34e34', NULL, NULL, NULL, 1563996275, NULL, 0, 'user.png', 'user.png', 'Howard', 'Tusiime', '96 Mushabe Street 83157 Kampala', '0700330747'),
(15, '192.168.33.1', 'tusiime.frida', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'useremail@mail.com', NULL, NULL, NULL, NULL, 1563996275, 1565525622, 1, 'd72582b36acd2574cce3fc4600da4324.jpeg', 'thumbnail_d72582b36acd2574cce3fc4600da4324.jpeg', 'Viola', 'Bakabulindi', '54 Ninsiima Street 0294 Gulu', '+256 711 511 382'),
(16, '192.168.33.1', 'edmond38', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'bonita.nabimanya@twasiima.co.ug', NULL, NULL, NULL, NULL, 1563996275, NULL, 1, 'user.png', 'user.png', 'Aaron', 'Kirigwajjo', '68 Mugisha Street 612 Kitgum', '+256463955089'),
(17, '192.168.33.1', 'ken.kiganda', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'jasper.atuhe@gmail.co.ug', '94486d4c9d959d66f4b688d1786876496741132a', NULL, NULL, NULL, 1563996275, NULL, 0, 'user.png', 'user.png', 'Gabrielle', 'Kirigwajjo', '34 Nabimanya Street 358 Paidha', '+256704607686'),
(18, '192.168.33.1', 'adrienne.bakabulindi', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'tamale.hellen@mwesige.com', NULL, NULL, NULL, NULL, 1563996275, NULL, 1, 'user.png', 'user.png', 'Laura', 'Tumwesigye', '62 Ampumuza Street 9509 Kakinga', '+256446216407'),
(19, '192.168.33.1', 'peter.abayisenga', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'carol26@baguma.co.ug', NULL, NULL, NULL, NULL, 1563996275, NULL, 1, 'user.png', 'user.png', 'Joel', 'Osiki', '55 Tumwesigye Street 5 Kanungu', '+256402916297'),
(20, '192.168.33.1', 'vrwabyoma', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'bobby.kareiga@gmail.com', '289db77e90bf00d44e9af2a02681871b14be4dff', NULL, NULL, NULL, 1563996275, NULL, 0, 'user.png', 'user.png', 'Marianna', 'Kirabira', '50 Kateregga Street 8 Bukedea', '+256 751 534 038'),
(21, '192.168.33.1', 'kbaguma', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'kiconco.frida@kakooza.com', '51fe3c175e971fb227061cb3c2a4ab44ac8b8613', NULL, NULL, NULL, 1563996275, NULL, 0, 'user.png', 'user.png', 'Jeffery', 'Kabanda', '52 Bugala Street 4 Pallisa', '0727 898 636'),
(22, '192.168.33.1', 'rasheed81', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'ookumu@ijaga.co.ug', NULL, NULL, NULL, NULL, 1563996275, NULL, 1, 'user.png', 'user.png', 'Marion', 'Atukunda', '17 Mulalira Street 29443 Mitooma', '+256470133530'),
(23, '192.168.33.1', 'nkawuki', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'osiki.philip@rusiimwa.info', '2e4b21963a0125aab30c0c244dbe5350b1e380aa', NULL, NULL, NULL, 1563996275, NULL, 0, 'user.png', 'user.png', 'Raul', 'Kiconco', '72 Kabanda Street 20 Lugazi', '+256 775 580 065'),
(24, '192.168.33.1', 'thomas.ddamulira', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'kiganda.joe@mulalira.co.ug', '57370f4b62f327b819f135585dbc96f57df29bd4', NULL, NULL, NULL, 1563996275, NULL, 0, 'user.png', 'user.png', 'Angelina', 'Bugala', '42 Ddamulira Street 1 Nebbi', '0785875120'),
(25, '192.168.33.1', 'nabasa.tabitha', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'maxwell27@tumwiine.com', '3aeaaa8b30c6a886cff6b0b70ccfbb977966e51f', NULL, NULL, NULL, 1563996275, NULL, 0, 'user.png', 'user.png', 'Vicky', 'Bakabulindi', '28 Bbosa Street 967 Gulu', '0704424020'),
(26, '192.168.33.1', 'hkafeero', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'xtumwiine@akashaba.ug', 'bfcb98988a50e60047b0a5aa4fccb019e549aa3f', NULL, NULL, NULL, 1563996275, NULL, 0, 'user.png', 'user.png', 'Sonia', 'Tendo', '29 Ninsiima Street 22 Nansana', '0493 222 072'),
(27, '192.168.33.1', 'kityamuwesi.caesar', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'flo38@hotmail.com', NULL, NULL, NULL, NULL, 1563996275, NULL, 1, 'user.png', 'user.png', 'Shakira', 'Bamwiine', '06 Kirigwajjo Street 3 Adjumani', '0771 213 387'),
(28, '192.168.33.1', 'isabell61', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'kibirige.brian@hotmail.co.ug', '06fc06bf5f1021f6ed3f3d3e3b51e310e105fb4b', NULL, NULL, NULL, 1563996275, NULL, 0, 'user.png', 'user.png', 'Willis', 'Kazibwe', '87 Kagambira Street 46 Sironko', '+256430629770'),
(29, '192.168.33.1', 'maggie.migisha', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'kayemba.warren@hotmail.com', NULL, NULL, NULL, NULL, 1563996275, NULL, 1, 'user.png', 'user.png', 'Amy', 'Lunyoro', '31 Tuhame Street 0966 Kiruhura', '0723472770'),
(30, '192.168.33.1', 'mckenzie76', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'otwesigomwe@nimukunda.ug', NULL, NULL, NULL, NULL, 1563996275, NULL, 1, 'user.png', 'user.png', 'Vince', 'Asiimwe', '39 Kansiime Street 1 Sembabule', '0731547117'),
(31, '192.168.33.1', 'mugisha.elizabeth', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'bakabulindi.wilma@hotmail.com', NULL, NULL, NULL, NULL, 1563996275, NULL, 1, 'user.png', 'user.png', 'Clara', 'Kawooya', '72 Bukenya Street 92646 Amuru', '0413 557 988'),
(32, '192.168.33.1', 'thomas.nuwagaba', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'jkareiga@gmail.co.ug', NULL, NULL, NULL, NULL, 1563996275, NULL, 1, 'user.png', 'user.png', 'Dennis', 'Kaaya', '35 Mwesige Street 7220 Amuria', '0747 924 972'),
(33, '192.168.33.1', 'tumwebaze.juliana', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'hobol@bukenya.com', NULL, NULL, NULL, NULL, 1563996275, NULL, 1, 'user.png', 'user.png', 'Roger', 'Mukalazi', '77 Muyambi Street 4636 Kalisizo', '+256 742 684 193'),
(34, '192.168.33.1', 'susanna.kiganda', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'robyn99@nankunda.com', '90e25a87445aed2880bbfa9cededb25ace83c36f', NULL, NULL, NULL, 1563996275, NULL, 0, 'user.png', 'user.png', 'Peter', 'Nyeko', '44 Kivumbi Street 86 Adjumani', '0486 150 102'),
(35, '192.168.33.1', 'odeke.mandy', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'fkivumbi@okumuringa.co.ug', 'd1b14c2cd1bc5ec0d29e38f5f2c9bfd914507d47', NULL, NULL, NULL, 1563996275, NULL, 0, 'user.png', 'user.png', 'Eve', 'Kaaya', '81 Kibirige Street 94490 Kayunga', '0748166926'),
(36, '192.168.33.1', 'andrew.kiwanuka', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'kijjoba.jordan@isyagi.co.ug', 'f18249b9cf0e12967d0fb6b13f306de6e3d2abd7', NULL, NULL, NULL, 1563996275, NULL, 0, 'user.png', 'user.png', 'Jaquelin', 'Kasekende', '20 Nyeko Street 84 Nebbi', '+256797192697'),
(37, '192.168.33.1', 'ynabasa', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'daniella.atuhe@gmail.co.ug', 'fa19a46112ac61047377c62676fe852b36e46ae5', NULL, NULL, NULL, 1563996275, NULL, 0, 'user.png', 'user.png', 'Catharine', 'Asiimwe', '96 Atwine Street 796 Busolwe', '+256 737 031 698'),
(38, '192.168.33.1', 'bamwiine.emilia', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'rkiwanuka@hotmail.co.ug', NULL, NULL, NULL, NULL, 1563996275, NULL, 1, 'user.png', 'user.png', 'Jonathan', 'Muyambi', '56 Mwesigye Street 4826 Soroti', '+256406032743'),
(39, '192.168.33.1', 'isaac.kansiime', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'roger.ouma@yahoo.co.ug', '89c71eaaff0687f9e602592ef43977b4aeed952c', NULL, NULL, NULL, 1563996275, NULL, 0, 'user.png', 'user.png', 'Jacquelyn', 'Akashabe', '01 Turyasingura Street 98833 Kalisizo', '+256440626069'),
(40, '192.168.33.1', 'bbwana', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'zakankunda@gamwera.com', '54b03a341782d7b7af7b608aaea1894e5b2402bb', NULL, NULL, NULL, 1563996276, NULL, 0, 'user.png', 'user.png', 'Donna', 'Tusiime', '17 Nimukunda Street 93248 Kamwenge', '0727 721 932'),
(41, '192.168.33.1', 'gkirabo', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'user@manager.com', '19b4c556fbe9bf4298aec74798b34022f5bcc9dd', NULL, NULL, NULL, 1563996276, 1566561314, 1, '4a722613d1ab15b8b3a972188492cdb6.png', 'thumbnail_4a722613d1ab15b8b3a972188492cdb6.png', 'Dave', 'Kateregga', '36 Kagambira Street 22609 Masaka', '0423 811 292'),
(42, '192.168.33.1', 'flavia59', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'kitovu.meagan@gmail.com', '7bd910fc0b6a48cff17eb405bdd9d141866c1cc2', NULL, NULL, NULL, 1563996276, NULL, 0, 'user.png', 'user.png', 'Laura', 'Tusiime', '42 Nankunda Street 629 Ibanda', '0428453936'),
(43, '192.168.33.1', 'xakankwasa', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'badru.katheryn@opega.ug', 'de4a744444ac2da0caf05b006e2ab217ad4102fb', NULL, NULL, NULL, 1563996276, NULL, 0, 'user.png', 'user.png', 'Ali', 'Rwabyoma', '59 Opega Street 05 Mubende', '+256 797 158 727'),
(44, '192.168.33.1', 'bridget28', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'viva65@gmail.com', 'f542511048f56b754e32059db68f066f69c9d763', NULL, NULL, NULL, 1563996276, NULL, 0, 'user.png', 'user.png', 'Eddie', 'Mugisha', '76 Nimukunda Street 4 Wakiso', '0776 798 723'),
(45, '192.168.33.1', 'nabimanya.nicolas', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'margaret.kanshabe@buyinza.com', '40892484a4a586fb31c6f4888d8501d417613f88', NULL, NULL, NULL, 1563996276, NULL, 0, 'user.png', 'user.png', 'Emmanuelle', 'Okumuringa', '70 Bugala Street 30189 Lwakhakha', '+256796224384'),
(46, '192.168.33.1', 'gabrielle.kirabira', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'nbyanyima@hotmail.com', NULL, NULL, NULL, NULL, 1563996276, NULL, 1, 'user.png', 'user.png', 'Cleveland', 'Kityamuwesi', '56 Kazibwe Street 4130 Kiruhura', '0786281167'),
(47, '192.168.33.1', 'viviane.nuwagaba', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'jmwesigye@yahoo.com', NULL, NULL, NULL, NULL, 1563996276, NULL, 1, 'user.png', 'user.png', 'Stevie', 'Agaba', '83 Natukunda Street 92 Ntungamo', '+256 765 692 149'),
(48, '192.168.33.1', 'berry96', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'vivianne37@gmail.co.ug', '5288612a9ce9d16ee640ffc9be67670845a354a4', NULL, NULL, NULL, 1563996276, NULL, 0, 'user.png', 'user.png', 'Maxwell', 'Nankunda', '92 Kirabo Street 130 Amuru', '0796 180 254'),
(49, '192.168.33.1', 'ituhame', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'sid.aisu@mwesige.com', '000ecdcfdfb1b5cedd7182c154030f0b7d70ab52', NULL, NULL, NULL, 1563996276, NULL, 0, 'user.png', 'user.png', 'Ronald', 'Ddamulira', '62 Kafeero Street 108 Apac', '+256 491 484 339'),
(50, '192.168.33.1', 'wilfred.kanshabe', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'akashaba.jenifer@gmail.com', NULL, NULL, NULL, NULL, 1563996276, NULL, 1, 'user.png', 'user.png', 'Trudie', 'Kagambira', '32 Bwana Street 6723 Nakaseke', '+256 761 578 555'),
(51, '192.168.33.1', 'kalumba.maggie', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'dbarigye@gmail.co.ug', 'af14c20fb8c27e4548085077bd0a7239e11f9a85', NULL, NULL, NULL, 1563996276, NULL, 0, 'user.png', 'user.png', 'Don', 'Nabasa', '58 Migisha Street 2 Alebtong', '+256 718 398 498'),
(52, '14.205.23.149', 'max594', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'steve.kabuubi@kawuki.net', NULL, NULL, NULL, NULL, 1484753802, NULL, 1, 'f44e6b8b8c87f459b78c34172f200155.jpg', 'thumbnail_f44e6b8b8c87f459b78c34172f200155.jpg', 'Clinton', 'Opega', '96 Bwana Street 9401 Iganga', '0720507731'),
(53, '1.42.57.1', 'dolores61', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'tumwesigye.dahlia@bwana.net', NULL, NULL, NULL, NULL, 1484753802, NULL, 1, 'c4328fb3aa69e3ecb408a932c465ff7c.jpg', 'thumbnail_c4328fb3aa69e3ecb408a932c465ff7c.jpg', 'Dolores', 'Kalumba', '72 Kayemba Street 21 Buikwe', '0711796216'),
(54, '176.218.253.177', 'alison.biyinzika', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'wkityamuwesi@aisu.net', NULL, NULL, NULL, NULL, 1484753802, NULL, 1, 'f6c8c9398ee861e763bf270362956821.jpg', 'thumbnail_f6c8c9398ee861e763bf270362956821.jpg', 'Evelyn', 'Kivumbi', '45 Munyagwa Street 50 Lwakhakha', '+256418538130'),
(55, '209.30.189.46', 'ekayemba', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'akasumba@kayemba.com', NULL, NULL, NULL, NULL, 1484753802, NULL, 1, '291c994288abd7f6e602de7e7f4b5e36.jpg', 'thumbnail_291c994288abd7f6e602de7e7f4b5e36.jpg', 'Teresa', 'Muhwezi', '34 Twasiima Street 00 Jinja', '0403 216 929'),
(56, '94.249.240.219', 'bkasekende', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'shawn.tumwiine@kanyesigye.com', NULL, NULL, NULL, NULL, 1484753802, NULL, 1, '7e936390424f72beed9c0f16e9542eb3.jpg', 'thumbnail_7e936390424f72beed9c0f16e9542eb3.jpg', 'Lucy', 'Kabuubi', '24 Rubalema Street 1 Pakwach', '0405623000'),
(57, '190.66.62.210', 'nkoojo.nathan', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'kateregga.tony@hotmail.com', NULL, NULL, NULL, NULL, 1484753802, NULL, 1, '2813e09fa992a9303c1904f5e5575c79.png', 'thumbnail_2813e09fa992a9303c1904f5e5575c79.png', 'Keith', 'Mwesige', '57 Kabanda Street 5 Bombo', '+256709369008'),
(58, '247.251.57.32', 'arianna47', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'wrusiimwa@gmail.co.ug', NULL, NULL, NULL, NULL, 1484753802, 1564426031, 1, '9a60e007d3de28788b34e9805238a72f.jpg', 'thumbnail_9a60e007d3de28788b34e9805238a72f.jpg', 'Emmanuel', 'Aurishaba', '28 Migisha Street 66644 Amuria', '+256 431 488 318'),
(59, '24.58.37.194', 'wilson10', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'dylan.asasira@munyagwa.info', NULL, NULL, NULL, NULL, 1484753802, NULL, 1, 'c28d26ea3573ef16878087221f9328ef.jpg', 'thumbnail_c28d26ea3573ef16878087221f9328ef.jpg', 'Abdul', 'Bukenya', '20 Tusiime Street 8 Wakiso', '+256 727 240 440'),
(60, '165.84.118.214', 'nick.gamwera', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'tumusiime.anna@ijaga.org', NULL, NULL, NULL, NULL, 1484753802, NULL, 1, 'fc10c73c78aedd4e28156809b563b730.jpg', 'thumbnail_fc10c73c78aedd4e28156809b563b730.jpg', 'Luis', 'Bbosa', '74 Kiganda Street 92 Kiboga', '+256476610997'),
(61, '7.28.20.117', 'kalumba.loraine', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'tusiime.kevin@gmail.co.ug', NULL, NULL, NULL, NULL, 1484753802, NULL, 1, '9ace35926094317734196f29ebc74e13.jpg', 'thumbnail_9ace35926094317734196f29ebc74e13.jpg', 'Nina', 'Byaruhanga', '32 Atukwase Street 8922 Ngora', '+256416178156'),
(62, '213.49.146.163', 'agaba.margaret', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'ykawuki@yahoo.com', NULL, NULL, NULL, NULL, 1484753802, NULL, 1, 'e060d9d6408bf7d3f37e464b3dcce3a2.jpg', 'thumbnail_e060d9d6408bf7d3f37e464b3dcce3a2.jpg', 'Joesph', 'Okumuringa', '59 Nkurunungi Street 6057 Amuru', '+256 450 361 323'),
(63, '58.128.140.39', 'patience.aisu', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'charlie.rwabyoma@gmail.com', NULL, NULL, NULL, NULL, 1484753802, NULL, 1, '10598a23e0b014880d0ab8127bbd9469.jpg', 'thumbnail_10598a23e0b014880d0ab8127bbd9469.jpg', 'Naomie', 'Migisha', '93 Byaruhanga Street 5467 Kapchorwa', '0713796436'),
(64, '201.118.55.25', 'btamale', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'kansiime.dave@yahoo.com', NULL, NULL, NULL, NULL, 1484753802, NULL, 1, '4ed707b65e970776700c790c3d77b954.jpg', 'thumbnail_4ed707b65e970776700c790c3d77b954.jpg', 'George', 'Migisha', '09 Ankunda Street 93915 Kamwenge', '0464236369'),
(65, '44.158.131.0', 'anayebare', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'tendo.eddie@kansiime.net', NULL, NULL, NULL, NULL, 1484753802, NULL, 1, 'a077760f23a070621a3900395f59023d.jpg', 'thumbnail_a077760f23a070621a3900395f59023d.jpg', 'Ruthe', 'Okumuringa', '84 Tumwiine Street 94255 Busembatya', '0791647522'),
(66, '250.153.186.223', 'rubalema.hope', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'muhwezi.jabari@yahoo.com', NULL, NULL, NULL, NULL, 1484753802, NULL, 1, '4e0ac94cf3dd04a60beec9c6bb55fc9c.jpg', 'thumbnail_4e0ac94cf3dd04a60beec9c6bb55fc9c.jpg', 'Nathan', 'Kasekende', '19 Natukunda Street 4430 Kotido', '0436 524 691'),
(67, '226.5.202.211', 'wasswa.johnathan', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'tusiime.owen@bugala.biz', NULL, NULL, NULL, NULL, 1484753802, NULL, 1, '8cd9a54d7ff6e1435abfc1e9ef8fd668.jpg', 'thumbnail_8cd9a54d7ff6e1435abfc1e9ef8fd668.jpg', 'Jane', 'Akankunda', '53 Atwine Street 04 Abim', '+256740252120'),
(69, '37.108.238.251', 'ahebwe.ray', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'akashaba.jimmy@hotmail.com', NULL, NULL, NULL, NULL, 1484753802, NULL, 1, 'cb96b42866bfbacf4a8a3bf7f854e2ab.jpg', 'thumbnail_cb96b42866bfbacf4a8a3bf7f854e2ab.jpg', 'Hope', 'Murungi', '53 Tuhame Street 966 Alebtong', '+256427001388'),
(71, '128.120.223.218', 'ahebwe.taylor', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'christopher.baguma@kawooya.info', NULL, NULL, NULL, NULL, 1484753802, NULL, 1, '01d09a44b04b1316e99e2a55e2b70518.jpg', 'thumbnail_01d09a44b04b1316e99e2a55e2b70518.jpg', 'Amy', 'Murungi', '82 Bamwiine Street 710 Gulu', '0703 218 872'),
(72, '165.255.81.125', 'turyasingura.katherine', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'mohammad.odeke@hotmail.com', NULL, NULL, NULL, NULL, 1484753802, NULL, 1, 'f29bf77308e58f99e40c4f63daba12d1.jpg', 'thumbnail_f29bf77308e58f99e40c4f63daba12d1.jpg', 'Adrianna', 'Kabuubi', '32 Atukunda Street 3 Kibaale', '0421769754'),
(73, '113.106.59.181', 'nina.kityamuwesi', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'ezra.akashabe@hotmail.co.ug', NULL, NULL, NULL, NULL, 1484753802, NULL, 1, 'd0e1155b56e4e9142be7c14184f8a67e.jpg', 'thumbnail_d0e1155b56e4e9142be7c14184f8a67e.jpg', 'Raul', 'Nuwamanya', '86 Kareiga Street 77 Ntungamo', '0730 435 841'),
(75, '73.59.131.241', 'isaiah47', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'mabel43@akashaba.ug', NULL, NULL, NULL, NULL, 1484753802, NULL, 1, '911f708cc1e5d08ad6ddb1d46dda0c6b.jpg', 'thumbnail_911f708cc1e5d08ad6ddb1d46dda0c6b.jpg', 'Nicolas', 'Mbabazi', '48 Osiki Street 563 Amuria', '0747 608 778'),
(78, '18.36.144.37', 'cecilia80', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'sid19@buyinza.com', NULL, NULL, NULL, NULL, 1484753802, NULL, 1, '5a77c55ec21dfa53690cb7a35e2dc497.jpg', 'thumbnail_5a77c55ec21dfa53690cb7a35e2dc497.jpg', 'Theodore', 'Nkurunungi', '82 Rubalema Street 13 Lwengo', '+256 460 462 252'),
(82, '103.9.190.99', 'yvette61', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'edmund.kabuubi@yahoo.com', NULL, NULL, NULL, NULL, 1484753802, NULL, 1, '1f9bd221d0eca32af330fb1842442822.jpg', 'thumbnail_1f9bd221d0eca32af330fb1842442822.jpg', 'Nasir', 'Baguma', '58 Kagambira Street 6 Kanoni', '+256421569840'),
(85, '38.202.5.119', 'mkabanda', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'susanna.lunyoro@yahoo.co.ug', NULL, NULL, NULL, NULL, 1484753802, NULL, 1, '206ed5cd622899d820e1e5841a2c272b.jpg', 'thumbnail_206ed5cd622899d820e1e5841a2c272b.jpg', 'Emily', 'Byaruhanga', '40 Tumusiime Street 239 Kanoni', '0444264602'),
(87, '58.55.6.163', 'angel97', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'chris.kiwanuka@kisitu.co.ug', NULL, NULL, NULL, NULL, 1484753802, NULL, 1, '73bfa5a81370d729f726dd276e827ca1.png', 'thumbnail_73bfa5a81370d729f726dd276e827ca1.png', 'Dolly', 'Kasekende', '89 Kazibwe Street 69629 Kabwohe', '+256 793 465 441'),
(89, '101.146.86.57', 'joshua.atukwase', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'lrwabyoma@yahoo.com', NULL, NULL, NULL, NULL, 1484753802, NULL, 1, '4ebfb9f70828e1ecafb10017f16e6ab1.jpg', 'thumbnail_4ebfb9f70828e1ecafb10017f16e6ab1.jpg', 'Gaston', 'Muyambi', '51 Kivumbi Street 281 Malaba', '0710258081'),
(121, '33.241.118.34', 'amelia.gamwera', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'dina.bakabulindi@gmail.co.ug', NULL, NULL, NULL, NULL, 1484753802, NULL, 1, 'dc74933ad1166eba88d989b42290e1ef.png', 'thumbnail_dc74933ad1166eba88d989b42290e1ef.png', 'Eva', 'Nayebare', '90 Kirigwajjo Street 44 Kitgum', '0734 714 833'),
(126, '224.203.184.174', '', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'jaqueline.lunyoro@gmail.co.ug', NULL, NULL, NULL, NULL, 1484753802, NULL, 1, '74b4ab5cd2a1ce2dfb3f081290c1a878.jpg', 'thumbnail_74b4ab5cd2a1ce2dfb3f081290c1a878.jpg', 'Charles', 'Kirabira', '76 Kiganda Street 579 Mpondwe', '+256 708 506 195'),
(128, '161.218.174.99', 'julie.nabasa', '$2y$08$9vlNia294t4c2qZTJ36nwuVbB.OzbTZ2J6OktFlqYXfhXGYWcCX2O', '', 'rwabyoma.berta@hotmail.co.ug', NULL, NULL, NULL, NULL, 1484753802, NULL, 1, 'db932bf1c98752c8bc40459a21acf5a4.jpg', 'thumbnail_db932bf1c98752c8bc40459a21acf5a4.jpg', 'Benny', 'Kanshabe', '77 Mwesigye Street 5463 Arua', '+256746101222'),
(129, '2405:204:d406:ca', 'mpkumar2004@gmail.com', '$2y$08$502ZjqP/ftcw9U0URkFLFeyBkJ3VWmrlZXrztcNACr06NfqiNHDQi', '', 'mpkumar2004@gmail.com', 'b2a3086a91452d8b5bc8dc6c5adb8f956451333f', NULL, NULL, NULL, 1565935133, NULL, 0, NULL, NULL, 'bbbbbbbbbbbbbbbb', 'bbbbbbbbbbbb', '', ''),
(130, '177.193.169.213', 'user@doctor.com', '$2y$08$ck75j8E5sfQyNsHfoMVj3ebmvb.c6QkZ89z3vNeFJC1FUuNIevhWy', '', 'user@doctor.com', 'c6d4742c43c21e7aed073598442b0e148f0a0728', NULL, NULL, NULL, 1565989891, NULL, 0, NULL, NULL, '', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE `users_groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `user_id` mediumint(8) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1),
(2, 2, 4),
(3, 3, 4),
(4, 4, 4),
(5, 5, 4),
(6, 6, 4),
(7, 7, 4),
(8, 8, 4),
(9, 9, 4),
(10, 10, 4),
(11, 11, 4),
(12, 12, 4),
(13, 13, 4),
(14, 14, 4),
(15, 15, 4),
(16, 16, 4),
(17, 17, 4),
(18, 18, 4),
(19, 19, 4),
(20, 20, 4),
(21, 21, 4),
(22, 22, 4),
(23, 23, 4),
(24, 24, 4),
(25, 25, 4),
(26, 26, 4),
(27, 27, 4),
(28, 28, 4),
(29, 29, 4),
(30, 30, 4),
(31, 31, 4),
(32, 32, 4),
(33, 33, 4),
(34, 34, 4),
(35, 35, 4),
(36, 36, 4),
(37, 37, 4),
(38, 38, 4),
(39, 39, 4),
(40, 40, 4),
(42, 42, 4),
(43, 43, 4),
(44, 44, 4),
(45, 45, 4),
(46, 46, 4),
(47, 47, 4),
(48, 48, 4),
(49, 49, 4),
(50, 50, 4),
(51, 51, 4),
(52, 52, 2),
(53, 53, 2),
(54, 54, 2),
(55, 55, 2),
(56, 56, 2),
(57, 57, 2),
(58, 58, 2),
(59, 59, 2),
(60, 60, 2),
(61, 61, 2),
(62, 62, 2),
(63, 63, 2),
(64, 64, 2),
(65, 65, 2),
(66, 66, 2),
(67, 67, 2),
(69, 69, 2),
(71, 71, 2),
(72, 72, 2),
(73, 73, 2),
(75, 75, 2),
(78, 78, 2),
(82, 82, 2),
(85, 85, 2),
(87, 87, 2),
(89, 89, 2),
(121, 121, 2),
(126, 126, 2),
(128, 128, 2),
(162, 41, 3),
(163, 129, 4),
(164, 130, 4);

-- --------------------------------------------------------

--
-- Table structure for table `users_permissions`
--

CREATE TABLE `users_permissions` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `user_id` mediumint(8) UNSIGNED NOT NULL,
  `perm_id` mediumint(8) UNSIGNED NOT NULL,
  `value` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_permissions`
--

INSERT INTO `users_permissions` (`id`, `user_id`, `perm_id`, `value`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 0, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `timestamp` (`timestamp`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companies_facilities`
--
ALTER TABLE `companies_facilities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `company_facility_id` (`company_facility_id`);

--
-- Indexes for table `companies_files`
--
ALTER TABLE `companies_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `companies_types`
--
ALTER TABLE `companies_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `company_type_id` (`company_type_id`);

--
-- Indexes for table `companies_users`
--
ALTER TABLE `companies_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `company_facilities`
--
ALTER TABLE `company_facilities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_types`
--
ALTER TABLE `company_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `doctors_profiles`
--
ALTER TABLE `doctors_profiles`
  ADD PRIMARY KEY (`id`,`reg_no`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD UNIQUE KEY `reg_no` (`reg_no`),
  ADD KEY `location_id` (`location_id`),
  ADD KEY `speciality_id` (`speciality_id`);

--
-- Indexes for table `doctor_specialities`
--
ALTER TABLE `doctor_specialities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `groups_permissions`
--
ALTER TABLE `groups_permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `perm_id` (`perm_id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lang_sets`
--
ALTER TABLE `lang_sets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lang_translations`
--
ALTER TABLE `lang_translations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `language_id` (`language_id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`),
  ADD KEY `location_type_id` (`location_type_id`);

--
-- Indexes for table `location_types`
--
ALTER TABLE `location_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `parent_id` (`parent_id`);

--
-- Indexes for table `location_zones`
--
ALTER TABLE `location_zones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `perm_key` (`perm_key`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `group_id` (`group_id`);

--
-- Indexes for table `users_permissions`
--
ALTER TABLE `users_permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `perm_id` (`perm_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67493;

--
-- AUTO_INCREMENT for table `companies_facilities`
--
ALTER TABLE `companies_facilities`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151082;

--
-- AUTO_INCREMENT for table `companies_files`
--
ALTER TABLE `companies_files`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134976;

--
-- AUTO_INCREMENT for table `companies_types`
--
ALTER TABLE `companies_types`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67489;

--
-- AUTO_INCREMENT for table `companies_users`
--
ALTER TABLE `companies_users`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=235592;

--
-- AUTO_INCREMENT for table `company_facilities`
--
ALTER TABLE `company_facilities`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `company_types`
--
ALTER TABLE `company_types`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `doctors_profiles`
--
ALTER TABLE `doctors_profiles`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `doctor_specialities`
--
ALTER TABLE `doctor_specialities`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `groups_permissions`
--
ALTER TABLE `groups_permissions`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` mediumint(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `lang_sets`
--
ALTER TABLE `lang_sets`
  MODIFY `id` mediumint(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lang_translations`
--
ALTER TABLE `lang_translations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=180;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `location_types`
--
ALTER TABLE `location_types`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `location_zones`
--
ALTER TABLE `location_zones`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT for table `users_groups`
--
ALTER TABLE `users_groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=165;

--
-- AUTO_INCREMENT for table `users_permissions`
--
ALTER TABLE `users_permissions`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `companies_facilities`
--
ALTER TABLE `companies_facilities`
  ADD CONSTRAINT `companies_facilities_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `companies_facilities_ibfk_2` FOREIGN KEY (`company_facility_id`) REFERENCES `company_facilities` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `companies_files`
--
ALTER TABLE `companies_files`
  ADD CONSTRAINT `companies_files_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `companies_types`
--
ALTER TABLE `companies_types`
  ADD CONSTRAINT `companies_types_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `companies_types_ibfk_2` FOREIGN KEY (`company_type_id`) REFERENCES `company_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `companies_users`
--
ALTER TABLE `companies_users`
  ADD CONSTRAINT `companies_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `companies_users_ibfk_2` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `company_types`
--
ALTER TABLE `company_types`
  ADD CONSTRAINT `company_types_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `company_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `doctors_profiles`
--
ALTER TABLE `doctors_profiles`
  ADD CONSTRAINT `doctors_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `doctors_profiles_ibfk_2` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `doctors_profiles_ibfk_3` FOREIGN KEY (`speciality_id`) REFERENCES `doctor_specialities` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `groups_permissions`
--
ALTER TABLE `groups_permissions`
  ADD CONSTRAINT `groups_permissions_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `groups_permissions_ibfk_2` FOREIGN KEY (`perm_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lang_translations`
--
ALTER TABLE `lang_translations`
  ADD CONSTRAINT `lang_translations_ibfk_1` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `locations`
--
ALTER TABLE `locations`
  ADD CONSTRAINT `locations_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `locations_ibfk_2` FOREIGN KEY (`location_type_id`) REFERENCES `location_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `location_types`
--
ALTER TABLE `location_types`
  ADD CONSTRAINT `location_types_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `location_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD CONSTRAINT `users_groups_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_groups_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users_permissions`
--
ALTER TABLE `users_permissions`
  ADD CONSTRAINT `users_permissions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_permissions_ibfk_2` FOREIGN KEY (`perm_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
