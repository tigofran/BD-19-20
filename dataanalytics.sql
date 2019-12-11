select tipo_anomalia, lingua, dia_da_semana, count(*) 
from d_tempo natural join d_lingua natural join f_anomalia 
group by tipo_anomalia, lingua, dia_da_semana

union

select tipo_anomalia, lingua, null, count(*) 
from d_tempo natural join d_lingua natural join f_anomalia 
group by tipo_anomalia, lingua

union

select tipo_anomalia, null, null, count(*) 
from d_tempo natural join d_lingua natural join f_anomalia 
group by tipo_anomalia

union

select null, null, null, count(*) 
from d_tempo natural join d_lingua natural join f_anomalia

order by tipo_anomalia, lingua, dia_da_semana;