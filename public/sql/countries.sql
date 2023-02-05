-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 29, 2022 at 05:00 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dine_connect`
--

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `iso`, `name`, `nicename`, `iso3`, `numcode`, `phonecode`, `status`, `sequence`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'AF', 'AFGHANISTAN', 'Afghanistan', 'AFG', 4, '+93', 1, 9999, NULL, NULL, NULL),
(2, 'AL', 'ALBANIA', 'Albania', 'ALB', 8, '+355', 1, 9999, NULL, NULL, NULL),
(3, 'DZ', 'ALGERIA', 'Algeria', 'DZA', 12, '+213', 1, 9999, NULL, NULL, NULL),
(4, 'AS', 'AMERICAN SAMOA', 'American Samoa', 'ASM', 16, '+1684', 1, 9999, NULL, NULL, NULL),
(5, 'AD', 'ANDORRA', 'Andorra', 'AND', 20, '+376', 1, 9999, NULL, NULL, NULL),
(6, 'AO', 'ANGOLA', 'Angola', 'AGO', 24, '+244', 1, 9999, NULL, NULL, NULL),
(7, 'AI', 'ANGUILLA', 'Anguilla', 'AIA', 660, '+1264', 1, 9999, NULL, NULL, NULL),
(8, 'AQ', 'ANTARCTICA', 'Antarctica', 'AQ\r', 10, '+672', 1, 9999, NULL, NULL, NULL),
(9, 'AG', 'ANTIGUA AND BARBUDA', 'Antigua and Barbuda', 'ATG', 28, '+1268', 1, 9999, NULL, NULL, NULL),
(10, 'AR', 'ARGENTINA', 'Argentina', 'ARG', 32, '+54', 1, 9999, NULL, NULL, NULL),
(11, 'AM', 'ARMENIA', 'Armenia', 'ARM', 51, '+374', 1, 9999, NULL, NULL, NULL),
(12, 'AW', 'ARUBA', 'Aruba', 'ABW', 533, '+297', 1, 9999, NULL, NULL, NULL),
(13, 'AU', 'AUSTRALIA', 'Australia', 'AUS', 36, '+61', 1, 9999, NULL, NULL, NULL),
(14, 'AT', 'AUSTRIA', 'Austria', 'AUT', 40, '+43', 1, 9999, NULL, NULL, NULL),
(15, 'AZ', 'AZERBAIJAN', 'Azerbaijan', 'AZE', 31, '+994', 1, 9999, NULL, NULL, NULL),
(16, 'BS', 'BAHAMAS', 'Bahamas', 'BHS', 44, '+1242', 1, 9999, NULL, NULL, NULL),
(17, 'BH', 'BAHRAIN', 'Bahrain', 'BHR', 48, '+973', 1, 9999, NULL, NULL, NULL),
(18, 'BD', 'BANGLADESH', 'Bangladesh', 'BGD', 50, '+880', 1, 9999, NULL, NULL, NULL),
(19, 'BB', 'BARBADOS', 'Barbados', 'BRB', 52, '+1246', 1, 9999, NULL, NULL, NULL),
(20, 'BY', 'BELARUS', 'Belarus', 'BLR', 112, '+375', 1, 9999, NULL, NULL, NULL),
(21, 'BE', 'BELGIUM', 'Belgium', 'BEL', 56, '+32', 1, 9999, NULL, NULL, NULL),
(22, 'BZ', 'BELIZE', 'Belize', 'BLZ', 84, '+501', 1, 9999, NULL, NULL, NULL),
(23, 'BJ', 'BENIN', 'Benin', 'BEN', 204, '+229', 1, 9999, NULL, NULL, NULL),
(24, 'BM', 'BERMUDA', 'Bermuda', 'BMU', 60, '+1441', 1, 9999, NULL, NULL, NULL),
(25, 'BT', 'BHUTAN', 'Bhutan', 'BTN', 64, '+975', 1, 9999, NULL, NULL, NULL),
(26, 'BO', 'BOLIVIA', 'Bolivia', 'BOL', 68, '+591', 1, 9999, NULL, NULL, NULL),
(27, 'BA', 'BOSNIA AND HERZEGOVINA', 'Bosnia and Herzegovina', 'BIH', 70, '+387', 1, 9999, NULL, NULL, NULL),
(28, 'BW', 'BOTSWANA', 'Botswana', 'BWA', 72, '+267', 1, 9999, NULL, NULL, NULL),
(29, 'BV', 'BOUVET ISLAND', 'Bouvet Island', 'BVT', 74, '+47', 1, 9999, NULL, NULL, NULL),
(30, 'BR', 'BRAZIL', 'Brazil', 'BRA', 76, '+55', 1, 9999, NULL, NULL, NULL),
(31, 'IO', 'BRITISH INDIAN OCEAN TERRITORY', 'British Indian Ocean Territory', 'IOT', 86, '+246', 1, 9999, NULL, NULL, NULL),
(32, 'BN', 'BRUNEI ', 'Brunei', 'BRN', 96, '+673', 1, 9999, NULL, NULL, NULL),
(33, 'BG', 'BULGARIA', 'Bulgaria', 'BGR', 100, '+359', 1, 9999, NULL, NULL, NULL),
(34, 'BF', 'BURKINA FASO', 'Burkina Faso', 'BFA', 854, '+226', 1, 9999, NULL, NULL, NULL),
(35, 'BI', 'BURUNDI', 'Burundi', 'BDI', 108, '+257', 1, 9999, NULL, NULL, NULL),
(36, 'KH', 'CAMBODIA', 'Cambodia', 'KHM', 116, '+855', 1, 9999, NULL, NULL, NULL),
(37, 'CM', 'CAMEROON', 'Cameroon', 'CMR', 120, '+237', 1, 9999, NULL, NULL, NULL),
(38, 'CA', 'CANADA', 'Canada', 'CAN', 124, '+1', 1, 9999, NULL, NULL, NULL),
(39, 'CV', 'CAPE VERDE', 'Cape Verde', 'CPV', 132, '+238', 1, 9999, NULL, NULL, NULL),
(40, 'KY', 'CAYMAN ISLANDS', 'Cayman Islands', 'CYM', 136, '+1345', 1, 9999, NULL, NULL, NULL),
(41, 'CF', 'CENTRAL AFRICAN REPUBLIC', 'Central African Republic', 'CAF', 140, '+236', 1, 9999, NULL, NULL, NULL),
(42, 'TD', 'CHAD', 'Chad', 'TCD', 148, '+235', 1, 9999, NULL, NULL, NULL),
(43, 'CL', 'CHILE', 'Chile', 'CHL', 152, '+56', 1, 9999, NULL, NULL, NULL),
(44, 'CN', 'CHINA', 'China', 'CHN', 156, '+86', 1, 9999, NULL, NULL, NULL),
(45, 'CX', 'CHRISTMAS ISLAND', 'Christmas Island', 'CXR', 162, '+61', 1, 9999, NULL, NULL, NULL),
(46, 'CC', 'COCOS (KEELING) ISLANDS', 'Cocos (Keeling) Islands', 'CCK', 166, '+672', 1, 9999, NULL, NULL, NULL),
(47, 'CO', 'COLOMBIA', 'Colombia', 'COL', 170, '+57', 1, 9999, NULL, NULL, NULL),
(48, 'KM', 'COMOROS', 'Comoros', 'COM', 174, '+269', 1, 9999, NULL, NULL, NULL),
(49, 'CG', 'CONGO', 'Congo', 'COG', 178, '+242', 1, 9999, NULL, NULL, NULL),
(50, 'CD', 'CONGO, THE DEMOCRATIC REPUBLIC OF THE', 'Congo, the Democratic Republic of the', 'COD', 180, '+242', 1, 9999, NULL, NULL, NULL),
(51, 'CK', 'COOK ISLANDS', 'Cook Islands', 'COK', 184, '+682', 1, 9999, NULL, NULL, NULL),
(52, 'CR', 'COSTA RICA', 'Costa Rica', 'CRI', 188, '+506', 1, 9999, NULL, NULL, NULL),
(53, 'CI', 'COTE D\'IVOIRE', 'Cote D\'Ivoire', 'CIV', 384, '+225', 1, 9999, NULL, NULL, NULL),
(54, 'HR', 'CROATIA', 'Croatia', 'HRV', 191, '+385', 1, 9999, NULL, NULL, NULL),
(55, 'CU', 'CUBA', 'Cuba', 'CUB', 192, '+53', 1, 9999, NULL, NULL, NULL),
(56, 'CY', 'CYPRUS', 'Cyprus', 'CYP', 196, '+357', 1, 9999, NULL, NULL, NULL),
(57, 'CZ', 'CZECH REPUBLIC', 'Czech Republic', 'CZE', 203, '+420', 1, 9999, NULL, NULL, NULL),
(58, 'DK', 'DENMARK', 'Denmark', 'DNK', 208, '+45', 1, 9999, NULL, NULL, NULL),
(59, 'DJ', 'DJIBOUTI', 'Djibouti', 'DJI', 262, '+253', 1, 9999, NULL, NULL, NULL),
(60, 'DM', 'DOMINICA', 'Dominica', 'DMA', 212, '+1767', 1, 9999, NULL, NULL, NULL),
(61, 'DO', 'DOMINICAN REPUBLIC', 'Dominican Republic', 'DOM', 214, '+1809', 1, 9999, NULL, NULL, NULL),
(62, 'EC', 'ECUADOR', 'Ecuador', 'ECU', 218, '+593', 1, 9999, NULL, NULL, NULL),
(63, 'EG', 'EGYPT', 'Egypt', 'EGY', 818, '+20', 1, 9999, NULL, NULL, NULL),
(64, 'SV', 'EL SALVADOR', 'El Salvador', 'SLV', 222, '+503', 1, 9999, NULL, NULL, NULL),
(65, 'GQ', 'EQUATORIAL GUINEA', 'Equatorial Guinea', 'GNQ', 226, '+240', 1, 9999, NULL, NULL, NULL),
(66, 'ER', 'ERITREA', 'Eritrea', 'ERI', 232, '+291', 1, 9999, NULL, NULL, NULL),
(67, 'EE', 'ESTONIA', 'Estonia', 'EST', 233, '+372', 1, 9999, NULL, NULL, NULL),
(68, 'ET', 'ETHIOPIA', 'Ethiopia', 'ETH', 231, '+251', 1, 9999, NULL, NULL, NULL),
(69, 'FK', 'FALKLAND ISLANDS (MALVINAS)', 'Falkland Islands (Malvinas)', 'FLK', 238, '+500', 1, 9999, NULL, NULL, NULL),
(70, 'FO', 'FAROE ISLANDS', 'Faroe Islands', 'FRO', 234, '+298', 1, 9999, NULL, NULL, NULL),
(71, 'FJ', 'FIJI', 'Fiji', 'FJI', 242, '+679', 1, 9999, NULL, NULL, NULL),
(72, 'FI', 'FINLAND', 'Finland', 'FIN', 246, '+358', 1, 9999, NULL, NULL, NULL),
(73, 'FR', 'FRANCE', 'France', 'FRA', 250, '+33', 1, 9999, NULL, NULL, NULL),
(74, 'GF', 'FRENCH GUIANA', 'French Guiana', 'GUF', 254, '+594', 1, 9999, NULL, NULL, NULL),
(75, 'PF', 'FRENCH POLYNESIA', 'French Polynesia', 'PYF', 258, '+689', 1, 9999, NULL, NULL, NULL),
(76, 'TF', 'FRENCH SOUTHERN TERRITORIES', 'French Southern Territories', 'ATF', 260, '+262', 1, 9999, NULL, NULL, NULL),
(77, 'GA', 'GABON', 'Gabon', 'GAB', 266, '+241', 1, 9999, NULL, NULL, NULL),
(78, 'GM', 'GAMBIA', 'Gambia', 'GMB', 270, '+220', 1, 9999, NULL, NULL, NULL),
(79, 'GE', 'GEORGIA', 'Georgia', 'GEO', 268, '+995', 1, 9999, NULL, NULL, NULL),
(80, 'DE', 'GERMANY', 'Germany', 'DEU', 276, '+49', 1, 9999, NULL, NULL, NULL),
(81, 'GH', 'GHANA', 'Ghana', 'GHA', 288, '+233', 1, 9999, NULL, NULL, NULL),
(82, 'GI', 'GIBRALTAR', 'Gibraltar', 'GIB', 292, '+350', 1, 9999, NULL, NULL, NULL),
(83, 'GR', 'GREECE', 'Greece', 'GRC', 300, '+30', 1, 9999, NULL, NULL, NULL),
(84, 'GL', 'GREENLAND', 'Greenland', 'GRL', 304, '+299', 1, 9999, NULL, NULL, NULL),
(85, 'GD', 'GRENADA', 'Grenada', 'GRD', 308, '+1473', 1, 9999, NULL, NULL, NULL),
(86, 'GP', 'GUADELOUPE', 'Guadeloupe', 'GLP', 312, '+590', 1, 9999, NULL, NULL, NULL),
(87, 'GU', 'GUAM', 'Guam', 'GUM', 316, '+1671', 1, 9999, NULL, NULL, NULL),
(88, 'GT', 'GUATEMALA', 'Guatemala', 'GTM', 320, '+502', 1, 9999, NULL, NULL, NULL),
(89, 'GN', 'GUINEA', 'Guinea', 'GIN', 324, '+224', 1, 9999, NULL, NULL, NULL),
(90, 'GW', 'GUINEA-BISSAU', 'Guinea-Bissau', 'GNB', 624, '+245', 1, 9999, NULL, NULL, NULL),
(91, 'GY', 'GUYANA', 'Guyana', 'GUY', 328, '+592', 1, 9999, NULL, NULL, NULL),
(92, 'HT', 'HAITI', 'Haiti', 'HTI', 332, '+509', 1, 9999, NULL, NULL, NULL),
(93, 'HM', 'HEARD ISLAND AND MCDONALD ISLANDS', 'Heard Island and Mcdonald Islands', 'HMD', 334, '+0', 1, 9999, NULL, NULL, NULL),
(94, 'VA', 'HOLY SEE (VATICAN CITY STATE)', 'Holy See (Vatican City State)', 'VAT', 336, '+39', 1, 9999, NULL, NULL, NULL),
(95, 'HN', 'HONDURAS', 'Honduras', 'HND', 340, '+504', 1, 9999, NULL, NULL, NULL),
(96, 'HK', 'HONG KONG', 'Hong Kong', 'HKG', 344, '+852', 1, 9999, NULL, NULL, NULL),
(97, 'HU', 'HUNGARY', 'Hungary', 'HUN', 348, '+36', 1, 9999, NULL, NULL, NULL),
(98, 'IS', 'ICELAND', 'Iceland', 'ISL', 352, '+354', 1, 9999, NULL, NULL, NULL),
(99, 'IN', 'INDIA', 'India', 'IND', 356, '+91', 1, 9999, NULL, NULL, NULL),
(100, 'ID', 'INDONESIA', 'Indonesia', 'IDN', 360, '+62', 1, 9999, NULL, NULL, NULL),
(101, 'IR', 'IRAN, ISLAMIC REPUBLIC OF', 'Iran, Islamic Republic of', 'IRN', 364, '+98', 1, 9999, NULL, NULL, NULL),
(102, 'IQ', 'IRAQ', 'Iraq', 'IRQ', 368, '+964', 1, 9999, NULL, NULL, NULL),
(103, 'IE', 'IRELAND', 'Ireland', 'IRL', 372, '+353', 1, 9999, NULL, NULL, NULL),
(104, 'IL', 'ISRAEL', 'Israel', 'ISR', 376, '+972', 1, 9999, NULL, NULL, NULL),
(105, 'IT', 'ITALY', 'Italy', 'ITA', 380, '+39', 1, 9999, NULL, NULL, NULL),
(106, 'JM', 'JAMAICA', 'Jamaica', 'JAM', 388, '+1876', 1, 9999, NULL, NULL, NULL),
(107, 'JP', 'JAPAN', 'Japan', 'JPN', 392, '+81', 1, 9999, NULL, NULL, NULL),
(108, 'JO', 'JORDAN', 'Jordan', 'JOR', 400, '+962', 1, 9999, NULL, NULL, NULL),
(109, 'KZ', 'KAZAKHSTAN', 'Kazakhstan', 'KAZ', 398, '+7', 1, 9999, NULL, NULL, NULL),
(110, 'KE', 'KENYA', 'Kenya', 'KEN', 404, '+254', 1, 9999, NULL, NULL, NULL),
(111, 'KI', 'KIRIBATI', 'Kiribati', 'KIR', 296, '+686', 1, 9999, NULL, NULL, NULL),
(112, 'KP', 'KOREA, DEMOCRATIC PEOPLE\'S REPUBLIC OF', 'Korea, Democratic People\'s Republic of', 'PRK', 408, '+850', 1, 9999, NULL, NULL, NULL),
(113, 'KR', 'KOREA, REPUBLIC OF', 'Korea, Republic of', 'KOR', 410, '+82', 1, 9999, NULL, NULL, NULL),
(114, 'KW', 'KUWAIT', 'Kuwait', 'KWT', 414, '+965', 1, 9999, NULL, NULL, NULL),
(115, 'KG', 'KYRGYZSTAN', 'Kyrgyzstan', 'KGZ', 417, '+996', 1, 9999, NULL, NULL, NULL),
(116, 'LA', 'LAO PEOPLE\'S DEMOCRATIC REPUBLIC', 'Lao People\'s Democratic Republic', 'LAO', 418, '+856', 1, 9999, NULL, NULL, NULL),
(117, 'LV', 'LATVIA', 'Latvia', 'LVA', 428, '+371', 1, 9999, NULL, NULL, NULL),
(118, 'LB', 'LEBANON', 'Lebanon', 'LBN', 422, '+961', 1, 9999, NULL, NULL, NULL),
(119, 'LS', 'LESOTHO', 'Lesotho', 'LSO', 426, '+266', 1, 9999, NULL, NULL, NULL),
(120, 'LR', 'LIBERIA', 'Liberia', 'LBR', 430, '+231', 1, 9999, NULL, NULL, NULL),
(121, 'LY', 'LIBYAN ARAB JAMAHIRIYA', 'Libyan Arab Jamahiriya', 'LBY', 434, '+218', 1, 9999, NULL, NULL, NULL),
(122, 'LI', 'LIECHTENSTEIN', 'Liechtenstein', 'LIE', 438, '+423', 1, 9999, NULL, NULL, NULL),
(123, 'LT', 'LITHUANIA', 'Lithuania', 'LTU', 440, '+370', 1, 9999, NULL, NULL, NULL),
(124, 'LU', 'LUXEMBOURG', 'Luxembourg', 'LUX', 442, '+352', 1, 9999, NULL, NULL, NULL),
(125, 'MO', 'MACAO', 'Macao', 'MAC', 446, '+853', 1, 9999, NULL, NULL, NULL),
(126, 'MK', 'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF', 'Macedonia, the Former Yugoslav Republic of', 'MKD', 807, '+389', 1, 9999, NULL, NULL, NULL),
(127, 'MG', 'MADAGASCAR', 'Madagascar', 'MDG', 450, '+261', 1, 9999, NULL, NULL, NULL),
(128, 'MW', 'MALAWI', 'Malawi', 'MWI', 454, '+265', 1, 9999, NULL, NULL, NULL),
(129, 'MY', 'MALAYSIA', 'Malaysia', 'MYS', 458, '+60', 1, 0, NULL, NULL, NULL),
(130, 'MV', 'MALDIVES', 'Maldives', 'MDV', 462, '+960', 1, 9999, NULL, NULL, NULL),
(131, 'ML', 'MALI', 'Mali', 'MLI', 466, '+223', 1, 9999, NULL, NULL, NULL),
(132, 'MT', 'MALTA', 'Malta', 'MLT', 470, '+356', 1, 9999, NULL, NULL, NULL),
(133, 'MH', 'MARSHALL ISLANDS', 'Marshall Islands', 'MHL', 584, '+692', 1, 9999, NULL, NULL, NULL),
(134, 'MQ', 'MARTINIQUE', 'Martinique', 'MTQ', 474, '+596', 1, 9999, NULL, NULL, NULL),
(135, 'MR', 'MAURITANIA', 'Mauritania', 'MRT', 478, '+222', 1, 9999, NULL, NULL, NULL),
(136, 'MU', 'MAURITIUS', 'Mauritius', 'MUS', 480, '+230', 1, 9999, NULL, NULL, NULL),
(137, 'YT', 'MAYOTTE', 'Mayotte', 'MYT', 175, '+269', 1, 9999, NULL, NULL, NULL),
(138, 'MX', 'MEXICO', 'Mexico', 'MEX', 484, '+52', 1, 9999, NULL, NULL, NULL),
(139, 'FM', 'MICRONESIA, FEDERATED STATES OF', 'Micronesia, Federated States of', 'FSM', 583, '+691', 1, 9999, NULL, NULL, NULL),
(140, 'MD', 'MOLDOVA, REPUBLIC OF', 'Moldova, Republic of', 'MDA', 498, '+373', 1, 9999, NULL, NULL, NULL),
(141, 'MC', 'MONACO', 'Monaco', 'MCO', 492, '+377', 1, 9999, NULL, NULL, NULL),
(142, 'MN', 'MONGOLIA', 'Mongolia', 'MNG', 496, '+976', 1, 9999, NULL, NULL, NULL),
(143, 'MS', 'MONTSERRAT', 'Montserrat', 'MSR', 500, '+1664', 1, 9999, NULL, NULL, NULL),
(144, 'MA', 'MOROCCO', 'Morocco', 'MAR', 504, '+212', 1, 9999, NULL, NULL, NULL),
(145, 'MZ', 'MOZAMBIQUE', 'Mozambique', 'MOZ', 508, '+258', 1, 9999, NULL, NULL, NULL),
(146, 'MM', 'MYANMAR', 'Myanmar', 'MMR', 104, '+95', 1, 9999, NULL, NULL, NULL),
(147, 'NA', 'NAMIBIA', 'Namibia', 'NAM', 516, '+264', 1, 9999, NULL, NULL, NULL),
(148, 'NR', 'NAURU', 'Nauru', 'NRU', 520, '+674', 1, 9999, NULL, NULL, NULL),
(149, 'NP', 'NEPAL', 'Nepal', 'NPL', 524, '+977', 1, 9999, NULL, NULL, NULL),
(150, 'NL', 'NETHERLANDS', 'Netherlands', 'NLD', 528, '+31', 1, 9999, NULL, NULL, NULL),
(151, 'AN', 'NETHERLANDS ANTILLES', 'Netherlands Antilles', 'ANT', 530, '+599', 1, 9999, NULL, NULL, NULL),
(152, 'NC', 'NEW CALEDONIA', 'New Caledonia', 'NCL', 540, '+687', 1, 9999, NULL, NULL, NULL),
(153, 'NZ', 'NEW ZEALAND', 'New Zealand', 'NZL', 554, '+64', 1, 9999, NULL, NULL, NULL),
(154, 'NI', 'NICARAGUA', 'Nicaragua', 'NIC', 558, '+505', 1, 9999, NULL, NULL, NULL),
(155, 'NE', 'NIGER', 'Niger', 'NER', 562, '+227', 1, 9999, NULL, NULL, NULL),
(156, 'NG', 'NIGERIA', 'Nigeria', 'NGA', 566, '+234', 1, 9999, NULL, NULL, NULL),
(157, 'NU', 'NIUE', 'Niue', 'NIU', 570, '+683', 1, 9999, NULL, NULL, NULL),
(158, 'NF', 'NORFOLK ISLAND', 'Norfolk Island', 'NFK', 574, '+672', 1, 9999, NULL, NULL, NULL),
(159, 'MP', 'NORTHERN MARIANA ISLANDS', 'Northern Mariana Islands', 'MNP', 580, '+1670', 1, 9999, NULL, NULL, NULL),
(160, 'NO', 'NORWAY', 'Norway', 'NOR', 578, '+47', 1, 9999, NULL, NULL, NULL),
(161, 'OM', 'OMAN', 'Oman', 'OMN', 512, '+968', 1, 9999, NULL, NULL, NULL),
(162, 'PK', 'PAKISTAN', 'Pakistan', 'PAK', 586, '+92', 1, 9999, NULL, NULL, NULL),
(163, 'PW', 'PALAU', 'Palau', 'PLW', 585, '+680', 1, 9999, NULL, NULL, NULL),
(164, 'PS', 'PALESTINIAN TERRITORY, OCCUPIED', 'Palestinian Territory, Occupied', 'PSE', 275, '+970', 1, 9999, NULL, NULL, NULL),
(165, 'PA', 'PANAMA', 'Panama', 'PAN', 591, '+507', 1, 9999, NULL, NULL, NULL),
(166, 'PG', 'PAPUA NEW GUINEA', 'Papua New Guinea', 'PNG', 598, '+675', 1, 9999, NULL, NULL, NULL),
(167, 'PY', 'PARAGUAY', 'Paraguay', 'PRY', 600, '+595', 1, 9999, NULL, NULL, NULL),
(168, 'PE', 'PERU', 'Peru', 'PER', 604, '+51', 1, 9999, NULL, NULL, NULL),
(169, 'PH', 'PHILIPPINES', 'Philippines', 'PHL', 608, '+63', 1, 9999, NULL, NULL, NULL),
(170, 'PN', 'PITCAIRN', 'Pitcairn', 'PCN', 612, '+64', 1, 9999, NULL, NULL, NULL),
(171, 'PL', 'POLAND', 'Poland', 'POL', 616, '+48', 1, 9999, NULL, NULL, NULL),
(172, 'PT', 'PORTUGAL', 'Portugal', 'PRT', 620, '+351', 1, 9999, NULL, NULL, NULL),
(173, 'PR', 'PUERTO RICO', 'Puerto Rico', 'PRI', 630, '+1787', 1, 9999, NULL, NULL, NULL),
(174, 'QA', 'QATAR', 'Qatar', 'QAT', 634, '+974', 1, 9999, NULL, NULL, NULL),
(175, 'RE', 'REUNION', 'Reunion', 'REU', 638, '+262', 1, 9999, NULL, NULL, NULL),
(176, 'RO', 'ROMANIA', 'Romania', 'ROM', 642, '+40', 1, 9999, NULL, NULL, NULL),
(177, 'RU', 'RUSSIAN FEDERATION', 'Russian Federation', 'RUS', 643, '+70', 1, 9999, NULL, NULL, NULL),
(178, 'RW', 'RWANDA', 'Rwanda', 'RWA', 646, '+250', 1, 9999, NULL, NULL, NULL),
(179, 'SH', 'SAINT HELENA', 'Saint Helena', 'SHN', 654, '+290', 1, 9999, NULL, NULL, NULL),
(180, 'KN', 'SAINT KITTS AND NEVIS', 'Saint Kitts and Nevis', 'KNA', 659, '+1869', 1, 9999, NULL, NULL, NULL),
(181, 'LC', 'SAINT LUCIA', 'Saint Lucia', 'LCA', 662, '+1758', 1, 9999, NULL, NULL, NULL),
(182, 'PM', 'SAINT PIERRE AND MIQUELON', 'Saint Pierre and Miquelon', 'SPM', 666, '+508', 1, 9999, NULL, NULL, NULL),
(183, 'VC', 'SAINT VINCENT AND THE GRENADINES', 'Saint Vincent and the Grenadines', 'VCT', 670, '+1784', 1, 9999, NULL, NULL, NULL),
(184, 'WS', 'SAMOA', 'Samoa', 'WSM', 882, '+684', 1, 9999, NULL, NULL, NULL),
(185, 'SM', 'SAN MARINO', 'San Marino', 'SMR', 674, '+378', 1, 9999, NULL, NULL, NULL),
(186, 'ST', 'SAO TOME AND PRINCIPE', 'Sao Tome and Principe', 'STP', 678, '+239', 1, 9999, NULL, NULL, NULL),
(187, 'SA', 'SAUDI ARABIA', 'Saudi Arabia', 'SAU', 682, '+966', 1, 9999, NULL, NULL, NULL),
(188, 'SN', 'SENEGAL', 'Senegal', 'SEN', 686, '+221', 1, 9999, NULL, NULL, NULL),
(189, 'CS', 'SERBIA', 'Serbia', 'SRB', 688, '+381', 1, 9999, NULL, NULL, NULL),
(190, 'SC', 'SEYCHELLES', 'Seychelles', 'SYC', 690, '+248', 1, 9999, NULL, NULL, NULL),
(191, 'SL', 'SIERRA LEONE', 'Sierra Leone', 'SLE', 694, '+232', 1, 1, NULL, NULL, NULL),
(192, 'SG', 'SINGAPORE', 'Singapore', 'SGP', 702, '+65', 1, 9999, NULL, NULL, NULL),
(193, 'SK', 'SLOVAKIA', 'Slovakia', 'SVK', 703, '+421', 1, 9999, NULL, NULL, NULL),
(194, 'SI', 'SLOVENIA', 'Slovenia', 'SVN', 705, '+386', 1, 9999, NULL, NULL, NULL),
(195, 'SB', 'SOLOMON ISLANDS', 'Solomon Islands', 'SLB', 90, '+677', 1, 9999, NULL, NULL, NULL),
(196, 'SO', 'SOMALIA', 'Somalia', 'SOM', 706, '+252', 1, 9999, NULL, NULL, NULL),
(197, 'ZA', 'SOUTH AFRICA', 'South Africa', 'ZAF', 710, '+27', 1, 9999, NULL, NULL, NULL),
(198, 'GS', 'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS', 'South Georgia and the South Sandwich Islands', 'SGS', 239, '+500', 1, 9999, NULL, NULL, NULL),
(199, 'ES', 'SPAIN', 'Spain', 'ESP', 724, '+34', 1, 9999, NULL, NULL, NULL),
(200, 'LK', 'SRI LANKA', 'Sri Lanka', 'LKA', 144, '+94', 1, 9999, NULL, NULL, NULL),
(201, 'SD', 'SUDAN', 'Sudan', 'SDN', 736, '+249', 1, 9999, NULL, NULL, NULL),
(202, 'SR', 'SURINAME', 'Suriname', 'SUR', 740, '+597', 1, 9999, NULL, NULL, NULL),
(203, 'SJ', 'SVALBARD AND JAN MAYEN', 'Svalbard and Jan Mayen', 'SJM', 744, '+47', 1, 9999, NULL, NULL, NULL),
(204, 'SZ', 'SWAZILAND', 'Swaziland', 'SWZ', 748, '+268', 1, 9999, NULL, NULL, NULL),
(205, 'SE', 'SWEDEN', 'Sweden', 'SWE', 752, '+46', 1, 9999, NULL, NULL, NULL),
(206, 'CH', 'SWITZERLAND', 'Switzerland', 'CHE', 756, '+41', 1, 9999, NULL, NULL, NULL),
(207, 'SY', 'SYRIAN ARAB REPUBLIC', 'Syrian Arab Republic', 'SYR', 760, '+963', 1, 9999, NULL, NULL, NULL),
(208, 'TW', 'TAIWAN, PROVINCE OF CHINA', 'Taiwan, Province of China', 'TWN', 158, '+886', 1, 9999, NULL, NULL, NULL),
(209, 'TJ', 'TAJIKISTAN', 'Tajikistan', 'TJK', 762, '+992', 1, 9999, NULL, NULL, NULL),
(210, 'TZ', 'TANZANIA, UNITED REPUBLIC OF', 'Tanzania, United Republic of', 'TZA', 834, '+255', 1, 9999, NULL, NULL, NULL),
(211, 'TH', 'THAILAND', 'Thailand', 'THA', 764, '+66', 1, 9999, NULL, NULL, NULL),
(212, 'TL', 'TIMOR-LESTE', 'Timor-Leste', 'TLS', 626, '+670', 1, 9999, NULL, NULL, NULL),
(213, 'TG', 'TOGO', 'Togo', 'TGO', 768, '+228', 1, 9999, NULL, NULL, NULL),
(214, 'TK', 'TOKELAU', 'Tokelau', 'TKL', 772, '+690', 1, 9999, NULL, NULL, NULL),
(215, 'TO', 'TONGA', 'Tonga', 'TON', 776, '+676', 1, 9999, NULL, NULL, NULL),
(216, 'TT', 'TRINIDAD AND TOBAGO', 'Trinidad and Tobago', 'TTO', 780, '+1868', 1, 9999, NULL, NULL, NULL),
(217, 'TN', 'TUNISIA', 'Tunisia', 'TUN', 788, '+216', 1, 9999, NULL, NULL, NULL),
(218, 'TR', 'TURKEY', 'Turkey', 'TUR', 792, '+90', 1, 9999, NULL, NULL, NULL),
(219, 'TM', 'TURKMENISTAN', 'Turkmenistan', 'TKM', 795, '+993', 1, 9999, NULL, NULL, NULL),
(220, 'TC', 'TURKS AND CAICOS ISLANDS', 'Turks and Caicos Islands', 'TCA', 796, '+1649', 1, 9999, NULL, NULL, NULL),
(221, 'TV', 'TUVALU', 'Tuvalu', 'TUV', 798, '+688', 1, 9999, NULL, NULL, NULL),
(222, 'UG', 'UGANDA', 'Uganda', 'UGA', 800, '+256', 1, 9999, NULL, NULL, NULL),
(223, 'UA', 'UKRAINE', 'Ukraine', 'UKR', 804, '+380', 1, 9999, NULL, NULL, NULL),
(224, 'AE', 'UNITED ARAB EMIRATES', 'United Arab Emirates', 'ARE', 784, '+971', 1, 9999, NULL, NULL, NULL),
(225, 'GB', 'UNITED KINGDOM', 'United Kingdom', 'GBR', 826, '+44', 1, 9999, NULL, NULL, NULL),
(226, 'US', 'UNITED STATES', 'United States', 'USA', 840, '+1', 1, 9999, NULL, NULL, NULL),
(227, 'UM', 'UNITED STATES MINOR OUTLYING ISLANDS', 'United States Minor Outlying Islands', 'UMI', 581, '+246', 1, 9999, NULL, NULL, NULL),
(228, 'UY', 'URUGUAY', 'Uruguay', 'URY', 858, '+598', 1, 9999, NULL, NULL, NULL),
(229, 'UZ', 'UZBEKISTAN', 'Uzbekistan', 'UZB', 860, '+998', 1, 9999, NULL, NULL, NULL),
(230, 'VU', 'VANUATU', 'Vanuatu', 'VUT', 548, '+678', 1, 9999, NULL, NULL, NULL),
(231, 'VE', 'VENEZUELA', 'Venezuela', 'VEN', 862, '+58', 1, 9999, NULL, NULL, NULL),
(232, 'VN', 'VIET NAM', 'Viet Nam', 'VNM', 704, '+84', 1, 9999, NULL, NULL, NULL),
(233, 'VG', 'VIRGIN ISLANDS, BRITISH', 'Virgin Islands, British', 'VGB', 92, '+1284', 1, 9999, NULL, NULL, NULL),
(234, 'VI', 'VIRGIN ISLANDS, U.S.', 'Virgin Islands, U.s.', 'VIR', 850, '+1340', 1, 9999, NULL, NULL, NULL),
(235, 'WF', 'WALLIS AND FUTUNA', 'Wallis and Futuna', 'WLF', 876, '+681', 1, 9999, NULL, NULL, NULL),
(236, 'EH', 'WESTERN SAHARA', 'Western Sahara', 'ESH', 732, '+212', 1, 9999, NULL, NULL, NULL),
(237, 'YE', 'YEMEN', 'Yemen', 'YEM', 887, '+967', 1, 9999, NULL, NULL, NULL),
(238, 'ZM', 'ZAMBIA', 'Zambia', 'ZMB', 894, '+260', 1, 9999, NULL, NULL, NULL),
(239, 'ZW', 'ZIMBABWE', 'Zimbabwe', 'ZWE', 716, '+263', 1, 9999, NULL, NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
