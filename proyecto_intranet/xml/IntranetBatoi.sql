SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `IntranetBatoi3` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `IntranetBatoi3` ;

-- -----------------------------------------------------
-- Table `IntranetBatoi3`.`alumnos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `IntranetBatoi3`.`alumnos` (
  `id` INT(6) NOT NULL AUTO_INCREMENT,
  `dni` VARCHAR(10) NOT NULL,
  `nombre` VARCHAR(25) NOT NULL,
  `apellido1` VARCHAR(25) NOT NULL,
  `apellido2` VARCHAR(25) NOT NULL,
  `password` VARCHAR(60) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `fecha_nac` DATE NOT NULL,
  `foto` VARCHAR(125) NULL,
  `nia` VARCHAR(8) NOT NULL,
  `sexo` CHAR(1) NOT NULL,
  `expediente` VARCHAR(5) NULL,
  `cod_postal` VARCHAR(5) NULL,
  `domicilio` VARCHAR(45) NULL,
  `provincia` VARCHAR(100) NOT NULL,
  `municipio` VARCHAR(100) NOT NULL,
  `telefono1` VARCHAR(9) NOT NULL,
  `telefono2` VARCHAR(9) NULL,
  `observaciones` VARCHAR(45) NULL,
  `fecha_matricula` DATE NOT NULL,
  `fecha_ingreso_centro` DATE NOT NULL,
  `estado_matricula` CHAR(1) NOT NULL,
  `repite` TINYINT(1) NOT NULL DEFAULT 0,
  `turno` CHAR(1) NOT NULL,
  `trabaja` CHAR(1) NOT NULL,
  PRIMARY KEY (`id`, `dni`, `nia`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `IntranetBatoi3`.`departamentos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `IntranetBatoi3`.`departamentos` (
  `departa` INT(2) NOT NULL AUTO_INCREMENT,
  `CLITERAL` VARCHAR(30) NOT NULL,
  `VLITERAL` VARCHAR(30) NOT NULL,
  `DepCurt` VARCHAR(3) NOT NULL,
  PRIMARY KEY (`departa`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `IntranetBatoi3`.`profesores`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `IntranetBatoi3`.`profesores` (
  `codigo` INT(4) NOT NULL AUTO_INCREMENT,
  `cod_horario` INT(3) NOT NULL,
  `dni` VARCHAR(10) NOT NULL,
  `nombre` VARCHAR(25) NOT NULL,
  `apellido1` VARCHAR(25) NOT NULL,
  `apellido2` VARCHAR(25) NOT NULL,
  `password` VARCHAR(60) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `email_alumnos` VARCHAR(45) NOT NULL,
  `fecha_baja` DATE NULL,
  `foto` VARCHAR(125) NULL,
  `domicilio_particular` VARCHAR(40) NOT NULL,
  `domicilio` VARCHAR(40) NOT NULL,
  `movil1` VARCHAR(9) NOT NULL,
  `movil2` VARCHAR(9) NULL,
  `perfil_acceso` VARCHAR(9) NOT NULL,
  `departamentos_DEPARTA` INT(2) NOT NULL,
  `sexo` CHAR(1) NOT NULL,
  `fecha_ingreso` DATE NOT NULL,
  `provincia` VARCHAR(100) NULL,
  `municipio` VARCHAR(100) NULL,
  `cod_postal` VARCHAR(5) NULL,
  `fecha_nac` DATE NOT NULL,
  `fecha_antiguedad` DATE NULL,
  `sustituye_a` INT(4) NULL,
  PRIMARY KEY (`codigo`, `departamentos_DEPARTA`),
  INDEX `fk_profesores_departamentos1_idx` (`departamentos_DEPARTA` ASC),
  CONSTRAINT `fk_profesores_departamentos1`
    FOREIGN KEY (`departamentos_DEPARTA`)
    REFERENCES `IntranetBatoi3`.`departamentos` (`departa`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `IntranetBatoi3`.`grupos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `IntranetBatoi3`.`grupos` (
  `codigo` CHAR(5) NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  `turno` CHAR(1) NOT NULL,
  `tutor` INT(4) NOT NULL,
  `familia` INT(2) NOT NULL,
  PRIMARY KEY (`codigo`),
  INDEX `fk_grupos_profesores1_idx` (`tutor` ASC),
  INDEX `fk_grupos_departamentos1_idx` (`familia` ASC),
  CONSTRAINT `fk_grupos_profesores1`
    FOREIGN KEY (`tutor`)
    REFERENCES `IntranetBatoi3`.`profesores` (`codigo`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_grupos_departamentos1`
    FOREIGN KEY (`familia`)
    REFERENCES `IntranetBatoi3`.`departamentos` (`departa`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;



-- -----------------------------------------------------
-- Table `IntranetBatoi3`.`manipulador_alimentos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `IntranetBatoi3`.`manipulador_alimentos` (
  `codigo` VARCHAR(8) NOT NULL,
  `fecha_inicio` DATE NOT NULL,
  `fecha_fin` DATE NULL,
  `horas` INT(3) NOT NULL,
  `activo` CHAR(1) NULL,
  `horario` VARCHAR(6) NOT NULL,
  `profesorado` TEXT NULL,
  `comentarios` TEXT NULL,
  PRIMARY KEY (`codigo`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `IntranetBatoi3`.`actividades_extraescolares`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `IntranetBatoi3`.`actividades_extraescolares` (
  `codigo` INT(4) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(50) NOT NULL,
  `descripcion` TEXT NULL,
  `objetivos` TEXT NULL,
  `fecha_realizacion` DATE NULL,
  `hora_inicio` TIME NOT NULL,
  `hora_fin` TIME NULL,
  `fecha_alta` DATE NULL,
  `comentarios` TEXT NULL,
  PRIMARY KEY (`codigo`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `IntranetBatoi3`.`grupos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `IntranetBatoi3`.`grupos` (
  `codigo` CHAR(5) NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  `turno` CHAR(1) NOT NULL,
  `tutor` INT(4) NOT NULL,
  `familia` INT(2) NOT NULL,
  PRIMARY KEY (`codigo`),
  INDEX `fk_grupos_profesores1_idx` (`tutor` ASC),
  INDEX `fk_grupos_departamentos1_idx` (`familia` ASC),
  CONSTRAINT `fk_grupos_profesores1`
    FOREIGN KEY (`tutor`)
    REFERENCES `IntranetBatoi3`.`profesores` (`codigo`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_grupos_departamentos1`
    FOREIGN KEY (`familia`)
    REFERENCES `IntranetBatoi3`.`departamentos` (`departa`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `IntranetBatoi3`.`grupos_profesores`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `IntranetBatoi3`.`grupos_profesores` (
  `grupos_codigo` CHAR(5) NOT NULL,
  `profesores_codigo` INT(4) NOT NULL,
  PRIMARY KEY (`grupos_codigo`, `profesores_codigo`),
  INDEX `fk_grupos_has_profesores_profesores1_idx` (`profesores_codigo` ASC),
  INDEX `fk_grupos_has_profesores_grupos1_idx` (`grupos_codigo` ASC),
  CONSTRAINT `fk_grupos_has_profesores_grupos1`
    FOREIGN KEY (`grupos_codigo`)
    REFERENCES `IntranetBatoi3`.`grupos` (`codigo`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_grupos_has_profesores_profesores1`
    FOREIGN KEY (`profesores_codigo`)
    REFERENCES `IntranetBatoi3`.`profesores` (`codigo`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `IntranetBatoi3`.`alumnos_has_manipulador_alimentos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `IntranetBatoi3`.`alumnos_has_manipulador_alimentos` (
  `alumnos_id` INT(6) NOT NULL,
  `manipulador_alimentos_codigo` VARCHAR(8) NOT NULL,
  `finalizado` TINYINT(1) NOT NULL,
  `registrado` CHAR(1) NULL,
  PRIMARY KEY (`alumnos_id`, `manipulador_alimentos_codigo`),
  INDEX `fk_alumnos_has_manipulador_alimentos_manipulador_alimentos1_idx` (`manipulador_alimentos_codigo` ASC),
  INDEX `fk_alumnos_has_manipulador_alimentos_alumnos1_idx` (`alumnos_id` ASC),
  CONSTRAINT `fk_alumnos_has_manipulador_alimentos_alumnos1`
    FOREIGN KEY (`alumnos_id`)
    REFERENCES `IntranetBatoi3`.`alumnos` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_alumnos_has_manipulador_alimentos_manipulador_alimentos1`
    FOREIGN KEY (`manipulador_alimentos_codigo`)
    REFERENCES `IntranetBatoi3`.`manipulador_alimentos` (`codigo`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `IntranetBatoi3`.`actividades_extraescolares_has_profesores`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `IntranetBatoi3`.`actividades_extraescolares_has_profesores` (
  `actividades_extraescolares_codigo` INT(4) NOT NULL,
  `profesores_codigo` INT(4) NOT NULL,
  `coordinador` TINYINT(1) NULL,
  PRIMARY KEY (`actividades_extraescolares_codigo`, `profesores_codigo`),
  INDEX `fk_actividades_extraescolares_has_profesores_profesores1_idx` (`profesores_codigo` ASC),
  INDEX `fk_actividades_extraescolares_has_profesores_actividades_ex_idx` (`actividades_extraescolares_codigo` ASC),
  CONSTRAINT `fk_actividades_extraescolares_has_profesores_actividades_extr1`
    FOREIGN KEY (`actividades_extraescolares_codigo`)
    REFERENCES `IntranetBatoi3`.`actividades_extraescolares` (`codigo`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_actividades_extraescolares_has_profesores_profesores1`
    FOREIGN KEY (`profesores_codigo`)
    REFERENCES `IntranetBatoi3`.`profesores` (`codigo`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `IntranetBatoi3`.`grupos_has_actividades_extraescolares`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `IntranetBatoi3`.`grupos_has_actividades_extraescolares` (
  `grupos_codigo` CHAR(5) NOT NULL,
  `actividades_extraescolares_codigo` INT(4) NOT NULL,
  PRIMARY KEY (`grupos_codigo`, `actividades_extraescolares_codigo`),
  INDEX `fk_grupos_has_actividades_extraescolares_actividades_extrae_idx` (`actividades_extraescolares_codigo` ASC),
  INDEX `fk_grupos_has_actividades_extraescolares_grupos1_idx` (`grupos_codigo` ASC),
  CONSTRAINT `fk_grupos_has_actividades_extraescolares_grupos1`
    FOREIGN KEY (`grupos_codigo`)
    REFERENCES `IntranetBatoi3`.`grupos` (`codigo`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_grupos_has_actividades_extraescolares_actividades_extraesc1`
    FOREIGN KEY (`actividades_extraescolares_codigo`)
    REFERENCES `IntranetBatoi3`.`actividades_extraescolares` (`codigo`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `IntranetBatoi3`.`alumnos_has_grupos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `IntranetBatoi3`.`alumnos_has_grupos` (
  `alumnos_id` INT(6) NOT NULL,
  `alumnos_dni` VARCHAR(10) NOT NULL,
  `alumnos_nia` VARCHAR(45) NOT NULL,
  `grupos_codigo` CHAR(5) NOT NULL,
  PRIMARY KEY (`alumnos_id`, `alumnos_dni`, `alumnos_nia`, `grupos_codigo`),
  INDEX `fk_alumnos_has_grupos_grupos1_idx` (`grupos_codigo` ASC),
  INDEX `fk_alumnos_has_grupos_alumnos1_idx` (`alumnos_id` ASC, `alumnos_dni` ASC, `alumnos_nia` ASC),
  CONSTRAINT `fk_alumnos_has_grupos_alumnos1`
    FOREIGN KEY (`alumnos_id` , `alumnos_dni` , `alumnos_nia`)
    REFERENCES `IntranetBatoi3`.`alumnos` (`id` , `dni` , `nia`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_alumnos_has_grupos_grupos1`
    FOREIGN KEY (`grupos_codigo`)
    REFERENCES `IntranetBatoi3`.`grupos` (`codigo`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `IntranetBatoi3`.`provincias`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `IntranetBatoi3`.`provincias` (
  `id` VARCHAR(2) NOT NULL,
  `nombre` VARCHAR(60) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `IntranetBatoi3`.`municipios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `IntranetBatoi3`.`municipios` (
  `provincias_id` VARCHAR(2) NOT NULL,
  `cod_municipio` VARCHAR(4) NOT NULL,
  `municipio` VARCHAR(60) NOT NULL,
  INDEX `fk_municipios_provincias1_idx` (`provincias_id` ASC),
  PRIMARY KEY (`provincias_id`, `cod_municipio`),
  CONSTRAINT `fk_municipios_provincias1`
    FOREIGN KEY (`provincias_id`)
    REFERENCES `IntranetBatoi3`.`provincias` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
