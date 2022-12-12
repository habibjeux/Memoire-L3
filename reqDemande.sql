// Nombre d heure fait pour chaque module
SELECT M.idModule, M.libelleModule, SUM(C.nbHeure) AS nbHeureFait FROM module M, cours C WHERE M.idModule = C.idModule AND C.estFait = 1 GROUP BY C.idModule;

// Nombre d heure non fait pour chaque module
SELECT M.idModule, M.libelleModule, SUM(C.nbHeure) AS nbHeureFait FROM module M, cours C WHERE M.idModule = C.idModule AND C.estFait = 0 GROUP BY C.idModule;

//Nombre d heure restant ou en excès pour chaque module
SELECT M.idModule, M.libelleModule, SUM(C.nbHeure) AS nbHeureFait,
M.nbHeureModule - SUM(C.nbHeure) AS RestantExces FROM module M, cours C 
WHERE M.idModule = C.idModule AND C.estFait = 1 GROUP BY C.idModule;

//Les modules terminés et ayant fait un examen
SELECT idModule, libelleModule FROM module WHERE idModule in (SELECT E.idModule FROM enseigner E, Cours C
WHERE E.idModule = C.idModule AND E.dateFin IS NOT NULL AND E.examenFait = 1 GROUP BY E.idModule);

//Les modules terminés et examen pas encore fait
SELECT idModule, libelleModule FROM module WHERE idModule in (SELECT E.idModule FROM enseigner E, Cours C
WHERE E.idModule = C.idModule AND E.dateFin IS NOT NULL AND E.examenFait = 0 GROUP BY E.idModule);

//Les modules qui n ont pas encore débuté
SELECT idModule, libelleModule FROM enseigner WHERE dateDebut IS NULL;

//Le nombre de séance faite pour chaque module
SELECT M.idModule, M.libelleModule, COUNT(C.estFait) AS nbSeanceFaite FROM module M, cours C WHERE M.idModule = C.idModule AND C.estFait = 1 GROUP BY C.idModule;
