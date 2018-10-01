<%@ page language="java" contentType="text/html; charset=ISO-8859-1"
    pageEncoding="ISO-8859-1"%>
<%@page import="java.util.*" %>
<%@page import="fusioncharts.FusionCharts" %>
<%@page import="java.sql.*" %>
<%@page import="java.util.*" %>
<%@page import="java.io.IOException" %>
<%@page import="java.io.*" %>
<%@page import="java.util.*" %>
<%@page import="java.lang.*" %>
<%! 
	public Connection con = null;
%>
<%
//Set response content type
response.setContentType("application/json");

// level mapping for each column
String[] levelValueMapping = { "region","country","city"};

String drillLevel = request.getParameter("drillLevel");
String query = "";
 String label = "";
  if (drillLevel == null || drillLevel.isEmpty())
  {
      drillLevel = "0";
      // build custom query 
      // parameter: column to be fetch
      query = BuildQuery(levelValueMapping[Integer.parseInt(drillLevel)]);
  }
  else
  {
	  drillLevel = Integer.toString((Integer.parseInt(drillLevel) + 1));
      
      label = request.getParameter("label");
      // build custom query 
      // parameter: column to be fetch, previously clicked value, previous level column name
      query = BuildQuery(levelValueMapping[(Integer.parseInt(drillLevel))],label,levelValueMapping[(Integer.parseInt(drillLevel)-1)]);
  }
  ResultSet rs = GetChartData(query);
  String chartJsonData = ProcessChartData(rs, levelValueMapping[(Integer.parseInt(drillLevel))], drillLevel, levelValueMapping.length);
  
  response.getWriter().write(chartJsonData);
  
  
%>
<%!
	private String BuildQuery(String columnName)
	{
	   String query;
	   query = "select `" + columnName + "`, SUM(`Total sales`) as `Total Sales`" + "from `Sales_Record` group by `" + columnName + "`";
	   return query;
	}
	
	private String BuildQuery(String columnName, String parentValue,String parentName)
	{
		String query;
	    query = "select `" + columnName + "`, SUM(`Total sales`) as `Total Sales`" + "from `Sales_Record` where `" + parentName + "` = '" + parentValue + "'Group by `" + columnName +"`";
	    return query;
	
	}
	private ResultSet GetChartData(String query) throws SQLException
	{
		  
		   String url = "jdbc:mysql://localhost:3306/drilldowndb";
		   String user = "root";
		   String password = "P@ssw0rd";
		   //String query = "SELECT `Region`, SUM(`Total sales`) FROM `Sales_Record` group by Region";
		   try {
			Class.forName("com.mysql.jdbc.Driver").newInstance();
		} catch (InstantiationException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		} catch (IllegalAccessException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		} catch (ClassNotFoundException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		   con = DriverManager.getConnection(url,user,password);
		   Statement st = con.createStatement();
		   String sql = (query);
		   ResultSet rs = st.executeQuery(sql);
		   return rs;
	}

	private String ProcessChartData(ResultSet rs,String columnName, String drillLevel, int maxLevel) throws NumberFormatException, SQLException
	{
		   String linkParam = "newchart-jsonurl-Handler/RequestHandler.jsp?label=%s&drillLevel=%s";
		 //store chart config name-config value pair
		   Map<String, String> chartConfig = new HashMap<String, String>();
		   chartConfig.put("caption", "Total Sales by" + columnName);
		   chartConfig.put("xAxisName", columnName);
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
			 if(Integer.parseInt(drillLevel) < maxLevel - 1)
	        {
	            String link = String.format(linkParam,rs.getString(1).toString(), drillLevel);
	           
	            data.append("{\"label\":\"" + rs.getString(1) + "\",\"value\":\"" + rs.getString(2) +"\",\"link\":\"" + link + "\"},");
	        }
			 else
			 {
				 data.append("{\"label\":\"" + rs.getString(1) + "\",\"value\":\"" + rs.getString(2) +"\"},");
			 }
			   
		   }
		  con.close();
		   data.replace(data.length() - 1, data.length(),"]");
	
		   jsonData.append(data.toString());
		   jsonData.append("}");
		   return jsonData.toString();
	}
%>
