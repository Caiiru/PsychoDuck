drop database if exists psychoduck;
create database psychoduck;
use psychoduck;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE Usuario (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    Nome VARCHAR(30) NOT NULL,
    CPF VARCHAR(20) UNIQUE NOT NULL,
    Email VARCHAR(30) NOT NULL,
    DT_Nascimento DATE DEFAULT NULL,
    Foto MEDIUMBLOB DEFAULT NULL
);
 

CREATE TABLE Curso (
    Nome_Curso VARCHAR(50),
    ID_Curso INT PRIMARY KEY AUTO_INCREMENT,
    Duracao_anos VARCHAR(3)
);

CREATE TABLE Professor (
    Matricula INT PRIMARY KEY AUTO_INCREMENT UNIQUE,
    fk_Usuario_ID INT UNIQUE,
    fK_Curso_ID_Curso INT
);

CREATE TABLE Aluno (
    Matricula INT PRIMARY KEY AUTO_INCREMENT,
    fk_Usuario_ID INT UNIQUE,
    fk_Curso_ID_Curso INT,
    DT_Inicio DATE,
    NotaMedia VARCHAR(5),
    QTD_Faltas INT
);

CREATE TABLE Psicologo (
    CIP VARCHAR(20) PRIMARY KEY,
    fk_Usuario_ID INT,
    fk_Especialidade_ID INT
);

CREATE TABLE Materia (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    Nome VARCHAR(30),
    QTD_Aulas INT,
    Turno VARCHAR(10)
);

CREATE TABLE Aula_Professor_Materia (
    ID_Aula INT PRIMARY KEY AUTO_INCREMENT,
    DT_Aula DATETIME,
    Observacao VARCHAR(300),
    fk_Professor_Matricula INT,
    fk_Materia_ID INT
);

CREATE TABLE Especialidade (
    ID_Espec INT PRIMARY KEY AUTO_INCREMENT,
    Nome_Espec VARCHAR(20),
    Descricao_Espec VARCHAR(300)
);

CREATE TABLE Possui (
    fk_Curso_ID_Curso INT,
    fk_Materia_ID INT
);

CREATE TABLE Assiste (
    fk_Aula_Professor_Materia_ID_Aula INT,
    fk_Aluno_Matricula INT
);

CREATE TABLE Consulta (
    fk_Psicologo_CIP VARCHAR(20),
    fk_Aluno_Matricula INT,
    DT_Consulta DATE,
    Observacao VARCHAR(300),
    ID_Consulta INT PRIMARY KEY AUTO_INCREMENT
);
 
ALTER TABLE Professor ADD CONSTRAINT FK_Professor_2
    FOREIGN KEY (fk_Usuario_ID)
    REFERENCES Usuario (ID)
    ON DELETE NO ACTION;
    
ALTER TABLE Professor ADD CONSTRAINT FK_Professor_3
    FOREIGN KEY (fk_Curso_ID_Curso)
    REFERENCES Curso (ID_Curso)
    ON DELETE NO ACTION;
 
ALTER TABLE Aluno ADD CONSTRAINT FK_Aluno_2
    FOREIGN KEY (fk_Usuario_ID)
    REFERENCES Usuario (ID)
    ON DELETE NO ACTION;
 
ALTER TABLE Aluno ADD CONSTRAINT FK_Aluno_3
    FOREIGN KEY (fk_Curso_ID_Curso)
    REFERENCES Curso (ID_Curso)
    ON DELETE CASCADE;
 
ALTER TABLE Psicologo ADD CONSTRAINT FK_Psicologo_2
    FOREIGN KEY (fk_Usuario_ID)
    REFERENCES Usuario (ID)
    ON DELETE NO ACTION;
 
ALTER TABLE Psicologo ADD CONSTRAINT FK_Psicologo_3
    FOREIGN KEY (fk_Especialidade_ID)
    REFERENCES Especialidade(ID_Espec)
    ON DELETE SET NULL;
 
ALTER TABLE Aula_Professor_Materia ADD CONSTRAINT FK_Aula_Professor_Materia_2
    FOREIGN KEY (fk_Professor_Matricula)
    REFERENCES Professor (Matricula);
 
ALTER TABLE Aula_Professor_Materia ADD CONSTRAINT FK_Aula_Professor_Materia_3
    FOREIGN KEY (fk_Materia_ID)
    REFERENCES Materia (ID);
 
ALTER TABLE Possui ADD CONSTRAINT FK_Possui_1
    FOREIGN KEY (fk_Curso_ID_Curso)
    REFERENCES Curso (ID_Curso)
    ON DELETE RESTRICT;
 
ALTER TABLE Possui ADD CONSTRAINT FK_Possui_2
    FOREIGN KEY (fk_Materia_ID)
    REFERENCES Materia(ID)
    ON DELETE RESTRICT;
 
ALTER TABLE Assiste ADD CONSTRAINT FK_Assiste_1
    FOREIGN KEY (fk_Aula_Professor_Materia_ID_Aula)
    REFERENCES Aula_Professor_Materia (ID_Aula)
    ON DELETE SET NULL;
 
ALTER TABLE Assiste ADD CONSTRAINT FK_Assiste_2
    FOREIGN KEY (fk_Aluno_Matricula)
    REFERENCES Aluno (Matricula)
    ON DELETE SET NULL;
 
ALTER TABLE Consulta ADD CONSTRAINT FK_Consulta_2
    FOREIGN KEY (fk_Psicologo_CIP)
    REFERENCES Psicologo (CIP)
    ON DELETE SET NULL;
 
ALTER TABLE Consulta ADD CONSTRAINT FK_Consulta_3
    FOREIGN KEY (fk_Aluno_Matricula)
    REFERENCES Aluno (Matricula)
    ON DELETE SET NULL;
    
INSERT INTO USUARIO(Nome, CPF, Email, DT_Nascimento)
VALUES("Jorge Flores", "11133399920", "jorgeflores@email.com", "2000-02-05"),
("Agnis Barbosa", "33145102312", "Ignisbarbosa@email.com", "1999-10-24"),
("Marcos Douglas", "4415213566", "marquinhosdagalera@email.com","1978-07-19"),
("Tonia Tilapia", "512371231231", "t.tonia@email.com","1994-01-07"),
("Jessica Rosa", "13151516123", "jepsicologa@email.com","1992-12-23"),
("Guilherme Santos", "204051231233","gui@email.com","1989-03-28");

INSERT INTO Curso(Nome_Curso,Duracao_anos)
values("Engenharia de Software","4"),
("Culinaria", "4.5"),
("Arquitetura","5.5"),
("Marketing","2.5"),
("Design de Moda","8");

INSERT INTO ALUNO(fk_Usuario_ID, fk_Curso_ID_Curso,DT_Inicio,NotaMedia,QTD_Faltas)
values(1,3,"2022-02-14",90,5),
(2,4,"2023-02-18",60,10);

INSERT INTO PROFESSOR(fk_Usuario_ID, fk_Curso_ID_Curso)
values(3,1),(4,2);

INSERT INTO ESPECIALIDADE(NOME_ESPEC,DESCRICAO_ESPEC)
values("Psicopedagogia","Atua na investigação e intervenção nos processos de aprendizagem de habilidades e conteúdos acadêmicos. "),
("Psicologia Social","Atua fundamentado na compreensão da dimensão subjetiva dos fenômenos sociais e coletivos, sob diferentes enfoques teóricos e metodológicos, com o objetivo de problematizar e propor ações no âmbito social."),
("Neuropsicologia","Atua no diagnóstico, no acompanhamento, no tratamento e na pesquisa da cognição, das emoções, da personalidade e do comportamento sob o enfoque da relação entre estes aspectos e o funcionamento cerebral. ");

INSERT INTO PSICOLOGO (CIP,FK_USUARIO_ID,FK_ESPECIALIDADE_ID)
values("213131221231",5,1),
("13245516667",6,3);
 

INSERT INTO MATERIA (Nome,QTD_AULAS,TURNO)
VALUES("Banco de Dados", 30, "Noite"),
("Etica",45,"Manhã"),
("Web Seguros", 25, "Tarde");
    
    
INSERT INTO AULA_PROFESSOR_MATERIA(DT_AULA, OBSERVACAO, FK_PROFESSOR_MATRICULA,FK_MATERIA_ID)
VALUES("2023-10-31 08:15:27", "Prova Formativa", 1,1);

INSERT INTO ASSISTE
values(1,1);

insert into possui
values(1,1),
(1,2),
(1,3);
 
SELECT ID, CIP,Nome,Nome_Espec as Especialidade, Foto FROM Psicologo as P INNER JOIN Usuario as U ON (P.fk_Usuario_ID = U.ID) inner join especialidade as E On (P.fk_Especialidade_Id = e.ID_Espec);
select * from professor;
select * from usuario;
select * from aluno;

/*SELECT PROFESSOR*/
SELECT Matricula, Nome as Nome_Professor,CPF, Nome_Curso as Curso, Foto FROM Professor as P INNER JOIN Usuario as U ON (P.fk_Usuario_ID = U.ID) INNER JOIN Curso as C ON (P.fk_Curso_ID_Curso = C.ID_Curso);

/*SELECT CURSO*/
select ID_Curso as ID, Nome_Curso as Nome  from curso; 

/*SELECT Aluno*/
SELECT Matricula,CPF,Nome, Nome_Curso as Curso, NotaMedia, QTD_FALTAS as Faltas,DATE_FORMAT(DT_Inicio, '%d/%m/%Y') as Data_Inicio, DATE_FORMAT(DT_Nascimento,'%d/%m/%Y') as Data_Nascimento, Foto FROM Usuario as U INNER JOIN Aluno as A ON (A.fk_Usuario_ID = U.ID) INNER JOIN CURSO AS C ON (A.fk_Curso_ID_CUrso = C.ID_Curso);

/*SELECT Psicologo*/
SELECT ID,Nome as Nome_Psicologo, CIP, Nome_Espec as Especialidade, Foto FROM Usuario as U INNER JOIN Psicologo as P ON (P.fk_Usuario_ID = U.ID) INNER JOIN Especialidade AS E ON (P.fK_Especialidade_ID = E.ID_Espec);

/*SELECT Especilidade*/
SELECT ID_Espec as ID, Nome_Espec as Nome_Especialidade FROM Especialidade;

SELECT * FROM USUARIO; 
SELECT Matricula,CPF,Nome,Email, Nome_Curso as Curso, NotaMedia, QTD_FALTAS as Faltas,
				DATE_FORMAT(DT_Inicio, '%d/%m/%Y') as Data_Inicio, 
				DATE_FORMAT(DT_Nascimento,'%d/%m/%Y') as Data_Nascimento, Foto 
				FROM Usuario as U INNER JOIN Aluno as A ON (A.fk_Usuario_ID = U.ID) 
				INNER JOIN CURSO AS C ON (A.fk_Curso_ID_CUrso = C.ID_Curso);
                
SELECT Matricula,CPF,Nome,Email, Nome_Curso as Curso, NotaMedia, QTD_FALTAS as Faltas,
				DATE_FORMAT(DT_Inicio, '%d/%m/%Y') as Data_Inicio, 
				DT_Nascimento as Data_Nascimento, Foto 
				FROM Usuario as U INNER JOIN Aluno as A ON (A.fk_Usuario_ID = U.ID) 
				INNER JOIN CURSO AS C ON (A.fk_Curso_ID_CUrso = C.ID_Curso);

                
select * from Curso;

UPDATE Usuario SET Nome = 'Jorgao'
				WHERE ID = 1;
                
select * from usuario;

SELECT * FROM professor;
    

SELECT fk_Usuario_ID as ID_Psicologo, U.Nome FROM PSICOLOGO as P INNER JOIN Usuario as U ON (P.fk_Usuario_ID = U.ID)
	WHERE P.fk_Usuario_ID = U.ID; 

SELECT Nome FROM PSICOLOGO as P Inner join Usuario as U ON (P.fk_Usuario_ID = U.ID) WHERE CIP = '13245516667';

INSERT INTO Consulta(fk_Psicologo_CIP, fk_Aluno_Matricula, DT_Consulta) values('13245516667', 1, '2020-02-01');
SELECT * FROM CONSULTA;

SELECT Nome, ID as ID_Psicologo FROM Usuario as U INNER JOIN Psicologo as P ON(P.fk_Usuario_ID = U.ID);

 
 SELECT ID_Consulta, fk_Psicologo_CIP, fk_Aluno_Matricula, DT_Consulta, Observacao, ID_Consulta FROM Consulta;
 
SELECT P.fk_Usuario_ID as ID_Psicologo, ID_Consulta as ID, CIP, UP.Nome as Nome_Psicologo, UA.ID as ID_Aluno, UA.Nome as Nome_Aluno, DT_Consulta, Observacao as Ob FROM CONSULTA as C INNER JOIN Aluno as A 
					INNER JOIN USUARIO AS UA ON (A.fk_Usuario_ID = UA.ID) 
					INNER JOIN Psicologo as P INNER JOIN USUARIO AS UP ON(P.fK_Usuario_ID = UP.ID)
					WHERE P.CIP=C.fk_Psicologo_CIP AND A.Matricula = C.fk_Aluno_Matricula;
                    
SELECT ID_Consulta as ID, UP.Nome as Psicologo_Nome, CIP, UA.Nome as Nome_Aluno, DT_Consulta, Observacao as Ob FROM CONSULTA as C INNER JOIN Aluno as A 
					INNER JOIN USUARIO AS UA ON (A.fk_Usuario_ID = UA.ID) 
					INNER JOIN Psicologo as P INNER JOIN USUARIO AS UP ON(P.fK_Usuario_ID = UP.ID)
					WHERE P.CIP=C.fk_Psicologo_CIP AND A.Matricula = C.fk_Aluno_Matricula AND ID_Consulta = 1;
                     
select * from consulta; 

DELETE FROM Consulta WHERE ID_Consulta = 1;

UPDATE Consulta SET fk_Aluno_Matricula =2 where ID_Consulta = 1;

SELECT * FROM Aluno;
 
COMMIT;