-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 09, 2020 at 11:11 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gp_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendance_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `attendance_date` date NOT NULL,
  `attendance_status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `class_id` int(11) NOT NULL,
  `class_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`class_id`, `class_name`) VALUES
(1, 'Level 4'),
(3, 'Level 5'),
(4, 'Level 6');

-- --------------------------------------------------------

--
-- Table structure for table `contents`
--

CREATE TABLE `contents` (
  `content_id` int(11) NOT NULL,
  `content_name` varchar(255) NOT NULL,
  `content_description` varchar(512) DEFAULT NULL,
  `content_file` varchar(255) NOT NULL,
  `content_addedOn` date NOT NULL,
  `content_module` int(11) NOT NULL,
  `content_teacher` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contents`
--

INSERT INTO `contents` (`content_id`, `content_name`, `content_description`, `content_file`, `content_addedOn`, `content_module`, `content_teacher`) VALUES
(5, 'Lecture 1', 'Edit Test', 'CSY2028-Topic 2-Lecture-Slide.pdf', '2020-02-01', 2, 2),
(6, 'Topic 1', 'Test', 'CSY2028_term1_first_sit_assignment_brief.pdf', '2020-01-25', 2, 2),
(7, 'Topic 2', 'Test 2', 'WWW.YTS.TO.jpg', '2020-01-29', 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `module_id` int(11) NOT NULL,
  `module_name` varchar(255) NOT NULL,
  `module_description` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`module_id`, `module_name`, `module_description`) VALUES
(2, 'CSY1020', 'Problem Solving and Programming'),
(3, 'CSY2028', 'Web Programming'),
(4, '', ''),
(5, 'CSY2020', 'Health'),
(6, 'CSY1000', 'Social Studies'),
(7, 'CSY3030', 'Abdroid'),
(8, 'CSY4040', 'Artificial Intelligence'),
(9, 'CSY5050', 'Fifty-fifty'),
(10, 'CSY6060', 'Sixty-Sixty');

-- --------------------------------------------------------

--
-- Table structure for table `module_class`
--

CREATE TABLE `module_class` (
  `module_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `module_class`
--

INSERT INTO `module_class` (`module_id`, `class_id`) VALUES
(2, 1),
(3, 3),
(5, 1),
(5, 3),
(6, 1),
(7, 1);

-- --------------------------------------------------------

--
-- Table structure for table `module_teacher`
--

CREATE TABLE `module_teacher` (
  `module_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `module_teacher`
--

INSERT INTO `module_teacher` (`module_id`, `teacher_id`) VALUES
(2, 2),
(5, 3),
(5, 4),
(6, 4),
(7, 4);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `student_firstname` varchar(255) NOT NULL,
  `student_surname` varchar(255) NOT NULL,
  `student_gender` char(1) NOT NULL DEFAULT 'M',
  `student_email` varchar(255) NOT NULL,
  `student_password` varchar(255) NOT NULL,
  `student_dateOfBirth` date NOT NULL,
  `student_contact` varchar(15) NOT NULL,
  `student_class` int(11) NOT NULL,
  `user_type` varchar(255) NOT NULL DEFAULT 'student'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `student_firstname`, `student_surname`, `student_gender`, `student_email`, `student_password`, `student_dateOfBirth`, `student_contact`, `student_class`, `user_type`) VALUES
(2, 'Lisa', 'Rai', 'F', 'lisaRae@gmail.com', '$2y$10$oNPLXofOVvfH460oWC0/yO0Xs9SYrD/YmWRWpr07byBTUI.7rLodm', '2000-01-01', '9823456789', 1, 'student'),
(3, 'Louis', 'Dhangana', 'M', 'louisDhg@gmail.com', '$2y$10$aHIaFQQarp/mCca5y/nUdO6pn9UdRoJHkJIhDYA4O/ZvuaeT.eBTK', '1998-07-17', '9812987655', 1, 'student'),
(4, 'Samir', 'Limbu', 'M', 'samirLimbu@gmail.com', '$2y$10$gTHwnj3Gb0wtXTqyXM1qHuX/YLRk19LTs.nadfPW4WCbM6.jNLl7C', '2000-07-21', '9876534678', 3, 'student');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `teacher_id` int(11) NOT NULL,
  `teacher_firstname` varchar(255) NOT NULL,
  `teacher_surname` varchar(255) NOT NULL,
  `teacher_gender` char(1) NOT NULL DEFAULT 'M',
  `teacher_email` varchar(255) NOT NULL,
  `teacher_password` varchar(255) NOT NULL,
  `teacher_dateOfBirth` date NOT NULL,
  `teacher_contact` varchar(15) NOT NULL,
  `teacher_qualification` varchar(255) NOT NULL,
  `user_type` varchar(255) NOT NULL DEFAULT 'teacher'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`teacher_id`, `teacher_firstname`, `teacher_surname`, `teacher_gender`, `teacher_email`, `teacher_password`, `teacher_dateOfBirth`, `teacher_contact`, `teacher_qualification`, `user_type`) VALUES
(2, 'Pradip', 'Jagebu', 'M', 'pradipJabegu@gmail.com', '$2y$10$vR5dZLsk2nIHHJ/yfeh6AuPMHkK6R5.NPKG2QgQnYm8fMebYL1gha', '1988-07-05', '9812398756', 'MIT', 'teacher'),
(3, 'Suzzan', 'Shrestha', 'M', 'suzzanShrestha@gmail.com', '$2y$10$Y79N2VN6jFKliEswGYzaYui7KIA4MJdh9zqJnSPaqS1Cuyf5XW2Zq', '1991-07-24', '9824536245', 'MSc', 'admin'),
(4, 'Sujan', 'Rai', 'M', 'sujanRai@gmail.com', '$2y$10$DIPRSZ2tz3HzSaVfXDFyj.jenLWpowDBiEgy/GK8ZR1U1uP4ZpnvG', '1993-07-13', '9825364786', 'MBA', 'teacher'),
(5, 'Yalamber', 'Ingnam', 'M', 'yalamber@gmail.com', '$2y$10$Oa3Q//hd4Ayb3iFR3aaCiuNI0Rj3bgIWW41Q5aNBCULLrorlWl2jS', '2020-02-05', '9836475535', 'MIT', 'teacher'),
(6, 'Pawel', 'Rai', 'M', 'pawel@gmail.com', '$2y$10$7AegR28B2y8oilT7zuSQsOcd1D0eG8HqQTyT72VeqylO/DRgcTxxm', '2004-07-06', '9823456578', 'MSc', 'teacher');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_class`
--

CREATE TABLE `teacher_class` (
  `teacher_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `teacher_class`
--

INSERT INTO `teacher_class` (`teacher_id`, `class_id`) VALUES
(2, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendance_id`),
  ADD KEY `fk_a_students` (`student_id`) USING BTREE,
  ADD KEY `fk_a_modules` (`module_id`) USING BTREE;

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`class_id`),
  ADD UNIQUE KEY `UNIQUE` (`class_name`) USING BTREE;

--
-- Indexes for table `contents`
--
ALTER TABLE `contents`
  ADD PRIMARY KEY (`content_id`),
  ADD KEY `fk_c_teachers` (`content_teacher`),
  ADD KEY `fk_c_modules` (`content_module`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`module_id`),
  ADD UNIQUE KEY `UNIQUE` (`module_name`) USING BTREE;

--
-- Indexes for table `module_class`
--
ALTER TABLE `module_class`
  ADD PRIMARY KEY (`module_id`,`class_id`),
  ADD KEY `fk_m_c_modules` (`module_id`) USING BTREE,
  ADD KEY `fk_m_c_classes` (`class_id`) USING BTREE;

--
-- Indexes for table `module_teacher`
--
ALTER TABLE `module_teacher`
  ADD PRIMARY KEY (`module_id`,`teacher_id`),
  ADD KEY `fk_m_t_modules` (`module_id`) USING BTREE,
  ADD KEY `fk_m_t_teachers` (`teacher_id`) USING BTREE;

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `fk_s_classes` (`student_class`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`teacher_id`);

--
-- Indexes for table `teacher_class`
--
ALTER TABLE `teacher_class`
  ADD PRIMARY KEY (`teacher_id`,`class_id`),
  ADD KEY `fk_t_c_teachers` (`teacher_id`) USING BTREE,
  ADD KEY `fk_t_c_classes` (`class_id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contents`
--
ALTER TABLE `contents`
  MODIFY `content_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `module_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `fk_a_modules` FOREIGN KEY (`module_id`) REFERENCES `modules` (`module_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_a_students` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `contents`
--
ALTER TABLE `contents`
  ADD CONSTRAINT `fk_c_modules` FOREIGN KEY (`content_module`) REFERENCES `modules` (`module_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_c_teachers` FOREIGN KEY (`content_teacher`) REFERENCES `teachers` (`teacher_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `module_class`
--
ALTER TABLE `module_class`
  ADD CONSTRAINT `fk_m_c_classes` FOREIGN KEY (`class_id`) REFERENCES `classes` (`class_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_m_c_modules` FOREIGN KEY (`module_id`) REFERENCES `modules` (`module_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `module_teacher`
--
ALTER TABLE `module_teacher`
  ADD CONSTRAINT `fk_m_t_modules` FOREIGN KEY (`module_id`) REFERENCES `modules` (`module_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_m_t_teachers` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`teacher_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `fk_s_classes` FOREIGN KEY (`student_class`) REFERENCES `classes` (`class_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `teacher_class`
--
ALTER TABLE `teacher_class`
  ADD CONSTRAINT `fk_t_c_classes` FOREIGN KEY (`class_id`) REFERENCES `classes` (`class_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_t_c_teachers` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`teacher_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
