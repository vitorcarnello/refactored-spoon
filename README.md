# Refactored Spoon API
This repository contains the base code for the **Refactored Spoon REST API**.

## Technology Stack

This project is based on the following main technologies:

**Laravel 8** + **PHP 8** + **PHP-FPM** + **MySQL**

with the entire environment running in **Docker** containers.
## Getting Started

The infrastructure is implemented using **Docker** and **Laravel Sail**.

### Setting Up the Development Environment
**1** Copy the .env.example file to .env

**2** Download the **Docker Containers** using the following command:

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/opt \
    -w /opt \
    laravelsail/php80-composer:latest \
    composer install --ignore-platform-reqs
```

**3** Create an alias for laravel sail:

```bash
alias sail='bash vendor/bin/sail'
```

**4** Turn up the containers:

```bash
sail up -d
```

**5** Generate an application key:

```bash
sail artisan key:generate
```

**6** Run the migration and the seeders:

```bash
sail artisan migrate --seed
```

**7** Get access to localhost and AdminerUI:

[http://localhost](http://localhost)  
[http://localhost:5431](http://localhost:5431)  
 
Adminer UI credentials:

**Server:** mysql   
**Username:** root  
**Password:** root  
**Database:** app  

## Code Quality

To run the tests, run the following command

```bash
sail artisan test
```
