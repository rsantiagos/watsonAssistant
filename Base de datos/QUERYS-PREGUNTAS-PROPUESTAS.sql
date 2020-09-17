#QUERY PARA LAS PREGUNTAS PROPUESTAS

/*1.	Muestra el Top 5 de la fuerza de venta actual que en diciembre de 2017
 ha traído a Telcel más portaciones con modo de suscripción prepago.*/
 
SELECT  tfv_id, tfv_nombre, ven_fecha, ven_monto, pln_nombre
FROM cat_venta
        JOIN cat_FuerzaVenta USING (fve_id)
        JOIN cat_TipoFuerzaVenta USING (tfv_id)
        JOIN cat_cuenta USING (cta_id)
        JOIN cat_numero USING (num_id)
        JOIN cat_plan USING (pln_id)
WHERE
    ven_fecha BETWEEN '2017-12-01' AND '2017-12-31'
        AND pln_nombre = 'TELCEL PREPAGO'
ORDER BY ven_monto DESC
LIMIT 0 , 5;


/*2.Muestra por región, el total de líneas que llegaron a Telcel en diciembre de 2017
 con modo de suscripción prepago y que realizaron su primera recarga los primeros quince días de enero 2018. */
 SELECT reg_id, reg_nombre, count(num_id) totalLineas, fac_fecha,
vin_observacion Movimiento, vin_fecha fechaMovimiento
FROM cat_venta
JOIN cat_cuenta USING(cta_id)
JOIN cat_plan USING(pln_id)
JOIN vin_movimientoCuenta USING(cta_id)
JOIN cat_movimiento USING(mov_id)
JOIN cat_factura USING(ven_id)
JOIN cat_estado USING(est_id)
JOIN cat_region USING(reg_id) 
JOIN cat_coordenada USING(est_id)
WHERE fac_fecha BETWEEN '2017-12-01' AND '2017-12-31'
AND vin_fecha BETWEEN '2018-01-01' AND '2018-01-15'
AND pln_id=3 # telcel pregado
AND mov_id=1 AND vin_observacion='PRIMERA RECARGA'
GROUP BY reg_id ORDER BY reg_id;

/*3.	Muestra el total de líneas por región que llegaron a Telcel en diciembre de 2017 con modo de suscripción 
prepago que tengan rol de LIDER ordenados de manera ascendente.*/
SELECT reg_id, reg_nombre, count(num_id) totalLineas, fac_fecha
FROM cat_venta
JOIN cat_cuenta USING(cta_id)
JOIN cat_plan USING(pln_id) # plan prepago
JOIN cat_factura USING(ven_id)
JOIN cat_estado USING(est_id)
JOIN cat_region USING(reg_id) 
JOIN cat_coordenada USING(est_id)
JOIN cat_empleado USING(emp_id)
WHERE fac_fecha BETWEEN '2017-12-01' AND '2017-12-31'
AND pln_id=3 # telcel pregado
AND rol_id=3 # rol empleado LIDER
GROUP BY reg_id ORDER BY count(num_id) ASC ;



/* 4.	Muestra las líneas que se portaron en la región tres en diciembre de 2017 a Telcel con el modo de suscripción prepago, 
cuya fuerza de venta actual sea diferente al canal de venta de activación */
SELECT num_numero, reg_nombre, num_fechaActivacion, pln_nombre, v.fve_id venta, va.fve_id activacion
FROM cat_factura 
JOIN cat_venta v USING (ven_id)
JOIN cat_localidad USING (loc_id, mun_id,est_id)
JOIN cat_estado USING (est_id)
JOIN cat_region USING (reg_id)
JOIN cat_cuenta USING (cta_id)
JOIN cat_numero USING (num_id)
JOIN cat_plan USING (pln_id)
JOIN cat_FuerzaVenta USING (fve_id)
JOIN cat_activacionVenta va USING (cta_id)
WHERE ven_fecha BETWEEN '2017-12-01' AND '2017-12-31'
AND reg_nombre = 'R3' AND pln_nombre='TELCEL PREPAGO'
AND v.fve_id <> va.fve_id ;




/* 5.	Cuál es la región de portabilidad prepago con el modo de suscripción prepago que en diciembre de 2017
	más megabytes descargó y cuántos megabytes fueron.
a)	Cuál es la región con el modo de suscripción prepago que mas megabytes descargo y cuantos megabytes fueron.
 */
SELECT reg_id, reg_nombre, SUM(vin_duracion)TotalMG
FROM cat_venta
JOIN cat_cuenta USING(cta_id)
JOIN cat_plan USING(pln_id) # plan prepago
JOIN cat_factura USING(ven_id)
JOIN cat_estado USING(est_id)
JOIN cat_region USING(reg_id)
JOIN vin_movimientoCuenta USING(cta_id) 
WHERE DATE(vin_fecha) BETWEEN '2017-12-01' AND '2017-12-31'
AND pln_id=3 # telcel pregado
AND mov_id = 6 # navegacion internet
group by reg_id 
order by SUM(vin_duracion) DESC 
LIMIT 1;