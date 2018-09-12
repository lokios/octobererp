<%@page import="com.mysql.jdbc.Driver"%>
<%@ page language="java" contentType="text/html; charset=ISO-8859-1"
    pageEncoding="ISO-8859-1"%>
<%@page import="java.util.*" %>
<%@page import="fusioncharts.FusionCharts" %>
<%@page import="java.sql.*" %>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<title>FusionCharts | Chart Using Database (MySQL)</title>
<link href="../Styles/ChartSampleStyleSheet.css" rel="stylesheet" />
<script type="text/javascript" src="//cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
   <script type="text/javascript" src="//cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>

</head>
<body>
 <h3>Chart Using Database (MySQL)</h3>
<div id="database_chart"></div>
<div><span><a href="../Index.jsp">Go Back</a></span></div>
<%
Connection con = null;
String url = "jdbc:mysql://localhost:3306/drilldowndb";
String user = "root";
String password = "P@ssw0rd";
String query = "SELECT `Region`, SUM(`Total sales`) FROM `Sales_Record` group by Region";
Class.forName("com.mysql.jdbc.Driver").newInstance();
con = DriverManager.getConnection(url,user,password);
Statement st = con.createStatement();
String sql = (query);
ResultSet rs = st.executeQuery(sql);


//store chart config name-config value pair
Map<String, String> chartConfig = new HashMap<String, String>();
chartConfig.put("caption", "Total Sales by Region");
chartConfig.put("xAxisName", "Region");
chartConfig.put("yAxisName", "Total Sales");
chartConfig.put("numberSuffix", "k");
chartConfig.put("theme", "fusion");

StringBuilder jsonData = new StringBuilder();
StringBuilder data = new StringBuilder();
// json data to use as chart data source
jsonData.append("{\"chart\":{");
for(Map.Entry conf:chartConfig.entrySet())
{
    jsonData.append("\"" + conf.getKey()+"\":\""+conf.getValue() + "\",");
}

jsonData.replace(jsonData.length() - 1, jsonData.length() ,"},");

// build  data object from label-value pair
data.append("\"data\":[");

while (rs.next())
{
	data.append("{\"label\":\"" + rs.getString(1) + "\",\"value\":\"" + rs.getString(2) +"\"},");
}
data.replace(data.length() - 1, data.length(),"]");

jsonData.append(data.toString());
jsonData.append("}");

con.close();
//Create chart instance
// charttype, chartID, width, height,containerid, data format, data
FusionCharts firstChart = new FusionCharts(
		  "column2d", 
		  "data_from_mysql", 
		  "800",
		  "550", 
		  "database_chart",
		  "json", 
		  jsonData.toString()
);
%>
<%=firstChart.render() %>
</body>

</html>