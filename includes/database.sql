CREATE DATABASE gestor_examenes;

USE gestor_examenes;

CREATE TABLE users
(uid int unsigned NOT NULL auto_increment,
name varchar(15) NOT NULL,
surname varchar(30) NOT NULL,
email varchar(50) NOT NULL,
pass varchar(255) NOT NULL,
rol varchar(15) NOT NULL,
PRIMARY KEY (uid)
);

CREATE TABLE centers
( centerid int unsigned NOT NULL auto_increment,
name varchar(25) NOT NULL,
PRIMARY KEY (centerid));

CREATE TABLE degrees 
( degreeid int unsigned NOT NULL auto_increment, 
name varchar(25) NOT NULL,
centerid int unsigned NOT NULL,
PRIMARY KEY (degreeid),
FOREIGN KEY (centerid) REFERENCES centers(centerid));

CREATE TABLE subjects 
( subjectid int unsigned NOT NULL auto_increment, 
name varchar(25) NOT NULL, 
degreeid int unsigned NOT NULL,
coordinatorid int unsigned NOT NULL,
PRIMARY KEY (subjectid),
FOREIGN KEY (degreeid) REFERENCES degrees(degreeid)
);

CREATE TABLE usersubjects
(subjectid int unsigned NOT NULL,
uid int unsigned NOT NULL,
FOREIGN KEY (subjectid) REFERENCES subjects(subjectid),
FOREIGN KEY (uid) REFERENCES users(uid)
);

CREATE TABLE units 
( unitid int unsigned NOT NULL auto_increment, 
name varchar(25) NOT NULL, 
subjectid int unsigned NOT NULL,
PRIMARY KEY (unitid),
FOREIGN KEY (subjectid) REFERENCES subjects(subjectid)
);
CREATE TABLE questions
( questionid int unsigned NOT NULL auto_increment,
text text NOT NULL,
unitid int unsigned NOT NULL,
PRIMARY KEY (questionid),
FOREIGN KEY (unitid) REFERENCES units(unitid)
);

CREATE TABLE answers
( answerid int unsigned NOT NULL auto_increment,
answertext text NOT NULL,
questionid int unsigned NOT NULL,
value BOOLEAN NOT NULL,
PRIMARY KEY (answerid),
FOREIGN KEY (questionid) REFERENCES questions(questionid) ON DELETE CASCADE
);

CREATE TABLE exams
( examid int unsigned NOT NULL auto_increment,
uid int unsigned NOT NULL,
subjectid int unsigned NOT NULL,
estado varchar(10) NOT NULL,
nota int unsigned,
date date,
PRIMARY KEY (examid),
FOREIGN KEY (uid) REFERENCES users(uid),
FOREIGN KEY (subjectid) REFERENCES subjects(subjectid)
);

CREATE TABLE examanswers
(
answerid int unsigned NOT NULL,
examid int unsigned NOT NULL,
FOREIGN KEY (answerid) REFERENCES answers(answerid) ON DELETE CASCADE,
FOREIGN KEY (examid) REFERENCES exams(examid)
);


INSERT INTO centers VALUES (null, "ESI");


INSERT INTO degrees VALUES (null, "GII",1);
INSERT INTO degrees VALUES (null, "GIA",1);

INSERT INTO users VALUES( NULL, "Roberto", "Gonzalez Alvarez", "rober@gmail.com", "123", "profesor");
INSERT INTO users VALUES( NULL, "Carlos", "Garcia Fernandez", "carlos@gmail.com", "123", "profesor");
INSERT INTO users VALUES( NULL, "Juanca", "Camacho Carribero", "juanca@gmail.com", "123", "alumno");
INSERT INTO users VALUES( NULL, "Rafa", "Rodriguez Calvante", "rafa@gmail.com", "123", "admin");

INSERT INTO subjects VALUES (null, "PW",1,1);
INSERT INTO subjects VALUES (null, "MP",1,1);
INSERT INTO subjects VALUES (null, "POO",1,1);

INSERT INTO subjects VALUES (null, "MV",2,2);
INSERT INTO subjects VALUES (null, "NA",2,2);
INSERT INTO subjects VALUES (null, "FP",2,2);

INSERT INTO usersubjects VALUES ("1", "1");
INSERT INTO usersubjects VALUES ("2", "1"); 
INSERT INTO usersubjects VALUES ("3", "1");

INSERT INTO units VALUES (null, "Introducci??n al PHP","1");
INSERT INTO units VALUES (null, "Lado del servidor","1");
INSERT INTO units VALUES (null, "Introducci??n a la programaci??n","2");
INSERT INTO units VALUES (null, "Recursividad","2");
INSERT INTO units VALUES (null, "Introducci??n a la POO","3");
INSERT INTO units VALUES (null, "Constructores y destructores","3");


INSERT INTO questions VALUES (null, "??Que es PHP?", 1);
INSERT INTO answers VALUES (null, "Un lenguaje de programaci??n", 1, 1);
INSERT INTO answers VALUES (null, "Un framework", 1, 0);
INSERT INTO answers VALUES (null, "Un patr??n de dise??o", 1, 0);

INSERT INTO questions VALUES (null, "??Donde se ejecuta este c??digo?", 1);
INSERT INTO answers VALUES (null, "En el back", 2, 1);
INSERT INTO answers VALUES (null, "En el front", 2, 0);
INSERT INTO answers VALUES (null, "Otro", 2, 0);

INSERT INTO questions VALUES (null, "??Que es el lado del servidor?", 1);
INSERT INTO answers VALUES (null, "El backend", 3, 1);
INSERT INTO answers VALUES (null, "El frontend", 3, 0);
INSERT INTO answers VALUES (null, "Ninguna de las otras", 3, 0);

INSERT INTO questions VALUES (null, "??Que es el server-side?", 1);
INSERT INTO answers VALUES (null, "El backend", 4, 1);
INSERT INTO answers VALUES (null, "El frontend", 4, 0);
INSERT INTO answers VALUES (null, "Ninguna de las otras", 4, 0);

INSERT INTO questions VALUES (null, "??El usuario ve c??digo PHP?", 1);
INSERT INTO answers VALUES (null, "Depende de nuestra implementaci??n como desarrolladores", 5, 1);
INSERT INTO answers VALUES (null, "Siempre", 5, 0);
INSERT INTO answers VALUES (null, "Ninguna de las otras", 5, 0);

INSERT INTO questions VALUES (null, "??Qu?? es la modularidad?", 1);
INSERT INTO answers VALUES (null, "Caracter??stica de un sistema que permite que sea entendido como la uni??n de varias partes que interact??an entre s??", 6, 1);
INSERT INTO answers VALUES (null, "Otro", 6, 0);
INSERT INTO answers VALUES (null, "Un concepto espec??fico s??lo de programaci??n estructurada a objetos", 6, 0);

INSERT INTO questions VALUES (null, "??Qu?? lenguaje es m??s conocido en PW?", 1);
INSERT INTO answers VALUES (null, "PHP", 7, 1);
INSERT INTO answers VALUES (null, "C++", 7, 0);
INSERT INTO answers VALUES (null, "Ninguna de las otras", 7, 0);

INSERT INTO questions VALUES (null, "??Que es una dependencia?", 1);
INSERT INTO answers VALUES (null, "Es un concepto de POO", 8, 1);
INSERT INTO answers VALUES (null," Es un concepto de programaci??n funcional", 8, 0);
INSERT INTO answers VALUES (null, "Ninguna de las otras", 8, 0);

INSERT INTO questions VALUES (null, "??Qu?? es la recursividad?", 1);
INSERT INTO answers VALUES (null, "Llamadas a la misma funci??n dentro de ella misma", 9, 1);
INSERT INTO answers VALUES (null, "Mecanismo usado en API Rest", 9, 0);
INSERT INTO answers VALUES (null, "Ninguna de las otras", 9, 0);

INSERT INTO questions VALUES (null, "??Cu??ndo se utiliza la recursividad?", 1);
INSERT INTO answers VALUES (null, "??nicamente cuando sea necesario, siempre y cuando no exista soluci??n iterativa", 10, 1);
INSERT INTO answers VALUES (null, "Nunca", 10, 0);
INSERT INTO answers VALUES (null, "Ninguna de las otras", 10, 0);

INSERT INTO questions VALUES (null, "??Es eficiente la recursividad?", 1);
INSERT INTO answers VALUES (null, "No", 11, 0);
INSERT INTO answers VALUES (null, "S??", 11, 0);
INSERT INTO answers VALUES (null, "Depende el algoritmo", 11, 1);

INSERT INTO questions VALUES (null, "??Qu?? es una clase?", 1);
INSERT INTO answers VALUES (null, "Construcci??n que permite agrupar variables y m??todos", 12, 1);
INSERT INTO answers VALUES (null, "Construcci??n que permite agrupar variables y funciones", 12, 0);
INSERT INTO answers VALUES (null, "Ninguna de las otras", 12, 0);

INSERT INTO questions VALUES (null, "??Qu?? es un objeto?", 1);
INSERT INTO answers VALUES (null, "Se trata de un ente abstracto usado en programaci??n que permite separar los diferentes componentes de un programa", 13, 1);
INSERT INTO answers VALUES (null, "Construcci??n que permite agrupar variables y funciones", 13, 0);
INSERT INTO answers VALUES (null, "Ninguna de las otras", 13, 0);