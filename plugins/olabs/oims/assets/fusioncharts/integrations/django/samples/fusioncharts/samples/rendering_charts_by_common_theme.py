from django.shortcuts import render
from django.http import HttpResponse

# Include the `fusioncharts.py` file which has required functions to embed the charts in html page
from ..fusioncharts import FusionCharts

# Loading Data from a Static JSON String
# It is a example to show a Overlapped Bar 2D and column 2d chart where data is passed as JSON string format.
# These charts are rendering with a common theme.
# The `chart` method is defined to load chart data from an JSON string.

def chart(request):
    # Create an object for the overlappedbar2d chart using the FusionCharts class constructor
  overlappedcolumn2d = FusionCharts("overlappedcolumn2d", "ex1" , "600", "400", "chart-1", "json", 
        # The data is passed as a string in the `dataSource` as parameter.
    """{  
          "chart": {
          "caption": "Split of Sales by Product Category",
          "subCaption": "5 top performing stores  - last month",
          "plotToolText": "<div><b>$label</b><br/>Product : <b>$seriesname</b><br/>Sales : <b>$$value</b></div>",
          "theme": "fusion"
          },
          "categories": [{
            "category": [{
              "label": "Garden Groove harbour"
            }, {
              "label": "Bakersfield Central"
            }, {
              "label": "Los Angeles Topanga"
            }, {
              "label": "Compton-Rancho Dom"
            }, {
              "label": "Daly City Serramonte"
            }]
          }],
          "dataset": [{
            "seriesname": "Non-Food Products",
            "data": [{
              "value": "28800"
            }, {
              "value": "25400"
            }, {
              "value": "21800"
            }, {
              "value": "19500"
            }, {
              "value": "11500"
            }]
          }, {
            "seriesname": "Food Products",
            "data": [{
              "value": "17000"
            }, {
              "value": "19500"
            }, {
              "value": "12500"
            }, {
              "value": "14500"
            }, {
              "value": "17500"
            }]
          }]
      }""")

    # Create an object for the column2d chart using the FusionCharts class constructor
  column2d = FusionCharts("column2d", "ex2" , "600", "400", "chart-2", "json", 
        # The data is passed as a string in the `dataSource` as parameter.
    """{  
          "chart":{  
            "caption":"Harry\'s SuperMart",
            "subCaption":"Top 5 stores in last month by revenue",
            "numberPrefix":"$",
            "theme": "fusion"
          },
          "data":[  
            {  
               "label":"Bakersfield Central",
               "value":"880000"
            },
            {  
               "label":"Garden Groove harbour",
               "value":"730000"
            },
            {  
               "label":"Los Angeles Topanga",
               "value":"590000"
            },
            {  
               "label":"Compton-Rancho Dom",
               "value":"520000"
            },
            {  
               "label":"Daly City Serramonte",
               "value":"330000"
            }
          ]
      }""")

    # returning complete JavaScript and HTML code, which is used to generate chart in the browsers. 
  return  render(request, 'chart-theme.html', {'output1' : overlappedcolumn2d.render(), 'output2' : column2d.render(),'chartTitle': 'Chart Themes'}) 
