Imports System.Xml.Linq.XElement
Imports FusionCharts.Charts
Partial Class WidgetWithXmlData
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
        chartConfig.Add("caption", "Nordstorm&s Customer Satisfaction Score for 2017")
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
        ' create root element as
        Dim root As New XElement("chart")
        For Each config In chartConfig
            root.SetAttributeValue(config.Key, config.Value)
        Next

        ' colorRange element
        Dim colorrange As New XElement("colorrange")
        For Each clr In color
            Dim colorElement As New XElement("color")
            colorElement.SetAttributeValue("minvalue", clr.Min.ToString())
            colorElement.SetAttributeValue("maxvalue", clr.Max.ToString())
            colorElement.SetAttributeValue("code", clr.ColorCode.ToString())
            colorrange.Add(colorElement)

        Next
        root.Add(colorrange)
        Dim dialsElement As New XElement("dials")
        For Each dialCnf In dial
            Dim dialElement As New XElement("dial")
            dialElement.SetAttributeValue(dialCnf.Key, dialCnf.Value)
            dialsElement.Add(dialElement)
        Next
        root.Add(dialsElement)
        ' convert xml root element to string
        Dim xmlData As String
        xmlData = root.ToString().Replace("""", "'").Replace(vbLf, " ").Replace(vbCr, " ")
        ' Create chart instance
        ' charttype, chartID, width, height, data format, data
        Dim gauge As New Chart("angulargauge", "widget", "400", "350", "xml", xmlData)
        Literal1.Text = gauge.Render()
    End Sub
End Class
