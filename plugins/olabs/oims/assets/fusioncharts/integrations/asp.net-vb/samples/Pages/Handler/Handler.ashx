<%@ WebHandler Language="VB" Class="Handler" %>


Imports System.Data
Imports System.Data.SqlClient


Public Class Handler : Implements IHttpHandler

    Public Sub ProcessRequest(ByVal context As HttpContext) Implements IHttpHandler.ProcessRequest
        context.Response.ContentType = "application/json"
        ' array to store level mapping for each column
        Dim levelValueMapping() As String = {"region", "country", "city"}
        Dim drillLevel, query, label As String
        drillLevel = context.Request("drillLevel")
        query = ""
        label = ""
        If String.IsNullOrEmpty(drillLevel) Then

            drillLevel = "0"
            ' build custom query 
            ' parameter: column to be fetch
            query = BuildQuery(levelValueMapping((Convert.ToInt16(drillLevel))))
        Else

            drillLevel = (Convert.ToInt16(drillLevel) + 1).ToString()
            label = context.Request("label")
            ' build custom query 
            ' parameter: column to be fetch, previously clicked value, previous level column name
            query = BuildQuery(levelValueMapping((Convert.ToInt16(drillLevel))), label, levelValueMapping((Convert.ToInt16(drillLevel) - 1)))
        End If
        Dim dt As DataTable
        ' establish DB connection and fetch chart data
        dt = GetChartData(query)

        Dim chartJsonData As String = ProcessChartData(dt, levelValueMapping((Convert.ToInt16(drillLevel))), drillLevel, levelValueMapping.Length)
        context.Response.Write(chartJsonData)
    End Sub

    Public ReadOnly Property IsReusable() As Boolean Implements IHttpHandler.IsReusable
        Get
            Return False
        End Get
    End Property

    Private Function ProcessChartData(ByVal dt As DataTable, ByVal columnName As String, ByVal drillLevel As String, ByVal maxLevel As Integer) As String
        Dim linkParam As String = "newchart-jsonurl-Handler/Handler.ashx?label={0}&drillLevel={1}"
        Dim jsonData As New StringBuilder
        Dim data As New StringBuilder

        'store chart config name-config value pair
        Dim chartConfig As New Dictionary(Of String, String)
        chartConfig.Add("caption", "Total Sales by " + columnName)
        chartConfig.Add("xAxisName", columnName)
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
            If Convert.ToInt16(drillLevel) < maxLevel - 1 Then
                Dim link As String = String.Format(linkParam, row(0).ToString(), drillLevel)
                ' String link = String.Format(linkParam, row[0].ToString(), drillLevel);
                data.AppendFormat("{{""label"":""{0}"",""value"":""{1}"", ""link"": ""{2}""}},", row(0).ToString(), row(1).ToString(), link)
            Else
                data.AppendFormat("{{""label"":""{0}"",""value"":  ""{1}""}},", row(0).ToString(), row(1).ToString())
            End If

        Next row
        data.Replace(",", "]", data.Length - 1, 1)

        jsonData.Append(data.ToString())
        jsonData.Append("}")
        ProcessChartData = jsonData.ToString()

    End Function

    Private Function BuildQuery(ByVal columnName As String) As String
        Dim query As String
        query = "select " + columnName + ", SUM([Total Sales]) as [Total Sales]" + "from Sales_Record group by " + columnName
        BuildQuery = query
    End Function

    Private Function BuildQuery(ByVal columnName As String, ByVal parentValue As String, ByVal parentName As String) As String
        Dim query As String
        query = "select " + columnName + ", SUM([Total Sales]) as [Total Sales]" + "from Sales_Record where " + parentName + "= '" + parentValue + "'Group by " + columnName
        BuildQuery = query
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