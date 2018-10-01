# Fusioncharts Exporter Handler

FusionCharts export handler for Ruby on Rails.

# Version 

2.0

## Installation

Add this line to your application's Gemfile:
```
gem 'fusioncharts_exporter'
```

And then execute:
```
$ bundle
```

## Introduction

### What is it?
FusionCharts Suite XT uses JavaScript to generate charts in the browser, using SVG and VML (for older IE). If you need to export the charts as images or PDF, you need a server-side helper library to convert the SVG to image/PDF. These export handlers allow you to take the SVG from FusionCharts charts and convert to image/PDF.

### How does the export handler work?
- A chart is generated in the browser. When the export to image or PDF button is clicked, the chart generates the SVG string to represent the current state and sends to the export handler. The export handler URL is configured via chart attributes.
- The export handler accepts the SVG string along with chart configuration like chart type, width, height etc., and uses [RMagick](http://rmagick.rubyforge.org/) library to convert to image or PDF.
- The export handler either writes the image or PDF to disk, based on the configuration provided by chart, or streams it back to the browser.

## Pre-requisites
You will have to install the following applications without which the exporter will fail to run.

-  [RMagick](http://rmagick.rubyforge.org/)

## RMagick Installation

 Dependencies to run the this controller

 - rmagick
 - json

 Installing rmagick in ubuntu
 1. First, check that the universe repository is enabled by inspecting '**/etc/apt/sources.list**' with your favourite editor.

 2. You will need to use **_sudo_** to ensure that you have permissions to edit the file.

 3. If universe is not included then modify the file so that it does.

 4. deb http://us.archive.ubuntu.com/ubuntu precise main universe
 5. After any changes you should run this command to update your system.

 6. **_sudo apt-get update_**
 7. You can now install the package like this.

 8. Install librmagick-ruby
    **_sudo apt-get install librmagick-ruby_**

 10. Add this line to your application’s gemfile
 11. **_gem "rmagick", "~> 2.13.1"_** 

## Configuration
The following are the configurables to be modified as required in the `app/controllerfc_exporter_controller.rb`:


Location on the server where the image will be saved.
`save_path`



## Mount the application
You will have to specify the end point of the export server. In order to do this, you will have to mount the export handler to your rails application. Add the following lines in `config/routes.rb`.

For eg., if you want your export server hosted at `http://<my-website>/export`, then add the following lines:
```
  post 'fc_exporter/init'
  get 'fc_exporter/init'
```

## Contributing and Testing

1. Clone the repository: `TODO`
2. Run `bundle install`
3. Run `rails server`
