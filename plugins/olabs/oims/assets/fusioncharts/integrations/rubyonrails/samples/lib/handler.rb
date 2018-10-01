class DrillDownDataHandler
@chartData =
        {
			"chart": {
				"caption": "Projected Global IP Traffic, 2016-2019",
				"subcaption": "Click on a column to drill-down into type of traffic",
				"yaxisname": "Total IP traffic (PetaByte per Month)",
				"formatnumberscale": "1",
				"defaultnumberscale": "PB",
				"yaxismaxvalue": "185000",
				"numberscaleunit": "PB,EB",
				"plottooltext": "<div><b>$label</b><br/>IP Traffic : <b>$value PB</b></div>",
				"theme": "fusion"
			},
			"data": [
				{
					"label": "2016",
					"value": "88426",
					"link": "newchart-json-2016-type"
				},
				{
					"label": "2017",
					"value": "108988",
					"link": "newchart-json-2017-type"
				},
				{
					"label": "2018",
					"value": "135483",
					"link": "newchart-json-2018-type"
				},
				{
					"label": "2019",
					"value": "167978",
					"link": "newchart-json-2019-type"
				}
			],
			"linkeddata": [
				{
					"id": "2016-type",
					"linkedchart": {
						"chart": {
							"caption": "Global IP Traffic, 2016",
							"subcaption": "By Type (PB per Month)",
							"formatnumberscale": "1",
							"rotatevalues": "0",
							"yaxismaxvalue": "60000",
							"defaultnumberscale": "PB",
							"numberscalevalue": "1024,1024",
							"numberscaleunit": "PB,EB",
							"plottooltext": "<div><b>$label</b><br/>IP Traffic : <b>$value PB</b></div>",
							"theme": "fusion"
						},
						"data": [
							{
								"label": "Fixed Internet",
								"value": "58304"
							},
							{
								"label": "Managed IP",
								"value": "23371"
							},
							{
								"label": "Mobile data",
								"value": "6751"
							}
						]
					}
				},
				{
					"id": "2017-type",
					"linkedchart": {
						"chart": {
							"caption": "Global IP Traffic, 2017",
							"subcaption": "By Type (PB per Month)",
							"formatnumberscale": "1",
							"rotatevalues": "0",
							"yaxismaxvalue": "75000",
							"defaultnumberscale": "PB",
							"numberscalevalue": "1024,1024",
							"numberscaleunit": "PB,EB",
							"plottooltext": "<div><b>$label</b><br/>IP Traffic : <b>$value PB</b></div>",
							"theme": "fusion"
						},
						"data": [
							{
								"label": "Fixed Internet",
								"value": "72251"
							},
							{
								"label": "Managed IP",
								"value": "26087"
							},
							{
								"label": "Mobile data",
								"value": "10650"
							}
						]
					}
				},
				{
					"id": "2018-type",
					"linkedchart": {
						"chart": {
							"caption": "Global IP Traffic, 2018",
							"subcaption": "By Type (PB per Month)",
							"formatnumberscale": "1",
							"rotatevalues": "0",
							"yaxismaxvalue": "95000",
							"defaultnumberscale": "PB",
							"numberscalevalue": "1024,1024",
							"numberscaleunit": "PB,EB",
							"plottooltext": "<div><b>$label</b><br/>IP Traffic : <b>$value PB</b></div>",
							"theme": "fusion"
						},
						"data": [
							{
								"label": "Fixed Internet",
								"value": "90085"
							},
							{
								"label": "Managed IP",
								"value": "29274"
							},
							{
								"label": "Mobile data",
								"value": "16124"
							}
						]
					}
				},
				{
					"id": "2019-type",
					"linkedchart": {
						"chart": {
							"caption": "Global IP Traffic, 2019",
							"subcaption": "By Type (PB per Month)",
							"formatnumberscale": "1",
							"rotatevalues": "0",
							"yaxismaxvalue": "120000",
							"defaultnumberscale": "PB",
							"numberscalevalue": "1024,1024",
							"numberscaleunit": "PB,EB",
							"plottooltext": "<div><b>$label</b><br/>IP Traffic : <b>$value PB</b></div>",
							"theme": "fusion"
						},
						"data": [
							{
								"label": "Fixed Internet",
								"value": "111899"
							},
							{
								"label": "Managed IP",
								"value": "31858"
							},
							{
								"label": "Mobile data",
								"value": "24221"
							}
						]
					}
				}
			]
		}