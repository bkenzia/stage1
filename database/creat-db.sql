DROP DATABASE IF EXISTS `click_collect`;

CREATE DATABASE `click_collect` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

USE `click_collect`;

CREATE TABLE `Client` (
  `client_id` BIGINT AUTO_INCREMENT PRIMARY KEY,
  `nom` VARCHAR(42) NOT NULL,
  `prénom` VARCHAR(42) NOT NULL,
  `civilité` VARCHAR(42) ,
  `age` VARCHAR(42) NOT NULL,
  `email` VARCHAR(42) UNIQUE NOT NULL,
  `telephone` VARCHAR(42)  NOT NULL,
  `mot_de_passe` VARCHAR(255),
  `address` VARCHAR(255),
  `postal_code` INT NOT NULL,
  `ville` VARCHAR(42) NOT NULL,
  `est_professionnel` BOOLEAN DEFAULT false,
  `est_admin` BOOLEAN DEFAULT false,
  `est_livreur` BOOLEAN DEFAULT false,
  `est_cgv` BOOLEAN DEFAULT false,

  `created_at` TIMESTAMP DEFAULT NOW(),
  `updated_at` TIMESTAMP DEFAULT NOW()
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE `Prestation` (
  `prestation_id` BIGINT AUTO_INCREMENT PRIMARY KEY,
  `nombre_collect` INT,
  `address_collect` VARCHAR(255),
  -- `nombre_livraison` INT NOT NULL,
  `address_livraison` VARCHAR(255),
  `justificatif_url` TEXT,
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
  `client_id` BIGINT NOT NULL REFERENCES `Client`(`client_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  `planning` TEXT,
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
  `prix` INT NOT NULL,
  `client_id` BIGINT NOT NULL REFERENCES `Client`(`client_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  `created_at` TIMESTAMP DEFAULT NOW(),
  `updated_at` TIMESTAMP DEFAULT NOW()
) ENGINE = InnoDB DEFAULT CHARSET = utf8;





CREATE TABLE `Paiement` (
  `paiement_id` BIGINT AUTO_INCREMENT PRIMARY KEY,
  `carte-nom` VARCHAR(42) NOT NULL,
  `carte-prénom` VARCHAR(42) NOT NULL,
  `dat-expiration` VARCHAR(255) NOT NULL,
  `crypto` VARCHAR(3) NOT NULL,
  `prestation_id` BIGINT NOT NULL REFERENCES `Prestation`(`prestation_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  `abonnement_id` BIGINT NOT NULL REFERENCES `Abonnement`(`abonnement_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  `created_at` TIMESTAMP DEFAULT NOW(),
  `updated_at` TIMESTAMP DEFAULT NOW()
) ENGINE = InnoDB DEFAULT CHARSET = utf8;


CREATE TABLE `Effectuer` (
  `paiement_id` BIGINT NOT NULL REFERENCES `Paiement`(`paiement_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  `client_id` BIGINT NOT NULL REFERENCES `Client`(`client_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  `created_at` TIMESTAMP DEFAULT NOW(),
  `updated_at` TIMESTAMP DEFAULT NOW(),
  PRIMARY KEY (`paiement_id`, `client_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE `Article` (
  `article_id` BIGINT AUTO_INCREMENT PRIMARY KEY,

  `nom` VARCHAR(42),
  `description` TEXT,
  `est_fragile` BOOLEAN DEFAULT false,
  `est_temperatures` BOOLEAN DEFAULT false,
  `volum` INT NOT NULL,
  `prestation_id` BIGINT NOT NULL REFERENCES `Prestation`(`prestation_id`) ON DELETE CASCADE ON UPDATE CASCADE,

  
  `created_at` TIMESTAMP DEFAULT NOW(),
  `updated_at` TIMESTAMP DEFAULT NOW()
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

-- CREATE TABLE `contenir` (
--   `article_id` BIGINT NOT NULL REFERENCES `Article`(`article_id`) ON DELETE CASCADE ON UPDATE CASCADE,
--   `prestation_id` BIGINT NOT NULL REFERENCES `Prestation`(`prestation_id`) ON DELETE CASCADE ON UPDATE CASCADE,
--   `created_at` TIMESTAMP DEFAULT NOW(),
--   `updated_at` TIMESTAMP DEFAULT NOW(),
--   PRIMARY KEY (`article_id`, `prestation_id`)
-- ) ENGINE = InnoDB DEFAULT CHARSET = utf8;

-- INSERT INTO Client(
--     nom,
--     prénom,
--     civilité,
--     age,
--     email,
--     telephone,
--     mot_de_passe,
--     address,
--     postal_code,
--     ville,
--     est_professionnel
    
--   )
-- VALUES (
--     'John',
--     'Doe',
--     'Homme',
--     '45',
--     'johndoe@test.com',
--     '07 11 11 33 22',
--     '1234LILI',
--     '3 rue du test',
--     '12345',
--     'testville',
--     TRUE
    
--   );