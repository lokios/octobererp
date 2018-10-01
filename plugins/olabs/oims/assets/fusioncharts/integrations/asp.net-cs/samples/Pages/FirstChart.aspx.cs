using System;
using System.Text;
using System.Collections.Generic;
using FusionCharts.Charts;

public partial class FirstChart : System.Web.UI.Page
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

        StringBuilder jsonData = new StringBuilder();
        StringBuilder data = new StringBuilder();
        // store chart config name-config value pair

        Dictionary<string, string> chartConfig = new Dictionary<string, string>();
        chartConfig.Add("caption", "Countries With Most Oil Reserves [2017-18]");
        chartConfig.Add("subCaption", "In MMbbl = One Million barrels");
        chartConfig.Add("xAxisName", "Country");
        chartConfig.Add("yAxisName", "Reserves (MMbbl)");
        chartConfig.Add("numberSuffix", "k");
        chartConfig.Add("theme", "fusion");

        // json data to use as chart data source
        jsonData.Append("{'chart':{");
        foreach (var config in chartConfig)
        {
            jsonData.AppendFormat("'{0}':'{1}',", config.Key, config.Value);
        }
        jsonData.Replace(",", "},", jsonData.Length - 1, 1);

        // build  data object from label-value pair
        data.Append("'data':[");

        foreach (KeyValuePair<string, double> pair in dataValuePair)
        {
            data.AppendFormat("{{'label':'{0}','value':'{1}'}},", pair.Key, pair.Value);
        }
        data.Replace(",", "]", data.Length - 1, 1);

        jsonData.Append(data.ToString());
        jsonData.Append("}");
        //Create chart instance
        // charttype, chartID, width, height, data format, data

        Chart chart = new Chart("column2d", "first_chart", "800", "550", "json", jsonData.ToString());
        Literal1.Text = chart.Render();
    }
}