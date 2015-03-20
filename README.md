# Postal

Simple usage of the postal codes and places for norwegian places.

Installation
------------

Install using composer:

    composer require anunatak/postal

This package is compatible with Laravel 5.

Add the service provider in `config/app.php`:

    'Anunatak\Postal\PostalServiceProvider',

And add an alias in the same file:

    'Postal'            => 'Anunatak\Postal\Postal',

Publish the migration for the data
	
	php artisan vendor:publish

Migrate the database

	php artisan migrate

Run an update of the postal codes

	php artisan postal:update
    
Usage
-----

Really just one simple function:

	$place = Postal::getPlace('6300'); // returns string: 'Åndalsnes' 

