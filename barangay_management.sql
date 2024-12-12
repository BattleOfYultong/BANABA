-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Dec 12, 2024 at 06:39 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `barangay_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE `announcement` (
  `image` varchar(255) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`image`, `id`) VALUES
('announcement_image.jpg', 2),
('announcement_image.jpg', 5);

-- --------------------------------------------------------

--
-- Table structure for table `barangays`
--

CREATE TABLE `barangays` (
  `barangay_id` int(11) NOT NULL,
  `barangay_name` varchar(255) NOT NULL,
  `contact_number` varchar(50) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barangays`
--

INSERT INTO `barangays` (`barangay_id`, `barangay_name`, `contact_number`, `address`) VALUES
(1, 'Banaba', '09939914917', 'Caloocan'),
(2, 'Tandang Sora', '09123238585', 'San Pedro 6'),
(3, 'Tandang Sora', '09123238585', 'San Pedro 6'),
(4, 'Banaba', '090090909', 'america'),
(5, 'Banaba', '090090909', 'america'),
(6, 'Tandang Sora', '09978723222', 'QC');

-- --------------------------------------------------------

--
-- Table structure for table `barangay_clearance`
--

CREATE TABLE `barangay_clearance` (
  `full_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `contact_number` int(11) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `civil_status` varchar(255) NOT NULL,
  `job` varchar(255) NOT NULL,
  `id_number` varchar(255) NOT NULL,
  `purpose` varchar(25) NOT NULL,
  `occupation` varchar(255) NOT NULL,
  `years_residency` int(10) NOT NULL,
  `household_head` varchar(255) NOT NULL,
  `valid_id_type` varchar(100) NOT NULL,
  `application_date` varchar(255) NOT NULL DEFAULT current_timestamp(),
  `id` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barangay_clearance`
--

INSERT INTO `barangay_clearance` (`full_name`, `address`, `contact_number`, `gender`, `civil_status`, `job`, `id_number`, `purpose`, `occupation`, `years_residency`, `household_head`, `valid_id_type`, `application_date`, `id`) VALUES
('Jasmine', 'Novaliches', 99090909, 'Female', 'Single', '12121-12-12', 'NO22232324232', 'Job Application', 'Teacher', 12, 'Yes', 'Driver\'s License', '2024-12-09 16:24:37', 1),
('juan', 'philippines', 2147483647, 'Male', 'Single', '1111-01-01', 'NO22232324232', 'Job Application', 'tambay', 100, 'Yes', 'Driver\'s License', '2024-12-09 17:01:17', 2),
('daniela', 'tandang sora', 302032030, 'Female', 'Single', '2321-03-21', '3231234234', 'Loan Release', 'student', 12, 'No', 'Driver\'s License', '2024-12-09 17:27:45', 3),
('Amiel Jake Baril', 'San Pedro 6 Tandang Sora QC', 2147483647, 'Male', 'Single', '2004-04-09', '12345', 'Job Application', 'student', 2, 'Yes', 'Other', '2024-12-10 17:27:58', 4);

-- --------------------------------------------------------

--
-- Table structure for table `blotter_appointments`
--

CREATE TABLE `blotter_appointments` (
  `user_id` int(11) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time(6) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blotter_appointments`
--

INSERT INTO `blotter_appointments` (`user_id`, `appointment_date`, `appointment_time`, `reason`, `name`) VALUES
(14, '2024-12-11', '09:00:00.000000', 'nothing', 'Amiel Jake Baril');

-- --------------------------------------------------------

--
-- Table structure for table `blotter_reports`
--

CREATE TABLE `blotter_reports` (
  `id` int(11) NOT NULL,
  `complainant_name` varchar(255) NOT NULL,
  `respondent_name` varchar(255) NOT NULL,
  `incident_details` text NOT NULL,
  `date_reported` datetime DEFAULT current_timestamp(),
  `incident_date` date NOT NULL,
  `status` enum('Pending','Resolved') DEFAULT 'Pending',
  `complainant_address` varchar(255) DEFAULT NULL,
  `respondent_address` varchar(255) DEFAULT NULL,
  `witnesses` text DEFAULT NULL,
  `incident_time` time DEFAULT NULL,
  `incident_location` varchar(255) DEFAULT NULL,
  `resident_type` enum('Normal','Senior','PWD') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blotter_reports`
--

INSERT INTO `blotter_reports` (`id`, `complainant_name`, `respondent_name`, `incident_details`, `date_reported`, `incident_date`, `status`, `complainant_address`, `respondent_address`, `witnesses`, `incident_time`, `incident_location`, `resident_type`) VALUES
(1, 'JM', 'AMIEL', 'sinapak', '2024-12-09 14:36:12', '2024-12-08', 'Pending', 'bcp', 'bayan ', 'Daniela', '15:00:00', 'MV', 'Senior'),
(2, 'amiel', 'jm', 'sinaksak', '2024-12-09 16:00:32', '0000-00-00', 'Resolved', 'bcp', 'novaliches', 'andrei', '00:12:00', 'school', 'Senior');

-- --------------------------------------------------------

--
-- Table structure for table `brgy_officials`
--

CREATE TABLE `brgy_officials` (
  `id` int(11) NOT NULL,
  `position` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `contact` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brgy_officials`
--

INSERT INTO `brgy_officials` (`id`, `position`, `name`, `image`, `contact`) VALUES
(1, 'Captain', 'Cap', '462574355_623413623350986_670243584951763857_n - Copy.jpg', '0997872321'),
(8, 'Secretary', 'Leizel Abella', 'admin.jpg', '09978723222');

-- --------------------------------------------------------

--
-- Table structure for table `business_permit`
--

CREATE TABLE `business_permit` (
  `business_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `business_permit`
--

INSERT INTO `business_permit` (`business_name`, `address`, `type`, `owner`, `contact`, `id`) VALUES
('Amiel Store', 'Novaliches', 'sari sari', 'Amiel', '09978723222', 2),
('Daniela Store', 'Philand', 'sari sari', 'Daniela', '09123238585', 3);

-- --------------------------------------------------------

--
-- Table structure for table `concerns`
--

CREATE TABLE `concerns` (
  `user_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `descriptions` text NOT NULL,
  `name` varchar(100) NOT NULL,
  `date_submitted` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `concerns`
--

INSERT INTO `concerns` (`user_id`, `title`, `descriptions`, `name`, `date_submitted`) VALUES
(5, 'water', 'leak', 'ronald', '2024-12-12 05:22:42'),
(6, 'Electricity', 'nag jumper kapitbahay namin kaya mataas babayran naming bill', 'Amiel Jake Baril', '2024-12-12 05:35:47');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('resident','barangay','admin') NOT NULL,
  `barangay_id` int(11) DEFAULT NULL,
  `valid_id_type` varchar(255) DEFAULT NULL,
  `valid_id_number` varchar(255) DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT 0,
  `photo` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `role`, `barangay_id`, `valid_id_type`, `valid_id_number`, `is_verified`, `photo`) VALUES
(1, 'Admin', 'admin@example.com', '0192023a7bbd73250516f069df18b500', 'admin', NULL, NULL, NULL, 1, NULL),
(2, 'Andrei Gumangan', 'keisleepyhead@gmail.com', '698d51a19d8a121ce581499d7b701668', 'barangay', 1, NULL, NULL, 1, 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAACWCAYAAABkW7XSAAAAAXNSR0IArs4c6QAAIABJREFUeF5MveezbdeV3Td2PDncfF9CeAABgmBqsnPbkr/IoUpll8squ1T+4P/Qtj6o7LIlS+1WdZPsthhAECSAB7783o0n57P3dv3G2pctSBCo9+49Z4e15hxzzDHHin74vY+qbblRt9fVfDmXtlJWxmomkZK4VFTtpDjW2'),
(3, 'Daniela Berba', 'berbadanielahermosura@gmail.com', 'bcbe3365e6ac95ea2c0343a2395834dd', 'resident', 24561, 'student id', '22012243', 1, 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAACWCAYAAABkW7XSAAAAAXNSR0IArs4c6QAAIABJREFUeF5MvdmTJOl15Xc83D32LffKqq7qjexuLATBmeFsstGM9DBjkp5kMj3MgyjJ9P/pRWaal3ngmIZGSSSIjWADDfRSXV1L7rFv7hEu+53rCahgherKyozwcP++e88999zzJX/6ybNqv69UZQ1tdgetdnvtG7n2VSXtD'),
(5, 'Amiel Jake Baril', 'amieljake929@gmail.com', 'aa4342613fdbc3ee4af3fc2e1dc3c5ef', 'barangay', 3, NULL, NULL, 1, 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAACWCAYAAABkW7XSAAAAAXNSR0IArs4c6QAAIABJREFUeF58vfmPJdmVHnYi3v5yr30j2WRPc9VoaM5wRqLtWWwNaBkSIY1lyAIMGBZg6w+TDQgwYMA/2oLhDZZHFjkz5HDYHJJis7fq6qrKzMr17fGMbzk3IrMpZ6M6qzLfixdx77ln+c53zqke7u1vt9tt4Avf9beIKuqoq'),
(6, 'Luke Chiang', 'lukechiang@gmail.com', 'c938489ddb8330955c187d62e032bb43', 'resident', 1, 'National ID', '12345', 1, 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAACWCAYAAABkW7XSAAAAAXNSR0IArs4c6QAAIABJREFUeF6EvfmPZGl2HXZjX3KprKruWrp7Fg5l7sOhaMqmbQqULQqWSJCmCBik9N/Z8D9gWb8YMGhBhiBAoERpJJJDTk/3DGdhL1XVteQSexhn+97LrJadg56qiox48d633Hvuuefeb/D07P7xeDwW/hvUsUY1qMFgWMfjo'),
(7, 'john michael', 'jmicagbon2004@gmail.com', '03650af23503e08755ce36a2b296db99', 'resident', 0, 'Driver\'s License', 'NO2-223-234234', 1, 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAACWCAYAAABkW7XSAAAAAXNSR0IArs4c6QAAIABJREFUeF6lfduWJbltbFfPgzSS7SeN7P//ztNVZxGBAAIgyMxqtZftqb1zM0kQCFwJfvz7z//6+vnx+ePz68ePH18fP9a/nx/r/3/++IE/1yc/fnz9+PFr/Z8X/z6+8NMPGwe///z6sr8/fYyPH+t/1lvw+dfX148f65kfX'),
(9, 'Jordan', 'jordan@gmail.com', '8e617358cf86c2b4ce01ad8309d2ac33', 'barangay', 5, NULL, NULL, 1, 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAACWCAYAAABkW7XSAAAAAXNSR0IArs4c6QAAIABJREFUeF69fdmWJLmNZXjUQ6da0luV+v8/tCLmkCCI7WIxj9TknB5VuJmRIJYLECTB11//+Pf36/X6+P7+/gj/vr8/Xh/g94+Pj8/XH/ub79f3x9fH634q/6Vbe31QH1+3n/U3/3vtvqUfpoXfWX397Z7zM//uanP9Zsf0/'),
(11, 'kupal', 'kupal@gmail.com', 'c76bf0bd1f2f43dd16b259b2cf484be4', 'resident', 1, 'Driver\'s License', 'NO2-223-234234', 1, 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAACWCAYAAABkW7XSAAAAAXNSR0IArs4c6QAAIABJREFUeF5UvemzJFly3eeREZGRy9tfrV3Vy0wDwwEGHIKSiQQ/kjJJNMn0Sf81RH2QgSLBgYBZuru6u9a35Z4ZQfud4zdfoQaFrnqVS8SNe305fvx49dXlxXA47INfh/0h4tBHzV9GVeyriD4i+t0QbTuN3X4f9aiKJqoYh'),
(12, 'RINI', 'RINI@example.com', '8cc94981380f0845ea0eb85739080959', 'barangay', 6, NULL, NULL, 1, 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAACWCAYAAABkW7XSAAAAAXNSR0IArs4c6QAAIABJREFUeF5cvWmwZedVJbjOcOc35qQcJKWUGixh8CAj22BsBmOMoRqwGVxVVFFUAIUpQwFFNRH1o350dHR1B0FVF9gNNFA2HsAMtjEzZjB4wJMsDMiDrHlISalU5hvvfM89p2Ottb/70v0UGZl67757z/nO9+1h7bXXzn7kh'),
(13, 'Jason', 'jason@example.com', '2b877b4b825b48a9a0950dd5bd1f264d', 'resident', NULL, 'Driver\'s License', 'NO2-223-234235', 1, 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAACWCAYAAABkW7XSAAAAAXNSR0IArs4c6QAAIABJREFUeF5cvXmw7flV3bfPPNzxjf369etBU7fmASEhJGTmSQIMsWICcWLjiAJMIJjEBlJOqIpTKVL5w1WuSkQINjYmCpKQEAIJCUloRIhBrXmiB6nHN9z73p3OPP3iz1r7e+7DV9Xq1+/ee87vfIc9rL322rU3Pv/+al5FL'),
(14, 'Amiel Jake Baril', 'ajb@example.com', '862c9944e2f0cd8cf0dbbde2ec0935d5', 'resident', NULL, 'Driver\'s License', 'NO2-223-234239', 1, 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAACWCAYAAABkW7XSAAAAAXNSR0IArs4c6QAAIABJREFUeF50vWmTZOl1HnbulplVWUuvM5gBZsG+YwCQNMOmbIsiKENk0KJkQQ5KpEGQIqBw0AFFWLLDn/zB4XDYv8dhBRUOfTAEkw5SDIPAEAAHGGAw2Ga6p6e7qyr3m+l4lvPeWw24Bo2ZrsrKvPe973vOc57znHOqu/OTQ'),
(17, 'ronald', 'ronald@gmail.com', '5af0a0feb2094f43bebb50c518c1ebfe', 'resident', 12345, 'Driver\'s License', 'NO2-223-234233', 1, 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAACWCAYAAABkW7XSAAAAAXNSR0IArs4c6QAAIABJREFUeF6MvdmSZNmNLXZ8isisKpEs1sAi2bqS7EoP6rf7/98kyUwiWZnhQ8jWBODs8OzubKtmZoT7GfYALCwsYB9+++FP76ftsD229+3x/r7hz+Owbe/4b8N/B/7siL+9b9vpsG2Hw5G/vL8/tjt+ftBnNnwWX8Tf+P0Hf'),
(18, 'Christine May Hieto', 'christinehieto@example.com', '723e1489a45d2cbaefec82eee410abd5', 'resident', 123456, 'Driver\'s License', 'NO2-223-234239', 1, 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAACWCAYAAABkW7XSAAAAAXNSR0IArs4c6QAAIABJREFUeF7Nfdua9bitXHfPRbwT21fbTt7/PadXPpKCBEEFVIFrjZPeh/m7RZE4FAogRVHf//rbP19f319fX1+vr9f4z/Hz8/399Xr9fn2ti7ef73nNt16Xxz3fr6+v39fv6u173Hu/39+7/j3GePb1GHOJ+DV6HveNscbvS');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barangays`
--
ALTER TABLE `barangays`
  ADD PRIMARY KEY (`barangay_id`);

--
-- Indexes for table `barangay_clearance`
--
ALTER TABLE `barangay_clearance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blotter_appointments`
--
ALTER TABLE `blotter_appointments`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `blotter_reports`
--
ALTER TABLE `blotter_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brgy_officials`
--
ALTER TABLE `brgy_officials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `business_permit`
--
ALTER TABLE `business_permit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `concerns`
--
ALTER TABLE `concerns`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcement`
--
ALTER TABLE `announcement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `barangays`
--
ALTER TABLE `barangays`
  MODIFY `barangay_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `barangay_clearance`
--
ALTER TABLE `barangay_clearance`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `blotter_appointments`
--
ALTER TABLE `blotter_appointments`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `blotter_reports`
--
ALTER TABLE `blotter_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `brgy_officials`
--
ALTER TABLE `brgy_officials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `business_permit`
--
ALTER TABLE `business_permit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `concerns`
--
ALTER TABLE `concerns`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
