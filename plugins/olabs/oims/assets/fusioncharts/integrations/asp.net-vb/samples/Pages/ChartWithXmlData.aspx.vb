Imports System.Xml.Linq.XElement
Imports FusionCharts.Charts
Partial Class ChartWithXmlData
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

        'store chart config name-config value pair
        Dim chartConfig As New Dictionary(Of String, String)
        chartConfig.Add("caption", "Countries With Most Oil Reserves [2017-18]")
        chartConfig.Add("subCaption", "In MMbbl = One Million barrels")
        chartConfig.Add("xAxisName", "Country")
        chartConfig.Add("yAxisName", "Reserves (MMbbl)")
        chartConfig.Add("numberSuffix", "k")
        chartConfig.Add("theme", "fusion")
        ' create root element as
        Dim root As New XElement("chart")
        For Each config In chartConfig
            root.SetAttributeValue(config.Key, config.Value)
        Next
        ' iterate through data-value pair
        For Each pair In dataValuePair
            Dim setEleemnt As New XElement("set")
            setEleemnt.SetAttributeValue("label", pair.Key)
            setEleemnt.SetAttributeValue("value", pair.Value)
            root.Add(setEleemnt)
        Next
        ' convert xml root element to string
        Dim xmlData As String
        xmlData = root.ToString().Replace("""", "'").Replace(vbLf, " ").Replace(vbCr, " ")
        ' Create chart instance
        ' charttype, chartID, width, height, data format, data
        Dim first_chart As New Chart("column2d", "column_chart", "600", "350", "xml", xmlData)
        Literal1.Text = first_chart.Render()

    End Sub

End Class
