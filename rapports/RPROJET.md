# Rapport de Projet


Plan noté en cours:

1. intro
	- présente du contexte en qq ligne
	- annonce du plan	
2. **presentation contexte + sujet** (très important, 4 à 5 pages)
	- du general au particulier
	- ex: entreprise → service → besoins → sujet (contact → sujet)
3. cahier des charges
	- le plus simple à rédiger 
	- fonctions attendus
	- pour qui (utilisateur)
	- comment
4. réalisation
	- qq capture d'écrans (4 ou 5 maxi) (important)
5. bilan + planning
	- planning du début et planning de la fin
	- bilans: humain + technique + pédago
6. conclusion
	- synthése
	- ouverture
	- **se termine bien**
	
Lors de mes différentes sortie sur Belfort j'ai eu l'occasion de discuter avec beaucoup d'étudiant venant de toute la région qui se plaignaient du manque de transport pour rentrer chez eux. Dans ce contexte j'ai eu l'idée réaliser un site de covoiturage pour les étudiants plus spécialement de l'Est de la France. Dans ce contexte nous verrons en details les attentes des étudiant et d'un tel site, le cahier des charges puis finalement le rendu travail plus le bilan de ce projet.

## Présentation

Le projet consiste à réaliser un site de covoiturage pour les étudiants de l'Est de la France afin qu'ils puissent trouver des voyages pour rentrer chez eux les week-end. Pour cela ils ont besoin de se faire un carnet d'adresse afin de rester en contact avec les gens prés de chez eux. 

Ce genre d'application peut être bénéfique à toute association étudiante et peut meme être mit en place par une organisation uniquement dédier à cette activitée.

En rassemblant toutes ces informations, il semble evident de créer un site orienté réseau social avec un moteur de recherche permettant de trouver les personnes avec qui on peut covoiturer. Nous avons mit en place ce servie avec une idée simple: le conducteur propose un voyage et ses contacts sont averti de ce voyage et peuvent donc rentrer en contact avec le chauffeur.

## Cahier des charges

Ce site est destiné au étudiant et donc à un publique jeune qui a une experience des ordinateurs.

L'application doit être réalisée en PHP/javascript/SQL. Elle doit fonctionner sur un serveur Apache et sur un environnement Linux. La base de donnée doit être créer à partir d'un script sql.

Ce site doit remplir les different points:

1. Intuitif : l'application doit pourvoir s'utiliser sans avoir besoin de lire la documentation. Pour cela il faudra une interface propre.
2. Pour les étudiants: la base de donnée doit intégrer la liste des université afin de pouvoir regrouper les étudiants.
3. Simple: un conducteur propose un voyage et toute personne peut rentrer en contact avec cette étudiant.
4. En France: les voyage peuvent aller de n'importe quelle ville en France.
5. Voyage récurent: si un étudiant rentre chez lui tout les week-end, il peut proposer sont voyage de manière récurrente tout les sept jours.
6. Les voyages des contacts: tout utilisateur peut consulter les voyages proposé par ses contacts dans la page voyage.
7. Carnet d'adresse: une interface pour consulter ses contact est obligatoire afin de trouver les informations de contact.
8. Demande de contact: il est possible de trouver et demander en contact tout autre utilisateur.
8. Recherche: il est possible de rechercher un voyage ou un étudiants dans la base de donnée.
9. Information personnelle: conformément à la CNIL il est possible de modifier et supprimer ses information personnelle, mais aussi d'en ajouter.
10. Mot de passe: le mot de passe doit être crypté et doit pouvoir être changé.
11. Compte: il es possible de créer et de supprimer son compte. 

Il nous a donc semblé évident de réaliser un réseau social avec un système de notification.

## Réalisation

Le cahier des charge a été remplie dans son intégralité, nous avons même réalisé des options qui n'était pas demandé comme l'adaptation de la couleur principale en fonction de l'utilisateur ainsi qu'un système de messagerie privée.

### Pages

Nous avons donc les pages suivante:

1. Page de connextion
1. Home
2. Voyages
3. Contacts
4. Messages
5. Recherche
6. Profile

#### Page de connection

La page de connexion comme son nom l'indique permet de se connecter à son compte ou de créer un compte.

En plus des fonctionnalités de cette page, nous avons affiché le nombre d'utilisateur à coté du formulaire d'inscription.

#### Home

Une fois connecté, l'utilisateur arrive sur la page home et se voit proposer quatre lien qui corresponde aux quatre pages principales du site à savoir Voyages, Contacts,  Messages, et Recherche.

L'utilisateur peut aussi voir la bar de navigation et une boite resumument ses information personnelles. Ces deux dernier éléments seront présent dans tout le reste du site.

#### Voyages

La page voyage contient l'intégralité des voyage proposé par l'utilisateur en plus des voyages des contacts de l'utilisateur.

![un oyages](captures/voyages.png)

Pour afficher une voyage, il suffit de cliquer dessus et une popup s'affiche avec une carte Google Map, et les différente information du voyage comme le temps approximatif, les différentes dates des trajet ainsi que la récurrence si les trajets se répètent.

![un oyages](captures/unvoyage.png)

#### Contacts

Cette page est probablement la plus classique 

![un oyages](captures/contacts.png)

#### Messages

![un oyages](captures/messages.png)

### Base de donnée

### Moyen utilisé