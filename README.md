Primera
=======

Primera is a WordPress theme with a modern development workflow.

**Table of Contents** <br>
- [Primera](#primera)
  - [Features](#features)
  - [Requirements](#requirements)
  - [Installation](#installation)
  - [Quick Start](#quick-start)
  - [Autoprefixer & CSS](#autoprefixer--css)
  - [Webpack & ES6](#webpack--es6)
  - [Mix & NPM Scripts](#mix--npm-scripts)
  - [Folder Structure](#folder-structure)
  - [App Files](#app-files)
  - [Controllers, Views & View Scripts](#controllers-views--view-scripts)
  - [AJAX Actions & REST Routes](#ajax-actions--rest-routes)
  - [Blade Templating](#blade-templating)
  - [Custom Blade Directives](#custom-blade-directives)
  - [Dotenv Configuration](#dotenv-configuration)
  - [Config Folder & Hierarchy](#config-folder--hierarchy)
  - [Helper Functions](#helper-functions)
  - [Translation](#translation)
  - [Still To-Do](#still-to-do)

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
- GPL Licensed

## Requirements

Make sure all dependencies have been installed before moving on.

- [WordPress](https://wordpress.org/) >= 5.4
- [PHP](https://www.php.net/manual/en/install.php) >= 7.3
- [Composer](https://getcomposer.org/download/)
- [Node.js](https://nodejs.org/en/) >= 12.0

## Installation

Download WordPress, either manually or via the terminal using [WP CLI](https://wp-cli.org/).

```shell
$ wp core download --path=my-project
```

Then open the themes directory in your terminal.

```shell
$ cd my-project/wp-content/themes
```

If you don't have [Composer](https://getcomposer.org/doc/00-intro.md) installed, go ahead and do that now. Then run the following command in your terminal.

```shell
$ composer create-project gooddaywp/primera my-theme-name
```

Last but not least, run the following command to install all NPM packages.

```shell
$ cd my-theme-name && npm install
```

Done.

## Quick Start

To take Primera for a spin, take the following steps after the installation is complete.

1. Search and replace `primeraTextDomain` with your preferred text domain
2. Open the `.env` file and adjust the values to fit your project
3. Run `npm start` in the terminal (from within this folder)
4. Visit the localhost URL displayed in the terminal

## Autoprefixer & CSS

Due to the Autoprefixer PostCSS plugin, there's no need for writing vendor prefixes in CSS. Browserlist is used to let you adjust which browsers you wish to support by modifying the `.browserlistrc` file using [this guide](https://github.com/ai/browserslist).

Please also remember that [Autoprefixer](https://autoprefixer.github.io/) can't help older browsers understand CSS properties which they simply do not support. For a great place to check which browser supports what, visit [caniuse.com](http://caniuse.com/).

## Webpack & ES6

Primera enables you to use all ES6 features via Laravel Mix and Webpack. If you are new to ES6, below are helpful links to get you started.

- https://github.com/mbeaudru/modern-js-cheatsheet
- https://babeljs.io/learn-es2015/

## Mix & NPM Scripts

Primera uses Laravel Mix, which is a wrapper around webpack. Mix makes it really easy to setup your module bundling and asset compilation. It's configuration file can be found at `./webpack.mix.js`. The NPM command `run` allow you to run any of the commands that are with the `"script"` section of you `package.json` file. Use the following commands to build, translate and develop your theme.

**`npm start`** <br>
Shortcut to run `npm run watch`.

**`dev`** or **`development`** <br>
Renders all assets uncompressed and without watching for changes.

**`prod`** or **`production`**<br>
Renders all assets compressed and without watching for changes.

**`watch`** <br>
Starts browsersync and renders all assets uncompressed. This task will keep watching for changes to your assets and refresh you browser window when changes are detected. The task can be exited via the keyboard shortcut `ctrl+c`.

**`pot`** <br>
Will create a `.pot` file with your languages directory. This file is used by WordPress to allow for translation.

**`zip`** <br>
Will run `build` before it can create a Zip file of your theme and place it within the directory you specified within the `.env` file.

**`build`** <br>
This will first run `npm prod`, then `npm pot` and then copy the files you specified with the `.env` to the directory you specified within the `.env` file. Thereafter this task will also create a Zip file of the current build.

## Folder Structure

**/app** <br>
This folder holds the template Controllers and theme helpers functions. This folder maps to the autoload PSR-4 setting within composer.

**/config** <br>
The config folder gives theme and plugin configuration examples as a staring point. Feel free to modify, remove or add as you please.

**/public** <br>
This folder holds assets such as images, fonts as well as compiled asset (CSS & JS) coming from the source folder. You can store other static assets in here as well.

**/source** <br>
The source folder holds assets that need compiling i.e. CSS, JS. The views folder holds the Blade template files which are also compiled/cached and are place in the directory specified via `/config/primera.php`.

**/tasks** <br>
This folder holds build scripts. They are placed into theme vs. an NPM package so you can modify them suit your project's needs.

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

Primera will also look for so called view scritps inside your public folder. Meaning, CSS or JS scritps with same name as the WP template (e.g. `front-page.css`) will get automatically enqueued on the front page template.

To make data available to the views, you simply create public functions within the Controllers. Each function with represent a variable that's passed to the view. All function names will be converted to `snake_case`. Meaning, `myCoolFnName` will become `my_cool_fn_name`. So it's probably best to write the fucntions with your Controllers in sanke case to not cause confusion later down the line.

Please have a look at the [soberwp/controller documentation](https://github.com/soberwp/controller/blob/master/README.md) to fully understand how they work.

## AJAX Actions & REST Routes

You are free to handle AJAX & REST any which way you like. However, Primera does offer a confient way to enqueue your REST routes and AJAX actions. In addition to [lifecycle methods](https://github.com/soberwp/controller/blob/master/README.md#lifecycles) of the Controllers, Primera adds two more lifecycle methods (`__ajax_actions` & `__rest_routes`) to ease including REST and AJAX callbacks.

Because the Controllers are loaded via WP's `init` action hook, these methods are also load via this hook. The `__rest_routes` method is then hooked via  `rest_api_init`. To separate asynchronous code from the rest of the Controller, an example using a [PHP trait](https://www.php.net/manual/en/language.oop5.traits.php) is supplied. However, you could also write the code directly into the Controller if you prefer.

Please note that all AJAX & REST callbacks are static. Controllers will not reveal static methods as data to your views. If the ajax/rest callbacks were defined as a normal public functions, their `die()` statements would break the page, since all public functions are automatically exposed to the respective view. Defining the function as static circumvents this, while still allowing the function to run.

## Blade Templating

Laravel's Blade templating is super easy to learn. Simply have a look at [the documentation](https://laravel.com/docs/6.x/blade) and the demo files within `/source/views` and you will be up and running in no time.

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
Displays all available variables wrapped with currly braces. Useful for grabbing all data supplied to your view and distributing it accross your template file.

**@codeif** <br>
Same as `@code` but with `@if` statements around the data.

## Dotenv Configuration

In Primera the `.env` file works a bit differently.

Dotenv files are often used for safe keeping of sensitive informaiton like API keys and are also *not* commited to version control (e.g. Github). Usually, these `.env` files hold information specific to the environment where your app or site lives.

Within this project `.env` files represent a singular point to set *not environment*, but **project specific** data that can be accessed via Node.js and PHP alike. The `.env` file can and should therefor also be commited to your version control system.

There are a couple important things to note regarding `.env` files within Primera.

- Please do **not** put sensitive information (e.g. API keys) into it
- Due to the dotenv NPM package, the following does not currently work
  - Line breaks are not supported, each value must be writen in one line
  - [Nesting variables](https://github.com/vlucas/phpdotenv#nesting-variables) is currently not possible
- Primera converts comma separated strings to arrays in PHP (e.g. `"one, two, three"` becomes `["one", "two", "three"]`)

## Config Folder & Hierarchy

Primera uses the composer package [`Brain\Hierarchy`](https://github.com/Brain-WP/Hierarchy). This package allows you check the template hierarchy within your theme's config (`/config`) and load different configurations for different templates. Below is an example of how to set this up.

```php
use Brain\Hierarchy\Hierarchy;
$templates = (new Hierarchy)->getTemplates($GLOBALS['wp_query']);
if (in_array('archive', $templates)) {
    // code for archive.php
}
```

## Helper Functions

Primera comes with a couple of helper functions to make your life a bit easier. These functions can be found with the `/app` folder.

Most of Laravel's helpers functions are also available within Primera. To learn more about them, please visit the [documentation](https://laravel.com/docs/6.x/helpers) or have a look at the source code (`./vendor/illuminate/support/helpers.php`).

## Translation

Translateble strings need to be defined in the controllers due to how wp-pot node module works. It cannot read blade files because it doesn't recognize blade as PHP.

## Still To-Do

- [ ] Create proper comments example at `/source/views/components/comments.blade.php`
- [ ] Add config code to prevent theme updates from WP.org
- [ ] Zip task must first run build task if no build exists
- [ ] Add `composer validate --no-check-all --strict` to build script to ensure composer json and lock file are identical
- [ ] Create more useful starting setup for views
- [ ] Find better solution for shared config file than .env, or [make .env more secure](https://github.com/wecodemore/wpstarter/issues/64)
- [ ] Add replace-in-file node module to repalce certain strings like text-domain (useful for install or build process)
- [ ] Add notes about using WooCommerce blade templates
- [ ] Use [WP CLI command](https://developer.wordpress.org/block-editor/developers/internationalization/#create-translation-file) `$ wp i18n make-pot` instead of NPM module
- [ ] Add to PostCSS: http://preset-env.cssdb.org/
