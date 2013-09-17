
=======
helperapp
=========

A mobile web app for fast and efficient helper coordination

Koordinationsapp bei Hochwasserkatastrophen


## Installation

[Official Laravel Installation guide](http://laravel.com/docs/installation)

Install Laravel dependencies

    composer update

local Environment in `/bootstrap/start.php` Line 32

    // Replace machinename through the name of your local development-environment
    'local-machinename' => array('MACHINE-NAME'),
 
Migrate database

    php artisan migrate --seed

Start integrated webserver (if no other (or vhost) installed)

    php artisan serve

## Authors

Idea and initial implementation
Philipp Zentner (http://philippzentner.com)

Further development and Laravel implementation
Max Klenk (https://github.com/maxklenk)

## Story

Philipp was victim of the flood (2.6. & 3.6. 2013) in Passau, Germany by himself.
He developed the helper-app in adversity. Soon the University of Passau and the city of Passau
used the app to coordinate helper and helper-requests.
Other cities followed.

A few weeks later Max Klenk converted the self-written backend into the PHP framework Laravel
and improved the apps security, performance and also the frontend.
