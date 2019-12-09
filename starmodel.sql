drop table if exists d_utilizador cascade;
drop table if exists d_tempo cascade;
drop table if exists d_local cascade;
drop table if exists d_lingua cascade;
drop table if exists f_anomalia cascade;

create table d_utilizador(
    id_utilizador serial not null,
    email varchar(30) not null,
    tipo varchar(12) not null,
    primary key(id_utilizador)
);

create table d_tempo(
    id_tempo serial not null,
    dia integer not null,
    dia_da_semana varchar(9) not null,
    semana integer not null,
    mes integer not null,
    trimestre integer not null,
    ano integer not null,
    primary key (id_tempo)
);

create table d_local(
    id_local serial not null,
    latitude numeric(8,6) not null,
    longitude numeric(9,6) not null,
    nome varchar(128) not null,
    primary key(id_local)
);

create table d_lingua(
    id_lingua serial not null,
    lingua varchar(20) not null,
    primary key(id_lingua)
);

create table f_anomalia(
    id_utilizador integer not null,
    id_tempo integer not null,
    id_local integer not null,
    id_lingua integer not null,
    tipo_anomalia smallint not null,
    com_proposta boolean not null,
    primary key(id_utilizador,id_tempo,id_local,id_lingua),
    foreign key(id_utilizador) references d_utilizador(id_utilizador) ON DELETE CASCADE ON UPDATE CASCADE,
    foreign key(id_tempo) references d_tempo(id_tempo) ON DELETE CASCADE ON UPDATE CASCADE,
    foreign key(id_local) references d_local(id_local) ON DELETE CASCADE ON UPDATE CASCADE,
    foreign key(id_lingua) references d_lingua(id_lingua) ON DELETE CASCADE ON UPDATE CASCADE
);

insert into d_tempo(dia,dia_da_semana,semana,mes,trimestre,ano)
    select extract(day from ts) as dia,
    to_char(ts,'Day') as dia_da_semana,
    extract(week from ts) as semana,
    extract(month from ts) as mes,
    extract(quarter from ts) as trimestre,
    extract(year from ts) as ano
    from anomalia order by ano, mes, dia;

insert into d_utilizador(email,tipo)
    select email, 'regular' from utilizador natural join utilizador_regular;

insert into d_utilizador(email,tipo)
    select email, 'qualificado' from utilizador natural join utilizador_qualificado;

insert into d_lingua(lingua)
    select lingua from anomalia;

insert into d_local(latitude, longitude, nome)
    select latitude, longitude, nome as localizacao from item natural join local_publico;