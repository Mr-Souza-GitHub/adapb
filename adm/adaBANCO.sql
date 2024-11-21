-- Active: 1697111381451@@127.0.0.1@5432@ada
-- CRIANDO BANCO
CREATE DATABASE ADA;


-- ADICIONANDO AS TABELAS

-- Sexo {masc, fem}
CREATE TABLE SEXO(
    CODSEXO SERIAL PRIMARY KEY,
    NOMESEXO VARCHAR(80) NOT NULL UNIQUE
);

-- Tipo {cão ou gato (pode ter mais depois)}
CREATE TABLE TIPO (
    CODTIPO SERIAL PRIMARY KEY,
    NOMETIPO VARCHAR(80) NOT NULL UNIQUE
);

-- Raca {racas de cachorros e gatos (todas as raças)}
CREATE TABLE RACA(
    CODRACA SERIAL PRIMARY KEY,
    NOMERACA VARCHAR(80) NOT NULL UNIQUE,
    PURA BOOLEAN
);

-- Deficiencia {nenhuma, mobilidade, visual, auditiva}
CREATE TABLE DEFICIENCIA(
    CODDEFICIENCIA SERIAL PRIMARY KEY,
    NOMEDEFICIENCIA VARCHAR(80) NOT NULL UNIQUE
);

-- Doença {Cegueira, Leishmaniose, etc}
CREATE TABLE DOENCA(
    CODDOENCA SERIAL PRIMARY KEY,
    NOMEDOENCA VARCHAR(80) NOT NULL UNIQUE
);

-- Vacinacao {em dia, atrasada ou agendada}
CREATE TABLE VACINACAO(
    CODVACINACAO SERIAL PRIMARY KEY,
    ESTADOVACINACAO VARCHAR(80) NOT NULL UNIQUE
);

-- Animal {nome, sexo, tipo, raça, vacinação, descrição e status de adoção}
CREATE TABLE ANIMAL(
    CODANIMAL SERIAL PRIMARY KEY,
    NOMEANIMAL VARCHAR(80) NOT NULL,
    SEXOANIMAL INTEGER REFERENCES SEXO(CODSEXO) NOT NULL,
    TIPOANIMAL INTEGER REFERENCES TIPO(CODTIPO) NOT NULL,
    RACAANIMAL INTEGER REFERENCES RACA(CODRACA) DEFAULT 1,
    VACINACAOANIMAL INTEGER REFERENCES VACINACAO(CODVACINACAO) DEFAULT 1 NOT NULL,
    DESCRICAOANIMAL VARCHAR(500),
    FOTOANIMAL VARCHAR(300),
    STATUSADOCAOANIMAL BOOLEAN DEFAULT FALSE
    -- talvez foto
);

CREATE TABLE ANIMALDEFICIENCIA(
    ANIMALPORTADOR INTEGER REFERENCES ANIMAL(CODANIMAL),
    PORTADEFICIENCIA INTEGER REFERENCES DEFICIENCIA(CODDEFICIENCIA)
);

CREATE TABLE ANIMALDOENCA(
    ANIMALPORTADOR INTEGER REFERENCES ANIMAL(CODANIMAL),
    PORTADOENCA INTEGER REFERENCES DOENCA(CODDOENCA)
);

-- Pessoa (que adotará) {sexo, cpf, endereco varchar, numero de telefone, email, }
CREATE TABLE PESSOA(
    CODPESSOA SERIAL PRIMARY KEY,
    NOMEPESSOA VARCHAR(255) NOT NULL,
    SEXOPESSOA INTEGER REFERENCES SEXO(CODSEXO),
    CPF VARCHAR(11) NOT NULL UNIQUE,
    TELEFONE VARCHAR(15),
    EMAIL VARCHAR(255) NOT NULL UNIQUE,
    ENDERECO VARCHAR(255) NOT NULL
    -- talvez foto
);

-- Adocao {cod, qual pessoa adotou, qual(is) animal(is) adotou}
CREATE TABLE ADOCAO(
    CODADOCAO SERIAL PRIMARY KEY,
    ADONTANTE INTEGER REFERENCES PESSOA(CODPESSOA) NOT NULL,
    ANIMALADOTADO INTEGER REFERENCES ANIMAL(CODANIMAL) NOT NULL,
    DATAADOCAO DATE NOT NULL
    -- talvez novo nome
    -- talvez link(agem) com a foto do animal
);



-- INSERINDO OS DADOS BÁSICOS NO BANCO
INSERT INTO SEXO(NOMESEXO) VALUES ('MACHO'), ('FÊMEA'), ('MASCULINO'), ('FEMININO');

INSERT INTO TIPO(NOMETIPO) VALUES ('CACHORRO'), ('GATO');

INSERT INTO VACINACAO(ESTADOVACINACAO) VALUES ('INDETERMINADA'), ('EM DIA'), ('AGENDADA'), ('ATRASADA');

-- Inserir mais raças posteriormente
INSERT INTO RACA(NOMERACA) VALUES ('INDETERMINADA/DESCONHECIDA'), ('BOXER'), ('CHIUAUA'), ('BULLDOG'), ('XITSU'), ('PINTCHER'), ('PASTOR ALEMÃO'), ('GOLDEN RETRIEVER'), ('CARAMELO'), ('PUDDOU'), ('BLOOD HUNTER'), ('YORKSHIRE');

-- Inserir mais deficiências posteriormente
INSERT INTO DEFICIENCIA(NOMEDEFICIENCIA) VALUES ('VISUAL'), ('AUDITIVA'), ('FÍSICA'), ('CEREBRAL');

-- Inserir mais doenças posteriormente
INSERT INTO DOENCA(NOMEDOENCA) VALUES ('LEISHMANIOSE'), ('OTITE'), ('SARNA'), ('OBESIDADE'), ('RAIVA');


-- INSERE ANIMAL DE TESTE
INSERT INTO ANIMAL(NOMEANIMAL, SEXOANIMAL, TIPOANIMAL, RACAANIMAL, VACINACAOANIMAL, DESCRICAOANIMAL) VALUES ('ANIMAL-TESTE', 1, 1, 3, 2, 'DESCRIÇÃO GENÉRICA DO ANIMAL');


-- ANIMAIS DA ASSOCIAÇÃO
    -- Nome do animal - (Escrever dentro das aspas)|
    -- Sexo - 1 (macho) 2 (fêmea)
    -- Tipo - 1 (cachorro) 2 (gato)
    -- Raça - (deixa tudo 1)
    -- Vacinação - 1 (Em dia) 2 (Agendada) 3 (Atrasada)
    -- Descrição - (Escrever dentro das aspas)
INSERT INTO ANIMAL(NOMEANIMAL, SEXOANIMAL, TIPOANIMAL, RACAANIMAL, VACINACAOANIMAL, DESCRICAOANIMAL) VALUES 
('Tortinho', 1, 1, 1, 2, 'Achado no meio de uma pista com a pata quebrada depois de diversos dias, que infelizmente teve que ser amputada. O Tortinho ama abraçar, é um animal extrovertido e brincalhão.'),
('Príncipe', 1, 1, 1, 2, 'Encontrado em um rancho e alimentado por pessoas que viviam na região, Príncipe teve o prazer de ser adotado pela associação. Infelizmente tem dificuldades para se locomover, adora carinhos e é muito dócil.'),
('Túlio', 1, 1, 1, 2, 'Vagando por dias sozinho na cidade, foi resgatado e levado ao abrigo, Túlio adora brincar e receber atenção de quem passa por ele.'),
('Filhote', 1, 1, 1, 2, 'Esperando para ser adotado, filhote é muito calmo e meigo, seus irmãos foram todos adotados e ele ficou na associação, aguardando a sua adoção.'),
('Zezinho,', 1, 1, 1, 2, 'Zezinho foi abandonado e apareceu na porta da associação, onde prontamente foi acolhido e cuidado, ama brincar e receber carinho daqueles que vê.'),
('Nikita', 2, 1, 1, 2, 'Nikita foi adotada pela associação depois que sua ex-dona não tinha mais condições de cuidar, um cachorro companheiro e que gosta de brincar.'),
('Estopinho', 1, 1, 1, 2, 'Abandonado e por diversos dias sozinho na rua, chegou na associação muito debilitado e hoje está saudável e esperando por sua adoção.'),
('Alemão', 1, 1, 1, 2, 'Alemão foi abandonado em um thermas, e logo após foi resgatado por um dos membros da associação. Hoje está saudável e procurando por um dono.'),
('Thor', 1, 1, 1, 2, 'Ele foi resgatado por um dos membros da associação, em uma casa da qual não era bem cuidado, não andava mais, foi realizado o procedimento da acupuntura e ele voltou a andar. Um animal muito calmo e amoroso.'),
('Florzinha', 2, 1, 1, 2, 'Foi recolhida na praia onde foi abandonada e a associação prestou seus serviços para o cuidado e bem-estar do animal. Muito meiga e calma, espera por sua adoção!'),
('Estrela', 2, 1, 1, 2, 'Estrela foi recolhida na praia, depois de sofrer abandono por seus antigos donos. Brincalhona e extrovertida, adora carinho.'),
('Captu', 2, 1, 1, 2, 'Morava em uma lava-jato e foi adotada pela associação, recebeu os cuidados necessários e todo o carinho que precisava. Muito alegre e brincalhona.'),
('Getulio', 1, 1, 1, 2, 'Espancado pelo dono, Getulio foi resgatado pela associação e acolhido, recebendo os cuidados necessários com muita dedicação e amor.'),
('Marquinha', 2, 1, 1, 2, 'Encontrada na pista depois de um atropelamento, Marquinha também foi um dos animais resgatados pela associação.'),
('Dona', 2, 1, 1, 2, 'Abandonada na pista e encontrada por um morador dali, foi levada até a associação e logo recebeu o suporte e ajuda necessária.'),
('Menina', 2, 1, 1, 2, 'Foi encontrada em um rancho, bem delimitada e posteriormente acolhida pela associação. Muito animada e bagunceira, adora quem a visita.'),
('Mozão', 2, 1, 1, 2, 'Encontrada em um terreno baldio em um dia de chuva, muito tímida e medrosa, foi cuidada pela associação.'),
('Marrom', 1, 1, 1, 2, 'Encontrado bem debilitado em frente ao hospital, foi recebido pela associação e realizou os procedimentos necessários para sua saúde.'),
('Gigi', 2, 1, 1, 2, 'Resgatada na praia pela associação, Gigi recebeu o tratamento necessário o qual precisava.'),
('João', 1, 1, 1, 2, 'Encontrado na rua a qual estava há dias, foi acolhido pela associação e recebeu o amor e carinho que precisava.'),
('Lampião', 1, 1, 1, 2, 'Filhote de uma das cachorrinhas da associação.'),
('Mãezinha', 2, 2, 1, 2, 'Foi resgatada no lixão pela associação, cuidada e alimentada, recebendo todo o cuidado que precisava.'),
('Mi', 2, 2, 1, 2, 'resgatada pela associação, recebendo todos os cuidados necessários.'),
('Arisco', 1, 2, 1, 2, 'Acolhido pela associação, é muito medroso e tímido.'),
('Bonitão', 1, 2, 1, 2, 'resgatado pela associação, recebendo todos os cuidados necessários.'),
('Bonitinho', 1, 2, 1, 2, 'resgatado pela associação, recebendo todos os cuidados necessários.'),
('Shakira', 2, 2, 1, 2, 'Morava em um hospital e como não era permitido animais, foi recolhida pela associação, recebendo atenção e cuidado. Muito meiga e carinhosa.'),
('Primeiro', 1, 1, 1, 2, 'Foi encontrado no canal amarrado durante 3 dias, foi resgatado pela associação e recebeu os cuidados necessários.'),
('Bela', 2, 1, 1, 2, 'Foi atropelada e deixada no local, depois foi entregue para a associação com uma pata quebrada, recebeu o acolhimento necessário.'),
('Duque', 1, 1, 1, 2, 'Um cachorro do canil, Duque foi adotado, sofria maus tratos e foi recolhido e cuidado pela associação.'),
('Cristal', 2, 1, 1, 2, 'Encontrada na praia, acabou por dar cria e foi resgatada pela associação, junto a seus filhotes.'),
('Lua', 2, 1, 1, 2, 'Encontrada na praia, acabou por dar cria e foi resgatada pela associação, junto a seus filhotes.'),
('Princesa', 2, 1, 1, 2, 'Morava no canil, foi para adoção e após não ter sido adotada veio para a associação e recebeu todo amor e carinho que necessitava.'),
('Celine', 2, 1, 1, 2, 'Resgatada na rodovia pela associação e cuidada pela mesma.'),
('Tete', 2, 1, 1, 2, 'Foi resgatada grávida de seus filhotes e fizeram seu parto por cesárea, onde logo após nasceram seus filhotes.'),
('Oreo', 1, 1, 1, 2, 'Foi resgatado no meio da mata pela associação e recebeu os cuidados necessários.'),
('Zelda', 2, 1, 1, 2, 'Foi resgatada no meio da mata pela associação e recebeu os cuidados necessários.'),
('Negão', 1, 1, 1, 2, 'Morava na rua, encontrado machucado e debilitado, foi resgatado pela associação e recebeu os cuidados necessários.'),
('Lindinha', 2, 1, 1, 2, 'Morava na rua, foi encontrada machucada e debilitada, foi resgatada pela associação e recebeu os cuidados necessários.'),
('Florzinha', 2, 1, 1, 2, 'Morava na rua, foi encontrada machucada e debilitada, foi resgatada pela associação e recebeu os cuidados necessários.'),
('Filhote 2', 2, 1, 1, 2, 'Nasceu de uma cachorra que chegou grávida na associação, é brincalhona e gosta de companhia'),
('Filhote 3', 1, 1, 1, 2, 'Nasceu na associação, após a mãe ser resgatada.'),
('Filhote 4', 1, 1, 1, 2, 'Nasceu na associação, após a mãe ser resgatada.'),
('Filhote 5', 1, 1, 1, 2, 'Filhote da Captu, nascido na associação.');


-- SELECIONA OS ANIMAIS MOSTRANDO OS NOMES DOS CAMPOS
SELECT A.CODANIMAL, A.NOMEANIMAL, S.NOMESEXO, T.NOMETIPO, R.NOMERACA, V.ESTADOVACINACAO, A.DESCRICAOANIMAL
FROM ANIMAL A, SEXO S, TIPO T, RACA R, VACINACAO V
WHERE A.SEXOANIMAL = S.CODSEXO AND A.TIPOANIMAL = T.CODTIPO AND A.RACAANIMAL = R.CODRACA AND A.VACINACAOANIMAL = V.CODVACINACAO;


-- ATRIBUINDO UMA DEFICIENCIA A UM ANIMAL
INSERT INTO ANIMALDEFICIENCIA VALUES (1, 2);

-- ATRIBUINDO UMA DOENC A UM ANIMAL
INSERT INTO ANIMALDOENCA VALUES (1, 3);

-- SELECIONA AS DEFICIENCIAS
SELECT * FROM DEFICIENCIA;

-- SELECIONA AS DEFICIENCIAS QUE O ANIMAL POSSUI
SELECT * FROM DEFICIENCIA, ANIMALDEFICIENCIA WHERE ANIMALPORTADOR = 1 AND CODDEFICIENCIA = PORTADEFICIENCIA;

select array_agg(nomedeficiencia) from  (select * from animal as an 
inner join ANIMALDEFICIENCIA as ad on an.codanimal = ad.ANIMALPORTADOR 
inner join  DEFICIENCIA as d on ad.PORTADEFICIENCIA = d.CODDEFICIENCIA) as tabela where codanimal = 1;



SELECT * FROM ANIMALDEFICIENCIA WHERE ANIMALPORTADOR = 54;

-- A FAZER ******************************************

-- FUNCAO PARA CADASTRAR ANIMAIS
-- CREATE FUNCTION CADASTRARANIMAIS (NOMEDOANIMAL VARCHAR(80), SEXODOANIMAL INTEGER, RACADOANIMAL INTEGER, DEFICIENCIADOANIMAL INTEGER, VACINACAODOANIMAL INTEGER, DESCRICAODOANIMAL VARCHAR(500)) RETURNS VOID AS
-- $$
--     INSERT INTO ANIMAL (NOMEANIMAL, SEXOANIMAL, RACAANIMAL, DEFICIENCIAANIMAL, VACINACAOANIMAL, DESCRICAO) VALUES (NOMEDOANIMAL, SEXODOANIMAL, RACADOANIMAL, DEFICIENCIADOANIMAL, VACINACAODOANIMAL, DESCRICAODOANIMAL);
-- $$ LANGUAGE SQL;



-- EXECUTAR FUNCAO DE CADASTRO DE ANIMAIS
--SELECT CADASTRARANIMAIS ('THOR', 1, 2, 2, 'ATIÇADO E ENCRENQUEIRO');


-- ADICIONAR FORMA DE SABER SE O ANIMAL JA FOI OU NAO ADOTADO (provavelmente trigger)