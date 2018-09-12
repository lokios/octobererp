"""fusioncharts URL Configuration

The `urlpatterns` list routes URLs to views. For more information please see:
    https://docs.djangoproject.com/en/dev/topics/http/urls/
Examples:
Function views
    1. Add an import:  from samples import views
    2. Add a URL to urlpatterns:  url(r'^$', views.home, name='home')
"""
from django.urls import path
from django.conf.urls import url
from django.contrib import admin
from fusioncharts.views import catalogue

from fusioncharts.samples import rendering_angular_gauge_using_dictionary_example, rendering_column2d_chart_using_dictionary_example
from fusioncharts.samples import rendering_map_using_dictionary_example, rendering_multiseries_column2d_chart_using_json_example
from fusioncharts.samples import rendering_multiseries_StackedColumn2dline_using_json_example, rendering_pie3d_using_json_example
from fusioncharts.samples import rendering_column_line_area_combi_using_json_example, rendering_map_using_json_example
from fusioncharts.samples import rendering_angular_gauge_using_json_example, client_side_chart_export
from fusioncharts.samples import fetching_json_data_from_url, fetching_xml_data_from_url, fetching_data_from_database
from fusioncharts.samples import drilldown_from_database_example, rendering_charts_by_common_theme
from fusioncharts.samples import export_chart_using_export_handler
from fusioncharts import datahandler

urlpatterns = [
    url(r'^$', catalogue),
    url(r'^admin/', admin.site.urls),
    url(r'^datahandler', datahandler.getdata),
    url(r'^rendering-angular-gauge-using-dictionary-example', rendering_angular_gauge_using_dictionary_example.chart, name='chart'),
    url(r'^rendering-angular-gauge-using-json-example', rendering_angular_gauge_using_json_example.chart, name='chart'),
    url(r'^rendering-column2d-chart-using-dictionary-example', rendering_column2d_chart_using_dictionary_example.chart, name='chart'),
    url(r'^rendering-map-using-dictionary-example', rendering_map_using_dictionary_example.chart, name='chart'),
    url(r'^rendering-map-using-json-example', rendering_map_using_json_example.chart, name='chart'),
    url(r'^rendering-multiseries-column2d-chart-using-json-example', rendering_multiseries_column2d_chart_using_json_example.chart, name='chart'),
    url(r'^rendering-multiseries-StackedColumn2dline-using-json-example', rendering_multiseries_StackedColumn2dline_using_json_example.chart, name='chart'),
    url(r'^rendering-pie3d-using-json-example', rendering_pie3d_using_json_example.chart, name='chart'),
    url(r'^rendering-column-line-area-combi-using-json-example', rendering_column_line_area_combi_using_json_example.chart, name='chart'),
    url(r'^client-side-chart-export', client_side_chart_export.chart, name='chart'),
    url(r'^fetching-json-data-from-url', fetching_json_data_from_url.chart, name='chart'),
    url(r'^fetching-xml-data-from-url', fetching_xml_data_from_url.chart, name='chart'),
    url(r'^fetching-data-from-database', fetching_data_from_database.chart, name='chart'),
    url(r'^drilldown-from-database-example', drilldown_from_database_example.chart, name='chart'),
    url(r'^rendering-charts-by-common-theme', rendering_charts_by_common_theme.chart, name='chart'),
    url(r'^export-chart-using-export-handler', export_chart_using_export_handler.chart, name='chart'),
    
]