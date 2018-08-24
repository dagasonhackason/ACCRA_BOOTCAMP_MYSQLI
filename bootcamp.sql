--       ============================================================================================================
--
--       =============================== CREATED WITH ALL THE ❤ LOVE ❤ IN THE WORLD ================================
--
--       ============================================================================================================
--
--
--              .8.              ,o888888o.        ,o888888o.    8 888888888o.            .8.           8 888888888o       ,o888888o.         ,o888888o.     8888888 8888888888     ,o888888o.             .8.                   ,8.       ,8.          8 888888888o
--             .888.            8888     `88.     8888     `88.  8 8888    `88.          .888.          8 8888    `88.  . 8888     `88.    . 8888     `88.         8 8888          8888     `88.          .888.                 ,888.     ,888.         8 8888    `88.
--            :88888.        ,8 8888       `8. ,8 8888       `8. 8 8888     `88         :88888.         8 8888     `88 ,8 8888       `8b  ,8 8888       `8b        8 8888       ,8 8888       `8.        :88888.               .`8888.   .`8888.        8 8888     `88
--           . `88888.       88 8888           88 8888           8 8888     ,88        . `88888.        8 8888     ,88 88 8888        `8b 88 8888        `8b       8 8888       88 8888                 . `88888.             ,8.`8888. ,8.`8888.       8 8888     ,88
--          .8. `88888.      88 8888           88 8888           8 8888.   ,88'       .8. `88888.       8 8888.   ,88' 88 8888         88 88 8888         88       8 8888       88 8888                .8. `88888.           ,8'8.`8888,8^8.`8888.      8 8888.   ,88'
--         .8`8. `88888.     88 8888           88 8888           8 888888888P'       .8`8. `88888.      8 8888888888   88 8888         88 88 8888         88       8 8888       88 8888               .8`8. `88888.         ,8' `8.`8888' `8.`8888.     8 888888888P'
--        .8' `8. `88888.    88 8888           88 8888           8 8888`8b          .8' `8. `88888.     8 8888    `88. 88 8888        ,8P 88 8888        ,8P       8 8888       88 8888              .8' `8. `88888.       ,8'   `8.`88'   `8.`8888.    8 8888
--       .8'   `8. `88888.   `8 8888       .8' `8 8888       .8' 8 8888 `8b.       .8'   `8. `88888.    8 8888      88 `8 8888       ,8P  `8 8888       ,8P        8 8888       `8 8888       .8'   .8'   `8. `88888.     ,8'     `8.`'     `8.`8888.   8 8888
--      .888888888. `88888.     8888     ,88'     8888     ,88'  8 8888   `8b.    .888888888. `88888.   8 8888    ,88'  ` 8888     ,88'    ` 8888     ,88'         8 8888          8888     ,88'   .888888888. `88888.   ,8'       `8        `8.`8888.  8 8888
--     .8'       `8. `88888.     `8888888P'        `8888888P'    8 8888     `88. .8'       `8. `88888.  8 888888888P       `8888888P'         `8888888P'           8 8888           `8888888P'    .8'       `8. `88888. ,8'         `         `8.`8888. 8 8888
--
--
--       *************************************************************************************************************
--       *                                                                                                           *
--       *                        Content:    MYSQL                                                                  *
--       *                        Website:    http://www.dagasonhackason.com/                                        *
--       *                                                                                                           *
--       *************************************************************************************************************

-- Let us create our Database
CREATE DATABASE IF NOT EXISTS `accra_bootcamp`;
USE `accra_bootcamp`;

-- Let us create our main User-Accounts Table
CREATE TABLE IF NOT EXISTS `users_table` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `is_activated` enum('Y','N') NOT NULL DEFAULT 'N',
  `username` varchar(500) NOT NULL,
  `username_validate` varchar(500) NOT NULL,
  `password` varchar(500) NOT NULL,
  `password_validate` varchar(500) NOT NULL,
  `email` varchar(500) NOT NULL,
  `full_name` varchar(500) NOT NULL,
  `gender` enum('MALE','FEMALE') NOT NULL DEFAULT 'MALE',
  `is_deleted` enum('Y','N') NOT NULL DEFAULT 'N',
  `reg_date` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Let us Dump Example DATA into User-Accounts Table
INSERT IGNORE INTO `users_table` (`id`, `is_activated`, `username`, `username_validate`, `password`, `password_validate`, `email`, `full_name`, `gender`, `is_deleted`, `reg_date`) VALUES
	(1, 'N', 'username', 'username_validate', 'password', 'password_validate', 'email', 'full_name', 'MALE', 'N', 'reg_date');

-- Let us create our login-logs Table
CREATE TABLE IF NOT EXISTS `users_login_log_table` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `account_id` varchar(500) NOT NULL,
  `time_logged_in` varchar(500) NOT NULL,
  `time_logged_out` varchar(500) NOT NULL,
  `login_type` enum('COOKIE','SESSION','APP') NOT NULL DEFAULT 'SESSION',
  `is_reported` enum('Y','N') NOT NULL DEFAULT 'N',
  `is_blocked` enum('Y','N') NOT NULL DEFAULT 'N',
  `auth_key` text NOT NULL,
  `auth_key_validate` text NOT NULL,
  PRIMARY KEY (`id`)
) AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Let us Dump Example DATA into login-logs Table
INSERT IGNORE INTO `users_login_log_table` (`id`, `account_id`, `time_logged_in`, `time_logged_out`, `login_type`, `is_reported`, `is_blocked`, `auth_key`, `auth_key_validate`) VALUES
	(1, 'account_id', 'time_logged_in', 'time_logged_out', 'COOKIE', 'N', 'N', 'auth_key', 'auth_key_validate');


