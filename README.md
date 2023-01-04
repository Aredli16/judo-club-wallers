# 🥋Judo Club Wallers🥋

Judo Club Wallers website

## Requirements 🚨

`PHP 8`, `Composer` and `Docker`

## Built With

- [![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/)
- [![Symfony](https://img.shields.io/badge/symfony-%23000000.svg?style=for-the-badge&logo=symfony&logoColor=white)](https://symfony.com/)
- [![Bootstrap](https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)](https://getbootstrap.com)

## Installation 🛠️

Start by installing the project dependencies

```bash
$ composer install
```

### Run locally

```bash
$  docker compose up # Launch database
$  php bin/console doctrine:migrations:migrate # Set up the database

$  symfony server:start # To start symfony server if you have Symfony CLI installed
```

### Fill database with fake data

```bash
$  php bin/console doctrine:fixtures:load
```

## Testing 🧪

```bash
$  php bin/phpunit # Testing app
$  php bin/phpunit --coverage-html var/test # Testing app and report code coverage into var/test/index.html file
```

## Deployment 🏗️

## Authors 👀

- [@Aredli16](https://www.github.com/Aredli16)
- [@Aventel](https://www.github.com/Aventel)
- [@Shinotobira](https://www.github.com/Shinotobira)
