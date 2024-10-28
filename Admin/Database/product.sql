DROP DATABASE IF EXISTS shopping;

CREATE DATABASE IF NOT EXISTS shopping;

SHOW DATABASES;

USE shopping;


-- -----------------------------------------------------
-- Table `user`
-- Create a new account at register
-- Login an accouunt using username and password
-- It is a role for admin, manager, ntid and register
-- It is connected by role
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `user` (
  `iduser` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(100) NOT NULL,
  `password` VARCHAR(100) NOT NULL,
  `fullname` VARCHAR(200) NOT NULL,
  `upload_image` VARCHAR(50) NOT NULL,
  `date` VARCHAR(50) NOT NULL,
  `time` VARCHAR(50) NOT NULL,
  `role` INT NULL,
  `email` VARCHAR(120) NOT NULL,
  PRIMARY KEY (`iduser`),
  INDEX `role_id` (`role` ASC)
);



-- -----------------------------------------------------
-- Table `venue`
-- It is for local only
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `venue` (
  `idvenue` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `capacity` INT NULL,
  PRIMARY KEY (`idvenue`),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC));

INSERT INTO `venue` (`idvenue`, `name`, `capacity`) VALUES
(1, 'RIT', 1);


-- -----------------------------------------------------
-- Table `product`
-- It is for showing all data to all roles only
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `product` (
  `idproduct` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `artist` VARCHAR(50) NOT NULL,
  `year` VARCHAR(50) NOT NULL,
  `datepost` VARCHAR(50) NOT NULL,
  `datestart` DATE NOT NULL,
  `dateend` DATE NOT NULL,
  `numberallowed` INT NOT NULL,
  `venue` INT NOT NULL,
  `description` VARCHAR(10000) NOT NULL,
  `image` VARCHAR(50) NOT NULL,
  `location_image` VARCHAR(50) NOT NULL,
  `video` VARCHAR(50) NOT NULL,
  `location_video` VARCHAR(50) NOT NULL,
  `time` VARCHAR(50) NOT NULL,
  `qrCodeImage` VARCHAR(50) NOT NULL,
  `whoisposted` VARCHAR(200) NOT NULL,
  PRIMARY KEY (`idproduct`),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC),
  INDEX `venue_fk_idx` (`venue` ASC));


INSERT INTO `product`(
  `idproduct`, 
  `name`, 
  `artist`, 
  `year`,
  `datepost`, 
  `datestart`, 
  `dateend`, 
  `numberallowed`, 
  `venue`, 
  `description`, 
  `image`, 
  `location_image`, 
  `video`, 
  `location_video`,
  `time`,
  `qrCodeImage`,
  `whoisposted`
) 
VALUES(
  1, 
  'The Sentinel', 
  'Unknown', 
  'Unknown',
  '2021-11-08', 
  '2021-11-08', 
  '2050-12-29', 
  1, 
  1, 
  'Weighing in at 110 tons and measuring 73 feet, The Sentinel represents the transformative nature of education. The unique blend and juxtipostioning of materials and shapes serves to visually represent RIT s mission of shaping and improving the world through creativity and innovation.',
  '1_Sentinel.JPG', 
  'upload/1_Sentinel.JPG', 
  '1_Sentinel.JPG', 
  '656300853',
  '05:24:00pm',
  'images/61b904337d69c.png',
  'Ike Chukz'
);

-- -----------------------------------------------------
-- Table `session`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `session` (
  `idsession` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `numberallowed` INT NOT NULL,
  `product` INT NOT NULL,
  `startdate` DATETIME NOT NULL,
  `enddate` DATETIME NOT NULL,
  PRIMARY KEY (`idsession`)
);


-- -----------------------------------------------------
-- Table `manager_product`
-- product for all data in admin.php
-- manager for only some data in products.php
-- nuseai and manager are showed new record when insert at the same time.
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `manager_product` (
  `product` INT NOT NULL,
  `manager` INT NOT NULL,
	PRIMARY KEY (`product`, `manager`)
); 


-- -----------------------------------------------------
-- Table `role`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `role` (
  `idrole` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idrole`),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC));

INSERT INTO `role` (`name`) values ('admin'),('product manager'),('product ntid'),('user');


-- Store data for (Send the email)
CREATE TABLE IF NOT EXISTS `pwdreset` (
  `pwdResetId` int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
  `pwdResetEmail` TEXT NOT NULL,
  `pwdResetSelector` TEXT NOT NULL,
  `pwdResetToken` LONGTEXT NOT NULL,
  `pwdResetExpires` TEXT NOT NULL
);