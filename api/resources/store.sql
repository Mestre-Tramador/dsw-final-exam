-- CREATE THE DATABASE
CREATE DATABASE `store` CHARACTER SET `utf8mb4` COLLATE `utf8mb4_general_ci`;

-- USE THE DATABASE
USE `store`;

-- CREATE THE TABLE FOR PERSONS
CREATE TABLE `person` (
	`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `address_id` BIGINT UNSIGNED,
	`type` ENUM('physical', 'legal') CHARACTER SET `utf8mb4` COLLATE `utf8mb4_general_ci` NOT NULL,
	`name` VARCHAR(255) CHARACTER SET `utf8mb4` COLLATE `utf8mb4_general_ci` NOT NULL,
	`surname` VARCHAR(255) CHARACTER SET `utf8mb4` COLLATE `utf8mb4_general_ci` NOT NULL,
	`gender` ENUM('F', 'M', 'O') CHARACTER SET `utf8mb4` COLLATE `utf8mb4_general_ci` NOT NULL,
	`document` VARCHAR(14) CHARACTER SET `utf8mb4` COLLATE `utf8mb4_general_ci` NOT NULL,
	`phone` VARCHAR(10) CHARACTER SET `utf8mb4` COLLATE `utf8mb4_general_ci`,
	`cellphone` VARCHAR(11) CHARACTER SET `utf8mb4` COLLATE `utf8mb4_general_ci`,
	`birth_date` DATE NOT NULL,
	`created_at` DATETIME NOT NULL,
	`updated_at` DATETIME NOT NULL,
	`deleted_at` DATETIME,
	PRIMARY KEY (`id`)
);

-- CREATE THE TABLE FOR ADDRESSES
CREATE TABLE `address` (
	`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`zip_code` VARCHAR(8) CHARACTER SET `utf8mb4` COLLATE `utf8mb4_general_ci` NOT NULL,
	`street` VARCHAR(255) CHARACTER SET `utf8mb4` COLLATE `utf8mb4_general_ci` NOT NULL,
	`number` INT UNSIGNED NOT NULL,
	`complement` VARCHAR(255) CHARACTER SET `utf8mb4` COLLATE `utf8mb4_general_ci`,
	`reference` VARCHAR(255) CHARACTER SET `utf8mb4` COLLATE `utf8mb4_general_ci`,
	`district` VARCHAR(255) CHARACTER SET `utf8mb4` COLLATE `utf8mb4_general_ci` NOT NULL,
	`city` VARCHAR(255) CHARACTER SET `utf8mb4` COLLATE `utf8mb4_general_ci` NOT NULL,
	`state` ENUM(
		'AC',
		'AL',
		'AP',
		'AM',
		'BA',
		'CE',
		'ES',
		'GO',
		'MA',
		'MT',
		'MS',
		'MG',
		'PA',
		'PB',
		'PR',
		'PE',
		'PI',
		'RJ',
		'RN',
		'RS',
		'RO',
		'RR',
		'SC',
		'SP',
		'SE',
		'TO',
		'DF'
	) CHARACTER SET `utf8mb4` COLLATE `utf8mb4_general_ci` NOT NULL,
	`created_at` DATETIME NOT NULL,
	`updated_at` DATETIME NOT NULL,
	`deleted_at` DATETIME,
	PRIMARY KEY (`id`)
);

-- LINKS THE PERSONS TO THE ADDRESSES
ALTER TABLE `person`
ADD CONSTRAINT `FK_PERSON_ADDRESS`
FOREIGN KEY (`address_id`)
REFERENCES `address`(`id`);