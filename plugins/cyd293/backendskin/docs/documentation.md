## Getting started

Creating a new skin for your backend need to have existing theme.

First you need to create **backend** folder in your own current theme.

## Folder structure

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

> **Remember**: laoyuts/default.htm in layout is the default layout use of all pages in backend.

#### Example 2

You want to change the partial in plugin.
All you need to do is to find the partial file and check where its located.

Lets use the rainlab user
if the page/partial is located at */plugins/rainlab/user/controllers/users/index.htm* now in your custom backend it will be located at *views/plugins/rainlab/user/controllers/users/index.htm*.

That it you can now edit the file and do what ever you want.

Everything will do in all assets and views.

## Notes

The theme will take effect immediately.

The question is how you will change your backend theme?
For now there are 2 methods.

First is to **change your theme**.

Second is to add query **_skin** in your url.
The **_skin** must be equal to your desired theme. This will not affect your front end theme.

The second method also will save a cookie so that if you will go to other page of your backend you dont need to add *_skin* query again.

To use the octobercms default skin, the value of **_skin** will be **octobercms**

## Feature Development

This version was just the core part of the plugin that will change all assets and pages that you want do change in your backend.

The next step for this is to provide you where you can easily switch backend theme via ui.

And for more feature I also planning to add an editor where you can edit via backend.

To contribute for this plugin. Just checkout the plugin from https://github.com/cydrickn/octobercms-backendskin.

## Happy coding guys.
