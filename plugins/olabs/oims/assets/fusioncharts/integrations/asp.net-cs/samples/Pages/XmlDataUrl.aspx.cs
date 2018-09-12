using System;
using FusionCharts.Charts;

public partial class XmlDataUrl : System.Web.UI.Page
{
    protected void Page_Load(object sender, EventArgs e)
    {
        //data url
        string xmlDataUrl = "../Data/xmlData.xml";
        // create chart instance
        // parameter
        // chrat type, chart id, chart widh, chart height, data format, data source
        Chart columnChart = new Chart("column2d", "first_chart", "600", "400", "xmlurl", xmlDataUrl);
        //render chart
        Literal1.Text = columnChart.Render();
    }
}