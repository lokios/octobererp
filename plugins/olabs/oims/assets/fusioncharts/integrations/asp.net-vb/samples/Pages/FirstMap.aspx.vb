Imports FusionCharts.Charts
Partial Class FirstMap
    Inherits System.Web.UI.Page
    'Create colorRange class
    'It will store Min range Max range And specific color code for each range
    Class ColorRange
        Private lowerLimit As Double
        Private upprLimit As Double
        Private code As String
        'lower value of range set as property
        Property Min() As Double
            Get
                Return lowerLimit

            End Get
            Set(value As Double)
                lowerLimit = value
            End Set
        End Property
        'upper value of range set as property
        Property Max() As Double
            Get
                Return upprLimit

            End Get
            Set(value As Double)
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
        Public Sub New(ByVal lowerLimit As Double, ByVal upperLimit As Double, ByVal code As String)
            Min = lowerLimit
            Max = upperLimit
            ColorCode = code
        End Sub

    End Class
    'Create countryData class
    'It will store id, value And show label for each country
    Class CountryData
        Private cid As String
        Private cvalue As Double
        Private label As Integer
        'country id set as a property
        Property ID() As String
            Get
                Return cid

            End Get
            Set(value As String)
                cid = value
            End Set
        End Property
        'data value for a country set as property
        Property Value() As Double
            Get
                Return cvalue

            End Get
            Set(value As Double)
                cvalue = value
            End Set
        End Property
        ' whether show label or not
        Property ShowLabel() As Integer
            Get
                Return label

            End Get
            Set(value As Integer)
                label = value
            End Set
        End Property
        'constructor
        Public Sub New(ByVal cntryid As String, ByVal val As Double, ByVal lbl As Integer)
            ID = cntryid
            Value = val
            ShowLabel = lbl
        End Sub

    End Class
    Protected Sub Page_Load(sender As Object, e As EventArgs) Handles MyBase.Load
        ' store chart config name-config value pair
        Dim chartConfig As New Dictionary(Of String, String)
        chartConfig.Add("caption", "Average Annual Population Growth")
        chartConfig.Add("subCaption", " 1955-2015")
        chartConfig.Add("includevalueinlabels", "1")
        chartConfig.Add("labelsepchar", ": ")
        chartConfig.Add("numberSuffix", "%")
        chartConfig.Add("entityFillHoverColor", "#FFF9C4")
        chartConfig.Add("theme", "fusion")

        'store color code for different range
        Dim color As New List(Of ColorRange)
        color.Add(New ColorRange(0.5, 1.0, "#FFD74D"))
        color.Add(New ColorRange(1.0, 2.0, "#FB8C00"))
        color.Add(New ColorRange(2.0, 3.0, "#E65100"))

        'store country data
        Dim countries As New List(Of CountryData)
        countries.Add(New CountryData("NA", 0.82, 1))
        countries.Add(New CountryData("SA", 2.04, 1))
        countries.Add(New CountryData("AS", 1.78, 1))
        countries.Add(New CountryData("EU", 0.4, 1))
        countries.Add(New CountryData("AF", 2.58, 1))
        countries.Add(New CountryData("AU", 1.3, 1))

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

        'build data object
        Dim data As New StringBuilder
        data.Append("'data':[")
        For Each country In countries

            data.AppendFormat("{{'id':'{0}','value':'{1}','showLabel':'{2}'}},", country.ID, country.Value, country.ShowLabel)
        Next
        data.Replace(",", "]", data.Length - 1, 1)
        jsonData.Append(range)
        jsonData.Append(data)
        jsonData.Append("}")
        'Create map instance
        'map type, mapid, width, height, data format, data

        Dim first_map As New Chart("world", "first_map", "800", "500", "json", jsonData.ToString())
        'render map
        Literal1.Text = first_map.Render()
    End Sub
End Class
