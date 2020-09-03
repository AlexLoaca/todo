-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2020 at 04:29 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `todo`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_sessions`
--

CREATE TABLE `account_sessions` (
  `session_id` int(255) NOT NULL,
  `account_id` int(50) UNSIGNED NOT NULL,
  `login_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `id` int(255) NOT NULL,
  `title` varchar(400) NOT NULL,
  `description` varchar(30000) NOT NULL,
  `expiration` date NOT NULL,
  `complete` tinyint(1) NOT NULL,
  `user_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`id`, `title`, `description`, `expiration`, `complete`, `user_id`) VALUES
(1, 'My title', 'Task chestii', '2019-12-14', 1, 59),
(2, 'Pizza Recipe', 'I told him if he helped me make it I would talk about him on my website and he would be famous. That seemed to get his attention. He thought the dough was â€œslimy and grossâ€ but he loved picking his own toppings, and the finished product was â€œawesomeâ€.', '2019-12-16', 0, 58),
(3, 'Pasta Recipe', 'Add flour to pot with butter and whisk until foaming and a light pale roux paste forms. Whisking constantly, slowly add about Â¼ cup milk to roux until completely incorporated. Continue to gradually whisk in milk, very slowly, until mixture is bubbly and thickened.', '2019-12-17', 0, 59),
(4, 'Sandwich Recipe', 'This is a hearty grilled sandwich with a distinctive and delicious combination of ingredients. The pickle slices add a bit of fun, and the barbecue sauce provides a hint of sweetness that\'s irresistible. â€”Henry Mujica, North Riverside, Illinois', '2020-12-15', 1, 58),
(5, 'Turkey Recipe', 'On the day, heat oven to 180C/160C fan/gas 4. Tip the whole shallots into a bowl with the thyme, bay and remaining 1 tbsp butter, then season and toss to coat. Lift the turkey into a roasting tin, massage the olive oil into the skin and season well if you havenâ€™t already seasoned ahead. Tip the shallots into the roasting tin, around the turkey, and stuff the lemon halves into the cavity. Cover the tin loosely with foil and roast for the calculated cooking time.', '2019-12-20', 0, 59),
(6, 'Salmon Recipe', 'Add wine, juice of 1 lemon, garlic, and red pepper flakes. Bring to a simmer and cook, basting salmon occasionally with a spoon. When salmon is opaque, remove from skillet. Add butter and remaining lemon juice to pan and whisk to combine with the sauce. Let simmer until thickened slightly, 2 minutes.\r\nServe fish drizzled with pan sauce and topped with fresh lemon slices and dill.', '2020-11-23', 0, 58);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`) VALUES
(58, 'Alex', 'alexyno8@yahoo.com', 'c303b71de8348e2cb4298307f2a4244f'),
(59, 'Alexyno', 'aa@ss.cc', 'c303b71de8348e2cb4298307f2a4244f'),
(60, 'Test', 'test@gmail.com', 'c303b71de8348e2cb4298307f2a4244f');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_sessions`
--
ALTER TABLE `account_sessions`
  ADD PRIMARY KEY (`session_id`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_sessions`
--
ALTER TABLE `account_sessions`
  MODIFY `session_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
