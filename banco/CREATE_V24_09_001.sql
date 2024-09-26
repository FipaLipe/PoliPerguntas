CREATE TABLE perguntas (
	id_pergunta INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    id_user_adicionou INTEGER NOT NULL,
    texto VARCHAR(255),
    imagem VARCHAR(200),
    dt_criada TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    situacao CHAR(1) NOT NULL DEFAULT 'I',
    dt_aberta TIMESTAMP,
    dt_fechada TIMESTAMP
);

CREATE TABLE alternativas (
	id_alternativa INTEGER NOT NULL PRIMARY KEY,
    id_pergunta INTEGER NOT NULL,
    correta BOOLEAN NOT NULL,
    texto VARCHAR(200),
    imagem VARCHAR(200)
);

CREATE TABLE users (
	id_user INTEGER NOT NULL PRIMARY KEY,
    rm VARCHAR(8) NOT NULL UNIQUE,
    nome VARCHAR(100) NOT NULL,
    senha VARCHAR(200) NOT NULL,
    pontos INTEGER DEFAULT 0,
    imagem VARCHAR(200),
    admin BOOL NOT NULL DEFAULT FALSE,
    situacao CHAR(1) NOT NULL DEFAULT 'A',
    dt_criado TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    dt_alterado TIMESTAMP
);

CREATE TABLE respostas (
	id_respota INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    id_pergunta INTEGER NOT NULL,
    id_alternativa INTEGER NOT NULL,
    id_user INTEGER NOT NULL,
    dt_respondida TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE perguntas
ADD FOREIGN KEY(id_user_adicionou) REFERENCES users(id_user);

ALTER TABLE alternativas
ADD FOREIGN KEY(id_pergunta) REFERENCES perguntas(id_pergunta);

ALTER TABLE respostas
ADD FOREIGN KEY(id_pergunta) REFERENCES perguntas(id_pergunta);

ALTER TABLE respostas
ADD FOREIGN KEY(id_alternativa) REFERENCES perguntas(id_alternativa);

ALTER TABLE respostas
ADD FOREIGN KEY(id_user) REFERENCES perguntas(id_user);