module FusionchartsExporter
  class Export

    # Path where all temporary images will be stored.
    FUSIONCHARTS_TEMP_PATH = "tmp/fusioncharts" 

    def setConfigFile(configFile)
      @configFile = configFile
      @config = YAML.load_file(@configFile)

      self
    end

    def setParams(params)
      @params = params
      @options = {}
      @export_params = @params[:parameters]
      @export_params.split("|").each do |p|
        splitted = p.split("=")
        @options[splitted[0]] = splitted[1]
      end

      self
    end

    # Return the options instance variable
    def get_options
      @options
    end

    # Return the filename with the absolute path of the current downloaded item
    def get_downloaded_filename
      get_download_filename
    end

    def downloadable?
      @options['exportaction'] === 'download' ? true : false
    end

    def saveable?
      @options['exportaction'] === 'save' ? true : false
    end

    def remove_files
      @remove_files.each { |f| File.delete(f) }
    end

    def save
      begin
        dest = get_destination
        FileUtils.mv(get_download_filename, dest)

        stat = true
      rescue 
        stat = false
      end

      @remove_files.reject!{ |f| f === get_download_filename }
      self.remove_files

      if stat
        return true
      end

      return false
    end

    def process_image
      
      pre_process_image

      File.open(@options['filepath'], "w") do |f|
        f.write(@params[:stream])
      end

      extension = @options['exportformat']

      unless(extension == 'svg')

        # Create a PNG / PDF image
        temp_extension = extension == 'pdf' ? 'pdf' : 'png'
        cmd = @config['inkscape_path'] + " --without-gui --export-background=#{@options['meta']['bgColor']} --file=#{@options['filepath']} --export-#{temp_extension}=#{@options['tempfilename']}.#{temp_extension} --export-width=#{@options['meta']['width']} --export-height=#{@options['meta']['height']}"
        raise "Inkscape was unable to convert svg to png. Is Inkscape configured and installed correctly?" unless system(cmd)
        @remove_files << @options['tempfilename'] + ".#{temp_extension}"

        # Create JPG image
        if  extension == 'jpg' || extension == 'jpeg'
          cmd = @config['imagemagick_path'] + " -quality 100 #{@options['tempfilename']}.png #{@options['tempfilename']}.#{extension}"
          raise "ImageMagick was unable to convert to jpg. Is ImageMagick configured and installed correctly?" unless system(cmd)
          @remove_files << @options['tempfilename'] + ".jpg"
        end
      end

    end

    # Get the name file that will be called during download
    def get_export_filename
       @options['exportfilename'] + "." + @options['exportformat']
    end

    def get_mime_type(options=nil)
      options = options || @options
      mime_types = {
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif' => 'image/gif',
        'png' => 'image/png',
        'pdf' => 'application/pdf',
        'svg' => 'image/svg+xml'
      }

      if(mime_types[options['exportformat']])
        return mime_types[options['exportformat']]
      else
        raise "Invalid mime type"
      end
    end

    def setRootPath(path)
      @root_path = path

      self
    end

    private

    # Get the full download filename with the path
    def get_download_filename
      @options['tempfilename'] + "." + @options['exportformat']
    end

    def pre_process_image
      @random_filename = SecureRandom.urlsafe_base64 + "_" + Time.now.to_i.to_s
      @random_filename_path = File.join(Rails.root, FUSIONCHARTS_TEMP_PATH, @random_filename)

      @options['tempfilename'] = @random_filename_path
      @options['filepath'] = @random_filename_path + ".svg"
      @options['meta'] = get_meta_options
      @remove_files = [ @options['filepath'] ]
    end

    

    # Get all meta request paramaters
    def get_meta_options

      meta = {}
      @params.each do |p|
        match = p[0].match(/^meta_(.*)/)
        if(match)
          meta[$1] = p[1]
        end
      end

      return meta

    end

    # Get the absoulte save path where the file be saved on the server
    def get_destination
      File.join(@root_path, @config['save_path'], @random_filename + "." + @options['exportformat'])
    end

  end
end
