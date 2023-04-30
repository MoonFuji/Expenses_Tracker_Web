SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `categories` (`category_id`, `name`) VALUES
(1, 'Groceries'),
(2, 'Utilities'),
(3, 'Rent'),
(4, 'Transportation'),
(5, 'Entertainment');

CREATE TABLE `revenue` (
  `revenue_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `date_added` date NOT NULL DEFAULT current_timestamp(),
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `revenue` (`revenue_id`, `user_id`, `amount`, `date_added`, `description`) VALUES
(1, 1, '5000.00', '2022-01-01', 'Salary'),
(2, 1, '1000.00', '2022-02-01', 'Bonus'),
(3, 2, '3000.00', '2022-01-15', 'Freelancing'),
(4, 2, '2000.00', '2022-02-15', 'Part-time job'),
(5, 3, '4000.00', '2022-01-30', 'Investment return'),
(6, 3, '1500.00', '2022-02-28', 'Savings interest'),
(7, 2, '123.00', '0000-00-00', 'lol'),
(8, 2, '1.00', '0000-00-00', 'e'),
(9, 2, '3.00', '2023-04-26', 'Freelancin'),
(10, 2, '3.00', '2023-04-26', 'Freelanci');

CREATE TABLE `sub_users` (
  `sub_user_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('sub_user') NOT NULL,
  `status` enum('active','disabled') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `sub_users` (`sub_user_id`, `user_id`, `username`, `password`, `email`, `role`, `status`) VALUES
(1, 1, 'subuser1', 'subuser123', 'subuser1@example.com', 'sub_user', 'active'),
(2, 1, 'subuser2', 'subuser123', 'subuser2@example.com', 'sub_user', 'disabled'),
(3, 2, 'subuser3', 'subuser123', 'subuser3@example.com', 'sub_user', 'active');

CREATE TABLE `transfers` (
  `transfer_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
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
  `user_id` int(11) NOT NULL  PRIMARY KEY AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('admin','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `role`) VALUES
(1, 'admin', 'admin123', 'admin@example.com', 'admin'),
(2, 'user1', 'user123', 'user1@example.com', 'user'),
(3, 'user2', 'user123', 'user2@example.com', 'user');

  CREATE TABLE `expenses` (
  `expense_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `date_added` date NOT NULL DEFAULT current_timestamp(),
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `expenses` (`expense_id`, `user_id`, `category_id`, `amount`, `date_added`, `description`) VALUES
(1, 2, 1, '500.00', '2022-01-10', 'Groceries for the week'),
(2, 2, 2, '200.00', '2022-01-15', 'Electricity bill'),
(3, 2, 3, '1000.00', '2022-01-31', 'Rent for the month'),
(4, 2, 4, '300.00', '2022-02-05', 'Gas for the car'),
(5, 2, 5, '150.00', '2022-02-20', 'Movie tickets'),
(6, 3, 1, '800.00', '2022-01-05', 'Groceries for the month'),
(7, 3, 2, '300.00', '2022-01-20', 'Internet bill'),
(8, 3, 4, '250.00', '2022-02-10', 'Train ticket'),
(9, 3, 5, '100.00', '2022-02-25', 'Concert tickets');

ALTER TABLE `revenue`
  ADD KEY `fk_revenue_user_id` (`user_id`);

ALTER TABLE `sub_users`
  ADD KEY `fk_sub_user_user_id` (`user_id`);

ALTER TABLE `transfers`
  ADD KEY `fk_transfer_from_user_id` (`from_user_id`),
  ADD KEY `fk_transfer_to_user_id` (`to_user_id`);

ALTER TABLE `expenses`
  ADD KEY `fk_expense_user_id` (`user_id`),
  ADD KEY `fk_expense_category_id` (`category_id`);



ALTER TABLE `revenue`
  ADD CONSTRAINT `fk_revenue_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `sub_users`
  ADD CONSTRAINT `fk_sub_user_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `transfers`
  ADD CONSTRAINT `fk_transfer_from_user_id` FOREIGN KEY (`from_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_transfer_to_user_id` FOREIGN KEY (`to_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;







ALTER TABLE `expenses`
  ADD CONSTRAINT `fk_expense_category_id` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_expense_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
