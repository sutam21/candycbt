/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

DROP TABLE IF EXISTS `materi`;
CREATE TABLE IF NOT EXISTS `materi` (
  `id_materi` int(255) NOT NULL AUTO_INCREMENT,
  `id_guru` int(255) NOT NULL DEFAULT 0,
  `kelas` text NOT NULL,
  `mapel` varchar(255) NOT NULL,
  `judul` varchar(50) NOT NULL,
  `materi` longtext DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `tgl_mulai` datetime NOT NULL,
  `youtube` varchar(255) DEFAULT NULL,
  `tgl` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_materi`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `materi` DISABLE KEYS */;
INSERT INTO `materi` (`id_materi`, `id_guru`, `kelas`, `mapel`, `judul`, `materi`, `file`, `tgl_mulai`, `youtube`, `tgl`, `status`) VALUES
	(6, 1, 'a:2:{i:0;s:6:"XITKJA";i:1;s:5:"XTKJB";}', 'KIMIA', 'hjhjhjh', '<p>&lt;iframe width="560" height="315" src="https://www.youtube.com/embed/t9FtOJBJJ3c" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen&gt;&lt;/iframe&gt;</p>', NULL, '2020-04-23 09:20:00', NULL, '2020-04-23 18:23:40', 1),
	(7, 1, 'a:1:{i:0;s:5:"XTKJB";}', 'KIMIA', 'TEST', '<p><iframe width="560" height="315" src="https://www.youtube.com/embed/t9FtOJBJJ3c" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></p>', 'Daftar hadir piket.xlsx', '2020-04-23 18:00:00', NULL, '2020-04-23 18:40:29', 1),
	(8, 1, 'a:1:{i:0;s:5:"semua";}', 'KIMIA', 'aaaaaaa', '', NULL, '2020-04-24 04:00:00', 'https://www.youtube.com/embed/t9FtOJBJJ3c', '2020-04-24 04:39:19', NULL),
	(9, 260, 'a:1:{i:0;s:5:"semua";}', 'KIMIA', 'NEW CANDY 2.5', '<p>200000000</p>', NULL, '2020-04-24 05:00:00', '', '2020-04-24 05:01:06', NULL),
	(10, 260, 'a:1:{i:0;s:5:"semua";}', 'KIMIA', 'test', '<p>teststtstst</p>', NULL, '2020-04-24 09:19:00', '', '2020-04-24 09:19:17', NULL);
/*!40000 ALTER TABLE `materi` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
