module FusionchartsExporter
  class Engine < ::Rails::Engine
    isolate_namespace FusionchartsExporter

    config.generators do |g|
      g.test_framework :rspec
    end
  end
end
