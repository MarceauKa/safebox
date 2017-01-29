# Safebox

**Safebox** is a self-hosted web application for **developers** and **web agencies** to manage **clients**, **websites**, **accounts**, **procedures**, **snippets** and more.
It's built with **Laravel 5.4** and **Vue.js 2**. All sensitive data are **encrypted** in the database.

## Installation

**Safebox** requires:
- PHP >= 7
- Node.js
- NPM
- Linux (or OSX)

### 1. Composer

```bash
composer create-project 404labfr/safebox
```

### 2. Configuration and database

Please update the `.env` file to your needs.  
Once your database is configured:

```bash
artisan migrate
```

If you want fake data:

```bash
artisan db:seed
```

### 3. Assets
```bash
npm install
npm run dev # or npm run production
```

## Documentation

### Default user

Email: `admin@safebox.com`
Password: `password`

### Website screenshots

When adding a website a screenshot is taken. 

You'll need :  
- **PhantomJS** (installed when `npm install`).
- A Laravel worker:
    1. `artisan queue:work` or `artisan queue:listen`.
    2. A CRON task to `artisan schedule:run` (see the Laravel documentation).
    
If you don't want screenshots you can specify the queue driver to `QUEUE_DRIVER=null` in your `.env` file.

## Contribute

All contribution is welcome, please Pull Request or open your issues.

## Tests

**Safebox** uses End-to-End tests with **Laravel Dusk**.
 
```bash
artisan dusk
```

## License

[MIT](http://opensource.org/licenses/MIT).
