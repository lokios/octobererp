Imports FusionCharts.Charts
Imports System.Data
Imports System.Data.SqlClient
Partial Class Pages_DataBaseExample
    Inherits System.Web.UI.Page
    Protected Sub Page_Load(sender As Object, e As EventArgs) Handles MyBase.Load
        Dim query As String = "select Region, SUM([Total Sales]) as [Total Sales] from Sales_Record group by Region"
        Dim dt As DataTable
        ' establish DB connection and fetch chart data
        dt = GetChartData(query)

        Dim chartJsonData As String = ProcessChartData(dt)

        'create chart instance
        'chart type, chart id, width, height, data format, data source as url
        Dim columnChart As New Chart("column2d", "columnchart", "700", "400", "json", chartJsonData)
        'render gauge
        Literal1.Text = columnChart.Render()
    End Sub
    Private Function ProcessChartData(ByVal dt As DataTable) As String
        Dim jsonData As New StringBuilder
        Dim data As New StringBuilder

        'store chart config name-config value pair
        Dim chartConfig As New Dictionary(Of String, String)
        chartConfig.Add("caption", "Total Sales by Reigion")
        chartConfig.Add("xAxisName", "Region")
        chartConfig.Add("yAxisName", "Total Sales")
        chartConfig.Add("numberSuffix", "k")
        chartConfig.Add("theme", "fusion")

        ' json data to use as chart data source
        jsonData.Append("{""chart"":{")
        For Each config In chartConfig
            jsonData.AppendFormat("""{0}"":""{1}"",", config.Key, config.Value)
        Next
        jsonData.Replace(",", "},", jsonData.Length - 1, 1)

        ' build  data object from label-value pair
        data.Append("""data"":[")
        For Each row As DataRow In dt.Rows
            data.AppendFormat("{{""label"":""{0}"",""value"":  ""{1}""}},", row(0).ToString(), row(1).ToString())

        Next row
        data.Replace(",", "]", data.Length - 1, 1)

        jsonData.Append(data.ToString())
        jsonData.Append("}")
        ProcessChartData = jsonData.ToString()

    End Function
    Private Function GetChartData(ByVal query As String) As DataTable
        Dim dt As New DataTable
        Dim serverName As String = "POUSHALI-PC\SHAREPOINT"
        Dim databaseName As String = "DrillDownDB"
        Dim connetionString As String = "Data Source=" + serverName + ";Initial Catalog=" + databaseName + ";Trusted_Connection=True;"
        Dim connection As SqlConnection = New SqlConnection()
        connection.ConnectionString = connetionString
        connection.Open()
        Dim adp As SqlDataAdapter = New SqlDataAdapter(query, connection)
        adp.Fill(dt)
        connection.Close()
        GetChartData = dt
    End Function
End Class
