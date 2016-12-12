# Safebox

**Safebox** est une web application à **auto-héberger** destinée aux **freelances** ou aux **agences** permettant de gérer ses sites, ses comptes utilisateurs, 
ses notes, ses snippets, ses domaines.

L'application est développée sous **Laravel 5.3** et **Vue.js 2**. Les données stockées sont chiffrées en base de données et sont déchiffrées à la volée.

## Installation

**Safebox** nécéssite:
- PHP >= 5.6
- Node.js
- Gulp
- NPM
- Un environnement Unix

### 1. Installation se fait sous composer

```bash
composer create-project 404labfr/safebox
```

### 2. Configuration et migration

La configuration se fait dans le fichier `.env`.  
Une fois la base de données configurée, lancez les migrations.

```bash
artisan migrate
```

Si vous souhaitez insérer les données de démo, faites :

```bash
artisan db:seed
```

### 3. Installation des assets
```bash
npm install
gulp
```

## Documentation

### Utilisateur par défaut

Email: `admin@safebox.com`
Mot de passe: `password`

### Prendre une capture des sites

Dès que vous ajoutez un site, une capture d'écran est faite.  

Pour cela, vous devez :  
- Avoir librairie node.js "PhantomJS" (installée par défaut lors du `npm install`).
- Le worker de Laravel fonctionnel:
    1. `artisan queue:work` ou `artisan queue:listen`.
    2. Une tâche CRON configurée toutes les minutes sur `artisan schedule:run`.
    
Si vous ne souhaitez pas activer les screenshots, vous pouvez spécifier `QUEUE_DRIVER=null` dans votre fichier `.env`.

## Contribuer

**Safebox** est open-source. N'hésitez pas à proposer vos améliorations et vos idées en utilisant l'onglet "Issues".

## License

Safebox est proposée en [licence open-source MIT](http://opensource.org/licenses/MIT).
