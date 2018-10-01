using System;
using FusionCharts.Charts;

public partial class AngularGauge : System.Web.UI.Page
{
    protected void Page_Load(object sender, EventArgs e)
    {
        //json data to render map
        string jsonData = "{'chart': {'caption': 'Nordstorm\\'s Customer Satisfaction Score for 2017','lowerLimit': '0','upperLimit': '100','showValue': '1','numberSuffix': '%','theme': 'fusion','showToolTip': '0'},'colorRange': {'color': [{'minValue': '0','maxValue': '50','code': '#F2726F'}, {'minValue': '50','maxValue': '75','code': '#FFC533'}, {'minValue': '75','maxValue': '100','code': '#62B58F'}]},'dials': {'dial': [{'value': '81'}]}}";
        // create chart instance
        // parameter
        // chrat type, chart id, chart widh, chart height, data format, data source
        Chart gauge = new Chart("angulargauge", "first_chart", "400", "400", "json", jsonData);
        //render gauge
        Literal1.Text = gauge.Render();
    }
}