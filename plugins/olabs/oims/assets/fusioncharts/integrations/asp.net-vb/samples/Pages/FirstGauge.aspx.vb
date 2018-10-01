Imports FusionCharts.Charts
Partial Class FirstGauge
    Inherits System.Web.UI.Page
    'Create colorRange class
    'It will store Min range Max range And specific color code for each range
    Class ColorRange
        Private lowerLimit As Integer
        Private upprLimit As Integer
        Private code As String
        'lower value of range set as property
        Property Min() As Integer
            Get
                Return lowerLimit

            End Get
            Set(value As Integer)
                lowerLimit = value
            End Set
        End Property
        'upper value of range set as property
        Property Max() As Integer
            Get
                Return upprLimit

            End Get
            Set(value As Integer)
                upprLimit = value
            End Set
        End Property
        ' specific color code for this range
        Property ColorCode() As String
            Get
                Return code

            End Get
            Set(value As String)
                code = value
            End Set
        End Property
        'constructor
        Public Sub New(ByVal lowerLimit As Integer, ByVal upperLimit As Integer, ByVal code As String)
            Min = lowerLimit
            Max = upperLimit
            ColorCode = code
        End Sub

    End Class
    Protected Sub Page_Load(sender As Object, e As EventArgs) Handles MyBase.Load
        'store chart config name-config value pair

        Dim chartConfig As New Dictionary(Of String, String)
        chartConfig.Add("caption", "Nordstorm\'s Customer Satisfaction Score for 2017")
        chartConfig.Add("lowerLimit", "0")
        chartConfig.Add("upperLimit", "100")
        chartConfig.Add("showValue", "1")
        chartConfig.Add("numberSuffix", "%")
        chartConfig.Add("theme", "fusion")
        chartConfig.Add("showToolTip", "0")

        Dim color As New List(Of ColorRange)
        color.Add(New ColorRange(0, 50, "#F2726F"))
        color.Add(New ColorRange(50, 75, "#FFC533"))
        color.Add(New ColorRange(75, 100, "#62B58F"))

        'store dial configuration

        Dim dial As New Dictionary(Of String, String)
        dial.Add("value", "81")
        'json data to use as chart data source
        Dim jsonData As New StringBuilder
        'build chart config object
        jsonData.Append("{'chart':{")

        For Each config In chartConfig
            jsonData.AppendFormat("'{0}':'{1}',", config.Key, config.Value)
        Next

        jsonData.Replace(",", "},", jsonData.Length - 1, 1)

        Dim range As New StringBuilder
        'build colorRange object
        range.Append("'colorRange':{")
        range.Append("'color':[")
        For Each clr In color

            range.AppendFormat("{{'minValue':'{0}','maxValue':'{1}','code':'{2}'}},", clr.Min, clr.Max, clr.ColorCode)
        Next
        range.Replace(",", "]},", range.Length - 1, 1)
        'build dials object
        Dim dials As New StringBuilder
        dials.Append("'dials':{")
        dials.Append("'dial':[")
        For Each dialCnf In dial

            dials.AppendFormat("{{'{0}':'{1}'}},", dialCnf.Key, dialCnf.Value)
        Next
        dials.Replace(",", "]}", dials.Length - 1, 1)

        jsonData.Append(range.ToString())
        jsonData.Append(dials.ToString())
        jsonData.Append("}")

        'Create gauge instance
        'charttype, chartID, width, height, data format, data

        Dim gauge As New Chart("angulargauge", "first_gauge", "400", "350", "json", jsonData.ToString())
        'render gauge
        Literal1.Text = gauge.Render()
    End Sub
End Class
