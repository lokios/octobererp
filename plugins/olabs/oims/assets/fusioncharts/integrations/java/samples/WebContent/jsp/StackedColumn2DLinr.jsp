<%@ page language="java" contentType="text/html; charset=ISO-8859-1"
    pageEncoding="ISO-8859-1"%>
    <%@page import="java.util.*" %>
<%@page import="fusioncharts.FusionCharts" %>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<title>FusionCharts | Stacked Column 2D with Line Chart</title>
<link href="../Styles/ChartSampleStyleSheet.css" rel="stylesheet" />
<script type="text/javascript" src="//cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
   <script type="text/javascript" src="//cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>

</head>
<body>
 <h3>Stacked Column 2D with Line Chart</h3>
<div id="stacked_line"></div>
<div><span><a href="../Index.jsp">Go Back</a></span></div>
<%
        String jsonData;
        jsonData = "{      \"chart\": {        \"showvalues\": \"0\",        \"caption\": \"Apple's Revenue & Profit\",        \"subCaption\": \"(2013-2016)\",        \"numberprefix\": \"$\",        \"numberSuffix\" : \"B\",        \"plotToolText\" : \"Sales of $seriesName in $label was <b>$dataValue</b>\",        \"showhovereffect\": \"1\",        \"yaxisname\": \"$ (In billions)\",        \"showSum\":\"1\",        \"theme\": \"fusion\"      },      \"categories\": [{        \"category\": [{          \"label\": \"2013\"        }, {          \"label\": \"2014\"        }, {          \"label\": \"2015\"        }, {          \"label\": \"2016\"        }]      }],      \"dataset\": [{        \"seriesname\": \"iPhone\",        \"data\": [{          \"value\": \"21\"        }, {          \"value\": \"24\"        }, {          \"value\": \"27\"        }, {          \"value\": \"30\"        }]      }, {        \"seriesname\": \"iPad\",        \"data\": [{          \"value\": \"8\"        }, {          \"value\": \"10\"        }, {          \"value\": \"11\"        }, {          \"value\": \"12\"        }]      }, {        \"seriesname\": \"Macbooks\",        \"data\": [{          \"value\": \"2\"        }, {          \"value\": \"4\"        }, {          \"value\": \"5\"        }, {          \"value\": \"5.5\"        }]      }, {        \"seriesname\": \"Others\",        \"data\": [{          \"value\": \"2\"        }, {          \"value\": \"4\"        }, {          \"value\": \"9\"        }, {          \"value\": \"11\"        }]      }, {        \"seriesname\": \"Profit\",        \"plotToolText\" : \"Total profit in $label was <b>$dataValue</b>\",        \"renderas\": \"Line\",        \"data\": [{          \"value\": \"17\"        }, {          \"value\": \"19\"        }, {          \"value\": \"13\"        }, {          \"value\": \"18\"        }]      }]    }";
    	
        FusionCharts stackedColumn = new FusionCharts(
      			  "stackedColumn2DLine",
     		      "ms_column",
     		      "700", 
     		      "400",
     		      "stacked_line",
     		      "json",
     		      jsonData      		      
      			);
        %>
   
		<%=stackedColumn.render()%>
</body>

</html>