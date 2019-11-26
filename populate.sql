insert into local_publico(latitude,longitude,nome) values (38.697931, -9.206683, 'Mosteiro dos Jeronimos');
insert into local_publico(latitude,longitude,nome) values (38.691617, -9.215977, 'Torre de Belem');
insert into local_publico(latitude,longitude,nome) values (38.937000, -9.325951, 'Convento de Mafra');
insert into local_publico(latitude,longitude,nome) values (41.145837, -8.614620, 'Torre dos Clerigos');
insert into local_publico(latitude,longitude,nome) values (38.572632, -7.907273, 'Templo de Diana');
insert into local_publico(latitude,longitude,nome) values (39.816082, -7.513033, 'Piscina Praia');
insert into local_publico(latitude,longitude,nome) values (41.140085, -8.609449, 'Ponte Dom Luis');
insert into local_publico(latitude,longitude,nome) values (38.693596, -9.205712, 'Padrao dos Descobrimentos');
insert into local_publico(latitude,longitude,nome) values (38.725280, -9.150049, 'Praca do Marques');
insert into local_publico(latitude,longitude,nome) values (40.101576, -7.313568, 'Mata da Rainha');
insert into local_publico(latitude,longitude,nome) values (39.936529, -7.601457, 'Barbaido');
insert into local_publico(latitude,longitude,nome) values (41.448172, -8.290265, 'Castelo de Guimaraes');
insert into local_publico(latitude,longitude,nome) values (40.054725, -8.671053, 'Santo Isidro');
insert into local_publico(latitude,longitude,nome) values (37.017578, -7.969428, 'Aeroporto de Faro');
insert into local_publico(latitude,longitude,nome) values (37.073545, -8.115933, 'Casino Vilamoura');
insert into local_publico(latitude,longitude,nome) values (36.997975, -8.948814, 'Fortaleza de Sagres');

insert into item(descricao,localizacao,latitude,longitude) values ('Nao se diz porta minas', 'Santo Isidro',40.054725, -8.671053);
insert into item(descricao,localizacao,latitude,longitude) values ('Nao se diz porta minas', 'Santo Isidro',40.054725, -8.671053);
insert into item(descricao,localizacao,latitude,longitude) values ('A palavra nao tem acento', 'Templo de Diana', 38.572632, -7.907273);
insert into item(descricao,localizacao,latitude,longitude) values ('Esta tudo mal escrito', 'Ponte Dom Luis', 41.140085, -8.609449);
insert into item(descricao,localizacao,latitude,longitude) values ('Portugal nao tem dois O', 'Castelo de Guimaraes', 41.448172, -8.290265);
insert into item(descricao,localizacao,latitude,longitude) values ('Steal esta mal escrito', 'Casino Vilamoura', 37.073545, -8.115933);
insert into item(descricao,localizacao,latitude,longitude) values ('Steal esta mal escrito', 'Casino Vilamoura', 37.073545, -8.115933);
insert into item(descricao,localizacao,latitude,longitude) values ('Montanha nao tem til no n', 'Mata da Rainha', 40.101576, -7.313568);
insert into item(descricao,localizacao,latitude,longitude) values ('Montanha nao tem til no n', 'Mata da Rainha', 40.101576, -7.313568);

insert into anomalia(zona,imagem,lingua,ts,descricao,tem_anomalia_redacao) values ('((1,5),(5,10))','\xABC12345','Portugues','2019-04-03 10:05:19','Esta tudo mal escrito',TRUE);
insert into anomalia(zona,imagem,lingua,ts,descricao,tem_anomalia_redacao) values ('((3,20),(20,24))','\xABC12345','Portugues','2019-06-03 15:05:43','A palavra nao tem acento',TRUE);
insert into anomalia(zona,imagem,lingua,ts,descricao,tem_anomalia_redacao) values ('((1,2),(3,4))','\xABC12345','Portugues','2019-07-05 10:00:00','Nao se diz porta minas',TRUE);
insert into anomalia(zona,imagem,lingua,ts,descricao,tem_anomalia_redacao) values ('((1,2),(3,4))','\xABC12345','Portugues','2019-11-26 16:48:25','Nao se diz porta minas',TRUE);
insert into anomalia(zona,imagem,lingua,ts,descricao,tem_anomalia_redacao) values ('((1,10),(10,20))','\xABC12345','Ingles','2018-11-03 23:38:11','Portugal nao tem dois O',TRUE);
insert into anomalia(zona,imagem,lingua,ts,descricao,tem_anomalia_redacao) values ('((1,1),(5,5))','\xABC12345','Portugues','2019-02-02 11:30:20','Steal esta mal escrito',FALSE);
insert into anomalia(zona,imagem,lingua,ts,descricao,tem_anomalia_redacao) values ('((1,1),(2,2))','\xABC12345','Espanhol','2019-05-30 17:30:20','Montanha nao tem til no n',FALSE);
insert into anomalia(zona,imagem,lingua,ts,descricao,tem_anomalia_redacao) values ('((1,1),(5,5))','\xABC12345','Portugues','2019-08-07 12:00:00','Steal esta mal escrito',FALSE);
insert into anomalia(zona,imagem,lingua,ts,descricao,tem_anomalia_redacao) values ('((1,1),(2,2))','\xABC12345','Espanhol','2019-09-22 19:45:00','Montanha nao tem til no n',FALSE);

insert into anomalia_traducao(id,zona2,lingua2) values (6,'((6,6),(10,10))','Ingles');
insert into anomalia_traducao(id,zona2,lingua2) values (7,'((6,6),(10,10))','Ingles');
insert into anomalia_traducao(id,zona2,lingua2) values (8,'((3,3),(4,4))','Portugues');
insert into anomalia_traducao(id,zona2,lingua2) values (9,'((3,3),(4,4))','Portugues');

insert into duplicado values (1,2);
insert into duplicado values (6,7);
insert into duplicado values (8,9);

insert into utilizador(email,pass) values ('jose@gmail.com', 'jose12345');
insert into utilizador(email,pass) values ('manel@gmail.com', 'manel12345');
insert into utilizador(email,pass) values ('miguel@gmail.com', 'miguel12345');
insert into utilizador(email,pass) values ('joaquim@gmail.com', 'joaquim12345');
insert into utilizador(email,pass) values ('alexandra@gmail.com', 'alexandra12345');
insert into utilizador(email,pass) values ('palush@gmail.com', 'palush12345');
insert into utilizador(email,pass) values ('dani@gmail.com', 'dani12345');
insert into utilizador(email,pass) values ('user@hotmail.com', 'naotenhocriatividade');
insert into utilizador(email,pass) values ('user2@webmail.com', 'continuosemcriatividade');
insert into utilizador(email,pass) values ('user3@gmail.com', 'todaagenteusagmail');

insert into utilizador_qualificado(email) values ('jose@gmail.com');
insert into utilizador_qualificado(email) values ('manel@gmail.com');
insert into utilizador_qualificado(email) values ('miguel@gmail.com');
insert into utilizador_qualificado(email) values ('alexandra@gmail.com');

insert into utilizador_regular(email) values ('joaquim@gmail.com');
insert into utilizador_regular(email) values ('dani@gmail.com');
insert into utilizador_regular(email) values ('palush@gmail.com');
insert into utilizador_regular(email) values ('user@hotmail.com');
insert into utilizador_regular(email) values ('user2@webmail.com');
insert into utilizador_regular(email) values ('user3@gmail.com');

insert into incidencia(anomalia_id,item_id,email) values (1,4,'manel@gmail.com');
insert into incidencia(anomalia_id,item_id,email) values (2,3,'miguel@gmail.com');
insert into incidencia(anomalia_id,item_id,email) values (3,2,'alexandra@gmail.com');
insert into incidencia(anomalia_id,item_id,email) values (4,1,'palush@gmail.com');
insert into incidencia(anomalia_id,item_id,email) values (5,5,'user@hotmail.com');
insert into incidencia(anomalia_id,item_id,email) values (6,7,'user3@gmail.com');
insert into incidencia(anomalia_id,item_id,email) values (7,7,'miguel@gmail.com');
insert into incidencia(anomalia_id,item_id,email) values (8,6,'joaquim@gmail.com');
insert into incidencia(anomalia_id,item_id,email) values (9,9,'dani@gmail.com');

insert into proposta_de_correcao(email,nro,data_hora,texto) values ('jose@gmail.com',1,'2019-08-08 10:00:00','Escrever steel em vez de steal');
insert into proposta_de_correcao(email,nro,data_hora,texto) values ('manel@gmail.com',1,'2019-10-02 07:15:00','Escrever montanha');
insert into proposta_de_correcao(email,nro,data_hora,texto) values ('alexandra@gmail.com',1,'2019-06-08 13:00:00','Colocar acento no O');
insert into proposta_de_correcao(email,nro,data_hora,texto) values ('miguel@gmail.com',1,'2019-11-11 19:45:33','Escrever steel em vez de steal');
insert into proposta_de_correcao(email,nro,data_hora,texto) values ('jose@gmail.com',2,'2019-12-25 01:01:01','Mais correto usar o termo lapiseira');
insert into proposta_de_correcao(email,nro,data_hora,texto) values ('miguel@gmail.com',2,'2019-11-04 12:00:00','Escrever Portugal');

insert into correcao(email,nro,anomalia_id) values ('jose@gmail.com',1,6);
insert into correcao(email,nro,anomalia_id) values ('manel@gmail.com',1,7);
insert into correcao(email,nro,anomalia_id) values ('alexandra@gmail.com',1,2);
insert into correcao(email,nro,anomalia_id) values ('miguel@gmail.com',1,6);
insert into correcao(email,nro,anomalia_id) values ('jose@gmail.com',2,3);
insert into correcao(email,nro,anomalia_id) values ('miguel@gmail.com',2,5);



