module FusionchartsExporter

  class InstallGenerator < Rails::Generators::Base

    source_root File.expand_path('../templates', __FILE__)

    # Generate configuration file
    def generate_config
      template "fusioncharts_exporter.erb", "#{Rails.root}/config/fusioncharts_exporter.yml"
    end

    # Create directory where all images will be stored temporarily
    def generate_temp_dir
      empty_directory File.join(Rails.root, "tmp", "fusioncharts")
    end

  end

end