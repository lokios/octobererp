<%@ page language="java" contentType="text/html; charset=ISO-8859-1"
    pageEncoding="ISO-8859-1"%>
 <%@page import="java.util.*" %>
<%@page import="fusioncharts.FusionCharts" %>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<title>FusionCharts | Multiseries Column 2D Chart</title>
<link href="../Styles/ChartSampleStyleSheet.css" rel="stylesheet" />
<script type="text/javascript" src="//cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
   <script type="text/javascript" src="//cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>

</head>
<body>
<h3>Multiseries Column 2D Chart</h3>
<div id="mscolumn_chart"></div>
<div><span><a href="../Index.jsp">Go Back</a></span></div>
<%
        String jsonData;
        jsonData = "{      'chart': {        'caption': 'App Publishing Trend',        'subCaption': '2012-2016',        'xAxisName': 'Years',        'yAxisName' : 'Total number of apps in store',        'formatnumberscale': '1',        'drawCrossLine':'1',        'plotToolText' : '<b>$dataValue</b> apps on $seriesName in $label','theme': 'fusion'      },      'categories': [{        'category': [{          'label': '2012'        }, {          'label': '2013'        }, {          'label': '2014'        }, {          'label': '2015'        },{        'label': '2016'        }        ]      }],      'dataset': [{        'seriesname': 'iOS App Store',        'data': [{          'value': '125000'        }, {          'value': '300000'        }, {          'value': '480000'        }, {          'value': '800000'        }, {          'value': '1100000'        }]      }, {        'seriesname': 'Google Play Store',        'data': [{          'value': '70000'        }, {          'value': '150000'        }, {          'value': '350000'        }, {          'value': '600000'        },{          'value': '1400000'        }]      }, {        'seriesname': 'Amazon AppStore',        'data': [{          'value': '10000'        }, {          'value': '100000'        }, {          'value': '300000'        }, {          'value': '600000'        },{          'value': '900000'        }]      }]    }";
    	
        FusionCharts column_chart = new FusionCharts(
      			  "mscolumn2d",
     		      "ms_column",
     		      "700", 
     		      "400",
     		      "mscolumn_chart",
     		      "json",
     		      jsonData      		      
      			);
        %>
   
		<%=column_chart.render()%>
</body>

</html>