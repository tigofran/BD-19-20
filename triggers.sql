--RI_1

drop trigger if exists zona_trigger on anomalia_traducao;
create or replace function zona_trigger() returns trigger as $$
begin
    if (select id from anomalia natural join anomalia_traducao where (zona && zona2) is true) is not null
    then
        raise exception 'RI-1: A zona da anomalia_tradução nao se pode sobrepor a zona da anomalia correspondente';
    end if;
return new;
end;
$$
language plpgsql;

create trigger zona_trigger after insert or update on anomalia_traducao
for each row execute procedure zona_trigger();

--RI-4
drop trigger if exists utilizador_trigger on utilizador;
create or replace function utilizador_trigger() returns trigger as $$
begin
    if (select email from utilizador except (select email from utilizador_regular union select email from utilizador_qualificado)) is not null
    then
        raise exception 'RI-4: O email tem de estar em utilizador_qualificado ou utilizador_regular';
    end if;
return new;
end;
$$
language plpgsql;

create constraint trigger utilizador_trigger after insert or update on utilizador deferrable initially deferred
for each row execute procedure utilizador_trigger();

--RI_5

drop trigger if exists utilizador_regular_trigger on utilizador_regular;
create or replace function utilizador_regular_trigger() returns trigger as $$
begin
    if (select email from utilizador_regular natural join utilizador_qualificado) is not null
    then
        raise exception 'RI-5: O utilizador so pode ser regular ou qualificado, nao ambos';
    end if;
return new;
end;
$$
language plpgsql;

create trigger utilizador_regular_trigger after insert or update on utilizador_regular
for each row execute procedure utilizador_regular_trigger();

--RI-6
drop trigger if exists utilizador_qualificado_trigger on utilizador_qualificado;
create or replace function utilizador_qualificado_trigger() returns trigger as $$
begin
    if (select email from utilizador_regular natural join utilizador_qualificado) is not null
    then
        raise exception 'RI-6: O utilizador so pode ser regular ou qualificado, nao ambos';
    end if;
return new;
end;
$$
language plpgsql;

create trigger utilizador_qualificado_trigger after insert or update on utilizador_qualificado
for each row execute procedure utilizador_qualificado_trigger();
