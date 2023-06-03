
CREATE TABLE person
(
  idPerson        BIGINT       NOT NULL AUTO_INCREMENT,
  email           VARCHAR(255) NOT NULL,
  name            VARCHAR(255) NOT NULL,
  password        VARCHAR(255) NOT NULL,
  photo           VARCHAR(255) NULL    ,
  birth           DATE         NULL    ,
  cellphone       INT(11)      NULL    ,
  createdOn       DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  sysWhats        TINYINT(1)   NOT NULL DEFAULT 0,
  sysConfirmEmail TINYINT(1)   NOT NULL DEFAULT 0,
  sysConfirmTerms TINYINT(1)   NOT NULL DEFAULT 0,
  PRIMARY KEY (idPerson)
);

CREATE TABLE personRole
(
  idRole BIGINT NOT NULL,
  idPerson BIGINT NOT NULL,
  PRIMARY KEY (idRole, idPerson)
);

CREATE TABLE role
(
  idRole BIGINT       NOT NULL AUTO_INCREMENT,
  role   VARCHAR(255) NOT NULL,
  PRIMARY KEY (idRole)
);