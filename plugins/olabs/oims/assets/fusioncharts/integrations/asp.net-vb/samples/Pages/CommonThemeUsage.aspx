<%@ Page Language="VB" AutoEventWireup="false" CodeFile="CommonThemeUsage.aspx.vb" Inherits="Pages_CommonThemeUsage" %>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <link href="../Styles/SampleStyleSheet.css" rel="stylesheet" />
    <title>FusionCharts | Use of Common Theme</title>
</head>
<body>
    <script type="text/javascript" src="//cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
   <script type="text/javascript" src="//cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>
   <script type="text/javascript" src="//cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.gammel.js"></script>
   <script type="text/javascript" src="//cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.zune.js"></script>
   <script type="text/javascript" src="//cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.carbon.js"></script>
   <script type="text/javascript" src="//cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.ocean.js"></script>
    <form id="form1" runat="server">
        <h3>Use of Common Theme</h3>
        <div style="width: 100%; display: table;">
            <div style="display: table-row">
                <div style="width: 40%; display: table-cell;"><asp:Literal ID="Literal1" runat="server"></asp:Literal></div>
                <div  style="width: 40%; display: table-cell;"><asp:Literal ID="Literal2" runat="server"></asp:Literal>  </div>
            </div>
        </div>
   </form>
    <script>
        FusionCharts && FusionCharts.ready(function () {
            
            //FusionCharts.options.defaultTheme = "fint";

            var trans = document.getElementById("controllers").getElementsByTagName("input");
            for (var i=0, len=trans.length; i<len; i++) {                
                if (trans[i].type == "radio"){
                    trans[i].onchange = function() {
                        ChangeTheme(this.value);
                    };
                }
            }
        });

        function ChangeTheme(theme) {
            for (var k in FusionCharts.items) {
                if (FusionCharts.items.hasOwnProperty(k)) {
                    FusionCharts.items[k].setChartAttribute('theme', theme);
                }
            }
        };
    </script>
        <div align="center" style="font-family:'Helvetica Neue', Arial; font-size: 16px;">
            <label style="padding: 0px 5px !important;">Select a theme for all charts </label>
        </div>
        <br/>
        <div id="controllers" align="center" style="font-family:'Helvetica Neue', Arial; font-size: 14px;">
            <label style="padding: 0px 5px !important;">
           <input type="radio" name="theme-options" checked value="fusion"/> Fusion
       </label>
       <label style="padding: 0px 5px !important;">
           <input type="radio" name="theme-options" value="gammel"/> Gammel
       </label>
       <label style="padding: 0px 5px !important;">
               <input type="radio" name="theme-options" value="zune"/> Zune
       </label>
       <label style="padding: 0px 5px !important;">
           <input type="radio" name="theme-options" value="carbon"/> Carbon
       </label>
       <label style="padding: 0px 5px !important;">
           <input type="radio" name="theme-options" value="ocean"/> Ocean
       </label>
        </div>
    <div><span><a href ="../Default.aspx">Go Back</a></span></div>
    
</body>
</html>
