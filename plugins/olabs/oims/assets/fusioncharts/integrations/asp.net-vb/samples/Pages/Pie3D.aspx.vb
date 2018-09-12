Imports FusionCharts.Charts
Partial Class Pie3D
    Inherits System.Web.UI.Page
    Protected Sub Page_Load(sender As Object, e As EventArgs) Handles MyBase.Load
        'store chart config data as json string
        Dim jsonData As String
        jsonData = "{      'chart': {        'caption': 'Recommended Portfolio Split',        'subCaption' : 'For a net-worth of $1M',        'showValues':'1',        'showPercentInTooltip' : '0',        'numberPrefix' : '$',        'enableMultiSlicing':'1',        'theme': 'fusion'      },      'data': [{        'label': 'Equity',        'value': '300000'      }, {        'label': 'Debt',        'value': '230000'      }, {        'label': 'Bullion',        'value': '180000'      }, {        'label': 'Real-estate',        'value': '270000'      }, {        'label': 'Insurance',        'value': '20000'      }]    }"
        'create chart instance
        'chart type, chart id, width, height, data format, data source as string
        Dim pie3d As New Chart("pie3d", "pie_chart", "800", "400", "json", jsonData)
        'render chart
        Literal1.Text = pie3d.Render()
    End Sub
End Class
