﻿<%@ Page Language="C#" AutoEventWireup="true" CodeFile="DataBaseExample.aspx.cs" Inherits="Pages_DataBaseExample" %>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <link href="../Styles/SampleStyleSheet.css" rel="stylesheet" />
    <title>FusionCharts | Chart Using Database (MSSQL)</title>
</head>
<body>
    <script type="text/javascript" src="//cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
   <script type="text/javascript" src="//cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>
    <form id="form1" runat="server">
        <h3>Chart Using Database (MSSQL)</h3>
        <div>
             <asp:Literal ID="Literal1" runat="server"></asp:Literal>     
        </div>
        <div><span><asp:HyperLink id="hyperlink1" NavigateUrl="../Default.aspx" Text="Go Back" runat="server"/></span></div>
    </form>
</body>
</html>
