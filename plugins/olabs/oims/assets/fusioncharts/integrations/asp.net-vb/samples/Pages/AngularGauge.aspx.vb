Imports FusionCharts.Charts
Partial Class AngularGauge
    Inherits System.Web.UI.Page
    Protected Sub Page_Load(sender As Object, e As EventArgs) Handles MyBase.Load
        'store chart config data as json string
        Dim jsonData As String
        jsonData = "{'chart': {'caption': 'Nordstorm\'s Customer Satisfaction Score for 2017','lowerLimit': '0','upperLimit': '100','showValue': '1','numberSuffix': '%','theme': 'fusion','showToolTip': '0'},'colorRange': {'color': [{'minValue': '0','maxValue': '50','code': '#F2726F'}, {'minValue': '50','maxValue': '75','code': '#FFC533'}, {'minValue': '75','maxValue': '100','code': '#62B58F'}]},'dials': {'dial': [{'value': '81'}]}}"
        'create gauge instance
        'gauge type, gauge id, width, height, data format, data source as string
        Dim gauge As New Chart("angulargauge", "gauge", "400", "400", "json", jsonData)
        'render gauge
        Literal1.Text = gauge.Render()
    End Sub
End Class
