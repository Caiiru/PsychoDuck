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
    fk_Especialidade_ID INT DEFAULT NULL
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

  
 
 
ALTER TABLE Consulta ADD CONSTRAINT FK_Consulta_2
    FOREIGN KEY (fk_Psicologo_CIP)
    REFERENCES Psicologo (CIP)
    ON DELETE SET NULL;
 
ALTER TABLE Consulta ADD CONSTRAINT FK_Consulta_3
    FOREIGN KEY (fk_Aluno_Matricula)
    REFERENCES Aluno (Matricula)
    ON DELETE SET NULL;
    
INSERT INTO USUARIO(Nome, CPF, Email, DT_Nascimento)
VALUES("Jorge de Morais", "11133399920", "jorgeflores@email.com", "2000-02-05"),
("Agnis Barbosa", "63233987021", "Ignisbarbosa@email.com", "1999-10-24"),
("Marcos Douglas", "28463441084", "marquinhosdagalera@email.com","1978-07-19"),
("Tonia Tilapia", "42748907086", "t.tonia@email.com","1994-01-07"),
("Jessica Rosa", "78950935090", "jepsicologa@email.com","1992-12-23"),
("Guilherme Santos", "56734379000","gui@email.com","1989-03-28"),
("Otávio Correia", "52829372042", "otavio12@email.com","2001-11-23"),
("Fabio Cavalcanti","26396930005", "fafa37_2309@email.com","1992-01-27"),
("Sofia Cardoso", "33933152003", "sofi_business@email.com","1999-12-02"),
("Victor Cavalcanti", "84451956030", "victor_cavalcanti@email.com", "1992-01-27"),
("Gabrielle Melo", "89950555027", "gabrielle@email.com", "2002-06-29"),
("Vitór Lima", "23269447043", "victinibestpokemon@email.com", "2004-09-18"),
("Miguel Alves", "35384291036", "miguelalvescassiano@email.com", "2000-02-27"),
("Mariana Barros", "31506354033", "marianacontato@email.com","1982-12-21"),
("Arthur Goncalves", "21097077047", "coronelgoncalves@email.gov.br", "1976-11-11"),
("Danilo Costa", "42267245000", "masterdan@email.com","1993-06-02"),
("Lucas Silva", "91152606077", "silvalucas@email.com", "1989-07-14"),
("Vinicius Melo", "24785359048", "viniyellow@email.com", "1999-01-13"),
("Renan Lima", "43413503073", "Thiagorenan@email.com", "1983-10-29"),
("Lara Barbosa", "39482920007", "larabarbosa0021@email.com","1995-06-22"),
("Maria Sofia Santos", "80292435029", "mariasofiasantista@email.com","2005-04-27"),
("Giovana Oliveira", "71920368035", "gioviskioliveira@email.com","1971-06-22"),
("Laura Ferreira", "24257425067", "ferreilaura@email.com", "1989-11-07"),
("Leila Pereira", "39974019001", "leilafernandes@email.com","1983-05-25"),
("Melissa Rocha", "20988604043", "melissabarbosa@email.com","1992-03-02"),
("Douglas Melo", "89533059001", "melocarsdouglas@email.coM","1990-01-27");

INSERT INTO Curso(Nome_Curso,Duracao_anos)
values("Engenharia de Software","4"),
("Culinaria", "4.5"),
("Arquitetura","5.5"),
("Marketing","2.5"),
("Design de Moda","8"),
("Administração", "4"),
("Biomedicina","5"),
("Ciencias Biologicas","6"),
("Design de Produto","3.5"),
("Engenharia Ambiental","5"),
("Engenharia Elétrica","6"),
("Farmacia","4"),
("Fisioterapia","4"),
("Medicina Veterinaria","8"),
("Pedagogia","5"),
("Turismo","3"),
("Fisica","4.5");


INSERT INTO ALUNO(fk_Usuario_ID, fk_Curso_ID_Curso,DT_Inicio,NotaMedia,QTD_Faltas)
values(1,3,"2022-02-14",90,5),
(2,4,"2023-02-18",60,10),
(7,8,"2021-06-17",85,30),
(8,15,"2019-02-23",90,5),
(9,17,"2016-06-18",56,45),
(10,12,"2017-06-18",76,21),
(11,5,"2019-02-18",97,15),
(12,2,"2022-06-12",80,13),
(13,10,"2023-06-18",100,2);

INSERT INTO PROFESSOR(fk_Usuario_ID, fk_Curso_ID_Curso)
values(3,1),
(4,2),
(14,2),
(15,10),
(16,13),
(17,6),
(18,17),
(19,7);

INSERT INTO ESPECIALIDADE(NOME_ESPEC,DESCRICAO_ESPEC)
values
(" "," "),
("Psicopedagogia","Atua na investigação e intervenção nos processos de aprendizagem de habilidades e conteúdos acadêmicos. "),
("Psicologia Social","Atua fundamentado na compreensão da dimensão subjetiva dos fenômenos sociais e coletivos, sob diferentes enfoques teóricos e metodológicos, com o objetivo de problematizar e propor ações no âmbito social."),
("Neuropsicologia","Atua no diagnóstico, no acompanhamento, no tratamento e na pesquisa da cognição, das emoções, da personalidade e do comportamento sob o enfoque da relação entre estes aspectos e o funcionamento cerebral. ");

INSERT INTO PSICOLOGO (CIP,FK_USUARIO_ID,FK_ESPECIALIDADE_ID)
values("213131221231",5,2),
("13245516667",6,3),
("11118857020",20, 1),
("05969067067",21,2),
("39833688080",22,4),
("38160204027",23,1),
("22607860067",24,2),
("75778950080",25,3),
("19172884096", 26,2);
 

 
COMMIT;