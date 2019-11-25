drop table local_publico cascade;
drop table item cascade;
drop table anomalia cascade;
drop table anomalia_traducao cascade;
drop table duplicado cascade;
drop table utilizador cascade;
drop table utilizador_qualificado cascade;
drop table utilizador_regular cascade;
drop table incidencia cascade;
drop table proposta_de_correcao cascade;
drop table correcao cascade;


create table local_publico(
    latitude numeric(8,6) not null unique,
    longitude numeric(9,6) not null unique,
    nome varchar(128) not null,
    constraint pk_localpublico primary key (latitude, longitude)
);

create table item(
	id serial not null,
	descricao varchar(255),
	localizacao varchar(255) not null,
	latitude numeric (8,6) not null,
	longitude numeric (9,6) not null,
	constraint pk_item primary key (id),
    constraint fk_latitude_item foreign key (latitude) references local_publico (latitude),
    constraint fk_longitude_item foreign key (longitude) references local_publico (longitude)
);

create table anomalia(
    id serial not null,
    imagem bytea not null,
    lingua varchar (20) not null,
    ts timestamp not null,
    descricao varchar (255),
    tem_anomalia_redacao boolean not null,
    zona numeric[2] not null,
    constraint pk_anomalia primary key (id)
);

create table anomalia_traducao(
    id serial not null,
    zona2 numeric[2] not null,
    lingua2 varchar(20) not null,
    constraint pk_anomaliatraducao primary key (id),
    constraint fk_id_anomaliatraducao foreign key (id) references anomalia(id)
);

create table duplicado(
    item1 integer not null,
    item2 integer not null,
    constraint pk_duplicado primary key (item1, item2),
    constraint fk_item1_duplicado foreign key (item1) references item (id),
    constraint fk_item2_duplicado foreign key (item2) references item (id),
    constraint duplicado_check check (item1 <> item2)
);

create table utilizador(
    email varchar (30) not null unique,
    pass varchar (30) not null,
    constraint pk_utilizador primary key (email)
);

create table utilizador_qualificado(
    email varchar (30) not null unique,
    constraint pk_utilizadorqualificado primary key (email),
    constraint fk_email_utilizadorqualificado foreign key (email) references utilizador (email)
);

create table utilizador_regular(
    email varchar (30) not null unique,
    constraint pk_utilizadorregular primary key (email),
    constraint fk_email_utilizadorregular foreign key (email) references utilizador (email)
);

create table incidencia(
    anomalia_id integer not null,
    item_id integer not null,
    email varchar (30) not null unique,
    constraint pk_incidencia primary key (anomalia_id),
    constraint fk_anomalia_id_incidencia foreign key (anomalia_id) references anomalia (id),
    constraint fk_itemid_incidencia foreign key (item_id) references item (id),
    constraint fk_email_incidencia foreign key (email) references utilizador (email)
);

create table proposta_de_correcao(
    email varchar (30) not null unique,
    nro integer not null unique,
    data_hora timestamp not null,
    texto text not null,
    constraint pk_proposta_de_correcao primary key (email,nro),
    constraint fk_email_proposta_de_correcao foreign key (email) references utilizador_qualificado (email)
);

create table correcao(
    email varchar (30) not null unique,
    nro integer not null unique,
    anomalia_id integer not null,
    constraint pk_correcao primary key (email,nro,anomalia_id),
    constraint fk_email_correcao foreign key (email) references proposta_de_correcao (email),
    constraint fk_nro_correcao foreign key (nro) references proposta_de_correcao (nro),
    constraint fk_anomaliaid_correcao foreign key (anomalia_id) references incidencia (anomalia_id)
);