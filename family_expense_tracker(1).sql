SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `family_expense_tracker` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `family_expense_tracker`;

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `categories` (`category_id`, `category_name`, `user_id`) VALUES
(1, 'Groceries', 2),
(2, 'Utilities', 2),
(3, 'Rent', 4),
(4, 'Transportation', 4),
(5, 'Entertainment', 0);

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
(4, 2, NULL, 4, '300.00', 'Gas for the car', '2022-02-05'),
(6, 3, NULL, 1, '800.00', 'Groceries for the month', '2022-01-05'),
(7, 3, NULL, 2, '300.00', 'Internet bill', '2022-01-20'),
(8, 3, NULL, 4, '250.00', 'Train ticket', '2022-02-10'),
(9, 3, NULL, 5, '100.00', 'Concert tickets', '2022-02-25'),
(10, 2, NULL, 2, '2.00', 'ex', '2023-05-07');

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
(1, 1, NULL, 0, '5000.00', 'Salary', '2022-01-01'),
(2, 1, NULL, 0, '1000.00', 'Bonus', '2022-02-01'),
(3, 2, NULL, 0, '3000.00', 'Freelancing', '2022-01-15'),
(4, 2, NULL, 0, '2000.00', 'Part-time job', '2022-02-15'),
(5, 3, NULL, 0, '4000.00', 'Investment return', '2022-01-30'),
(6, 3, NULL, 0, '1500.00', 'Savings interest', '2022-02-28'),
(14, 4, NULL, 0, '123.00', 'ayou', '2023-05-01'),
(15, 2, NULL, 2, '1.00', 'lol', '2023-05-04'),
(16, 2, NULL, 2, '1.00', 'lol', '2023-05-04'),
(17, 2, NULL, 2, '1.00', 'lol', '2023-05-04'),
(18, 2, NULL, 2, '3.00', 'rev', '2023-05-18'),
(19, 2, NULL, 2, '3.00', 'rev', '2023-05-18');

CREATE TABLE `sub_users` (
  `sub_user_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `status` enum('active','disabled') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `sub_users` (`sub_user_id`, `user_id`, `username`, `password`, `email`, `status`) VALUES
(1, 1, 'subuser1', 'subuser123', 'subuser1@example.com', 'active'),
(2, 1, 'subuser2', 'subuser123', 'subuser2@example.com', 'disabled'),
(3, 2, 'subuser3', 'subuser123', 'subuser3@example.com', 'active');

CREATE TABLE `transfers` (
  `transfer_id` int(11) NOT NULL,
  `from_user_id` int(11) NOT NULL,
  `to_user_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `date_added` date NOT NULL DEFAULT current_timestamp(),
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `transfers` (`transfer_id`, `from_user_id`, `to_user_id`, `amount`, `date_added`, `description`) VALUES
(1, 1, 2, '1000.00', '2022-01-15', 'Transfer to user1'),
(2, 1, 3, '2000.00', '2022-02-01', 'Transfer to user2'),
(3, 2, 3, '500.00', '2022-02-20', 'Transfer to subuser3');

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`user_id`, `username`, `password`) VALUES
(1, 'admin', 'admin123'),
(2, 'user1', 'user123'),
(3, 'user2', 'user123'),
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
  ADD PRIMARY KEY (`sub_user_id`,`user_id`) USING BTREE,
  ADD KEY `fk_sub_user_user_id` (`user_id`);

ALTER TABLE `transfers`
  ADD PRIMARY KEY (`transfer_id`),
  ADD KEY `fk_transfer_from_user_id` (`from_user_id`),
  ADD KEY `fk_transfer_to_user_id` (`to_user_id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);


ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

ALTER TABLE `expenses`
  MODIFY `expense_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

ALTER TABLE `revenue`
  MODIFY `revenue_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

ALTER TABLE `sub_users`
  MODIFY `sub_user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `transfers`
  MODIFY `transfer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  ADD CONSTRAINT `fk_transfer_from_user_id` FOREIGN KEY (`from_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_transfer_to_user_id` FOREIGN KEY (`to_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
