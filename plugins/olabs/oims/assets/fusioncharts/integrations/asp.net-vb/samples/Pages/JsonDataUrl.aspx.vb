Imports FusionCharts.Charts
Partial Class JsonDataUrl
    Inherits System.Web.UI.Page

    Protected Sub Page_Load(sender As Object, e As EventArgs) Handles MyBase.Load
        'store chart  data url as  string
        Dim jsonDataUrl As String
        jsonDataUrl = "../Data/jsonData.json"
        'create gauge instance
        'chart type, chart id, width, height, data format, data source as url
        Dim columnChart As New Chart("column2d", "columnchart", "700", "400", "jsonurl", jsonDataUrl)
        'render gauge
        Literal1.Text = columnChart.Render()
    End Sub
End Class
