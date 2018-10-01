<%@ page language="java" contentType="text/html; charset=ISO-8859-1"
    pageEncoding="ISO-8859-1"%>
<%@page import="java.util.*" %>
<%@page import="fusioncharts.FusionCharts" %>
<%!
//Create colorRange class
//It will store Min range Max range and specific color code for each range
private class ColorRange
{
	public  int min,max;
	public  String colorCode;
	public ColorRange(int min,int max, String code)
	{
		this.min = min;
		this.max = max;
		this.colorCode = code;
	}
	
}
%>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<title>FusionCharts | Simple Widget Using Array</title>
<link href="../Styles/ChartSampleStyleSheet.css" rel="stylesheet" />
<script type="text/javascript" src="//cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
   <script type="text/javascript" src="//cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>

</head>
<body>
<h3>Simple Widget Using Array</h3>
<div id="gauge"></div>
<div><span><a href="../Index.jsp">Go Back</a></span></div>
<%
//store chart config name-config value pair
Map<String, String> chartConfig = new HashMap<String, String>();
chartConfig.put("caption", "Nordstorms Customer Satisfaction Score for 2017");
chartConfig.put("lowerLimit", "0");
chartConfig.put("upperLimit", "100");
chartConfig.put("showValue", "1");
chartConfig.put("numberSuffix", "%");
chartConfig.put("theme", "fusion");
chartConfig.put("showToolTip", "0");
//store dial value config
Map<String,String> dial = new HashMap<String,String>();
dial.put("value","81");
//store color range-color
ArrayList<ColorRange> color = new ArrayList<ColorRange>();
color.add(new ColorRange(0,50,"#F2726F"));
color.add(new ColorRange(50,75,"#FFC533"));
color.add(new ColorRange(75,100,"#62B58F"));

//json data to use as chart data source
StringBuilder jsonData = new StringBuilder();
//build chart config object
jsonData.append("{'chart':{");
for(Map.Entry conf:chartConfig.entrySet())
{
    jsonData.append("'" + conf.getKey()+"':'"+conf.getValue() + "',");
}
jsonData.replace(jsonData.length() - 1, jsonData.length() ,"},");

StringBuilder range = new StringBuilder();
//build colorRange object
range.append("'colorRange':{");
range.append("'color':[");
for(int i =0; i< color.size(); i++)
{
	range.append("{'minValue':'" + color.get(i).min + "','maxValue':'" + color.get(i).max + "','code':'" + color.get(i).colorCode +"'},");
}
range.replace(range.length() - 1, range.length(),"]},");
//build dials object
StringBuilder dials = new StringBuilder();
dials.append("'dials':{");
dials.append("'dial':[");
for(Map.Entry dialCnf:dial.entrySet())
{
    dials.append("{'" + dialCnf.getKey() + "':'" + dialCnf.getValue() +"'},");
}
dials.replace(dials.length() - 1, dials.length(),"]}");

jsonData.append(range.toString());
jsonData.append(dials.toString());
jsonData.append("}");

//Create gauge instance
// charttype, chartID, width, height,container id, data format, data
FusionCharts gauge = new FusionCharts(
		  "angularGauge", 
		  "first_gauge", 
		  "400",
		  "350", 
		  "gauge",
		  "json", 
		  jsonData.toString()
 );
 %>
 <%= gauge.render() %>

</body>
</html>