require 'json'

class Mscolumn2d

    def self.getChart

        chartData = {
            "chart": {
              "caption": "App Publishing Trend",
              "subCaption": "2012-2016",
              "xAxisName": "Years",
              "yAxisName": "Total number of apps in store",
              "drawCrossLine": "1",
              "plotToolText": "<b>$dataValue</b> apps on $seriesName in $label",
              "theme": "fusion"
            },
      
            "categories": [{
              "category": [{
                "label": "2012"
              }, {
                "label": "2013"
              }, {
                "label": "2014"
              }, {
                "label": "2015"
              }, {
                "label": "2016"
              }]
            }],
            "dataset": [{
              "seriesname": "iOS App Store",
              "data": [{
                "value": "125000"
              }, {
                "value": "300000"
              }, {
                "value": "480000"
              }, {
                "value": "800000"
              }, {
                "value": "1100000"
              }]
            }, {
              "seriesname": "Google Play Store",
              "data": [{
                "value": "70000"
              }, {
                "value": "150000"
              }, {
                "value": "350000"
              }, {
                "value": "600000"
              }, {
                "value": "1400000"
              }]
            }, {
              "seriesname": "Amazon AppStore",
              "data": [{
                "value": "10000"
              }, {
                "value": "100000"
              }, {
                "value": "300000"
              }, {
                "value": "600000"
              }, {
                "value": "900000"
              }]
            }]
          }       

        # Chart rendering 
        chart = Fusioncharts::Chart.new({
                width: "700",
                height: "400",
                type: "mscolumn2d",
                renderAt: "chartContainer",
                dataSource: chartData
            })

    end
end