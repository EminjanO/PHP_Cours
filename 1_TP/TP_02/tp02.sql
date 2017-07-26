##### phase I #####

# 2.liste des bases de données disponibles 
SHOW DATABASES;

# 3.liste des tables disponibles
SHOW TABLES;

# 4.liste des champs de la table etudiants
SHOW columns
FROM etudiants;

EXPLAIN etudiants;
DESCRIBE etudiants;

##### phaseII #####

#1 Allez dans la base de données world
USE world;
#2 Affichez la liste des tables disponibles
SHOW TABLES;
#3 Affichez la structure des tables.
SHOW CREATE TABLE city;
DESCRIBE city; DESCRIBE country; DESCRIBE countrylanguage;
#4 Dessinez le schéma relationnel de la base de données
(Tables : contenus, types, clés ; Liens entre les tables)

### Minicampus
# Afficher la liste des tables disponibles :
SHOW tables
Afficher la structure des tables :
DESCRIBE class; DESCRIBE class_user;
DESCRIBE cours; DESCRIBE course_class;
ESCRIBE cours_user; DESCRIBE faculte; DESCRIBE user;

# Dessinez le schéma relationnel des tables


##### phaseIII #####

# Partie 1. : travail "mono table" -> dans world

# Afficher la plus grande superficie pour un pays
SELECT
	max( SurfaceArea ) AS laPlusGrande
FROM
	country;

# Afficher le pays qui a la plus petite superficie

SELECT
	country.Name,
	country.SurfaceArea AS 'laPlusPetiteSuperf.(km²)'
FROM
	world.country
WHERE
	country.SurfaceArea = (
		SELECT
			MIN( country.SurfaceArea )
		FROM
			world.country );

# Afficher la superfie totale du "BENELUX"
SELECT
	'benelux', SUM( SurfaceArea )
FROM
	country
WHERE
	name IN ( 'Netherlands', 'belgium', 'Luxembourg' );

# ou bien

SELECT
	'benelux', SUM( country.SurfaceArea ) AS 'surface'
FROM
	world.country
WHERE
	country.Code2 = 'BE'
	OR country.Code2 = 'NL'
	OR country.Code2 = 'LU';

# Afficher la superfie totale des pays suivants: "BENELUX", France, Allemagne, Espagne, Italie, Grece

SELECT
	SUM( SurfaceArea ) + (
		SELECT
			SUM( SurfaceArea )
		FROM
			country
		WHERE
			name IN ( 'Netherlands', 'belgium', 'Luxembourg' ) ) AS surface
FROM
	country
WHERE
	name IN ( 'France', 'Germany', 'Spain', 'Italy', 'Greece' );

# Partie 2 : travail "multi table"

# Pour les pays du "BENELUX":
# donnez, le nom du pays, la population du pays et la population totale des villes du pays reprise dans la table des villes

SELECT
	c.name AS pays,
	c.Population AS popuPays,
	SUM( v.Population ) AS popuVilles
FROM
	country AS c
	INNER JOIN
	city AS v
		ON c.Code = v.countrycode
WHERE
	c.name IN ( 'Belgium', 'netherlands', 'Luxembourg' )
GROUP BY c.name;

## ou bien

SELECT
	c.name AS pays,
	c.Population AS popuPays,
	SUM( v.Population ) AS popuVilles
FROM
	country AS c
	INNER JOIN
	city AS v ON c.Code = v.countrycode
WHERE
	c.code IN ( 'BEL', 'NLD', 'LUX' )
GROUP BY c.code;

# donnez en ordre décroissant sur les pourcentages, les noms et les pourcentages des langues parlées

SELECT DISTINCT
	l.language AS 'language',
	ROUND( SUM( l.percentage / 100 * c.population ) / (
		SELECT
			SUM( c.population )
		FROM
			country AS c
		WHERE
			c.code IN ( 'BEL', 'NLD', 'LUX' ) ) * 100,
				 5 ) AS pct
FROM
	country AS c
	INNER JOIN
	countrylanguage AS l ON c.Code = l.CountryCode
WHERE
	c.code IN ( 'BEL', 'NLD', 'LUX' )
GROUP BY l.language
ORDER BY pct DESC

# donnez le pourcentage de personnes qui parlent une langue officielle

SELECT
	ROUND( SUM( ( cl.Percentage / 100 ) * ct.Population ) / (
		SELECT
			SUM( ct.Population )
		FROM
			country AS ct ) * 100,
				 5 ) AS '%_langueOfficielle'
FROM
	countrylanguage AS cl
	INNER JOIN
	country AS ct ON ct.code = cl.CountryCode
WHERE
	cl.isOfficial = 'T';

# donnez le pourcentage de personnes qui ne parlent pas une langue officielle

SELECT
	ROUND( SUM( ( cl.Percentage / 100 ) * ct.population ) / (
		SELECT
			SUM( ct.population )
		FROM
			world.country AS ct ) * 100,
				 5 ) AS '%_langueNonOfficielle'
FROM
	world.countryLanguage AS cl
	INNER JOIN
	world.country AS ct ON ct.code = cl.CountryCode
WHERE
	cl.isOfficial = 'F';

## A faire chez soi

# 1. Dans `world` : mono-table

# Afficher la superficie de chacune des régions d'Europe


SELECT
	ct.Region, SUM( ct.SurfaceArea )
FROM
	world.country AS ct
WHERE
	ct.Continent = 'Europe'
	AND ct.Region LIKE '%Europe'
GROUP BY ct.Region;

#  Pour chacun des continents, afficher le(s) pays qui a (ont) eu leur indépendance le plus récemment

SELECT
	ct1.Name, ct1.Continent, ct1.IndepYear
FROM
	world.country AS ct1
	JOIN
	(
		SELECT
			ct.Continent, MAX( ct.IndepYear ) AS 'maxIndepYear'
		FROM
			world.country AS ct
		GROUP BY Continent ) ct2 ON ct1.Continent = ct2.Continent
																AND ct1.IndepYear = ct2.maxIndepYear
ORDER BY ct1.Continent, ct1.Name;





#  2. Dans `minicampus` : mono-table

#  Afficher la liste des facultés "de base" (Celles qui n'ont pas de parent)

SELECT
	*
FROM
	minicampus.faculte
WHERE
	faculte.codeParent IS NULL;

#  Afficher les "filles" d'une faculté donnée (p.e. TI)

SELECT
	*
FROM
	minicampus.faculte
WHERE
	faculte.codeParent = 'TI';

#  Afficher la liste des classes "de base" (celles qui n'ont pas de parent)

SELECT
	*
FROM
	minicampus.class
WHERE
	class.parent_id IS NULL;

#  Afficher les "filles" d'une "section" donnée (p.e TI)

SELECT
	class.nom AS 'nomFilles(TI)'
FROM
	minicampus.class
WHERE
	class.parent_id = (
		SELECT
			class.id
		FROM
			minicampus.class
		WHERE
			class.nom = 'TI' );

#  Afficher les "filles des filles" d'une classe donnée (p.e TI)

SELECT
	class.nom AS 'nomPetitesFilles(TI)'
FROM
	minicampus.class
WHERE
	class.parent_id BETWEEN 2 AND 4;

#  3. Dans `minicampus` : multi-tables

#  Pour tous les étudiants, afficher les informations suivantes :
# Groupe, Matricule, Nom, Prénom, Email (construit : matricule@students...)
########################## pas du bon repense
SELECT
	class.nom AS goupe,
	UCASE( user.username ) AS 'matricule',
	user.nom,
	user.prenom,
	CONCAT( LCASE( user.username ),
					'@students.ephec.be' )
FROM
	minicampus.user
	INNER JOIN
	minicampus.class_user ON user.id = class_user.user_id
	INNER JOIN
	minicampus.class ON class_user.class_id = class.id
WHERE
	user.username LIKE 'HE%';

#  Afficher la liste des cours (code, faculté et libellé) pour une classe donnée (p.e. 1TL2)

SELECT
	cours.code, faculte, cours.intitule
FROM
	minicampus.cours
	INNER JOIN
	minicampus.course_class ON cours.code = course_class.cours_id
	INNER JOIN
	minicampus.class ON class.id = course_class.class_id
WHERE
	class.nom = '1TL2';

#  Pour chacune des "facultés", afficher ces informations précédées du nom de son "parent"

SELECT
	f2.nom,
	f1.id,
	f1.nom,
	f1.code,
	f1.codeParent,
	f1.position,
	f1.nbEnfants
FROM
	minicampus.faculte f1
	INNER JOIN
	minicampus.faculte f2 ON f1.codeParent = f2.code
WHERE
	f1.codeParent IS NOT NULL;


































