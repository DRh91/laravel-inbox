# Laravel-Inbox

Adds a very basic messaging system with inbox functionality to a laravel project. 

## Requirements

This package needs the laravel authentication (https://laravel.com/docs/5.8/authentication) to work.
1) run `php artisan make:auth` 
2) change `$table->bigIncrements('id');` to `$table->increments('id');` in your users table migration to avoid errors on database migration.

## Install

1)	`composer require drhd/inbox` 
2)	add `drhd\inbox\InboxServiceProvider::class` to app.php providers
3)  run `php artisan make:auth` if not done yet
5)	migrate your database with `php artisan migrate` 
6)	publish the package views: `php artisan vendor:publish`
7)  add hasInbox trait to users model: `use hasInbox;`

## Usage 

To send a message go to /inbox/create and submit the form. This will send a message to the given receiver. The name of the receiver is the column 'name' in users table.
To view your conversations go to /inbox.
