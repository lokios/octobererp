<%@ page language="java" contentType="text/html; charset=ISO-8859-1"
    pageEncoding="ISO-8859-1"%>
<%@page import="java.util.*" %>
<%@page import="fusioncharts.FusionCharts" %>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<title>FusionCharts | Pie 3D Chart</title>
<link href="../Styles/ChartSampleStyleSheet.css" rel="stylesheet" />
<script type="text/javascript" src="//cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
   <script type="text/javascript" src="//cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>

</head>
<body>
 <h3>Pie 3D Chart</h3>
<div id="pie3d_chart"></div>
<div><span><a href="../Index.jsp">Go Back</a></span></div>
<%
        String jsonData;
        jsonData = "{      'chart': {        'caption': 'Recommended Portfolio Split',        'subCaption' : 'For a net-worth of $1M',        'showValues':'1',        'showPercentInTooltip' : '0',        'numberPrefix' : '$',        'enableMultiSlicing':'1',        'theme': 'fusion'      },      'data': [{        'label': 'Equity',        'value': '300000'      }, {        'label': 'Debt',        'value': '230000'      }, {        'label': 'Bullion',        'value': '180000'      }, {        'label': 'Real-estate',        'value': '270000'      }, {        'label': 'Insurance',        'value': '20000'      }]    }";
    	
        FusionCharts column_chart = new FusionCharts(
      			  "pie3d",
     		      "piechart",
     		      "400", 
     		      "400",
     		      "pie3d_chart",
     		      "json",
     		      jsonData      		      
      			);
        %>
   
		<%=column_chart.render()%>
</body>
</html>