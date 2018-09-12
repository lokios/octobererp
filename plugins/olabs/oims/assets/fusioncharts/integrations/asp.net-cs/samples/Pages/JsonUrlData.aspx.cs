using System;
using FusionCharts.Charts;

public partial class JsonUrlData : System.Web.UI.Page
{
    protected void Page_Load(object sender, EventArgs e)
    {
        //data url
        string jsonDataUrl = "../Data/jsonData.json";
        // create chart instance
        // parameter
        // chrat type, chart id, chart widh, chart height, data format, data source
        Chart columnChart = new Chart("column2d", "first_chart", "600", "400", "jsonurl", jsonDataUrl);
        //render chart
        Literal1.Text = columnChart.Render();
    }
}