/*  combien d'étudiants dans tous les "groupes" */
SELECT 
    Classe, COUNT(*) AS nbr
FROM
    etudiants
GROUP BY Classe
 
/* combien d'étudiants par année-section? */
 
SELECT 
    left(Classe, 2) as AnSec, COUNT(*) AS nbr
FROM
    etudiants
GROUP BY left(Classe, 2)

/* combien d'étudiants par section? */

SELECT 
    right(left(Classe, 2),1) as AnSec, COUNT(*) AS nbr
FROM
    etudiants
GROUP BY right(left(Classe, 2),1)

/* combien de fois reviennenwheret chaque prénoms? */

SELECT 
    Prenom, COUNT(*) AS nbr
FROM
    etudiants
GROUP BY Prenom

/* Quel est le plus grand nombre de fois que revient un prénom? */

SELECT 
    MAX(nbred) AS bb
FROM
    (SELECT 
        COUNT(*) AS nbred
    FROM
        etudiants
    GROUP BY Prenom) AS nbr
/* Quel(s) est(sont) le(s) prénom(s) qui revien(nen)t le plus souvent.*/
/* avec limit */

SELECT 
    Prenom
FROM
    etudiants
GROUP BY Prenom
ORDER BY COUNT(Prenom) DESC
LIMIT 2

/* sans limit */


SELECT 
    Prenom
FROM
    etudiants
group by Prenom
having count(*) = (SELECT 
    MAX(nbred) AS nombre
FROM
    (SELECT 
        COUNT(*) AS nbred
    FROM
        etudiants
    GROUP BY Prenom) AS nbr)
    
    
/* Y-a-t-il un(des) cas d'homonymie ? */
/* dans "etudians" */

SELECT 
    nom, prenom, COUNT(*) AS nbr
FROM
    etudiants
WHERE
    nom = nom AND prenom = prenom
GROUP BY nom , prenom
HAVING COUNT(*) > 1

/* das "etudians_2" */

SELECT 
    nom, prenom, COUNT(*) AS nbr
FROM
    etudiants_2
WHERE
    nom = nom AND prenom = prenom
GROUP BY nom , prenom
HAVING COUNT(*) > 1

/* Quels sont les étudiants concernés par une homonymie? */
/* dans "etudians" */

SELECT 
    *
FROM
    etudiants
WHERE
    nom = (SELECT    // nom IN (SELECT 
            nom
        FROM
            etudiants
        WHERE
            nom = nom AND prenom = prenom
        GROUP BY nom , prenom
        HAVING COUNT(*) > 1)
ORDER BY nom

/* das "etudians_2" */

SELECT 
    *
FROM
    etudiants_2
WHERE
    nom IN (SELECT     // nom  (SELECT  ne marche pas ?????????
            nom
        FROM
            etudiants_2
        WHERE
            nom = nom AND prenom = prenom
        GROUP BY nom , prenom
        HAVING COUNT(*) > 1)
ORDER BY nom


