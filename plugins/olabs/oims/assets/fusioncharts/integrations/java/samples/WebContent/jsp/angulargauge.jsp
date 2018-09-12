<%@ page language="java" contentType="text/html; charset=ISO-8859-1"
    pageEncoding="ISO-8859-1"%>
     <%@page import="java.util.*" %>
<%@page import="fusioncharts.FusionCharts" %>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>FusionCharts | Angular Gauge</title>
<link href="../Styles/ChartSampleStyleSheet.css" rel="stylesheet" />
<script type="text/javascript" src="//cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
   <script type="text/javascript" src="//cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>
</head>
<body>
<h3>Angular Gauge</h3>
<div id="gauge"></div>
<div><span><a href="../Index.jsp">Go Back</a></span></div>
<%
        String jsonData;
        jsonData = "{        \"chart\": {            \"caption\": \"Nordstorm's Customer Satisfaction Score for 2017\",            \"lowerLimit\": \"0\",            \"upperLimit\": \"100\",            \"showValue\": \"1\",            \"numberSuffix\": \"%\",            \"theme\": \"fusion\",            \"showToolTip\": \"0\"        },        \"colorRange\": {            \"color\": [{                \"minValue\": \"0\",                \"maxValue\": \"50\",                \"code\": \"#F2726F\"            }, {                \"minValue\": \"50\",                \"maxValue\": \"75\",                \"code\": \"#FFC533\"            }, {                \"minValue\": \"75\",                \"maxValue\": \"100\",                \"code\": \"#62B58F\"            }]        },        \"dials\": {            \"dial\": [{                \"value\": \"81\"            }]        }    }";
    	
        FusionCharts gauge = new FusionCharts(
      			  "angulargauge",
     		      "angular_gauge",
     		      "400", 
     		      "400",
     		      "gauge",
     		      "json",
     		      jsonData      		      
      			);
        %>
   
		<%=gauge.render()%>
</body>
</html>