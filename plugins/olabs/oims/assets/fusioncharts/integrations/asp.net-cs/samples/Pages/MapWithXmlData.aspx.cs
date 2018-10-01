using System;
using System.Collections.Generic;
using System.Xml.Linq;
using FusionCharts.Charts;

public partial class MapWithXmlData : System.Web.UI.Page
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

        // create root eleement chart
        //it will store all chart config an data to render chart
        XElement chart = new XElement("chart");
        //iterate through chart configuration
        //add each config as chart element attribute
        foreach (var config in chartConfig)
        {
            //chart.SetAttributeValue(formatStringQuote(config.Key), formatStringQuote(config.Value));
            chart.SetAttributeValue(config.Key, config.Value);
        }
        //color range element
        XElement colorRange = new XElement("colorrange");
        //iterate through color list

        foreach (ColorRange clr in color)
        {
            XElement colorElemet = new XElement("color");
            colorElemet.SetAttributeValue("minvalue", clr.Min.ToString());
            colorElemet.SetAttributeValue("maxvalue", clr.Max.ToString());
            colorElemet.SetAttributeValue("code", clr.ColorCode.ToString());
            colorRange.Add(colorElemet);
        }
        chart.Add(colorRange);
        // create set elemnt as a child element of chart
        foreach (CountryData country in countries)
        {
            XElement set = new XElement("set");
            set.SetAttributeValue("id", country.ID.ToString());
            set.SetAttributeValue("value", country.Value.ToString());
            set.SetAttributeValue("showlabel", country.ShowLabel.ToString());
            chart.Add(set);
        }

        //Create chart instance
        // charttype, chartID, width, height, data format, data

        Chart worldMap = new Chart("world", "worldmap", "800", "550", "xml", formatString(chart.ToString()));
        Literal1.Text = worldMap.Render();
    }
    private string formatString(string str)
    {
        // xml is multiline
        // c# does not support multi line string
        // js expects ' as \' to write in browser so replace them by \\'
        // replace each \n and \r with space and " by '
        return str.Replace("'", "\\'").Replace("\"", "'").Replace("\n", "").Replace("\r", "");

    }
}