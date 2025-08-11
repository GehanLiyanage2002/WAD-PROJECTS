-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 11, 2025 at 11:31 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sis_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_history`
--

CREATE TABLE `academic_history` (
  `id` int(30) NOT NULL,
  `student_id` int(30) NOT NULL,
  `course_id` int(30) NOT NULL,
  `semester` varchar(200) NOT NULL,
  `year` varchar(200) NOT NULL,
  `school_year` text NOT NULL,
  `status` int(10) NOT NULL DEFAULT 1 COMMENT '1= New,\r\n2= Regular,\r\n3= Returnee,\r\n4= Transferee',
  `end_status` tinyint(3) NOT NULL DEFAULT 0 COMMENT '0=pending,\r\n1=Completed,\r\n2=Dropout,\r\n3=failed,\r\n4=Transferred-out,\r\n5=Graduated',
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course_list`
--

CREATE TABLE `course_list` (
  `id` int(30) NOT NULL,
  `department_id` int(30) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course_list`
--

INSERT INTO `course_list` (`id`, `department_id`, `name`, `description`, `status`, `delete_flag`, `date_created`, `date_updated`) VALUES
(1, 2, 'BSIT', 'Bachelor of Science in Information Technology', 1, 1, '2022-01-27 10:03:25', '2025-08-05 11:09:45'),
(2, 4, 'BEEd', 'Bachelor of Elementary Education', 1, 1, '2022-01-27 10:06:43', '2025-08-05 11:09:30'),
(3, 4, 'BSEd', 'Bachelor of Secondary Education', 1, 1, '2022-01-27 10:07:21', '2025-08-05 11:09:42'),
(4, 4, 'MAEd', 'Master of Arts in Education', 1, 1, '2022-01-27 10:07:52', '2025-08-05 11:09:50'),
(5, 4, 'PhD Educ', 'Doctor of Philosophy in Education', 1, 1, '2022-01-27 10:08:21', '2025-08-05 11:10:04'),
(6, 1, 'BSCE', 'Bachelor of Science in Civil Engineering', 1, 1, '2022-01-27 10:08:48', '2025-08-05 11:09:36'),
(7, 1, 'MSCE', 'Master of Science in Civil Engineering', 1, 1, '2022-01-27 10:09:00', '2025-08-05 11:09:57'),
(8, 1, 'BS ChE', 'Bachelor of Science in Chemical Engineering', 1, 1, '2022-01-27 10:09:35', '2025-08-05 11:09:33'),
(9, 1, 'MS ChE', 'Master of Science in Chemical Engineering', 1, 1, '2022-01-27 10:10:16', '2025-08-05 11:09:53'),
(10, 1, 'DEngg ChE', 'Doctor of Engineering (Chemical Engineering)', 1, 1, '2022-01-27 10:10:39', '2025-08-05 11:09:47'),
(11, 1, 'BSCS', 'Bachelor of Science in Computer Science', 1, 1, '2022-01-27 10:12:23', '2025-08-05 11:09:39'),
(12, 1, 'MSCS', 'Master of Science in Computer Science', 1, 1, '2022-01-27 10:12:35', '2025-08-05 11:10:01'),
(13, 7, 'Bio Systems Technology Degree Program', 'It offers practical and research-based education to develop sustainable solutions using innovations in biotechnology, bioinstrumentation, and systems engineering.', 1, 0, '2025-08-05 11:37:41', NULL),
(14, 8, 'Engineering Technology Degree Program  ', 'The degree prepares students to become skilled technologists capable of solving industry-related challenges through innovation and technical expertise.', 1, 0, '2025-08-05 11:38:21', NULL),
(15, 9, ' Information and Communication Technology Degree Program   ', 'It equips students with practical skills and theoretical knowledge to design, implement, and manage modern ICT solutions. The department aims to produce competent professionals who can drive innovation in areas such as software engineering, cybersecurity, data science, and emerging technologies.', 1, 0, '2025-08-05 11:39:26', NULL),
(16, 10, 'Mineral Resources and Technology Degree Program', 'The degree prepares students to address real-world challenges like natural disasters, mineral exploration, and environmental sustainability through fieldwork, research, and technology-based solutions.', 1, 0, '2025-08-05 12:25:14', NULL),
(17, 11, 'Science and Technology Degree Program  ', 'The degree aims to develop analytical, research, and problem-solving skills in students, preparing them to contribute to scientific advancement and technological development across various industries.', 1, 0, '2025-08-05 12:25:48', NULL),
(18, 12, 'Computer Science and Technology Degree Program  ', 'The degree aims to equip students with the knowledge and skills needed to design innovative software solutions, analyze complex data, and contribute to advancements in computer science and digital technology.', 1, 0, '2025-08-05 12:26:16', NULL),
(19, 12, 'Industrial Information Technology Degree Program', 'The degree aims to equip students with the knowledge and skills needed to design innovative software solutions, analyze complex data, and contribute to advancements in computer science and digital technology.', 1, 0, '2025-08-05 12:26:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `department_list`
--

CREATE TABLE `department_list` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department_list`
--

INSERT INTO `department_list` (`id`, `name`, `description`, `status`, `delete_flag`, `date_created`, `date_updated`) VALUES
(1, 'CoEng', 'College of Engineering', 1, 1, '2022-01-27 09:22:31', '2025-08-05 11:09:20'),
(2, 'CoAS', 'College of Arts and Science', 1, 1, '2022-01-27 09:22:54', '2025-08-05 11:09:09'),
(3, 'CoB', 'College of Business', 1, 1, '2022-01-27 09:23:20', '2025-08-05 11:09:12'),
(4, 'CoE', 'College of Education', 1, 1, '2022-01-27 09:25:42', '2025-08-05 11:09:15'),
(5, 'CSSP', 'College of Social Sciences and Philosophy', 1, 1, '2022-01-27 09:26:35', '2025-08-05 11:09:23'),
(6, 'Sample101', 'Deleted Department', 1, 1, '2022-01-27 09:27:17', '2022-01-27 09:27:28'),
(7, 'Department of Biosystems Technology', 'The Department of Biosystems Technology focuses on the integration of biological sciences with modern technology to solve real-world problems in agriculture, environment, food production, and bioengineering.', 1, 0, '2025-08-05 11:25:25', NULL),
(8, 'Department of Engineering Technology', 'The Department of Engineering Technology provides hands-on, application-oriented education in various engineering fields. It bridges the gap between theoretical engineering concepts and practical implementation, focusing on areas such as mechanical, electrical, civil, and electronic technologies.', 1, 0, '2025-08-05 11:26:06', NULL),
(9, 'Department of Information and Communication Technology', 'The Department of Information and Communication Technology (ICT) focuses on the study and application of computer systems, software development, networking, and digital communication. It equips students with practical skills and theoretical knowledge to design, implement, and manage modern ICT solutions.', 1, 0, '2025-08-05 11:26:53', NULL),
(10, 'Department of Applied Earth Sciences', 'The Department of Applied Earth Sciences focuses on the scientific study of the Earth’s structure, resources, and processes, with a strong emphasis on practical applications. It covers areas such as geology, geophysics, environmental science, and natural resource management. ', 1, 0, '2025-08-05 12:22:41', NULL),
(11, 'Department of Science And Technology', 'The Department of Science and Technology offers a multidisciplinary approach to understanding and applying scientific principles and technological innovations. It encompasses a wide range of fields such as physics, chemistry, mathematics, and emerging technologies.', 1, 0, '2025-08-05 12:23:19', NULL),
(12, 'Department of Computer Science and Informatics', 'The Department of Computer Science and Informatics focuses on the theoretical foundations and practical applications of computing and information systems. It covers key areas such as algorithms, programming, data structures, artificial intelligence, databases, and human-computer interaction. ', 1, 0, '2025-08-05 12:24:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_list`
--

CREATE TABLE `student_list` (
  `id` int(30) NOT NULL,
  `roll` varchar(100) NOT NULL,
  `firstname` text NOT NULL,
  `middlename` text DEFAULT NULL,
  `lastname` text NOT NULL,
  `gender` varchar(100) NOT NULL,
  `contact` text NOT NULL,
  `present_address` text NOT NULL,
  `permanent_address` text NOT NULL,
  `dob` date NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'UVA Student Information System'),
(6, 'short_name', 'UVA_SIS'),
(13, 'user_avatar', 'uploads/user_avatar.jpg'),
(14, 'cover', 'uploads/cover-1643245863.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `middlename` text DEFAULT NULL,
  `lastname` varchar(250) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 0,
  `status` int(1) NOT NULL DEFAULT 1 COMMENT '0=not verified, 1 = verified',
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `middlename`, `lastname`, `username`, `password`, `avatar`, `last_login`, `type`, `status`, `date_added`, `date_updated`) VALUES
(1, 'Adminstrator', NULL, 'Admin', 'admin', '0192023a7bbd73250516f069df18b500', 'uploads/avatar-1.png?v=1639468007', NULL, 1, 1, '2021-01-20 14:02:37', '2021-12-14 15:47:08'),
(8, 'Claire', NULL, 'Blake', 'cblake', '4744ddea876b11dcb1d169fadf494418', 'uploads/avatar-8.png?v=1643185259', NULL, 2, 1, '2022-01-26 16:20:59', '2022-01-26 16:20:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_history`
--
ALTER TABLE `academic_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `course_list`
--
ALTER TABLE `course_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `department_list`
--
ALTER TABLE `department_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_list`
--
ALTER TABLE `student_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_history`
--
ALTER TABLE `academic_history`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `course_list`
--
ALTER TABLE `course_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `department_list`
--
ALTER TABLE `department_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `student_list`
--
ALTER TABLE `student_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `academic_history`
--
ALTER TABLE `academic_history`
  ADD CONSTRAINT `academic_history_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student_list` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `academic_history_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `course_list` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `course_list`
--
ALTER TABLE `course_list`
  ADD CONSTRAINT `course_list_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `department_list` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
