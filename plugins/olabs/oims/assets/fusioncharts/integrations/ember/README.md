
#### [Demos and Documentation](https://fusioncharts.github.io/ember-fusioncharts/)

# Ember-Fusioncharts

A lightweight EmberJS component which provides bindings for FusionCharts JavaScript Charting Library. It easily adds rich and interactive charts to any ambitious Ember application.

## Installation

To install `ember-fusioncharts` to any existing ember project, run:

For Modern Ember CLI:
```bash
$ ember install ember-fusioncharts
```

For Earlier Ember CLI (and addon developers):
```bash
$ npm install ember-fusioncharts --save-dev
$ ember g ember-fusioncharts
```

Then import `fusioncharts` library to your `ember-cli-build.js` build file:
```javascript
/* eslint-env node */
'use strict';

const EmberApp = require('ember-cli/lib/broccoli/ember-app');

module.exports = function(defaults) {
  let app = new EmberApp(defaults, {
    // Add options here
  });

  // Import fusioncharts library
  app.import('bower_components/fusioncharts/fusioncharts.js');
  app.import('bower_components/fusioncharts/fusioncharts.charts.js');
  app.import('bower_components/fusioncharts/themes/fusioncharts.theme.fint.js');
  app.import('bower_components/fusioncharts/themes/fusioncharts.theme.ocean.js');

  // Use `app.import` to add additional libraries to the generated
  // output files.
  //
  // If you need to use different assets in different
  // environments, specify an object as the first parameter. That
  // object's keys should be the environment name and the values
  // should be the asset to use in that environment.
  //
  // If the library that you are including contains AMD or ES6
  // modules that you would like to import into your application
  // please specify an object with the list of modules as keys
  // along with the exports of each module as its value.

  return app.toTree();
};

```

## Getting Started

After installing `ember-fusioncharts`, create a simple component(e.g. `chart-viewer`, also you can use it anywhere in your application) to show your interactive charts, run:
```bash
$ ember g component chart-viewer
```

Write your chart logic in `chart-viewer.js` file:
```javascript
import Component from '@ember/component';

const myDataSource = {
    "chart": {
        "caption": "Harry's SuperMart",
        "subCaption": "Top 5 stores in last month by revenue",
        "numberPrefix": "$",
        "theme": "fint"
    },
    "data": [
        {
            "label": "Bakersfield Central",
            "value": "880000"
        },
        {
            "label": "Garden Groove harbour",
            "value": "730000"
        },
        {
            "label": "Los Angeles Topanga",
            "value": "590000"
        },
        {
            "label": "Compton-Rancho Dom",
            "value": "520000"
        },
        {
            "label": "Daly City Serramonte",
            "value": "330000"
        }
    ]
};

export default Component.extend({
    title: 'Ember FusionCharts Sample',
    width: 600,
    height: 400,
    type: 'column2d',
    dataFormat: 'json',
    dataSource: myDataSource
});
```

And use `fusioncharts-xt` component in your `chart-viewer.hbs` template to show your charts:
```html
<h1>{{ title }}</h1>

{{fusioncharts-xt
    width=width
    height=height
    type=type
    dataFormat=dataFormat
    dataSource=dataSource}}
```

Then, use `chart-viewer` component in your `application.hbs` template:

```html
{{chart-viewer}}

{{outlet}}
```

## Test

```sh
$ npm test
```

## Contributing

* Clone the repository.
* Install dependencies.
* Run `npm start` to start the dev server.
* Open `http://localhost:4200/` in your browser.

```sh
$ git clone https://github.com/fusioncharts/ember-fusioncharts.git
$ cd ember-fusioncharts
$ npm i && bower install
$ npm start
```

To build, run:
```sh
$ npm run build
```

### [Demos and Documentation](https://fusioncharts.github.io/ember-fusioncharts/)
