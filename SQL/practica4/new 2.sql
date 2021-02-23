REM ******** CONSULTAS *******************

Prompt ****** 1.	Listado con el nombre y apellido de los empleados que trabajan en el departamento Finance. Ordenados por apellido.....

SELECT e.first_name, e.last_name
FROM pr3_employees e INNER JOIN pr3_departments d
     USING (department_id)
WHERE d.department_name = 'Finance'
ORDER BY e.first_name;

/*
FIRST_NAME           LAST_NAME               
-------------------- -------------------------
Daniel               Faviet                    
Ismael               Sciarra                   
John                 Chen                      
Jose Manuel          Urman                     
Luis                 Popp                      
Nancy                Greenberg   
6 filas seleccionadas  
*/

Prompt ****** 2.	Nombre y apellido de los empleados que tienen personal a su cargo, es decir, que son jefes de alg�n empleado. Sin repetici�n.....

SELECT distinct em.first_name, em.last_name  
FROM pr3_employees ee INNER JOIN pr3_employees em
     ON ee.manager_id = em.employee_id;

/*
FIRST_NAME           LAST_NAME               
-------------------- -------------------------
Eleni                Zlotkey                   
Lex                  De Haan                   
Karen                Partners                  
Shanta               Vollman                   
Gerald               Cambrault                 
Steven               King                      
Neena                Kochhar                   
Nancy                Greenberg                 
Den                  Raphaely                  
Adam                 Fripp                     
Kevin                Mourgos                   
Shelley              Higgins                   
Alexander            Hunold                    
Payam                Kaufling                  
Matthew              Weiss                     
Alberto              Errazuriz                 
Michael              Hartstein                 
John                 Russell                   

 18 filas seleccionadas  
*/ 
Prompt ****** 3.	Listado de los apellidos de los empleados que ganan m�s que su jefe, incluyendo tambi�n el apellido de su jefe y los salarios de ambos.....

SELECT ee.last_name EMPLEADO, ee.salary SALEMP, 
       em.last_name JEFE, em.salary SALJEFE 
FROM pr3_employees ee INNER JOIN pr3_employees em
     ON ee.manager_id = em.employee_id
WHERE ee.salary >= em.salary;

/*
EMPLEADO		SALEMP 	JEFE		SALJEFE
------------  ----------- ---------- ------------------------- 
Ozer           11500 		Cambrault    11000 
Abel           11000 		Zlotkey      10500
*/

Prompt ****** 4.	Listado con el nombre y apellido de los empleados que han trabajado en el departamento Sales.....

SELECT distinct e.first_name,  e.last_name 
FROM (pr3_employees e INNER JOIN pr3_job_history  h
      USING (employee_id)) 
      INNER JOIN pr3_departments  d
      ON h.department_id = d.department_id
WHERE d.department_name = 'Sales';

/*
FIRST_NAME           LAST_NAME               
-------------------- -------------------------
Jonathon             Taylor                   
*/

Prompt ****** 5.	Nombres de los puestos que desempe�an los empleados en el departamento IT, sin tuplas repetidas....

SELECT distinct j.job_title
FROM (pr3_employees e INNER JOIN pr3_departments d
      USING (department_id)) 
      INNER JOIN pr3_jobs j
      USING (job_id)
WHERE d.department_name = 'IT';

/*
JOB_TITLE                         
-----------------------------------
Programmer    
*/

Prompt ****** 6.	Listado con los nombres de los empleados que trabajan en cualquier departamento cuyo nombre contenga una e que no trabajan en Europa, junto con el nombre del departamento y del pa�s en el que trabajan......

SELECT e.first_name, e.last_name, d.department_name DEP, c.country_name
FROM (((pr3_employees e INNER JOIN pr3_departments d
      USING (department_id)) INNER JOIN pr3_locations l
      USING (location_id)) INNER JOIN pr3_countries c 
      USING (country_id)) INNER JOIN pr3_regions r 
      USING (region_id)
WHERE r.region_name <> 'Europe'
  AND d.department_name LIKE '%e%';

/*
FIRST_NAME   LAST_NAME  DEP	      COUNTRY_NAME                           
----------- ----------- -------------------------------------
Steven       King        Executive    United States of America                 
Neena        Kochhar     Executive    United States of America                 
Lex          De Haan     Executive    United States of America                 
Nancy        Greenberg   Finance      United States of America                 
Daniel       Faviet      Finance      United States of America                 
John         Chen        Finance      United States of America                 
Ismael       Sciarra     Finance      United States of America                 
Jose Manuel  Urman       Finance      United States of America                 
Luis         Popp        Finance      United States of America                 
Michael      Hartstein   Marketing    Canada                                   
Pat          Fay         Marketing    Canada     
*/

Prompt ****** 7.	Listado de las localizaciones de los departamentos de la empresa (identificador del pa�s, ciudad, identificador de la localizaci�n y nombre del departamento) en la que se encuentra alg�n departamento de UK, incluyendo aquellas localizaciones de UK en las que no hay departamento. El listado debe estar ordenado por ciudad.....

SELECT l.country_id, l.city, location_id, d.department_name 
FROM pr3_departments d RIGHT OUTER JOIN pr3_locations l
	 USING (location_id)
WHERE country_id = 'UK'
ORDER BY city;

/*
COUNTRY_ID 	CITY	  	LOCATION_ID	  DEPARTMENT_NAME              
-------------  ---------  --------------  --------------------
UK         	London     2400 			  Human Resources                
UK         	Oxford     2500 			  Sales                          
UK         	Stretford  2600               
*/

Prompt ****** 8.	Nombre de todos los pa�ses que no tengan ninguna localizaci�n, ordenados alfab�ticamente en orden descendente.....

SELECT c.country_name
FROM pr3_countries c LEFT OUTER JOIN pr3_locations l
     USING (country_id)
WHERE l.location_id IS NULL
ORDER BY c.country_name DESC;

/*
COUNTRY_NAME                           
----------------------------------------
Zimbabwe                                 
Zambia                                   
Nigeria                                  
Kuwait                                   
Israel                                   
HongKong                                 
France                                   
Egypt                                    
Denmark                                  
Belgium                                  
Argentina                                

 11 filas seleccionadas
*/

Prompt ****** 9.	Nombre, apellidos y departamento de los empleados sin departamento (el departamento aparecer� vac�o) y de los departamentos sin empleados (el nombre y apellidos aparecer�n vac�os).....

SELECT e.first_name, e.last_name, d.department_id
FROM pr3_employees e FULL OUTER JOIN pr3_departments d
     ON e.department_id = d.department_id
WHERE e.first_name IS NULL
   OR d.department_id IS NULL;

COMMIT;
