using System;
using System.Collections.Generic;
using System.Text;
using FusionCharts.Charts;

public partial class FirstGauge : System.Web.UI.Page
{
    class ColorRange
    {
        public int Min { get; set; }
        public int Max { get; set; }
        public string ColorCode { get; set; }

        public ColorRange(int min, int max, string code)
        {
            Min = min;
            Max = max;
            ColorCode = code;
        }
    }
    protected void Page_Load(object sender, EventArgs e)
    {
        // store chart config name-config value pair

        Dictionary<string, string> chartConfig = new Dictionary<string, string>();
        chartConfig.Add("caption", "Nordstorm\\'s Customer Satisfaction Score for 2017");
        chartConfig.Add("lowerLimit", "0");
        chartConfig.Add("upperLimit", "100");
        chartConfig.Add("showValue", "1");
        chartConfig.Add("numberSuffix", "%");
        chartConfig.Add("theme", "fusion");
        chartConfig.Add("showToolTip", "0");

        List<ColorRange> color = new List<ColorRange>();
        color.Add(new ColorRange(0, 50, "#F2726F"));
        color.Add(new ColorRange(50, 75, "#FFC533"));
        color.Add(new ColorRange(75, 100, "#62B58F"));

        //store dial configuration

        var dial = new List<KeyValuePair<string, string>>();
        dial.Add(new KeyValuePair<string, string>("value", "81"));

        // json data to use as chart data source
        StringBuilder jsonData = new StringBuilder();
        //build chart config object
        jsonData.Append("{'chart':{");
        foreach (var config in chartConfig)
        {
            jsonData.AppendFormat("'{0}':'{1}',", config.Key, config.Value);
        }
        jsonData.Replace(",", "},", jsonData.Length - 1, 1);

        StringBuilder range = new StringBuilder();
        //build colorRange object
        range.Append("'colorRange':{");
        range.Append("'color':[");
        foreach (ColorRange clr in color)
        {
            range.AppendFormat("{{'minValue':'{0}','maxValue':'{1}','code':'{2}'}},", clr.Min, clr.Max, clr.ColorCode);
        }
        range.Replace(",", "]},", range.Length - 1, 1);
        //build dials object
        StringBuilder dials = new StringBuilder();
        dials.Append("'dials':{");
        dials.Append("'dial':[");
        foreach (var dialCnf in dial)
        {
            dials.AppendFormat("{{'{0}':'{1}'}},", dialCnf.Key, dialCnf.Value);
        }
        dials.Replace(",", "]}", dials.Length - 1, 1);

        jsonData.Append(range.ToString());
        jsonData.Append(dials.ToString());
        jsonData.Append("}");

        //Create gauge instance
        // charttype, chartID, width, height, data format, data

        Chart gauge = new Chart("angulargauge", "first_gauge", "400", "350", "json", jsonData.ToString());
        //render gauge
        Literal1.Text = gauge.Render();
    }
}