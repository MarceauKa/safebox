# Safebox

**Safebox** est une application à **auto-héberger** destinée aux **freelances** ou aux **agences** permettant de gérer ses sites, ses comptes utilisateurs, 
ses notes, ses snippets, ses domaines.

L'application est développée sous **Laravel 5.3** et **Vue.js 2**. Les données stockées sont chiffrées en base de données et sont déchiffrées à la volée.

## Installation

**Safebox** nécéssite:
- PHP >= 5.6
- Node.js
- Gulp
- NPM

### 1. Installation se fait sous composer

```bash
composer create-project 404labfr/safebox
```

### 2. Configuration et migration

La configuration se fait dans le fichier `.env`.  
Une fois la base de données configurée, lancez les migrations.

```bash
artisan migrate --seed
```

### 3. Installation des assets
```bash
npm install
gulp
```

4. Lancement du serveur local:
```
artisan serve
```

## Documentation

### Utilisateur par défaut

Email: admin@safebox.com
Mot de passe: password

## Contribuer

**Safebox** est open-source. N'hésitez pas à proposer vos améliorations et vos idées en utilisant l'onglet "Issues".

## License

Safebox est proposée en [licence open-source MIT](http://opensource.org/licenses/MIT).
