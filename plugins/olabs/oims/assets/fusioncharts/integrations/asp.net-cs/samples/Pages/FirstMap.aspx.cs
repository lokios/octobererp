using System;
using System.Collections.Generic;
using System.Text;
using FusionCharts.Charts;

public partial class FirstMap : System.Web.UI.Page
{
    //Create colorRange class
    //It will store Min range Max range and specific color code for each range

    class ColorRange
    {
        public double Min { get; set; }
        public double Max { get; set; }
        public string ColorCode { get; set; }

        public ColorRange(double min, double max, string code)
        {
            Min = min;
            Max = max;
            ColorCode = code;
        }
    }
    //Create countryData class
    //It will store id, value and show label for each country

    class CountryData
    {
        public string ID { get; set; }
        public double Value { get; set; }
        public int ShowLabel { get; set; }

        public CountryData(string id, double value, int showLabel)
        {
            ID = id;
            Value = value;
            ShowLabel = showLabel;

        }

    }
    protected void Page_Load(object sender, EventArgs e)
    {
        // store chart config name-config value pair
        Dictionary<string, string> chartConfig = new Dictionary<string, string>();
        chartConfig.Add("caption", "Average Annual Population Growth");
        chartConfig.Add("subCaption", " 1955-2015");
        chartConfig.Add("includevalueinlabels", "1");
        chartConfig.Add("labelsepchar", ": ");
        chartConfig.Add("numberSuffix", "%");
        chartConfig.Add("entityFillHoverColor", "#FFF9C4");
        chartConfig.Add("theme", "fusion");

        // store color code for different range
        List<ColorRange> color = new List<ColorRange>();
        color.Add(new ColorRange(0.5, 1.0, "#FFD74D"));
        color.Add(new ColorRange(1.0, 2.0, "#FB8C00"));
        color.Add(new ColorRange(2.0, 3.0, "#E65100"));

        // store country data
        List<CountryData> countries = new List<CountryData>();
        countries.Add(new CountryData("NA", .82, 1));
        countries.Add(new CountryData("SA", 2.04, 1));
        countries.Add(new CountryData("AS", 1.78, 1));
        countries.Add(new CountryData("EU", .40, 1));
        countries.Add(new CountryData("AF", 2.58, 1));
        countries.Add(new CountryData("AU", 1.30, 1));

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

        // build data object
        StringBuilder data = new StringBuilder();
        data.Append("'data':[");
        foreach (CountryData country in countries)
        {
            data.AppendFormat("{{'id':'{0}','value':'{1}','showLabel':'{2}'}},", country.ID, country.Value, country.ShowLabel);
        }
        data.Replace(",", "]", data.Length - 1, 1);
        jsonData.Append(range);
        jsonData.Append(data);
        jsonData.Append("}");
        //Create map instance
        // map type, mapid, width, height, data format, data

        Chart map = new Chart("world", "first_map", "800", "500", "json", jsonData.ToString());
        //render map
        Literal1.Text = map.Render();
    }
}