require 'json'

class AngularGuage
    def self.getGauge

        angularGaugeData = {
            "chart": {
                "caption": "Nordstorm's Customer Satisfaction Score for 2017",
                "lowerLimit": "0",
                "upperLimit": "100",
                "showValue": "1",
                "numberSuffix": "%",
                "theme": "fusion",
                "showToolTip": "0"
            },
            "colorRange": {
                "color": [{
                    "minValue": "0",
                    "maxValue": "50",
                    "code": "#F2726F"
                }, {
                    "minValue": "50",
                    "maxValue": "75",
                    "code": "#FFC533"
                }, {
                    "minValue": "75",
                    "maxValue": "100",
                    "code": "#62B58F"
                }]
            },
            "dials": {
                "dial": [{
                    "value": "81"
                }]
            }
        }        

        # Chart rendering 
        chart = Fusioncharts::Chart.new({
                width: "450",
                height: "250",
                type: "angulargauge",
                renderAt: "gaugeContainer",
                dataSource: angularGaugeData
            })

    end
end