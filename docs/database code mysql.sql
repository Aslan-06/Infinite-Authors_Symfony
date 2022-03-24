#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Table: Livre
#------------------------------------------------------------

CREATE TABLE Livre(
        id           int (11) Auto_increment  NOT NULL ,
        Titre        Varchar (255) NOT NULL ,
        Auteur       Varchar (255) NOT NULL ,
        dateCreation Date NOT NULL ,
        imageLien        Varchar (255) ,
        PRIMARY KEY (id )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Section
#------------------------------------------------------------

CREATE TABLE Section(
        id        int (11) Auto_increment  NOT NULL ,
        titre     Varchar (255) NOT NULL ,
        idSection Int ,
        idLivre   Int NOT NULL ,
        numSequence Int,
        PRIMARY KEY (id )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Texte
#------------------------------------------------------------

CREATE TABLE Texte(
        id           int (11) Auto_increment  NOT NULL ,
        contenu      Text NOT NULL ,
        idSection   Int NOT NULL ,
        PRIMARY KEY (id )
)ENGINE=InnoDB;

ALTER TABLE Section ADD CONSTRAINT FK_Section_id_Livre FOREIGN KEY (idLivre) REFERENCES Livre(id);
ALTER TABLE Texte ADD CONSTRAINT FK_Texte_id_Section FOREIGN KEY (idSection) REFERENCES Section(id);
