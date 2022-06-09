-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Jun 01, 2022 at 10:21 AM
-- Server version: 10.6.5-MariaDB-1:10.6.5+maria~focal
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `advisorreport_db`
--
CREATE DATABASE IF NOT EXISTS `advisorreport_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `advisorreport_db`;

-- --------------------------------------------------------

--
-- Table structure for table `tb_comment`
--

DROP TABLE IF EXISTS `tb_comment`;
CREATE TABLE `tb_comment` (
  `comment_id` int(11) NOT NULL COMMENT 'รหัสปัญหาและอุปสรรค',
  `comment_text` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ปัญหาและอุปสรรค',
  `wp_id` int(11) NOT NULL COMMENT 'รหัสรายงาน'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ตาราง : ปัญหาและอุปสรรค';

--
-- Dumping data for table `tb_comment`
--

INSERT INTO `tb_comment` (`comment_id`, `comment_text`, `wp_id`) VALUES
(1, '6', 1),
(2, '9', 2),
(3, 'asdfasdfasdfasdf', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tb_event`
--

DROP TABLE IF EXISTS `tb_event`;
CREATE TABLE `tb_event` (
  `event_id` int(11) NOT NULL COMMENT 'รหัสกิจกรรมเสริม',
  `event_text` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'กิจกรรมเสริม',
  `wp_id` int(11) NOT NULL COMMENT 'รหัสรายงาน\n'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ตาราง : กิจกรรมเสริม';

--
-- Dumping data for table `tb_event`
--

INSERT INTO `tb_event` (`event_id`, `event_text`, `wp_id`) VALUES
(1, '6', 1),
(2, '9', 2),
(3, 'adsfadssafadsf', 2),
(4, 'asdfasdfadsf', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tb_field`
--

DROP TABLE IF EXISTS `tb_field`;
CREATE TABLE `tb_field` (
  `field_id` int(11) NOT NULL COMMENT 'รหัสสาขาวิชา',
  `field_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ชื่อสาขาวิชา'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ตาราง : สาขาวิชา';

--
-- Dumping data for table `tb_field`
--

INSERT INTO `tb_field` (`field_id`, `field_name`) VALUES
(1, 'สาขาวิชาการจัดการ'),
(2, 'สาขาวิชาการบัญชี'),
(3, 'สาขาวิชาการตลาดดิจิทัล'),
(4, 'สาขาวิชาการท่องเที่ยวและการโรงแรม'),
(5, 'สาขาวิชาเศรษฐศาสตร์'),
(6, 'สาขาวิชานิเทศศาสตร์ดิจิทัล'),
(7, 'สาขาวิชาคอมพิวเตอร์ธุรกิจดิจิทัล'),
(8, 'สาขาวิชาการเงิน'),
(9, 'สาขาวิชาการจัดการโลจิสติกส์และซัพพลายเชน'),
(10, 'สาขาจัดการธุรกิจการค้าสมัยใหม่');

-- --------------------------------------------------------

--
-- Table structure for table `tb_groupstu`
--

DROP TABLE IF EXISTS `tb_groupstu`;
CREATE TABLE `tb_groupstu` (
  `groupstu_id` int(11) NOT NULL COMMENT 'รหัสหมู่เรียน',
  `groupstu_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ชื่อหมู่เรียน',
  `field_id` int(11) NOT NULL COMMENT 'รหัสสาขา\n',
  `user_id` int(11) NOT NULL COMMENT 'รหัสผู้ใช้ (อาจารย์)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ตาราง : หมู่เรียน';

--
-- Dumping data for table `tb_groupstu`
--

INSERT INTO `tb_groupstu` (`groupstu_id`, `groupstu_name`, `field_id`, `user_id`) VALUES
(1, 'หมู่เรียนทดสอบ 1', 7, 2),
(2, 'หมู่เรียนทดสอบ 2', 7, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tb_role`
--

DROP TABLE IF EXISTS `tb_role`;
CREATE TABLE `tb_role` (
  `role_id` int(11) NOT NULL COMMENT 'รหัสสิทธิ์เข้าใช้งาน',
  `role_name` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ชื่อสิทธิ์เข้าใช้งาน'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ตาราง : ข้อมูลสิทธิ์การใช้งาน';

--
-- Dumping data for table `tb_role`
--

INSERT INTO `tb_role` (`role_id`, `role_name`) VALUES
(1, 'ผู้ดูแลระบบ/เจ้าหน้าที่'),
(2, 'อาจารย์'),
(3, 'ผู้บริหาร');

-- --------------------------------------------------------

--
-- Table structure for table `tb_student_problems`
--

DROP TABLE IF EXISTS `tb_student_problems`;
CREATE TABLE `tb_student_problems` (
  `student_problems_id` int(11) NOT NULL COMMENT 'รหัสสรุปปัญหาและแนวทางแก้ไข',
  `student_problems_problem` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'ปัญหา',
  `student_problems_solution` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'แนวทางแก้ไข',
  `wp_id` int(11) NOT NULL COMMENT 'รหัสรายงาน'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ตาราง : สรุปปัญหาของนักศึกษาและแนวทางแก้ไข';

--
-- Dumping data for table `tb_student_problems`
--

INSERT INTO `tb_student_problems` (`student_problems_id`, `student_problems_problem`, `student_problems_solution`, `wp_id`) VALUES
(1, '6', '6', 1),
(2, '9', '9', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tb_student_problem_no`
--

DROP TABLE IF EXISTS `tb_student_problem_no`;
CREATE TABLE `tb_student_problem_no` (
  `student_problem_no_id` int(11) NOT NULL COMMENT 'รหัสสรุปปัญหาที่ไม่สามารถแก้ไขได้',
  `student_problem_no_problem` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ปัญหา',
  `wp_id` int(11) NOT NULL COMMENT 'รหัสรายงาน\n'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ตาราง : สรุปปัญหาของนักศึกษาที่ไม่สามารถแก้ไขได้';

--
-- Dumping data for table `tb_student_problem_no`
--

INSERT INTO `tb_student_problem_no` (`student_problem_no_id`, `student_problem_no_problem`, `wp_id`) VALUES
(1, '6', 1),
(2, '9', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tb_timereport`
--

DROP TABLE IF EXISTS `tb_timereport`;
CREATE TABLE `tb_timereport` (
  `timereport_id` int(11) NOT NULL COMMENT 'รหัสช่วงเวลา',
  `timereport_year` int(50) NOT NULL COMMENT 'ปีการศึกษา',
  `timereport_term` int(50) NOT NULL COMMENT 'เทอม',
  `timereport_status` int(30) NOT NULL DEFAULT 1 COMMENT 'สถานะ 1= ดำเนินการ 2 = ปีที่ผ่านมา',
  `timereport_start_month` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'เริ่มตั้งแต่เดือน',
  `timereport_end_month` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ถึงเดือน',
  `timereport_name` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'ช่วงเวลา'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ตาราง : ช่วงเวลา';

--
-- Dumping data for table `tb_timereport`
--

INSERT INTO `tb_timereport` (`timereport_id`, `timereport_year`, `timereport_term`, `timereport_status`, `timereport_start_month`, `timereport_end_month`, `timereport_name`) VALUES
(1, 2564, 1, 2, 'พฤศจิกายน 2563', 'มีนาคม 2564', '16 พฤศจิกายน 2563 - 20 มีนาคม 2564'),
(2, 2564, 2, 1, 'มิถุนายน 2564', 'ตุลาคม 2564', '6 มิถุนายน 256 - 10 ตุลาคม 2564');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

DROP TABLE IF EXISTS `tb_user`;
CREATE TABLE `tb_user` (
  `user_id` int(11) NOT NULL COMMENT 'รหัสผู้ใช้',
  `user_username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ชื่อผู้ใช้',
  `user_password` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'รหัสผ่าน',
  `user_title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'คำนำหน้าชื่อ',
  `user_fname` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ชื่อ',
  `user_lname` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'นาสกุล',
  `user_position` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ตำแหน่ง',
  `user_address` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ที่อยู่',
  `user_tel` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'เบอร์โทรศัพท์',
  `user_email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'อีเมล์',
  `role_id` int(11) NOT NULL COMMENT '1 = ผู้ดูแลระบบ/เจ้าหน้าที่ \n2 = อาจารย์ \n3 = ผู้บริหาร',
  `field_id` int(11) DEFAULT NULL COMMENT 'รหัสสาขา',
  `uset_status` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT 'สถานะการใช้งาน\n1 = ใช้งานปกติ\n0 = ระงับใช้งาน\n'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ตาราง : ผู้ใช้';

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`user_id`, `user_username`, `user_password`, `user_title`, `user_fname`, `user_lname`, `user_position`, `user_address`, `user_tel`, `user_email`, `role_id`, `field_id`, `uset_status`) VALUES
(1, 'admin', '25d55ad283aa400af464c76d713c07ad', 'นาย', 'สมควร', 'ผู้ดูแลระบบ', 'เจ้าหน้าที่ธุรการ', 'อ.เมือง จ.เลย', '0777777777', 'admin@mail.com', 1, NULL, '1'),
(2, 'advisor', '25d55ad283aa400af464c76d713c07ad', 'ดร.', 'สมศักดิ์', 'อาจารย์', 'อาจารย์ประจำคณะ', 'อ.เมือง จ.เลย', '0888888888', 'advisor@mail.com', 2, 7, '1'),
(3, 'manager', '25d55ad283aa400af464c76d713c07ad', 'รศ.ดร.', 'สมหญิง', 'ผู้บริหาร', 'อธิการบดี', 'อ.เมือง จ.เลย', '0999999999', 'manager@mail.com', 3, NULL, '1');

-- --------------------------------------------------------

--
-- Table structure for table `tb_workreport`
--

DROP TABLE IF EXISTS `tb_workreport`;
CREATE TABLE `tb_workreport` (
  `wp_id` int(11) NOT NULL COMMENT 'รหัสรายงานการปฏิบัติหน้าที่',
  `wp_start_male` int(2) DEFAULT NULL COMMENT 'จำนวนนักศึกษาต้นภาคเรียน (ชาย)',
  `wp_start_female` int(2) DEFAULT NULL COMMENT 'จำนวนนักศึกษาต้นภาคเรียน (หญิง)',
  `wp_start_sum` int(11) NOT NULL COMMENT 'รวมเริ่มต้น',
  `wp_break` int(2) DEFAULT NULL COMMENT 'หยุดพักการเรียน',
  `wp_quit` int(2) DEFAULT NULL COMMENT 'ลาออก',
  `wp_out` int(2) DEFAULT NULL COMMENT 'พ้นสภาพ',
  `wp_died` int(2) DEFAULT NULL COMMENT 'เสียชีวิต',
  `wp_died_text` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'สาเหตุเสียชีวิต',
  `wp_no_contact` int(2) DEFAULT NULL COMMENT 'ติดต่อไม่ได้',
  `wp_end_male` int(2) DEFAULT NULL COMMENT 'จำนวนนักศึกษาสิ้นภาคเรียน (ชาย)',
  `wp_end_female` int(2) DEFAULT NULL COMMENT 'จำนวนนักศึกษาสิ้นภาคเรียน (หญิง)',
  `wp_end_sum` int(11) NOT NULL COMMENT 'รวมคงเหลือ',
  `wp_scholarship` int(2) DEFAULT NULL COMMENT 'ทุนกู้ยืมทางการศึกษา',
  `wp_scholarship_other` int(2) DEFAULT NULL COMMENT 'ทุนอื่น ๆ ',
  `wp_event` int(2) DEFAULT NULL COMMENT 'เข้าร่วมกิจกรรม',
  `wp_glorification` int(2) DEFAULT NULL COMMENT 'เชิดชูเกียรติ',
  `wp_lowgrade` int(2) DEFAULT NULL COMMENT 'ผลการเรียนต่ำกว่า 2.00',
  `wp_meeting` int(2) DEFAULT NULL COMMENT 'เข้าพบในชั่วโมงที่ปรึกษา',
  `wp_counsel` int(2) DEFAULT NULL COMMENT 'ปรึกษารายบุคคล (คน)',
  `wp_counsel_count` int(2) DEFAULT NULL COMMENT 'ปรึกษารายบุคคล (ครั้ง)',
  `wp_createdate` datetime NOT NULL COMMENT 'วันเวลาที่สร้างข้อมูล',
  `teacher_id` int(11) NOT NULL COMMENT 'รหัสผู้ใช้ (อาจารย์)',
  `timereport_id` int(11) NOT NULL COMMENT 'รหัสช่วงเวลา',
  `groupstu_id` int(11) NOT NULL COMMENT 'รหัสหมู่เรียน',
  `field_id` int(11) NOT NULL COMMENT 'รหัสสาขาวิชา',
  `manager_id` int(11) DEFAULT NULL COMMENT 'รหัสผู้ใช้ (ผู้อนุมัติ ผู้บริหาร)\n',
  `wp_approveddate` datetime DEFAULT NULL COMMENT 'วันที่อนุมัติ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ตาราง : รายงานปฏิบัติหน้าที่';

--
-- Dumping data for table `tb_workreport`
--

INSERT INTO `tb_workreport` (`wp_id`, `wp_start_male`, `wp_start_female`, `wp_start_sum`, `wp_break`, `wp_quit`, `wp_out`, `wp_died`, `wp_died_text`, `wp_no_contact`, `wp_end_male`, `wp_end_female`, `wp_end_sum`, `wp_scholarship`, `wp_scholarship_other`, `wp_event`, `wp_glorification`, `wp_lowgrade`, `wp_meeting`, `wp_counsel`, `wp_counsel_count`, `wp_createdate`, `teacher_id`, `timereport_id`, `groupstu_id`, `field_id`, `manager_id`, `wp_approveddate`) VALUES
(1, 6, 6, 6, 6, 6, 66, 6, '6', 6, 66, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, '2022-05-31 20:42:44', 2, 2, 1, 7, 3, '2022-05-31 20:43:52'),
(2, 9, 9, 9, 9, 9, 9, 9, '9', 99, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, '2022-05-31 20:43:15', 2, 2, 2, 7, 3, '2022-05-31 20:43:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_comment`
--
ALTER TABLE `tb_comment`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `fk_tb_comment_tb_workreport1_idx` (`wp_id`);

--
-- Indexes for table `tb_event`
--
ALTER TABLE `tb_event`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `fk_tb_event_tb_workreport1_idx` (`wp_id`);

--
-- Indexes for table `tb_field`
--
ALTER TABLE `tb_field`
  ADD PRIMARY KEY (`field_id`);

--
-- Indexes for table `tb_groupstu`
--
ALTER TABLE `tb_groupstu`
  ADD PRIMARY KEY (`groupstu_id`),
  ADD KEY `fk_tb_groupstu_tb_field1_idx` (`field_id`),
  ADD KEY `fk_tb_groupstu_tb_user1_idx` (`user_id`);

--
-- Indexes for table `tb_role`
--
ALTER TABLE `tb_role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `tb_student_problems`
--
ALTER TABLE `tb_student_problems`
  ADD PRIMARY KEY (`student_problems_id`),
  ADD KEY `fk_tb_student_problems_tb_workreport1_idx` (`wp_id`);

--
-- Indexes for table `tb_student_problem_no`
--
ALTER TABLE `tb_student_problem_no`
  ADD PRIMARY KEY (`student_problem_no_id`),
  ADD KEY `fk_tb_student_problem_no_tb_workreport1_idx` (`wp_id`);

--
-- Indexes for table `tb_timereport`
--
ALTER TABLE `tb_timereport`
  ADD PRIMARY KEY (`timereport_id`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `fk_tb_user_tb_role_idx` (`role_id`),
  ADD KEY `fk_tb_user_tb_field1_idx` (`field_id`);

--
-- Indexes for table `tb_workreport`
--
ALTER TABLE `tb_workreport`
  ADD PRIMARY KEY (`wp_id`),
  ADD KEY `fk_tb_workreport_tb_user1_idx` (`teacher_id`),
  ADD KEY `fk_tb_workreport_tb_timereport1_idx` (`timereport_id`),
  ADD KEY `fk_tb_workreport_tb_groupstu1_idx` (`groupstu_id`),
  ADD KEY `fk_tb_workreport_tb_field1_idx` (`field_id`),
  ADD KEY `fk_tb_workreport_tb_user2_idx` (`manager_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_comment`
--
ALTER TABLE `tb_comment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสปัญหาและอุปสรรค', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_event`
--
ALTER TABLE `tb_event`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสกิจกรรมเสริม', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_field`
--
ALTER TABLE `tb_field`
  MODIFY `field_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสสาขาวิชา', AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tb_groupstu`
--
ALTER TABLE `tb_groupstu`
  MODIFY `groupstu_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสหมู่เรียน', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_student_problems`
--
ALTER TABLE `tb_student_problems`
  MODIFY `student_problems_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสสรุปปัญหาและแนวทางแก้ไข', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_student_problem_no`
--
ALTER TABLE `tb_student_problem_no`
  MODIFY `student_problem_no_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสสรุปปัญหาที่ไม่สามารถแก้ไขได้', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_timereport`
--
ALTER TABLE `tb_timereport`
  MODIFY `timereport_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสช่วงเวลา', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสผู้ใช้', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_workreport`
--
ALTER TABLE `tb_workreport`
  MODIFY `wp_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสรายงานการปฏิบัติหน้าที่', AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_comment`
--
ALTER TABLE `tb_comment`
  ADD CONSTRAINT `fk_tb_comment_tb_workreport1` FOREIGN KEY (`wp_id`) REFERENCES `tb_workreport` (`wp_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tb_event`
--
ALTER TABLE `tb_event`
  ADD CONSTRAINT `fk_tb_event_tb_workreport1` FOREIGN KEY (`wp_id`) REFERENCES `tb_workreport` (`wp_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tb_groupstu`
--
ALTER TABLE `tb_groupstu`
  ADD CONSTRAINT `fk_tb_groupstu_tb_field1` FOREIGN KEY (`field_id`) REFERENCES `tb_field` (`field_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tb_groupstu_tb_user1` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tb_student_problems`
--
ALTER TABLE `tb_student_problems`
  ADD CONSTRAINT `fk_tb_student_problems_tb_workreport1` FOREIGN KEY (`wp_id`) REFERENCES `tb_workreport` (`wp_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tb_student_problem_no`
--
ALTER TABLE `tb_student_problem_no`
  ADD CONSTRAINT `fk_tb_student_problem_no_tb_workreport1` FOREIGN KEY (`wp_id`) REFERENCES `tb_workreport` (`wp_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD CONSTRAINT `fk_tb_user_tb_field1` FOREIGN KEY (`field_id`) REFERENCES `tb_field` (`field_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tb_user_tb_role` FOREIGN KEY (`role_id`) REFERENCES `tb_role` (`role_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tb_workreport`
--
ALTER TABLE `tb_workreport`
  ADD CONSTRAINT `fk_tb_workreport_tb_field1` FOREIGN KEY (`field_id`) REFERENCES `tb_field` (`field_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tb_workreport_tb_groupstu1` FOREIGN KEY (`groupstu_id`) REFERENCES `tb_groupstu` (`groupstu_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tb_workreport_tb_timereport1` FOREIGN KEY (`timereport_id`) REFERENCES `tb_timereport` (`timereport_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tb_workreport_tb_user1` FOREIGN KEY (`teacher_id`) REFERENCES `tb_user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tb_workreport_tb_user2` FOREIGN KEY (`manager_id`) REFERENCES `tb_user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
