/*
 Navicat Premium Data Transfer

 Source Server         : local_vagrant
 Source Server Type    : MySQL
 Source Server Version : 80029
 Source Host           : 192.168.56.10:3306
 Source Schema         : users

 Target Server Type    : MySQL
 Target Server Version : 80029
 File Encoding         : 65001

 Date: 17/09/2022 14:00:55
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `date_birth` int NOT NULL,
  `sex` int NOT NULL,
  `motherland` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
BEGIN;
INSERT INTO `users` (`id`, `firstname`, `lastname`, `date_birth`, `sex`, `motherland`) VALUES (1, 'Bob', 'Merlin', 495656638, 1, 'Minsk');
INSERT INTO `users` (`id`, `firstname`, `lastname`, `date_birth`, `sex`, `motherland`) VALUES (3, 'Marry', 'Clark', 1126808638, 0, 'Urupinsk');
INSERT INTO `users` (`id`, `firstname`, `lastname`, `date_birth`, `sex`, `motherland`) VALUES (4, 'Pavel', 'Ivanov', 969042238, 1, 'New York');
INSERT INTO `users` (`id`, `firstname`, `lastname`, `date_birth`, `sex`, `motherland`) VALUES (14, 'Piter', 'Parker', 180168892, 1, 'New York');
INSERT INTO `users` (`id`, `firstname`, `lastname`, `date_birth`, `sex`, `motherland`) VALUES (15, 'Tony', 'Stark', 464248492, 1, 'Bashkortostan');
INSERT INTO `users` (`id`, `firstname`, `lastname`, `date_birth`, `sex`, `motherland`) VALUES (16, 'Chelovek', 'Muravei', 1316242492, 1, 'Bakkhlama');
INSERT INTO `users` (`id`, `firstname`, `lastname`, `date_birth`, `sex`, `motherland`) VALUES (17, 'Rasmus', 'Lerdorf', 53938492, 1, 'Qeqertarsuaq');
INSERT INTO `users` (`id`, `firstname`, `lastname`, `date_birth`, `sex`, `motherland`) VALUES (18, 'Baba', 'Jaga', 338021692, 0, 'Forest');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
