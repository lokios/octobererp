using System;
using FusionCharts.Charts;

public partial class ClientSide_Export_Enabled : System.Web.UI.Page
{
    protected void Page_Load(object sender, EventArgs e)
    {
        //json data in string format
        string jsonData = "{      'chart': {        'caption': 'Countries With Most Oil Reserves [2017-18]',        'subCaption': 'In MMbbl = One Million barrels',        'xAxisName': 'Country',        'yAxisName': 'Reserves (MMbbl)',        'numberSuffix': 'K',        'theme': 'fusion',  'exportEnabled':'1'    },      'data': [{        'label': 'Venezuela',        'value': '290'      }, {        'label': 'Saudi',        'value': '260'      }, {        'label': 'Canada',        'value': '180'      }, {        'label': 'Iran',        'value': '140'      }, {        'label': 'Russia',        'value': '115'      }, {        'label': 'UAE',        'value': '100'      }, {        'label': 'US',        'value': '30'      }, {        'label': 'China',        'value': '30'      }]    }";
        // create chart instance
        // parameter
        // chrat type, chart id, chart widh, chart height, data format, data source
        Chart column2d = new Chart("column2d", "first_chart", "700", "400", "json", jsonData);
        //render chart
        Literal1.Text = column2d.Render();

    }
}