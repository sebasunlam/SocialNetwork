-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema SocialNetwork
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `SocialNetwork` ;

-- -----------------------------------------------------
-- Schema SocialNetwork
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `SocialNetwork` DEFAULT CHARACTER SET utf8 ;
USE `SocialNetwork` ;

-- -----------------------------------------------------
-- Table `SocialNetwork`.`user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SocialNetwork`.`user` ;

CREATE TABLE IF NOT EXISTS `SocialNetwork`.`user` (
  `id` BIGINT NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(32) NOT NULL,
  `fechaCreacion` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `facebookId` VARCHAR(255) NULL,
  `facebookToken` VARCHAR(255) NULL,
  `facebookRefreshToken` VARCHAR(255) NULL,
  `googleId` VARCHAR(255) NULL,
  `googleToken` VARCHAR(255) NULL,
  `googleRefreshToken` VARCHAR(255) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC),
  UNIQUE INDEX `facebookId_UNIQUE` (`facebookId` ASC),
  UNIQUE INDEX `googleId_UNIQUE` (`googleId` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `SocialNetwork`.`sexo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SocialNetwork`.`sexo` ;

CREATE TABLE IF NOT EXISTS `SocialNetwork`.`sexo` (
  `id` BIGINT NOT NULL,
  `descripcion` VARCHAR(50) NOT NULL,
  `enum` INT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `SocialNetwork`.`perfil`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SocialNetwork`.`perfil` ;

CREATE TABLE IF NOT EXISTS `SocialNetwork`.`perfil` (
  `id` BIGINT NOT NULL,
  `apellido` VARCHAR(200) NOT NULL,
  `nombre` VARCHAR(200) NOT NULL,
  `fechanacimiento` DATE NOT NULL,
  `telefono` VARCHAR(45) NOT NULL,
  `user_id` BIGINT NOT NULL,
  `sexo_id` BIGINT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_perfil_user_idx` (`user_id` ASC),
  UNIQUE INDEX `user_id_UNIQUE` (`user_id` ASC),
  INDEX `fk_perfil_sexo1_idx` (`sexo_id` ASC),
  CONSTRAINT `fk_perfil_user`
    FOREIGN KEY (`user_id`)
    REFERENCES `SocialNetwork`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_perfil_sexo1`
    FOREIGN KEY (`sexo_id`)
    REFERENCES `SocialNetwork`.`sexo` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `SocialNetwork`.`imagen`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SocialNetwork`.`imagen` ;

CREATE TABLE IF NOT EXISTS `SocialNetwork`.`imagen` (
  `id` BIGINT NOT NULL,
  `url` VARCHAR(1000) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `SocialNetwork`.`perfil_imagen`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SocialNetwork`.`perfil_imagen` ;

CREATE TABLE IF NOT EXISTS `SocialNetwork`.`perfil_imagen` (
  `id` BIGINT NOT NULL,
  `perfil_id` BIGINT NOT NULL,
  `imagen_id` BIGINT NOT NULL,
  `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX `fk_perfil_has_imagen_imagen1_idx` (`imagen_id` ASC),
  INDEX `fk_perfil_has_imagen_perfil1_idx` (`perfil_id` ASC),
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_perfil_has_imagen_perfil1`
    FOREIGN KEY (`perfil_id`)
    REFERENCES `SocialNetwork`.`perfil` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_perfil_has_imagen_imagen1`
    FOREIGN KEY (`imagen_id`)
    REFERENCES `SocialNetwork`.`imagen` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `SocialNetwork`.`tipo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SocialNetwork`.`tipo` ;

CREATE TABLE IF NOT EXISTS `SocialNetwork`.`tipo` (
  `id` BIGINT NOT NULL,
  `descripcion` VARCHAR(250) NOT NULL,
  `like_text` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `SocialNetwork`.`raza`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SocialNetwork`.`raza` ;

CREATE TABLE IF NOT EXISTS `SocialNetwork`.`raza` (
  `id` BIGINT NOT NULL,
  `descripcion` VARCHAR(250) NOT NULL,
  `tipo_id` BIGINT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_raza_tipo1_idx` (`tipo_id` ASC),
  CONSTRAINT `fk_raza_tipo1`
    FOREIGN KEY (`tipo_id`)
    REFERENCES `SocialNetwork`.`tipo` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `SocialNetwork`.`tamanio`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SocialNetwork`.`tamanio` ;

CREATE TABLE IF NOT EXISTS `SocialNetwork`.`tamanio` (
  `id` BIGINT NOT NULL,
  `descripcion` VARCHAR(200) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `SocialNetwork`.`mascota`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SocialNetwork`.`mascota` ;

CREATE TABLE IF NOT EXISTS `SocialNetwork`.`mascota` (
  `id` BIGINT NOT NULL,
  `nombre` VARCHAR(250) NOT NULL,
  `dia_nacimiento` TINYINT NULL,
  `mes_nacimiento` TINYINT NULL,
  `anio_nacimiento` INT NOT NULL,
  `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `adopcion` BIT NOT NULL,
  `pareja` BIT NOT NULL,
  `raza_id` BIGINT NOT NULL,
  `tamanio_id` BIGINT NOT NULL,
  `sexo_id` BIGINT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_mascota_raza1_idx` (`raza_id` ASC),
  INDEX `fk_mascota_tamanio1_idx` (`tamanio_id` ASC),
  INDEX `fk_mascota_sexo1_idx` (`sexo_id` ASC),
  CONSTRAINT `fk_mascota_raza1`
    FOREIGN KEY (`raza_id`)
    REFERENCES `SocialNetwork`.`raza` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_mascota_tamanio1`
    FOREIGN KEY (`tamanio_id`)
    REFERENCES `SocialNetwork`.`tamanio` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_mascota_sexo1`
    FOREIGN KEY (`sexo_id`)
    REFERENCES `SocialNetwork`.`sexo` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `SocialNetwork`.`perfil_has_mascota`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SocialNetwork`.`perfil_has_mascota` ;

CREATE TABLE IF NOT EXISTS `SocialNetwork`.`perfil_has_mascota` (
  `perfil_id` BIGINT NOT NULL,
  `mascota_id` BIGINT NOT NULL,
  PRIMARY KEY (`perfil_id`, `mascota_id`),
  INDEX `fk_perfil_has_mascota_mascota1_idx` (`mascota_id` ASC),
  INDEX `fk_perfil_has_mascota_perfil1_idx` (`perfil_id` ASC),
  CONSTRAINT `fk_perfil_has_mascota_perfil1`
    FOREIGN KEY (`perfil_id`)
    REFERENCES `SocialNetwork`.`perfil` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_perfil_has_mascota_mascota1`
    FOREIGN KEY (`mascota_id`)
    REFERENCES `SocialNetwork`.`mascota` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `SocialNetwork`.`mascota_imagen`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SocialNetwork`.`mascota_imagen` ;

CREATE TABLE IF NOT EXISTS `SocialNetwork`.`mascota_imagen` (
  `id` BIGINT NOT NULL,
  `mascota_id` BIGINT NOT NULL,
  `imagen_id` BIGINT NOT NULL,
  `timestamp` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX `fk_mascota_has_imagen_imagen1_idx` (`imagen_id` ASC),
  INDEX `fk_mascota_has_imagen_mascota1_idx` (`mascota_id` ASC),
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_mascota_has_imagen_mascota1`
    FOREIGN KEY (`mascota_id`)
    REFERENCES `SocialNetwork`.`mascota` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_mascota_has_imagen_imagen1`
    FOREIGN KEY (`imagen_id`)
    REFERENCES `SocialNetwork`.`imagen` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `SocialNetwork`.`provincia`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SocialNetwork`.`provincia` ;

CREATE TABLE IF NOT EXISTS `SocialNetwork`.`provincia` (
  `id` BIGINT NOT NULL,
  `descripcion` VARCHAR(250) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `SocialNetwork`.`departamento`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SocialNetwork`.`departamento` ;

CREATE TABLE IF NOT EXISTS `SocialNetwork`.`departamento` (
  `id` BIGINT NOT NULL,
  `descripcion` VARCHAR(250) NOT NULL,
  `provincia_id` BIGINT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_departamento_provincia1_idx` (`provincia_id` ASC),
  CONSTRAINT `fk_departamento_provincia1`
    FOREIGN KEY (`provincia_id`)
    REFERENCES `SocialNetwork`.`provincia` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `SocialNetwork`.`localidad`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SocialNetwork`.`localidad` ;

CREATE TABLE IF NOT EXISTS `SocialNetwork`.`localidad` (
  `id` BIGINT NOT NULL,
  `descripcion` VARCHAR(250) NOT NULL,
  `departamento_id` BIGINT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_localidad_departamento1_idx` (`departamento_id` ASC),
  CONSTRAINT `fk_localidad_departamento1`
    FOREIGN KEY (`departamento_id`)
    REFERENCES `SocialNetwork`.`departamento` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `SocialNetwork`.`domicilio`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SocialNetwork`.`domicilio` ;

CREATE TABLE IF NOT EXISTS `SocialNetwork`.`domicilio` (
  `id` BIGINT NOT NULL,
  `calle` VARCHAR(500) NOT NULL,
  `nro` INT NULL,
  `lat` DOUBLE NOT NULL,
  `long` DOUBLE NOT NULL,
  `localidad_id` BIGINT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_domicilio_localidad1_idx` (`localidad_id` ASC),
  CONSTRAINT `fk_domicilio_localidad1`
    FOREIGN KEY (`localidad_id`)
    REFERENCES `SocialNetwork`.`localidad` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `SocialNetwork`.`perfil_domicilio`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SocialNetwork`.`perfil_domicilio` ;

CREATE TABLE IF NOT EXISTS `SocialNetwork`.`perfil_domicilio` (
  `id` BIGINT NOT NULL,
  `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `perfil_id` BIGINT NOT NULL,
  `domicilio_id` BIGINT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_perfil_domicilio_perfil1_idx` (`perfil_id` ASC),
  INDEX `fk_perfil_domicilio_domicilio1_idx` (`domicilio_id` ASC),
  CONSTRAINT `fk_perfil_domicilio_perfil1`
    FOREIGN KEY (`perfil_id`)
    REFERENCES `SocialNetwork`.`perfil` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_perfil_domicilio_domicilio1`
    FOREIGN KEY (`domicilio_id`)
    REFERENCES `SocialNetwork`.`domicilio` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `SocialNetwork`.`media_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SocialNetwork`.`media_type` ;

CREATE TABLE IF NOT EXISTS `SocialNetwork`.`media_type` (
  `id` BIGINT NOT NULL,
  `descripcion` VARCHAR(250) NOT NULL,
  `enum` INT NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `SocialNetwork`.`media`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SocialNetwork`.`media` ;

CREATE TABLE IF NOT EXISTS `SocialNetwork`.`media` (
  `id` BIGINT NOT NULL,
  `url` VARCHAR(45) NOT NULL,
  `media_type_id` BIGINT NOT NULL,
  `local` BIT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_media_media_type1_idx` (`media_type_id` ASC),
  CONSTRAINT `fk_media_media_type1`
    FOREIGN KEY (`media_type_id`)
    REFERENCES `SocialNetwork`.`media_type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `SocialNetwork`.`post`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SocialNetwork`.`post` ;

CREATE TABLE IF NOT EXISTS `SocialNetwork`.`post` (
  `id` BIGINT NOT NULL,
  `content` TEXT NULL,
  `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `media_id` BIGINT NULL,
  `shared_post_id` BIGINT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_post_media1_idx` (`media_id` ASC),
  INDEX `fk_post_post1_idx` (`shared_post_id` ASC),
  CONSTRAINT `fk_post_media1`
    FOREIGN KEY (`media_id`)
    REFERENCES `SocialNetwork`.`media` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_post_post1`
    FOREIGN KEY (`shared_post_id`)
    REFERENCES `SocialNetwork`.`post` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `SocialNetwork`.`perfil_like_post`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SocialNetwork`.`perfil_like_post` ;

CREATE TABLE IF NOT EXISTS `SocialNetwork`.`perfil_like_post` (
  `perfil_id` BIGINT NOT NULL,
  `post_id` BIGINT NOT NULL,
  `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `coment` TEXT NULL,
  `like` BIT NOT NULL,
  PRIMARY KEY (`perfil_id`, `post_id`),
  INDEX `fk_perfil_has_post_post1_idx` (`post_id` ASC),
  INDEX `fk_perfil_has_post_perfil1_idx` (`perfil_id` ASC),
  CONSTRAINT `fk_perfil_has_post_perfil1`
    FOREIGN KEY (`perfil_id`)
    REFERENCES `SocialNetwork`.`perfil` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_perfil_has_post_post1`
    FOREIGN KEY (`post_id`)
    REFERENCES `SocialNetwork`.`post` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `SocialNetwork`.`perfil_follows_mascota`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SocialNetwork`.`perfil_follows_mascota` ;

CREATE TABLE IF NOT EXISTS `SocialNetwork`.`perfil_follows_mascota` (
  `perfil_id` BIGINT NOT NULL,
  `mascota_id` BIGINT NOT NULL,
  `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`perfil_id`, `mascota_id`),
  INDEX `fk_perfil_has_mascota1_mascota1_idx` (`mascota_id` ASC),
  INDEX `fk_perfil_has_mascota1_perfil1_idx` (`perfil_id` ASC),
  CONSTRAINT `fk_perfil_has_mascota1_perfil1`
    FOREIGN KEY (`perfil_id`)
    REFERENCES `SocialNetwork`.`perfil` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_perfil_has_mascota1_mascota1`
    FOREIGN KEY (`mascota_id`)
    REFERENCES `SocialNetwork`.`mascota` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `SocialNetwork`.`transferencia`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SocialNetwork`.`transferencia` ;

CREATE TABLE IF NOT EXISTS `SocialNetwork`.`transferencia` (
  `id` BIGINT NOT NULL,
  `aceptada` BIT NULL,
  `fecha_solicitud` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_aceptacion` TIMESTAMP NULL,
  `fecha_entrega` TIMESTAMP NULL,
  `perfil_id` BIGINT NOT NULL,
  `mascota_id` BIGINT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_transferencia_perfil1_idx` (`perfil_id` ASC),
  INDEX `fk_transferencia_mascota1_idx` (`mascota_id` ASC),
  CONSTRAINT `fk_transferencia_perfil1`
    FOREIGN KEY (`perfil_id`)
    REFERENCES `SocialNetwork`.`perfil` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_transferencia_mascota1`
    FOREIGN KEY (`mascota_id`)
    REFERENCES `SocialNetwork`.`mascota` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `SocialNetwork`.`citas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SocialNetwork`.`citas` ;

CREATE TABLE IF NOT EXISTS `SocialNetwork`.`citas` (
  `id` BIGINT NOT NULL,
  `fecha_solicitud` TIMESTAMP NOT NULL,
  `acepta` BIT NULL,
  `fecha_acepta` TIMESTAMP NULL,
  `mascota_buscando` BIGINT NOT NULL,
  `mascota_ofrecida` BIGINT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_citas_mascota1_idx` (`mascota_buscando` ASC),
  INDEX `fk_citas_mascota2_idx` (`mascota_ofrecida` ASC),
  CONSTRAINT `fk_citas_mascota1`
    FOREIGN KEY (`mascota_buscando`)
    REFERENCES `SocialNetwork`.`mascota` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_citas_mascota2`
    FOREIGN KEY (`mascota_ofrecida`)
    REFERENCES `SocialNetwork`.`mascota` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `SocialNetwork`.`visitas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SocialNetwork`.`visitas` ;

CREATE TABLE IF NOT EXISTS `SocialNetwork`.`visitas` (
  `id` BIGINT NOT NULL,
  `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `mascota_id` BIGINT NOT NULL,
  `perfil_id` BIGINT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_visitas_mascota1_idx` (`mascota_id` ASC),
  INDEX `fk_visitas_perfil1_idx` (`perfil_id` ASC),
  CONSTRAINT `fk_visitas_mascota1`
    FOREIGN KEY (`mascota_id`)
    REFERENCES `SocialNetwork`.`mascota` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_visitas_perfil1`
    FOREIGN KEY (`perfil_id`)
    REFERENCES `SocialNetwork`.`perfil` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `SocialNetwork`.`perdido`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SocialNetwork`.`perdido` ;

CREATE TABLE IF NOT EXISTS `SocialNetwork`.`perdido` (
  `id` BIGINT NOT NULL,
  `desde` TIMESTAMP NOT NULL,
  `hasta` TIMESTAMP NULL,
  `lat` DOUBLE NOT NULL,
  `long` DOUBLE NOT NULL,
  `mascota_id` BIGINT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_perdido_mascota1_idx` (`mascota_id` ASC),
  CONSTRAINT `fk_perdido_mascota1`
    FOREIGN KEY (`mascota_id`)
    REFERENCES `SocialNetwork`.`mascota` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `SocialNetwork`.`encontrado`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SocialNetwork`.`encontrado` ;

CREATE TABLE IF NOT EXISTS `SocialNetwork`.`encontrado` (
  `id` BIGINT NOT NULL,
  `contacto` VARCHAR(200) NOT NULL,
  `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `perdido_id` BIGINT NOT NULL,
  `perfil_id` BIGINT NULL,
  `imagen_id` BIGINT NULL,
  `aceptada` BIT NULL,
  `fecha_aceptacion` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_encontrado_perdido1_idx` (`perdido_id` ASC),
  INDEX `fk_encontrado_perfil1_idx` (`perfil_id` ASC),
  INDEX `fk_encontrado_imagen1_idx` (`imagen_id` ASC),
  CONSTRAINT `fk_encontrado_perdido1`
    FOREIGN KEY (`perdido_id`)
    REFERENCES `SocialNetwork`.`perdido` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_encontrado_perfil1`
    FOREIGN KEY (`perfil_id`)
    REFERENCES `SocialNetwork`.`perfil` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_encontrado_imagen1`
    FOREIGN KEY (`imagen_id`)
    REFERENCES `SocialNetwork`.`imagen` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
