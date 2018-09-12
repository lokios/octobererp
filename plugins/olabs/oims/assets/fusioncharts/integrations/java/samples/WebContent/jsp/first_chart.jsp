<%@ page language="java" contentType="text/html; charset=ISO-8859-1"
    pageEncoding="ISO-8859-1"%>
<%@page import="java.util.*" %>
<%@page import="fusioncharts.FusionCharts" %>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<title>FusionCharts | Simple Chart Using Array</title>
<link href="../Styles/ChartSampleStyleSheet.css" rel="stylesheet" />
<script type="text/javascript" src="//cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
   <script type="text/javascript" src="//cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>

</head>
<body>
<h3>Simple Chart Using Array</h3>  
 <div id="chart"></div>
 <div><span><a href="../Index.jsp">Go Back</a></span></div>
 <%
 // store chart config name-config value pair
 Map<String, String> chartConfig = new HashMap<String, String>();
 chartConfig.put("caption", "Countries With Most Oil Reserves [2017-18]");
 chartConfig.put("subCaption", "In MMbbl = One Million barrels");
 chartConfig.put("xAxisName", "Country");
 chartConfig.put("yAxisName", "Reserves (MMbbl)");
 chartConfig.put("numberSuffix", "k");
 chartConfig.put("theme", "fusion");
 
 //store label-value pair
 Map<String, Integer> dataValuePair = new HashMap<String, Integer>();
 dataValuePair.put("Venezuela", 290);
 dataValuePair.put("Saudi", 260);
 dataValuePair.put("Canada", 180);
 dataValuePair.put("Iran", 140);
 dataValuePair.put("Russia", 115);
 dataValuePair.put("UAE", 100);
 dataValuePair.put("US", 30);
 dataValuePair.put("China", 30);
 
  StringBuilder jsonData = new StringBuilder();
  StringBuilder data = new StringBuilder();
  // json data to use as chart data source
  jsonData.append("{'chart':{");
  for(Map.Entry conf:chartConfig.entrySet())
  {
      jsonData.append("'" + conf.getKey()+"':'"+conf.getValue() + "',");
  }
 
  jsonData.replace(jsonData.length() - 1, jsonData.length() ,"},");

  // build  data object from label-value pair
  data.append("'data':[");

  for(Map.Entry pair:dataValuePair.entrySet())
  {
      data.append("{'label':'" + pair.getKey() + "','value':'" + pair.getValue() +"'},");
  }
  data.replace(data.length() - 1, data.length(),"]");

  jsonData.append(data.toString());
  jsonData.append("}");
  
  
//Create chart instance
  // charttype, chartID, width, height,containerid, data format, data
  FusionCharts firstChart = new FusionCharts(
		  "column2d", 
		  "first_chart", 
		  "800",
		  "550", 
		  "chart",
		  "json", 
		  jsonData.toString()
 );
 %>
 <%= firstChart.render() %>
 
   
 
 
</body>
</html>