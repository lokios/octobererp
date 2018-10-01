# Intro

Hey there! You're looking at the docs for an Official Bootstrap Theme—thanks for your purchase! This theme has been lovingly crafted by Bootstrap's founders and friends to help you build awesome projects on the web. Let's dive in.

Each theme is designed as it's own toolkit—a series of well designed, intuitive, and cohesive components—built on top of Bootstrap. If you've used Bootstrap itself, you'll find this all super familiar, but with new aesthetics, new components, beautiful and extensive examples, and easy-to-use build tools and documentation.

Since this theme is based on Bootstrap, and includes nearly everything Bootstrap itself does, you'll want to give the [official project documentation](http://getbootstrap.com) a once over before continuing. There's also [the kitchen sink]({{ relative }}bootstrap/index.html)—a one-page view of all Bootstrap's components restyled by this theme.

For everything else, including compiling and using this Bootstrap theme, read through the docs below.

Thanks, and enjoy!

# What's included

Within your Bootstrap theme you'll find the following directories and files, grouping common resources and providing both compiled and minified distribution files, as well as raw source files.

{% highlight bash %}
theme/
  ├── v3
  └── v4
      ├── gulpfile.js
      ├── package.json
      ├── README.md
      ├── docs/
      ├── scss/
      │   ├── bootstrap/
      │   ├── custom/
      │   ├── variables.scss
      │   └── toolkit.scss
      ├── js/
      │   ├── bootstrap/
      │   └── custom/
      ├── fonts/
      │   ├── bootstrap-entypo.eot
      │   ├── bootstrap-entypo.svg
      │   ├── bootstrap-entypo.ttf
      │   ├── bootstrap-entypo.woff
      │   └── bootstrap-entypo.woff2
      └── dist/
          ├── toolkit.css
          ├── toolkit.css.map
          ├── toolkit.min.css
          ├── toolkit.min.css.map
          ├── toolkit.js
          └── toolkit.min.js
{% endhighlight %}


## Getting started

At the top level of your bootstrap theme you'll find a directory for each major Bootstrap version that's supported (currently both `v3` and `v4`). Within each directory you have all the relevant files for that version.

To view your Bootstrap Theme documentation, simply find the docs directory and open index.html in your favorite browser.

{% highlight bash %}
$ open docs/index.html
{% endhighlight %}


## Gulpfile.js

If you're after more customization we've also included a custom [Gulp](http://gulpjs.com) file, which can be used to quickly re-compile a theme's CSS and JS. You'll need to install both [Node](https://nodejs.org/en/download/) and Gulp before using our included `gulpfile.js`.

Once node is installed, run the following npm command to install Gulp.

{% highlight bash %}
$ npm install gulp -g
{% endhighlight %}

When you're done, make sure you've installed the rest of the theme's dependencies:

{% highlight bash %}
$ npm install
{% endhighlight %}

Now, modify your source files and run `gulp` to generate new local `dist/` files automatically. **Be aware that this replaces existing `dist/` files**, so proceed with caution.

## Theme source code

The `scss/`, `js/`, and `fonts/` directories contain the source code for our CSS, JS, and icon fonts (respectively). Within the `scss/` and `js/` directories you'll find two subdirectories:

- `bootstrap/`, which contains the most recently released version of Bootstrap (v4.0.0).
- `custom/`, which contains all of the custom components and overrides authored specifically for this theme.

The `dist/` folder includes everything above, built into single CSS and JS files that can easily be integrated into your project.

The `docs/` folder includes the source code for our documentation, as well as a handful of live examples.

The remaining files not specifically mentioned above provide support for packages, license information, and development.


# Custom builds

Leverage the included source files and `gulpfile.js` to customize your Bootstrap Theme for your exact needs. Change variables, exclude components, and more.

- `toolkit-*.scss` is the entry point for Sass files - to build your own custom build, simply modify your local custom files or edit the includes listed here. Note: some themes also rely on a shared `components.scss` file, which you can find imported in your `toolkit-*.scss`.
- `variables.scss` is home to your theme's variables. Note that your theme's `variables` file depends on and overrides an existing Bootstrap variable file (found in `/scss/bootstrap/_variables.scss`).


# Basic template

The basic template is a guideline for how to structure your pages when building with a Bootstrap Theme. Included below are all the necessary bits for using the theme's CSS and JS, as well as some friendly reminders.

Copy the example below into a new HTML file to get started with it.

{% highlight html %}
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- These meta tags come first. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Bootstrap Theme Example</title>

    <!-- Include the CSS -->
    <link href="dist/toolkit.min.css" rel="stylesheet">

  </head>
  <body>
    <h1>Hello, world!</h1>

    <!-- Include jQuery (required) and the JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="dist/toolkit.min.js"></script>
  </body>
</html>
{% endhighlight %}
