SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `IntranetBatoi` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `IntranetBatoi` ;

-- -----------------------------------------------------
-- Table `IntranetBatoi`.`alumnos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `IntranetBatoi`.`alumnos` (
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
  `domicilio` TEXT NULL,
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
  PRIMARY KEY (`id`, `nia`, `dni`),
  UNIQUE INDEX `dni_UNIQUE` (`dni` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `IntranetBatoi`.`departamentos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `IntranetBatoi`.`departamentos` (
  `departa` INT(2) NOT NULL AUTO_INCREMENT,
  `CLITERAL` VARCHAR(30) NOT NULL,
  `VLITERAL` VARCHAR(30) NOT NULL,
  `DepCurt` VARCHAR(3) NOT NULL,
  PRIMARY KEY (`departa`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `IntranetBatoi`.`profesores`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `IntranetBatoi`.`profesores` (
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
  UNIQUE INDEX `dni_UNIQUE` (`dni` ASC),
  CONSTRAINT `fk_profesores_departamentos1`
    FOREIGN KEY (`departamentos_DEPARTA`)
    REFERENCES `IntranetBatoi`.`departamentos` (`departa`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `IntranetBatoi`.`grupos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `IntranetBatoi`.`grupos` (
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
    REFERENCES `IntranetBatoi`.`profesores` (`codigo`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_grupos_departamentos1`
    FOREIGN KEY (`familia`)
    REFERENCES `IntranetBatoi`.`departamentos` (`departa`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;



-- -----------------------------------------------------
-- Table `IntranetBatoi`.`manipulador_alimentos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `IntranetBatoi`.`manipulador_alimentos` (
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
-- Table `IntranetBatoi`.`actividades_extraescolares`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `IntranetBatoi`.`actividades_extraescolares` (
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
-- Table `IntranetBatoi`.`grupos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `IntranetBatoi`.`grupos` (
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
    REFERENCES `IntranetBatoi`.`profesores` (`codigo`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_grupos_departamentos1`
    FOREIGN KEY (`familia`)
    REFERENCES `IntranetBatoi`.`departamentos` (`departa`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;




-- -----------------------------------------------------
-- Table `IntranetBatoi`.`grupos_profesores`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `IntranetBatoi`.`grupos_profesores` (
  `grupos_codigo` CHAR(5) NOT NULL,
  `profesores_codigo` INT(4) NOT NULL,
  PRIMARY KEY (`grupos_codigo`, `profesores_codigo`),
  INDEX `fk_grupos_has_profesores_profesores1_idx` (`profesores_codigo` ASC),
  INDEX `fk_grupos_has_profesores_grupos1_idx` (`grupos_codigo` ASC),
  CONSTRAINT `fk_grupos_has_profesores_grupos1`
    FOREIGN KEY (`grupos_codigo`)
    REFERENCES `IntranetBatoi`.`grupos` (`codigo`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_grupos_has_profesores_profesores1`
    FOREIGN KEY (`profesores_codigo`)
    REFERENCES `IntranetBatoi`.`profesores` (`codigo`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `IntranetBatoi`.`alumnos_has_manipulador_alimentos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `IntranetBatoi`.`alumnos_has_manipulador_alimentos` (
  `alumnos_id` INT(6) NOT NULL,
  `manipulador_alimentos_codigo` VARCHAR(8) NOT NULL,
  `finalizado` TINYINT(1) NOT NULL,
  `registrado` CHAR(1) NULL,
  PRIMARY KEY (`alumnos_id`, `manipulador_alimentos_codigo`),
  INDEX `fk_alumnos_has_manipulador_alimentos_manipulador_alimentos1_idx` (`manipulador_alimentos_codigo` ASC),
  INDEX `fk_alumnos_has_manipulador_alimentos_alumnos1_idx` (`alumnos_id` ASC),
  CONSTRAINT `fk_alumnos_has_manipulador_alimentos_alumnos1`
    FOREIGN KEY (`alumnos_id`)
    REFERENCES `IntranetBatoi`.`alumnos` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_alumnos_has_manipulador_alimentos_manipulador_alimentos1`
    FOREIGN KEY (`manipulador_alimentos_codigo`)
    REFERENCES `IntranetBatoi`.`manipulador_alimentos` (`codigo`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `IntranetBatoi`.`actividades_extraescolares_has_profesores`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `IntranetBatoi`.`actividades_extraescolares_has_profesores` (
  `actividades_extraescolares_codigo` INT(4) NOT NULL,
  `profesores_codigo` INT(4) NOT NULL,
  `coordinador` TINYINT(1) NULL,
  PRIMARY KEY (`actividades_extraescolares_codigo`, `profesores_codigo`),
  INDEX `fk_actividades_extraescolares_has_profesores_profesores1_idx` (`profesores_codigo` ASC),
  INDEX `fk_actividades_extraescolares_has_profesores_actividades_ex_idx` (`actividades_extraescolares_codigo` ASC),
  CONSTRAINT `fk_actividades_extraescolares_has_profesores_actividades_extr1`
    FOREIGN KEY (`actividades_extraescolares_codigo`)
    REFERENCES `IntranetBatoi`.`actividades_extraescolares` (`codigo`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_actividades_extraescolares_has_profesores_profesores1`
    FOREIGN KEY (`profesores_codigo`)
    REFERENCES `IntranetBatoi`.`profesores` (`codigo`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `IntranetBatoi`.`grupos_has_actividades_extraescolares`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `IntranetBatoi`.`grupos_has_actividades_extraescolares` (
  `grupos_codigo` CHAR(5) NOT NULL,
  `actividades_extraescolares_codigo` INT(4) NOT NULL,
  PRIMARY KEY (`grupos_codigo`, `actividades_extraescolares_codigo`),
  INDEX `fk_grupos_has_actividades_extraescolares_actividades_extrae_idx` (`actividades_extraescolares_codigo` ASC),
  INDEX `fk_grupos_has_actividades_extraescolares_grupos1_idx` (`grupos_codigo` ASC),
  CONSTRAINT `fk_grupos_has_actividades_extraescolares_grupos1`
    FOREIGN KEY (`grupos_codigo`)
    REFERENCES `IntranetBatoi`.`grupos` (`codigo`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_grupos_has_actividades_extraescolares_actividades_extraesc1`
    FOREIGN KEY (`actividades_extraescolares_codigo`)
    REFERENCES `IntranetBatoi`.`actividades_extraescolares` (`codigo`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `IntranetBatoi`.`provincias`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `IntranetBatoi`.`provincias` (
  `id` VARCHAR(2) NOT NULL,
  `nombre` VARCHAR(60) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `IntranetBatoi`.`municipios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `IntranetBatoi`.`municipios` (
  `provincias_id` VARCHAR(2) NOT NULL,
  `cod_municipio` VARCHAR(4) NOT NULL,
  `municipio` VARCHAR(60) NOT NULL,
  INDEX `fk_municipios_provincias1_idx` (`provincias_id` ASC),
  PRIMARY KEY (`provincias_id`, `cod_municipio`),
  CONSTRAINT `fk_municipios_provincias1`
    FOREIGN KEY (`provincias_id`)
    REFERENCES `IntranetBatoi`.`provincias` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `IntranetBatoi`.`alumnos_has_grupos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `IntranetBatoi`.`alumnos_has_grupos` (
  `alumnos_id` INT(6) NOT NULL,
  `alumnos_nia` VARCHAR(8) NOT NULL,
  `alumnos_dni` VARCHAR(10) NOT NULL,
  `grupos_codigo` CHAR(5) NOT NULL,
  PRIMARY KEY (`alumnos_id`, `alumnos_nia`, `alumnos_dni`, `grupos_codigo`),
  INDEX `fk_alumnos_has_grupos_grupos1_idx` (`grupos_codigo` ASC),
  INDEX `fk_alumnos_has_grupos_alumnos1_idx` (`alumnos_id` ASC, `alumnos_nia` ASC, `alumnos_dni` ASC),
  CONSTRAINT `fk_alumnos_has_grupos_alumnos1`
    FOREIGN KEY (`alumnos_id` , `alumnos_nia` , `alumnos_dni`)
    REFERENCES `IntranetBatoi`.`alumnos` (`id` , `nia` , `dni`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_alumnos_has_grupos_grupos1`
    FOREIGN KEY (`grupos_codigo`)
    REFERENCES `IntranetBatoi`.`grupos` (`codigo`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
