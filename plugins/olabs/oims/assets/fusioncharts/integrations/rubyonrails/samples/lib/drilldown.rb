class Drilldown
    def self.getChart
		@chart = Fusioncharts::Chart.new({
			width: "600",
			height: "400",
			type: "column2d",
			renderAt: "chartContainer",
			dataFormat: "jsonurl",
			dataSource: "/samples/drilldown/handler"
		})

    end
end