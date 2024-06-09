create database practicafinal;
use practicafinal;
create table articulos (
    coda varchar(100),
    nombre varchar(100),
    pvp int,
    iva int,
    constraint PK_ARTICULOS primary key (coda)
);
CREATE TABLE usuarios (
  usuario VARCHAR(30) NOT NULL,
  pass VARCHAR(100) NOT NULL,
  CONSTRAINT usuarios_pk PRIMARY KEY(usuario)
);
CREATE TABLE ventas (
    id INT AUTO_INCREMENT,
    usuario VARCHAR(30) NOT NULL,
    coda VARCHAR(100) NOT NULL,
    fecha DATE NOT NULL,
    cantidad INT NOT NULL,
    total_gasto DECIMAL(10, 2) NOT NULL,
    CONSTRAINT PK_VENTAS PRIMARY KEY (id),
    CONSTRAINT FK_USUARIO FOREIGN KEY (usuario) REFERENCES usuarios(usuario),
    CONSTRAINT FK_ARTICULO FOREIGN KEY (coda) REFERENCES articulos(coda)
);

insert into articulos values ("A1","Elden Ring",60,21);
insert into articulos values ("A2","Persona 5 Royal",40,21);
insert into articulos values ("A3","Nier Automata",20,21);
insert into articulos values ("A4","Pokemon Escarlata",60,21);
insert into articulos values ("A5","GTA V",20,21);
insert into articulos values ("A6","God Of War Ragnarock",50,21);
insert into articulos values ("A7","Resident Evil 4 Remake",40,21);
insert into articulos values ("A8","Dark Souls 3",10,21);
insert into articulos values ("A9","Monster Hunter World:Iceborne",20,21);
insert into articulos values ("A10","Bloodborne",10,21);
insert into articulos values ("A11","League Of Legends",0,21);
insert into articulos values ("A12","Hearthstone",0,21);
insert into articulos values ("A13","World of Warcraft",60,21);
insert into articulos values ("A14","The Last of US",10,21);
insert into articulos values ("A15","The Last of US parte 2",40,21);
commit;

