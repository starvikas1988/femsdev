-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 24, 2023 at 04:31 AM
-- Server version: 10.1.40-MariaDB
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `femsdev`
--

-- --------------------------------------------------------
--
-- Table structure for table `qa_norther_tools_equipment_feedback`
--

CREATE TABLE `qa_norther_tools_equipment_feedback` (
  `id` int(11) NOT NULL,
  `audit_date` date DEFAULT NULL,
  `agent_id` int(11) DEFAULT NULL,
  `tl_id` int(11) DEFAULT NULL,
  `call_date` date DEFAULT NULL,
  `audit_type` varchar(100) DEFAULT NULL,
  `auditor_type` varchar(10) DEFAULT NULL,
  `call_duration` text,
  `interaction_id` varchar(100) DEFAULT NULL,
  `manager` varchar(50) DEFAULT NULL,
  `call_number` bigint(20) DEFAULT NULL,
  `voc` tinyint(4) DEFAULT NULL,
  `overall_score` float DEFAULT NULL,
  `earned_score` int(11) DEFAULT NULL,
  `possible_score` int(11) DEFAULT NULL,
  `customer_earned_score` int(11) DEFAULT NULL,
  `business_earned_score` int(11) DEFAULT NULL,
  `compliance_earned_score` int(11) DEFAULT NULL,
  `customer_possible_score` int(11) DEFAULT NULL,
  `business_possible_score` int(11) DEFAULT NULL,
  `compliance_possible_score` int(11) DEFAULT NULL,
  `customer_overall_score` float DEFAULT NULL,
  `business_overall_score` float DEFAULT NULL,
  `compliance_overall_score` float DEFAULT NULL,
  
  `opening_call` varchar(10) DEFAULT NULL,
  `active_listening` varchar(10) DEFAULT NULL,
  `positive_tone` varchar(10) DEFAULT NULL,
  `positive_language` varchar(10) DEFAULT NULL,
  `acknowledgements_timely` varchar(10) DEFAULT NULL,
  `rate_of_speech` varchar(10) DEFAULT NULL,
  `effective_engagement` varchar(10) DEFAULT NULL,
  `handle_call` varchar(10) DEFAULT NULL,
  `acknowledged_queries` varchar(10) DEFAULT NULL,
  `internal_processes` varchar(10) DEFAULT NULL,
  `avoided_overlapping` varchar(10) DEFAULT NULL,
  `follow_up_instructions` varchar(10) DEFAULT NULL,
  `hold_policy` varchar(10) DEFAULT NULL,
  `dead_air` varchar(10) DEFAULT NULL,
  `hold_verbiage` varchar(10) DEFAULT NULL,
  `professionalism` varchar(10) DEFAULT NULL,
  `further_queries` varchar(10) DEFAULT NULL,
  `close_call` varchar(10) DEFAULT NULL,
  `cmt1` text,
  `cmt2` text,
  `cmt3` text,
  `cmt4` text,
  `cmt5` text,
  `cmt6` text,
  `cmt7` text,
  `cmt8` text,
  `cmt9` text,
  `cmt10` text,
  `cmt11` text,
  `cmt12` text,
  `cmt13` text,
  `cmt14` text,
  `cmt15` text,
  `cmt16` text,
  `cmt17` text,
  `cmt18` text,
  `call_summary` text,
  `feedback` text,
  `attach_file` text,
  `entry_by` int(11) DEFAULT NULL,
  `entry_date` datetime DEFAULT NULL,
  `audit_start_time` datetime DEFAULT NULL,
  `client_entryby` int(11) DEFAULT NULL,
  `mgnt_rvw_by` int(11) DEFAULT NULL,
  `mgnt_rvw_note` text,
  `mgnt_rvw_date` datetime DEFAULT NULL,
  `agent_rvw_note` text,
  `agnt_fd_acpt` varchar(20) DEFAULT NULL,
  `agent_rvw_date` datetime DEFAULT NULL,
  `client_rvw_by` int(11) DEFAULT NULL,
  `client_rvw_note` text,
  `client_rvw_date` datetime DEFAULT NULL,
  `log` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `qa_norther_tools_equipment_feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `agent_id` (`agent_id`),
  ADD KEY `tl_id` (`tl_id`),
  ADD KEY `entry_by` (`entry_by`),
  ADD KEY `client_entryby` (`client_entryby`),
  ADD KEY `mgnt_rvw_by` (`mgnt_rvw_by`),
  ADD KEY `client_rvw_by` (`client_rvw_by`),
  ADD KEY `audit_date` (`audit_date`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `qa_norther_tools_equipment_feedback`
--
ALTER TABLE `qa_norther_tools_equipment_feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

--
-- Dumping data for table `qa_norther_tools_equipment_feedback`
--

INSERT INTO `qa_norther_tools_equipment_feedback` (`id`, `audit_date`, `agent_id`, `tl_id`, `call_date`, `audit_type`, `auditor_type`, `call_duration`, `manager`, `call_number`, `voc`, `overall_score`, `earned_score`, `possible_score`, `customer_earned_score`, `business_earned_score`, `compliance_earned_score`, `customer_possible_score`, `business_possible_score`, `compliance_possible_score`, `customer_overall_score`, `business_overall_score`, `compliance_overall_score`, `opening_call`, `active_listening`, `positive_tone`, `positive_language`, `acknowledgements_timely`, `rate_of_speech`, `effective_engagement`, `handle_call`, `acknowledged_queries`, `internal_processes`, `avoided_overlapping`, `follow_up_instructions`, `hold_policy`, `dead_air`, `hold_verbiage`, `professionalism`, `further_queries`, `close_call`, `cmt1`, `cmt2`, `cmt3`, `cmt4`, `cmt5`, `cmt6`, `cmt7`, `cmt8`, `cmt9`, `cmt10`, `cmt11`, `cmt12`, `cmt13`, `cmt14`, `cmt15`, `cmt16`, `cmt17`, `cmt18`, `call_summary`, `feedback`, `attach_file`, `entry_by`, `entry_date`, `audit_start_time`, `client_entryby`, `mgnt_rvw_by`, `mgnt_rvw_note`, `mgnt_rvw_date`, `agent_rvw_note`, `agnt_fd_acpt`, `agent_rvw_date`, `client_rvw_by`, `client_rvw_note`, `client_rvw_date`, `log`) VALUES
(1, '2023-04-13', 17583, 7731, '2023-04-13', 'CQ Audit', '', '16:26:00', 'sougata', 8876787676, 3, 100, 100, 100, 77, 12, 11, 77, 12, 11, 100, 100, 100, 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'remark1', 'remark2', 'Remark3', 'Remark4', 'Remark5', 'Remark6', 'Remark7', 'Remark8', 'Remark9', 'Remark10', 'Remark11', 'Remark12', 'Remark13', 'Remark14', 'Remark15', 'Remark16', 'Remark17', 'Remark18', 'erert', 'ertert', 'file_vishal_MP3_700KB1.mp3', 1, '2023-04-13 07:06:35', '2023-04-13 07:05:40', NULL, 1, 'KIIO', '2023-04-13 07:21:49', 'ok jjjj', 'Acceptance', '2023-04-13 08:21:18', NULL, NULL, NULL, NULL);

(2, '2023-04-17', 17583, 7731, '2023-04-17', 'Calibration', 'Regular', '00:00:22675757577575757575757657', 'dffds', 'ewrwerwer', 'jghgng', 'Agent', 665, 'hghgj', 'jgjghjg', 2424242444, 6, 100, 100, 100, 77, 12, 11, 77, 12, 11, 100, 100, 100, 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, 8359, '2023-04-17 10:15:58', '2023-04-17 06:21:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, '2023-04-17', 17583, 7731, '2023-04-17', 'Calibration', 'Regular', '00:00:22675757577575757575757657', 'dffds', 'ewrwerwer', 'jghgng', 'Agent', 665, 'hghgj', 'jgjghjg', 2424242444, 6, 100, 100, 100, 77, 12, 11, 77, 12, 11, 100, 100, 100, 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, 8359, '2023-04-17 10:15:59', '2023-04-17 06:21:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, '2023-04-18', 7758, 7731, '2023-04-18', 'Pre-Certificate Mock Call', NULL, '00:15:09', 'type of call', 'customer name', 'cancellation', 'Agent', 100, 'L1', 'L2', 9876543210, 4, 100, 100, 100, 77, 12, 11, 77, 12, 11, 100, 100, 100, 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'sample-mp4-file-small.mp4', 8359, '2023-04-18 01:23:29', '2023-04-18 01:09:53', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, '2023-04-18', 7758, 7731, '2023-04-18', 'Certification Audit', NULL, '00:00:50', 'type', 'customer name', 'cancellation', 'Customer', 665, 'le', 'lf', 987654321, 4, 100, 100, 100, 77, 12, 11, 77, 12, 11, 100, 100, 100, 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'nn', 'nn', 'sample-3s1.mp3', 8359, '2023-04-18 01:32:37', '2023-04-18 01:25:10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, '2023-04-18', 17583, 7731, '2023-04-18', 'CQ Audit', NULL, '32214214142353534552', 'today 2', 'customer name', 'jghgng', 'Agent', 665, 'L1', 'L2', 9876543210, 1, 0, 99, 100, 77, 12, 10, 77, 12, 10, 100, 100, 100, 'Pass', 'Pass', 'Fail', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'dfdsfds', 'sfsafafafasf', 'Thu_Dec_29_2022_13_19_41_GMT+0530_(India_Standard_Time)_wav.mp3', 8359, '2023-04-18 01:40:39', '2023-04-18 01:38:15', NULL, 23, 'changed ', '2023-04-18 02:22:41', 'accepted', 'Acceptance', '2023-04-18 01:48:51', NULL, NULL, NULL, NULL),
(7, '2023-04-18', 7758, 7731, '2023-04-18', 'BQ Audit', NULL, '00:00:47', 'today', 'cust', 'cancellation', 'NA', 100, 'L1', 'L2', 9876543210, 4, 0, 63, 100, 60, 2, 1, 60, 2, 1, 100, 100, 100, 'Fail', 'Fail', 'Pass', 'Fail', 'Fail', 'Pass', 'Pass', 'Pass', 'Fail', 'Fail', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'c', 'f', 'sample-3s2.mp3', 8359, '2023-04-18 01:57:37', '2023-04-18 01:55:22', NULL, 23, 'anshu', '2023-04-18 02:17:18', 'na', 'Not Acceptance', '2023-04-18 02:06:18', NULL, NULL, NULL, NULL),
(8, '2023-04-18', 7758, 7731, '2023-04-18', 'Calibration', 'Master', '00:32:00', 'today 2', 'dsf', 'cancellation', 'Process', 665, 'L1', 'L2', 9876543210, 3, 100, 100, 100, 77, 12, 11, 77, 12, 11, 100, 100, 100, 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'remarks', 'remarks', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, 8359, '2023-04-18 03:36:53', '2023-04-18 03:30:24', NULL, 23, 'r', '2023-04-18 03:37:52', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, '2023-04-19', 17583, 7731, '2023-04-19', 'CQ Audit', NULL, '16:26:00', 'test11', 'sougata', 'ok', 'Agent', 2, 'ertgege', 'erter', 8876787676, 2, 100, 100, 100, 77, 12, 11, 77, 12, 11, 100, 100, 100, 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'ertet', 'ertert', NULL, 1, '2023-04-19 04:17:42', '2023-04-19 04:16:41', NULL, NULL, NULL, NULL, 'okk', 'Acceptance', '2023-04-19 08:57:32', NULL, NULL, NULL, NULL),
(10, '2023-04-19', 17583, 7731, '2023-04-19', 'Calibration', 'Master', '16:26:00', 'test11', 'sougata', 'ok', 'Agent', 4, 'ertgege', 'erter', 8876787676, 7, 100, 100, 100, 77, 12, 11, 77, 12, 11, 100, 100, 100, 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'fsfsdf', 'dsfsd', NULL, 1, '2023-04-19 06:46:02', '2023-04-19 06:45:07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, '2023-04-19', 17583, 7731, '2023-04-19', 'CQ Audit', NULL, '16:21:32', 'test call', 'Krishna', 'ykflu', 'Agent', 2, 'ryryrtyr', 'yiyiyyuoyo', 8876787676, 5, 100, 100, 100, 77, 12, 11, 77, 12, 11, 100, 100, 100, 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'khgkhgh', 'hgkgkg', 'sample-1.m4a', 1, '2023-04-19 06:52:33', '2023-04-19 06:51:20', NULL, 1, 'okk', '2023-04-19 06:53:42', 'okk', 'Acceptance', '2023-04-19 06:58:21', NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `qa_norther_tools_equipment_feedback`
--


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
