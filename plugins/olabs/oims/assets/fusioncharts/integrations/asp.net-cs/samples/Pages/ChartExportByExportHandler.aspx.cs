using System;
using FusionCharts.Charts;


public partial class Pages_ChartExportByExportHandler : System.Web.UI.Page
{
    protected void Page_Load(object sender, EventArgs e)
    {
        //chart data
        string jsonData = "{      'chart': {        'caption': 'Salary Hikes by Country',        'subCaption': '2016 - 2017',        'showhovereffect': '1',        'numberSuffix': '%',        'rotatelabels': '1',   'exportEnabled':'1', 'exportMode': 'server'  ,   'theme': 'fusion'      },      'categories': [{        'category': [{          'label': 'Australia'        }, {          'label': 'New-Zealand'        }, {          'label': 'India'        }, {          'label': 'China'        }, {          'label': 'Myanmar'        }, {          'label': 'Bangladesh'        }, {          'label': 'Thailand'        }, {          'label': 'South Korea'        }, {          'label': 'Hong Kong'        }, {          'label': 'Singapore'        }, {          'label': 'Taiwan'        }, {          'label': 'Vietnam'        }]      }],      'dataset': [{        'seriesName': '2016 Actual Salary Increase',        'plotToolText' : 'Salaries increased by <b>$dataValue</b> in 2016',        'data': [{          'value': '3'        }, {          'value': '3'        }, {          'value': '10'        }, {          'value': '7'        }, {          'value': '7.4'        }, {          'value': '10'        }, {          'value': '5.4'        }, {          'value': '4.5'        }, {          'value': '4.1'        }, {          'value': '4'        }, {          'value': '3.7'        }, {          'value': '9.3'        }]      }, {        'seriesName': '2017 Projected Salary Increase',        'plotToolText' : 'Salaries expected to increase by <b>$dataValue</b> in 2017',        'renderAs': 'line',        'data': [{          'value': '3'        }, {          'value': '2.8'        }, {          'value': '10'        }, {          'value': '6.9'        }, {          'value': '6.7'        }, {          'value': '9.4'        }, {          'value': '5.5'        }, {          'value': '5'        }, {          'value': '4'        }, {          'value': '4'        }, {          'value': '4.5'        }, {          'value': '9.8'        }]      }, {        'seriesName': 'Inflation rate',        'plotToolText' : '$dataValue projected inflation',        'renderAs': 'area',        'showAnchors':'0',        'data': [{          'value': '1.6'        }, {          'value': '0.6'        }, {          'value': '5.6'        }, {          'value': '2.3'        }, {          'value': '7'        }, {          'value': '5.6'        }, {          'value': '0.2'        }, {          'value': '1'        }, {          'value': '2.6'        }, {          'value': '0'        }, {          'value': '1.1'        }, {          'value': '2.4'        }]      }]    }";
        // create chart instance
        // parameter
        // chrat type, chart id, chart widh, chart height, data format, data source
        Chart pie3D = new Chart("mscombi3d", "first_chart", "600", "400", "json", jsonData);
        //render chart
        Literal1.Text = pie3D.Render();
    }
}