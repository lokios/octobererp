from django.shortcuts import render
from django.http import HttpResponse

# Include the `fusioncharts.py` file that contains functions to embed the charts.
from ..fusioncharts import FusionCharts

# The `chart` function is defined to load data from a Python Dictionary. This data will be converted to
# JSON and the chart will be rendered in the browser.

def chart(request):
	
    # Create an object for the Multiseries column 2D charts using the FusionCharts class constructor
	mscol2D = FusionCharts("stackedColumn2DLine", "ex1" , "600", "400", "chart-1", "json", 
            # The data is passed as a string in the `dataSource` as parameter.
    """{ 
            "chart": {
            "showvalues": "0",
            "caption": "Apple's Revenue & Profit",
            "subCaption": "(2013-2016)",
            "numberprefix": "$",
            "numberSuffix" : "B",
            "plotToolText" : "Sales of $seriesName in $label was <b>$dataValue</b>",
            "showhovereffect": "1",
            "yaxisname": "$ (In billions)",
            "showSum":"1",
            "theme": "fusion"
        },
        "categories": [{
            "category": [{
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
            "seriesname": "iPhone",
            "data": [{
            "value": "21"
            }, {
            "value": "24"
            }, {
            "value": "27"
            }, {
            "value": "30"
            }]
        }, {
            "seriesname": "iPad",
            "data": [{
            "value": "8"
            }, {
            "value": "10"
            }, {
            "value": "11"
            }, {
            "value": "12"
            }]
        }, {
            "seriesname": "Macbooks",
            "data": [{
            "value": "2"
            }, {
            "value": "4"
            }, {
            "value": "5"
            }, {
            "value": "5.5"
            }]
        }, {
            "seriesname": "Others",
            "data": [{
            "value": "2"
            }, {
            "value": "4"
            }, {
            "value": "9"
            }, {
            "value": "11"
            }]
        }, {
            "seriesname": "Profit",
            "plotToolText" : "Total profit in $label was <b>$dataValue</b>",
            "renderas": "Line",
            "data": [{
            "value": "17"
            }, {
            "value": "19"
            }, {
            "value": "13"
            }, {
            "value": "18"
            }]
        }]
    }""")
  
	return render(request, 'index.html', {'output': mscol2D.render(), 'chartTitle': 'Stacked Column 2D with Line Chart'})


