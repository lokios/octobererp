﻿using System;
using FusionCharts.Charts;

public partial class MsColumn2d : System.Web.UI.Page
{
    protected void Page_Load(object sender, EventArgs e)
    {
        //json data in string format
        string jsonData = "{      'chart': {        'caption': 'App Publishing Trend',        'subCaption': '2012-2016',        'xAxisName': 'Years',        'yAxisName' : 'Total number of apps in store',        'formatnumberscale': '1',        'drawCrossLine':'1',        'plotToolText' : '<b>$dataValue</b> apps on $seriesName in $label',				'theme': 'fusion'      },      'categories': [{        'category': [{'label': '2012'        }, {'label': '2013'        }, {'label': '2014'        }, {'label': '2015'        },{        'label': '2016'        }        ]      }],      'dataset': [{        'seriesname': 'iOS App Store',        'data': [{'value': '125000'        }, {'value': '300000'        }, {'value': '480000'        }, {'value': '800000'        }, {'value': '1100000'        }]      }, {        'seriesname': 'Google Play Store',        'data': [{'value': '70000'        }, {'value': '150000'        }, {'value': '350000'        }, {'value': '600000'        },{'value': '1400000'        }]      }, {        'seriesname': 'Amazon AppStore',        'data': [{'value': '10000'        }, {'value': '100000'        }, {'value': '300000'        }, {'value': '600000'        },{'value': '900000'        }]      }]    }";
        // create chart instance
        // parameter
        // chrat type, chart id, chart widh, chart height, data format, data source
        Chart column2d = new Chart("mscolumn2d", "first_chart", "700", "400", "json", jsonData);
        //render chart
        Literal1.Text = column2d.Render();
    }
}