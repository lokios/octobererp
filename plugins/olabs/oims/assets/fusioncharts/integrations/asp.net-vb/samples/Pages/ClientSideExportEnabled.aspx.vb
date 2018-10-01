Imports FusionCharts.Charts
Partial Class ClientSideExportEnabled
    Inherits System.Web.UI.Page
    Protected Sub Page_Load(sender As Object, e As EventArgs) Handles MyBase.Load
        'store chart  data url as  string
        Dim jsonData As String
        jsonData = "{      'chart': {        'caption': 'Countries With Most Oil Reserves [2017-18]',        'subCaption': 'In MMbbl = One Million barrels',        'xAxisName': 'Country',        'yAxisName': 'Reserves (MMbbl)',        'numberSuffix': 'K',        'theme': 'fusion',  'exportEnabled':'1'    },      'data': [{        'label': 'Venezuela',        'value': '290'      }, {        'label': 'Saudi',        'value': '260'      }, {        'label': 'Canada',        'value': '180'      }, {        'label': 'Iran',        'value': '140'      }, {        'label': 'Russia',        'value': '115'      }, {        'label': 'UAE',        'value': '100'      }, {        'label': 'US',        'value': '30'      }, {        'label': 'China',        'value': '30'      }]    }"
        'create gauge instance
        'chart type, chart id, width, height, data format, data source as url
        Dim columnChart As New Chart("column2d", "columnchart", "700", "400", "json", jsonData)
        'render gauge
        Literal1.Text = columnChart.Render()
    End Sub
End Class
