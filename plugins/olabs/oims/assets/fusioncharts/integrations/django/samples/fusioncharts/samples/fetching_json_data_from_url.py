from django.shortcuts import render
from django.http import HttpResponse

# Include the `fusioncharts.py` file which has required functions to embed the charts in html page
from ..fusioncharts import FusionCharts

# Loading Data from a Static JSON String
# It is a example to show a Column 2D chart where data is passed as JSON string format.
# The `chart` method is defined to load chart data from an JSON string.

def chart(request):
  # Create an object for the column2d chart using the FusionCharts class constructor
  column2d = FusionCharts("column2d", "ex1" , "600", "400", "chart-1", "jsonurl","/static/data/data.json")
  
    # returning complete JavaScript and HTML code, which is used to generate chart in the browsers.
  return  render(request, 'index.html', {'output' : column2d.render(),'chartTitle': 'Chart using data from JSON URL'})
