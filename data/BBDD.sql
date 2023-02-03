CREATE DATABASE photoSold;
USE photoSold;

GRANT ALL PRIVILEGES ON photoSold.* TO 'Admin'@'%' IDENTIFIED BY '12345';
FLUSH PRIVILEGES;

CREATE TABLE usuario(
    dni VARCHAR(9) NOT NULL PRIMARY KEY,
    nombre VARCHAR(30) NOT NULL,
    apellidos VARCHAR(30) NOT NULL,
    password VARCHAR(30) NOT NULL,
    email VARCHAR(50) NOT NULL,
    admin BOOLEAN DEFAULT false,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE fotografia(
    id_fotografia int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(30) NOT NULL,
    precio FLOAT NOT NULL,
    tamanio VARCHAR(50) NOT NULL,
    imagen VARCHAR(255) NOT NULL,
    creador VARCHAR(30) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE usuario_foto(
id_fotografia int(11) UNSIGNED AUTO_INCREMENT,
dni varchar (9) NOT NULL,
PRIMARY KEY (id_fotografia,dni),
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO usuario (dni, nombre ,apellidos, password ,email,admin) VALUES
(00000,'admin','admin',12345,'admin@admin.com',1);

INSERT INTO fotografia (nombre,precio,tamanio,imagen,creador) VALUES
('paisaje01',1.50,'2160 X 1442','../PUBLIC/images/pexels-jeff-nissen-942255.jpg','Jeff Nissen'),
('paisaje02',1.50,'7952 X 5034','../PUBLIC/images/pexels-jeremy-bishop-2923595.jpg','Jeremy Bishop'),
('paisaje03',1.50,'2500 X 1667','../PUBLIC/images/pexels-luis-del-río-15286.jpg','Luís del Río'),
('paisaje04',1.50,'2201 X 1467','../PUBLIC/images/pexels-pixabay-206359.jpg','Pixabay'),
('paisaje05',1.50,'20160 X 1442','../PUBLIC/images/pexels-pixabay-209807.jpg','Pixabay'),
('paisaje06',1.50,'2000 X 1333','../PUBLIC/images/pexels-pixabay-531602.jpg','Pixabay'),
('paisaje07',1.50,'5342 X 3648','../PUBLIC/images/pexels-roberto-nickson-2885320.jpg','Roberto Nickson');

ALTER TABLE usuario_foto ADD FOREIGN KEY (id_fotografia) REFERENCES fotografia(id_fotografia);
ALTER TABLE usuario_foto ADD FOREIGN KEY (dni) REFERENCES usuario(dni);



