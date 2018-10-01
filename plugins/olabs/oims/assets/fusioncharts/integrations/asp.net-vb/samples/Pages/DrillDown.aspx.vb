Imports FusionCharts.Charts
Partial Class DrillDown
    Inherits System.Web.UI.Page
    Protected Sub Page_Load(sender As Object, e As EventArgs) Handles MyBase.Load
        'create chart instance
        'chart type, chart id, width, height, data format, data source as url
        Dim columnChart As New Chart("column2d", "columnchart", "700", "400", "jsonurl", "Handler/Handler.ashx")
        'render gauge
        Literal1.Text = columnChart.Render()
    End Sub
End Class
