require 'json'

class FirstWidget

    # Widget rendering
    def self.getWidget
        
        # Widget appearance configuration
        widgetAppearancesConfigObj = {
            "caption" => "Nordstorm's Customer Satisfaction Score for 2017",
            "lowerLimit" => "0",
            "upperLimit" => "100",
            "showValue" => "1",
            "numberSuffix" => "%",
            "theme" => "fusion",
            "showToolTip" => "0"
        }

        # Widget color range data
        colorDataObj = {"color" => [
                {"minValue" => "0", "maxValue" => "50", "code" => "#F2726F"}, 
                {"minValue" => "50", "maxValue" => "75", "code" => "#FFC533"},
                {"minValue" => "75", "maxValue" => "100", "code" => "#62B58F"}
            ]
        }
        
        # Widget dial data in array format, multiple values can be separated by comma e.g. ["81", "23", "45",...]
        widgetDialDataArray = ["81"]
        
        # Dial value in JSON format
        widgetDialDataStr = ""
        
        # Template for dial value
        widgetDialDataTemplate = "{ \"value\": \"%s\" },"

        # Iterates dial data array and converts them proper data format 
        widgetDialDataArray.each {|item|
            data = widgetDialDataTemplate % [item]
            widgetDialDataStr.concat(data)
        }

        # Removing trailing comma
        widgetDialDataStr = widgetDialDataStr.chop
        
        # Formats dial value(s)
        widgetDialTemplate = "{ \"dial\": [%s]}"
        widgetDialStr = ""
        widgetDialStr = widgetDialTemplate % [widgetDialDataStr]

        # Final Widget JSON template
        widgetJSONTemplate = "{ \"chart\": %s, \"colorRange\": %s,  \"dials\": %s}"
        
        # Final Widget JSON data from template
        widgetJSONStr = widgetJSONTemplate % [widgetAppearancesConfigObj.to_json, colorDataObj.to_json, widgetDialStr]
        
        # Rendering the widget
        widget = Fusioncharts::Chart.new({
            width: "400",
            height: "250",
            type: "angulargauge",
            renderAt: "widgetContainer",
            dataSource: widgetJSONStr
        })
    end
end