Imports FusionCharts.Charts
Partial Class FirstChart
    Inherits System.Web.UI.Page
    Protected Sub Page_Load(sender As Object, e As EventArgs) Handles MyBase.Load
        'store label-value pair
        Dim dataValuePair As New Dictionary(Of String, Double)
        dataValuePair.Add("Venezuela", 290)
        dataValuePair.Add("Saudi", 260)
        dataValuePair.Add("Canada", 180)
        dataValuePair.Add("Iran", 140)
        dataValuePair.Add("Russia", 115)
        dataValuePair.Add("UAE", 100)
        dataValuePair.Add("US", 30)
        dataValuePair.Add("China", 30)

        Dim jsonData As New StringBuilder
        Dim data As New StringBuilder

        'store chart config name-config value pair
        Dim chartConfig As New Dictionary(Of String, String)
        chartConfig.Add("caption", "Countries With Most Oil Reserves [2017-18]")
        chartConfig.Add("subCaption", "In MMbbl = One Million barrels")
        chartConfig.Add("xAxisName", "Country")
        chartConfig.Add("yAxisName", "Reserves (MMbbl)")
        chartConfig.Add("numberSuffix", "k")
        chartConfig.Add("theme", "fusion")

        ' json data to use as chart data source
        jsonData.Append("{'chart':{")
        For Each config In chartConfig
            jsonData.AppendFormat("'{0}':'{1}',", config.Key, config.Value)
        Next


        jsonData.Replace(",", "},", jsonData.Length - 1, 1)

        ' build  data object from label-value pair
        data.Append("'data':[")

        For Each pair In dataValuePair
            data.AppendFormat("{{'label':'{0}','value':'{1}'}},", pair.Key, pair.Value)
        Next


        data.Replace(",", "]", data.Length - 1, 1)

        jsonData.Append(data.ToString())
        jsonData.Append("}")
        ' Create chart instance
        ' charttype, chartID, width, height, data format, data
        Dim first_chart As New Chart("column2d", "first_chart", "600", "350", "json", jsonData.ToString())
        Literal1.Text = first_chart.Render()

    End Sub
End Class
