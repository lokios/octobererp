from django.shortcuts import render
from django.http import HttpResponse

# Include the `fusioncharts.py` file that contains functions to embed the charts.
from ..fusioncharts import FusionCharts

# The `chart` function is defined to load data from a Python Dictionary. This data will be converted to
# JSON and the chart will be rendered in the browser.

def chart(request):
	
    # Create an object for the Multiseries column 2D charts using the FusionCharts class constructor
	mscol2D = FusionCharts("mscolumn2d", "ex1" , "600", "400", "chart-1", "json", 
            # The data is passed as a string in the `dataSource` as parameter.
    """{ 
            "chart": {
            "caption": "App Publishing Trend",
            "subCaption": "2012-2016",
            "xAxisName": "Years",
            "yAxisName" : "Total number of apps in store",
            "formatnumberscale": "1",
            "drawCrossLine":"1",
            "plotToolText" : "<b>$dataValue</b> apps on $seriesName in $label",
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
            },{
            "label": "2016"
            }
            ]
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
            },{
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
            },{
            "value": "900000"
            }]
        }]
    }""")
  
	return render(request, 'index.html', {'output': mscol2D.render(), 'chartTitle': 'Multiseries Column 2D Chart'})


