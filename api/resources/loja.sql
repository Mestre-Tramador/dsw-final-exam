-- CREATE THE DATABASE
CREATE DATABASE `loja` CHARACTER SET `utf8mb4` COLLATE `utf8mb4_general_ci`;

-- USE THE DATABASE
USE `loja`;

-- CREATE THE TABLE FOR PERSONS
CREATE TABLE `pessoa` (
	`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
	`tipoPessoa` VARCHAR(255) CHARACTER SET `utf8mb4` COLLATE `utf8mb4_general_ci` NOT NULL,
	`nome` VARCHAR(255) CHARACTER SET `utf8mb4` COLLATE `utf8mb4_general_ci` NOT NULL,
	`sobrenome` VARCHAR(255) CHARACTER SET `utf8mb4` COLLATE `utf8mb4_general_ci` NOT NULL,
	`sexo` VARCHAR(255) CHARACTER SET `utf8mb4` COLLATE `utf8mb4_general_ci` NOT NULL,
	`documento` VARCHAR(14) CHARACTER SET `utf8mb4` COLLATE `utf8mb4_general_ci` NOT NULL,
	`telefone` VARCHAR(10) CHARACTER SET `utf8mb4` COLLATE `utf8mb4_general_ci`,
	`celuar` VARCHAR(11) CHARACTER SET `utf8mb4` COLLATE `utf8mb4_general_ci`,
	`nascimento` DATE NOT NULL,
	`cep` VARCHAR(8) CHARACTER SET `utf8mb4` COLLATE `utf8mb4_general_ci`,
	`rua` VARCHAR(255) CHARACTER SET `utf8mb4` COLLATE `utf8mb4_general_ci`,
	`numero` INT UNSIGNED,
	`complemento` VARCHAR(255) CHARACTER SET `utf8mb4` COLLATE `utf8mb4_general_ci`,
	`referencia` VARCHAR(255) CHARACTER SET `utf8mb4` COLLATE `utf8mb4_general_ci`,
	`bairro` VARCHAR(255) CHARACTER SET `utf8mb4` COLLATE `utf8mb4_general_ci`,
	`cidade` VARCHAR(255) CHARACTER SET `utf8mb4` COLLATE `utf8mb4_general_ci`,
	`estado` VARCHAR(2) CHARACTER SET `utf8mb4` COLLATE `utf8mb4_general_ci`,
	PRIMARY KEY (`id`)
);