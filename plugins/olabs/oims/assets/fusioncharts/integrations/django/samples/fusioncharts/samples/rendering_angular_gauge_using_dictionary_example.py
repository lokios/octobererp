from django.shortcuts import render
from django.http import HttpResponse

# Include the `fusioncharts.py` file which has required functions to embed the widget in html page
from ..fusioncharts import FusionCharts
from collections import OrderedDict


# Loading Data from a Ordered Dictionary
# Example to create a Angular Gauge with the data passed as Dictionary format.
# The `chart` method is defined to load widget data from Dictionary.

def chart(request):

    # Load dial indicator values from simple string array
    # e.g. dialValues = ["52", "10", "81", "95"]
    dialValues = ["81"]

    # widget data is passed to the `dataSource` parameter, as dict, in the form of key-value pairs.
    dataSource = OrderedDict()

    # The `widgetConfig` dict contains key-value pairs data for widget attribute
    widgetConfig = OrderedDict()
    widgetConfig["caption"] = "Nordstorm's Customer Satisfaction Score for 2017"
    widgetConfig["lowerLimit"] = "0"
    widgetConfig["upperLimit"] = "100"
    widgetConfig["showValue"] = "1"
    widgetConfig["numberSuffix"] = "%"
    widgetConfig["theme"] = "fusion"
    widgetConfig["showToolTip"] = "0"


    # The `colorData` dict contains key-value pairs data for ColorRange of dial
    colorRangeData = OrderedDict()
    colorRangeData["color"] = [
        {
            "minValue": "0",
            "maxValue": "50",
            "code": "#F2726F"
        },
        {
            "minValue": "50",
            "maxValue": "75",
            "code": "#FFC533"
        },
        {
            "minValue": "75",
            "maxValue": "100",
            "code": "#62B58F"
        }
    ]

    # Convert the data in the `dialData` array into a format that can be consumed by FusionCharts. 
    dialData = OrderedDict()
    dialData["dial"] = []

    dataSource["chart"] = widgetConfig
    dataSource["colorRange"] = colorRangeData
    dataSource["dials"] = dialData

    
    # Iterate through the data in `dialValues` and insert in to the `dialData["dial"]` list.    
    # The data for the `dial` should be in an array wherein each element of the array is a JSON object
    # having the `value` as keys.
    for i in range(len(dialValues)):        
        dialData["dial"].append({"value": dialValues[i]})


    # Create an object for the angular-gauge using the FusionCharts class constructor
    # The widget data is passed to the `dataSource` parameter.
    angularChart = FusionCharts("angulargauge", "ex1", "100%", "200", "chart-1", "json", dataSource)

    # returning complete JavaScript and HTML code, which is used to generate widget in the browsers. 
    return  render(request, 'index.html', {'output' : angularChart.render(), 'chartTitle': 'Simple Widget Using Array'})