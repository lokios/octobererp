from django.shortcuts import render
from django.http import HttpResponse

# Include the `fusioncharts.py` file that contains functions to embed the charts.
from ..fusioncharts import FusionCharts
from collections import OrderedDict

# Loading Data from a Ordered Dictionary
# Example to create a World Map with the chart data passed as Dictionary format.
# The `chart` method is defined to load chart data from Dictionary.

def chart(request):

  # Chart data is passed to the `dataSource` parameter, as dict, in the form of key-value pairs.
  dataSource = OrderedDict()

  # The `mapConfig` dict contains key-value pairs data for chart attribute
  mapConfig = OrderedDict()
  mapConfig["caption"] = "Average Annual Population Growth"
  mapConfig["subcaption"] = "1955-2015"
  mapConfig["numbersuffix"] = "%"
  mapConfig["includevalueinlabels"] = "1"
  mapConfig["labelsepchar"] = ":"
  mapConfig["theme"] = "fusion"

  # Map color range data
  colorDataObj = { "minvalue": "0", "code" : "#FFE0B2", "gradient": "1",    
    "color" : [
        { "minValue" : "0.5", "maxValue" : "1", "code" : "#FFD74D" },
        { "minValue" : "1.0", "maxValue" : "2.0", "code" : "#FB8C00" },
        { "minValue" : "2.0", "maxValue" : "3.0", "code" : "#E65100" }
    ]
  }

  dataSource["chart"] = mapConfig
  dataSource["colorrange"] = colorDataObj
  dataSource["data"] = []


  # Map data array
  mapDataArray = [
    ["NA", "0.82", "1"],
    ["SA", "2.04", "1"],
    ["AS", "1.78", "1"],
    ["EU", "0.40", "1"],
    ["AF", "2.58", "1"],
    ["AU", "1.30", "1"]
  ]


  # Iterate through the data in `mapDataArray` and insert in to the `dataSource["data"]` list.    
  # The data for the `data` should be in an array wherein each element of the array is a JSON object
  # having the `id`, `value` and `showlabel` as keys.
  for i in range(len(mapDataArray)):        
      dataSource["data"].append({"id": mapDataArray[i][0], "value": mapDataArray[i][1], "showLabel": mapDataArray[i][2] })

  # Create an object for the world map using the FusionCharts class constructor  
  # The chart data is passed to the `dataSource` parameter.
  fusionMap = FusionCharts("maps/world", "ex1" , "650", "450", "chart-1", "json", dataSource)

  # returning complete JavaScript and HTML code, which is used to generate map in the browsers. 
  return  render(request, 'index.html', {'output' : fusionMap.render(), 'chartTitle': 'Simple Map Using Array'})
