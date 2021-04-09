-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 09, 2021 at 08:58 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hamitech`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
                             `id` int(11) NOT NULL,
                             `fullname` varchar(100) NOT NULL,
                             `phone` varchar(20) NOT NULL,
                             `username` varchar(100) NOT NULL,
                             `password` varchar(100) NOT NULL,
                             `last_login` bigint(20) NOT NULL,
                             `cdate` bigint(20) NOT NULL,
                             `status` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `fullname`, `phone`, `username`, `password`, `last_login`, `cdate`, `status`) VALUES
(2, 'هادی :)', '09218248954', 'root', '1234', 1617951462, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
                            `id` int(11) NOT NULL,
                            `first_name` varchar(50) NOT NULL,
                            `last_name` varchar(50) NOT NULL,
                            `national_code` varchar(10) NOT NULL,
                            `phone` varchar(20) NOT NULL,
                            `username` varchar(50) NOT NULL,
                            `password` varchar(50) NOT NULL,
                            `birthday` bigint(20) NOT NULL,
                            `created_at` bigint(20) NOT NULL,
                            `updated_at` bigint(20) DEFAULT NULL,
                            `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `first_name`, `last_name`, `national_code`, `phone`, `username`, `password`, `birthday`, `created_at`, `updated_at`, `status`) VALUES
(3, 'سید هادی', 'رنجبر', '0000000000', '09218248954', 'Hadi', 'root', 1616358600, 1617910804, 1617951471, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
    ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
