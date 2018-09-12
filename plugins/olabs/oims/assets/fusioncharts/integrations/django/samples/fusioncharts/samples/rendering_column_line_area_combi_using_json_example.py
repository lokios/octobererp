from django.shortcuts import render
from django.http import HttpResponse

# Include the `fusioncharts.py` file which has required functions to embed the charts in html page
from ..fusioncharts import FusionCharts

# Loading Data from a Static JSON String
# It is a example to show a MsCombi 3D chart where data is passed as JSON string format.
# The `chart` method is defined to load chart data from an JSON string.

def chart(request):

    # Create an object for the mscombi3d chart using the FusionCharts class constructor
    mscombi3dChart = FusionCharts("mscombi3d", "ex3", "100%", 400, "chart-1", "json",
    # The data is passed as a string in the `dataSource` as parameter.
    """{ 
        "chart": {
        "caption": "Salary Hikes by Country",
        "subCaption": "2016 - 2017",
        "numberSuffix": "%",
        "rotatelabels": "1",
        "theme": "fusion"
      },
      "categories": [{
        "category": [{
          "label": "Australia"
        }, {
          "label": "New-Zealand"
        }, {
          "label": "India"
        }, {
          "label": "China"
        }, {
          "label": "Myanmar"
        }, {
          "label": "Bangladesh"
        }, {
          "label": "Thailand"
        }, {
          "label": "South Korea"
        }, {
          "label": "Hong Kong"
        }, {
          "label": "Singapore"
        }, {
          "label": "Taiwan"
        }, {
          "label": "Vietnam"
        }]
      }],
      "dataset": [{
        "seriesName": "2016 Actual Salary Increase",
        "plotToolText" : "Salaries increased by <b>$dataValue</b> in 2016",
        "data": [{
          "value": "3"
        }, {
          "value": "3"
        }, {
          "value": "10"
        }, {
          "value": "7"
        }, {
          "value": "7.4"
        }, {
          "value": "10"
        }, {
          "value": "5.4"
        }, {
          "value": "4.5"
        }, {
          "value": "4.1"
        }, {
          "value": "4"
        }, {
          "value": "3.7"
        }, {
          "value": "9.3"
        }]
      }, {
        "seriesName": "2017 Projected Salary Increase",
        "plotToolText" : "Salaries expected to increase by <b>$dataValue</b> in 2017",
        "renderAs": "line",
        "data": [{
          "value": "3"
        }, {
          "value": "2.8"
        }, {
          "value": "10"
        }, {
          "value": "6.9"
        }, {
          "value": "6.7"
        }, {
          "value": "9.4"
        }, {
          "value": "5.5"
        }, {
          "value": "5"
        }, {
          "value": "4"
        }, {
          "value": "4"
        }, {
          "value": "4.5"
        }, {
          "value": "9.8"
        }]
      }, {
        "seriesName": "Inflation rate",
        "plotToolText" : "$dataValue projected inflation",
        "renderAs": "area",
        "showAnchors":"0",
        "data": [{
          "value": "1.6"
        }, {
          "value": "0.6"
        }, {
          "value": "5.6"
        }, {
          "value": "2.3"
        }, {
          "value": "7"
        }, {
          "value": "5.6"
        }, {
          "value": "0.2"
        }, {
          "value": "1"
        }, {
          "value": "2.6"
        }, {
          "value": "0"
        }, {
          "value": "1.1"
        }, {
          "value": "2.4"
        }]
      }]
    }""")
  
    # returning complete JavaScript and HTML code, which is used to generate chart in the browsers. 
    return  render(request, 'index.html', {'output' : mscombi3dChart.render(), 'chartTitle': 'Multiseries Combination 3D Chart'})
