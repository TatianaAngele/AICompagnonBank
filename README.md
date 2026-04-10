## Documentation de l'API

1. Rendez-vous sur [https://editor.swagger.io](https://editor.swagger.io)
2. Cliquez sur `File` → `Import file`
3. Sélectionnez le fichier `/api_doc/aicompagnonbank.json`

## Clonage du dépot :

```sh
git clone https://github.com/TatianaAngele/aicompagnonbank
cd aicompagnonbank
```

## Installation des dépendances

Assurez-vous d'avoir Composer installé sur votre machine. Pour installer toutes les bibliothèques et dépendances requises par le projet, exécutez la commande suivante à la racine du projet :

```sh
composer install
```

## Configuration de l'environnement (.env)

Le projet utilise un fichier d'environnement pour gérer la configuration locale (comme les accès à la base de données).

1. Copiez le fichier .env.example et nommez la copie .env :

```sh
cp .env.example .env
```

2. Ouvrez le fichier .env avec votre éditeur de texte.
3. Repérez la ligne DATABASE_URL correspondant à PostgreSQL. C'est la seule ligne que vous devez modifier. Remplacez les identifiants par ceux de votre configuration locale et ajustez la variable serverVersion selon la version de PostgreSQL installée sur votre machine.

```raw
DATABASE_URL="postgresql://votre_utilisateur:votre_mot_de_passe@127.0.0.1:5432/aicompagnonbank?serverVersion=VOTRE_VERSION_POSTGRESQL&charset=utf8"
```

## Création de la base de données

Une fois le fichier .env correctement renseigné, vous pouvez créer la base de données PostgreSQL associée au projet en utilisant la console de Symfony :

```sh
symfony console doctrine:database:create
```

## Lancement du projet

Pour démarrer le serveur de développement web, utilisez la commande suivante

```sh
symfony server:start
```

Votre application sera alors accessible depuis http://localhost:8000/api
