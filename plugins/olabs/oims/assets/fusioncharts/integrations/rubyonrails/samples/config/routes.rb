Rails.application.routes.draw do
  root to: "samples#home"
  get "/samples/drilldown/handler" => "samples#handler"
  get "/samples/:page" => "samples#index"
  
  # For details on the DSL available within this file, see http://guides.rubyonrails.org/routing.html
end
