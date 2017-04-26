<p align="center"><img width="250" src="public/img/logo.png?raw=true" alt="Safebox logo" /></p>

# Safebox

**Safebox** is a self-hosted web application for **developers** and **web agencies** to manage **clients**, **websites**, **accounts**, **procedures**, **snippets** and more.
It's built with **Laravel 5.4** and **Vue.js 2**. All sensitive data are **encrypted** in the database.

## Installation

**Safebox** requires:
- PHP >= 7
- Node.js
- NPM
- Linux (or OSX)

**Installation with composer**

```bash
composer create-project 404labfr/safebox
```

**Configuration and database**  

Please update the `.env` file to your needs.  
Once your database is configured:
```bash
artisan migrate
```

If you want fake data:
```bash
artisan db:seed
```

**Assets**

```bash
npm install
npm run [dev|watch|production]
```

## Documentation

### Default user

Email: `admin@safebox.com`  
Password: `password`

### Website screenshots

When adding a website a screenshot is taken. 

You'll need :  
- **PhantomJS** : installed when `npm install`.
- A Laravel worker : see the [queue documentation](https://laravel.com/docs/5.4/queues)
   
If you don't want screenshots you can specify the queue driver to `QUEUE_DRIVER=null` in your `.env` file.

## Changelog

Take a look at the [changelog file](https://github.com/404labfr/safebox/blob/develop/changelog.md).

## Tests

**Safebox** uses features tests with PHPUnit 5.7.
 
```bash
vendor/bin/phpunit
```

## Contribute

All contribution is welcome, please Pull Request or open your issues.

## License

[MIT](http://opensource.org/licenses/MIT).
