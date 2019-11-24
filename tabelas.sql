create table local_publico(
    latitude numeric not null,
    longitude numeric not null,
    nome varchar not null,
    constraint pk_localpublico primary key (latitude, longitude)
);

create table item(
	id serial not null,
	descricao varchar,
	localizacao varchar not null,
	latitude numeric not null,
	longitude numeric not null,
	constraint pk_item primary key (id),
    constraint fk_latitude foreign key (latitude) references local_publico (latitude),
    constraint fk_longitude foreign key (longitude) references local_publico (longitude)
);

create table anomalia(
    id serial not null,
    imagem bytea not null,
    lingua varchar not null,
    ts timestamp not null,
    descricao varchar,
    tem_anomalia_redacao boolean not null,
    zona numeric[2] not null,
    constraint pk_anomalia primary key (id)
);

create table anomalia_traducao(
    id serial not null,
    zona2 numeric[2] not null,
    lingua2 varchar not null,
    constraint pk_anomaliatraducao primary key (id),
    constraint fk_id foreign key (id) references anomalia(id)
);

create table duplicado(
    item1 integer not null,
    item2 integer not null,
    constraint pk_duplicado primary key (item1, item2),
    constraint fk_item1 foreign key (item1) references item (id1),
    constraint fk_item2 foreign key (item2) references item (id2),
    constraint duplicado_check check (item1 <> item2)
);

create table utilizador(
    email varchar not null,
    pass varchar not null,
    constraint pk_utilizador primary key (email)
);

create table utilizador_qualificado(
    email varchar not null,
    constraint pk_utilizador primary key (email)
    constraint fk_email foreign key (id) references utlizador (email)
);

create table utilizador_regular(
    email varchar not null,
    constraint pk_utilizadorregular primary key (email)
    constraint fk_email foreign key (id) references utlizador (email)
);

create table incidencia(
    anomalia_id integer not null,
    item_id integer not null,
    email varchar not null,
    constraint pk_incidencia primary key (anomalia_id),
    constraint fk_anomalia_id foreign key (anomalia_id) references anomalia (id),
    constraint fk_item_id foreign key (item_id) references item (id),
    constraint fk_email foreign key (email) references utilizador (email),
);

create table proposta_de_correcao(
    email varchar not null,
    nro integer not null,
    data_hora timestamp not null,
    texto text not null,
    constraint pk_proposta_de_correcao primary key (email,nro),
    constraint fk_email foreign key (email) references utilizador_qualificado (email)
);

create table correcao(
    email varchar not null,
    nro integer not null,
    anomalia_id integer not null,
    constraint pk_correcao primary key (email,nro,anomalia_id),
    constraint fk_email foreign key (email) references proposta_de_correcao (email),
    constraint fk_nro foreign key (nro) references proposta_de_correcao (nro),
    constraint fk_anomalia_id foreign key (anomalia_id) references incidencia (anomalia_id)
);
