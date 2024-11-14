# Utilisation du projet
## 1 - Prérequis
Installez les dernières versions des composants suivants :
* [Docker](https://docs.docker.com/install/)
* [Plugin compose de docker et non docker-compose](https://docs.docker.com/compose/install/)
* [Make / Makefile](https://www.gnu.org/software/make/manual/make.html)

Ces outils sont assez communs sous Linux et MacOs, si vous êtes sous Windows, je vous recommande d'installer docker dans [WSL](https://learn.microsoft.com/fr-fr/windows/wsl/install).

## 2 - Technologies
Le projet est une application de consultation de films développée sur une stack php 8.2 sous le framework Symfony 7.1.6.

Ma stack docker est minimaliste, j'utilise php en mode cli, le service php n'est donc pas permanent et n'est relancé qu'en temps voulu.

Pour lancer le serveur, j'utilise le server web interne à php qui n'est bien sûr pas adapté à la production, mais qui "fit" bien avec l'objectif de l'exercice.

Je n'utilise plus le server local de symfony car depuis la version 5, la commande a été déplacée vers la cli symfony que je ne souhaite pas utiliser.

## 3 - Make
Le projet utilise make comme **task runner**, chaque commande (docker ou autres) habituellement lancée en ligne de commande est wrappée dans les targets du makefile.

Si vous ne désirez pas utiliser make, rien ne vous y oblige il suffit de copier chaque commande de la target correspondante.

Attention tout de même de bien remplacer les variables adéquates telles que les variables **${UID}** et **${GID}**.
En effet, certaines commandes qui génèrent des fichiers sont utilisées avec un utilisateur ayant les mêmes uid/gid du host afin d'éviter des conflits de droit owner.

## 4 - Lancement de l'application
### Le Build
On commence par build l'image docker de php.
Pour information, j'installe globalement dans l'image docker certains outils de tests et d'analyses.

```bash
$ make
```

#### L'Installation des dépendances et build des assets

```bash
$ make install
```
A ce stade il ne faut pas oublier de rajouter sa clé dans **.env.local**
```bash
$ echo TMDB_API_KEY=my_key > .env.local
```

#### Lancement de la stack

### LE RUN

#### Lancement du serveur

Pour lancer le serveur en mode dev :
```bash
$ make server-dev
```
En mode prod :
```bash
$ make server-prod
```

Le serveur est accessible en local sur votre navigateur sur l'adresse : "http://localhost:8000/"

/!\ Attention en mod prod il faut lancer make install-prod pour build les assets de prod avant de lancer la stack.

### Tests
J'ai séparé les tests en 2 packages :
* Core : test de la layer applicative : La partie infrastructure est mockée par des Inplementation des gateways "in memory".
* Functional : des tests fonctionnel droits qui prouve qu'il n'y a pas d'erreur sur les routes testées, dans l'environement de test l'injection de dépendance est configurée pour utiliser les implémentations in memory.


#### Lancement des tests *Core*

```bash
$ make test-core
```

#### Lancement des tests *Functional*

```bash
$ make test-func
```

Les tests peuvent être tous lancés d'un coup avec la commande make test.

```bash
$ make test
```
