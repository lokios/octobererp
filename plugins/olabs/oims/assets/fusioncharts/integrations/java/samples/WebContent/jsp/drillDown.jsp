<%@page import="com.mysql.jdbc.Driver"%>
<%@ page language="java" contentType="text/html; charset=ISO-8859-1"
    pageEncoding="ISO-8859-1"%>
<%@page import="java.util.*" %>
<%@page import="fusioncharts.FusionCharts" %>
<%@page import="java.sql.*" %>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<title>FusionCharts | Chart with Drill-Down Feature</title>
<link href="../Styles/ChartSampleStyleSheet.css" rel="stylesheet" />
<script type="text/javascript" src="//cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
   <script type="text/javascript" src="//cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>

</head>
<body>
<h3>Chart with Drill-Down Feature</h3>
<div id="drilldown_enabled_chart"></div>
<div><span><a href="../Index.jsp">Go Back</a></span></div>
<%

//Create chart instance
// charttype, chartID, width, height,containerid, data format, data
FusionCharts firstChart = new FusionCharts(
		  "column2d", 
		  "drilldown_chart", 
		  "800",
		  "550", 
		  "drilldown_enabled_chart",
		  "jsonurl", 
		  "Handler/RequestHandler.jsp"
);
%>
<%=firstChart.render() %>
</body>

</html>