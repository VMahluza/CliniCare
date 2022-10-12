-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 11, 2022 at 10:54 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE `clinicaredb`;

USE `clinicaredb`;
--

-- --------------------------------------------------------

--
-- Table structure for table `diagnosis`
--

CREATE TABLE `diagnosis` (
                             `Diagnosis_id` int(11) NOT NULL,
                             `person_id` int(11) NOT NULL,
                             `title` varchar(20) DEFAULT NULL,
                             `description` varchar(100) DEFAULT NULL,
                             `date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `diagnosis`
--

INSERT INTO `diagnosis` (`Diagnosis_id`, `person_id`, `title`, `description`, `date`) VALUES
                                                                                          (3, 4, 'Malaria', 'Malaria is a mosquito-borne infectious disease that affects humans and other animals. Malaria causes', '2022-10-12 05:43:20'),
                                                                                          (5, 4, 'Corona Virus', 'COVID-19 is the illness that presents on being infected by a deadly coronavirus called SARS-CoV-2. T', '2022-10-09 06:38:52'),
                                                                                          (6, 4, 'Corona Virus', 'COVID-19 is the illness that presents on being infected by a deadly coronavirus called SARS-CoV-2. T', '2022-10-09 06:40:31'),
                                                                                          (16, 4, 'UYagula ', 'Sifeoskoas', '2022-10-09 08:36:56');

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
                         `notes_id` int(11) NOT NULL,
                         `Diagnosis_id` int(11) DEFAULT NULL,
                         `description` varchar(150) DEFAULT NULL,
                         `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`notes_id`, `Diagnosis_id`, `description`, `created`) VALUES
                                                                               (1, 6, 'Umooioweio njkjzkjckzc', '2022-10-10 21:06:58'),
                                                                               (3, 3, 'jkjkjk', '2022-10-11 08:31:07'),
                                                                               (18, 6, 'kjakjaijdoaojiuhjsidj', '2022-10-11 08:54:18'),
                                                                               (19, 3, 'jkjkjk', '2022-10-11 09:05:28'),
                                                                               (20, 6, 'kjakjaijdoaojiuhjsidj', '2022-10-11 09:09:07'),
                                                                               (21, 3, 'jkjkjk', '2022-10-11 09:09:41'),
                                                                               (22, 6, 'kjakjaijdoaojiuhjsidj', '2022-10-11 09:10:06'),
                                                                               (23, 6, 'kjakjaijdoaojiuhjsidj', '2022-10-11 09:20:59'),
                                                                               (24, 6, 'kjakjaijdoaojiuhjsidj', '2022-10-11 09:28:54'),
                                                                               (25, 6, 'kjakjaijdoaojiuhjsidj', '2022-10-11 09:32:52'),
                                                                               (26, 6, 'kjakjaijdoaojiuhjsidj', '2022-10-11 09:33:15'),
                                                                               (27, 3, 'jkjkjk', '2022-10-11 09:44:44'),
                                                                               (28, 3, 'jkjkjk', '2022-10-11 09:45:40'),
                                                                               (29, 3, 'jkjkjk', '2022-10-11 09:46:12'),
                                                                               (30, 3, 'jkjkjk', '2022-10-11 09:49:36'),
                                                                               (31, 3, 'jkjkjk', '2022-10-11 09:51:02'),
                                                                               (32, 3, 'jkjkjk', '2022-10-11 09:54:16'),
                                                                               (34, 3, 'jkjkjk', '2022-10-11 10:00:14'),
                                                                               (35, 6, 'kjakjaijdoaojiuhjsidj', '2022-10-11 10:33:55');

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
                           `id` int(11) NOT NULL,
                           `patientNumber` int(9) NOT NULL,
                           `firstname` varchar(50) NOT NULL,
                           `surname` varchar(50) NOT NULL,
                           `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`id`, `patientNumber`, `firstname`, `surname`, `created`) VALUES
                                                                                     (4, 8288912, 'KABELO', 'NGWENYA', '2022-10-05 23:06:28'),
                                                                                     (11, 23453565, 'NICKY', 'MKHATSHWA', '2022-10-10 14:28:21');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
                        `id` int(10) NOT NULL,
                        `firstname` varchar(50) NOT NULL,
                        `surname` varchar(50) NOT NULL,
                        `email` varchar(50) NOT NULL,
                        `password` char(60) NOT NULL,
                        `role_id` int(3) NOT NULL,
                        `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `firstname`, `surname`, `email`, `password`, `role_id`, `created`) VALUES
                                                                                                 (9, 'VICTOR', 'MAHLUZA', 'MAHLUZAVICTOR@GMAIL.COM', '$2y$10$9gVSwNEmPsyX4qgeg1EmveTY62RbJHzIqeVNvMT6cyApbGk0IBc3a', 2, '2022-10-02 22:09:19'),
                                                                                                 (10, 'ADMINNAME', 'ADMINSURNAME', 'ADMIN@CLINICARE.COM', '$2y$10$ppg4dDstMGqBvScj2frEj.MvQ/Ph8zWlkEFU/hSS20ndBQUqJWRNe', 2, '2022-10-07 15:31:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `diagnosis`
--
ALTER TABLE `diagnosis`
    ADD PRIMARY KEY (`Diagnosis_id`),
    ADD KEY `fk_person_id` (`person_id`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
    ADD PRIMARY KEY (`notes_id`),
    ADD KEY `fk_Diagnosis_id` (`Diagnosis_id`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `patientNumber` (`patientNumber`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `diagnosis`
--
ALTER TABLE `diagnosis`
    MODIFY `Diagnosis_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
    MODIFY `notes_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
    MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `diagnosis`
--
ALTER TABLE `diagnosis`
    ADD CONSTRAINT `fk_person_id` FOREIGN KEY (`person_id`) REFERENCES `patient` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `notes`
--
ALTER TABLE `notes`
    ADD CONSTRAINT `fk_Diagnosis_id` FOREIGN KEY (`Diagnosis_id`) REFERENCES `diagnosis` (`Diagnosis_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
