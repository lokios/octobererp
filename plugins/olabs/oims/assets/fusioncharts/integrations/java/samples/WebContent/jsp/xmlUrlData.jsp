<%@ page language="java" contentType="text/html; charset=ISO-8859-1"
    pageEncoding="ISO-8859-1"%>
 <%@page import="java.util.*" %>
<%@page import="fusioncharts.FusionCharts" %>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<title>FusionCharts | Chart using data from XML URL</title>
<link href="../Styles/ChartSampleStyleSheet.css" rel="stylesheet" />
<script type="text/javascript" src="//cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
   <script type="text/javascript" src="//cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>

</head>
<body>
 <h3>Chart using data from XML URL</h3>
<div id="column_chart"></div>
<div><span><a href="../Index.jsp">Go Back</a></span></div>
<%
        String xmlDataUrl;
		xmlDataUrl = "../Data/xmlData.xml";
    	
        FusionCharts column_chart = new FusionCharts(
      			  "column2d",
     		      "column",
     		      "700", 
     		      "400",
     		      "column_chart",
     		      "xmlurl",
     		     xmlDataUrl      		      
      			);
        %>
   
		<%=column_chart.render()%>
</body>

</html>