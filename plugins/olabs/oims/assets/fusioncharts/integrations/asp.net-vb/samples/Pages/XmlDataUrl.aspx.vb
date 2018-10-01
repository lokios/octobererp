Imports FusionCharts.Charts
Partial Class XmlDataUrl
    Inherits System.Web.UI.Page
    Protected Sub Page_Load(sender As Object, e As EventArgs) Handles MyBase.Load
        'store chart  data url as  string
        Dim xmlDataUrl As String
        xmlDataUrl = "../Data/xmlData.xml"
        'create gauge instance
        'chart type, chart id, width, height, data format, data source as url
        Dim columnChart As New Chart("column2d", "columnchart", "700", "400", "xmlurl", xmlDataUrl)
        'render gauge
        Literal1.Text = columnChart.Render()
    End Sub
End Class
