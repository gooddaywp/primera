
# Primera

Primera is an WordPress theme with a modern development workflow.

## Features

- Laravel's Blade templating engine
- Laravel's Mix webpack wrapper
- Controllers for template data passing
- Modern JavaScript via Babel.js
- Modern CSS via Sass, Less, Stylus or PostCSS
- Autoprefixer and Browserlist
- Browsersync live updates
- Composer and NPM package managers
- Composer PSR-4 autoloader
- Build scripts for zip and pot files
- Single point Dotenv configuration

## Requirements

Make sure all dependencies have been installed before moving on.

- [WordPress](https://wordpress.org/) >= 5.4
- [PHP](https://www.php.net/manual/en/install.php) >= 7.3
- [Composer](https://getcomposer.org/download/)
- [Node.js](https://nodejs.org/en/) >= 12.0.0

## Installation

1. Download WordPress, either manually or via WP CLI, if installed.
```shell
wp core download
```
2. Open the themes directory inside your WordPress installation.
```shell
cd wp-content/themes
```
3. If you don't have [Composer](https://getcomposer.org/doc/00-intro.md) installed, go ahead and do that now. Then run the following command in your terminal.
```shell
composer create-project gooddaywp/primera my-theme-name
```

This will install all PHP and NPM dependencies for you. It will also copy the **.env.example** file to **.env**.

## Folder Structure

**/app** <br>
This folder holds the template Controllers and theme helpers functions. This folder maps to the autoload PSR-4 setting within composer.

**/config** <br>
The config holds the theme and plugin configuration.

**/public** <br>
This folder holds assets such as images, fonts as well as compiled asset (CSS & JS) coming from the source folder.

**/source** <br>
The source folder holds assets that need compiling i.e. CSS, JS and the Blade template files inside of the views folder.

**/tasks** <br>
This folder holds build scripts written in Node.js. They are placed into theme so you can modify them suit your project's needs.

**/templates** <br>
The template folder holds custom WordPress page tempaltes.

## App Files

Throughout the theme, "app" files are used to handle data that's ment to be applied to the theme globally.

**/app/Controllers/App.php** <br>
This file supplies values globally to all Blade templates.

**/source/css/app.css** & **/source/js/app.js** <br>
These files compile global JS & CSS.

**/source/views/app.blade.php** <br>
This is the main template file that other views are extending.

## Controllers, Views & View Scripts

Controller class names follow the same hierarchy as WordPress. Meaning, to create a controller for the `front-page.php` WordPress template, you would create a Controller with the class name `FrontPage.php` inside the Controllers folder. The controller will automatically be loaded for this template file.

Primera will tell WP to look for the coresponding Blade template (<abbr title="also known as">AKA</abbr> view) inside the views directory. The template name does not need to be modified. Meaning, `front-page.php` or `front-page.blade.php` will both work.

If you prefer to use the default WordPress template, simply place it into the root level of your WP theme. However, Controllers and Blade templating won't work in this case.

Primera will also look for so called view scritps inside your public folder. Meaning, CSS or JS scritps (e.g. `front-page.css`) with same name as the WP template will get automatically enqueued on the front page template.

To make data available to the views, you simply create public functions within the Controllers. Each function with represent a variable that's passed to the view. All function names will be converted to `snake_case`. Meaning, `myCoolFnName` will become `my_cool_fn_name`. So it's probably best to write the fucntions with your Controllers in sanke case to not cause confusion later down the line.

Please have a look at the [soberwp/controller documentation](https://github.com/soberwp/controller/blob/master/README.md) to fully understand how they work.

## AJAX Actions & REST Routes

You are free to handle AJAX and REST any which way you like. However, Primera does offer a confient way to enqueue your REST routes and AJAX actions. In addition to [lifecycle methods](https://github.com/soberwp/controller/blob/master/README.md#lifecycles) of the Controllers, Primera adds two more lifecycle methods (`__ajax_actions` & `__rest_routes`) to ease including REST and AJAX callbacks.

Because the Controllers are loaded via WP's `init` action hook, these methods are also load via this hook. The `__rest_routes` method is then hooked via  `rest_api_init`. To separate asynchronous code from the rest of the Controller, an example using a [PHP trait](https://www.php.net/manual/en/language.oop5.traits.php) is supplied. However, you could also write the code directly into the Controller if you prefer.

Please note that all AJAX & REST callbacks are static. Controllers will not reveal static methods as data to your views.

## Blade Templating

Blade templating is easy to learn. Simply have a look at [the documentation](https://laravel.com/docs/6.x/blade) and the demo files within `/source/views`.

## Custom Blade Directives

Blade templating allows for the creation of custom directives, and component aliases. To see a demo on how this works, have a look at `/config/primera.php`.

The composer package `primera-lib` already adds the following directives to be used within Blade templates.

**@dump(__var__)** <br>
Displays the contents of the variable.

**@dd(__var__)** <br>
Displays the contents of the variable and exits the script via `die()`.

**@debug** <br>
Displays all Controller data on the page.

**@code** <br>
Display all available variables wrapped with currly braces. Useful to grab all data supplied to your view and drop to that into your template.

**@codeif** <br>
Same as `@code` but with `@if` statements around the data.

## Dotenv Configuration

## Getting Up To Speed With Modern PHP

https://www.smashingmagazine.com/2019/02/wordpress-modern-php/



