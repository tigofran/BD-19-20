select tipo_anomalia, lingua, dia_da_anomalia, count(*) 
from d_tempo natural join f_anomalia
group by tipo_anomalia, lingua, dia_da_anomalia

union

select tipo_anomalia, lingua, null, count(*) 
from d_tempo natural join f_anomalia
group by tipo_anomalia, lingua

union

select tipo_anomalia, null, null, count(*) 
from d_tempo natural join f_anomalia
group by tipo_anomalia

union

select null, null, null, count(*) 
from d_tempo natural join f_anomalia;