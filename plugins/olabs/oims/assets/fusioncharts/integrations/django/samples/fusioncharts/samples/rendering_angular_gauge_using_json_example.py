from django.shortcuts import render
from django.http import HttpResponse

# Include the `fusioncharts.py` file that contains functions to embed the charts.
from ..fusioncharts import FusionCharts

# Loading Data from a Static JSON String
# Example to create a Angular Gauge with the chart data passed as JSON string format.
# The `chart` method is defined to load chart data from a JSON string.

def chart(request):
      
    # Create an object for the angualar gauge using the FusionCharts class constructor
    angularGauge = FusionCharts("angulargauge", "ex1" , "450", "270", "chart-1", "json", 
        # The data is passed as a string in the `dataSource` as parameter.
        """{  
            "chart": {
                "caption": "Nordstorm's Customer Satisfaction Score for 2017",
                "lowerLimit": "0",
                "upperLimit": "100",
                "showValue": "1",
                "numberSuffix": "%",
                "theme": "fusion",
                "showToolTip": "0"
            },
            "colorRange": {
                "color": [{
                    "minValue": "0",
                    "maxValue": "50",
                    "code": "#F2726F"
                }, {
                    "minValue": "50",
                    "maxValue": "75",
                    "code": "#FFC533"
                }, {
                    "minValue": "75",
                    "maxValue": "100",
                    "code": "#62B58F"
                }]
            },
            "dials": {
                "dial": [{
                    "value": "81"
                }]
            }
        }""")
    # Alternatively, you can assign this string to a string variable in a separate JSON file
    # and pass the URL of that file to the `dataSource` parameter.
    return  render(request, 'index.html', {'output' : angularGauge.render(),'chartTitle': 'Angular Gauge'})