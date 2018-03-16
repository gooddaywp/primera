
A WordPress starter theme with support for SCSS, PostCSS, ES2015, BrowserSync and Gulp.

---

**Note:** Using this theme requires you to have [Node.js](https://nodejs.org/) installed.

## Installation

**1st** Rename the theme's folder name to whatever suits your project is. Side note: Update conflicts
with themes from wordpress.org arise from themes having identical folder names. To avoid such conflicts
simply make sure that your theme's folder name is unique (e.g. via a prefix).

**2nd** Open `package.json` and change the package's `name` to match your theme's folder name. This is
done because your package's name must also be [unique](https://docs.npmjs.com/files/package.json#name).

**3rd** Find and replace all `primera` and `Primera` strings inside the theme's folder to suit your
project. Please only use alphabetic characters `a-zA-Z` and underscores `_`.

**4th** Open `css/style.css` and adjust the [header comment section](https://developer.wordpress.org/themes/basics/main-stylesheet-style-css/) to suit your project.
Please be sure to keep the version number as it is used throughout the theme.

**5th** Open your terminal and `cd` into the theme's folder. There you run `sudo npm install` and enter you computers admin password to install all node modules.

_Now you can run any of the following gulp commands._

## Gulp Commands

GulpJS is a task runner. Below is a list of tasks you can run inside your terminal.

**`gulp css`**
- Processes SCSS, PostCSS
- Concatenates and minifies all `css` files into `./style.css`
- Runs once

**`gulp js`**
- Processes ES2015 via [BabelJS](//babeljs.io/)
- Concatenates and minifies all `js` files into `./script.js`
- Runs once

**`gulp watch`**
- Listens for changes within any `php`, `js` or `css` file
- Applies `gulp css` or `gulp js` as needed
- Will reload the browser to reflect the changes
- Will keep running until you hit `crtl+c` within the terminal

**`gulp imgmin`**
- Optimizes all images that are inside the `img` folder
- Runs once

**`gulp potfile`**
- Create a `.pot` file to be used for translations
- Please see the Translation section below for more information
- Runs once

**`gulp build`**
- Runs `gulp css`, `gulp js`, `gulp imgmin` and `gulp potfile`
- Runs once

**`gulp`**
- Runs `gulp watch`
- Runs once

## SCSS & PostCSS Plugins

[SASS](//sass-lang.com/) or [SCSS](//sass-lang.com/) is a CSS extension that supplies some [really cool features](//sass-lang.com/guide/) to CSS.

[PostCSS](//postcss.org) is a JavaScript framework which processes CSS files. Primera includes the following PostCSS plugins.
- [CSSNext](//cssnext.io/)
- [PropertyLookup](//github.com/simonsmith/postcss-property-lookup)
- [Easings](https://www.npmjs.com/package/postcss-easings)
- [MQPacker](https://www.npmjs.com/package/css-mqpacker)

## ES2015 Resources

- https://laracasts.com/series/es6-cliffsnotes
- https://babeljs.io/learn-es2015/
- https://github.com/mbeaudru/modern-js-cheatsheet

## Translation

1) While developing, wrap any hard coded translatable text strings in their [appropriate WP function](https://developer.wordpress.org/themes/functionality/internationalization/#localization-functions).
2) Revisit `gulpfile.js` and make sure the `domain` property inside `wpPot()` matches your theme's text domain.
3) Run `gulp potfile` to create a `.pot` file inside the languages folder.
4) To translate the `.pot` file and create the necessary `.po` and `.mo` files, you can use either [Poedit](https://poedit.net/) or [Loco Translate](https://wordpress.org/plugins/loco-translate/).

Please visit the following link to learn more about internationalization (i18n):
https://developer.wordpress.org/themes/functionality/internationalization/

## Versioning
To update your themes version, as found inside the `style.css` file, simply bump the version inside your `package.json` file and run `gulp css` or `gulp build`.

## Browser Support
While writing CSS you do not need to worry about browser prefixes. The autoprefixer PostCSS plugin supplied via CSSNext will do that for you. To adjust which browsers you'd like to support you can simply change the `browserlist` inside `package.json` using [this guide](https://github.com/ai/browserslist).

Please also remember that [autoprefixer](https://autoprefixer.github.io/) can't help older browsers understand CSS properties which they simply do not support. A great place to check which browser supports what, have a look at: [caniuse.com](http://caniuse.com/).
