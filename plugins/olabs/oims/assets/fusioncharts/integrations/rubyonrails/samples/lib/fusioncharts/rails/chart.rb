module Fusioncharts

    class Chart

      include ::ActionView::Helpers::OutputSafetyHelper

      attr_accessor :options
      attr_reader :width, :height, :type, :renderAt, :dataSource, :dataFormat, :jsonUrl, :xmlUrl

      # Constructor
      def initialize(options=nil)
        if options.nil?
          @options = {}
        else
          @options = options
          parse_options
        end
      end

      # Sets the width for a chart
      def width=(width)
        @width = width.to_s

        setOption('width', @width)
      end

      # Sets the height for a chart
      def height=(height)
        @height = height.to_s

        setOption('height', @height)
      end

      # Set the type for a chart
      def type=(type)
        @type = type

        setOption('type', @type)
      end

      # Sets the dataformat for a chart.
      # Valid values are: json / xml
      def dataFormat=(format)
        @dataFormat = format

        setOption('dataFormat', @dataFormat)
      end

      # Set the DOM id where the chart needs to be rendered
      def renderAt=(id)
        @renderAt = id

        setOption('renderAt',  @renderAt)
      end
      
      # Set the datasource for the chart. It can take the followinf formats
      # 1. Ruby Hash
      # 2. XML string
      # 3. JSON string
      def dataSource=(dataSource)
        @dataSource = dataSource
        parse_datasource_json
      end

      # Set the JSON url where data needs to be loaded
      def jsonUrl=(url)
        @jsonUrl = url
      end

      # Set the XML url where data needs to be loaded
      def xmlUrl=(url)
        @xmlUrl = url
      end

      # Returns where the chart needs to load XML data from a url
      def xmlUrl?
        self.xmlUrl ? true : false
      end

      # Returns where the chart needs to load JSON data from a url
      def jsonUrl?
        self.jsonUrl ? true : false
      end

      # Render the chart
      def render
        config = json_escape JSON.generate(self.options)
        dataUrlFormat = self.jsonUrl? ? "json" : ( self.xmlUrl ? "xml" : nil )
        template = File.read(File.expand_path("../../../templates/chart.erb", __FILE__))
        renderer = ERB.new(template)
        raw renderer.result(binding)
      end

      private
      # Helper method to add property to the options hash
      def setOption(key, value)
        self.options[key] = value

        return self
      end

      # Helper method to convert json string to Ruby hash
      def parse_datasource_json
        @dataFormat = "json" unless defined? @dataFormat

        if !xmlUrl? or !jsonUrl?
          @dataSource = JSON.parse(@dataSource) if @dataSource.is_a? String and @dataFormat == "json"
        end

        setOption('dataSource', @dataSource)
      end

      # Helper method that converts the constructor params into instance variables
      def parse_options
        keys = @options.keys

        keys.each{ |k| instance_variable_set "@#{k}".to_sym, @options[k] if self.respond_to? k }
        parse_datasource_json
      end

      # Escape tags in json, if avoided might be vulnerable to XSS
      def json_escape(str)
        str.to_s.gsub('/', '\/')
      end

    end

end
