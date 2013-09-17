
=======
helperapp
=========

A mobile web app for fast and efficient helper coordination

Koordinationsapp bei Hochwasserkatastrophen


## Installation

[offizielle Anleitung](http://laravel.com/docs/installation)

Laravel Depencies installieren

    composer update

local Environment in `/bootstrap/start.php` Zeile 32 einrichten

    // MACHINE-NAME durch name des Entwickungsrechners ersetzen
    'local-machinename' => array('MACHINE-NAME'),
 
Datenbank migrieren

    php artisan migrate --seed

Testserver starten

    php artisan serve
