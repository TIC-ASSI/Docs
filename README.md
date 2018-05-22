---
autotemp: true
title: Monitoratge de servidors a temps real
subtitle: Aplicacions i Serveis d'Internet
author:
	- Erik Campobadal
	- Toni Sbert
	- Aleix Gil
	- Oscar Vendrell
---

#Introducció

En aquest projecte final de l'assignatura hem creat una aplicacio d'Internet on un ususari pot veure a temps real totes les dades dels seus servidors.
Podrem veure percentatges de espai lliure o utilitzat en els servidors, utilitzacio de la xarxa, utilitzacio de la cpu o tambe els processos que hi corren.

Principalment s'han d'instalar una serie de paquets que posem a continuacio:

\lstinputlisting[language=bash , caption="installer"]{installer}

Els paquets necessaris que hem instalat, son el apache pel servidor, mySQL per tractar la base de dades, PHP per poder tractar les dades i fer la app, i finalment python3 **sha de completar**

#Python


#PHP
Un cop ens van arriban les dades les hem de classificar segons el que volguem veure. Hem creat diferents moduls on a cada modul farem diferents relacions i clasificarem les dades:

##User

Principalment tenim el modul **user**, on demanem al usuari que ens dongui un nom, el seu email i la contrasenya, i crearem un token (anoment api_token).

Per fer-ho segur tenim la funcio *setPasswordAttribute*, que aqui creem el hash de la contrasenya. Per ultim veiem la ultima funcio *servers*, on fem la relacio amb l'esquema anterior, es a dir, un usuari pot tenir varis servidors.

\lstinputlisting[language=php , caption="User.php"]{./Moni/app/User.php}

##Server

En el modul **server** primerament rebrem el mon, el sistema operatiu actiu, la seva versio, el processador, node i la plataforma utilitzada, i tot un seguit de funcions on podem veure la realcio amb la resta de moduls. Primer tenim la relacio amb user, on veiem que el servidor nomes correspon  a un unic usuari, pero les seguents relacions podem comprobar com per exemple un servidor pot tenir varis processos (*return $this->hasMany(Pid::class);*), i aixi amb els moduls **net**, **Disk**, **Cpu**, **Mem** i **Net**.

\lstinputlisting[language=php , caption="Server.php"]{./Moni/app/Server.php}

##Net, Pid, Disk, Cpu, Mem, Net

En aquests moduls practicament farem el mateix en tots. De tota la informació que ens arriba agafem la que ens sigui necessaria segons el modul, i fem la serva relació amb la resta de moduls. Per exemple en el modul **Disk** ens interes el seu espai lliure, total, ocupat i el percentatge corresponent, i despres fem la relacio amb el modul **Server** i **Time**

\lstinputlisting[language=php , caption="Disk.php"]{./Moni/app/Disk.php}

##Address

\lstinputlisting[language=php , caption="Address.php"]{./Moni/app/Address.php}

##Time

\lstinputlisting[language=php , caption="Time.php"]{./Moni/app/Time.php}

##Controller

\lstinputlisting[language=php , caption="Time.php"]{./Moni/app/Http/MoniController.php}
