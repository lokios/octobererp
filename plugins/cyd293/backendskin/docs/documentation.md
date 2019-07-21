## Getting started

Creating a new skin for your backend need to have existing theme.

First you need to create **backend** folder in your own current theme.

## Folder Structure

### Inside Current Folder structure

```
- theme
--- current_theme
----- backend
------- assets
------- config
------- layouts
------- views
--------- modules
----------- backend
----------- cms
----------- system
--------- plugins
```

### Folder Structure inside backendskin

As of version 1.1 you can now separate your backend skin from your theme.

```
- backendskins
--- <your-skin-code> # eg. myskin
----- assets
----- config
----- layouts
----- views
------- modules
--------- backend
--------- cms
--------- system
------- plugins
```

> ** Note: ** as default the skin code will use the current theme, lets say your current theme is `mytheme` your skin will be `mytheme`

> ** Note: ** All folders are optional, just add folder to what you need.

> ** Note: ** The plugin will not replace all file inside specific folder. The plugin will add a asset path and view paths if the file that you need was existing in your custom backend.

### Equivalent of the folders

**assets** : We request you to add this folder for your custom assets (eg. image, js, css).

**layouts** : This folder will contain your file where you add your own layout. This will be equivalent to **modules/backend/layouts**.

**views** : Here where all views and assets of each modules and plugins. Here you can change the controller partials and assets. And even widget assets and partials.

### How to customise

Customizing your backend is just easy, all you need to know is the file structure on where the view or asset is located.

> **Note:** Same location and same file name thats how you do it.

#### Example 1

You want to change the default in modules/backend/layouts/default.htm

All you need to do is to create new file in your layout folder namely default.htm and you can edit it now.

> **Remember**: layouts/default.htm in layout is the default layout use of all pages in backend.

#### Example 2

You want to change the partial in plugin.
All you need to do is to find the partial file and check where its located.

Lets use the rainlab user
if the page/partial is located at */plugins/rainlab/user/controllers/users/index.htm* now in your custom backend it will be located at *views/plugins/rainlab/user/controllers/users/index.htm*.

That it you can now edit the file and do what ever you want.

Everything will do in all assets and views.

## Defining your skin

### Using just the current theme

Normally backend skin using your current theme name.

Example if your theme name is `mytheme` this will be use also as your skin.

### Using Cookies

This method will only temporary cookie, this is only intended for testing specific skin.

To use this, first you need to add query **_skin** in your url.
The **_skin** must be equal to your desired skin code. This will not affect your front end theme.

This will create a new cookie named **backend_skin**

### Using Console

As of version 1.1 a new console command was added, `backendskin:skin:set

The command will only need one argument that argument was the `code`

```
php artisan backend:skin:set <yourskincode>
```

> This command will save a setting namely `cyd293.backendskin::skin.active`
> And the backend skin will always check this setting for your skin

### Using Config

As of version 1.1 you can now define a configuration for backend skin.

You need to create a file and folder `cyd293/backendskin/config.php` inside `config` folder of octobercms.

Inside `config.php`

```php
<?php

return [
    'activeSkin' => '<yourskincode>',
];
```

### The fallback skin

The fallback skin, All method of defining your skin code will only define the your desired skin.

But if the skin was not exists in both `backendskins` or `themes`, the skin will use the code `octobercms`,
means it will just use the default skin of OctoberCms.

#### The prioritization of checking the skin code

The below are the order of how the plugin will obtain skin code that will be use.

1. Input `_skin`
2. Cookies `backend_skin`
3. Setting `cyd293.backendskin::skin.active`
4. Config `cyd293.backendskin::activeSkin`
5. Current theme


## Feature Development

This version was just the core part of the plugin that will change all assets and pages that you want do change in your backend.

The next step for this is to provide you where you can easily switch backend theme via ui.

And for more feature I also planning to add an editor where you can edit via backend.

To contribute for this plugin. Just checkout the plugin from https://github.com/cydrickn/octobercms-backendskin.

## Happy coding guys.
