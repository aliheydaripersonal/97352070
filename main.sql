-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 07, 2022 at 02:55 PM
-- Server version: 5.7.36
-- PHP Version: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `classified`
--

-- --------------------------------------------------------

--
-- Table structure for table `accesses`
--

DROP TABLE IF EXISTS `accesses`;
CREATE TABLE IF NOT EXISTS `accesses` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` int(11) UNSIGNED DEFAULT NULL,
  `active` int(11) DEFAULT NULL,
  `date` int(11) DEFAULT NULL,
  `expire_date` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `token` (`token`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accesses`
--

INSERT INTO `accesses` (`id`, `user_id`, `token`, `ip`, `active`, `date`, `expire_date`) VALUES
(1, 1, '3mnm28YEzy1659803856DO9t4Tuw5FidWqcjATlb248678G7NHZGy3gw', 2130706433, 1, 1659803856, 1662395856),
(2, 1, '2a4j9gzyLE1660110843vnzzWGBL1EmFUykUgw6H6912955MtBnOE4QE', 2130706433, 1, 1660110843, 1662702843),
(3, 1, 'oOyahBkAGW1660323227XTquJO2XkNlyY9q9t4Q1691816Keu0fU5vQ2', 2130706433, 1, 1660323227, 1662915227),
(4, 1, '5UNiUev9Ue16604229638CFqx1IY79UY1ztXQgmA123634HnpjqOxT62', 2130706433, 1, 1660422963, 1663014963),
(5, 1, 'AA5UdWux7b1662388679mjbH5z3lv77F4ImKNFWv300184Ucu2pughc0', 2130706433, 1, 1662388679, 1664980679),
(6, 1, '4knagJaA5g1662537990odVMzNPbeV1BVOPq2hZa490405oP7bhlEjQt', 2130706433, 1, 1662537990, 1665129990),
(7, 1, 'jx6EDuPaEc1662538822J3wukk1aPeQo0aLJQYUf595808pZmxng56ML', 2130706433, 1, 1662538822, 1665130822),
(8, 2, 'UqiQ55cQJ81662550725K2HZVwzgnA1uWO2ju6Ap325165xWo7a2UguP', 2130706433, 1, 1662550725, 1665142725),
(9, 1, 'Clf7aGtcym166255670549iNIhYWTUIMIdImmEOH721618KW5Xxcwfx9', 2130706433, 1, 1662556705, 1665148705);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`) USING BTREE,
  KEY `status` (`status`),
  KEY `parent_id` (`parent_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1160 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `content`, `parent_id`, `status`) VALUES
(1, 'خدمات', 'service', NULL, NULL, 0, 0),
(2, 'برای فروش', 'for-sale', NULL, NULL, 0, 0),
(4, 'استخدام', 'jobs', NULL, NULL, 0, 0),
(5, 'برای اجاره', 'for-rent', NULL, NULL, 0, 0),
(7, 'وسایل نقلیه', 'cars-vehicles', NULL, NULL, 2, 0),
(8, 'وسایل نقلیه', 'cars-vehicles-services', NULL, NULL, 5, 0),
(10, 'خودرو', 'auto-other-vehicle-services', NULL, NULL, 1, 0),
(11, 'پرستار کودک', 'care', NULL, NULL, 1, 0),
(12, 'خدمات نظافتی', 'cleaning-services', NULL, NULL, 1, 0),
(35, 'عتیقه جات', 'antiques', NULL, NULL, 2, 0),
(36, 'لوازم خانگی', 'appliances', NULL, NULL, 2, 0),
(66, 'مدیریت', 'admin', NULL, NULL, 4, 0),
(67, 'بازاریابی', 'advertising', NULL, NULL, 4, 0),
(68, 'معماری', 'architecture', NULL, NULL, 4, 0),
(69, 'هنر', 'art-jobs', NULL, NULL, 4, 0),
(125, 'املاک', 'real-estate', NULL, NULL, 2, 0),
(126, 'املاک', 'real-estate-services', NULL, NULL, 5, 0);

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

DROP TABLE IF EXISTS `cities`;
CREATE TABLE IF NOT EXISTS `cities` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `country_id` int(10) UNSIGNED DEFAULT NULL,
  `province_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alternates` text COLLATE utf8mb4_unicode_ci,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `timezone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `population` int(10) UNSIGNED DEFAULT NULL,
  `latitude` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`) USING BTREE,
  KEY `province_id` (`province_id`),
  KEY `country_id` (`country_id`)
) ENGINE=MyISAM AUTO_INCREMENT=193543 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `country_id`, `province_id`, `name`, `alternates`, `slug`, `timezone`, `population`, `latitude`, `longitude`) VALUES
(98121, 30, 1365, 'طالقان', 'Shahrak,Shahrak-e Taleqan,Shahrak-e Ţāleqān,Taleqan,Tāleqān,shhrk,shhrk talqan,taliqan,talqan,Ţāleqān,تالِقان,شهرك,شهرک طالقان,طالقان', 'taleqan', 'Asia/Tehran', 0, '36.17449', '50.76908'),
(98122, 30, 1366, 'الوند', 'Alborz,Alvand,albrz,alwnd,البرز,الوند', 'alvand-qazvin', 'Asia/Tehran', 90000, '36.1893', '50.0643'),
(98123, 30, 1367, 'آزادشهر', 'Azad Shahr,Azadshahr,azadshhr,Āzādshahr,آزادشهر', 'azadshahr-hamadan', 'Asia/Tehran', 514102, '34.79049', '48.57011'),
(98124, 30, 1368, 'نير', 'Nir,Nīr,Shahrestan-e Nir,Shahrestān-e Nīr,nyr,shhrstan nyr,شهرستان نير,نير', 'nir', 'Asia/Tehran', 0, '38.0346', '47.9986'),
(98125, 30, 1369, 'کندوان', 'Kandavan,Kandavān,Kandkhan,Kandkhān,Kandovan,Kandovān,Kanvan,Kanvān,kndwan,Кандован,کندوان', 'kandovan', 'Asia/Tehran', 601, '37.7949', '46.2487'),
(98126, 30, 1369, 'قره آغاج', 'Qarah Aghaj,Qarah Āghāj,Qareh Aghaj,Qareh Āghāj,qrh aghaj,قره آغاج', 'qarah-aghaj', 'Asia/Tehran', 0, '37.2187', '47.2167'),
(98127, 30, 1369, 'بستان آباد', 'Bostanabad,Bostānābād,bstan abad,بستان آباد', 'bostanabad', 'Asia/Tehran', 0, '37.84633', '46.83542'),
(98128, 30, 1370, 'کهریز', 'Kahriz,Kahrīz,khryz,کهریز', 'kahriz', 'Asia/Tehran', 766706, '34.3838', '47.0553'),
(98129, 30, 1371, 'نور آباد', 'Nurabad,Nūrābād,nwr abad,Нурабад,نور آباد', 'nurabad-lorestan-province', 'Asia/Tehran', 73528, '34.0734', '47.9725'),
(98130, 30, 1370, 'جوانرود', 'Javanrud,Javānrūd,Juanru,Jūānrū,Qal`a Juanrud,Qal`eh Juanrud,Qal`eh-ye Javanrud,Qal‘a Jūanrūd,Qal‘eh Jūānrūd,Qal‘eh-ye Javānrūd,jwanrwd,جوانرود', 'javanrud', 'Asia/Tehran', 0, '34.8067', '46.4913'),
(98131, 30, 1372, 'فيروزه', 'Barghan,Barghān,Bozghan,Bozghān,Firuzeh,Fīrūzeh,bzghan,fyrwzh,بزغان,فيروزه', 'bozghan', 'Asia/Tehran', 0, '36.28639', '58.58586'),
(98132, 30, 1372, 'کلات نادری', 'Kalat,Kalat-e Naderi,Kalāt,Kalāt-e Nāderī,klat,klat nadry,کلات,کلات نادری', 'kalat-e-naderi', 'Asia/Tehran', 0, '36.99532', '59.76472'),
(98133, 30, 1373, 'يستگاهِ گَرمسار', 'Istgah-e Garmsar,Istgah-e Rah Ahan Garmsar,Istgah-e Rah Ahan-e Garmsar,aystgah grmsar,aystgah rahahn garmsar,ystgahi garmsar,ystgahi rah ahan garmsar,ystgahi rahahani garmsar,Īstgāh-e Garmsār,Īstgāh-e Rāh Āhan Garmsār,Īstgāh-e Rāh Āhan-e Garmsār,ايستگاه راهاهن گَرمسار,ايستگاه گرمسار,يستگاهِ راه آهَن گَرمسار,يستگاهِ راهاهَنِ گَرمسار,يستگاهِ گَرمسار', 'istgah-e-rah-ahan-e-garmsar', 'Asia/Tehran', 49491, '35.23455', '52.30942'),
(98134, 30, 1374, 'قرچك', 'Qarchak,qrchk,قرچك', 'qarchak', 'Asia/Tehran', 251834, '35.42867', '51.57544'),
(98135, 30, 1374, 'شهرک امام حسن مجتبی', 'Shahrak-e Emam Hasan,Shahrak-e Emam Hasan-e Mojtaba,Shahrak-e Emām Ḩasan,Shahrak-e Emām Ḩasan-e Mojtabá,shhrk amam hsn,shhrk amam hsn mjtby,شهرک امام حسن,شهرک امام حسن مجتبی', 'shahrak-e-emam-hasan', 'Asia/Tehran', 5394, '35.48846', '51.34567'),
(98136, 30, 1374, 'شهر جدید اندیشه', 'Shahrak-e Andisheh,Shahrak-e Andīsheh,shhr jdyd andyshh,شهر جدید اندیشه', 'shahre-jadide-andisheh', 'Asia/Tehran', 80000, '35.6803', '51.0193'),
(98137, 30, 1368, 'اُميدچِه', 'Omidcheh,Omīdcheh,aumydchih,اُميدچِه', 'omidcheh', 'Asia/Tehran', 1710, '38.28667', '48.14139'),
(98138, 30, 1375, 'آق قايِه', 'Aq Qayeh,aq qayih,Āq Qāyeh,آق قايِه', 'aq-qayeh', 'Asia/Tehran', 5114, '37.27472', '55.15889'),
(98139, 30, 1375, 'گميشان', 'Gish Dafeh,Gomesh Tappeh,Gomish Tappeh,Gomish Tappeh Jik,Gomishan,Gomīsh Tappeh,Gomīsh Tappeh Jīk,Gomīshān,Gumish Tepe,Gumshan,Gumshān,Gīsh Dafeh,gmysh tph,gmyshan,گميش تپه,گميشان', 'gomishan', 'Asia/Tehran', 0, '37.0718', '54.07654'),
(98140, 30, 1376, 'پائین بازار رودبار', 'Pa\'in-e Bazar-e Rudbar,Pā’īn-e Bāzār-e Rūdbār,Rudbar,Rudbar-e Kuhpayeh-ye Pa\'in,Rūdbār,Rūdbār-e Kūhpāyeh-ye Pā’īn,payyn bazar rwdbar,rwdbar,rwdbar kwhpayh payyn,رودبار,رودبار کوهپایه پائین,پائین بازار رودبار', 'pa-in-e-bazar-e-rudbar', 'Asia/Tehran', 0, '36.8211', '49.4264'),
(98141, 30, 1377, 'خرمدره', 'Khorramdareh,Khorramdarreh,Khurramdarreh,Khurramdarrekh,khrmdrh,خرمدره', 'khorramdarreh', 'Asia/Tehran', 50528, '36.20777', '49.19527'),
(98142, 30, 1376, 'پادگان منجیل', 'Ordugah-e Nezami Manjil,Ordūgāh-e Nez̧āmī Manjīl,Padegan-e Manjil,Pādegān-e Manjīl,padgan mnjyl,پادگان منجیل', 'padegan-e-manjil', 'Asia/Tehran', 17396, '36.7415', '49.4161'),
(98143, 30, 1378, 'کوار', 'Kaval,Kavar,Kavār,kwar,کوار', 'kavar', 'Asia/Tehran', 0, '29.205', '52.6899'),
(98144, 30, 1379, 'یاسوج', 'Jasudz,Jasudzh,Jasudż,Jasudž,Jásúdž,YES,Yasooj,Yasuc,Yasudsch,Yasuj,Yasûc,Yesuj,Yesūj,Yāsūj,ya su ji,yasuj,yasuja,yasujeu,yasuju,yaswj,yiswj,yswj,Ёсӯҷ,Ясудж,Յասուջ,ياسوج,يَسُّج,يِسوج,یاسوج,یسوج,यासूज,ヤースージュ,亞蘇季,야수즈', 'yasuj', 'Asia/Tehran', 96786, '30.66824', '51.58796'),
(98145, 30, 1375, 'شاه پسند', 'Azadshahr,Shah Pasand,Shāh Pasand,azad shhr,shah psnd,Āzādshahr,آزاد شهر,شاه پسند', 'azadshahr-golestan', 'Asia/Tehran', 47590, '37.08641', '55.17222'),
(98147, 30, 1377, 'زرین آباد', 'Zarinabad,Zarrinabad,Zarrīnābād,zryn abad,زرین آباد', 'zarrinabad', 'Asia/Tehran', 0, '36.42622', '48.28158'),
(98148, 30, 1380, 'زرند', 'Zarand,zrnd,زرند', 'zarand-iran', 'Asia/Tehran', 58983, '30.81271', '56.56399'),
(98149, 30, 1377, 'زنجان', 'JWN,Zanjan,Zanjān,Zendzhan,Zenjan,Zenjān,znjan,Зенджан,زنجان', 'zanjan', 'Asia/Tehran', 357471, '36.67642', '48.49628'),
(98150, 30, 1381, 'یزد', 'AZD,Dakbayan sa Yazd,Giaznt,Jasd,Jazd,Jazdo,Jezd,Jezdas,Yasd,Yazd,Yezd,Yəzd,iezdi,ya ci de,yajeudeu,yazda,yazudo,yzd,Γιαζντ,Јазд,Йезд,Язд,Յազդ,יזד,يزد,یزد,यज़्द,იეზდი,ヤズド,亚兹德,야즈드', 'yazd', 'Asia/Tehran', 477905, '31.89722', '54.3675'),
(98151, 30, 1371, 'چَم باغِ وِيسيان', 'Cham Bagh-e Veysian,Cham Bāgh-e Veysīān,Vaisiyan,Vaisyan,Vasian,Vasīān,Veseyan,Veseyān,Veysian,Veysiyan,Veysīyān,Veysīān,Voisiyan,cham baghi wisyan,wasyan,wisian,wisyan,وَسيان,وِسِيان,وِيسيان,وِيسيّان,چَم باغِ وِيسيان', 'vasian', 'Asia/Tehran', 1817, '33.49083', '48.04917'),
(98152, 30, 1369, 'وِرَزگَن', 'Varazqan,Varazqān,Varezqan,Varezqān,Varzagan,Varzaghan Dezmar,Varzagān,Varzaqan,Varzaqān,Verazgan,Verazqan,Verazqān,warzagan,warzaghan dizmar,wirazgan,wrzqan,ورزقان,وَرزَغَن دِزمَر,وَرزَگان,وِرَزگَن', 'varazqan', 'Asia/Tehran', 0, '38.67549', '46.11205'),
(98153, 30, 1374, 'ورامين', 'Esfandabad,Esfandābād,Varamin,Varāmīn,Veramin,Verāmin,varamin,wramyn,Варамин,ورامين', 'varamin', 'Asia/Tehran', 179603, '35.3242', '51.6457'),
(98154, 30, 1367, 'تُّيسِركَن', 'Tooyserkan,Tuisarkan,Tuysarkan,Tuyserkan,Tūysarkān,Tūyserkān,Tūīsarkān,tuysirkan,twysrkan,تویسرکان,تُّيسِركَن', 'tuyserkan', 'Asia/Tehran', 0, '34.551', '48.44353'),
(98155, 30, 1372, 'طرقبه', 'Targhobeh,Toroqbeh,Torqabeh,Torqebeh,trqbh,Ţoroqbeh,Ţorqabeh,طرقبه', 'torqabeh', 'Asia/Tehran', 0, '36.3104', '59.3735'),
(98156, 30, 1372, 'تربت حیدریه', 'Torbat-e Heydariyeh,Torbat-e Ḩeydarīyeh,Torbat-e-Heydari,Turbat-i-Haidari,Turbet-i-Haidari,trbt hydryh,تربت حیدریه', 'torbat-e-heydariyeh', 'Asia/Tehran', 125633, '35.27401', '59.21949'),
(98157, 30, 1382, 'تنکابن', 'Shahsavar,Shahsavār,Shahsawar,Shahsawār,Tonekabon,Tonekābon,tnkabn,Тонекабон,تنکابن', 'tonekabon', 'Asia/Tehran', 37501, '36.81626', '50.87376'),
(98158, 30, 1374, 'تهران', 'THR,Taekhran,Tahran,Techerane,Teera,Teerao,Teerã,Teerão,Tegeran,Teheran,Teherana,Teheranas,Teherano,Teherán,Teherāna,Tehran,Tehrano,Tekheran,Téhéran,de hei lan,teharan,teharana,tehelan,teheran,tehran,teirani,thran,thrn,thrwn,tihiran,tihran,Τεχεράνη,Тæхран,Тегеран,Техеран,Теҳрон,Թեհրան,טהראן,טהרן,تهران,تهرون,تِهران,تِهِرَن,تہران,طهران,ܛܗܪܐܢ,तेहरान,তেহরান,தெஹ்ரான்,เตหะราน,ཏེ་ཧི་རན​།,თეირანი,ቴህራን,テヘラン,德黑兰,德黑蘭,테헤란', 'tehran', 'Asia/Tehran', 7153309, '35.69439', '51.42151'),
(98159, 30, 1376, 'هشتپر توالش', 'Gashpar,Hashtpar,Hashtpar-e Tavalesh,Hashtpar-e Tavālesh,Otak Saray,Otaq Sarai,Otaq Saray,Otāq Sarai,Oţāq Sarāy,Talesh,Tālesh,hshtpr,hshtpr twalsh,هشتپر,هشتپر توالش', 'hashtpar', 'Asia/Tehran', 45305, '37.79658', '48.90521'),
(98160, 30, 1374, 'طالب آباد', 'Taleb Abad,talb abad,طالب آباد', 'taleb-abad', 'Asia/Tehran', 4850, '35.5013', '51.53147'),
(98161, 30, 1366, 'تاكستان', 'Seyadahan,Seyādahan,Siadehan,Siahdehan,Siakh-Degen,Siakhdekhan,Sīahdehān,Sīādehan,Takestan,Takistan,Tākestān,Tākistān,takstan,تاكستان', 'takestan', 'Asia/Tehran', 71499, '36.07057', '49.69571'),
(98162, 30, 1383, 'تکاب', 'Takab,Takan Tepe,Takāb,tkab,تکاب', 'takab', 'Asia/Tehran', 51541, '36.4009', '47.1133'),
(98163, 30, 1374, 'تجريش', 'Tajrish,Tajrīsh,tjrysh,تجريش', 'tajrish', 'Asia/Tehran', 0, '35.8044', '51.4256'),
(98164, 30, 1381, 'هرات', 'Burd Harat,Burd Herat,Būrd Harāt,Būrd Herāt,Harat Khowreh,Harāt Khowreh,Herat,Herat-i-Khurreh,Herāt,Herāt-i-Khurreh,Shahr-e Herat,Shahr-e Herāt,Tajabad,Tajabad-e Harat,Tājābād,Tājābād-e Harāt,hrat,shhr hrat,شهر هرات,هرات', 'shahr-e-herat', 'Asia/Tehran', 0, '30.05407', '54.37294'),
(98165, 30, 1381, 'تفت', 'Taft,tft,Тафт,تفت', 'taft-yazd-iran', 'Asia/Tehran', 19394, '31.74384', '54.20278'),
(98166, 30, 1384, 'تفرش', 'Tafresh,tfrsh,Тафреш,تفرش', 'tafresh', 'Asia/Tehran', 14399, '34.69307', '50.01601'),
(98167, 30, 1369, 'تبریز', 'TBZ,Tabrez,Tabris,Tabriz,Tabrizo,Tabríz,Tabrīz,Taebris,Taebriz,Tampriz,Tauris,Tebriz,Tebriza,Tebrizas,Tebrīza,Tehbryz,Tewrez,Tewrêz,Toewriz,Täbris,Täbriz,Töwriz,Təbriz,da bu li shi,ta bris,tabareza,tabariza,tabeulijeu,tabris,taburizu,tavrizi,tbryz,Ταμπρίζ,Табрез,Табриз,Тебриз,Тэбрыз,Тәбриз,Թավրիզ,טאבריז,תבריז,تبريز,تبریز,تەورێز,तबरेज़,ਤਬਰੀਜ਼,ടാബ്രിസ്,ตาบริซ,ཊ་བི་རི་ཛ།,თავრიზი,タブリーズ,大不里士,타브리즈', 'tabriz', 'Asia/Tehran', 1424641, '38.08', '46.2919'),
(98168, 30, 1381, 'گلشن', 'Golshan,Gulshan,TCX,Tabas,Tabas Gilaki,Tebes,Təbəs,ta ba si,tbs,Ţabas,Табас,Тебес,شہرستان طبس,طبس,塔巴斯', 'tabas', 'Asia/Tehran', 49993, '33.59586', '56.92437'),
(98169, 30, 1378, 'سوریان', 'Sureyan,Surian,Suriyan,Sūreyān,Sūrīyān,Sūrīān,swryan,سوریان', 'surian-iran', 'Asia/Tehran', 0, '30.4551', '53.651'),
(98170, 30, 1382, 'سورک', 'Surak,Sūrak,swrk,سورک', 'surak', 'Asia/Tehran', 0, '36.59488', '53.20762'),
(98171, 30, 1382, 'نور', 'Nur,Nūr,Suldeh,Sulehdeh,Sūldeh,Sūlehdeh,nwr,swldih,swlihdih,سولدِه,سولِهدِه,نور', 'nur-iran', 'Asia/Tehran', 0, '36.57168', '52.0153'),
(98172, 30, 1376, 'صومعه سرا', 'Somee Sara,Sowma`eh Sara,Sowme`eh Sara,Sume`eh Sara,Sumehsara,Sumesera,Şowma‘eh Sarā,Şowme‘eh Sarā,Şūme‘eh Sarā,صومعه سرا', 'sowme-eh-sara', 'Asia/Tehran', 0, '37.30134', '49.31504'),
(98173, 30, 1373, 'سرخه', 'Sorkheh,Surkheh,srkhh,سرخه', 'sorkheh', 'Asia/Tehran', 0, '35.4633', '53.214'),
(98174, 30, 1370, 'سنقر', 'Sanghur,Sanghūr,Sonqor,Sunqur,Sūnqūr,snqr,سنقر', 'sonqor', 'Asia/Tehran', 43174, '34.78187', '47.59945'),
(98175, 30, 1372, 'سلطان آباد', 'Kashmar,Soltanabad,Solţānābād,Sultanabad,Sultānābād,Turshiz,sltan abad,سلطان آباد', 'soltanabad', 'Asia/Tehran', 0, '36.40352', '58.03894'),
(98176, 30, 1380, 'سیرجان', 'SYJ,Sa\'idabad,Sa‘īdābād,Sircan,Sirdschan,Sirdzan,Sirdzhan,Sirdżan,Sirdžan,Sirjan,Sīrjān,sirajana,syrjan,xi er zhan,Серҷон,Сирджан,سيرجان,سیرجان,सीरजान,錫爾詹', 'sirjan', 'Asia/Tehran', 207645, '29.45137', '55.6809'),
(98177, 30, 1376, 'سیاهکل', 'Seyah Kal,Seyāh Kal,Siah Kal,Siahkal,Siahkal Mahalleh,Siyah Kal,Sīyāh Kal,Sīāh Kal,Sīāhkal,Sīāhkal Maḩalleh,syahkl,سیاهکل', 'siahkal', 'Asia/Tehran', 0, '37.15328', '49.87136'),
(98178, 30, 1385, 'شوشتر', 'Shooshtar,Shushtar,Shushtehr,Shustar,Shūshtar,Shūstar,shwshtr,Шуштэр,شوشتر', 'shushtar', 'Asia/Tehran', 77507, '32.04972', '48.84843'),
(98179, 30, 1385, 'شوش', 'Shoosh,Shush,Shūsh,Susa,Suse,Susy,Suza,Suzo,Suzy,Súsy,Sūsa,shwsh,susa,Сузы,شوش,スーサ', 'shush', 'Asia/Tehran', 52284, '32.1942', '48.2436'),
(98180, 30, 1386, 'شیروان', 'Shirvan,Shīrvān,shyrwan,شیروان', 'shirvan', 'Asia/Tehran', 82790, '37.39669', '57.92952'),
(98181, 30, 1378, 'شیراز', 'Chimaz,Chiraz,SYZ,Schiras,Sheroz,Shiraz,Shyraz,Shīrāz,Siraz,Siraza,Sirazas,Sirazo,Siráz,Sjiraz,Sziraz,Xiraz,chi ras,she la zi,shirazi,shirazu,shyraz,silajeu,Ŝirazo,Şiraz,Şîraz,Širaz,Širazas,Šíráz,Šīrāz,Šīrāza,Σιράζ,Шероз,Шираз,Шыраз,Շիրազ,שיראז,شيراز,شیراز,ชีราซ,შირაზი,シーラーズ,設拉子,시라즈', 'shiraz', 'Asia/Tehran', 1249942, '29.61031', '52.53113'),
(98182, 30, 1374, 'شَريف آباد', 'Sharifabad,Sharīfābād,sharyf abad,shryf abad,شريف آباد,شَريف آباد', 'sharifabad', 'Asia/Tehran', 8870, '35.4275', '51.78528'),
(98183, 30, 1387, 'شلمزار', 'Shalamzar,Shalamzār,shlmzar,شلمزار', 'shalamzar', 'Asia/Tehran', 0, '32.0465', '50.81639'),
(98184, 30, 1387, 'شهر كرد', 'CQD,QHK,Shahr Kord,Shahr Kurd,Shahr-e Kord,Shahrekord,Shakhre-Kord,shhr krd,Шахре-Корд,شهر كرد', 'shahr-e-kord', 'Asia/Tehran', 129153, '32.32612', '50.8572'),
(98185, 30, 1380, 'شهر بابک', 'Shahr Babak,Shahr Bābak,Shahr-e Babak,Shahr-e Bābak,Shahr-i-Babak,Shahr-i-Bābak,shhr babk,شهر بابک', 'shahr-e-babak', 'Asia/Tehran', 52409, '30.1165', '55.1186'),
(98186, 30, 1376, 'شفت', 'Bazar Shaft,Bāzār Shaft,Shaft,shft,شفت', 'shaft', 'Asia/Tehran', 0, '37.1702', '49.3998'),
(98187, 30, 1385, 'شادگان', 'Fallabiyeh,Fallahiyeh,Fallehiyeh,Fallābīyeh,Fallāḩīyeh,Shadegan,Shadeganskie,Shadgan,Shādegān,Shādgān,shadgan,Шадеганские,شادگان', 'shadegan', 'Asia/Tehran', 37220, '30.64924', '48.66497'),
(98188, 30, 1369, 'شبستر', 'Chabiastar,Shabestar,Shabiastar,Shabistar,shbstr,Шабестар,شبستر', 'shabestar', 'Asia/Tehran', 0, '38.1804', '45.7028'),
(98189, 30, 1383, 'قَرِه اِينی', 'Kara Aineh,Qareh Eyni,Qareh Eynī,Seyah Cheshmeh,Siah Chashmeh,Siah Cheshmeh,Siyah Cheshmeh,Siāh Chashmeh,Sīyah Cheshmeh,Sīāh Cheshmeh,qarih ainy,syah chishmih,syh chshmh,سياه چِشمِه,سيه چشمه,قَرِه اِينی', 'seyah-cheshmeh', 'Asia/Tehran', 0, '39.06508', '44.38416'),
(98190, 30, 1373, 'سمنان', 'SNX,Semnan,Semnān,smnan,Семнан,سمنان', 'semnan', 'Asia/Tehran', 124826, '35.57691', '53.39205'),
(98191, 30, 1388, 'سمیرم', 'Samirum,Semirom,Semīrom,Simrom,Sīmrom,smyrm,سمیرم', 'semirom', 'Asia/Tehran', 27220, '31.41667', '51.56667'),
(98192, 30, 1385, 'سدین یک', 'Sedeyyen-e Bala,Sedeyyen-e Bālā,Sedeyyen-e Yek,Sedin-e Yek,Sedīn-e Yek,Seyyedin-e Bala,Seyyedin-e Yek,Seyyedīn-e Bālā,Seyyedīn-e Yek,S̄edīn-e Yek,Tadayyon-e Yek,sdyn yk,tdyn yk,thdyn yk,تدین یک,ثدین یک,سدین یک', 'sedeyen-e-yek', 'Asia/Tehran', 1082, '31.36205', '48.81833'),
(98193, 30, 1384, 'ساوه', 'Sava,Saveh,Sāveh,sawh,Сава,ساوه', 'saveh', 'Asia/Tehran', 175533, '35.0213', '50.3566'),
(98194, 30, 1378, 'سروستان', 'Sarvestan,Sarvestān,Sarvistan,Sarvistān,srwstan,سروستان', 'sarvestan', 'Asia/Tehran', 0, '29.2735', '53.2203'),
(98195, 30, 1389, 'سرو آباد', 'Sarrabad,Sarrābād,Sarvabad,Sarvābād,Saulawa,Saulāwa,Sulaveh,Sūlāveh,srw abad,سرو آباد', 'sarvabad', 'Asia/Tehran', 0, '35.3126', '46.3669'),
(98196, 30, 1382, 'ساری', 'SRY,Sari,Sari i Iran,Saris,Sariyo,Sarí,Sarî,Shahr-i-Tajan,Shari-i-Tajan,Sori,Szari,Szári,Sárí,Sārī,sa li shi,sali,sari,sary,sary  ayran,Σάρι,Сари,Сарі,Сорӣ,Սարի,سارى,ساري,ساری,ساری، ایران,सारी,სარი,サーリー,薩里市,사리', 'sari', 'Asia/Tehran', 255396, '36.56332', '53.06009'),
(98197, 30, 1383, 'سردشت', 'Sardasht,srdsht,سردشت', 'sardasht-west-azerbaijan', 'Asia/Tehran', 0, '36.1552', '45.4788'),
(98198, 30, 1390, 'سردشت بشاکرد', 'Sardasht,Sardasht-e Bashakerd,Sardasht-e Bashākerd,srdsht,srdsht bshakrd,سردشت,سردشت بشاکرد', 'sardasht-hormozgan', 'Asia/Tehran', 0, '26.4559', '57.9028'),
(98199, 30, 1391, 'سربیشه', 'Sar-bice,Sarbisheh,Sarbīsheh,srbyshh,سربیشه', 'sarbisheh', 'Asia/Tehran', 0, '32.57566', '59.79821'),
(98200, 30, 1391, 'سرایان', 'Sara\'ian,Sarayan,Sarāyān,Sarā’īān,Siryan,Sīryān,srayan,سرایان', 'sarayan', 'Asia/Tehran', 0, '33.86017', '58.52166'),
(98201, 30, 1392, 'سرابله', 'Sarableh,Sarābleh,srablh,سرابله', 'sarableh', 'Asia/Tehran', 0, '33.76772', '46.56578'),
(98202, 30, 1371, 'سراب دوره', 'Sarab Darreh,Sarab Doreh,Sarab Dowrah,Sarab Dowreh,Sarab-e Do Rah,Sarab-e Dowreh,Sarab-e Dureh,Sarabdowreh,Sarāb Darreh,Sarāb Doreh,Sarāb Dowrah,Sarāb Dowreh,Sarāb-e Do Rah,Sarāb-e Dowreh,Sarāb-e Dūreh,Sarābdowreh,srab dwrh,سراب دوره', 'sarab-e-dureh', 'Asia/Tehran', 0, '33.5639', '48.0221'),
(98203, 30, 1369, 'سراب', 'Sarab,Sarāb,srab,سراب', 'sarab', 'Asia/Tehran', 0, '37.9408', '47.5367'),
(98204, 30, 1389, 'سقز', 'Saggiz,Saggız,Saghez,Saghghez,Sakez,Sakezo,Sakiz,Sakkiz,Sakīz,Saqez,Saqqez,Saqqez (2),Saqqiz,Saqqız,Sekkez,Seqiz,sa gai zi,saghiz,sakkeja,sakyz,saqiz,sqz,sqz (1),sqz (2),Саққиз,Секкез,سقز,سقّز (1),سقّز (٢),سَغِز,سَقِّز,سَكيز,سەقز,सक्केज,薩蓋茲', 'saqqez', 'Asia/Tehran', 151237, '36.24992', '46.2735'),
(98205, 30, 1389, 'سنندج', 'SDG,Sanandadsch,Sanandadz,Sanandadż,Sanandadž,Sanandago,Sanandaj,Sanandaĝo,Sanandij,Senendec,Senendedzas,Senendedzh,Senendedžas,Senendehdzh,Senna,Senneh,Sinandij,Sine,Sinneh,Sənəndəc,sa nan da ji,sanandaja,sanandaji,sina,sinih,snndj,Санандаџ,Санандаҷ,Сенендедж,Сенендэдж,Сәнәндәҗ,Սանանդաջ,سنندج,سنە,سِنَّ,سِنِّه,सनंदज,सनंदाज,萨南达季,사난다지', 'sanandaj', 'Asia/Tehran', 349176, '35.31495', '46.99883'),
(98206, 30, 1383, 'سلماس', 'Dilmagan,Dilman,Dīlmagān,Dīlman,Salmas,Salmās,Shahpoor,Shahpur,Shapur,Shāhpūr,slmas,Салмас,سلماس', 'salmas', 'Asia/Tehran', 81606, '38.1973', '44.7653'),
(98207, 30, 1374, 'سله بن', 'Soleh Bon,slh bn,سله بن', 'soleh-bon', 'Asia/Tehran', 1500, '35.76841', '52.56091'),
(98208, 30, 1382, 'رامسر', 'RZR,Ramsar,Ransar,Rāmsar,Rānsar,Sakht Sar,ramsr,ramusaru,رامسر,ラームサル', 'ramsar', 'Asia/Tehran', 0, '36.91796', '50.64802'),
(98209, 30, 1383, 'شاهین دژ', 'Sa\'in Dezh,Sa\'in Qal`eh,Sahin Dazh,Sain Kaleh,Shahin Dezh,Shāhīn Dezh,Sāīn Kaleh,shahyn dzh,Şā’īn Dezh,Şā’īn Qal‘eh,شاهین دژ', 'shahin-dezh', 'Asia/Tehran', 41442, '36.6793', '46.5669'),
(98210, 30, 1370, 'صحنه', 'Sahna,Sahneh,Sehneh,shnh,Şaḩneh,صحنه', 'sahneh', 'Asia/Tehran', 0, '34.4813', '47.6908'),
(98211, 30, 1372, 'سبزوار', 'AFZ,Sabzawar,Sabzawār,Sabzevar,Sabzevār,Sabzewar,Sabzivor,Sebzevar,Səbzivar,sa bo ze wa er,sab si war,sabzevara,sbzwar,Сабзевар,Сабзивор,Себзевар,سبزوار,सब्ज़ेवार,ซับซีวาร์,薩卜澤瓦爾', 'sabzevar', 'Asia/Tehran', 226183, '36.2126', '57.68191'),
(98212, 30, 1378, 'سعادت شهر', 'Sa\'adat Abad,Sa`adat Shahr,Sa`adatabad,Sa‘ādat Shahr,Sa‘ādatābād,Sa’ādat Ābād,سعادت شهر', 'sa-adat-shahr', 'Asia/Tehran', 0, '30.07921', '53.13464'),
(98213, 30, 1376, 'رودسر', 'Rud-i-Sar,Rudsar,Rūd-i-Sar,Rūdsar,rwdsr,رودسر', 'rudsar', 'Asia/Tehran', 47502, '37.13696', '50.29174'),
(98214, 30, 1380, 'نرماشير', 'Narmashir,Narmāshīr,Rostamabad,Rostamābād,nrmashyr,rstm abad,رستم آباد,نرماشير', 'narmashir', 'Asia/Tehran', 0, '28.95216', '58.69773'),
(98215, 30, 1372, 'رشتخوار', 'Rash Khar,Rashkhvan,Rashkhvān,Rashtkhvar,Rashtkhvār,Roshkhvar,Roshkhvār,Roshtehkhvar,Roshtehkhvār,Roshtkhar,Roshtkhvar,Roshtkhvār,Roshtkhār,Rushkar,Rūshkār,rshtkhwar,رشتخوار', 'roshtkhvar', 'Asia/Tehran', 0, '34.97512', '59.62482'),
(98216, 30, 1374, 'رباط كريم', 'Robat Karim,Robāţ Karīm,Shahriar,Shahryar,Shahryār,rbat krym,رباط كريم', 'robat-karim', 'Asia/Tehran', 62753, '35.4846', '51.0829'),
(98217, 30, 1376, 'رضوانشهر', 'Razvand,Rezvandeh,Rezvanshahr,Rezvāndeh,Rezvānshahr,Reẕvāndeh,Reẕvānshahr,Rizvand,Rizwand,rdwandh,rdwanshhr,رضوانده,رضوانشهر', 'rezvanshahr', 'Asia/Tehran', 0, '37.54976', '49.13703'),
(98218, 30, 1367, 'رزن', 'Razan,rzn,رزن', 'razan', 'Asia/Tehran', 0, '35.38625', '49.0334'),
(98219, 30, 1380, 'راور', 'Ravar,Rāvar,rawr,راور', 'ravar', 'Asia/Tehran', 40167, '31.26562', '56.80545'),
(98220, 30, 1370, 'روانسر', 'Ravansar,Ravānsar,Rawansir,Rawānsīr,rwansr,روانسر', 'ravansar', 'Asia/Tehran', 0, '34.7153', '46.6533'),
(98221, 30, 1376, 'رشت', 'RAS,Raixt,Rascht,Rasht,Rasjt,Rast,Rasto,Raszt,Raŝto,Rašt,Reshh,Resht,Rest,Restas,Reşt,Reštas,Rəşt,la shen te,lasyuteu,rashuto,rasta,reshti,rsht,Рашт,Решт,Рещ,Рәшт,Ռեշտ,ראשת,رشت,ڕەشت,रश्त,แรชต์,რეშთი,ラシュト,拉什特,라슈트', 'rasht-iran', 'Asia/Tehran', 594590, '37.27611', '49.58862'),
(98222, 30, 1385, 'رامشیر', 'Khalafabad,Khalafābād,Khalas Abad,Ram Shahr,Ramshir,Rāmshīr,khlf abad,ramshyr,خلف آباد,رامشیر', 'ramshir', 'Asia/Tehran', 19454, '30.89315', '49.40787'),
(98223, 30, 1375, 'راميان', 'Rameyan,Ramian,Ramiyan,Rāmeyān,Rāmīyān,Rāmīān,ramyan,راميان', 'ramian', 'Asia/Tehran', 0, '37.01598', '55.14123'),
(98224, 30, 1385, 'رامهرمز', 'Ram Hormuz,Ramhormoz,Ramuz,Rām Hormuz,Rāmhormoz,Rāmuz,ramhrmz,رامهرمز', 'ramhormoz', 'Asia/Tehran', 38821, '31.27997', '49.60351'),
(98225, 30, 1380, 'رفسنجان', 'Bahramabad,Bahrāmābād,RJN,Rafsandzhane,Rafsanjan,Rafsanjān,Rafsinjan,Rafsinjān,rfsnjan,Рафсанджане,رفسنجان', 'rafsanjan', 'Asia/Tehran', 147680, '30.4067', '55.9939'),
(98226, 30, 1380, 'رابر', 'Raber,Rabor,Rabur,Rahbur,Rābor,Rābur,Rāhbur,rabr,رابر', 'rabor', 'Asia/Tehran', 0, '29.2912', '56.9131'),
(98227, 30, 1372, 'قوچان', 'Gochan,Quchan,Qūchān,qwchan,قوچان', 'quchan', 'Asia/Tehran', 111752, '37.106', '58.50955'),
(98228, 30, 1389, 'قروه', 'Qorveh,Qurve,Qurveh,qrwh,قروه', 'qorveh', 'Asia/Tehran', 87953, '35.1664', '47.80564'),
(98229, 30, 1393, 'قم', 'Dakbayan sa Qom,Ghom,Homo,Kom,Kum,Kum shaary,Kumas,QUM,Qom,Qum,Qûm,gomu,koma,ku mu,kum,kuvom,qm,qwm,Ĥomo,Ком,Кум,Кум шаары,Қум,קום,قم,قوم,कोम,குவோம்,ゴム,库姆,쿰', 'qom', 'Asia/Tehran', 900000, '34.6401', '50.8764'),
(98230, 30, 1367, 'قهورد علیا', 'Ghohorde Olya,Ghohordé Olya,Khokhurd Bala,Khokhūrd Bāla,Qohord,Qohord-e Bala,Qohord-e Bālā,Qohord-e `Olya,Qohord-e ‘Olyā,Qohurd-e `Olya,Qohūrd-e ‘Olyā,qhrd bala,قهرد بالا,قهورد علیا', 'qohurd-e-olya', 'Asia/Tehran', 2115, '35.43979', '48.07362'),
(98231, 30, 1378, 'قیر و کارزین', 'Qir,Qir va Karzin,Qīr,Qīr va Kārzīn,qyr,qyr w karzyn,قیر,قیر و کارزین', 'qir', 'Asia/Tehran', 0, '28.4825', '53.0346'),
(98232, 30, 1390, 'قشم', 'Bandar-e Qeshm,Gheshm,Keshm,Qeshm,Qishm,qshm,Кешм,قشم', 'qeshm', 'Asia/Tehran', 25000, '26.9492', '56.2691'),
(98233, 30, 1366, 'قزوین', 'Dakbayan sa Qazvin,GZW,Gazvin,Kazvin,Kazvinas,Kazvín,Kazwin,Kuazvin,Qazvin,Qazvín,Qazvīn,Qazwen,Qazwên,Qəzvin,gazuvuin,jia ci wen,kajeubin,kazvina,kxs win,qzwyn,Казвин,Казвін,Къазвин,Қазвин,Ղազվին,قزوين,قزوین,قەزوین,कज़्वीन,กอซวีน,ყაზვინი,ガズヴィーン,加兹温,카즈빈', 'qazvin', 'Asia/Tehran', 333635, '36.26877', '50.0041'),
(98234, 30, 1370, 'قصر شيرين', 'Ghasr-i-shirin,Ghasr-shirin,Ghasr-shīrīn,Ghasr-ī-shīrīn,Qasr-e Shirin,Qasr-i-Shirin,Qasr-ī-Shīrīn,Qaşr-e Shīrīn,qsr shyryn,قصر شيرين', 'qasr-e-shirin', 'Asia/Tehran', 0, '34.5156', '45.5791'),
(98235, 30, 1375, 'قرن آباد', 'Qarnabad,Qarnābād,qrn abad,قرن آباد', 'qarnabad', 'Asia/Tehran', 1961, '36.82203', '54.59222'),
(98236, 30, 1383, 'قره ضیاء الدین', 'Ghareh Ziya\' Oddin,Ghareh Ziya’ Oddin,Qara Zia ud Din,Qara Zīa ud Dīn,Qarah Zia\' od Din,Qarah Ẕīā’ od Dīn,Qaraziadin,Qareh Zeya ed Din,Qareh Zeyā ed Dīn,Qareh Zia\' od Din,Qareh Ziya \'Eddin,Qareh Zīyā ’Eddīn,Qareh Ẕīā’ od Dīn,قره ضیاء الدین', 'qarah-zia-od-din', 'Asia/Tehran', 31947, '38.8915', '45.0255'),
(98237, 30, 1374, 'كَرَج', 'Karaj,Qal`eh Hasan,Qal`eh-ye Hasan Khan,Qal‘eh Hasan,Qal‘eh-ye Ḩasan Khān,Qods,Shahr-e Qods,Shahrak-e Qods,karaj,qds,shhr qds,shhrk qds,شهر قدس,شهرك قدس,قدس,قلعه حسن خان,قَلعِه هَسَن,كَرَج', 'shahr-e-qods', 'Asia/Tehran', 0, '35.7214', '51.109'),
(98238, 30, 1380, 'قلعه گنج', 'Ghal`eh Ganj,Ghal‘eh Ganj,Kalat-i-Ganj,Kalateh-ye Ganj,Kalāt-i-Ganj,Kalāteh-ye Ganj,Mohammadabad,Moḩammadābād,Qal`eh Ganj,Qal`eh-ye Ganj,Qal‘eh Ganj,Qal‘eh-ye Ganj,قلعه گنج', 'qal-eh-ganj', 'Asia/Tehran', 0, '27.5236', '57.8811'),
(98239, 30, 1390, 'قَلعِۀ دِهِ بارِز', 'Bala Shahr,Bala Shahr-e Deh Barez,Bālā Shahr,Bālā Shahr-e Deh Bārez,Deh Barez,Deh Bariz,Deh Bārez,Deh Bāriz,Deh Dariz,Deh Dāriz,Dehbarez,Dehbārez,Qal`eh-ye Deh Barez,Qal`eh-ye Deh-e Barez,Qal‘eh-ye Deh Bārez,Qal‘eh-ye Deh-e Bārez,Rudan,Rugan,Rūdān,Rūgan,bala shahr,bala shahri dih bariz,dhbarz,rwdan,rwgan,بالا شَهر,بالا شَهرِ دِه بارِز,دهبارز,رودان,روگَن,قَلعِۀ دِهِ بارِز', 'rudan', 'Asia/Tehran', 0, '27.44194', '57.19198'),
(98240, 30, 1385, 'قلعه خواجه بالا', 'Qal\'eh Khajeh,Qal`eh Khvajeh,Qal`eh-ye Khvajeh,Qal`eh-ye Khvajeh Bala,Qal‘eh Khvājeh,Qal‘eh-ye Khvājeh,Qal‘eh-ye Khvājeh Bālā,Qal’eh Khājeh,qlʿh khwajh,قلعه خواجه,قلعه خواجه بالا', 'qal-eh-ye-khvajeh', 'Asia/Tehran', 0, '32.20622', '49.44526'),
(98241, 30, 1392, 'قَلعِه دَرِّه', 'Arakvaz,Arakvaz-e Malekshahi,Arakvāz,Arakvāz-e Malekshāhī,Arkavazi,Arkavāzī,Arkvaz,Arkvāz,Arkwaz,Arkwāz,Qal`eh Darreh,Qal‘eh Darreh,arkwaz,arkwaz mlkshahy,ارکواز,ارکواز ملکشاهی,قَلعِه دَرِّه', 'arakvaz-e-malekshahi', 'Asia/Tehran', 0, '33.3828', '46.5983'),
(98242, 30, 1387, 'قَهُفرُخ', 'Farrokh Shahr,Qahferokh,Qahofrokh,Qatarokh,Qehfarukh,frkh shhr,qahfirukh,qahufrukh,qatarukh,فرّخ شهر,قَتَرُخ,قَهفِرُخ,قَهُفرُخ', 'farrokh-shahr', 'Asia/Tehran', 32391, '32.27174', '50.98008'),
(98243, 30, 1391, 'قاین', 'Qa\'en,Qain,Qayen,Qaīn,Qāyen,Qā’en,Shahr-e Qayen,Shahr-e Qāyen,qayn,قائن,قاین', 'qa-en', 'Asia/Tehran', 40157, '33.72654', '59.18439'),
(98244, 30, 1370, 'سر پل ذهاب', 'Pol-e Zahab,Pol-e Zohab,Pol-e Z̄ahāb,Pol-e Z̄ohāb,Sar-e Pol-e Zahab,Sar-e Pol-e Z̄ahāb,Sar-i-Pul Zuhab,Sar-ī-Pūl Zūhāb,Sari-Pul,Sarpol,Sarpol-e Zahab,Sarpol-e Z̄ahāb,Sarī-Pūl,sr pl dhhab,سر پل ذهاب', 'sarpol-e-zahab', 'Asia/Tehran', 51611, '34.46109', '45.86264'),
(98245, 30, 1382, 'پل سفيد', 'Pol Sefid,Pol-e Sefid,Pol-e Sefīd,pl sfyd,پل سفيد', 'pol-e-sefid', 'Asia/Tehran', 0, '36.11787', '53.05531'),
(98246, 30, 1371, 'پلدختر', 'Pol Dokhtar,Pol-e Dokhtar,Poldokhtar,Pul-i-Dukhtar,pl dkhtr,pldkhtr,پل دختر,پلدختر', 'poldokhtar', 'Asia/Tehran', 0, '33.15249', '47.71014'),
(98247, 30, 1383, 'پلدشت', 'Araplar,Pol Dasht,Pol\'desht,Pol-e Dasht,Poldasht,Pol’desht,Pul Dasht,aaraplar,pldsht,اَرَپلَر,پلدشت', 'poldasht', 'Asia/Tehran', 0, '39.348', '45.071'),
(98248, 30, 1374, 'پيچوا', 'Pichva,Pishva,Pishyan,Pīchvā,Pīshvā,Pīshyān,pychwa,pyshwa,pyshyan,پيشوا,پيشيان,پيچوا', 'pishva', 'Asia/Tehran', 53856, '35.308', '51.7267'),
(98249, 30, 1383, 'پیرانشهر', 'KHA,Khaneh,Khāneh,Okrug Peronsahr,Okrug Peronšahr,Piran Shahr,Piransaher,Piransahr,Piransar,Piransara,Piranschahr,Piransehr,Piranshahr,Piranshekhr,Piransherkh,Piransjahr,Piranszahr,Piranxahr,Piranşehr,Piranşəhr,Piranšaher,Piranšahr,Piranšāra,Pîranşar,Pīrān Shahr,Pīrānshahr,byranshhr,pi lan sha he er,piranshafuru,pyranshar,pyranshhr,Пероншаҳр,Пираншехр,Піраншерх,بیرانشهر,پیرانشار,پیرانشهر,پیرانشھر,پیرانشہر,ピーラーンシャフル,皮兰沙赫尔', 'piranshahr', 'Asia/Tehran', 61973, '36.701', '45.1413'),
(98250, 30, 1370, 'پاوه', 'Paveh,Pawah,Paweh,Pāveh,Pāweh,pawh,پاوه', 'paveh', 'Asia/Tehran', 17779, '35.0434', '46.3565'),
(98251, 30, 1368, 'پارس آباد', 'Farsabad,Fārsābād,PFQ,Parsabad,Pārsābād,fars abad,pars abad,Парсабад,فارس آباد,پارس آباد', 'parsabad', 'Asia/Tehran', 101661, '39.6482', '47.9174'),
(98252, 30, 1369, 'اسکو', 'Osku,Oskū,Uzku,Yuzki,askw,اسکو', 'osku', 'Asia/Tehran', 0, '37.91504', '46.12258'),
(98253, 30, 1383, 'اشنويه', 'Ashnooyeh,Oshnaviyeh,Oshnavīyeh,Oshnovie,Oshnovieh,Oshnoviyeh,Oshnovīeh,Oshnovīyeh,Oshnuje,Ushnu,Ushnuiyeh,Ushnū,Ushnūīyeh,ashnwyh,Ошновіє,Ошнуйе,اشنويه', 'oshnaviyeh', 'Asia/Tehran', 50661, '37.0397', '45.0983'),
(98254, 30, 1383, 'ارومیه', 'OMH,Orumiyeh,Orūmīyeh,Ourmia,Reza\'iyeh,Rezaeyeh,Rezaiyye,Rezâiyye,Rezā’īyeh,Rizaiyeh,Rizāiyeh,Urmia,Urmija,Urmiya,Urmiye,Urmía,Urumija,Urumiyeh,Urūmiyeh,arwmyh,arwmyt,shhrstan arwmyh,Úrmia,Ûrmiye,Урмия,Урумия,אורמיה,أرومية,ارومیه,ارومیّه,شهرستان ارومیه,ܐܘܪܡܝܐ', 'orumiyeh', 'Asia/Tehran', 577307, '37.55274', '45.07605'),
(98255, 30, 1385, 'امیدیه شرکت نفت', 'Omidiyeh,Omidiyeh Sherkat-e Naft,Omīdīyeh,Omīdīyeh Sherkat-e Naft,Sherkat-e Naft,amydyh,amydyh shrkt nft,امیدیه,امیدیه شرکت نفت', 'omidiyeh', 'Asia/Tehran', 46983, '30.76277', '49.70226'),
(98256, 30, 1378, 'نور آباد', 'Nurabad,Nūrābād,nwr abad,نور آباد', 'nurabad-fars', 'Asia/Tehran', 64041, '30.11405', '51.52174'),
(98257, 30, 1382, 'نوشهر', 'Bandar-e Now Shahr,NSH,Nau Shahr,Nowshahr,nwshhr,نوشهر', 'nowshahr', 'Asia/Tehran', 40000, '36.64852', '51.49621'),
(98259, 30, 1372, 'نیشابور', 'Nejsaburo,Nejŝaburo,Neyshabur,Neyshābūr,Nichapur,Nisabur,Nischapur,Nishabur,Nishapur,Nishopur,Nişabur,Nīshābūr,Nīshāpūr,nishapu,nysabwr,nyshabwr,nyshapwr,Нишапур,Нишопур,نيسابور,نیشابور,نیشاپور,ニシャプー', 'neyshabur', 'Asia/Tehran', 220929, '36.21329', '58.79575'),
(98260, 30, 1378, 'نیریز', 'Neyriz,Neyrīz,Niriz,Nīrīz,nyryz,نیریز', 'neyriz', 'Asia/Tehran', 45506, '29.1988', '54.3278'),
(98261, 30, 1372, 'نقاب', 'Neqab,Neqāb,nqab,نقاب', 'neqab', 'Asia/Tehran', 0, '36.70792', '57.42146'),
(98262, 30, 1382, 'نيكا', 'Naranj Bagh,Neka,Neka\',Nekā,Nekā’,Nika,Nāranj Bāgh,Nīkā,naranj bagh,nka,nyka,Нека,نارَنج باغ,نكا,نكاء,نيكا', 'neka', 'Asia/Tehran', 48847, '36.65079', '53.29905'),
(98263, 30, 1365, 'نَظَرابادِ بُزُرگ', 'Nazarabad,Nazarabad-e Bozorg,Naz̧arābād,Naz̧arābād-e Bozorg,nazarabadi buzurg,nzr abad,نظر آباد,نَظَرابادِ بُزُرگ', 'nazarabad', 'Asia/Tehran', 213388, '35.95411', '50.60607'),
(98264, 30, 1388, 'نطنز', 'Natanz,Naţanz,ntnz,نطنز', 'natanz', 'Asia/Tehran', 0, '33.51118', '51.91808'),
(98265, 30, 1382, 'نشتارود', 'Nashta Rud,Nashtarood,Nashtarud,Nashtā Rūd,Nashtārūd,Neshta Rud,Neshtā Rūd,nshtarwd,نشتارود', 'nashtarud', 'Asia/Tehran', 5837, '36.7509', '51.02362'),
(98266, 30, 1383, 'نقده', 'Nagadeh,Naghadeh,Naghdeh,Nakhuda,Naqadeh,Nākhuda,nqdh,نقده', 'naqadeh', 'Asia/Tehran', 73528, '36.9553', '45.388'),
(98267, 30, 1368, 'نمين', 'Namin,Namīn,nmyn,نمين', 'namin', 'Asia/Tehran', 0, '38.4269', '48.4839'),
(98268, 30, 1388, 'نائین', 'Na\'in,Naeyn,Nāeyn,Nā’īn,nayyn,نائین', 'na-in', 'Asia/Tehran', 0, '32.86006', '53.08749'),
(98269, 30, 1367, 'نهاوند', 'Nachavant,Nagavande,Nahavand,Nahāvand,Nehavend,Nehāvend,Nihavand,Nīhāvand,nhawnd,nihavuando,Ναχαβάντ,Нагаванде,نهاوند,ニハーヴァンド', 'nahavand', 'Asia/Tehran', 76250, '34.19088', '48.37446'),
(98270, 30, 1375, 'مراوه تپه', 'Maraveh,Maraveh Tappeh,Maravehtepe,Marveh Tappeh,Marāveh,Marāveh Tappeh,Moraveh Tappeh,Morāveh Tappeh,mrawh tph,مراوه تپه', 'maraveh-tappeh', 'Asia/Tehran', 0, '37.9041', '55.95596'),
(98271, 30, 1385, 'ملا ثانی', 'Molla Sany,Mollasani,Mollā Sāny,Mollās̄ānī,Mulla Sani,Mulla Sāni,Ramin,Rāmīn,mla thany,ramyn,رامین,ملا ثانی', 'mollasani', 'Asia/Tehran', 0, '31.5847', '48.88587'),
(98272, 30, 1378, 'مُهر', 'Mehr,Mohr,Mohur,Mohur-i- Saiyidan,Mohur-i- Saiyidān,Mur,Mūr,mhr,muhr,shhrstan muhr,شهرستان مُهر,مهر,مُهر', 'mohr', 'Asia/Tehran', 35000, '27.5552', '52.8836'),
(98273, 30, 1380, 'محمد آباد', 'Mohammadabad,Mohammadabad-e Rigan,Moḩammadābād,Moḩammadābād-e Rīgān,Muhammadabad,Muhammadābād,mhmd abad,محمد آباد', 'mohammadabad', 'Asia/Tehran', 0, '28.66877', '59.07341'),
(98274, 30, 1375, 'مينودشت', 'Minudasht,Mīnūdasht,mynwdsht,مينودشت', 'minudasht', 'Asia/Tehran', 0, '37.23015', '55.37211'),
(98275, 30, 1390, 'ميناب', 'Minab,Mīnāb,mynab,Минаб,ميناب', 'minab', 'Asia/Tehran', 70790, '27.13104', '57.08716'),
(98276, 30, 1369, 'میانه', 'Meyaneh,Meyāneh,Miane,Mianeh,Miyaneh,Mīyaneh,Mīāneh,myanh,میانه', 'mianeh', 'Asia/Tehran', 0, '37.421', '47.715'),
(98277, 30, 1383, 'میاندوآب', 'Meyandoab,Meyāndoāb,Miandoab,Miandow Ab,Miandowab,Mianduab,Miyandoab,Miyanduab,Miyāndūāb,Mīyāndoāb,Mīāndow Āb,Mīāndowāb,Mīāndoāb,Mīāndūāb,myandwab,Миандоаб,میاندوآب', 'miandoab', 'Asia/Tehran', 132819, '36.96667', '46.10961'),
(98278, 30, 1369, 'میاو', 'Meyab,Meyāb,Miab,Miyab,Mīyāb,Mīāb,miab,myab,myaw,ميّاب,مِياب,میاب,میاو', 'miab', 'Asia/Tehran', 611, '38.7011', '45.8019'),
(98279, 30, 1381, 'ميبد', 'Maibud,Meybod,mybd,ميبد', 'meybod', 'Asia/Tehran', 51874, '32.25014', '54.01658'),
(98280, 30, 1368, 'مشگين شهر', 'Kheyav,Kheyāv,Khiav,Khiov,Khiyav,Khiyov,Khīyāv,Khīāv,Meshgin Shahr,Meshgīn Shahr,Meshkin Shahr,Meshkīn Shahr,Mishgin,mshgyn shhr,مشگين شهر', 'meshgin-shahr', 'Asia/Tehran', 0, '38.399', '47.682'),
(98281, 30, 1381, 'مِهريز', 'Mahriz,Mahrīz,Mehriz,Mehrīz,mhryz,mihryz,مهريز,مِهريز', 'mahriz', 'Asia/Tehran', 36720, '31.58428', '54.4428'),
(98282, 30, 1392, 'مَنسور آباد', 'Mansurabad,Mansūrābād,Mehran,Mehrān,manswr abad,mhran,مهران,مَنسور آباد', 'mehran', 'Asia/Tehran', 11831, '33.1222', '46.1646'),
(98283, 30, 1376, 'ماسوله', 'Massulya,Masuleh,Māsūleh,maswlh,ماسوله', 'masuleh', 'Asia/Tehran', 554, '37.15497', '48.98982'),
(98284, 30, 1385, 'مسجد سلیمان', 'Masjed Soleiman,Masjed Soleyman,Masjed Soleymān,Masjed-e Soleyman,Masjed-e Soleymān,Masjid-i-Sulaiman,msjd slyman,مسجد سلیمان', 'masjed-soleyman', 'Asia/Tehran', 111510, '31.9364', '49.3039'),
(98285, 30, 1378, 'مصیری', 'Masiri,Masīrī,Maşīrī,msyry,مصیری', 'masiri', 'Asia/Tehran', 0, '30.24493', '51.52158'),
(98286, 30, 1380, 'بردسیر', 'Bardesir,Bardesīr,Bardsir,Bardsīr,Deh-e Now-e Mashiz,Deh-e Now-e Mashīz,Mashiz,Mashīz,Mshiz,Qal`eh-ye Mashiz,Qal‘eh-ye Mashīz,brdsyr,بردسیر', 'bardsir', 'Asia/Tehran', 37192, '29.92266', '56.57433'),
(98287, 30, 1372, 'مشهد', 'MHD,Masant,Masat,Maschhad,Mashad,Mashado,Mashhad,Mashkhad,Masyhad,Maxhad,Maŝhado,Maşat,Mašhad,Mașhad,Meixad,Meshed,Mesheda,Meshedas,Meshkhed,MeshkhӀed,Meszhed,Mexed,Meşhed,Mešheda,Mešhedas,Məshəd,Məşhəd,ma shen ha de,mach had,macukat,masahada,mashuhado,masyuhadeu,meshhedi,mshd,mshhd,Μασάντ,Машхад,Машҳад,Мешхед,МешхӀед,Мешһед,Мәшһәд,Մաշհադ,משהד,مشهد,مشہد,مەشھەد,मशहद,মাশহাদ,ਮਸ਼ਹਦ,மசுகாத்,മശ്‌ഹദ്,มัชฮัด,მეშჰედი,マシュハド,馬什哈德,마슈하드', 'mashhad-iran', 'Asia/Tehran', 2307177, '36.29807', '59.60567'),
(98288, 30, 1378, 'مرودشت', 'Marvdasht,Mervdesht,mrwdsht,Мервдешт,مرودشت', 'marvdasht', 'Asia/Tehran', 148858, '29.8742', '52.8025'),
(98289, 30, 1389, 'مریوان', 'Dezh Shahpur,Dezh Shapoor,Dezh Shāhpūr,Marivan,Marīvān,Qal`eh-ye Marivan,Qal‘eh-ye Marīvān,dizh shahpwr,mrywan,دِژ شاهپور,قَلعِۀ مَريوان,مریوان', 'marivan', 'Asia/Tehran', 91664, '35.51829', '46.18298'),
(98290, 30, 1369, 'مرند', 'Marand,Morand,mrnd,Маранд,مرند', 'marand', 'Asia/Tehran', 124191, '38.4329', '45.7749'),
(98291, 30, 1369, 'مراغه', 'ACP,Maragheh,Maraghen,Marāgheh,Marāghen,mraghh,مراغه', 'maragheh', 'Asia/Tehran', 0, '37.39206', '46.23909'),
(98292, 30, 1380, 'منوجان', 'Jarian,Jārīān,Manujan,Manūjān,Posht Qalat,Posht Qalāt,Qal`eh-ye Manujan,Qal‘eh-ye Manūjān,jaryan,mnwjan,جاریان,منوجان', 'manujan', 'Asia/Tehran', 0, '27.40698', '57.50128'),
(98293, 30, 1376, 'منجیل', 'Manjil,Manjīl,Menjil,Menjīl,mnjyl,منجیل', 'manjil', 'Asia/Tehran', 15630, '36.74445', '49.40082'),
(98294, 30, 1369, 'مَلِك كَندی', 'Malek Kandi,Malek Kandī,Malekan,Malekān,Malik Kandi,Malikkand,malik kandy,mlkan,ملکان,مَلِك كَندی', 'malekan', 'Asia/Tehran', 0, '37.14258', '46.10345'),
(98295, 30, 1367, 'ملایر', 'Daulatabad,Daūlatābād,Dowlatabad,Dowlatābād,Malayer,Malāyer,mlayr,ملایر', 'malayer', 'Asia/Tehran', 176573, '34.30158', '48.82166'),
(98296, 30, 1374, 'مَلار', 'Malar,Malard,Malār,Malārd,Melard,Melārd,malar,mlard,ملارد,مَلار', 'malard', 'Asia/Tehran', 56745, '35.6659', '50.9767'),
(98297, 30, 1383, 'ماکو', 'IMQ,Maku,Mākū,ma ku,makw,makۆ,Маку,Մակու,ماكو,ماکو,ماکۆ,馬庫', 'maku', 'Asia/Tehran', 0, '39.28992', '44.46035'),
(98298, 30, 1377, 'ماهنشان', 'Mah Neshan,Mahneshan,Māh Neshān,Māhneshān,mah nshan,mahnshan,ماه نشان,ماهنشان', 'mahneshan', 'Asia/Tehran', 0, '36.7444', '47.6725'),
(98299, 30, 1382, 'محمود آباد', 'Mahmudabad,Maḩmūdābād,mhmwd abad,محمود آباد', 'mahmudabad-iran', 'Asia/Tehran', 0, '36.63191', '52.26286'),
(98300, 30, 1384, 'محلات', 'Mahallat,Mahallat Bala,Mahallat-e Bala,Mahallāt Bāla,Maḩallāt,Maḩallāt-e Bālā,mhlat,محلات', 'mahallat', 'Asia/Tehran', 0, '33.91108', '50.45317'),
(98301, 30, 1383, 'مِه آباد', 'Mahabad,Mahābād,Makhabad,Mehabad,Mehābād,Saujbulagh,Sāūjbulāgh,mah abad,mhabad,mih abad,Махабад,مهاباد,مَه آباد,مِه آباد', 'mahabad', 'Asia/Tehran', 162434, '36.7631', '45.7222'),
(98302, 30, 1387, 'لُرد جَن', 'Lord Jan,Lordagan,Lordagān,Lordajan,Lordajān,Lordakan,Lordakān,Lordegan,Lordegān,Lordgan,Lordgān,Lurdagan,Lurdagān,lrdgan,lurd jan,لردگان,لُرد جَن', 'lordegan', 'Asia/Tehran', 0, '31.51338', '50.82672'),
(98303, 30, 1379, 'لیکک بهمنی', 'Lak Lak,Lakak,Likak,Likak-e Bahmani,Lirkak,Līkak,Līkak-e Bahmanī,Līrkak,Qal`eh-i-Likak,Qal`eh-ye Likak,Qal‘eh-i-Likak,Qal‘eh-ye Līkak,Seh Laklak,lykk,lykk bhmny,ليکک,لیکک بهمنی', 'likak', 'Asia/Tehran', 0, '30.8949', '50.0931'),
(98304, 30, 1378, 'لار', 'LRR,Lar,Larestan,Lār,Shahr-e Qadim-e Lar,Shahr-e Qadīm-e Lār,lar,shhr qdym lar,شهر قدیم لار,لار', 'shahr-e-qadim-e-lar', 'Asia/Tehran', 0, '27.68336', '54.34172'),
(98305, 30, 1376, 'لنگرود', 'Langarood,Langarud,Langarūd,Langerud,Langerūd,Shahr-e Langarud,Shahr-e Langarūd,lngrwd,لنگرود', 'langarud', 'Asia/Tehran', 68148, '37.19548', '50.15263'),
(98306, 30, 1378, 'لامرد', 'LFM,Lamard,Lamerd,Lāmard,Lāmerd,lamrd,لامرد', 'lamerd', 'Asia/Tehran', 0, '27.334', '53.179'),
(98307, 30, 1385, 'لالی', 'Dasht-e Lali,Dasht-e Lati,Dasht-e Lālī,Lali,Lali Pelayen,Lālī,Lālī Pelāyen,dsht laly,laly,دشت لالی,لالی', 'lali', 'Asia/Tehran', 0, '32.32981', '49.09324'),
(98308, 30, 1376, 'لاهیجان', 'Lahijan,Lāhījān,lahyjan,لاهیجان', 'lahijan', 'Asia/Tehran', 0, '37.20416', '50.00919'),
(98309, 30, 1371, 'کوهدشت', 'Kuh-i-Dasht,Kuhdasht,Kūh-ī-Dasht,Kūhdasht,kwhdsht,کوهدشت', 'kuhdasht', 'Asia/Tehran', 100208, '33.53335', '47.60999'),
(98310, 30, 1380, 'کوهبنان', 'Koobanan,Kuh Banan,Kuh Baneh,Kuhbanan,Kuhbonan,Kūh Baneh,Kūh Banān,Kūhbanān,Kūhbonān,kwhbnan,کوهبنان', 'kuhbanan', 'Asia/Tehran', 0, '31.41029', '56.28255'),
(98311, 30, 1375, 'کرد کوی', 'Kord Ku,Kord Kuy,Kord Kū,Kord Kūy,Kurd Kui,Kurd Kūi,krd kwy,krdkwy,kurd kw,كردكوی,كُرد كو,کرد کوی', 'kord-kuy', 'Asia/Tehran', 0, '36.79307', '54.11214'),
(98312, 30, 1384, 'كميجان', 'Khumajan,Khūmajān,Komazan,Komejan,Komejān,Komeyjan,Komeyjān,Komijan,Komizan,Komāzān,Komījān,Komīzān,Kumizan,Kūmīzān,kmyjan,كميجان', 'komijan', 'Asia/Tehran', 0, '34.72142', '49.32653'),
(98313, 30, 1390, 'كيش', 'Kish,Kīsh,kysh,Киш,كيش', 'kish', 'Asia/Tehran', 20922, '26.55778', '54.01944'),
(98314, 30, 1383, 'خوی', 'KHY,Khoi,Khowy,Khoy,Khvoy,khwy,خوی', 'khowy', 'Asia/Tehran', 175370, '38.5503', '44.9521'),
(98315, 30, 1395, 'خورموج', 'Khormoj,Khormuj,Khormūj,Khowr Muj,Khowr Mūj,Khowrmuj,Khowrmūj,Khurmoj,Khurmudj,Khurmuj,Khūrmūj,khwrmwj,خورموج', 'khowrmuj', 'Asia/Tehran', 0, '28.6543', '51.38'),
(98316, 30, 1388, 'خور', 'Khowr,Khur,Khvor,Khūr,khwr,خور', 'khur', 'Asia/Tehran', 0, '33.77512', '55.08329'),
(98317, 30, 1388, 'خوانسار', 'Khansar,Khavansar,Khonsar,Khunsar,Khvansar,Khvonsar,Khvonsār,Khvānsār,Khūnsār,Shahr-e Khvonsar,Shahr-e Khvonsār,khwansar,خوانسار', 'khvansar', 'Asia/Tehran', 21146, '33.22052', '50.31497'),
(98318, 30, 1385, 'خرمشهر', 'Al-Muhammarah,Choremsehras,Choremšehras,Chorramsahr,Chorramschahr,Chorramszahr,Chorramšahr,Horamsaher,Horamšaher,Huerremsehr,Hürremşehr,Jorramchar,Khoramshahr,Khorram Shahr Abadan,Khorram Shahr Ābādān,Khorramchahre,Khorramshahr,Khorramxahr,Khorremshekhr,Khunin Shahr,Khurramshahr,Khūnīn Shahr,Koramshar,Koramsjar,Mohammerah,Muhammerah,Xürrəmşəhr,almhmrt,bndr khrmshhr,horramushafuru,huo la mu sha he er,khrmshhr,khurramasahara,Корамшар,Хорремшехр,Хуррамшаҳр,المحمرة,بندر خرمشهر,خرمشهر,خرمشھر,खुर्रमशहर,ホッラムシャフル,霍拉姆沙赫尔', 'khorramshahr', 'Asia/Tehran', 330606, '30.44079', '48.18428'),
(98319, 30, 1371, 'خرم آباد', 'KHD,Khorramabad,Khorramābād,Khur Ramabad,Khur Ramābād,Khurramobod,khrm abad,Хуррамобод,خرم آباد', 'khorramabad', 'Asia/Tehran', 329825, '33.48778', '48.35583'),
(98320, 30, 1378, 'خنج', 'Khonj,Khunj,Khunji,khnj,خنج', 'khonj', 'Asia/Tehran', 0, '27.8913', '53.4344'),
(98321, 30, 1384, 'خنداب', 'Khandab,Khondab,Khondāb,Khāndāb,khandab,khndab,خانداب,خنداب', 'khondab', 'Asia/Tehran', 0, '34.3928', '49.1841'),
(98322, 30, 1384, 'خمين', 'Khomein,Khomeyn,Khomeīn,Khowmeyn,Khumain,Khūmaīn,khmyn,خمين', 'khomeyn', 'Asia/Tehran', 77425, '33.63889', '50.08003'),
(98323, 30, 1369, 'خمارلو', 'Khomarlu,Khomārlū,khmarlw,خمارلو', 'khomarlu', 'Asia/Tehran', 0, '39.1489', '47.0347'),
(98324, 30, 1378, 'خرامه', 'Karameh,Kharameh,Kharāmeh,Kherameh,Kherāmeh,khramh,خرامه', 'kherameh', 'Asia/Tehran', 0, '29.49896', '53.31199'),
(98325, 30, 1390, 'خَمير', 'Bandar-e Khamir,Bandar-e Khamīr,Khamir,Khamīr,Xamir,bandari khamyr,bndr khmyr,bndrkhmyr,khamyr,بندر خمير,بندرخمير,بَندَرِ خَمير,خَمير', 'bandar-e-khamir', 'Asia/Tehran', 0, '26.9521', '55.5851'),
(98326, 30, 1368, 'هرو آباد', 'Harau,Harowabad,Herau,Herauabad,Heroabad,Herow,Herowabad,Herowābād,Heroābād,Hirabad,Hirābād,Khalkhal,Khalkhāl,hrw abad,khlkhal,خلخال,هرو آباد', 'khalkhal', 'Asia/Tehran', 51024, '37.61837', '48.52928'),
(98327, 30, 1372, 'خلیل آباد', 'Khalilabad,Khalīlābād,khlyl abad,خلیل آباد', 'khalilabad-iran', 'Asia/Tehran', 0, '35.25395', '58.28566'),
(98328, 30, 1370, 'کرمانشاه', 'Bahtaran,Bakhtaran,Bākhtarān,KSH,Kermansah,Kermansaho,Kermanschah,Kermanshah,Kermanshahan,Kermanshakh,Kermanŝaho,Kermânsâh,Kermānschāh,Kermānshāh,Kermānshāhān,Kirmansah,Kirmanşah,Kirmasan,Kirmaşan,Province de Kermanshah,Provincia de Kermanshah,Provinco Kermansah,Provinco Kermanŝah,Província de Kermanshah,Qahremanshahr,Qahremānshahr,astan krmanshah,ke er man sha he,kerumansha,krmanshah,Керманшах,Кирмоншоҳ,Устони Кирмоншоҳ,استان کرمانشاه,كرمانشاه,کرمانشاه,ケルマーンシャー,克尔曼沙赫', 'kermanshah', 'Asia/Tehran', 621100, '34.31417', '47.065'),
(98329, 30, 1380, 'کرمان', 'Carmana,Dakbayan sa Kerman,Dakbayan sa Kermān,KER,Kerman,Kermanas,Kermano,Kermon,Kermán,Kermān,Kirman,Kirmon,karmana,ke er man,keleuman,kermani,keruman,krman,Керман,Кирмон,Կերման,כרמאן,كرمان,کرمان,कर्मान,ქერმანი,ケルマーン,克尔曼,케르만', 'kerman-iran', 'Asia/Tehran', 577514, '30.28321', '57.07879'),
(98330, 30, 1370, 'کرند غرب', 'Karand,Karind,Karīnd,Kerend,Kerend-e Gharb,krnd ghrb,کرند غرب', 'kerend-e-gharb', 'Asia/Tehran', 0, '34.2842', '46.2423'),
(98331, 30, 1378, 'كازرون', 'Kasrun,Kazarun,Kazeroun,Kazerun,Kazeruna,Kāzarūn,Kāzerūn,kazrwn,Казеруна,كازرون', 'kazerun', 'Asia/Tehran', 94511, '29.61919', '51.6535'),
(98332, 30, 1372, 'کاشمر', 'Kashmar,Khashmar,Kāshmar,Soultanabad,Torshiz,Torshīz,Turshiz,Turshīz,kashmr,کاشمر', 'kashmar', 'Asia/Tehran', 96151, '35.23831', '58.46558'),
(98333, 30, 1365, 'کرج', 'Heredi,Karadj,Karadje,Karadsch,Karadz,Karadzs,Karadż,Karadž,Karago,Karaj,Karatz,Karaĝo,Karej,Kerec,Keredi,Keredzas,Keredzh,Keredžas,Kerezh,Kərəc,Leredi,PYK,QKC,Qasabeh-e Karaj,Qaşabeh-e Karaj,ka la ji,kairaija,kalaji,karaj,karaji,kha rac,krj,kyaraji,qasabihi karaj,Καράτζ,Карай,Караџ,Караҷ,Кередж,Кереж,כאראג,قَصَبِهِ كَرَج,كرج,کرج,کەرەج,कैरैज,கராஜ்,คาราจ,ქარაჯი,キャラジ,卡拉季,카라지', 'karaj', 'Asia/Tehran', 1448075, '35.83266', '50.99155'),
(98334, 30, 1370, 'کنگاور', 'Kangavar,Kangāvar,kngawr,کنگاور', 'kangavar', 'Asia/Tehran', 53414, '34.5043', '47.9653'),
(98335, 30, 1395, 'كنگان', 'Bandar-e Kangan,Bandar-e Kangān,KNR,Kangan,Kangun,Kangān,bndri kngan,kngan,بندرِ كنگان,كنگان', 'kangan', 'Asia/Tehran', 0, '27.834', '52.0628'),
(98336, 30, 1389, 'کامیاران', 'Kamyaran,Kāmyārān,kamyaran,کامیاران', 'kamyaran', 'Asia/Tehran', 61642, '34.79535', '46.93682'),
(98337, 30, 1369, 'کليبر', 'Kaleybar,Kalibar,Kalipar,Kalībar,Keleibar,Keleivar,klybr,کليبر', 'kaleybar', 'Asia/Tehran', 0, '38.86509', '47.03909'),
(98338, 30, 1375, 'كلاله', 'KLM,Kalalah,Kalaleh,Kalālah,Kalāleh,klalh,كلاله', 'kalaleh', 'Asia/Tehran', 33700, '37.37899', '55.493'),
(98339, 30, 1369, 'کوجووار', 'kwjwwar,کوجووار', 'kujuvar', 'Asia/Tehran', 6001, '38.05993', '46.13809'),
(98340, 30, 1367, 'کبودر آهنگ', 'Kaboodrahang,Kabud Rahang,Kabudarahang,Kabutarahang,Kabūd Rāhang,Kabūdarāhang,Kabūtarāhang,kbwdr ahng,کبودر آهنگ', 'kabudarahang', 'Asia/Tehran', 0, '35.20924', '48.72341'),
(98341, 30, 1392, 'جوی زَر', 'Aiwan,Aīwān,Bagh-e Shah,Bagh-i-Shah,Bāgh-e Shāh,Bāgh-ī-Shāh,Eyvan,Eyvan-e Gharb,Eyvān,Eyvān-e Gharb,Juy Zar,Jūy Zar,aywan,aywan ghrb,baghi shah,jwy zar,ايوان,ایوان غرب,باغِ شاه,جوی زَر', 'eyvan', 'Asia/Tehran', 0, '33.8272', '46.3097'),
(98342, 30, 1382, 'جويبار', 'Baghlu,Bāghlū,Juybar,Jūybār,jwybar,جويبار', 'juybar', 'Asia/Tehran', 28404, '36.64088', '52.91206'),
(98343, 30, 1372, 'جغتای', 'Jaghatai,Jaghatāi,Joghatay,Joghatāy,Joghtay,Joghtāy,jghtay,جغتای', 'joghtay', 'Asia/Tehran', 0, '36.63619', '57.07284'),
(98344, 30, 1395, 'خارك', 'Jazireh Khark,Jazireh-ye Khark,Jazīreh-ye Khārk,Khark,Khārk,khark,Харк,جَزيرِۀ خارك,خارك', 'khark', 'Asia/Tehran', 8196, '29.26139', '50.33056'),
(98345, 30, 1390, 'جاسک', 'JSK,Jask,Jāsk,bndri jask,jask,بندرِ جاسک,جاسک', 'jask', 'Asia/Tehran', 0, '25.64533', '57.77552'),
(98347, 30, 1395, 'ولایت', 'Jam,Jam-e Jam,Jamm,Jām-e Jam,Velayat,Velāyat,jami jam,jm,wlayt,جامِ جَم,جم,ولایت', 'jam', 'Asia/Tehran', 0, '27.82817', '52.32536'),
(98348, 30, 1386, 'جاجرم', 'Jajarm,Jājarm,jajrm,جاجرم', 'jajarm', 'Asia/Tehran', 0, '36.95012', '56.38005'),
(98349, 30, 1378, 'دو', 'Do,JAR,Jahrom,Jahrum,Jahrūm,dw,jhrm,جهرم,دو', 'jahrom', 'Asia/Tehran', 0, '28.5', '53.5605'),
(98350, 30, 1392, 'يلام', 'Elam,Elām,IIL,Ilam,ailam,aylam,ylam,Īlām,Илам,اِلام,ایلام,يلام', 'ilam-iran', 'Asia/Tehran', 140940, '33.6374', '46.4227'),
(98351, 30, 1385, 'هویزه', 'Havizeh,Hawiza,Hawizeh,Hawīzeh,Hovayze,Hovayzeh,Hoveyzeh,Huzgan,Hūzgān,hwyzh,هویزه', 'hoveyzeh', 'Asia/Tehran', 0, '31.4619', '48.074'),
(98352, 30, 1369, 'هريس', 'Haris,Harīs,Heris,Herīs,Hiriz,hrys,هريس', 'heris', 'Asia/Tehran', 0, '38.24816', '47.11678'),
(98353, 30, 1385, 'هندیجان', 'Hendeyan,Hendeyān,Hendian,Hendijan,Hendijan Kuchek,Hendijar,Hendījān,Hendījān Kūchek,Hendījār,Hendīān,Hindian,Hindijan,Hindīān,hndyjan,هندیجان', 'hendijan', 'Asia/Tehran', 0, '30.2363', '49.7119'),
(98354, 30, 1365, 'هَشتجِرد', 'Ashjird,Hashtgerd,Hashtjerd,Hashtjird,hashtjird,hshtgrd,هشتگرد,هَشتجِرد', 'hashtgerd', 'Asia/Tehran', 0, '35.962', '50.6799'),
(98355, 30, 1370, 'هرسین', 'Harsin,Harsīn,hrsyn,هرسین', 'harsin-iran', 'Asia/Tehran', 57647, '34.2721', '47.5861'),
(98356, 30, 1367, 'همدان', 'Ecbatana,HDM,Hamadan,Hamadān,Hamedan,Hamedān,Khamadan,hmdan,Хамадан,همدان', 'hamadan', 'Asia/Tehran', 528256, '34.79922', '48.51456'),
(98359, 30, 1385, 'هفتگل', 'Haftgel,Haftkel,hftgl,hftkl,هفتکل,هفتگل', 'haftkel', 'Asia/Tehran', 0, '31.44686', '49.52951'),
(98360, 30, 1375, 'گورگان', 'Asterabad,Asterābād,GBT,Gorgan,Gorgān,Gurgan,Gurgon,Gūrgān,Hirkanio,aastir abad,grgan,gwrgan,Горган,Гургон,اَستِر آباد,گرگان,گورگان', 'gorgan', 'Asia/Tehran', 244937, '36.8427', '54.44391'),
(98361, 30, 1375, 'گنبد کاووس', 'Dashte Gorgan,Gonbad Qabus,Gonbad Qavoos,Gonbad Qābūs,Gonbad-e Kavus,Gonbad-e Kāvūs,Gonbad-e Qabus,Gonbad-e Qābūs,Gunbad-i-Kawas,Gunbad-i-Kawus,Gunbad-i-Kāwās,Gunbad-i-Kāwūs,Gunbad-i-Qabus,Gunbad-i-Qābūs,gnbd kawws,gnbd qabws,گنبد قابوس,گنبد کاووس', 'gonbad-e-kavus', 'Asia/Tehran', 131416, '37.25004', '55.16721'),
(98362, 30, 1372, 'گناباد', 'Gonabad,Gonābād,Gunabad,Gūnābād,Juymand,Jūymand,gnabad,گناباد', 'gonabad', 'Asia/Tehran', 43465, '34.35287', '58.68365'),
(98363, 30, 1388, 'گلپایگان', 'Golpayagan,Golpayegan,Golpāyagān,Golpāyegān,Gulpaigan,Gulpāīgān,Shahr-e Golpayegan,Shahr-e Golpāyegān,glpaygan,گلپایگان', 'golpayegan', 'Asia/Tehran', 44916, '33.4537', '50.28836'),
(98364, 30, 1370, 'گیلان غرب', 'Gilan,Gilan-e Gharb,Gīlān,Gīlān-e Gharb,gylan ghrb,گیلان غرب', 'gilan-e-gharb', 'Asia/Tehran', 0, '34.1421', '45.9203'),
(98365, 30, 1378, 'گراش', 'Gerash,Gerāsh,Girash,Girāsh,grash,گراش', 'gerash', 'Asia/Tehran', 25316, '27.66966', '54.13586'),
(98366, 30, 1390, 'گاوبندی', 'Gabandi,Gavbandi,Gāvbandī,gawbndy,گاوبندی', 'gavbandi', 'Asia/Tehran', 0, '27.2083', '53.0361'),
(98367, 30, 1373, 'گرمسار', 'Garmsar,Garmsār,Qeshlaq,Qeshlāq,Qishlaq,Shahr-e Qeshlaq,Shahr-e Qeshlāq,grmsar,qishlaq,shahri qishlaq,شَهرِ قِشلاق,قِشلاق,گرمسار', 'garmsar', 'Asia/Tehran', 0, '35.21824', '52.34085'),
(98368, 30, 1368, 'گرمی', 'Garmi,Garmi Ejarood,Garmī,Germi,Germī,grmy,گرمی', 'germi', 'Asia/Tehran', 0, '39.0215', '48.0801'),
(98369, 30, 1386, 'گرمه', 'Garmeh,grmh,گرمه', 'garmeh', 'Asia/Tehran', 0, '36.987', '56.28942'),
(98370, 30, 1395, 'بندر گناوه', 'Bandar Ganaveh,Bandar Ganāveh,Bandar-e Ganaveh,Bandar-e Ganāveh,Bandar-e Genaveh,Bandar-e Genāveh,Bandar-e-Gonaveh,Bandar-e-Gonāveh,Ganaveh,Ganāveh,Genaveh,Genāveh,Gonaveh,Gonāveh,Kenareh,Kenâreh,bndr gnawh,بندر گناوه', 'bandar-e-genaveh', 'Asia/Tehran', 52750, '29.5791', '50.517'),
(98371, 30, 1382, 'گلوگاه', 'Galugah,Galūgāh,glwgah,گلوگاه', 'galugah', 'Asia/Tehran', 0, '36.72734', '53.80888'),
(98372, 30, 1375, 'گاليكش', 'Galikash,Galikesh,Galīkesh,Gālīkash,Gālīkesh,galyksh,گاليكش', 'galikesh', 'Asia/Tehran', 0, '37.27259', '55.43394'),
(98373, 30, 1376, 'فومن', 'Fowman,Fowmen,Fuman,Fumen,Fūman,fwmn,فومن', 'fuman', 'Asia/Tehran', 27763, '37.224', '49.3125'),
(98374, 30, 1374, 'فيروزكوه', 'Firuzkuh,Fīrūzkūh,Qasabeh-ye Firuz Kuh,Qaşabeh-ye Fīrūz Kūh,fyrwzkwh,فيروزكوه', 'firuzkuh', 'Asia/Tehran', 0, '35.75674', '52.77062'),
(98375, 30, 1378, 'فیروز آباد', 'Firuzabad,Fīrūzābād,fyrwz abad,فیروز آباد', 'firuzabad', 'Asia/Tehran', 66558, '28.8438', '52.5707'),
(98376, 30, 1372, 'فیض آباد', 'Faizabad,Faizābād,Feyzabad,Feyzābād,Feyẕābād,fyd abad,فیض آباد', 'feyzabad', 'Asia/Tehran', 0, '35.01891', '58.78343'),
(98377, 30, 1388, 'فریدون شهر', 'Fareydunshahr,Fareydūnshahr,Fereydunshahr,Fereydūnshahr,frydwn shhr,فریدون شهر', 'fereydunshahr', 'Asia/Tehran', 11562, '32.94195', '50.11991'),
(98378, 30, 1382, 'فريدونكنار', 'Faridun Kinar,Fereidun Kenar,Fereydun Kenar,Fereydunkenar,Fereydūn Kenār,Fereydūnkenār,Fāridūn Kinār,Qasabeh,Qaşabeh,frydwn knar,frydwnknar,فريدون كنار,فريدونكنار', 'fereydun-kenar', 'Asia/Tehran', 34097, '36.68489', '52.51917'),
(98379, 30, 1391, 'فردوس', 'Ferdous,Ferdows,Firdaus,Firdavs,Firdevs,Firdovs,Tun,Tūn,fei er dao si,ferudousu,frdws,Фердоус,Фирдавс,فردوس,フェルドゥース,費爾道斯', 'ferdows', 'Asia/Tehran', 0, '34.0185', '58.17222'),
(98380, 30, 1378, 'فسا', 'FAZ,Fasa,Fassa,Fasā,fsa,فسا', 'fasa', 'Asia/Tehran', 98061, '28.9383', '53.6482'),
(98381, 30, 1380, 'فاریاب', 'Fariab,Fariyab,Faryab,Fāryāb,Fārīāb,Pariab,Paryab,Paryāb,Pay Ab,Pārīāb,Pāy Āb,Shahmoradi-ye Faryab,Shahmorādi-ye Fāryāb,faryab,فاریاب', 'faryab', 'Asia/Tehran', 0, '28.0987', '57.23181'),
(98382, 30, 1386, 'فاروج', 'Farij,Faruj,Fārij,Fārūj,farwj,فاروج', 'faruj', 'Asia/Tehran', 0, '37.23121', '58.219'),
(98383, 30, 1387, 'فارسان', 'Farsa,Farsan,Farsian,Farsun,Farsūn,Fārsā,Fārsān,Fārsīān,farsan,فارسان', 'farsan', 'Asia/Tehran', 25071, '32.25694', '50.56095'),
(98384, 30, 1378, 'فراشبند', 'Farash,Farashband,Farrash,Farrashband,Farrāsh,Farrāshband,Farāsh,Farāshband,frashbnd,فراشبند', 'farashband', 'Asia/Tehran', 0, '28.8713', '52.0916'),
(98385, 30, 1384, 'فرمهين', 'Farmahin,Farmahīn,frmhyn,فرمهين', 'farmahin', 'Asia/Tehran', 0, '34.50383', '49.68437'),
(98386, 30, 1372, 'فریمان', 'Fariman,Farimun,Farīmān,Farīmūn,fryman,فریمان', 'fariman', 'Asia/Tehran', 0, '35.70685', '59.85006'),
(98387, 30, 1394, 'فنوج', 'Fannuj,Fannūj,Fanuch,Fanuj,Fanūj,Fānūch,fnwj,فنوج', 'fannuj', 'Asia/Tehran', 13000, '26.57583', '59.63972'),
(98388, 30, 1367, 'گاماسپ', 'Famast,Fāmāst,Gamasb,Gamasp,Gāmāsb,Gāmāsp,Pamas,famast,gamasb,gamasp,pamas,فاماست,پَمَس,گاماسب,گاماسپ', 'pamas', 'Asia/Tehran', 1081, '34.03791', '48.462'),
(98389, 30, 1367, 'فامنین', 'Famanin,Famenin,Faminin,Famīnīn,Fāmanīn,Fāmenīn,famnyn,فامنین', 'famenin', 'Asia/Tehran', 0, '35.11593', '48.97336'),
(98390, 30, 1380, 'فهرج', 'Fahraj,Fahrej,Iranshahr,Irānshahr,Narmashir,Narmāshīr,fhrj,فهرج', 'fahraj', 'Asia/Tehran', 0, '28.9502', '58.885'),
(98391, 30, 1378, 'استهبان', 'Estahban,Estahbanat,Estahbān,Estehbanat,Eşţahbān,Eşţahbānāt,Istehbanat,Istehbānāt,Savanat,Savānāt,Shahr-e Estahbanat,Shahr-e Eşţahbānāt,asthban,استهبان', 'estahban', 'Asia/Tehran', 0, '29.1266', '54.0421');
INSERT INTO `cities` (`id`, `country_id`, `province_id`, `name`, `alternates`, `slug`, `timezone`, `population`, `latitude`, `longitude`) VALUES
(98392, 30, 1370, 'اسلام آباد غرب', 'Eslamabad,Eslamabad-e Gharb,Eslāmābād,Eslāmābād-e Gharb,Harunabad,Hārūnābād,Shahabad,Shahabad-e Gharb,Shāhābād,Shāhābād-e Gharb,aslam abad ghrb,اسلام آباد غرب', 'eslamabad-e-gharb', 'Asia/Tehran', 0, '34.1089', '46.52988'),
(98393, 30, 1365, 'اشتهارد', 'Eshtehard,Eshtehārd,Ishtahabad,Ishtahard,ashthard,Īshtahard,Īshtahābād,اشتهارد', 'eshtehard', 'Asia/Tehran', 0, '35.7255', '50.3662'),
(98394, 30, 1386, 'اسفراین', 'Esfarayen,Esfarāyen,Meyanabad,Meyanābād,Mianabad,Miyanabad,Mīyānābād,Mīānābād,asfrayn,اسفراین', 'esfarayen', 'Asia/Tehran', 59678, '37.07645', '57.51009'),
(98395, 30, 1378, 'اقلید', 'Eklid,Eklīd,Eqlid,Eqlīd,Iqlid,Iqlīd,Shahrestan-e Eqlid,Shahrestān-e Eqlīd,aqlyd,اقلید', 'eqlid', 'Asia/Tehran', 0, '30.89885', '52.69701'),
(98396, 30, 1373, 'شاهرود', 'Emamshahr,Emāmshahr,RUD,Shahrud,Sharud,Shāhrūd,Shārūd,aimamshahr,shahrwd,sharwd,اِمامشَهر,شارود,شاهرود', 'shahrud', 'Asia/Tehran', 131889, '36.41819', '54.97628'),
(98397, 30, 1372, 'دولت آباد', 'Daulatabad,Daulatābad,Dowlatabad,Dowlatābād,dwlt abad,دولت آباد', 'dowlatabad-razavi-khorasan-iran', 'Asia/Tehran', 0, '35.28219', '59.51972'),
(98398, 30, 1371, 'دورود', 'Dorood Garan,Dorud,Dorūd,Dow Rud,Dow Rūd,Durud,Dūrūd,dwrwd,دورود', 'dorud', 'Asia/Tehran', 0, '33.49218', '49.0616'),
(98399, 30, 1379, 'گچساران', 'Do Gonbadan,Do Gonbadān,Dogonbadan,Dow Gonbadan,Dow Gonbadān,Du Gunbadan,Du Gunbadān,GCH,Gachsaran,Gachsārān,du gunbadan,gchsaran,دُو گُنبَدان,گچساران', 'dogonbadan', 'Asia/Tehran', 94638, '30.3586', '50.7981'),
(98400, 30, 1389, 'ديواندره', 'Divan Darra,Divandarreh,Diwan Darreh,Dīvan Darra,Dīvāndarreh,Dīwān Darreh,dywandrh,ديواندره', 'divandarreh', 'Asia/Tehran', 0, '35.9139', '47.0239'),
(98401, 30, 1385, 'دزفول', 'DEF,Dezfoul,Dezful,Dezfūl,Dizful,Dizful\',Dīzfūl,des ful,dezaphula,di zi fu lei,dyzfwl,dzfwl,Дизфуль,دزفول,ديزفول,देज़फूल,เดซฟูล,迪茲富勒', 'dezful', 'Asia/Tehran', 0, '32.38114', '48.40581'),
(98402, 30, 1395, 'قَلئِه دير', 'Bandar-e Deyyer,Daiyir,Dayer,Dayir,Dayyer,Deyr,Qal\'eh Dir,Qal’eh Dīr,bndr dyr,dyr,qalyih dyr,بندر دیر,دير,قَلئِه دير', 'deyr', 'Asia/Tehran', 0, '27.8399', '51.9378'),
(98403, 30, 1384, 'دليجان', 'Dalijan,Dalijān,Delijan,Delījān,Dilijan,Dilījān,dlyjan,دليجان', 'delijan', 'Asia/Tehran', 33508, '33.9905', '50.6838'),
(98404, 30, 1392, 'دِه لُوان', 'Deh Lovan,Deh Lovān,Deh Luran,Deh Lūrān,Dehloran,Dehlorān,Dekhlorana,dhlran,dih luan,dih lwran,Дехлорана,دهلران,دِه لوران,دِه لُوان', 'dehloran', 'Asia/Tehran', 46002, '32.6941', '47.2679'),
(98405, 30, 1389, 'دهگلان', 'Deh Gulan,Deh-i-Gulan,Deh-ī-Gūlān,Dehgolan,Dehgolān,dhglan,دهگلان', 'dehgolan', 'Asia/Tehran', 0, '35.278', '47.4184'),
(98406, 30, 1379, 'دِهدَست', 'Dehdasht,Dehdast,Kuhgiluyeh,dhdsht,dihdast,دهدشت,دِهدَست', 'dehdasht', 'Asia/Tehran', 69726, '30.7949', '50.56457'),
(98407, 30, 1379, 'سی سخت', 'Deh Bozorg-e Sisakht,Deh Bozorg-e Sīsakht,Deh Bozorg-e Sīsākht,Deh-e Bozorg Sisakht,Deh-e Bozorg Sīsakht,Sisakht,Sīsakht,dih buzurgi sysakht,sy skht,دِه بُزُرگِ سيساخت,دِه بُزُرگِ سيسَخت,سی سخت', 'sisakht', 'Asia/Tehran', 0, '30.86393', '51.4559'),
(98408, 30, 1378, 'صفاشهر', 'Deh Bid,Deh Bīd,Safashahr,dh byd,sfashhr,Şafāshahr,ده بید,صفاشهر', 'safashahr', 'Asia/Tehran', 0, '30.6131', '53.1954'),
(98409, 30, 1388, 'دهاقان', 'Dehaqan,Dehāqān,dhaqan,دهاقان', 'dehaqan', 'Asia/Tehran', 0, '31.94004', '51.64786'),
(98410, 30, 1385, 'سوسنگرد', 'Dasht-e Azadegan,Dasht-e Āzādegān,Dasht-i-Mishan,Dasht-i-Mishān,Dashte\' Mishan,Dashte’ Mishan,Khafajiyah,Khafajiyaz,Khafajiyeh,Susangerd,Susangird,Susangurd,Sūsangerd,Sūsangird,Sūsangurd,swsngrd,سوسنگرد', 'susangerd', 'Asia/Tehran', 41443, '31.5635', '48.18958'),
(98411, 30, 1392, 'شهرستان دره‌شهر', 'Dareh sahr,Darre Szahr,Darreh Shahr,Darreh-ye Shahr,Darrehshahr,Darreshekhr,Deresehr,Dereşehr,Dərəşəhr,Madakto,drh shhr,Даррашаҳр,Даррешехр,Դարեհ շահր,دره شهر,دره‌شهر,دەڕەشار,شهرستان دره‌شهر', 'darreh-shahr', 'Asia/Tehran', 24961, '33.14447', '47.3799'),
(98412, 30, 1372, 'درگز', 'Dargaz,Darreh Gaz,Mohammadabad,Mohammadabad Arbab,Moḩammadābād,Moḩammadābād Arbāb,Muhammadabad,Muhammadābād,drgz,drh gz,دره گز,درگز', 'dargaz', 'Asia/Tehran', 0, '37.44447', '59.10809'),
(98413, 30, 1388, 'فریدن', 'Daran,Darun,Dārān,Dārūn,Fareydan,Faridan,Farīdān,daran,frydn,داران,فریدن', 'daran', 'Asia/Tehran', 0, '32.98741', '50.4108'),
(98414, 30, 1378, 'داراب ٢', 'Darab,Darab-e Do,Dārāb,Dārāb-e Do,darab,darab 2,داراب,داراب ٢', 'darab', 'Asia/Tehran', 63319, '28.75171', '54.54065'),
(98415, 30, 1373, 'دامغان', 'Damghan,Dāmghān,damghan,دامغان', 'damghan', 'Asia/Tehran', 67694, '36.1679', '54.34292'),
(98416, 30, 1374, 'قَصَبِهِ دَماوَند', 'Damavand,Damāvand,Demavend,Demāvend,Qasabeh-e Damavand,Qaşabeh-e Damāvand,dmawnd,qasabihi damawand,Дамаванд,دماوند,قَصَبِهِ دَماوَند', 'damavand', 'Asia/Tehran', 29144, '35.71842', '52.06958'),
(98417, 30, 1372, 'چناران', 'Chanaran,Chanārān,Chenaran,Chenārān,Chinaran,Chinārān,chnaran,چناران', 'chenaran', 'Asia/Tehran', 46940, '36.64546', '59.12123'),
(98418, 30, 1387, 'چلگرد', 'Chalehgard,Chelgard,Chelgerd,Shur Ab,Shūr Āb,chlgrd,چلگرد', 'chelgard', 'Asia/Tehran', 0, '32.4672', '50.12229'),
(98419, 30, 1382, 'چالوس', 'Chalus,Chālūs,chalws,Чалус,چالوس', 'chalus-iran', 'Asia/Tehran', 69638, '36.655', '51.4204'),
(98420, 30, 1388, 'چادگان', 'Chadegan,Chadgan,Chadgun,Chadgūn,Chadugan,Chadūgān,Chādegān,Chādgān,chadgan,چادگان', 'chadegan', 'Asia/Tehran', 0, '32.76825', '50.62873'),
(98421, 30, 1395, 'بوشِهر', 'Abu Shahr,Abu Shehr,Abuschehr,BUZ,Bandar Abu Shehr,Bandar Bushehr,Bandar Būshehr,Bandar-e Bushehr,Bandar-e Būshehr,Bouchehr,Buschehr,Buschir,Busehr,Bushehr,Busher,Bushir,Bushire,Būshehr,Būšehr,bndr bwshhr,bwshhr,bwshihr,Бушер,Бушир,Бӯшеҳр,Бӯшиҳр,بندر بوشهر,بوشهر,بوشِهر', 'bushehr', 'Asia/Tehran', 165377, '28.96887', '50.83657'),
(98422, 30, 1383, 'بوکان', 'Bokan,Bowkan,Bowkān,Bukan,Būkān,bwkan,Букан,بوکان', 'bukan', 'Asia/Tehran', 213331, '36.521', '46.2089'),
(98423, 30, 1366, 'بوئین زهرا', 'Bu\'in,Bu\'in Zahra,Buyin,Būyīn,Bū’īn,Bū’īn Zahrā,bwyyn zhra,بوئین زهرا', 'bu-in-zahra', 'Asia/Tehran', 0, '35.7669', '50.0578'),
(98424, 30, 1371, 'بوروجيرد', 'Borudzherd,Borujerd,Borūjerd,Burujird,Būrūjīrd,brwjrd,bwrwjyrd,Боруджерд,بروجرد,بوروجيرد', 'borujerd', 'Asia/Tehran', 251958, '33.8973', '48.7516'),
(98425, 30, 1387, 'بِرُّجِن', 'Amrujan,Amrūjān,Beroojen,Borujan,Borujen,Borūjen,Borūjān,Burujan,Burūjān,Urujan,Urūjān,aamrwjan,birujin,brwjn,burwjan,اَمروجان,بروجن,بُروجان,بِرُّجِن', 'borujen', 'Asia/Tehran', 52654, '31.96523', '51.2873'),
(98426, 30, 1395, 'بُرَزدجَن', 'Borazdjan,Borazjan,Borazjun,Borāzjān,Borāzjūn,brazjan,burazdjan,برازجان,بُرَزدجَن', 'borazjan', 'Asia/Tehran', 86059, '29.2699', '51.2188'),
(98427, 30, 1385, 'شهرک کولوری', 'Boneh Hoseinkalooli,Boneh Hoseyn Koluli,Boneh Ḩoseyn Kolūlī,Boneh-ye Hoseyn Kaluli,Boneh-ye Ḩoseyn Kalūlī,Shahrak-e Kaluli,Shahrak-e Kalūlī,Shahrak-e Kuluri,Shahrak-e Kūlūrī,bnh hsyn klwly,shhrk klwly,shhrk kwlwry,بنه حسين کلولی,شهرک کلولی,شهرک کولوری', 'shahrak-e-kuluri', 'Asia/Tehran', 1941, '32.35276', '48.47059'),
(98428, 30, 1386, 'بجنورد', 'BJB,Bodzhnurd,Bojnord,Bojnourd,Bojnurd,Bojnūrd,Bujnurd,Bujnūrd,bjnwrd,Боджнурд,بجنورد', 'bojnurd', 'Asia/Tehran', 192041, '37.47473', '57.32903'),
(98429, 30, 1391, 'بیرجند', 'Birdjand,Birdschand,Birdzhend,Birjand,Bīrjand,XBJ,byrjnd,Бирдженд,Бӣрҷанд,بيرجند,بیرجند', 'birjand', 'Asia/Tehran', 196982, '32.86628', '59.22114'),
(98430, 30, 1368, 'بيله سوار', 'Bileh Savar,Bīleh Savār,bylh swar,بيله سوار', 'bileh-savar', 'Asia/Tehran', 14000, '39.37961', '48.35463'),
(98431, 30, 1389, 'بيجار', 'Bidzhar,Bijar,Bījār,byjar,Биджар,بيجار', 'bijar', 'Asia/Tehran', 53871, '35.8668', '47.60506'),
(98432, 30, 1369, 'بناب', 'Benab,Benāb,Binab,Bināb,Bonab,Bonāb,Bunab,bnab,Бонаб,بناب', 'bonab', 'Asia/Tehran', 80359, '37.3404', '46.0561'),
(98433, 30, 1382, 'بهشهر', 'Ashraf,Behshahr,Bekhshekhr,aashraf,bhshhr,Бехшехр,اَشرَف,بهشهر', 'behshahr', 'Asia/Tehran', 93500, '36.69235', '53.55262'),
(98434, 30, 1385, 'بهبهان', 'Behbahan,Behbahān,Behbehan,Behbehān,bhbhan,بهبهان', 'behbahan', 'Asia/Tehran', 79327, '30.5959', '50.2417'),
(98435, 30, 1376, 'ماسال', 'Bazar-e Masal,Bāzār-e Māsāl,Masal,Masal-Bazar,Māsāl,Sar-i-Bazar,Sar-i-Bāzar,Sari Bazar Musar,Sārī Bāzār Mūsār,bazar masal,masal,بازار ماسال,ماسال', 'masal', 'Asia/Tehran', 0, '37.3631', '49.1329'),
(98436, 30, 1390, 'لَستَك', 'Bastak,Lastak,bstk,lastak,Бастак,بستک,لَستَك', 'bastak', 'Asia/Tehran', 0, '27.19908', '54.36676'),
(98437, 30, 1379, 'بَشت', 'Basht,Bāsht,basht,باشت,بَشت', 'basht', 'Asia/Tehran', 0, '30.361', '51.15735'),
(98438, 30, 1372, 'برداسکن', 'Badar Askan,Badar Askān,Badr Eshkand,Bardaskan,Bardaskand,Bardeshkand,Bardeskan,Bardāskan,Bardāskand,Berdesken,Budraskan,Būdraskān,Bərdəskən,ba er da si kan,baradaskana,brdaskn,brdskn,Бардаскан,Բարդասքան,برداسکن,بردسكن,بردسکن,বারদাস্কান,巴爾達斯坎', 'bardaskan', 'Asia/Tehran', 28233, '35.26218', '57.97075'),
(98439, 30, 1389, 'بَنِ', 'Bane,Baneh,Bani,Bāneh,banh,bani,Бани,بانه,بَنِ', 'baneh', 'Asia/Tehran', 104799, '35.9975', '45.8853'),
(98440, 30, 1375, 'بَندَرِ شاه', 'Bandar Shah,Bandar Shāh,Bandar-e Shah,Bandar-e Shāh,Bandar-e Torkaman,Bandar-e Torkeman,Bandar-e Torkman,bandari shah,bandari turkman,bndr trkmn,بندر تركمن,بَندَرِ تُركمَن,بَندَرِ شاه', 'bandar-e-torkaman', 'Asia/Tehran', 0, '36.90124', '54.07195'),
(98441, 30, 1385, 'بندر ماهشهر', 'Bandar Ma`sbur,Bandar Ma`shur,Bandar Mah Shahr Terminal,Bandar Mah Sharh,Bandar Mah-Shahr,Bandar Mashur,Bandar Ma‘sbur,Bandar Ma‘shūr,Bandar-Mashour,Bandar-e Ma`shur,Bandar-e Mahshahr,Bandar-e Ma‘shūr,Bandar-e Māhshahr,Bandar-mashoor,Bar Andaz,Bār Andāz,MRX,Mah Shahr,Mahshahr,Markaz-e Bargiri-ye Bandar-e Mah Shahr,Markaz-e Bārgīrī-ye Bandar-e Māh Shahr,Mashur,Māhshahr,bndr mahshhr,بندر ماهشهر', 'bandar-e-mahshahr', 'Asia/Tehran', 0, '30.55655', '49.18852'),
(98442, 30, 1390, 'بندر لنگه', 'BDH,Bandar Langeh,Bandar-e Lengeh,Bandar-e-Langeh,Linja,Linjah,bndr lngh,بندر لنگه', 'bandar-e-lengeh', 'Asia/Tehran', 22768, '26.55792', '54.88067'),
(98443, 30, 1375, 'بندر گز', 'Bandar Gaz,Bandar-e Gaz,Bandar-i-Gaz,Bandar-i-Jaz,Bander Gaz,bndr gz,بندر گز', 'bandar-e-gaz', 'Asia/Tehran', 0, '36.77409', '53.94798'),
(98444, 30, 1395, 'بندر ديلم', 'Bandar Deylam,Bandar Dilam,Bandar Dīlam,Bandar-e Delam,Bandar-e Deylam,Dilam,Dīlam,bndr dylm,بندر ديلم', 'bandar-e-deylam', 'Asia/Tehran', 0, '30.0542', '50.159'),
(98445, 30, 1376, 'بندر انزلی', 'Bandar Anzali,Bandar Pahlavi,Bandar Pahlevi,Bandar-e Anzali,Bandar-e Anzalī,Bandar-e Pahlavi,Bandar-e Pahlavī,Enceli,Enzeli,Pahlavi,Pahlavī,Pahlevi,Pahlevī,Pehlevi,bndr anzly,بندر انزلی', 'bandar-e-anzali', 'Asia/Tehran', 110826, '37.47318', '49.45785'),
(98446, 30, 1390, 'بندرعباس', 'BND,Bandar Abas,Bandar Abbas,Bandar Abbas - بندر عباس,Bandar Abbás,Bandar `Abbas,Bandar `Abbasi,Bandar ‘Abbās,Bandar ‘Abbāsī,Bandar-Abbas,Bandar-Abbasz,Bandar-Abbos,Bandar-Abbász,Bandar-e Abbas,Bandar-e `Abbas,Bandar-e ‘Abbās,Bandare Abasas,Bander Abbas,Bantar Ampas,Bendehr-Abas,Bender Abas,Bender Abbas,Bender Ebbas,Bender-Abbas,Bəndər Abbas,Cambarao,Cambarão,Gombroon,Gumrun,Port Comorao,Port Comorão,a ba si gang,ban dar xab bas,bandaleuabaseu,bandara abbasa,bandara-e-abbasa,bender-abasi,bndr ʻbʼs,bndr ʿbas,gumbrun,Μπαντάρ Αμπάς,Бандар-Аббос,Бендер Абас,Бендер-Аббас,Бендэр-Абас,Բանդեր Աբբաս,בנדר עבאס,بندر عباس,بندرعباس,بَندَر عَبّاسی,بَندَرِ عَبّاس,بەندەر عەباس,گُمبرُّن,बंदर-ए-अब्बास,বন্দর আব্বাস,บันดาร์อับบาส,ბენდერ-აბასი,バンダレ・アッバース,阿巴斯港,반다르아바스', 'bandar-abbas', 'Asia/Tehran', 352173, '27.1865', '56.2808'),
(98447, 30, 1380, 'بم', 'BXR,Bam,bamu,bm,Бам,بم,バム', 'bam', 'Asia/Tehran', 99268, '29.106', '58.357'),
(98448, 30, 1372, 'بجستان', 'Bajestan,Bajestān,Bejestan,Bejestān,Bijestan,Bijistan,Bījestān,Bījistān,bjstan,بجستان', 'bajestan', 'Asia/Tehran', 0, '34.51639', '58.1845'),
(98449, 30, 1367, 'بهار', 'Bahar,Bahār,Bakhar,bhar,Бахар,بهار', 'bahar', 'Asia/Tehran', 28645, '34.9072', '48.4414'),
(98450, 30, 1385, 'باغ ملک', 'Bagh Malek,Bagh-e Malek,Bagh-i-Malik,Bāgh-e Malek,bagh mlk,باغ ملک', 'bagh-e-malek', 'Asia/Tehran', 0, '31.52398', '49.88558'),
(98451, 30, 1380, 'بافت', 'Baft,Bāft,baft,بافت', 'baft', 'Asia/Tehran', 0, '29.2331', '56.6022'),
(98452, 30, 1381, 'بافق', 'Bafk,Bafq,Bāfq,bafq,Бафк,بافق', 'bafq', 'Asia/Tehran', 31215, '31.6035', '55.40249'),
(98453, 30, 1382, 'بابلسر', 'Babolsar,Babul Sar,Bābolsar,Bābul Sar,Mashhad-i-Sar,Mashhadsar,Meshed-i-Sar,bablsr,بابلسر', 'babolsar', 'Asia/Tehran', 48051, '36.69929', '52.65011'),
(98454, 30, 1382, 'بابل', 'Babol,Babol\',Babul,Balfrush,Barfarush,Barfrush,Barfurush,Bābol,Bābul,Bārfurush,babl,Баболь,بابل', 'babol', 'Asia/Tehran', 202796, '36.55102', '52.6786'),
(98455, 30, 1371, 'ازنا', 'Azna,Aznā,azna,ازنا', 'azna', 'Asia/Tehran', 47482, '33.6095', '48.9307'),
(98456, 30, 1369, 'هشترود', 'Azaran,Hashtrud,Hashtrūd,Sar Eskand,Sar Eskand Khan,Sar Eskand Khān,Sar Eskandar,Saraskand,Sarāskand,hshtrwd,Āz̄arān,هشترود', 'hashtrud', 'Asia/Tehran', 16888, '37.4779', '47.0508'),
(98457, 30, 1384, 'شازند', 'Azadshahr,Shah Zand,Shazand,Shāzand,shaznd,Āzādshahr,شازند', 'shazand', 'Asia/Tehran', 0, '33.93132', '49.40629'),
(98458, 30, 1376, 'آستارا', 'Astara,astara,Āstārā,Астара,آستارا', 'astara-iran', 'Asia/Tehran', 39065, '38.43084', '48.86994'),
(98459, 30, 1376, 'آستانه اشرفیه', 'Astane,Astaneh,Astaneh-ye Ashrafiyeh,astanh ashrfyh,Āstāneh,Āstāneh-ye Ashrafīyeh,آستانه اشرفیه', 'astaneh-ye-ashrafiyeh', 'Asia/Tehran', 42784, '37.26318', '49.94325'),
(98460, 30, 1384, 'آشتيان', 'Ashtian,Ashtiyan,Ashtīyan,ashtyan,Āshtīān,آشتيان', 'ashtian', 'Asia/Tehran', 0, '34.52298', '50.00608'),
(98461, 30, 1386, 'آشخانه', 'Ashkhaneh,ashkhanh,Āshkhāneh,آشخانه', 'ashkhaneh', 'Asia/Tehran', 0, '37.5615', '56.92125'),
(98463, 30, 1391, 'اسدیه', 'Asadiyeh,Asadīyeh,asdyh,اسدیه', 'asadiyeh', 'Asia/Tehran', 0, '32.9428', '59.71998'),
(98464, 30, 1367, 'اسد آباد', 'Asadabad,Asadabada,Asadābād,asd abad,Асадабада,اسد آباد', 'asadabad-iran', 'Asia/Tehran', 59617, '34.78241', '48.12012'),
(98466, 30, 1378, 'ارسنجان', 'Arsanjan,Arsanjān,Arsenjan,Arsenjān,Arsinjan,Arsinjān,arsnjan,ارسنجان', 'arsanjan', 'Asia/Tehran', 0, '29.9124', '53.3085'),
(98467, 30, 1388, 'اردستان', 'Ardestan,Ardestān,Ardistan,Ardistān,ardstan,اردستان', 'ardestan', 'Asia/Tehran', 16058, '33.3761', '52.3694'),
(98468, 30, 1387, 'اردل', 'Ardal,Ardel,ardl,اردل', 'ardal', 'Asia/Tehran', 0, '31.99969', '50.66231'),
(98469, 30, 1381, 'اردکان', 'Ardakan,Ardakān,Ardekan,ardkan,اردکان', 'ardakan', 'Asia/Tehran', 58834, '32.31001', '54.01747'),
(98470, 30, 1368, 'اَردِبيل', 'ADU,Ardabel,Ardabil,Ardabīl,Ardebil,Ardebīl,Erdebil,aardibyl,ardbyl,Ərdəbil,Ардабел,اردبيل,اردبیل,اَردِبيل', 'ardabil', 'Asia/Tehran', 410753, '38.2498', '48.2933'),
(98471, 30, 1388, 'گل آرا', 'Aran,Aran Bidgol,Aran va Bidgol,Arun,Arūn,Gol Ara,Gol Ārā,aran,aran byd gl,aran w bydgl,gl ara,Ārān,Ārān Bīdgol,Ārān va Bīdgol,آران,آران بيد گل,آران و بيدگل,گل آرا', 'aran-bidgol', 'Asia/Tehran', 0, '34.05751', '51.48291'),
(98473, 30, 1373, 'اَردان', 'Aradan,Ardan,Ardān,Azadan,aardan,aradan,Ārādān,Āzādān,آرادان,اَردان', 'aradan', 'Asia/Tehran', 0, '35.24941', '52.49422'),
(98474, 30, 1367, 'اَنوج', 'Anuch,Anuj,Anūch,Anūj,Sefid Kuh,Sefīd Kūh,aanwj,anwch,انوچ,اَنوج', 'anuch', 'Asia/Tehran', 1833, '34.10829', '48.57375'),
(98475, 30, 1385, 'اندیمشک', 'Andimeshg,Andimeshk,Andimishk,Andremeshl,Andīmeshg,Andīmeshk,Andīmīshk,Salehabad,Salehābād,andymshk,اندیمشک', 'andimeshk', 'Asia/Tehran', 0, '32.4615', '48.35368'),
(98477, 30, 1380, 'انار', 'Anar,Anār,anar,انار', 'anar', 'Asia/Tehran', 0, '30.87066', '55.27025'),
(98478, 30, 1382, 'آمل', 'Amol,Amol\',Amul,aml,Āmol,Амоль,آمل', 'amol', 'Asia/Tehran', 199382, '36.46961', '52.35072'),
(98479, 30, 1376, 'املش', 'Amlash,Amlesh,Amlish,amlsh,املش', 'amlash', 'Asia/Tehran', 0, '37.0966', '50.18709'),
(98480, 30, 1377, 'الوند', 'Alband,Alvand,Alwand,El\'vend,El’vend,alwnd,Алванд,الوند', 'alvand-zanjan', 'Asia/Tehran', 74889, '36.31885', '49.16773'),
(98485, 30, 1371, 'الشتر', 'Alashtar,Aleshtar,Alishtar,Alishtār,Qal`eh Mozaffari,Qal`eh `Alishtar,Qal‘eh Moz̧affari,Qal‘eh ‘Alishtār,alshtr,الشتر', 'aleshtar', 'Asia/Tehran', 27701, '33.86419', '48.26258'),
(98486, 30, 1378, 'اکبر آباد', 'Akbar Abad Kawar,Akbarabad,Akbarabad-e Kavar,Akbarābād,Akbarābād-e Kavār,akbr abad,Акбарабад,اکبر آباد', 'akbarabad', 'Asia/Tehran', 98342, '29.2464', '52.7793'),
(98488, 30, 1385, 'اهواز', 'AWZ,Ahvaz,Ahvaz - ahwaz,Ahvaz - اهواز,Ahvaza,Ahvazas,Ahvazo,Ahvoz,Ahváz,Ahvāz,Ahvāza,Ahwas,Ahwaz,Ahwāz,Akhvaz,Akhvaz shaary,Axvaz,Bandar Nasiri,Bandar Nāsirī,Bandar-e Naser,Bandar-e Nāşer,Ehvaz,Naseri,Nasiri,Nāsiri,Nāşerī,a wa shi,abajeu,afuvuazu,ahabaja,ahavaza,ahvazi,ahwaz,akvacu,alahwaz,Əhvaz,Ахваз,Ахваз шаары,Аҳвоз,Ախվազ,אהוואז,ئەھواز,الأهواز,اهواز,اہواز,अहवाज़,আহবাজ,ਅਹਵਾਜ਼,ஆக்வாசு,ཨཱ་ཝཛ།,აჰვაზი,アフヴァーズ,阿瓦士,아바즈', 'ahvaz', 'Asia/Tehran', 841145, '31.31901', '48.6842'),
(98489, 30, 1395, 'اهرم', 'Ahram,Ahrom,ahrm,اهرم', 'ahram', 'Asia/Tehran', 0, '28.8826', '51.2746'),
(98490, 30, 1369, 'اهر', 'Ahar,Akhar,Eher,a ha er,ahaleu,ahara,ahr,Əhər,Ахар,Аҳар,أهر,اهر,اہار,اہر,अहार,阿哈尔,아하르', 'ahar', 'Asia/Tehran', 94348, '38.4774', '47.0699'),
(98491, 30, 1385, 'آغاجاری', 'AKW,Agha Jari,Aghajari,Aqa Jari,aghajary,Āghā Jārī,Āghājārī,Āqā Jarī,آغاجاری', 'aghajari', 'Asia/Tehran', 21785, '30.7006', '49.8315'),
(98492, 30, 1384, 'آبيِك', 'Abiak,abyik,آبيِك', 'abyek-markazi', 'Asia/Tehran', 55128, '36.06667', '50.55'),
(98493, 30, 1366, 'اَبيِك سُفلَ', 'Abiak,Abiak Sarai,Abiak Sarāi,Abyek,Abyek Sofla,Abyek-e Pa\'in,aabyik sufla,abyiki payyn,abyk,Ābyek,Ābyek-e Pā’īn,آبيِكِ پائين,آبيک,اَبيِك سُفلَ', 'abyek-qazvin', 'Asia/Tehran', 0, '36.03993', '50.53101'),
(98494, 30, 1377, 'ابهر', 'Abhar,Abkhar,abhr,Абхар,ابهر', 'abhar', 'Asia/Tehran', 69889, '36.1468', '49.218'),
(98495, 30, 1392, 'آبادان', 'Abdanan,Awdanan,Qal`a Ab-i-Danan,Qal`eh Ab-i-Danan,Qal`eh-ye Ab Danan,Qal`eh-ye Abdaran,Qal‘a Ab-ī-Danan,Qal‘eh Āb-ī-Dānān,Qal‘eh-ye Āb Dānān,Qal‘eh-ye Ābdārān,a bo da nan,abadanana,abdanan,Ābdānān,Абданан,آبدانان,ابدانان,قَلعِۀ آب دانان,قَلعِۀ آبداران,अबदानन,阿卜达南,阿卜達南', 'abdanan', 'Asia/Tehran', 19360, '32.9926', '47.4198'),
(98497, 30, 1377, 'آب بر', 'Abbar,Obar,Ubar,Ubār,ab br,Ābbar,آب بر', 'abbar', 'Asia/Tehran', 0, '36.92627', '48.95832'),
(98498, 30, 1381, 'اَبَركو', 'Abar Qu,Abar Qū,Abarghoo,Abarku,Abarkuh,Abarkū,Abarkūh,Abarquh,Abarqūh,aabarghu,aabarkw,aabarqwh,abr qw,abrkwh,ابر قو,ابرکوه,اَبَرغُّ,اَبَرقوه,اَبَركو', 'abarkuh', 'Asia/Tehran', 0, '31.1289', '53.2824'),
(98499, 30, 1378, 'آباده', 'Abade,Abadeh,abadh,Ābādeh,Абаде,آباده', 'abadeh', 'Asia/Tehran', 59116, '31.1608', '52.6506'),
(98500, 30, 1385, 'آبادان', 'ABD,Abadan,Abadana,Abadanas,Abadano,Abadán,Ampantan,Obodon,a ba dan,abadan,abadana,abadani,Ábádán,Ābadāna,Ābādān,ʿbadan,Αμπαντάν,Абадан,Ободон,Աբադան,אבאדאן,آبادان,ابادان,عبادان,अबादान,ਆਬਾਦਾਨ,აბადანი,アバダーン,アーバーダーン,阿巴丹,아바단', 'abadan-iran', 'Asia/Tehran', 370180, '30.3392', '48.3043'),
(98501, 30, 1380, 'کوه سفید', 'Kuh Sefid,Kuh-e Sefid,Kūh Sefīd,Kūh-e Sefīd,kwh sfyd,کوه سفید', 'kuh-sefid', 'Asia/Tehran', 2850, '29.2762', '56.8014'),
(98502, 30, 1383, 'شُط', 'Shot,Showt,Showţ,Shoţ,shut,shwt,شوط,شُط', 'showt', 'Asia/Tehran', 0, '39.2192', '44.77'),
(98505, 30, 1378, 'سپیدان', 'Ardakan,Ardakān,Sepidan,Sepīdān,ardkan,spydan,اردکان,سپیدان', 'sepidan', 'Asia/Tehran', 0, '30.25961', '51.98491'),
(98506, 30, 1374, 'اقباليّه', 'Eqbaliyeh,Eqbālīyeh,aqbalyh,اقباليّه', 'eqbaliyeh', 'Asia/Tehran', 36709, '35.3022', '51.5358'),
(98507, 30, 1388, 'شاهین شهر', 'Shahin Shahr,Shāhīn Shahr,shahyn shhr,شاهین شهر', 'shahin-shahr', 'Asia/Tehran', 0, '32.85788', '51.5529'),
(98508, 30, 1388, 'زرّین شهر', 'Qal`eh Riz,Qal‘eh Rīz,Riz,Riz-e Lanjan,Rīz,Rīz-e Lanjān,Zarrin Shahr,Zarrīn Shahr,zryn shhr,زرّین شهر', 'zarrin-shahr', 'Asia/Tehran', 0, '32.3897', '51.3766'),
(98509, 30, 1388, 'تیران', 'Tehran,Tehrān,Tihran,Tihrān,Tiran,Tirun,Tirūn,Tīrān,tyran,تیران', 'tiran', 'Asia/Tehran', 0, '32.70328', '51.15381'),
(98510, 30, 1388, 'رهنان', 'Rahnan,Rehnan,Rehnān,Renan,Renān,Rohanan,Rohnan,rhnan,rnan,رنان,رهنان', 'rehnan', 'Asia/Tehran', 49143, '32.68325', '51.60158'),
(98511, 30, 1388, 'قمشه', 'Qomisheh,Qomsheh,Qomīsheh,Qowmsheh,Qumisheh,Shahreza,Shahreẕā,Shahriza,qmshh,shhrda,شهرضا,قمشه', 'shahreza', 'Asia/Tehran', 0, '32.0089', '51.8668'),
(98512, 30, 1388, 'قهدریجان', 'Kedargun,Kedargūn,Qadrijan,Qadrijān,Qadrja,Qadrjā,Qahderijan,Qahderījān,qhdryjan,قهدریجان', 'qahderijan', 'Asia/Tehran', 29392, '32.5773', '51.45367'),
(98513, 30, 1388, 'نجف آباد', 'Nadzhafabad,Najafabad,Najafābād,Nejafabad,Nejafābād,njf abad,Наджафабад,نجف آباد', 'najafabad', 'Asia/Tehran', 223450, '32.63464', '51.36525'),
(98514, 30, 1388, 'مبارکه', 'Mobarakeh,Mobārakeh,Mubarakeh,Mubārakeh,mbarkh,مبارکه', 'mobarakeh', 'Asia/Tehran', 0, '32.34651', '51.50449'),
(98515, 30, 1388, 'خمینی شهر', 'Homayoon Shahr,Homayunshahr,Homāyūnshahr,Khomeyni Shahr,Khomeynishahr,Khomeynī Shahr,Khomeynīshahr,Sedeh,khmyny shhr,خمینی شهر', 'khomeyni-shahr', 'Asia/Tehran', 277334, '32.6856', '51.53609'),
(98516, 30, 1388, 'کلیشاد و سودرجان', 'Baba `Abdollah,Bābā ‘Abdollāh,Gulshad,Gulshād,Kalushad,Kalūshād,Kelishad,Kelishad va Sudarjan,Kelishad-e Sofla,Kelīshād,Kelīshād va Sūdarjān,Kelīshād-e Soflá,klyshad,klyshad w swdrjan,کلیشاد,کلیشاد و سودرجان', 'kelishad-va-sudarjan', 'Asia/Tehran', 33630, '32.55118', '51.52758'),
(98517, 30, 1388, 'ملاورجان', 'Falavar Jan,Falavarjan,Falāvar Jān,Falāvarjān,Felavarjan,Felāvarjān,Mollavarjan,Mollāvarjān,Pol-e Vargan,Pol-e Vargān,Pol-e Varqan,Pol-e Varqān,Pul-i-Vargan,Pul-i-Vargān,flawrjan,mlawrjan,فلاورجان,ملاورجان', 'falavarjan', 'Asia/Tehran', 49843, '32.5553', '51.50973'),
(98518, 30, 1388, 'اصفهان', 'Aspadana,Dakbayan sa Esfahan,Dakbayan sa Esfahān,Esfahan,Esfahano,Esfahān,Esfehan,Eşfahān,Eşfehān,IFN,Isfachan,Isfahan,Isfahana,Isfahanas,Isfahanum,Isfahon,Isfahán,Isfahāna,Isfakhan,Isfehan,Ispahan,Iszfahan,Iszfahán,Kota Isfahan,Spahan,Yspyhan,asfhan,aysfahan,esaphahana,esufahan,icupakan,isafahana,iseupahan,isfahana,isphahana,xis fa han,yi si fa han,Îsfehan,İsfahan,İsfehan,Ισφαχάν,Ісфахан,Исфахан,Исфаҳон,Исфаһан,Սպահան,אספהאן,أصفهان,ئسفأھان,ئەسفەھان,اصفهان,اصفہان,ایصفاهان,इस्फहान,इस्फ़हान,এসফাহন,ਇਸਫ਼ਹਾਨ,இசுபகான்,อิสฟาฮาน,ისპაანი,エスファハーン,伊斯法罕,이스파한', 'isfahan', 'Asia/Tehran', 1547164, '32.65246', '51.67462'),
(98519, 30, 1388, 'دولت آباد', 'Daulatabad,Daulatābād,Dowlatabad,Dowlatābād,dwlt abad,دولت آباد', 'dowlatabad-isfahan-iran', 'Asia/Tehran', 33607, '32.79978', '51.69553'),
(98521, 30, 1388, 'باغ ابریشم', 'Abrisham,Abrīsham,Bagh Abrisham,Bagh-e Abrisham,Bāgh Abrīsham,Bāgh-e Abrīsham,abryshm,bagh abryshm,ابریشم,باغ ابریشم', 'abrisham', 'Asia/Tehran', 20000, '32.55613', '51.57325'),
(98522, 30, 1374, 'اسلامشهر', 'Eslamshahr,Eslāmshahr,aslamshhr,اسلامشهر', 'eslamshahr', 'Asia/Tehran', 0, '35.55222', '51.23504'),
(98523, 30, 1372, 'شهرک باخرز', 'Shahr-e Now,Shahrak-e Bakharz,Shahrak-e Bākharz,shhrk bakhrz,شهرک باخرز', 'shahrak-e-bakharz', 'Asia/Tehran', 0, '34.99204', '60.31714'),
(98524, 30, 1394, 'زابل', 'ACZ,Zabol,Zabol\',Zābol,zabl,Заболь,زابل', 'zabol', 'Asia/Tehran', 121989, '31.0306', '61.4949'),
(98525, 30, 1394, 'زاهدان', 'Dowzdab,Dowzdāb,Duzdab,Duzdap,Duzdāb,Duzdāp,ZAH,Zahedan,Zahedan-e (Yek),Zahedanas,Zahedano,Zahedán,Zahidan,Zaidan,Zaidān,Zakhedan,Záhedán,Zāhedān,Zāhedān-e (Yek),cakitan,jahedan,jahedana,zahdan,zahedan,zahedana,zahedani,zha hei dan,Захедан,Зоҳидон,Զահեդան,زاهدان,زاہدان,ज़ाहेदान,জহেদন,சாகிதன்,ზაჰედანი,ザーヘダーン,扎黑丹,자헤단', 'zahedan', 'Asia/Tehran', 551980, '29.4963', '60.8629'),
(98526, 30, 1394, 'زهک', 'Deh-e Zahak,Zahak,Zehak,zhk,زهک', 'zehak', 'Asia/Tehran', 0, '30.894', '61.6804'),
(98527, 30, 1394, 'مهرستان', 'Magas,Mehrestan,Mehrestān,Qal`eh-ye Zaboli,Qal‘eh-ye Zābolī,Zaboli,Zābolī,mhrstan,zably,زابلی,مهرستان', 'zaboli', 'Asia/Tehran', 0, '27.131', '61.67445'),
(98528, 30, 1372, 'تربت جام', 'Torbat-e Jam,Torbat-e Jām,Torbat-e Sheykh Jam,Torbat-e Sheykh Jām,Turbat-i-Shaikh Jam,trbt jam,تربت جام', 'torbat-e-jam', 'Asia/Tehran', 58928, '35.244', '60.6225'),
(98529, 30, 1372, 'تايباد', 'Taiabad,Taybad,Tayebad,Tayebat,Tayyebat,Taīabad,Tāybād,Tāyebāt,taybad,Ţayyebāt,تايباد', 'taybad', 'Asia/Tehran', 37513, '34.74', '60.7756'),
(98530, 30, 1394, 'سوران', 'Sooran,Suran,Surar,Sūrān,Sūrār,swran,سوران', 'suran-sistan-and-baluchestan-iran', 'Asia/Tehran', 0, '27.2855', '61.9965'),
(98531, 30, 1372, 'سرخس', 'CKT,Sarahs,Sarakhs,Serakhs,srkhs,Сарахс,سرخس', 'sarakhs', 'Asia/Tehran', 46499, '36.5449', '61.1577'),
(98532, 30, 1394, 'راسک', 'Rasak,Rask,Razk,Rāsak,Rāsk,Rāzk,rask,راسک', 'rasak', 'Asia/Tehran', 0, '26.23682', '61.39901'),
(98534, 30, 1394, 'نیکشهر', 'Geh,Keh,Nik,Nikshahr,Nīk,Nīkshahr,nykshhr,نیکشهر', 'nikshahr', 'Asia/Tehran', 17000, '26.2258', '60.2143'),
(98535, 30, 1391, 'نهبندان', 'Nah,Neh,Nehbandan,Nehbandān,nhbndan,نهبندان', 'nehbandan', 'Asia/Tehran', 0, '31.54185', '60.03648'),
(98536, 30, 1394, 'کنارک', 'Kenarak,Kenārak,Konarak,Konārak,Kumarak,Kunarak,Kunark,Kunārak,Kūmārak,knark,کنارک', 'konarak', 'Asia/Tehran', 0, '25.3604', '60.3995'),
(98537, 30, 1372, 'خواف', 'Khaf,Khvaf,Khvāf,Khāf,Qasabeh-ye Rud,Qaşabeh-ye Rūd,Rud,Rui Khaf,Ruy,Rūd,Rūi Khāf,Rūy,khwaf,خواف', 'khvaf', 'Asia/Tehran', 0, '34.5763', '60.14093'),
(98538, 30, 1394, 'خاش', 'Kavash,Khash,Khāsh,Kwash,Kwāsh,Vasht,Vāsht,khash,Хаш,خاش', 'khash-iran', 'Asia/Tehran', 69603, '28.22107', '61.21582'),
(98539, 30, 1394, 'ايرانشهر', 'Fahrej,Fehruj,IHR,Iranshahr,Qal`eh-ye Naseri,Qal‘eh-ye Nāşerī,ayranshhr,Īrānshahr,ايرانشهر', 'iranshahr', 'Asia/Tehran', 131232, '27.20245', '60.68476'),
(98541, 30, 1394, 'دوست محمد خان', 'Dust Mohammad Khan,Dūst Moḩammad Khān,dwst mhmd khan,دوست محمد خان', 'dust-mohammad-khan', 'Asia/Tehran', 0, '31.1447', '61.7925'),
(98542, 30, 1394, 'چابهار', 'Cabahar,Cahbahar,Chabahar,Chabakhar,Chah Bahar,Chakhbekhar,Chāh Bahār,Czabahar,Tschahbahar,ZBR,bndr chabhar,cabahara,chabhar,chah bhar,qia he ba ha er,tshabhar,Çabahar,Čabahar,Čáhbahár,Чабахар,Чахбехар,Чҳобаҳор,بندر چابهار,تشابهار,چابهار,چابہار,چاه بهار,چاہ بہار,चाबहार,ਚਾਬਹਾਰ,恰赫巴哈爾', 'chabahar', 'Asia/Tehran', 47287, '25.2919', '60.643'),
(98543, 30, 1384, 'مامونیه', 'Mamuniyeh,Māmūnīyeh,mamwnyh,مامونیه', 'mamuniyeh', 'Asia/Tehran', 0, '35.30555', '50.4992'),
(98544, 30, 1369, 'دِهخوارِقان', 'Azarshahr,Dehkhvareqan,Dehkhvāreqān,adhrshhr,dihkhwariqan,Āz̄arshahr,آذرشهر,دِهخوارِقان', 'azarshahr', 'Asia/Tehran', 0, '37.759', '45.9783'),
(98545, 30, 1370, 'تازه آباد', 'Tazehabad,Tāzehābād,tazh abad,تازه آباد', 'tazehabad', 'Asia/Tehran', 0, '34.7387', '46.1496'),
(98546, 30, 1388, 'كاشان', 'Kachan,Kashan,Kāshān,kashan,كاشان', 'kashan', 'Asia/Tehran', 0, '33.99728', '51.44158'),
(98547, 30, 1380, 'جیرفت', 'JYR,Jiroft,Jīroft,Sabzawaran,Sabzevaran,Sabzevaran-e Jiroft,Sabzevārān,Sabzevārān-e Jiroft,Sabzvaran,Sabzvārān,Sabzāwārān,jyrft,جیرفت', 'jiroft', 'Asia/Tehran', 0, '28.67806', '57.74056'),
(98548, 30, 1380, 'رودبار', 'Eslamabad,Eslamabad-e Rudbar,Eslāmābād,Eslāmābād-e Rūdbār,Rudbar,Rūdbār,aslam abad,aslam abad rwdbar,rwdbar,اسلام آباد,اسلام آباد رودبار,رودبار', 'eslamabad', 'Asia/Tehran', 0, '28.02611', '58'),
(98550, 30, 1380, 'کهنوج', 'Kahnuj,Kahnūj,khnwj,کهنوج', 'kahnuj', 'Asia/Tehran', 0, '27.9519', '57.6996'),
(98551, 30, 1373, 'مهدیشهر', 'Mahdishahr,Sangsar,mhdyshhr,sngsr,سنگسر,مهدیشهر', 'mahdishahr', 'Asia/Tehran', 21000, '35.71071', '53.35394'),
(98552, 30, 1394, 'گلمورتی', 'Dalgan,Dalgān,Galmurti,Galmūrtī,dlgan,glmwrty,دلگان,گلمورتی', 'dalgan', 'Asia/Tehran', 0, '27.48232', '59.44656'),
(98553, 30, 1375, 'آق قلا', 'Aq Qal`eh,Aq Qala,Pahlavi Dezh,Pahlavi-dej,Pahlavī Dezh,Pahlevi Diz,aq qla,Āq Qalā,Āq Qal‘eh,آق قلا', 'aq-qala', 'Asia/Tehran', 0, '37.0139', '54.45504'),
(98554, 30, 1385, 'بندرامام', 'Bandar Imam,Bandar Imam Khomeini,Bandar Jomeiny,Bandar Sahpur,Bandar Šâhpur,Bandar-e Chomejni,Bandar-e Emam Khomeyni,Bandar-e Homeini,Bandar-e Imam Chomeini,Bandare Chomeinis,Bandare Emm Xomeyni,Bender Imam Humeyni,Bender İmam Humeyni,Bender-Imam-Khomejni,Bender-Khomejni,Bəndər İmam Xomeyni,QBR,bandaleueemamhomeini,bandara-e-imama khumeyani,bandare・emamu・homeini,bndr amam khmyny,bndramam khmyny,huo mei ni gang,mynaʾ alamam alkhmyny,Бендер-Імам-Хомейні,Бендер-Хомейни,بندر امام خمينى,بندر امام خمینی,بندرامام خمینی,ميناء الإمام الخميني,बंदर-ए-इमाम खुमेयनी,バンダレ・エマーム・ホメイニー,霍梅尼港,반다르에에맘호메이니', 'bandar-e-emam-khomeyni', 'Asia/Tehran', 0, '30.43698', '49.10288'),
(98555, 30, 1382, 'قائم شهر', 'Qa\'em Shahr,Qā’em Shahr,qaym shhr,قائم شهر', 'qa-em-shahr', 'Asia/Tehran', 0, '36.48144', '52.89109'),
(98556, 30, 1374, 'پاکدشت', 'Mamazan,Māmāzān,Pakdasht,Pākdasht,mamazan,pakdsht,مامازان,پاکدشت', 'pakdasht', 'Asia/Tehran', 0, '35.47854', '51.6834'),
(98557, 30, 1391, 'بشرویه', 'Bocruye,Boshruiyeh,Boshruyeh,Boshrūyeh,Boshrūīyeh,Bushruieh,Bushruiyeh,Bushrūīeh,Bushrūīyeh,bshrwyh,بشرویه', 'boshruyeh', 'Asia/Tehran', 0, '33.86845', '57.42885'),
(98558, 30, 1368, 'گیوی', 'Givi,Gīvī,gywy,گیوی', 'givi', 'Asia/Tehran', 0, '37.68585', '48.34204'),
(98559, 30, 1374, 'ری', 'Raj,Ray,Rayy,Rehj,Rei,Rej,Rejus,Rey,Rhagae,Rėjus,Shahr-e Rey,alry,lei yi,ry,shhr ry,Ρέι,Рей,Рэй,الري,رى,ری,رے,شهر ری,雷伊', 'rey', 'Asia/Tehran', 0, '35.59354', '51.43997'),
(98560, 30, 1381, 'بهاباد', 'Bahabad,Bahābād,Behabad,Behābād,bhabad,بهاباد', 'bahabad', 'Asia/Tehran', 0, '31.87091', '56.02433');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `iso` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contient` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_iso` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=MyISAM AUTO_INCREMENT=254 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `iso`, `contient`, `currency`, `currency_iso`, `slug`) VALUES
(30, 'ایران', 'IR', 'AS', 'Iranian Rial', 'IRR', 'iran');

-- --------------------------------------------------------

--
-- Table structure for table `countries_languages`
--

DROP TABLE IF EXISTS `countries_languages`;
CREATE TABLE IF NOT EXISTS `countries_languages` (
  `country_id` int(10) UNSIGNED NOT NULL,
  `language_id` int(11) DEFAULT NULL,
  KEY `country_id` (`country_id`),
  KEY `language_id` (`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries_languages`
--

INSERT INTO `countries_languages` (`country_id`, `language_id`) VALUES
(30, 43);

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

DROP TABLE IF EXISTS `favorites`;
CREATE TABLE IF NOT EXISTS `favorites` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `post_id` int(10) UNSIGNED DEFAULT NULL,
  `date` int(11) DEFAULT NULL,
  KEY `user_id` (`user_id`),
  KEY `post_id` (`post_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`user_id`, `post_id`, `date`) VALUES
(1, 19, 1660648807),
(1, 20, 1662542613);

-- --------------------------------------------------------

--
-- Table structure for table `fields`
--

DROP TABLE IF EXISTS `fields`;
CREATE TABLE IF NOT EXISTS `fields` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `type` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `required` int(11) DEFAULT '0',
  `search_type` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`) USING BTREE,
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fields`
--

INSERT INTO `fields` (`id`, `category_id`, `type`, `name`, `required`, `search_type`) VALUES
(1, 2, 'price', 'price', 0, 'range'),
(3, 7, 'year', 'year', 1, 'range'),
(4, 125, 'number', 'size', 1, 'range');

-- --------------------------------------------------------

--
-- Table structure for table `fields_options`
--

DROP TABLE IF EXISTS `fields_options`;
CREATE TABLE IF NOT EXISTS `fields_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `field_id` int(11) DEFAULT NULL,
  `label` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `field_id` (`field_id`)
) ENGINE=MyISAM AUTO_INCREMENT=141 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

DROP TABLE IF EXISTS `languages`;
CREATE TABLE IF NOT EXISTS `languages` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `english_name` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `iso` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `iso` (`iso`),
  KEY `status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=185 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `english_name`, `iso`, `status`) VALUES
(43, 'فارسی', 'Persian (Farsi)', 'fa', 0);

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

DROP TABLE IF EXISTS `logs`;
CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `access_id` int(10) UNSIGNED DEFAULT NULL,
  `ip` int(11) UNSIGNED DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `date` int(11) DEFAULT NULL,
  `last_update` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `access_id` (`access_id`),
  KEY `ip` (`ip`),
  KEY `type` (`type`),
  KEY `last_update` (`last_update`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `user_id`, `access_id`, `ip`, `type`, `user_agent`, `date`, `last_update`) VALUES
(1, 1, 1, 2130706433, 0, '\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/104.0.0.0 Safari\\/537.36\"', 1659803856, 1659816185),
(2, 1, 2, 2130706433, 0, '\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/104.0.0.0 Safari\\/537.36\"', 1660110843, 1660120903),
(3, 1, 3, 2130706433, 0, '\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/104.0.0.0 Safari\\/537.36\"', 1660323227, 1660422337),
(4, 1, 4, 2130706433, 0, '\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/104.0.0.0 Safari\\/537.36\"', 1660422963, 1660756374),
(5, 1, 5, 2130706433, 0, '\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/104.0.0.0 Safari\\/537.36\"', 1662388679, 1662393117),
(6, 1, 6, 2130706433, 0, '\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/104.0.0.0 Safari\\/537.36\"', 1662537991, 1662537991),
(7, 1, 7, 2130706433, 0, '\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/104.0.0.0 Safari\\/537.36\"', 1662538823, 1662550107),
(8, 2, 8, 2130706433, 0, '\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/104.0.0.0 Safari\\/537.36\"', 1662550725, 1662556269),
(9, 1, 9, 2130706433, 0, '\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/104.0.0.0 Safari\\/537.36\"', 1662556705, 1662561114);

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

DROP TABLE IF EXISTS `media`;
CREATE TABLE IF NOT EXISTS `media` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `post_id` int(10) UNSIGNED NOT NULL,
  `type` int(11) DEFAULT NULL,
  `path` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `width` int(11) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `post_id`, `type`, `path`, `thumbnail`, `width`, `height`) VALUES
(24, 20, 0, 'public/media/2022/09/90909481662539358.webp', 'public/thumbnail/2022/09/90909481662539358.webp', 500, 281),
(25, 20, 0, 'public/media/2022/09/82631481662539359.webp', 'public/thumbnail/2022/09/82631481662539359.webp', 500, 281);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `country_id` int(10) UNSIGNED DEFAULT NULL,
  `province_id` int(10) UNSIGNED DEFAULT NULL,
  `city_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `mail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `media_count` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `status` int(11) DEFAULT NULL,
  `date` int(11) DEFAULT NULL,
  `last_update` int(11) DEFAULT NULL,
  `renewal_date` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `status` (`status`,`city_id`,`date`),
  KEY `status_2` (`status`,`country_id`,`date`),
  KEY `renewal_date` (`renewal_date`),
  KEY `status_3` (`status`,`province_id`,`date`),
  KEY `media_count` (`media_count`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `country_id`, `province_id`, `city_id`, `user_id`, `title`, `content`, `mail`, `phone`, `media_count`, `status`, `date`, `last_update`, `renewal_date`) VALUES
(21, 30, 1369, 98432, 2, 'زمین 1500 متری در بناب', 'زمین در بناب', 'test2@test.com', '+989141111111', 0, 0, 1662550802, 1662556359, 1662550802),
(20, 30, 1374, 98158, 1, 'ملک 2356 متری در نیاوران', 'توضیحات ملک_br_متراژ 2564 متر مربع_br_', 'test@test.com', '+989121111111', 2, 0, 1662539358, 1662542211, 1662539358);

-- --------------------------------------------------------

--
-- Table structure for table `posts_categories`
--

DROP TABLE IF EXISTS `posts_categories`;
CREATE TABLE IF NOT EXISTS `posts_categories` (
  `post_id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  KEY `category_id` (`category_id`),
  KEY `_copy_1` (`post_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts_categories`
--

INSERT INTO `posts_categories` (`post_id`, `category_id`) VALUES
(20, 125),
(20, 2),
(21, 125),
(21, 2);

-- --------------------------------------------------------

--
-- Table structure for table `posts_stats`
--

DROP TABLE IF EXISTS `posts_stats`;
CREATE TABLE IF NOT EXISTS `posts_stats` (
  `post_id` int(10) UNSIGNED NOT NULL,
  `views` int(10) UNSIGNED DEFAULT NULL,
  `sended_mails` int(10) UNSIGNED DEFAULT NULL,
  `calls` int(10) UNSIGNED DEFAULT NULL,
  `date` int(11) DEFAULT NULL,
  KEY `post_id` (`post_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts_values`
--

DROP TABLE IF EXISTS `posts_values`;
CREATE TABLE IF NOT EXISTS `posts_values` (
  `post_id` int(10) UNSIGNED NOT NULL,
  `field_id` int(10) UNSIGNED DEFAULT NULL,
  `value` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  KEY `field_id` (`field_id`,`value`),
  KEY `_copy_1` (`post_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts_values`
--

INSERT INTO `posts_values` (`post_id`, `field_id`, `value`) VALUES
(20, 1, '1500000000'),
(20, 4, '500'),
(21, 4, '1500'),
(21, 1, '500000');

-- --------------------------------------------------------

--
-- Table structure for table `provinces`
--

DROP TABLE IF EXISTS `provinces`;
CREATE TABLE IF NOT EXISTS `provinces` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `country_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`) USING BTREE,
  KEY `country_id` (`country_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3808 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `provinces`
--

INSERT INTO `provinces` (`id`, `country_id`, `name`, `slug`) VALUES
(1365, 30, 'البرز', 'alborz'),
(1366, 30, 'قزوین', 'qazvin'),
(1367, 30, 'همدان', 'hamadan'),
(1368, 30, 'اردبیل', 'ardabil'),
(1369, 30, 'آذربایجان شرقی', 'east-azerbaijan'),
(1370, 30, 'کرمانشاه', 'kermanshah'),
(1371, 30, 'استان لرستان', 'lorestan-province'),
(1372, 30, 'خراسان رضوی', 'razavi-khorasan'),
(1373, 30, 'سمنان', 'semnan'),
(1374, 30, 'تهران', 'tehran'),
(1375, 30, 'گلستان', 'golestan'),
(1376, 30, 'گیلان', 'gilan'),
(1377, 30, 'زنجان', 'zanjan'),
(1378, 30, 'فارس', 'fars'),
(1379, 30, 'کهگیلویه و بویر احمد', 'kohgiluyeh-and-boyer-ahmad'),
(1380, 30, 'کرمان', 'kerman'),
(1381, 30, 'یزد', 'yazd'),
(1382, 30, 'مازندران', 'mazandaran'),
(1383, 30, 'آذربایجان غربی', 'west-azerbaijan'),
(1384, 30, 'مرکزی', 'markazi'),
(1385, 30, 'خوزستان', 'khuzestan'),
(1386, 30, 'خراسان جنوبی', 'north-khorasan'),
(1387, 30, 'چارمحال بختیاری', 'chaharmahal-and-bakhtiari'),
(1388, 30, 'اصفهان', 'isfahan'),
(1389, 30, 'کردستان', 'kordestan'),
(1390, 30, 'هرمزگان', 'hormozgan'),
(1391, 30, 'خراسان شمالی', 'south-khorasan-province'),
(1392, 30, 'ایلام', 'ilam'),
(1393, 30, 'قم', 'qom'),
(1394, 30, 'سیستان و بلوچستان', 'sistan-and-baluchestan'),
(1395, 30, 'بوشهر', 'bushehr');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

DROP TABLE IF EXISTS `reports`;
CREATE TABLE IF NOT EXISTS `reports` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` int(11) DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `post_id` int(10) UNSIGNED DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `_copy_1` (`post_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `searches`
--

DROP TABLE IF EXISTS `searches`;
CREATE TABLE IF NOT EXISTS `searches` (
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `query` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `date` int(11) DEFAULT NULL,
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `temporary`
--

DROP TABLE IF EXISTS `temporary`;
CREATE TABLE IF NOT EXISTS `temporary` (
  `reference` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `data` text COLLATE utf8mb4_unicode_ci,
  `date` int(11) DEFAULT NULL,
  `expire_date` int(11) DEFAULT NULL,
  PRIMARY KEY (`reference`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `mail` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `firstname` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_admin` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `ip` int(11) DEFAULT NULL,
  `date` int(11) DEFAULT NULL,
  `status` int(10) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mail` (`mail`),
  KEY `phone` (`phone`),
  KEY `date` (`date`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `mail`, `phone`, `firstname`, `lastname`, `password`, `is_admin`, `ip`, `date`, `status`) VALUES
(1, 'test@test.com', NULL, 'ali', 'heydari', 'otIjnKsg', 1, 2130706433, 1659803740, 0),
(2, 'test2@test.com', NULL, 'تست2', 'تست2', 'otIjnKsg', 0, 2130706433, 1662550725, 0);

-- --------------------------------------------------------

--
-- Table structure for table `verifications`
--

DROP TABLE IF EXISTS `verifications`;
CREATE TABLE IF NOT EXISTS `verifications` (
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` int(11) UNSIGNED DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `date` int(11) DEFAULT NULL,
  UNIQUE KEY `code` (`code`),
  KEY `email` (`email`),
  KEY `phone` (`phone`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--
ALTER TABLE `posts` ADD FULLTEXT KEY `title` (`title`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
