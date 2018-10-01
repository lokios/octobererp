using System;
using FusionCharts.Charts;


public partial class CommonThemeUsage : System.Web.UI.Page
{
    protected void Page_Load(object sender, EventArgs e)
    {
        // store chart data as json string
        string jsonDataFirstChart, jsonDataSecondChart;
        jsonDataFirstChart = "{      'chart': {        'caption': 'Average Fastball Velocity',        'yAxisName' : 'Velocity (in mph)',        'subCaption': '[2005-2016]',        'numberSuffix': ' mph',        'rotateLabels': '1',        'setAdaptiveYMin': '1',     },      'data': [{        'label': '2005',        'value': '89.45'      }, {        'label': '2006',        'value': '89.87'      }, {        'label': '2007',        'value': '89.64'      }, {        'label': '2008',        'value': '90.13'      }, {        'label': '2009',        'value': '90.67'      }, {        'label': '2010',        'value': '90.54'      }, {        'label': '2011',        'value': '90.75'      }, {        'label': '2012',        'value': '90.8'      }, {        'label': '2013',        'value': '91.16'      }, {        'label': '2014',        'value': '91.37'      }, {        'label': '2015',        'value': '91.66'      }, {        'label': '2016',        'value': '91.8'      }, ]    }";
        jsonDataSecondChart = "{        'chart': {          'caption': 'Lead sources by industry',          'yAxisName': 'Number of Leads',          'alignCaptionWithCanvas': '0',          'plotToolText': '<b>$dataValue</b> leads received',        },        'data': [{            'label': 'Travel & Leisure',            'value': '41'          },          {            'label': 'Advertising/Marketing/PR',            'value': '39'          },          {            'label': 'Other',            'value': '38'          },          {            'label': 'Real Estate',            'value': '32'          },          {            'label': 'Communications/Cable/Phone',            'value': '26'          },          {            'label': 'Construction',            'value': '25'          },          {            'label': 'Entertainment',            'value': '25'          },          {            'label': 'Staffing Firm/Full Time/Temporary',            'value': '24'          },          {            'label': 'Transportation/Logistics',            'value': '23'          },          {            'label': 'Utilities',            'value': '22'          },          {            'label': 'Aerospace/Defense Products',            'value': '18'          },          {            'label': 'Banking/Finance/Securities',            'value': '16'          },          {            'label': 'Consumer Products - Non-Durables',            'value': '15'          },          {            'label': 'Distribution',            'value': '13'          },          {            'label': 'Education',            'value': '12'          },          {            'label': 'Health Products & Services',            'value': '11'          },          {            'label': 'Hospitality & Hotels',            'value': '10'          },          {            'label': 'Non-Business/Residential',            'value': '6'          },          {            'label': 'Pharmaceutical',            'value': '4'          },          {            'label': 'Printing & Publishing',            'value': '1'          },          {            'label': 'Professional Services',            'value': '1'          },          {            'label': 'VAR/ISV',            'value': '1'          },          {            'label': 'Warranty Administrators',            'value': '1'          }        ]      }";
      
        // Create chart instance for first chart
        Chart lineChart = new Chart("line", "first_chart", "600", "300", "json", jsonDataFirstChart);
        // create chart instance for second chart
        Chart barChart = new Chart("bar2d","second_chart","600","300","json", jsonDataSecondChart);
        // render first chart
        Literal1.Text = lineChart.Render();
        // render second chart
        Literal2.Text = barChart.Render();
    }

}