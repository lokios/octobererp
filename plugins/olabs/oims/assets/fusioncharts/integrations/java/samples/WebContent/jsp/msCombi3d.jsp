<%@ page language="java" contentType="text/html; charset=ISO-8859-1"
    pageEncoding="ISO-8859-1"%>
     <%@page import="java.util.*" %>
<%@page import="fusioncharts.FusionCharts" %>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<title>FusionCharts | Multiseries Combination 3D Chart</title>
<link href="../Styles/ChartSampleStyleSheet.css" rel="stylesheet" />
<script type="text/javascript" src="//cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
   <script type="text/javascript" src="//cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>

</head>
<body>
<h3>Multiseries Combination 3D Chart</h3>
<div id="mscombi_3d"></div>
<div><span><a href="../Index.jsp">Go Back</a></span></div>
<%
        String jsonData;
        jsonData = "{      'chart': {        'caption': 'Salary Hikes by Country',        'subCaption': '2016 - 2017',        'showhovereffect': '1',        'numberSuffix': '%',        'rotatelabels': '1',        'theme': 'fusion'      },      'categories': [{        'category': [{          'label': 'Australia'        }, {          'label': 'New-Zealand'        }, {          'label': 'India'        }, {          'label': 'China'        }, {          'label': 'Myanmar'        }, {          'label': 'Bangladesh'        }, {          'label': 'Thailand'        }, {          'label': 'South Korea'        }, {          'label': 'Hong Kong'        }, {          'label': 'Singapore'        }, {          'label': 'Taiwan'        }, {          'label': 'Vietnam'        }]      }],      'dataset': [{        'seriesName': '2016 Actual Salary Increase',        'plotToolText' : 'Salaries increased by <b>$dataValue</b> in 2016',        'data': [{          'value': '3'        }, {          'value': '3'        }, {          'value': '10'        }, {          'value': '7'        }, {          'value': '7.4'        }, {          'value': '10'        }, {          'value': '5.4'        }, {          'value': '4.5'        }, {          'value': '4.1'        }, {          'value': '4'        }, {          'value': '3.7'        }, {          'value': '9.3'        }]      }, {        'seriesName': '2017 Projected Salary Increase',        'plotToolText' : 'Salaries expected to increase by <b>$dataValue</b> in 2017',        'renderAs': 'line',        'data': [{          'value': '3'        }, {          'value': '2.8'        }, {          'value': '10'        }, {          'value': '6.9'        }, {          'value': '6.7'        }, {          'value': '9.4'        }, {          'value': '5.5'        }, {          'value': '5'        }, {          'value': '4'        }, {          'value': '4'        }, {          'value': '4.5'        }, {          'value': '9.8'        }]      }, {        'seriesName': 'Inflation rate',        'plotToolText' : '$dataValue projected inflation',        'renderAs': 'area',        'showAnchors':'0',        'data': [{          'value': '1.6'        }, {          'value': '0.6'        }, {          'value': '5.6'        }, {          'value': '2.3'        }, {          'value': '7'        }, {          'value': '5.6'        }, {          'value': '0.2'        }, {          'value': '1'        }, {          'value': '2.6'        }, {          'value': '0'        }, {          'value': '1.1'        }, {          'value': '2.4'        }]      }]    }";
    	
        FusionCharts column_chart = new FusionCharts(
      			  "mscombi3d",
     		      "combi_chart",
     		      "700", 
     		      "400",
     		      "mscombi_3d",
     		      "json",
     		      jsonData      		      
      			);
        %>
   
		<%=column_chart.render()%>
</body>
</html>