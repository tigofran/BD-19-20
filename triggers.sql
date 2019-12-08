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

--RI-6
create trigger utilizador_regular_trigger after insert or update on utilizador_regular
for each row execute procedure utilizador_regular_trigger();

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

--RI-4
create trigger utilizador_trigger after insert or update on utilizador
for each row execute procedure utilizador_trigger();

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

create trigger utilizador_trigger after insert or update on utilizador
for each row execute procedure utilizador_trigger();