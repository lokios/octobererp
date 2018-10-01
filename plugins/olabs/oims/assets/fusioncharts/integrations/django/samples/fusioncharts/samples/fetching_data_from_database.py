from django.shortcuts import render
from django.http import HttpResponse

# Include the `fusioncharts.py` file that contains functions to embed the charts.
from ..fusioncharts import FusionCharts

from ..models import *

# The `chart` function is defined to load data from a Python Dictionary. This data will be converted to
# JSON and the chart will be rendered.

def chart(request):
	# Chart data is passed to the `dataSource` parameter, as dict, in the form of key-value pairs.
	dataSource = {}
	dataSource['chart'] = { 
		"caption" : "Top 10 Most Populous Countries",
		"theme":"fusion"
		}
   
    # Convert the data in the `actualData` array into a format that can be consumed by FusionCharts. 
    # The data for the chart should be in an array wherein each element of the array is a JSON object
    # having the `label` and `value` as keys.

	dataSource['data'] = []
    # Iterate through the data in `Country` model and insert in to the `dataSource['data']` list.
	for key in SalesRecord.objects.raw("select 1 as id, Region, SUM([TotalSales]) as [TotalSales] from SalesRecord group by Region"):
	  data = {}
	  data['label'] = key.Region
	  data['value'] = key.TotalSales
	  dataSource['data'].append(data)

    # Create an object for the Column 2D chart using the FusionCharts class constructor        	  		
	column2D = FusionCharts("column2D", "ex1" , "600", "400", "chart-1", "json", dataSource)
	return render(request, 'index.html', {'output': column2D.render(),'chartTitle': 'Chart Using Database (SQLite3)'})
