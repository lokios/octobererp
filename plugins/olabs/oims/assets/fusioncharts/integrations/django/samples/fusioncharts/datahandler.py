from django.shortcuts import render
from django.http import HttpResponse
from django.http import QueryDict
from fusioncharts.models import *

import json

def getdata(request):

    levelValueMapping = BuildColumnLevel()
    urlQueryString =  request.META['QUERY_STRING']
    drillLevel = getQueryStringValueByKey(urlQueryString, "drillLevel", "" )
    query = ""
    label = ""

    if not drillLevel:
        drillLevel = "1"
        # build custom query & parameter column to be fetch
        query = BuildQuery(levelValueMapping[int(drillLevel)])
    else:
        drillLevel = (int(drillLevel) + 1)
        label = getQueryStringValueByKey(urlQueryString, "label", "" )
        # build custom query 
        # parameter column to be fetch, previously clicked value, previous level column name
        query = BuildQuery(levelValueMapping[int(drillLevel)], label, levelValueMapping[int(drillLevel) - 1])

    
    # fetch chart data from DB data create chart compatible json
    chartJsonData = ProcessChartData(query, levelValueMapping[(int(drillLevel))], drillLevel, len(levelValueMapping))
    
    # send response
    return  HttpResponse(chartJsonData)


def getQueryStringValueByKey(queryString, searchKey, defaultValue):
    
    queryDict = QueryDict(queryString)

    for key, value in queryDict.items():
        if key.lower() == searchKey.lower():
            defaultValue = value
            break

    return defaultValue


def BuildColumnLevel():
    mapDict =	{
        1: "Region",
        2: "Country",
        3: "City"
    }
    return mapDict


def BuildQuery(columnName, parentValue=None, parentName=None):

    query = ""
        
    if parentValue is None:
        query = "select 1 as id," + columnName + ", SUM([TotalSales]) as [TotalSales]" + "from SalesRecord group by " + columnName
    else:
        query = "select 1 as id," + columnName + ", SUM([TotalSales]) as [TotalSales]" + "from SalesRecord where " + parentName + "= '" + parentValue + "' Group by " + columnName
    
    return query



def ProcessChartData(sqlQuery, columnName, drillLevel, maxLevel):

    # Chart data is passed to the `dataSource` parameter.
    dataSource = {}
    dataSource['chart'] = { 
        "caption" : "Total Sales by " + columnName,
        "xAxisName" : columnName,
        "yAxisName" : "Total Sales",
        "numberSuffix": "K",
        "theme": "fusion"
    }

    dataSource['data'] = []
    
    # Iterate rows by invoking 'RawQuerySet' in `SalesRecord` model and insert in to the `dataSource['data']` list.

    for key in SalesRecord.objects.raw(sqlQuery):
        data = {}
        # region-sales, country-sales, city-sales
        if str(drillLevel) == "1":
            data['label'] = key.Region
            data['value'] = key.TotalSales
            # Create link for each Region when a data plot is clicked.
            data['link'] = "newchart-jsonurl-/datahandler?" + "label=" + key.Region + "&drillLevel=" + str(drillLevel)
        elif str(drillLevel) == "2":
            data['label'] = key.Country
            data['value'] = key.TotalSales
            # Create link for each country when a data plot is clicked.
            data['link'] = "newchart-jsonurl-/datahandler?" + "label=" + key.Country + "&drillLevel=" + str(drillLevel)
        elif str(drillLevel) == "3":
            data['label'] = key.City
            data['value'] = key.TotalSales

        dataSource['data'].append(data)
        
    return json.dumps(dataSource)