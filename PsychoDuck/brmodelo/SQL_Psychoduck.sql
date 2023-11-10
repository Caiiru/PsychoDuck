drop database if exists psychoduck_database;
create database psychoduck_database;
use psychoduck_database;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE Usuario (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    Nome VARCHAR(30),
    CPF VARCHAR(20),
    Email VARCHAR(30),
    DT_Nascimento DATE
);
 

CREATE TABLE Curso (
    Nome_Curso VARCHAR(20),
    ID_Curso INT PRIMARY KEY AUTO_INCREMENT,
    Duracao_anos VARCHAR(3)
);

CREATE TABLE Professor (
    Matricula INT PRIMARY KEY,
    fk_Usuario_ID INT
);

CREATE TABLE Aluno (
    Matricula INT PRIMARY KEY AUTO_INCREMENT,
    fk_Usuario_ID INT,
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
    ID INT PRIMARY KEY AUTO_INCREMENT,
    Nome VARCHAR(20),
    Descricao VARCHAR(300)
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
    DT_Consulta DATETIME,
    Observacao VARCHAR(300),
    ID_Consulta INT PRIMARY KEY AUTO_INCREMENT
);
 
ALTER TABLE Professor ADD CONSTRAINT FK_Professor_2
    FOREIGN KEY (fk_Usuario_ID)
    REFERENCES Usuario (ID)
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
    REFERENCES Especialidade(ID)
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
("Marketing","2.5");

INSERT INTO ALUNO(fk_Usuario_ID, fk_Curso_ID_Curso,DT_Inicio,NotaMedia,QTD_Faltas)
values(1,4,"2022-02-14",90,5),
(2,4,"2023-02-18",60,10);

INSERT INTO PROFESSOR(Matricula,fk_Usuario_ID)
values(1,3),(2,4);

INSERT INTO ESPECIALIDADE(NOME,DESCRICAO)
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

SELECT * FROM ASSISTE;

select * from possui;

insert into possui
values(1,1),
(1,2),
(1,3);

select * from possui;

SELECT Nome_Curso as Curso, Nome as Materia
FROM Possui p 
Inner join Curso C ON c.ID_Curso = p.fk_Curso_ID_Curso
INNER JOIN Materia M on m.ID = p.fk_Materia_ID;

SELECT * FROM ESPECIALIDADE;
COMMIT;