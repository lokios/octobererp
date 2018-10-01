FusionchartsExporter::Engine.routes.draw do

  post "/" => "exporter#index", as: "fusioncharts_exporter_export"

end