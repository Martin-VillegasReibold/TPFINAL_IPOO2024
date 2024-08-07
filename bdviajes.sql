CREATE DATABASE bdviajes; 
USE bdviajes2;
CREATE TABLE persona(
    pnumdoc bigint PRIMARY KEY,
    pnombre varchar(150),
    papellido varchar(150),
    ptelefono bigint
    )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE empresa(
    idempresa bigint AUTO_INCREMENT,
    enombre varchar(150),
    edireccion varchar(150),
    PRIMARY KEY (idempresa)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE responsable (
    rnumeroempleado bigint AUTO_INCREMENT,
    rnumerolicencia bigint,
    rnumdoc bigint,
    PRIMARY KEY (rnumeroempleado),
    FOREIGN KEY (rnumdoc) REFERENCES persona(pnumdoc)
    )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
	
CREATE TABLE viaje (
    idviaje bigint AUTO_INCREMENT, 
	vdestino varchar(150),
    vmaxpasajeros bigint,
	idempresa bigint,
    rnumeroempleado bigint,
    vimporte float, 
    PRIMARY KEY (idviaje),
    FOREIGN KEY (idempresa) REFERENCES empresa (idempresa) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY (rnumeroempleado) REFERENCES responsable (rnumeroempleado)
    ON UPDATE CASCADE ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT = 1;
	
    CREATE TABLE pasajero ( 
    idpasajero bigint AUTO_INCREMENT, 
    pdocumento bigint,
    numasiento bigint,
    numticket bigint,
    idviaje bigint, 
    PRIMARY KEY (idpasajero), 
    FOREIGN KEY (pdocumento) REFERENCES persona (pnumdoc)  ON UPDATE CASCADE
    ON DELETE CASCADE,
    FOREIGN KEY (idviaje) REFERENCES viaje (idviaje)  ON UPDATE CASCADE
    ON DELETE CASCADE
    )ENGINE=InnoDB DEFAULT CHARSET=utf8;


    