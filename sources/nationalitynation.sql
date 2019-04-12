/*
 Navicat Premium Data Transfer

 Source Server         : Localhost
 Source Server Type    : MariaDB
 Source Server Version : 100214
 Source Host           : localhost:3306
 Source Schema         : ergast-f1

 Target Server Type    : MariaDB
 Target Server Version : 100214
 File Encoding         : 65001

 Date: 10/04/2019 19:13:30
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for nationalitynation
-- ----------------------------
DROP TABLE IF EXISTS `nationalitynation`;
CREATE TABLE `nationalitynation`  (
  `nationality_name` char(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `country_name` char(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL
) ENGINE = MyISAM CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of nationalitynation
-- ----------------------------
INSERT INTO `nationalitynation` VALUES ('American', 'United States');
INSERT INTO `nationalitynation` VALUES ('American-Italian', 'United States');
INSERT INTO `nationalitynation` VALUES ('Argentine', 'Argentina');
INSERT INTO `nationalitynation` VALUES ('Argentine-Italian', 'Argentina');
INSERT INTO `nationalitynation` VALUES ('Australian', 'Australia');
INSERT INTO `nationalitynation` VALUES ('Austrian', 'Austria');
INSERT INTO `nationalitynation` VALUES ('Belgian', 'Belgium');
INSERT INTO `nationalitynation` VALUES ('Belgium', 'Belgium');
INSERT INTO `nationalitynation` VALUES ('Brazilian', 'Brazil');
INSERT INTO `nationalitynation` VALUES ('British', 'United Kingdom');
INSERT INTO `nationalitynation` VALUES ('Canadian', 'Canada');
INSERT INTO `nationalitynation` VALUES ('Chilean', 'Chile');
INSERT INTO `nationalitynation` VALUES ('Colombian', 'Colombia');
INSERT INTO `nationalitynation` VALUES ('Czech', 'Czech Republic');
INSERT INTO `nationalitynation` VALUES ('Danish', 'Denmark');
INSERT INTO `nationalitynation` VALUES ('Dutch', 'Netherlands');
INSERT INTO `nationalitynation` VALUES ('East German', 'Germany');
INSERT INTO `nationalitynation` VALUES ('Finnish', 'Finland');
INSERT INTO `nationalitynation` VALUES ('French', 'France');
INSERT INTO `nationalitynation` VALUES ('German', 'Germany');
INSERT INTO `nationalitynation` VALUES ('Hong Kong', 'Hong Kong');
INSERT INTO `nationalitynation` VALUES ('Hungarian', 'Hungary');
INSERT INTO `nationalitynation` VALUES ('Indian', 'India');
INSERT INTO `nationalitynation` VALUES ('Indonesian', 'Indonesia');
INSERT INTO `nationalitynation` VALUES ('Irish', 'Ireland');
INSERT INTO `nationalitynation` VALUES ('Italian', 'Italy');
INSERT INTO `nationalitynation` VALUES ('Japanese', 'Japan');
INSERT INTO `nationalitynation` VALUES ('Liechtensteiner', 'Liechtenstein');
INSERT INTO `nationalitynation` VALUES ('Malaysian', 'Malaysia');
INSERT INTO `nationalitynation` VALUES ('Mexican', 'Mexico');
INSERT INTO `nationalitynation` VALUES ('Monegasque', 'Monaco');
INSERT INTO `nationalitynation` VALUES ('New Zealand', 'New Zealand');
INSERT INTO `nationalitynation` VALUES ('New Zealander', 'New Zealand');
INSERT INTO `nationalitynation` VALUES ('Polish', 'Poland');
INSERT INTO `nationalitynation` VALUES ('Portuguese', 'Portugal');
INSERT INTO `nationalitynation` VALUES ('Rhodesian', 'Zimbabwe');
INSERT INTO `nationalitynation` VALUES ('Russian', 'Russia');
INSERT INTO `nationalitynation` VALUES ('South African', 'South Africa');
INSERT INTO `nationalitynation` VALUES ('Spanish', 'Spain');
INSERT INTO `nationalitynation` VALUES ('Swedish', 'Sweden');
INSERT INTO `nationalitynation` VALUES ('Swiss', 'Switzerland');
INSERT INTO `nationalitynation` VALUES ('Thai', 'Thailand');
INSERT INTO `nationalitynation` VALUES ('Uruguayan', 'Uruguay');
INSERT INTO `nationalitynation` VALUES ('Venezuelan', 'Venezuela');

SET FOREIGN_KEY_CHECKS = 1;
