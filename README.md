<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

[Laravel 11.x Inertia Vue](https://laravel.com/docs/11.x)

##### Libraries
- [Laravel Breeze And Inertia Vue](https://laravel.com/docs/11.x/starter-kits#breeze-and-inertia)
- [Flowbite 3.0.0](https://flowbite.com)
- [vue3-toastify 0.2.8](https://www.npmjs.com/package/vue3-toastify)

##### Requirements
- PHP >= 8.2

##### Installation
    ```
    composer install
    ```

    ```
    copy .env-example to .env
    ```

    ```
    php artisan migrate --seed
    ```

##### Installation
     ```
    php artisan serve
    ```
##### Structure
- app
    - DataTransferObject
    - Http
    - Models
    - Providers
    - Repositories
    - Services
    - Traits
        - Acessor
- bootstrap
- config
- database
    - factories
    - migrations
    - seeders
- public
- resources
    - css
    - js
    - views
        - email
- routes
- storage
    - app
    - framework
    - logs
- tests
