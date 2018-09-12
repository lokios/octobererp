require 'json'
require 'fusioncharts-rails'

class FirstChart
    def self.getChart
        
        # Chart appearance configuration
        chartAppearancesConfigObj = Hash.new
        chartAppearancesConfigObj = { 
                        "caption" => "Countries With Most Oil Reserves [2017-18]",
                        "subCaption" => "In MMbbl = One Million barrels", 
                        "xAxisName" => "Country",
                        "yAxisName" => "Reserves (MMbbl)", 
                        "numberSuffix" => "K", 
                        "theme" => "fusion"
                    }
        
        # An array of hash objects which stores data
        chartDataObj = [
                    {"Venezuela" => "290"},
                    {"Saudi" => "260"},
                    {"Canada" => "180"},
                    {"Iran" => "140"},
                    {"Russia" => "115"},
                    {"UAE" => "100"},
                    {"US" => "30"},
                    {"China" => "30"}
                ]
        
        # Chart data template to store data in "Label" & "Value" format
        labelValueTemplate = "{ \"label\": \"%s\", \"value\": \"%s\" },"
        
        # Chart data as JSON string
        labelValueJSONStr = ""

        chartDataObj.each {|item| 
            data = labelValueTemplate % [item.keys[0], item[item.keys[0]]]
            labelValueJSONStr.concat(data)
        }

        # Removing trailing comma character
        labelValueJSONStr = labelValueJSONStr.chop

        # Chart JSON data template
        chartJSONDataTemplate = "{ \"chart\": %s, \"data\": [%s] }"

        # Final Chart JSON data from template
        chartJSONDataStr = chartJSONDataTemplate % [chartAppearancesConfigObj.to_json, labelValueJSONStr]

        # Chart rendering 
        chart = Fusioncharts::Chart.new({
                width: "600",
                height: "400",
                type: "column2d",
                renderAt: "chartContainer",
                dataSource: chartJSONDataStr
            })

    end
end