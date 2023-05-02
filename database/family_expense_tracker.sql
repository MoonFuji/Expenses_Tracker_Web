SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `family_expense_tracker_g4_16` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `family_expense_tracker_g4_16`;

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `categories` (`category_id`, `category_name`, `user_id`) VALUES
(1, 'Transfers', 2),
(2, 'Utilities', 2),
(3, 'Rent', 4),
(4, 'Transportation', 4),
(6, 'car', 2);

CREATE TABLE `expenses` (
  `expense_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `sub_user_id` int(11) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `expense_amount` decimal(10,2) NOT NULL,
  `expense_description` text NOT NULL,
  `date_added` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `expenses` (`expense_id`, `user_id`, `sub_user_id`, `category_id`, `expense_amount`, `expense_description`, `date_added`) VALUES
(4, 2, NULL, 6, '3000.00', 'Gas for the JAAAAG', '2023-05-04'),
(6, 3, NULL, 2, '800.00', 'Groceries for the month', '2022-01-05'),
(7, 3, NULL, 2, '300.00', 'Internet bill', '2022-01-20'),
(8, 3, NULL, 4, '250.00', 'Train ticket', '2022-02-10'),
(17, 2, NULL, 1, '1.00', 'Transfer to mooon', '2023-05-02'),
(18, 2, NULL, 1, '1.00', 'Transfer to mooon', '2023-05-02'),
(19, 2, NULL, 1, '1.00', 'Transfer to Moooooncef', '2023-05-02');

CREATE TABLE `revenue` (
  `revenue_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `sub_user_id` int(11) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `revenue_amount` decimal(10,2) NOT NULL,
  `revenue_description` text DEFAULT NULL,
  `date_added` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `revenue` (`revenue_id`, `user_id`, `sub_user_id`, `category_id`, `revenue_amount`, `revenue_description`, `date_added`) VALUES
(3, 2, NULL, 1, '3000.00', 'Freelancing', '2022-01-15'),
(4, 2, NULL, 1, '2000.00', 'Part-time job', '2022-02-15'),
(5, 3, NULL, 1, '4000.00', 'Investment return', '2022-01-30'),
(6, 3, NULL, 1, '1500.00', 'Savings interest', '2022-02-28'),
(14, 4, NULL, 1, '123.00', 'ayou', '2023-05-01'),
(15, 2, NULL, 2, '10000.00', 'weed', '2023-05-04'),
(22, 2, 6, 1, '123.00', 'Transfer from user1', '2023-05-02'),
(27, 2, 6, 1, '1.00', 'Transfer from user1', '2023-05-02'),
(29, 2, 9, 1, '1.00', 'Transfer from user1', '2023-05-02');

CREATE TABLE `sub_users` (
  `sub_user_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('active','disabled') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `sub_users` (`sub_user_id`, `user_id`, `username`, `password`, `status`) VALUES
(6, 2, 'mooon', '123', 'active'),
(9, 2, 'Moooooncef', '123', 'active');

CREATE TABLE `transfers` (
  `transfer_id` int(11) NOT NULL,
  `from_user_id` int(11) NOT NULL,
  `to_user_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `date_added` date NOT NULL DEFAULT current_timestamp(),
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `transfers` (`transfer_id`, `from_user_id`, `to_user_id`, `amount`, `date_added`, `description`) VALUES
(7, 2, 6, '123.00', '2023-05-02', 'Transfer to mooon'),
(8, 2, 6, '1.00', '2023-05-02', 'Transfer to mooon'),
(9, 2, 6, '1.00', '2023-05-02', 'Transfer to mooon'),
(10, 2, 9, '1.00', '2023-05-02', 'Transfer to Moooooncef');

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`user_id`, `username`, `password`) VALUES
(2, 'Mouncef', '86'),
(3, 'IMAD', '12'),
(4, 'moon', '1');


ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD KEY `fk_user_id_categories` (`user_id`);

ALTER TABLE `expenses`
  ADD PRIMARY KEY (`expense_id`),
  ADD KEY `fk_expense_user_id` (`user_id`),
  ADD KEY `fk_expense_category_id` (`category_id`),
  ADD KEY `fk_subuser_id_expense` (`sub_user_id`);

ALTER TABLE `revenue`
  ADD PRIMARY KEY (`revenue_id`),
  ADD KEY `fk_revenue_user_id` (`user_id`),
  ADD KEY `fk_sub_users_revenue` (`sub_user_id`),
  ADD KEY `fk_category_id_revenue` (`category_id`);

ALTER TABLE `sub_users`
  ADD PRIMARY KEY (`sub_user_id`),
  ADD KEY `fk_sub_user_user_id` (`user_id`);

ALTER TABLE `transfers`
  ADD PRIMARY KEY (`transfer_id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);


ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

ALTER TABLE `expenses`
  MODIFY `expense_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

ALTER TABLE `revenue`
  MODIFY `revenue_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

ALTER TABLE `sub_users`
  MODIFY `sub_user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

ALTER TABLE `transfers`
  MODIFY `transfer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;


ALTER TABLE `categories`
  ADD CONSTRAINT `fk_user_id_categories` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

ALTER TABLE `expenses`
  ADD CONSTRAINT `fk_expense_category_id` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_expense_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_subuser_id_expense` FOREIGN KEY (`sub_user_id`) REFERENCES `sub_users` (`sub_user_id`);

ALTER TABLE `revenue`
  ADD CONSTRAINT `fk_category_id_revenue` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`),
  ADD CONSTRAINT `fk_revenue_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_subusers_revenue` FOREIGN KEY (`sub_user_id`) REFERENCES `sub_users` (`sub_user_id`);

ALTER TABLE `sub_users`
  ADD CONSTRAINT `fk_sub_user_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `transfers`
  ADD CONSTRAINT `fk_transfer_from_user_id` FOREIGN KEY (`from_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
