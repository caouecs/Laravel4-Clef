# Laravel4-Clef

Integrate the Clef.io tools in a Laravel project.

## Installation

This package is available through `Packagist` and `Composer`.

Add `"caouecs/clef": "dev-master"` to your composer.json or run `composer require caouecs/clef`.

Then you have to add `"Caouecs\Clef\ClefServiceProvider"` to your list of providers in your `app/config/app.php`, and a list of elements for aliases :

    'Clef' => 'Caouecs\Clef\Clef'

So, I recommend you use [Package Installer](https://github.com/rtablada/package-installer), Laravel4-Clef has a valid provides.json file. After installation of Package Installer, just run `php artisan package:install caouecs/clef` ; the lists of providers and aliases will be up-to-date.

Next, you must migrate config :

    php artisan config:publish caouecs/clef

## Configuration file

After installation, the config file is located at *app/config/packages/caouecs/clef/clef.php*.

You can define :

* the app_id of your application
* the app_secret of your application

You can add an application in [Clef.io](https://getclef.com/developer/).

## Clef class

* logout : response to Logout Webhook from Clef.io
* authorize : return authorization from Clef.io for an account
* info : return info about membre from Clef.io
* authentication : get authentication of a Clef account
* button : display button for Login, by javascript
* customButtom : display custom button for Login

## Todo

* example of controller class for login, identification and logout
