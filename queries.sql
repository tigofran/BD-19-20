/*QUERY 1*/

SELECT localizacao
FROM item
WHERE id = (SELECT item_id
FROM incidencia 
GROUP BY item_id
HAVING COUNT(anomalia_id) = (SELECT MAX(mycount)
FROM (
	SELECT item_id ,COUNT(item_id) AS mycount
FROM incidencia
GROUP BY item_id) AS foo));


/*QUERY 2*/

SELECT email
FROM (utilizador_regular NATURAL JOIN incidencia) 
INNER JOIN (anomalia_traducao NATURAL JOIN anomalia)
ON incidencia.anomalia_id = anomalia_traducao.id
WHERE ts >= '2019-01-01 00:00:00' AND ts < '2019-07-01 00:00:00'
GROUP BY email
HAVING COUNT(email) >= ALL(
	SELECT COUNT(email)
	FROM (utilizador_regular NATURAL JOIN incidencia) 
	INNER JOIN (anomalia_traducao NATURAL JOIN anomalia)
	ON incidencia.anomalia_id = anomalia_traducao.id
	WHERE ts >= '2019-01-01 00:00:00' AND ts < '2019-07-01 00:00:00'
	GROUP BY email);


/*SELECT email, COUNT(email)
FROM utilizador_regular NATURAL JOIN incidencia
WHERE anomalia_id IN (
	SELECT id
	FROM anomalia_traducao NATURAL JOIN anomalia
	WHERE ts >= '2019-01-01 00:00:00' AND ts < '2019-07-01 00:00:00')
GROUP BY email;*/




#mudar ts 2019-06-01 para 2019-01-01

/*QUERY 3*/


SELECT email
FROM (
	SELECT  email,latitude,longitude
	FROM incidencia INNER JOIN item
	ON incidencia.item_id = item.id
	INNER JOIN anomalia
	ON incidencia.anomalia_id = anomalia.id
	WHERE ts >= '2019-01-01 00:00:00' AND ts < '2020-01-01 00:00:00' 
		AND latitude > 39.336775) AS foo
GROUP BY email
HAVING COUNT(DISTINCT foo.latitude) = (SELECT COUNT(latitude) FROM local_publico WHERE latitude > 39.336775);




/*QUERY 4*/

SELECT DISTINCT email
FROM utilizador_qualificado NATURAL JOIN (SELECT  anomalia_id, email
	FROM incidencia INNER JOIN item
	ON incidencia.item_id = item.id
	INNER JOIN anomalia
	ON incidencia.anomalia_id = anomalia.id
	WHERE ts >= '2019-01-01 00:00:00' AND ts < '2020-01-01 00:00:00' 
		AND latitude < 39.336775
	) AS foo
WHERE anomalia_id||email NOT IN (SELECT anomalia_id||email FROM correcao);

/*SELECT  anomalia_id, email
FROM incidencia INNER JOIN item
ON incidencia.item_id = item.id
INNER JOIN anomalia
ON incidencia.anomalia_id = anomalia.id
WHERE ts >= '2019-01-01 00:00:00' AND ts < '2020-01-01 00:00:00' 
	AND latitude < 39.336775;*/
