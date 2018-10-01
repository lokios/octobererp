require 'json'
class DrillDownDataHandler

    def self.processDataforDrillDown(dbData, columnName, drillLevel, maxLevel)
        
        # Chart appearance configuration
        chartConfigObj = Hash.new
        chartConfigObj = { 
                            "caption" => "Sales by " + columnName,
                            "xAxisName" => columnName,
                            "yAxisName" => "Total Sales", 
                            "numberSuffix" => "K", 
                            "theme" => "fusion"
                        }
                        
        dataTemplateWithLink = "{\"label\": \"%s\",\"value\": \"%s\", \"link\":\"newchart-jsonurl-/samples/drilldown/handler?label=%s&drillLevel=%s\"},"
        dataTemplateWithoutLink = "{\"label\": \"%s\",\"value\": \"%s\"},"
        
        # Chart data as JSON string
        labelValueJSONStr = ""

        dbData.each do |row|
            if drillLevel.to_i < maxLevel - 1 
                labelValuedata = dataTemplateWithLink % [row[columnName], row["TotalSales"].to_s, row[columnName], drillLevel]
            else
                labelValuedata = dataTemplateWithoutLink % [row[columnName], row["TotalSales"].to_s, row[columnName]]
            end
            labelValueJSONStr.concat(labelValuedata)
        end

        # Removing trailing comma character
        labelValueJSONStr = labelValueJSONStr.chop

        # Chart JSON data template
        chartJSONDataTemplate = "{ \"chart\": %s, \"data\": [%s] }"

        # Final Chart JSON data from template
        chartJSONDataStr = chartJSONDataTemplate % [chartConfigObj.to_json, labelValueJSONStr]

        return chartJSONDataStr
    end
    
    def self.GetDBData(*args)
        if args.size == 1
            columnName = args[0]
            result = SalesRecord.select( columnName + ', SUM(TotalSales) as TotalSales').group(columnName)
        else
            columnName = args[0]
            parentValue = args[1]
            parentName = args[2]
            result = SalesRecord.select( columnName + ', ' + parentName + ', SUM(TotalSales) as TotalSales').where(parentName + " = '" + parentValue + "'").group(columnName)
        end
    end

    def self.getData(params)
        
        # Drilldown column order
        columnLevel = ["Region", "Country", "City"]
        
        # Get drilldown parameters
        columnClickedUpon = params[:label]
        drillDownLevel = params[:drillLevel]
        
        if drillDownLevel
            iDrillDownLevel = drillDownLevel.to_i + 1
            data = GetDBData(columnLevel[iDrillDownLevel], columnClickedUpon, columnLevel[iDrillDownLevel - 1])
            drillDownLevel = iDrillDownLevel.to_s
        else
            drillDownLevel = "0"
            data = GetDBData(columnLevel[drillDownLevel.to_i])
        end

        chartData = processDataforDrillDown(data, columnLevel[drillDownLevel.to_i], drillDownLevel, columnLevel.size)
    end

end