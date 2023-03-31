-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 30, 2023 at 02:48 AM
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
-- Table structure for table `qa_hcci_core_feedback`
--

CREATE TABLE `qa_hcci_core_feedback` (
  `id` int(11) NOT NULL,
  `audit_date` date DEFAULT NULL,
  `agent_id` int(11) DEFAULT NULL,
  `tl_id` int(11) DEFAULT NULL,
  `call_date` date DEFAULT NULL,
  `audit_type` varchar(100) DEFAULT NULL,
  `auditor_type` varchar(10) DEFAULT NULL,
  `call_duration` text,
  `call_file` varchar(100) DEFAULT NULL,
  `sr_no` varchar(50) DEFAULT NULL,
  `consumer_no` bigint(20) DEFAULT NULL,
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
  
  `brand` varchar(10) DEFAULT NULL,
  `issue_identification` varchar(10) DEFAULT NULL,
  `issue_resolution` varchar(10) DEFAULT NULL,
  `identify_verification` varchar(10) DEFAULT NULL,
  `situational_policy` varchar(10) DEFAULT NULL,
  `strategic_Cross_Sale_Offered` varchar(10) DEFAULT NULL,
  `call_Beginning` varchar(10) DEFAULT NULL,
  `call_Control` varchar(10) DEFAULT NULL,
  `pace` varchar(10) DEFAULT NULL,
  `holds` varchar(10) DEFAULT NULL,
  `dash_Documentation` varchar(10) DEFAULT NULL,
  `disposition_Tagging` varchar(10) DEFAULT NULL,
  `betti_SR_Audit` varchar(10) DEFAULT NULL,
  `escalation` varchar(10) DEFAULT NULL,
  `correct_Action` varchar(10) DEFAULT NULL,
  `unintelligible_language` varchar(10) DEFAULT NULL,
  `address_customer_issues` varchar(10) DEFAULT NULL,
  `validate_customers_account` varchar(10) DEFAULT NULL,
  `correct_outcome` varchar(10) DEFAULT NULL,
  `egregious_policy_error` varchar(10) DEFAULT NULL,
  `flagrantly_inappropriate_response` varchar(10) DEFAULT NULL,
  `build_ANGI_Services` varchar(10) DEFAULT NULL,
  `mention_Stella_Survey` varchar(10) DEFAULT NULL,
  `mention_ANGI_APP` varchar(10) DEFAULT NULL,
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
  `cmt19` text,
  `cmt20` text,
  `cmt21` text,
  `cmt22` text,
  `cmt23` text,
  `cmt24` text,
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

--
-- Indexes for table `qa_hcci_core_feedback`
--
ALTER TABLE `qa_hcci_core_feedback`
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
-- AUTO_INCREMENT for table `qa_hcci_core_feedback`
--
ALTER TABLE `qa_hcci_core_feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;


--
-- Dumping data for table `qa_hcci_core_feedback`
--

INSERT INTO `qa_hcci_core_feedback` (`id`, `audit_date`, `agent_id`, `tl_id`, `call_date`, `audit_type`, `auditor_type`, `call_duration`, `call_type`, `digital_non_digital`, `week`, `voc`, `overall_score`, `earned_score`, `possible_score`, `customer_earned_score`, `business_earned_score`, `compliance_earned_score`, `customer_possible_score`, `business_possible_score`, `compliance_possible_score`, `customer_overall_score`, `business_overall_score`, `compliance_overall_score`, `lob`, `suggested_opening_spiel`, `sla`, `suggested_closing_spiel`, `additional_assistance`, `spiel_adherance`, `use_proper_script`, `acknowledge_issue`, `empathy_statement`, `provide_assurance`, `information_shared`, `probing_question`, `call_back`, `active_listening`, `interruption`, `dead_air`, `grammar_usage`, `professionalism`, `interact_with_intention`, `strong_ownership`, `enthusiasm`, `tailored_contact`, `avon_security`, `send_right_approver`, `efficiency_of_action`, `documentation`, `proper_disposition_tagging`, `resolved_the_concerns`, `first_response`, `cmt1`, `cmt2`, `cmt3`, `cmt4`, `cmt5`, `cmt6`, `cmt7`, `cmt8`, `cmt9`, `cmt10`, `cmt11`, `cmt12`, `cmt13`, `cmt14`, `cmt15`, `cmt16`, `cmt17`, `cmt18`, `cmt19`, `cmt20`, `cmt21`, `cmt22`, `cmt23`, `cmt24`, `cmt25`, `cmt26`, `cmt27`, `cmt28`, `call_summary`, `feedback`, `attach_file`, `entry_by`, `entry_date`, `audit_start_time`, `client_entryby`, `mgnt_rvw_by`, `mgnt_rvw_note`, `mgnt_rvw_date`, `agent_rvw_note`, `agnt_fd_acpt`, `agent_rvw_date`, `client_rvw_by`, `client_rvw_note`, `client_rvw_date`, `log`) VALUES
(1, '2023-02-28', 27006, 23718, '2023-02-28', 'CQ Audit', 'Master', '16:26:00', 'Available CL', 'Digital', 3, 3, 84.85, 28, 33, 11, 10, 7, 15, 11, 7, 73.33, 90.91, 100, 'Inbound', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Fail', 'Fail', 'Fail', 'Pass', 'Fail', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Fail', 'Pass', 'Fail', 'Fail', 'remark1', 'remark2', 'Remark3', 'Remark4', 'Remark5', 'Remark6', 'Remark7', 'Remark8', 'Remark9', 'Remark10', 'Remark11', 'Remark12', 'Remark13', 'Remark14', 'Remark15', 'Remark16', 'Remark17', 'Remark18', 'Remark19', 'remark20', 'remark21', 'remark22', 'remark23', 'remark24', 'remark25', 'remark26', 'remark27', 'remark28', 'Call Summary:', 'Feedback', 'file_vishal_MP3_700KB.mp3', 1, '2023-02-28 06:33:04', '2023-02-28 06:25:47', NULL, 1, 'okkk', '2023-02-28 06:34:27', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, '2023-02-28', 27006, 23718, '2023-02-28', 'CQ Audit', 'Master', '16:26:00', 'Available CL', 'Digital', 3, 3, 0, 22, 33, 11, 7, 4, 15, 11, 7, 73.33, 63.64, 57.14, 'Inbound', 'Pass', 'Pass', 'Pass', 'Fail', 'Pass', 'Fail', 'Pass', 'Fail', 'Fail', 'Fail', 'Pass', 'Fail', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Fail', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'remark1', 'remark2', 'Remark3', 'Remark4', 'Remark5', 'Remark6', 'Remark7', 'Remark8', 'Remark9', 'Remark10', 'Remark11', 'Remark12', 'Remark13', 'Remark14', 'Remark15', 'Remark16', 'Remark17', 'Remark18', 'Remark19', 'remark20', 'remark21', 'remark22', 'remark23', 'remark24', 'remark25', 'remark26', 'remark27', 'remark28', 'Call Summary:', 'Feedback', 'file_vishal_MP3_700KB1.mp3', 1, '2023-02-28 08:29:45', '2023-02-28 08:21:14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, '2023-03-01', 30058, 23718, '2023-03-01', 'CQ Audit', 'Master', '16:26:00', 'Available CL', 'Digital', 1, 3, 86.67, 26, 30, 11, 10, 5, 13, 11, 6, 84.62, 90.91, 83.33, 'Outbound', 'Pass', 'Pass', 'Pass', 'Fail', 'N/A', 'Pass', 'Pass', 'Pass', 'Pass', 'Fail', 'N/A', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Fail', 'N/A', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Fail', 'Pass', 'Fail', 'Fail', 'remark1', 'remark2', 'Remark3', 'Remark4', 'Remark5', 'Remark6', 'Remark7', 'Remark8', 'Remark9', 'Remark10', 'Remark11', 'Remark12', 'Remark13', 'Remark14', 'Remark15', 'Remark16', 'Remark17', 'Remark18', 'Remark19', 'remark20', 'remark21', 'remark22', 'remark23', 'remark24', 'remark25', 'remark26', 'remark27', 'remark28', 'Call Summary:', 'Feedback', 'file_vishal_MP3_700KB2.mp3', 1, '2023-03-01 01:22:47', '2023-03-01 01:20:06', NULL, NULL, NULL, NULL, 'Agent test done', 'Acceptance', '2023-03-01 02:51:10', NULL, NULL, NULL, NULL),
(4, '2023-03-01', 30058, 23718, '2023-03-01', 'CQ Audit', 'Master', '16:26:00', 'Avon Grow App issue', 'Non Digital', 2, 4, 90.91, 30, 33, 14, 10, 6, 15, 11, 7, 93.33, 90.91, 85.71, 'Email', 'Fail', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Fail', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Fail', 'Pass', 'Pass', 'Pass', 'remark1', 'remark2', 'Remark3', 'Remark4', 'Remark5', 'Remark6', 'Remark7', 'Remark8', 'Remark9', 'Remark10', 'Remark11', 'Remark12', 'Remark13', 'Remark14', 'Remark15', 'Remark16', 'Remark17', 'Remark18', 'Remark19', 'remark20', 'remark21', 'remark22', 'remark23', 'remark24', 'remark25', 'remark26', 'remark27', 'remark28', 'Call Summary', 'Feedback', 'file_vishal_MP3_700KB3.mp3', 1, '2023-03-01 07:37:36', '2023-03-01 07:32:52', NULL, 1, 'Your Review', '2023-03-01 07:39:07', 'agent test', 'Acceptance', '2023-03-01 07:55:25', NULL, NULL, NULL, NULL),
(5, '2023-03-07', 27006, 23718, '2023-03-07', 'Calibration', 'Master', '07:19:22', 'Avon Shop related Concern', 'Digital', 1, 2, 100, 33, 33, 15, 11, 7, 15, 11, 7, 100, 100, 100, 'Email', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Tue_Dec_27_2022_19_58_58_GMT+0530_(India_Standard_Time)_wav.mp3', 1, '2023-03-07 06:36:38', '2023-03-07 03:24:58', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, '2023-03-07', 27006, 23718, '2023-03-07', 'Calibration', 'Regular', '07:20:20', 'Branch Store Hours', 'Non Digital', 3, 1, 100, 33, 33, 15, 11, 7, 15, 11, 7, 100, 100, 100, 'Outbound', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, 1, '2023-03-07 06:53:15', '2023-03-07 06:36:53', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, '2023-03-09', 27006, 23718, '2023-03-09', 'CQ Audit', 'Master', '05:00:00', 'Available CL', 'Digital', 2, 4, 100, 33, 33, 15, 11, 7, 15, 11, 7, 100, 100, 100, 'Inbound', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'hghf', 'hghjg', NULL, 1, '2023-03-09 07:41:20', '2023-03-09 07:33:56', NULL, 1, '', '2023-03-10 01:34:38', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, '2023-03-09', 27006, 23718, '2023-03-09', 'Operation Audit', 'Master', '05:00:00', 'Available CL', 'Digital', 3, 5, 100, 33, 33, 15, 11, 7, 15, 11, 7, 100, 100, 100, '', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'vhgf', 'nbhjg', 'let-it-go-12279.mp3', 1, '2023-03-09 07:53:54', '2023-03-09 07:45:01', NULL, 1, '', '2023-03-09 08:39:14', 'fsdfgds', 'Acceptance', '2023-03-09 08:02:21', NULL, NULL, NULL, NULL),
(9, '2023-03-10', 27006, 23718, '2023-03-10', 'CQ Audit', 'Master', '05:00:00', 'Feedback', 'Digital', 3, 6, 100, 33, 33, 15, 11, 7, 15, 11, 7, 100, 100, 100, 'Inbound', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '679', 'knjkk', NULL, 1, '2023-03-10 00:40:16', '2023-03-10 00:38:55', NULL, 1, 'OKK', '2023-03-10 07:06:03', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, '2023-03-10', 27006, 23718, '2023-03-10', 'CQ Audit', NULL, '05:00:00', 'Due Date', 'Digital', 3, 9, 100, 33, 33, 15, 11, 7, 15, 11, 7, 100, 100, 100, 'Outbound', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'yit', 'hjkhbk', NULL, 1, '2023-03-10 00:41:54', '2023-03-10 00:40:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, '2023-03-10', 27006, 23718, '2023-03-10', 'CQ Audit', NULL, '05:00:00', 'Cancel Order', 'Non Digital', 3, 6, 100, 33, 33, 15, 11, 7, 15, 11, 7, 100, 100, 100, 'Email', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'tytyu', 'rterter', NULL, 1, '2023-03-10 00:43:02', '2023-03-10 00:42:01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, '2023-03-10', 27006, 23718, '2023-03-10', 'CQ Audit', NULL, '05:00:00', 'Due Date', 'NA', 3, 8, 100, 33, 33, 15, 11, 7, 15, 11, 7, 100, 100, 100, 'Chat', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, 1, '2023-03-10 00:44:13', '2023-03-10 00:43:10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, '2023-03-10', 27006, 23718, '2023-03-10', 'CQ Audit', NULL, '05:00:00', 'Branch Transfer', 'Digital', 5, 6, 100, 33, 33, 15, 11, 7, 15, 11, 7, 100, 100, 100, 'CRM', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'gjhgj', 'hjkkj', NULL, 1, '2023-03-10 00:45:24', '2023-03-10 00:44:25', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, '2023-03-10', 27006, 23718, '2023-03-10', 'CQ Audit', 'Master', '05:00:00', 'Due Date', 'Digital', 3, 0, 93.94, 31, 33, 15, 11, 5, 15, 11, 7, 100, 100, 71.43, 'SMS', 'Fail', 'Fail', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'jhjhj', 'hhjghiuh', NULL, 1, '2023-03-10 00:46:35', '2023-03-10 00:45:35', NULL, 1, '', '2023-03-10 01:00:02', 'fgdfg', 'Acceptance', '2023-03-10 00:52:52', NULL, NULL, NULL, NULL),
(15, '2023-03-10', 27010, 23718, '2023-03-10', 'CQ Audit', 'Master', '16:26:00', 'Cannot Login', 'Digital', 3, 2, 96.97, 32, 33, 14, 11, 7, 15, 11, 7, 93.33, 100, 100, 'Inbound', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Fail', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'remark1', 'remark2', 'Remark3', 'Remark4', 'Remark5', 'Remark6', 'Remark7', 'Remark8', 'Remark9', 'Remark10', 'Remark11', 'Remark12', 'Remark13', 'Remark14', 'Remark15', 'Remark16', 'Remark17', 'Remark18', 'Remark19', 'remark20', 'remark21', 'remark22', 'remark23', 'remark24', 'remark25', 'remark26', 'remark27', 'remark28', 'Call Summary:', 'Feedback', 'file_vishal_MP3_700KB4.mp3', 1, '2023-03-10 05:02:20', '2023-03-10 04:59:24', NULL, 1, '', '2023-03-10 07:04:25', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, '2023-03-10', 30058, 23718, '2023-03-10', 'CQ Audit', 'Master', '16:26:00', 'Cannot Login', 'Non Digital', 2, 3, 100, 33, 33, 15, 11, 7, 15, 11, 7, 100, 100, 100, 'Outbound', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'dfgdg', 'dfgdfg', 'file_vishal_MP3_700KB6.mp3', 1, '2023-03-10 07:26:39', '2023-03-10 07:26:03', NULL, 1, 'hjghjg', '2023-03-10 11:59:29', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, '2023-03-10', 27006, 23718, '2023-03-10', 'CQ Audit', NULL, '16:00:00', 'Avon Grow App issue', 'Digital', 3, 2, 100, 33, 33, 15, 11, 7, 15, 11, 7, 100, 100, 100, 'Inbound', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'rtyry', 'rtyrty', NULL, 1, '2023-03-10 07:47:19', '2023-03-10 07:45:43', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, '2023-03-10', 27006, 23718, '2023-03-10', 'CQ Audit', NULL, '16:00:00', 'Avon Grow App issue', 'Digital', 2, 1, 100, 33, 33, 15, 11, 7, 15, 11, 7, 100, 100, 100, 'Inbound', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'fhfg', 'dfgdfg', NULL, 1, '2023-03-10 07:53:45', '2023-03-10 07:53:20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, '2023-03-10', 27006, 23718, '2023-03-10', 'CQ Audit', NULL, '05:00:00', 'Cancel Order', 'Digital', 2, 3, 100, 33, 33, 15, 11, 7, 15, 11, 7, 100, 100, 100, 'Inbound', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, 1, '2023-03-10 10:43:28', '2023-03-10 10:42:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(21, '2023-03-10', 27006, 23718, '2023-03-10', 'CQ Audit', NULL, '05:00:00', 'Cannot Login', 'Digital', 3, 6, 100, 33, 33, 15, 11, 7, 15, 11, 7, 100, 100, 100, 'Email', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, 1, '2023-03-10 10:46:33', '2023-03-10 10:45:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(22, '2023-03-10', 27006, 23718, '2023-03-10', 'Calibration', 'Master', '09:00:00', 'Cancel Order', 'Digital', 5, 8, 100, 33, 33, 15, 11, 7, 15, 11, 7, 100, 100, 100, 'Inbound', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'file_vishal_MP3_700KB7.mp3', 1, '2023-03-10 11:27:25', '2023-03-10 10:54:07', NULL, 1, 'pl', '2023-03-13 02:21:26', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, '2023-03-13', 30058, 23718, '2023-03-13', 'CQ Audit', 'Master', '16:28:00', 'Avon Grow App issue', 'Digital', 3, 3, 100, 33, 33, 15, 11, 7, 15, 11, 7, 100, 100, 100, 'Inbound', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Call Summary', 'Feedback', NULL, 1, '2023-03-13 03:39:18', '2023-03-13 03:35:55', NULL, 1, 'okk', '2023-03-13 03:45:01', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, '2023-03-13', 27006, 23718, '0000-00-00', 'Operation Audit', NULL, '03:00:00', 'Due Date', 'Non Digital', 2, 3, 100, 33, 33, 15, 11, 7, 15, 11, 7, 100, 100, 100, 'Chat', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, 1, '2023-03-13 06:33:36', '2023-03-13 06:31:46', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, '2023-03-14', 27006, 23718, '0000-00-00', 'CQ Audit', 'Master', '03:00:00', 'Stock Availability', 'NA', 4, 6, 100, 33, 33, 15, 11, 7, 15, 11, 7, 100, 100, 100, 'CRM', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, 1, '2023-03-14 01:05:38', '2023-03-14 00:56:15', NULL, 1, 'guytgjfjv', '2023-03-14 01:07:18', 'hghj', 'Acceptance', '2023-03-14 01:15:49', NULL, NULL, NULL, NULL),
(26, '2023-03-14', 27006, 23718, '0000-00-00', 'BQ Audit', 'Master', '05:00:00', 'Available CL', 'Non Digital', 3, 4, 100, 33, 33, 15, 11, 7, 15, 11, 7, 100, 100, 100, 'Outbound', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, 1, '2023-03-14 01:43:18', '2023-03-14 01:42:27', NULL, 1, 'afafd', '2023-03-14 01:44:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(27, '2023-03-14', 27006, 23718, '0000-00-00', 'BQ Audit', NULL, '03:00:00', 'Feedback', 'Digital', 4, 5, 100, 33, 33, 15, 11, 7, 15, 11, 7, 100, 100, 100, 'Email', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, 1, '2023-03-14 01:46:20', '2023-03-14 01:44:48', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(28, '2023-03-14', 23735, 23718, '2023-03-14', 'CQ Audit', NULL, '16:26:00', 'Avon Grow App issue', NULL, 1, 4, 100, 33, 33, 15, 11, 7, 15, 11, 7, 100, 100, 100, 'Inbound', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'sdfd', 'fsdfsf', 'file_vishal_MP3_700KB9.mp3', 1, '2023-03-14 05:45:22', '2023-03-14 05:44:40', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(29, '2023-03-14', 27006, 23718, '2023-03-14', 'BQ Audit', NULL, '03:00:00', 'Available CL', NULL, 2, 3, 100, 33, 33, 15, 11, 7, 15, 11, 7, 100, 100, 100, 'CRM', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, 1, '2023-03-14 06:38:42', '2023-03-14 06:33:00', NULL, 1, 'dfsdf', '2023-03-14 06:51:35', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(30, '2023-03-14', 27006, 23718, '2023-03-14', 'Operation Audit', NULL, '05:00:00', 'Available CL', NULL, 2, 6, 100, 33, 33, 15, 11, 7, 15, 11, 7, 100, 100, 100, 'Chat', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, 1, '2023-03-14 07:09:31', '2023-03-14 07:07:17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(31, '2023-03-14', 27006, 23718, '2023-03-14', 'CQ Audit', NULL, '05:00:00', 'Available CL', NULL, 2, 4, 100, 33, 33, 15, 11, 7, 15, 11, 7, 100, 100, 100, 'Email', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', 'Pass', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Agent_issue.mp4', 1, '2023-03-14 07:14:22', '2023-03-14 07:12:30', NULL, NULL, NULL, NULL, 'asdfsfd', 'Acceptance', '2023-03-14 07:17:51', NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
