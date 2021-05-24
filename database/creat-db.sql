DROP DATABASE IF EXISTS `click_collect`;

CREATE DATABASE `click_collect` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

USE `click_collect`;

CREATE TABLE `Client` (
  `client_id` BIGINT AUTO_INCREMENT PRIMARY KEY,
  `nom` VARCHAR(42) NOT NULL,
  `prénom` VARCHAR(42) NOT NULL,
  `civilité` VARCHAR(42) NOT NULL,
  `age` INT NOT NULL,
  `email` VARCHAR(42) UNIQUE NOT NULL,
  `telephone` VARCHAR(42) UNIQUE NOT NULL,
  `mot_de_passe` VARCHAR(255),
  `address` VARCHAR(255),
  `postal_code` INT NOT NULL,
  `ville` VARCHAR(42) NOT NULL,
  `est_professionnel` BOOLEAN DEFAULT false,
  `created_at` TIMESTAMP DEFAULT NOW(),
  `updated_at` TIMESTAMP DEFAULT NOW()
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE `Prestation` (
  `prestation_id` BIGINT AUTO_INCREMENT PRIMARY KEY,
  `nombre_collect` INT NOT NULL,
  `address_collect` VARCHAR(255),
  `nombre_livraison` INT NOT NULL,
  `address_livraison` VARCHAR(255),
  `created_at` TIMESTAMP DEFAULT NOW(),
  `updated_at` TIMESTAMP DEFAULT NOW()
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE `commander` (
  `client_id` BIGINT NOT NULL REFERENCES `Client`(`client_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  `prestation_id` BIGINT NOT NULL REFERENCES `Prestation`(`prestation_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  `created_at` TIMESTAMP DEFAULT NOW(),
  `updated_at` TIMESTAMP DEFAULT NOW(),
  PRIMARY KEY (`client_id`, `prestation_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;


CREATE TABLE `Livreur` (
  `livreur_id` BIGINT AUTO_INCREMENT PRIMARY KEY,
  `nom` VARCHAR(42) NOT NULL,
  `prénom` VARCHAR(42) NOT NULL,
  `telephone` VARCHAR(42) UNIQUE NOT NULL,
  `created_at` TIMESTAMP DEFAULT NOW(),
  `updated_at` TIMESTAMP DEFAULT NOW()
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE `Consulter` (
  `livreur_id` BIGINT NOT NULL REFERENCES `Livreur`(`livreur_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  `prestation_id` BIGINT NOT NULL REFERENCES `Prestation`(`prestation_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  `created_at` TIMESTAMP DEFAULT NOW(),
  `updated_at` TIMESTAMP DEFAULT NOW(),
  PRIMARY KEY (`livreur_id`, `prestation_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE `Abonnement` (
  `abonnement_id` BIGINT AUTO_INCREMENT PRIMARY KEY,
  `est_mensuel` BOOLEAN DEFAULT false,
  `client_id` BIGINT NOT NULL REFERENCES `Client`(`client_id`) ON DELETE CASCADE ON UPDATE CASCADE,

  `created_at` TIMESTAMP DEFAULT NOW(),
  `updated_at` TIMESTAMP DEFAULT NOW()
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE `Paiement` (
  `paiement_id` BIGINT AUTO_INCREMENT PRIMARY KEY,
  `prestation_id` BIGINT NOT NULL REFERENCES `Prestation`(`prestation_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  `client_id` BIGINT NOT NULL REFERENCES `Client`(`client_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  `abonnement_id` BIGINT NOT NULL REFERENCES `Abonnement`(`abonnement_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  `created_at` TIMESTAMP DEFAULT NOW(),
  `updated_at` TIMESTAMP DEFAULT NOW()
) ENGINE = InnoDB DEFAULT CHARSET = utf8;








INSERT INTO Client(
    prénom,
    nom,
    age,
    email,
    telephone,
    PASSWORD,
    address,
    postal_code,
    ville,
    est_professionnel
  )
VALUES (
    'John',
    'Doe',
    45,
    'johndoe@test.com',
    '07 11 11 33 22',
    '$2y$14$fKBLLkng0oSLiQqzhvFEH.DQ0MONyb2Dv2kg.s7uT0j.8mVA2VML6',
    '3 rue du test',
    '12345',
    'testville',
    TRUE
  );