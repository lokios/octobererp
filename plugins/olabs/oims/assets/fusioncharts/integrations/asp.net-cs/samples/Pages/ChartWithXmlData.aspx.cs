using System;
using System.Collections.Generic;
using System.Xml.Linq;
using FusionCharts.Charts;

public partial class ChartWithXmlData : System.Web.UI.Page
{
    protected void Page_Load(object sender, EventArgs e)
    {
        //store label-value pair
        var dataValuePair = new List<KeyValuePair<string, double>>();

        dataValuePair.Add(new KeyValuePair<string, double>("Venezuela", 290));
        dataValuePair.Add(new KeyValuePair<string, double>("Saudi", 260));
        dataValuePair.Add(new KeyValuePair<string, double>("Canada", 180));
        dataValuePair.Add(new KeyValuePair<string, double>("Iran", 140));
        dataValuePair.Add(new KeyValuePair<string, double>("Russia", 115));
        dataValuePair.Add(new KeyValuePair<string, double>("UAE", 100));
        dataValuePair.Add(new KeyValuePair<string, double>("US", 30));
        dataValuePair.Add(new KeyValuePair<string, double>("China", 30));

        // store chart config name-config value pair

        Dictionary<string, string> chartConfig = new Dictionary<string, string>();
        chartConfig.Add("caption", "Countries With Most Oil Reserves [2017-18]");
        chartConfig.Add("subCaption", "In MMbbl = One Million barrels");
        chartConfig.Add("xAxisName", "Country");
        chartConfig.Add("yAxisName", "Reserves (MMbbl)");
        chartConfig.Add("numberSuffix", "k");
        chartConfig.Add("theme", "fusion");

        // create root eleement chart
        //it will store all chart config an data to render chart
        XElement chart = new XElement("chart");
        //iterate through chart configuration
        //add each config as chart element attribute
        foreach(var config in chartConfig)
        {
           //chart.SetAttributeValue(formatStringQuote(config.Key), formatStringQuote(config.Value));
           chart.SetAttributeValue(config.Key, config.Value);
        }
        // create set elemnt as a child element of chart
        foreach (KeyValuePair<string, double> pair in dataValuePair)
        {
            XElement set = new XElement("set");
            set.SetAttributeValue("label", pair.Key);
            set.SetAttributeValue("value", pair.Value.ToString());
            chart.Add(set);
        }
        //Create chart instance
        // charttype, chartID, width, height, data format, data

        Chart column_chart = new Chart("column2d", "first_chart", "800", "550", "xml", formatString(chart.ToString()));
        Literal1.Text = column_chart.Render();

    }
    private string formatString(string str)
    {
        // xml is multiline
        // c# does not support multi line string
        // js expects ' as \' to write in browser so replace them by \\'
        // replace each \n and \r with space and " by '
        return str.Replace("'","\\'").Replace("\"", "'").Replace("\n", "").Replace("\r", "");
        
    }
}