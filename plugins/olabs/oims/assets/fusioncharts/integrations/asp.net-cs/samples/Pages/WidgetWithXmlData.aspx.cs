using System;
using System.Collections.Generic;
using System.Xml.Linq;
using FusionCharts.Charts;

public partial class WidgetWithXmlData : System.Web.UI.Page
{
    //color range class with 3 properties to store upper limit lower limit pf a range along with specific color code for that range
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
        chartConfig.Add("caption", "Nordstorm&apos;s Customer Satisfaction Score for 2017");
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
        // create dials as Xelement
        XElement dials = new XElement("dials");
        foreach (KeyValuePair<string, string> pair in dial)
        {
            XElement dialElement = new XElement("dial");
            dialElement.SetAttributeValue(pair.Key,pair.Value);
            dials.Add(dialElement);
        }
       
        chart.Add(dials);
        //Create chart instance
        // charttype, chartID, width, height, data format, data

        Chart gauge = new Chart("angulargauge", "first_widget", "400", "450", "xml", formatString(chart.ToString()));
        Literal1.Text = gauge.Render();

    }
    private string formatString(string str)
    {
        // xml is multiline
        // c# does not support multi line string
        // js expects ' as \' to write in browser so replace them by \\'
        // replace each \n and \r with space and " by '
        return str.Replace("\"", "'").Replace("\n", "").Replace("\r", "");

    }
}