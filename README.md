<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel Shopper 

visit [laravel-shopper](https://laravelshopper.dev/docs/2.x) To explore this awesome package.

### installation 

    ```bash
        composer create-project laravel/laravel shopper
        composer require shopper/framework --with-dependencies
        php artisan shopper:install
        php artisan shopper:publish
        php artisan migrate:fresh --seed
        composer require shopper/starter-kits --dev #install livewire straterkit
        php artisan shopper:starter-kit:install livewire
        php artisan shopper:user

        php artisan shopper:component:publish  #publish components

    ```

## ***changes realized***

- Added to main database seeder to seed permissions and tohter relevant items 

```php
$this->call([
           ShopperSeeder::class
        ]);
```
to default seeder after publishing vendor resources 

- Changes to storage to store cover image and logo add an uploads driver 

```php

//GO TO filesystems.php add this under disks,
 'uploads' => [
            'driver' => 'local',
            'root' => storage_path('app/uploads'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
            'report' => false,
        ],
    //if folder does not exist create it in storage/app/

```

###### After creating a Payment Method
- Edit zone, Add it to the Zone to be used.
- Navigate to Views->components->icons->payments and create a view for the payment method

## Custom Dashboard

```bash

    php artisan make:livewire CustomDashboard

```
In `Config\Shopper\Component\dashboard` alter 

```php
 'pages' => [
        // 'dashboard' => Pages\Dashboard::class,
        'dashboard' => App\Livewire\CustomDashboard::class,
    ],
```
To overide the view or copy it and amet it navigate to `vendor/shopper/framework/resources/views/livewire/pages/` get the view you want and copy it to the view you want. Alternatively you can copy it to overide the defaults for instance :

```bash

mkdir -p resources/views/vendor/shopper/livewire/pages
cp vendor/shopper/framework/resources/views/livewire/pages/dashboard.blade.php resources/views/vendor/shopper/livewire/pages/

# same as for other files such as lanhage translations
mkdir -p resources/lang/vendor/shopper/en/pages
cp vendor/shopper/framework/resources/lang/en/pages/dashboard.php resources/lang/vendor/shopper/en/pages/


``` 
now this will be treated as the view to take Instead of overiding anything in the Vendor directly because it will be overwritten on upgrades . Then proceed to Modify `resources/views/vendor/shopper/livewire/pages/dashboard.blade.php`

## sidebar

to see how to manipilate the sidebar plugin used [see](https://github.com/shopperlabs/shopper/blob/2.x/packages/admin/docs/content/extending/navigation.md)

## views

Copy Shopper views 
```bash 
cp -R vendor/shopper/framework/resources/views resources/views/vendor/shopper
```
Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
