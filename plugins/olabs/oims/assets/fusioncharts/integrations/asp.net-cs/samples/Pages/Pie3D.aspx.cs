using System;
using FusionCharts.Charts;

public partial class Pie3D : System.Web.UI.Page
{
    protected void Page_Load(object sender, EventArgs e)
    {
        //chart data
        string jsonData = "{      'chart': {        'caption': 'Recommended Portfolio Split',        'subCaption' : 'For a net-worth of $1M',        'showValues':'1',        'showPercentInTooltip' : '0',        'numberPrefix' : '$',        'enableMultiSlicing':'1',        'theme': 'fusion'      },      'data': [{        'label': 'Equity',        'value': '300000'      }, {        'label': 'Debt',        'value': '230000'      }, {        'label': 'Bullion',        'value': '180000'      }, {        'label': 'Real-estate',        'value': '270000'      }, {        'label': 'Insurance',        'value': '20000'      }]    }";
        // create chart instance
        // parameter
        // chrat type, chart id, chart widh, chart height, data format, data source
        Chart pie3D = new Chart("pie3d", "first_chart", "600", "400", "json", jsonData);
        //render chart
        Literal1.Text = pie3D.Render();
    }
}