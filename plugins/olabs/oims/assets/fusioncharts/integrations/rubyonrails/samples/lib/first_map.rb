require 'json'

class FirstMap

    # Map rendering
    def self.getMap 

        # Map appearance configuration
        mapAppearancesConfigObj = {
            "caption" => "Average Annual Population Growth",
            "subcaption" => " 1955-2015",
            "numbersuffix" => "%",
            "includevalueinlabels" => "1",
            "labelsepchar" => ": ",
            "entityFillHoverColor" => "#FFF9C4",
            "theme" => "fusion"
        }

        # Map color range data
        colorDataObj = { "minvalue" => "0", "code" => "#FFE0B2", "gradient" => "1",
                        "color" => [
                            {"minValue" => "0.5", "maxValue" => "1", "code" => "#FFD74D"}, 
                            {"minValue" => "1.0", "maxValue" => "2.0", "code" => "#FB8C00"},
                            {"minValue" => "2.0", "maxValue" => "3.0", "code" => "#E65100"}
                        ]
        }
        
        # Map data array
        mapDataArray = [ 
            ["NA", ".82", "1"],
            ["SA", "2.04", "1"],
            ["AS", "1.78", "1"],
            ["EU", ".40", "1"],
            ["AF", "2.58", "1"],
            ["AU", "1.30", "1"]
        ]

        # Map data template
        mapDataTemplate = "{ \"id\": \"%s\", \"value\": \"%s\", \"showLabel\": \"%s\" },"
        
        # Map data as JSON string
        mapDataJSONStr = ""
        
        # Iterate all data in mapDataArray and converts it to actual data format
        mapDataArray.each {|item|
            data = mapDataTemplate % [item[0], item[1], item[2]]
            mapDataJSONStr.concat(data)
        }

        # Removing trailing comma
        mapDataJSONStr = mapDataJSONStr.chop

        # Map JSON data template
        mapJSONTemplate = "{ \"chart\": %s, \"colorRange\": %s,  \"data\": [%s]}"

        # Map JSON data after combining all parts
        mapJSONStr = mapJSONTemplate % [mapAppearancesConfigObj.to_json, colorDataObj.to_json, mapDataJSONStr]

        # Rendeing the Map
        map = Fusioncharts::Chart.new({
            width: "600",
            height: "400",
            type: "maps/world",
            renderAt: "mapContainer",
            dataSource: mapJSONStr
        })

    end
end