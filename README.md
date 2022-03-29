# demons-et-merveilles

Ce site a été réalisé pour l'édition 2019 du Démons&&Merveilles organisé par l'AIUS.

J'ai réalisé ce site en PHP, couplé avec une base de données MySQL.

Ce site est une plateforme ayant pour objectif de :

- servir de site vitrine
- permettre à des MJ de déposer des scénarios et des histoire de JdR
- permettre à l'organisateur de définir des salles et tables de JdR
- permettre à l'organisateur de définir des créneaux horaires
- permettre à l'organisateur de valider/refuser les propositions des MJ
- permettre à des joueurs de rejoindre les parties validées par les admins

Cette plateforme a uniquement pour but d'organiser les parties de JdR qui se dérouleront en présentiel.

Une version démo est disponible sur : https://demons-et-merveilles.lucas-lett.fr/
Utilisez le compte démo suivant :
username : démo
password : 123456

---

Pour l'installer :

- mettez en place une base de données et initialisez là avec le script sql
- modifiez config.php avec les infos nécessaires

---

Note:

Ce site a été réalisé avec les anciennes fonction sql de PHP, aujourd'hui non supportées.
Un patch a été ajouté pour convertir les anciennes fonctions en fonction mysqli
