-- MySQL dump 10.13  Distrib 5.7.32, for Linux (x86_64)
--
-- Host: localhost    Database: ukm_id
-- ------------------------------------------------------
-- Server version	5.7.32-0ubuntu0.18.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `oauth_access_tokens`
--

DROP TABLE IF EXISTS `oauth_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_access_tokens` (
  `access_token` varchar(40) NOT NULL,
  `client_id` varchar(80) NOT NULL,
  `user_id` varchar(80) DEFAULT NULL,
  `expires` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `scope` varchar(4000) DEFAULT NULL,
  `request_token` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`access_token`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_access_tokens`
--

LOCK TABLES `oauth_access_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_access_tokens` DISABLE KEYS */;
INSERT INTO `oauth_access_tokens` VALUES ('76c44a937653372f22220275882e2a4e5b582999','testclient','46516256','2021-01-28 19:55:40',NULL,'abcdefg1111222'),('ad3e93d7782e92512e3bc77fec1a238382a4f021','testclient','46516256','2021-01-28 20:01:12',NULL,'abcdefg1111222');
/*!40000 ALTER TABLE `oauth_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_authorization_codes`
--

DROP TABLE IF EXISTS `oauth_authorization_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_authorization_codes` (
  `authorization_code` varchar(40) NOT NULL,
  `client_id` varchar(80) NOT NULL,
  `user_id` varchar(80) DEFAULT NULL,
  `redirect_uri` varchar(2000) DEFAULT NULL,
  `expires` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `scope` varchar(4000) DEFAULT NULL,
  `id_token` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`authorization_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_authorization_codes`
--

LOCK TABLES `oauth_authorization_codes` WRITE;
/*!40000 ALTER TABLE `oauth_authorization_codes` DISABLE KEYS */;
INSERT INTO `oauth_authorization_codes` VALUES ('400ed52d57cc0cecce7af3194c80e14510726a8a','testclient',NULL,NULL,'2020-12-16 13:19:23',NULL,NULL),('6339a046ac86c7c4bb8fc9a03428ae28d34ab666','testclient',NULL,NULL,'2020-12-16 13:31:38',NULL,NULL),('8373697ed217379e1bb09a2b4c1f1f9a370e3116','testclient',NULL,NULL,'2020-12-16 13:19:40',NULL,NULL);
/*!40000 ALTER TABLE `oauth_authorization_codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_clients`
--

DROP TABLE IF EXISTS `oauth_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_clients` (
  `client_id` varchar(80) NOT NULL,
  `client_secret` varchar(80) DEFAULT NULL,
  `redirect_uri` varchar(2000) DEFAULT NULL,
  `grant_types` varchar(80) DEFAULT NULL,
  `scope` varchar(4000) DEFAULT NULL,
  `user_id` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_clients`
--

LOCK TABLES `oauth_clients` WRITE;
/*!40000 ALTER TABLE `oauth_clients` DISABLE KEYS */;
INSERT INTO `oauth_clients` VALUES ('testclient','testpass','http://fake/',NULL,NULL,NULL);
/*!40000 ALTER TABLE `oauth_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_jwt`
--

DROP TABLE IF EXISTS `oauth_jwt`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_jwt` (
  `client_id` varchar(80) NOT NULL,
  `subject` varchar(80) DEFAULT NULL,
  `public_key` varchar(2000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_jwt`
--

LOCK TABLES `oauth_jwt` WRITE;
/*!40000 ALTER TABLE `oauth_jwt` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_jwt` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_refresh_tokens`
--

DROP TABLE IF EXISTS `oauth_refresh_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_refresh_tokens` (
  `refresh_token` varchar(40) NOT NULL,
  `client_id` varchar(80) NOT NULL,
  `user_id` varchar(80) DEFAULT NULL,
  `expires` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `scope` varchar(4000) DEFAULT NULL,
  PRIMARY KEY (`refresh_token`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_refresh_tokens`
--

LOCK TABLES `oauth_refresh_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_refresh_tokens` DISABLE KEYS */;
INSERT INTO `oauth_refresh_tokens` VALUES ('006e8e1a660c94aee19b9e3f56548d7ae4991a32','testclient',NULL,'2021-01-06 13:48:12',NULL),('00b95b7bee8b748bbe6164f170cbef585fba9510','testclient','46516256','2021-02-11 11:15:54',NULL),('0196c9d77f16eb553e539d74c29fdef8c86f515f','testclient','qwgqwwgwwehwqeqwgqwgqw1wqwq','2021-01-05 11:44:28',NULL),('028a35f6d6094d1302751f7040d2a07748e2a813','testclient','qwgqwwgwwehwqeqwgqwgqw1wqwq','2021-01-05 11:55:39',NULL),('03665b091f5d53f4d52704403432b05e7cd5961c','testclient',NULL,'2021-01-05 17:02:54',NULL),('078676f788e1320e5814d9b3139100f58ace12e8','testclient','qwgqwwgwwehwqeqwgqwgqw1wqwq','2021-01-05 11:51:41',NULL),('0a678013d246572c6fbc225b298079f0a4bb0f07','testclient','46516256','2021-02-11 18:50:57',NULL),('0bda581da41d74a16c88a37ad53d2df3f939fca3','testclient',NULL,'2021-01-05 17:02:52',NULL),('0cd6bc740729767e460c6c0b9933323df6a79edd','testclient','qwgqwwgwwehwqeqwgqwgqw1wqwq','2021-01-05 11:38:07',NULL),('0d6be7ec94e8814b84adc4e60b9d246235165d0e','testclient','ukm-test','2020-12-31 13:32:06',NULL),('0df57ebb2fa81a4555c7bc782c699f24dfaad805','testclient','46516256','2021-02-11 18:47:54',NULL),('0e544da476a3408e64647ee16b887bb68c78d5b2','testclient','ukm-test','2020-12-31 15:01:32',NULL),('0eb7e0606a89ed5b6b2455b1cd739be9e87593c4','testclient','qwgqwwgwwehwqeqwgqwgqw1wqwq','2021-01-05 11:50:52',NULL),('1009a201481ce5479c14d6829da8fd7c42ecc8fe','testclient',NULL,'2021-01-06 13:13:16',NULL),('13242af43f9b623bbad9e67e5e97d12ee23263da','testclient','bshaffer','2020-12-30 15:28:20',NULL),('15b568c57bd8757f115de6a297924fc0e5673336','testclient',NULL,'2021-01-06 13:18:11',NULL),('17d53105611f9dca7951b19917b1a905827d34b8','testclient','qwgqwwgwwehwqeqwgqwgqw1wqwq','2021-01-05 12:01:04',NULL),('18f897bdfa54441d187a7492856a4fcc55fdbc78','testclient','46516256','2021-01-26 16:51:27',NULL),('198c37d5d3f59f7099dbe0e7ccf3eed6575ed43c','testclient','ukm-test','2020-12-30 16:18:52',NULL),('1a0cb221a821ddd56aee08469921fdbda8a9d130','testclient','46516256','2021-02-11 11:04:16',NULL),('1b3ee66cae29e1a1e166a598e5316d6762df13c0','testclient','46516256','2021-02-11 16:49:26',NULL),('1b85dd424aa229a84e1baf1cfddbe07d54b7f386','testclient','46516256','2021-02-11 16:46:04',NULL),('1c34be4d6dc5acfc8c2e71dda2b876f8d18479e3','testclient','46516256','2021-02-11 16:03:52',NULL),('1c4f1ef8f9d348e007c26fe6d95508817c3da4c0','testclient','qwgqwwgwwehwqeqwgqwgqw1wqwq','2021-01-05 11:50:07',NULL),('1ce970cebd34d4003323505072331245b3483cfe','testclient',NULL,'2021-01-06 13:33:21',NULL),('20ff72d679db9f132d283cbb753eabe8468eafc5','testclient','+4711122444','2021-01-06 14:06:27',NULL),('212e9f5f7d1a1c1552d5d53655f3709235bd2986','testclient',NULL,'2021-01-06 13:19:48',NULL),('213877a329b85212d159a38734c7873fe5df1085','testclient',NULL,'2021-01-05 17:02:55',NULL),('2325f19befb479072f544124de549178da821fb7','testclient','46516256','2021-02-11 16:04:43',NULL),('23ee6645b8f719e51079f9478c413cdc6ad2e694','testclient','+4711122444','2021-01-06 14:02:31',NULL),('240f6f7e71e53d2469e0d39d818468234567d854','testclient','+4711122444','2021-01-06 13:53:52',NULL),('25e276e2c373421a44cd8ab44fc2f6fbd1cd3090','testclient',NULL,'2021-01-05 12:46:41',NULL),('268f2711164db249853d4a925f1bee143589e26b','testclient',NULL,'2021-01-05 16:49:27',NULL),('283e33c42e30ef3343fbdca151c6c7f7464aa9c9','testclient',NULL,'2021-01-06 12:14:23',NULL),('28e0840666c0d336e43c63c444f210af66ae0733','testclient',NULL,'2021-01-06 13:38:54',NULL),('2a2669d97adb7f7baf64ac86d57aa05287020e2a','testclient',NULL,'2021-01-05 16:47:51',NULL),('2b76a534c9cd0d56e7a60013bdea5208ee88dbc9','testclient','46516256','2021-01-26 17:42:59',NULL),('2bd25fd3df5847d39a3d0dbf6989c0c5f80df56d','testclient','qwgqwwgwwehwqeqwgqwgqw1wqwq','2021-01-04 17:46:55',NULL),('2e9fec27e63695876aa889f0853b30b804ac5535','testclient',NULL,'2021-01-05 18:43:07',NULL),('2f2a8f2f5ed94fb3b58c78cf2a835d1769abec41','testclient','ukm-test','2020-12-31 13:38:20',NULL),('2f30c31e6c6f0c47dcf04922325d89d883df9724','testclient','46516256','2021-01-28 18:36:58',NULL),('3102d2fb03fa8a6b80a622c6c0441ec850092e72','testclient',NULL,'2021-01-05 16:49:51',NULL),('314fd46978c66b523ee6ccc6cf6931fcdea73f8e','testclient',NULL,'2021-01-05 16:56:17',NULL),('31e0d112a436e9d16cff98ae93330eda3ff6f82a','testclient','+4711122444','2021-01-06 14:50:19',NULL),('3216853b51d500f9d3fe1508e1cb9d89b862d87a','testclient',NULL,'2021-01-06 13:40:28',NULL),('3287860a8b64d0093cf5dba98f561aad2f11f365','testclient','46516256','2021-01-26 17:01:03',NULL),('32b1fb3c5518c48eb1dd435403a58a1d26762860','testclient',NULL,'2021-01-06 13:01:45',NULL),('347538a669a8d20b15deb82c3b176f0e1f475f99','testclient','+4711122444','2021-01-06 14:19:06',NULL),('35bba1bbdccc8a4f6ca06854bc579fa15e33345c','testclient','+4711122444','2021-01-06 15:45:55',NULL),('361b20716e4da53a174b1f3ddfa370121ddf86b2','testclient',NULL,'2021-01-05 16:59:19',NULL),('363dacf1bcb61dc1ece7fa6b35a29370001641c1','testclient',NULL,'2021-01-06 13:27:13',NULL),('3658673b07ab8ac679e66ef0a1b9effacfb7a5de','testclient',NULL,'2021-01-05 16:58:31',NULL),('36e40f496fcfe8830e98d1752f28fe00e719e58a','testclient','ukm-test','2021-01-01 10:57:19',NULL),('37fc129c9bf89702032ccbecd179350658405a30','testclient','+4711122444','2021-01-06 14:08:41',NULL),('384441055150df00dd69f53affccf61363ae2018','testclient',NULL,'2021-01-06 13:42:17',NULL),('3884cdd2f86b3621f631c0f368fbad10586b6f97','testclient','+4711122444','2021-01-06 13:58:08',NULL),('39832241d4714b242e376dfdc3253551bb4f0be8','testclient','46516256','2021-02-11 18:53:28',NULL),('39b20812312dd08997da0443c1cfbc767ffacb3f','testclient','46516256','2021-02-11 18:55:30',NULL),('3ad50eba3b3c03050497566a1db9c0bb1fb46355','testclient','bshaffer','2020-12-30 15:03:20',NULL),('3b55fe8a847ebbf639134c8e849511c283ef05c8','testclient',NULL,'2021-01-05 16:59:26',NULL),('3c4f7dc6475c882f6bfca8a77baf88700a908c51','testclient',NULL,'2021-01-06 13:33:02',NULL),('3e3dfdc227fbdf2e1b3d70ebf700dc44d7df3ede','testclient',NULL,'2021-01-05 16:13:52',NULL),('3f582b1bf42ec815f9df0ff56753ecf89c4e5d8b','testclient',NULL,'2021-01-05 13:34:56',NULL),('40302dba9e8e88b6fdee7cfd5710f5d9e26366bc','testclient',NULL,'2021-01-06 14:25:37',NULL),('41e07e18358160ed54426adf71c8d8f6616d8431','testclient',NULL,'2021-01-05 18:43:05',NULL),('41e26ea7728e33e494005ca7ad085be3746410b4','testclient',NULL,'2021-01-05 16:50:09',NULL),('427c3c7d5334436a390106f8a450f73a1de08716','testclient','+4711122444','2021-01-06 14:24:50',NULL),('42c871186e98ad100fa739ea6a9cb42de6d918c5','testclient','qwgqwwgwwehwqeqwgqwgqw1wqwq','2021-01-05 11:40:03',NULL),('43dcc4343828381957534a59e4387c1878d9f0ba','testclient','qwgqwwgwwehwqeqwgqwgqw1wqwq','2021-01-05 11:45:35',NULL),('44c25cf82c1e69fc3818a31d469482f7e3810fcb','testclient','ukm-test','2021-01-01 10:38:41',NULL),('451cc0ae1f5c9f5f8699a1accc95f50725183d76','testclient','46516256','2021-02-09 12:34:41',NULL),('4600799fc74c5e41ae8debf5a550104aa814b732','testclient','46516256','2021-02-11 11:01:43',NULL),('4a261dca19ab6764f96e5ab398f861e1fb5d0bb7','testclient','46516256','2021-02-11 16:03:32',NULL),('4add15756b70f58f81abf852ac04c41cfc354078','testclient','46516256','2021-02-11 16:03:22',NULL),('4b500176b6d955e1fa4831b7a31084e11164ffa6','testclient',NULL,'2021-01-05 16:15:20',NULL),('4bbbcb440f18bf8161a3563b324cca235b554db2','testclient',NULL,'2021-01-05 12:46:39',NULL),('4c6db7c02732fcc4af5ffaadef88eedc6d6ff94c','testclient','46516256','2021-01-28 14:53:05',NULL),('4ffd4b1e2a7085cb410e9b22251bf8cc64b4f0f9','testclient','+4711122444','2021-01-06 13:43:29',NULL),('501245f8937ac4870e4ecbd343b612a376da4ee4','testclient',NULL,'2021-01-05 13:35:03',NULL),('501a2f0e06a155a16fea0b0265d91e9fbcecd9bb','testclient','+4711122444','2021-01-06 15:47:28',NULL),('51bdc844f1a5bc617554ded2320cbe871676b6cd','testclient','qwgqwwgwwehwqeqwgqwgqw1wqwq','2021-01-04 17:43:06',NULL),('525396ddef9c0490c34ddee2dfdb451c674d96d1','testclient',NULL,'2021-01-05 13:34:55',NULL),('53239a30f932e30264aa2da1cf50943a1e1e2028','testclient','46516256','2021-02-11 16:12:05',NULL),('536b5cdd00d2ec12e785bcd19d2f4d1a48adb1a1','testclient','ukm-test','2020-12-31 13:52:12',NULL),('53c4a0c6ba0c8365b14e37466af0cf8ec2ea89fe','testclient',NULL,'2021-01-06 12:14:22',NULL),('5507f3f275e4e8da43b6616b9275794e83416ff5','testclient','46516256','2021-02-11 11:15:40',NULL),('55224c049d78a1a5a56507ce591a22bd5bfea81b','testclient','qwgqwwgwwehwqeqwgqwgqw1wqwq','2021-01-05 11:42:27',NULL),('560b9e3fda5e02018508e0222db785acd9aba851','testclient','46516256','2021-02-11 11:18:54',NULL),('56319ac68b358c03e4af078ab6c287ac8a38afe7','testclient','46516256','2021-02-11 11:08:26',NULL),('565037ba19a2a1f2263ce0048b5e2970d330c8af','testclient',NULL,'2021-01-06 13:54:59',NULL),('56ae292a999a3e00db57ef945c3d61afe7e2c408','testclient','ukm-test','2020-12-31 13:54:40',NULL),('5792cc67ca261d2913311fd3064fb0777e6d2dba','testclient',NULL,'2021-01-05 16:53:39',NULL),('5947eb5883803e0351942f5eef650da68b4746e7','testclient','46516256','2021-02-11 18:53:52',NULL),('59c937c17c5519190dce9968b9d1929e5c7b95ee','testclient',NULL,'2021-01-05 13:11:01',NULL),('5b6d95cb1f6c749ada8c777f715245d18547d68c','testclient',NULL,'2021-01-05 17:02:54',NULL),('5e0448a13e7062c97c3edba9c86cd359899d6546','testclient','bshaffer','2020-12-30 15:10:25',NULL),('5fac164e808d6a97c739d08659842718540cc25d','testclient','+4711122444','2021-01-06 14:19:48',NULL),('6104e718367729d8a1a0e6985114d9dbb8861708','testclient','+4711122444','2021-01-06 13:51:40',NULL),('620bc32ef6004162a8ad098277d02e777b3fdd13','testclient','ukm-test','2020-12-30 15:54:42',NULL),('627b1b3d84e8adade43929178960580f19a7b095','testclient','46516256','2021-02-11 13:19:28',NULL),('6398faa544e5a84fbf39c9828b912d12b22930ac','testclient','+4711122444','2021-01-06 14:19:15',NULL),('63f91101b3970cc778a125de69149988afc7f046','testclient','ukm-test','2020-12-31 15:41:58',NULL),('64f09e006f3b95b4cfddfd7ca2c24cdc742e947b','testclient',NULL,'2021-01-05 16:48:12',NULL),('651734f2bc266c53b818fa1adf9ba8493e518868','testclient','ukm-test','2020-12-30 16:21:39',NULL),('65c32097cb9b646e3a0ff937054db5477028d455','testclient','qwgqwwgwwehwqeqwgqwgqw1wqwq','2021-01-05 11:46:34',NULL),('6935af9661dacca5c9938188a4f2e7142810b754','testclient',NULL,'2021-01-05 16:00:37',NULL),('694f1bb905e631f9a718ca344fd46f28067e9d09','testclient','ukm-test','2020-12-31 15:41:56',NULL),('698ee46bd57391188c85f314a8850423acfaa8e6','testclient','ukm-test','2020-12-31 16:57:24',NULL),('6a606ca84369e0c46af6a04573ed6b21e2e670de','testclient',NULL,'2021-01-06 13:59:26',NULL),('6ba37acc10efe4e72eddd96f0d7bcc4f0c0c9b32','testclient','+4711122444','2021-01-06 13:54:04',NULL),('6e527b7c77cf3c81847f4ad193793104a3f5c2a7','testclient','qwgqwwgwwehwqeqwgqwgqw1wqwq','2021-01-05 11:44:20',NULL),('6ec01bdad5104d113c0a46e4c761b4f0e2089fec','testclient','46516256','2021-02-11 11:15:33',NULL),('6f63d9d865d39f41ec6ca7887fb761ee3a32815c','testclient','qwgqwwgwwehwqeqwgqwgqw1wqwq','2021-01-01 15:18:41',NULL),('7221631636968712f6cb95a23abf3a76d1dd0578','testclient','qwgqwwgwwehwqeqwgqwgqw1wqwq','2021-01-05 11:32:58',NULL),('733422ba777c98331e919e604e55bab27baf97bc','testclient','+4711122444','2021-01-06 14:06:47',NULL),('747c58f89b6d02f0c626469adf0b7314dbc36a88','testclient','qwgqwwgwwehwqeqwgqwgqw1wqwq','2021-01-05 11:45:32',NULL),('78e3b06ebed392b882dba46ce27b4d3b5a851085','testclient','46516256','2021-02-11 16:06:41',NULL),('7e2e2b0f5fceacf3e1e360226c8628cf8c3581bd','testclient',NULL,'2021-01-05 16:48:17',NULL),('7e89785d23be391347d033a17e22e40495189705','testclient','46516256','2021-02-11 11:08:29',NULL),('7fdad5db2a850310108ee29a6a4acf006b7b594e','testclient','qwgqwwgwwehwqeqwgqwgqw1wqwq','2021-01-05 11:53:57',NULL),('808930966baf2560836073c974776e18b3c7b12c','testclient','+4711122444','2021-01-06 14:20:00',NULL),('80d6de6d7f016ce6889ad53c17a3b50010cd1441','testclient','bshaffer','2020-12-30 15:26:47',NULL),('80f7ef79c57b9751884029fbcbea060ee9038e63','testclient',NULL,'2021-01-05 16:59:42',NULL),('82b587974fc74f78e09680b189871426a7293af8','testclient','ukm-test','2020-12-31 15:53:45',NULL),('8324297e1c0a0e6608e670e8cbcbe31daa6b3722','testclient','+4746516256','2021-01-19 11:00:43',NULL),('83370b2bdbe4c39c331b6d36bd9e2eaad5242879','testclient','46516256','2021-02-11 18:52:54',NULL),('8383b798d01503fa4b08ecb8f008141148fe92ed','testclient','46516256','2021-02-11 11:00:41',NULL),('846de75553ec1c88c85ed850d69da6b3f7699b61','testclient','qwgqwwgwwehwqeqwgqwgqw1wqwq','2021-01-04 17:39:10',NULL),('863fbd0eaeabfb201d4754115df6c2e508545ccd','testclient','+4711122444','2021-01-06 13:58:41',NULL),('86c940f2c88a79ee23c3d406319faaaa5aa95458','testclient','bshaffer','2020-12-30 15:26:55',NULL),('86d0c5946fe15e8478b6382d4107185781935471','testclient','bshaffer','2020-12-30 15:26:41',NULL),('87c5a4c2b6c6e3c8410502cf1d6905a9d6b60acb','testclient','46516256','2021-02-11 11:15:44',NULL),('88d22df7c2ce437722156c047e2e56e0bfd7e499','testclient','qwgqwwgwwehwqeqwgqwgqw1wqwq','2021-01-05 11:50:26',NULL),('88edaf180cc982e666c7107fbea6422a8eab69ec','testclient','46516256','2021-02-11 16:04:03',NULL),('8a3ce549ccff1d30975d9fe3a029bb0418ef875c','testclient',NULL,'2021-01-05 12:46:38',NULL),('8bb35425b74d30deca24b34afae752ef04fb3f05','testclient','46516256','2021-01-26 15:24:45',NULL),('8c90d79f577f72a30631a78ee53b8aa1382dd26a','testclient','46516256','2021-01-26 17:28:55',NULL),('8de4efdf6af65daeb729545992a60ff9b13cf2b4','testclient','+4711122444','2021-01-06 16:09:48',NULL),('8e7e02566f52f8e3d695c2734499e846bad91710','testclient','+4711122444','2021-01-06 13:36:17',NULL),('8eb9caf6ceaf95d978956ad996301eaddf1f6583','testclient','46516256','2021-02-11 18:50:50',NULL),('9010c60bb453d257a868fc9ea2f42102b7d1a2bf','testclient','46516256','2021-02-11 11:08:11',NULL),('90d4a6e3a04dfb546f94adc3792f0f77e9962395','testclient',NULL,'2021-01-05 12:46:41',NULL),('91258b2b8b3da8ba5010bc5f14da21b87371c94c','testclient','46516256','2021-02-11 16:03:13',NULL),('9199dcbf6221960798e3944eff4420e73c191c0e','testclient',NULL,'2021-01-05 18:43:07',NULL),('932ee018694effb0c626731d8634d79b56ff746a','testclient',NULL,'2021-01-06 14:17:41',NULL),('9420ef348be75ca4e5c9a1debedf26c6fff34e20','testclient',NULL,'2021-01-05 16:49:29',NULL),('94ed6c44b0c89a95fd72a292662a11bfd7ef33f0','testclient','46516256','2021-02-11 11:02:08',NULL),('95623bd62e5a2b33b9a0b509803371ae9681c827','testclient','46516256','2021-01-26 16:52:22',NULL),('978f2e8d87f6417ac740d9897d88f7fdaa206d52','testclient',NULL,'2021-01-05 13:08:52',NULL),('98619ce97b7a4ac9d19f732ef13110320e9d0c9f','testclient','ukm-test','2021-01-01 10:24:08',NULL),('9ab84ced2716e8edc200fcb889a8863f2d79c8fe','testclient',NULL,'2021-01-05 12:46:40',NULL),('9c307063171d9af6c38a27ca748662d677686097','testclient',NULL,'2021-01-05 16:12:38',NULL),('9c49bce2f695200330111ab5d14d3665e29e065f','testclient','qwgqwwgwwehwqeqwgqwgqw1wqwq','2021-01-05 11:32:29',NULL),('9da838ad528063a4cdfe0abcc2676157ad6c47b4','testclient',NULL,'2021-01-06 14:02:53',NULL),('9df9dc498701ec76d49a808e5653fd125aa1b422','testclient','+4711122444','2021-01-06 13:59:42',NULL),('9f39340663302aef1870bf8c9b107f21a6fb91e0','testclient',NULL,'2021-01-05 16:50:01',NULL),('a0ef1c1f1b8cdbc4e1f632fe1867198b073ffd22','testclient','ukm-test','2021-01-01 10:38:37',NULL),('a149ecb71f0f50c93e8b66a79ce93ca54afd1a41','testclient','bshaffer','2020-12-30 15:28:31',NULL),('a233b246fdd1758fe61d1736829dbdd5e0992490','testclient',NULL,'2021-01-06 13:37:27',NULL),('a2cc31ed9a857f7cc5e65b70f0000160074af9eb','testclient','+4711122444','2021-01-06 13:41:05',NULL),('a31f5dc410e65454344fc1399c4c589b6007d1b7','testclient',NULL,'2021-01-05 17:02:55',NULL),('a32337ac69ece28353b54911bcc6cb225f78c38d','testclient','46516256','2021-02-11 16:03:34',NULL),('a47321f4e801732bab91d76bcdffb4c7d5bc132f','testclient',NULL,'2021-01-05 12:10:00',NULL),('a616fedf046c1849d031637c45f10833d09a959d','testclient','bshaffer','2020-12-30 15:26:54',NULL),('a6bd7fd0af5d9735965e2edcfe922b29f1941f61','testclient','qwgqwwgwwehwqeqwgqwgqw1wqwq','2021-01-05 12:01:07',NULL),('a70742e2a9357f1941c58a64c0d964f856451fa9','testclient','ukm-test','2020-12-31 13:32:05',NULL),('a7e2be60669ea2dff4566b4df626fc4d7d6efa68','testclient',NULL,'2021-01-05 17:02:55',NULL),('a8bbc5105a19afd4cfab28394eee3140f6ebdc3c','testclient','qwgqwwgwwehwqeqwgqwgqw1wqwq','2021-01-05 11:45:03',NULL),('a9e0d441dc970d771f9d15aaa090d2364598c3b0','testclient','+4711122444','2021-01-06 13:38:04',NULL),('a9f855a4c94fc623ee0b966c861e2e9b2622ed32','testclient','ukm-test','2020-12-31 16:56:11',NULL),('ab6aeb8fb4a2a681233ddfe81077ff37d62b7b24','testclient',NULL,'2021-01-06 13:46:02',NULL),('ac27bf7b600e133f7ff7fb081ef4859eaaafd920','testclient','qwgqwwgwwehwqeqwgqwgqw1wqwq','2021-01-05 11:52:12',NULL),('ac75f7964612519c6c3de6bda714c99b975adb2d','testclient',NULL,'2021-01-05 16:53:34',NULL),('acabd5b89f791a4547a22edefd28b0279cbe0d63','testclient','46516256','2021-02-11 18:54:37',NULL),('afa85e3f6e66f94d0c6d0a6428478803026c2305','testclient',NULL,'2021-01-05 16:59:20',NULL),('afd9a3cab680eef758303b8ff32e869709098b89','testclient',NULL,'2021-01-05 12:16:33',NULL),('afe4ba69c5b11417a34f49387ef6e0f7f3b84537','testclient',NULL,'2021-01-05 15:44:33',NULL),('b021faada4d8133aa7ea2c201383baec729f59c2','testclient','ukm-test','2020-12-31 13:38:21',NULL),('b06e3a90347901d183aa2b4bd5d2b4eba1d33888','testclient',NULL,'2021-01-06 14:19:38',NULL),('b138abb1036cb6c88d987cb78a7ee867a551cfa4','testclient','46516256','2021-02-11 16:48:20',NULL),('b161ae182f36f2472aa87cfdbae9c61e06b817d5','testclient',NULL,'2021-01-05 13:34:35',NULL),('b25cec24a075bfe6defd58eb7c36f2aa4e587d46','testclient',NULL,'2021-01-05 17:02:55',NULL),('b2f26b655a00e832d845630fa952100ac213ef86','testclient','qwgqwwgwwehwqeqwgqwgqw1wqwq','2021-01-05 11:46:06',NULL),('b356c17049a1fa858a09d0621f23e4551d1ffe8c','testclient','46516256','2021-01-26 17:28:54',NULL),('b3cd9fbf16a321e5309e388dbfa4054707e159e8','testclient',NULL,'2021-01-05 13:02:41',NULL),('b48956e19f9845a15ef4788d01e47b02969a8da3','testclient',NULL,'2021-01-05 16:50:02',NULL),('b6453d26bcdab3c9cead1e350769c5790e068475','testclient',NULL,'2021-01-05 19:01:30',NULL),('b6bdbac401a040df3fcd476f53b4ede97d71428c','testclient','bshaffer','2020-12-30 15:25:42',NULL),('b813840a1f8b98752a309daff0192e6d85360d12','testclient','46516256','2021-02-11 16:02:54',NULL),('b83a823323071105fe24365eb6b7230573f5322d','testclient','qwgqwwgwwehwqeqwgqwgqw1wqwq','2021-01-05 11:34:48',NULL),('badec97a843e6f5917c112ddd8a06762be7bd01c','testclient','qwgqwwgwwehwqeqwgqwgqw1wqwq','2021-01-05 12:03:00',NULL),('bb58e843ca663db9c420e37fef84dfd502896efd','testclient',NULL,'2021-01-06 14:03:00',NULL),('bc3b8ae3ee2bfaba7ff80bd287cc63c151f92af5','testclient',NULL,'2021-01-06 14:26:18',NULL),('bc7d1aa12cfb3d3d1e1e9ab0c0c0c1e04cc2b8e7','testclient','+4711122444','2021-01-06 14:27:21',NULL),('bd2157990571eeac8d023552e9e8ab466df254b1','testclient','46516256','2021-02-11 11:16:42',NULL),('bd7826b6f10bb2feceab61b29a6de15033548492','testclient',NULL,'2021-01-05 17:01:43',NULL),('bddb852366fce16ffe778fc8dff256851c2df402','testclient','+4711122444','2021-01-06 14:05:55',NULL),('bdfe4043f6c922367bbe9eed27e2f6454091fb7d','testclient','bshaffer','2020-12-30 15:26:55',NULL),('be7d203158b206bb3b7db4fcf3d9f0fc6c38b31e','testclient','qwgqwwgwwehwqeqwgqwgqw1wqwq','2021-01-05 11:38:29',NULL),('be7dc8de014df0470c3b5343361db7bf76d4fcab','testclient',NULL,'2021-01-05 17:02:24',NULL),('be89bea403996907d5fea315a34d6ad1adb4c53f','testclient',NULL,'2021-01-05 18:50:54',NULL),('bf93c4f5ec1e3bce92b3c3ae10ca4f5e46f9728c','testclient',NULL,'2021-01-06 12:14:16',NULL),('bfd5f889573f77f07bd98417d61fcce76aa58090','testclient',NULL,'2021-01-06 14:17:29',NULL),('c16be4f410c53e707aa09ba5d505fe792704bb4b','testclient','ukm-test','2021-01-01 10:25:25',NULL),('c186f3929bab2f827e1be01dc16b1458d21e05df','testclient','+4711122444','2021-01-12 13:06:37',NULL),('c32141966e195f96767cae48a97f29c5cd1ea0d3','testclient','+4711122444','2021-01-06 14:22:49',NULL),('c34c736d273af060519b186c3cb3e865ad38d75d','testclient','qwgqwwgwwehwqeqwgqwgqw1wqwq','2021-01-05 11:28:23',NULL),('c3d66516662ac5b2b05520df1b4e86d4cbed8410','testclient','46516256','2021-02-11 11:21:40',NULL),('c4944b9c6ad6adec6a40aa08c6f21b7e87363a06','testclient',NULL,'2021-01-05 17:00:25',NULL),('c4d672af7c2929a6dbe4f3dd19730d48386136d7','testclient',NULL,'2021-01-06 14:38:00',NULL),('c6ddd994f5272c5b4a31a56b99198bdadff164cb','testclient','qwgqwwgwwehwqeqwgqwgqw1wqwq','2021-01-05 11:53:10',NULL),('c7e3166a8062dd862b45a31d3288016501805e9a','testclient','46516256','2021-01-28 14:49:47',NULL),('c7fe7cd4dfc6ba0747c4298a4e8ca6619bf22362','testclient','qwgqwwgwwehwqeqwgqwgqw1wqwq','2021-01-05 11:54:32',NULL),('c83844043d6929de989d1af70af635dab1a7a243','testclient',NULL,'2021-01-05 12:43:42',NULL),('c9afc3fd4dd02183579560571d58bebaf5e75d82','testclient',NULL,'2021-01-06 13:59:03',NULL),('cab446ae136718e62c5da37495f1998394d0d6f7','testclient','bshaffer','2020-12-30 15:26:45',NULL),('cad1eb987074fb93529084c5242aa56487014bb0','testclient',NULL,'2021-01-05 16:57:25',NULL),('cb0e7f557b925121e5bd5d4261eadd2f0a566ca9','testclient',NULL,'2021-01-06 13:17:44',NULL),('cd6d580fcc5f4397abd1c6a7488276ae894e4a3e','testclient','46516256','2021-02-11 18:55:40',NULL),('d24d6635814a6c864061554f7a1ee406e8ff4b65','testclient','46516256','2021-02-11 19:01:12',NULL),('d30b1d6e5aa55e3c36fea628040ad3cce933b40b','testclient','bshaffer','2020-12-30 15:28:21',NULL),('d7dfa7dbc04ec44c16e6f6909bbc413af031fd0e','testclient','qwgqwwgwwehwqeqwgqwgqw1wqwq','2021-01-05 11:52:31',NULL),('d8ea89bce0d0ee12d78a21b5725b60915f0b6fa3','testclient',NULL,'2021-01-05 16:47:41',NULL),('dc287c62be2104b10d5db90b59a3d019ba4ae105','testclient','+4746516256','2021-01-19 11:03:22',NULL),('dc307d1c38b6c9eed46c13b88e2c1f7967f2948a','testclient','ukm-test','2020-12-31 13:32:03',NULL),('dd57ae35f487869b37b01c035d38ee108498dcc8','testclient',NULL,'2021-01-06 13:33:45',NULL),('df521e5a0f64d38e69a67546e656de1dc186297d','testclient',NULL,'2021-01-05 18:43:06',NULL),('dff005e6ccf7690579511f31bb7bf901853da7bb','testclient',NULL,'2021-01-06 13:26:29',NULL),('e00c92eac9f7cca21df89f23f7a75ad488c68ab1','testclient',NULL,'2021-01-05 13:11:29',NULL),('e0437712fe3359d7d4acce5aea0e559a849aec7a','testclient','+4711122444','2021-01-06 13:54:29',NULL),('e075357a40ba858cff9850bf8751a1566821db35','testclient',NULL,'2021-01-05 16:14:05',NULL),('e092152a4d09c4fc98d86d863f96b8043624beed','testclient','46516256','2021-02-11 11:04:02',NULL),('e0acd70092e8e31faf496385604840726be49857','testclient','46516256','2021-02-11 13:19:31',NULL),('e12f34ecab0e1a049e290df1699be5ec8e65098e','testclient',NULL,'2021-01-05 16:15:18',NULL),('e1b3532edc80f3baf9790f704c04da1872e18ae9','testclient',NULL,'2021-01-05 16:58:37',NULL),('e1fc4e457c710617b3c86cfa90e0b659bd4f2d0b','testclient',NULL,'2021-01-05 18:48:27',NULL),('e432fc727c7be69f4417850f8bc93ee3899b3168','testclient',NULL,'2021-01-05 16:13:43',NULL),('e541961132f73bd04df083d4d76aae79e8c05ddc','testclient','ukm-test','2020-12-31 13:38:02',NULL),('e5fbf3d2548937950f14337a917eac0e199ef70f','testclient','46516256','2021-02-11 16:02:57',NULL),('e673694487b78fa096fc5d2a761e81822ee269e9','testclient','+4711122444','2021-01-06 14:27:11',NULL),('e9dcb3290bb1d35607a7f1091303ea6d92012813','testclient',NULL,'2021-01-06 13:45:22',NULL),('ea9e6cf97e78373541b0966afa526746afefbe5a','testclient',NULL,'2021-01-05 16:12:03',NULL),('ecf5644ce04a9416b20e3ee4f12e567db96ec3e8','testclient','qwgqwwgwwehwqeqwgqwgqw1wqwq','2021-01-05 11:57:20',NULL),('ed17514656af427190448646d0b5aee8923d4467','testclient',NULL,'2021-01-05 13:32:07',NULL),('ee59b94c7b4f96ac527a8e0888e7ad500014ff54','testclient','46516256','2021-02-11 16:02:22',NULL),('ee67951a74994c8339050d4c1374e20c88719fcf','testclient','qwgqwwgwwehwqeqwgqwgqw1wqwq','2021-01-05 12:01:06',NULL),('ef4b2eb2364480f10584b6242299e8dfba74e556','testclient','+4711122444','2021-01-06 14:06:13',NULL),('ef6a55a8a7f5e8c3c1ae130ab1702ee88371dc0b','testclient','46516256','2021-02-11 11:04:39',NULL),('ef8a2a27d27b59d5c8cb86c501dada546099bdd5','testclient','ukm-test','2020-12-31 16:24:14',NULL),('efc925a06ee1b5978e5c6f8efc995a29d0d39a18','testclient','46516256','2021-01-28 15:41:00',NULL),('effc6ed700bce9983806f03e49a8ff543d8cd25a','testclient',NULL,'2021-01-05 16:48:40',NULL),('f0b7e3390ac9bde6cc140ce07c4d50720bc50e5c','testclient','qwgqwwgwwehwqeqwgqwgqw1wqwq','2021-01-05 12:00:14',NULL),('f2f4735b6459dba716e0a6a7cee0646338134baf','testclient',NULL,'2021-01-06 13:03:27',NULL),('f42753b35d9c708320734c4d178c8aaefa5e0123','testclient','bshaffer','2020-12-30 15:26:53',NULL),('f4da8876582d1dba90bc4dd9a9628b3c11362529','testclient',NULL,'2021-01-05 16:13:22',NULL),('f5122dd668cb6abeb094f25b667d1bb5c0ddb5f6','testclient','46516256','2021-02-11 11:08:13',NULL),('f71d85a038f072dbd01270f3fc6a4678c5b7ed3a','testclient',NULL,'2021-01-05 18:50:55',NULL),('f7757462d683395b3228a4877a83d1c6a0561c9d','testclient','qwgqwwgwwehwqeqwgqwgqw1wqwq','2021-01-05 11:42:19',NULL),('f903c344f3cc2637086d22f9bc5e04ec0e5e7c67','testclient','46516256','2021-02-11 16:15:21',NULL),('fb621dcddb5d11c6e3e1c2d2089dfca797a3b2dd','testclient','+4711122444','2021-01-06 13:58:23',NULL),('fc202171b780bf4bf3f2934fbbe05a1033679bea','testclient','46516256','2021-02-11 11:02:24',NULL),('fccb8060a0b40c357598e9bd88abeef9cdd0922e','testclient',NULL,'2021-01-05 16:48:21',NULL),('fff3f6676c86c113da5504db22585a3759d3e30c','testclient','46516256','2021-01-28 15:39:27',NULL);
/*!40000 ALTER TABLE `oauth_refresh_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_scopes`
--

DROP TABLE IF EXISTS `oauth_scopes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_scopes` (
  `scope` varchar(80) NOT NULL,
  `is_default` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`scope`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_scopes`
--

LOCK TABLES `oauth_scopes` WRITE;
/*!40000 ALTER TABLE `oauth_scopes` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_scopes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_users`
--

DROP TABLE IF EXISTS `oauth_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_users` (
  `tel_nr` varchar(80) NOT NULL,
  `password` varchar(80) DEFAULT NULL,
  `first_name` varchar(80) DEFAULT NULL,
  `last_name` varchar(80) DEFAULT NULL,
  `tel_nr_verified` tinyint(1) DEFAULT NULL,
  `scope` varchar(4000) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `facebook_id` int(11) DEFAULT NULL,
  `tel_country_code` varchar(10) DEFAULT NULL,
  `vilkaar` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`tel_nr`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_users`
--

LOCK TABLES `oauth_users` WRITE;
/*!40000 ALTER TABLE `oauth_users` DISABLE KEYS */;
INSERT INTO `oauth_users` VALUES ('46516256','$2y$10$5SQh6kuqHhBA2QHJuYIsu.S7hpTzITvIrE9CYoS9nrPUMVHfq0if2','Kushtrim','Aliu',1,NULL,'1992-05-11',NULL,'+47',1);
/*!40000 ALTER TABLE `oauth_users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-01-28 18:05:46
