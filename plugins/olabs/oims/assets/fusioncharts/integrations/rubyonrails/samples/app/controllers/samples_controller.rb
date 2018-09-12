require 'fusioncharts-rails'

require 'first_chart'
require 'first_widget'
require 'first_map'
require 'drilldown'
require 'angular_gauge'
require 'mscolumn2d'

require 'drill_down_data_handler'

class SamplesController < ApplicationController
  protect_from_forgery except: :handler
  def index

    ##### Variables for First Chart Sample
		@first_chart=FirstChart.getChart
		@first_widget=FirstWidget.getWidget
		@first_map=FirstMap.getMap

    @drilldown_chart = Drilldown.getChart
    
    @myGauge = AngularGuage.getGauge

    @myMsColumn2dChart = Mscolumn2d.getChart

		render template: "/samples/#{params[:page]}"

  end
  
  def home
    redirect_to "/samples/index"
  end

  def handler
    # render json: {"test"=>"test-data"}
    render json: DrillDownDataHandler.getData(params)
    # render json: DrillDownDataHandler.getChart(params)
  end

end
