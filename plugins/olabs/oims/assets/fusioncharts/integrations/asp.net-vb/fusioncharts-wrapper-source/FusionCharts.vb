using System;
using System.Text;
using System.Collections;
using System.Web.UI.WebControls;
using System.Web;
using System.Collections.Generic;
using System.Globalization;

namespace FusionCharts.Charts
{
    /// <summary>
    /// Contains static methods to render FusionCharts in the Page. 
    /// </summary>
    public class Chart: ICloneable
    {
        private Hashtable __CONFIG__ = null;
        private static Hashtable __PARAMMAP__ = null;

        /// <summary>
        /// User configurable chart parameter list 
        /// </summary>
        public enum ChartParameter
        {
            chartType,
            chartId,
            chartWidth,
            chartHeight,
            dataFormat,
            dataSource,
            renderAt,
            bgColor,
            bgOpacity
        }

        /// <summary>
        /// List of supported data formats
        /// </summary>
        public enum DataFormat
        {
            json,
            jsonurl,
            xml,
            xmlurl,
            csv
        }

        #region constructor methods
        /// <summary>
        /// Chart constructor
        /// Chart configuration parameters can be supplyed to the constructor also.
        /// </summary>
        public Chart()
        {
            __INIT();
        }


        /// <summary>
        /// Chart constructor
        /// </summary>
        /// <param name="chartType">The type of chart that you intend to plot</param>
        public Chart(string chartType)
        {
            __INIT();

            SetChartParameter("type", chartType);
        }

        /// <summary>
        /// Chart constructor
        /// </summary>
        /// <param name="chartType">The type of chart that you intend to plot</param>
        /// <param name="chartId">Id for the chart, using which it will be recognized in the HTML page. Each chart on the page needs to have a unique Id.</param>
        public Chart(string chartType, string chartId)
        {
            __INIT();

            SetChartParameter("type", chartType);
            SetChartParameter("id", chartId);
        }

        /// <summary>
        /// Chart constructor
        /// </summary>
        /// <param name="chartType">The type of chart that you intend to plot</param>
        /// <param name="chartId">Id for the chart, using which it will be recognized in the HTML page. Each chart on the page needs to have a unique Id.</param>
        /// <param name="chartWidth">Intended width for the chart (in pixels)</param>
        public Chart(string chartType, string chartId, string chartWidth)
        {
            __INIT();

            SetChartParameter("type", chartType);
            SetChartParameter("id", chartId);
            SetChartParameter("width", chartWidth);
        }

        /// <summary>
        /// Chart constructor
        /// </summary>
        /// <param name="chartType">The type of chart that you intend to plot</param>
        /// <param name="chartId">Id for the chart, using which it will be recognized in the HTML page. Each chart on the page needs to have a unique Id.</param>
        /// <param name="chartWidth">Intended width for the chart (in pixels)</param>
        /// <param name="chartHeight">Intended height for the chart (in pixels)</param>
        public Chart(string chartType, string chartId, string chartWidth, string chartHeight)
        {
            __INIT();

            SetChartParameter("type", chartType);
            SetChartParameter("id", chartId);
            SetChartParameter("width", chartWidth);
            SetChartParameter("height", chartHeight);
        }

        /// <summary>
        /// Chart constructor
        /// </summary>
        /// <param name="chartType">The type of chart that you intend to plot</param>
        /// <param name="chartId">Id for the chart, using which it will be recognized in the HTML page. Each chart on the page needs to have a unique Id.</param>
        /// <param name="chartWidth">Intended width for the chart (in pixels)</param>
        /// <param name="chartHeight">Intended height for the chart (in pixels)</param>
        /// <param name="dataFormat">Data format. e.g. json, jsonurl, csv, xml, xmlurl</param>
        public Chart(string chartType, string chartId, string chartWidth, string chartHeight, string dataFormat)
        {
            __INIT();

            SetChartParameter("type", chartType);
            SetChartParameter("dataFormat", dataFormat);
            SetChartParameter("id", chartId);
            SetChartParameter("width", chartWidth);
            SetChartParameter("height", chartHeight);
        }

        /// <summary>
        /// Chart constructor
        /// </summary>
        /// <param name="chartType">The type of chart that you intend to plot</param>
        /// <param name="chartId">Id for the chart, using which it will be recognized in the HTML page. Each chart on the page needs to have a unique Id.</param>
        /// <param name="chartWidth">Intended width for the chart (in pixels)</param>
        /// <param name="chartHeight">Intended height for the chart (in pixels)</param>
        /// <param name="dataFormat">Data format. e.g. json, jsonurl, csv, xml, xmlurl</param>
        /// <param name="dataSource">Data for the chart</param>
        public Chart(string chartType, string chartId, string chartWidth, string chartHeight, string dataFormat, string dataSource)
        {
            __INIT();

            SetChartParameter("type", chartType);
            SetChartParameter("dataFormat", dataFormat);
            SetData(dataSource);
            SetChartParameter("id", chartId);
            SetChartParameter("width", chartWidth);
            SetChartParameter("height", chartHeight);
        }

        /// <summary>
        /// Chart constructor
        /// </summary>
        /// <param name="chartType">The type of chart that you intend to plot</param>
        /// <param name="chartId">Id for the chart, using which it will be recognized in the HTML page. Each chart on the page needs to have a unique Id.</param>
        /// <param name="chartWidth">Intended width for the chart (in pixels)</param>
        /// <param name="chartHeight">Intended height for the chart (in pixels)</param>
        /// <param name="dataFormat">Data format. e.g. json, jsonurl, csv, xml, xmlurl</param>
        /// <param name="dataSource">Data for the chart</param>
        /// <param name="bgColor">Background color of the chart container</param>
        public Chart(string chartType, string chartId, string chartWidth, string chartHeight, string dataFormat, string dataSource,
            string bgColor)
        {
            __INIT();

            SetChartParameter("type", chartType);
            SetChartParameter("dataFormat", dataFormat);
            SetData(dataSource);
            SetChartParameter("id", chartId);
            SetChartParameter("width", chartWidth);
            SetChartParameter("height", chartHeight);
            SetChartParameter("containerBackgroundColor", bgColor);
        }

        /// <summary>
        /// Chart constructor
        /// </summary>
        /// <param name="chartType">The type of chart that you intend to plot</param>
        /// <param name="chartId">Id for the chart, using which it will be recognized in the HTML page. Each chart on the page needs to have a unique Id.</param>
        /// <param name="chartWidth">Intended width for the chart (in pixels)</param>
        /// <param name="chartHeight">Intended height for the chart (in pixels)</param>
        /// <param name="dataFormat">Data format. e.g. json, jsonurl, csv, xml, xmlurl</param>
        /// <param name="dataSource">Data for the chart</param>
        /// <param name="bgColor">Back-ground-color of the chart container</param>
        /// <param name="bgOpacity">Background opacity of the chart container</param>
        public Chart(string chartType, string chartId, string chartWidth, string chartHeight, string dataFormat, string dataSource,
            string bgColor, string bgOpacity)
        {
            __INIT();

            SetChartParameter("type", chartType);
            SetChartParameter("dataFormat", dataFormat);
            SetData(dataSource);
            SetChartParameter("id", chartId);
            SetChartParameter("width", chartWidth);
            SetChartParameter("height", chartHeight);
            SetChartParameter("containerBackgroundColor", bgColor);
            SetChartParameter("containerBackgroundOpacity", bgOpacity);
        }
         #endregion

        #region RenderALL methods

        /// <summary>
        /// Generate html code for rendering chart
        /// This function assumes that you've already included the FusionCharts JavaScript class in your page
        /// </summary>
        /// <returns>JavaScript + HTML code required to embed a chart</returns>
        private string RenderChartALL()
        {

            string dataSource = GetChartParameter("dataSource");
            string dataFormat = GetChartParameter("dataFormat");
            string chartId = GetChartParameter("id");
            string renderAt = GetChartParameter("renderAt");

           
            
            StringBuilder builder = new StringBuilder();
            builder.AppendFormat("<!-- Using ASP.NET FusionCharts Wrapper and JavaScript rendering --><!-- START Script Block for Chart {0} -->" + Environment.NewLine, chartId);
            // if the user has provided renderAt then assume that the HTML container is already present in the page.
            if (renderAt.Trim().Length == 0)
            {
                renderAt = chartId + "_div";
                // Now create the container div also.
                builder.AppendFormat("<div id='{0}' >" + Environment.NewLine, renderAt);
                builder.Append("Chart..." + Environment.NewLine);
                builder.Append("</div>" + Environment.NewLine);
            }

            string chartConfigJSON = fc_encodeJSON(GetConfigurationGroup("params"), true);

            builder.Append("<script type=\"text/javascript\">" + Environment.NewLine);
            builder.Append("FusionCharts && FusionCharts.ready(function () {" + Environment.NewLine);
            builder.AppendFormat("if (FusionCharts(\"{0}\") ) FusionCharts(\"{0}\").dispose();\n", chartId);
            builder.AppendFormat("var chart_{0} = new FusionCharts({1}).render();" + Environment.NewLine, chartId, chartConfigJSON);
            builder.Append("});" + Environment.NewLine);
            builder.Append("</script>" + Environment.NewLine);
            builder.AppendFormat("<!-- END Script Block for Chart {0} -->" + Environment.NewLine, chartId);

            return builder.ToString();

        }

        #endregion

        #region Public Methods
        /// <summary>
        /// Public method to clone an exiting FusionCharts instance
        /// To make the chartId unique, this function will add "_clone" as suffix in the clone chart's Id.
        /// </summary>
        public object Clone()
        {
            Chart ChartClone = new Chart();
            ChartClone.__CONFIG__ = (Hashtable)this.__CONFIG__.Clone();
            ChartClone.SetChartParameter("id", ((Hashtable)ChartClone.__CONFIG__["params"])["id"].ToString() + "_clone");

            return ChartClone;
        }

        /// <summary>
        /// Public method to generate html code for rendering chart
        /// This function assumes that you've already included the FusionCharts JavaScript class in your page
        /// </summary>
        /// <returns>JavaScript + HTML code required to embed a chart</returns>
        public string Render()
        {
            return RenderChartALL();
        }

        /// <summary>
        /// Public method to generate html code for rendering chart
        /// This function assumes that you've already included the FusionCharts JavaScript class in your page
        /// </summary>
        /// <param name="chartType">The type of chart that you intend to plot</param>
        /// <returns>JavaScript + HTML code required to embed a chart</returns>

        public string Render(string chartType)
        {
            SetChartParameter("type", chartType);

            return RenderChartALL();
        }

        /// <summary>
        /// Public method to generate html code for rendering chart
        /// This function assumes that you've already included the FusionCharts JavaScript class in your page
        /// </summary>
        /// <param name="chartType">The type of chart that you intend to plot</param>
        /// <param name="chartId">Id for the chart, using which it will be recognized in the HTML page. Each chart on the page needs to have a unique Id.</param>
        /// <returns>JavaScript + HTML code required to embed a chart</returns>

        public string Render(string chartType, string chartId)
        {
            SetChartParameter("type", chartType);
            SetChartParameter("id", chartId);

            return RenderChartALL();
        }

        /// <summary>
        /// Public method to generate html code for rendering chart
        /// This function assumes that you've already included the FusionCharts JavaScript class in your page
        /// </summary>
        /// <param name="chartType">The type of chart that you intend to plot</param>
        /// <param name="chartId">Id for the chart, using which it will be recognized in the HTML page. Each chart on the page needs to have a unique Id.</param>
        /// <param name="chartWidth">Intended width for the chart (in pixels)</param>
        /// <returns>JavaScript + HTML code required to embed a chart</returns>

        public string Render(string chartType, string chartId, string chartWidth)
        {
            SetChartParameter("type", chartType);
            SetChartParameter("id", chartId);
            SetChartParameter("width", chartWidth);

            return RenderChartALL();
        }

        /// <summary>
        /// Public method to generate html code for rendering chart
        /// This function assumes that you've already included the FusionCharts JavaScript class in your page
        /// </summary>
        /// <param name="chartType">The type of chart that you intend to plot</param>
        /// <param name="chartId">Id for the chart, using which it will be recognized in the HTML page. Each chart on the page needs to have a unique Id.</param>
        /// <param name="chartWidth">Intended width for the chart (in pixels)</param>
        /// <param name="chartHeight">Intended height for the chart (in pixels)</param>
        /// <returns>JavaScript + HTML code required to embed a chart</returns>

        public string Render(string chartType, string chartId, string chartWidth, string chartHeight)
        {
            SetChartParameter("type", chartType);
            SetChartParameter("id", chartId);
            SetChartParameter("width", chartWidth);
            SetChartParameter("height", chartHeight);

            return RenderChartALL();
        }

        /// <summary>
        /// Public method to generate html code for rendering chart
        /// This function assumes that you've already included the FusionCharts JavaScript class in your page
        /// </summary>
        /// <param name="chartType">The type of chart that you intend to plot</param>
        /// <param name="chartId">Id for the chart, using which it will be recognized in the HTML page. Each chart on the page needs to have a unique Id.</param>
        /// <param name="chartWidth">Intended width for the chart (in pixels)</param>
        /// <param name="chartHeight">Intended height for the chart (in pixels)</param>
        /// <param name="dataFormat">Data format. e.g. json, jsonurl, csv, xml, xmlurl</param>
        /// <returns>JavaScript + HTML code required to embed a chart</returns>

        public string Render(string chartType, string chartId, string chartWidth, string chartHeight, string dataFormat)
        {
            SetChartParameter("type", chartType);
            SetChartParameter("dataFormat", dataFormat);
            SetChartParameter("id", chartId);
            SetChartParameter("width", chartWidth);
            SetChartParameter("height", chartHeight);

            return RenderChartALL();
        }

        /// <summary>
        /// Public method to generate html code for rendering chart
        /// This function assumes that you've already included the FusionCharts JavaScript class in your page
        /// </summary>
        /// <param name="chartType">The type of chart that you intend to plot</param>
        /// <param name="chartId">Id for the chart, using which it will be recognized in the HTML page. Each chart on the page needs to have a unique Id.</param>
        /// <param name="chartWidth">Intended width for the chart (in pixels)</param>
        /// <param name="chartHeight">Intended height for the chart (in pixels)</param>
        /// <param name="dataFormat">Data format. e.g. json, jsonurl, csv, xml, xmlurl</param>
        /// <param name="dataSource">Data for the chart</param>
        /// <returns>JavaScript + HTML code required to embed a chart</returns>

        public string Render(string chartType, string chartId, string chartWidth, string chartHeight, string dataFormat, string dataSource)
        {
            SetChartParameter("type", chartType);
            SetChartParameter("dataFormat", dataFormat);
            SetData(dataSource);
            SetChartParameter("id", chartId);
            SetChartParameter("width", chartWidth);
            SetChartParameter("height", chartHeight);

            return RenderChartALL();
        }


        /// <summary>
        /// Public method to generate html code for rendering chart
        /// This function assumes that you've already included the FusionCharts JavaScript class in your page
        /// </summary>
        /// <param name="chartType">The type of chart that you intend to plot</param>
        /// <param name="chartId">Id for the chart, using which it will be recognized in the HTML page. Each chart on the page needs to have a unique Id.</param>
        /// <param name="chartWidth">Intended width for the chart (in pixels)</param>
        /// <param name="chartHeight">Intended height for the chart (in pixels)</param>
        /// <param name="dataFormat">Data format. e.g. json, jsonurl, csv, xml, xmlurl</param>
        /// <param name="dataSource">Data for the chart</param>
        /// <param name="bgColor">Background color of the chart container</param>
        /// <returns>JavaScript + HTML code required to embed a chart</returns>

        public string Render(string chartType, string chartId, string chartWidth, string chartHeight, string dataFormat, string dataSource,
            string bgColor)
        {
            SetChartParameter("type", chartType);
            SetChartParameter("dataFormat", dataFormat);
            SetData(dataSource);
            SetChartParameter("id", chartId);
            SetChartParameter("width", chartWidth);
            SetChartParameter("height", chartHeight);
            SetChartParameter("containerBackgroundColor", bgColor);

            return RenderChartALL();
        }


        /// <summary>
        /// Public method to generate html code for rendering chart
        /// This function assumes that you've already included the FusionCharts JavaScript class in your page
        /// </summary>
        /// <param name="chartType">The type of chart that you intend to plot</param>
        /// <param name="chartId">Id for the chart, using which it will be recognized in the HTML page. Each chart on the page needs to have a unique Id.</param>
        /// <param name="chartWidth">Intended width for the chart (in pixels)</param>
        /// <param name="chartHeight">Intended height for the chart (in pixels)</param>
        /// <param name="dataFormat">Data format. e.g. json, jsonurl, csv, xml, xmlurl</param>
        /// <param name="dataSource">Data for the chart</param>
        /// <param name="bgColor">Background color of the chart container</param>
        /// <param name="bgOpacity">Background opacity of the chart container</param>
        /// <returns>JavaScript + HTML code required to embed a chart</returns>

        public string Render(string chartType, string chartId, string chartWidth, string chartHeight, string dataFormat, string dataSource,
            string bgColor, string bgOpacity)
        {
            SetChartParameter("type", chartType);
            SetChartParameter("dataFormat", dataFormat);
            SetData(dataSource);
            SetChartParameter("id", chartId);
            SetChartParameter("width", chartWidth);
            SetChartParameter("height", chartHeight);
            SetChartParameter("containerBackgroundColor", bgColor);
            SetChartParameter("containerBackgroundOpacity", bgOpacity);

            return RenderChartALL();
        }



        

        /// <summary>
        /// SetChartParameter sets various configurations of a FusionCharts instance
        /// </summary>
        /// <param name="param">Name of chart parameter</param>
        /// <param name="value">Value of chart parameter</param>
        public void SetChartParameter(ChartParameter param, object value)
        {

            SetChartParameter(__PARAMMAP__[param.ToString()].ToString(), value);
        }

        /// <summary>
        /// GetChartParameter returns the value of a parameter of a FusionCharts instance
        /// </summary>
        /// <param name="param">Name of chart parameter</param>
        /// <returns>String</returns>
       
        public string GetChartParameter(ChartParameter param)
        {
            return GetChartParameter(__PARAMMAP__[param.ToString()].ToString());
        }

        /// <summary>
        /// This method to set the data for the chart
        /// </summary>
        /// <param name="dataSource">Data for the chart</param>

        public void SetData(string dataSource)
        {
            SetChartParameter("dataSource", dataSource);
        }

        /// <summary>
        /// This method to set the data for the chart
        /// </summary>
        /// <param name="dataSource">Data for the chart</param>
        /// <param name="dataFormat">Data format. e.g. json, jsonurl, csv, xml, xmlurl</param>
        public void SetData(string dataSource, DataFormat format)
        {
            SetChartParameter("dataSource", dataSource);
            SetChartParameter("dataFormat", format.ToString());
        }

        #endregion



        #region Helper Private Methods

        /// <summary>
        /// SetConfiguration sets various configurations of FusionCharts
        /// It takes configuration names as first parameter and its value a second parameter
        /// There are config groups which can contain common configuration names. All config names in all groups gets set with this value
        /// unless group is specified explicitly
        /// </summary>
        /// <param name="setting">Name of configuration</param>
        /// <param name="value">Value of configuration</param>
        private void SetChartParameter(string setting, object value)
        {
            if (((Hashtable)__CONFIG__["params"]).ContainsKey(setting))
            {
                ((Hashtable)__CONFIG__["params"])[setting] = value;
            }
        }

        
        private void SetParamsMap()
        {
            if (__PARAMMAP__ == null)
            {
                __PARAMMAP__ = new Hashtable(StringComparer.InvariantCultureIgnoreCase);
                __PARAMMAP__["chartType"] = "type";
                __PARAMMAP__["chartId"] = "id";
                __PARAMMAP__["chartWidth"] = "width";
                __PARAMMAP__["chartHeight"] = "height";
                __PARAMMAP__["dataFormat"] = "dataFormat";
                __PARAMMAP__["dataSource"] = "dataSource";
                __PARAMMAP__["renderAt"] = "renderAt";
                __PARAMMAP__["bgColor"] = "containerBackgroundColor";
                __PARAMMAP__["bgOpacity"] = "containerBackgroundOpacity";
            }

        }

        private void __INIT()
        {
            __CONFIG__ = new Hashtable(StringComparer.InvariantCultureIgnoreCase);
            Hashtable param = new Hashtable(StringComparer.InvariantCultureIgnoreCase);
            param["type"] = "";
            param["width"] = "";
            param["height"] = "";
            param["renderAt"] = "";
            param["dataSource"] = "";
            param["dataFormat"] = "";
            param["id"] = Guid.NewGuid().ToString().Replace("-", "_");
            param["containerBackgroundColor"] = "";
            param["containerBackgroundOpacity"] = "";

            __CONFIG__["params"] = param;

            param = null;
            SetParamsMap();
        }

        

        /// <summary>
        /// Transform the meaning of boolean value in integer value
        /// </summary>
        /// <param name="value">true/false value to be transformed</param>
        /// <returns>1 if the value is true, 0 if the value is false</returns>
        private static int boolToNum(bool value)
        {
            return value ? 1 : 0;
        }


        private string GetChartParameter(string setting)
        {
            if (((Hashtable)__CONFIG__["params"]).ContainsKey(setting))
            {
                return ((Hashtable)__CONFIG__["params"])[setting].ToString();
            }
            return null;
        }


        private string fc_encodeJSON(Hashtable json, bool enclosed)
        {
            string strjson = "", Key = "", Value = "";
            
            foreach (DictionaryEntry ds in json)
            {
                if (ds.Value.ToString().Trim() != "")
                {
                    Key = ds.Key.ToString();
                    Value = ds.Value.ToString();
                    // If this is not the dataSource then convert the value as JavaScript string
                    if (Key.ToLower().Equals("datasource"))
                    {
                        // Remove new line char from the dataSource
                        Value.Replace("\n\r", "");
                        // detect if non-JSON format then wrap with quot '"'
                        if (!(Value.StartsWith("{") && Value.EndsWith("}")))
                        {
                            Value = "\"" + Value + "\"";
                        }
                    }
                    else {
                        Value = "\"" + Value + "\"";
                    }
                    strjson = strjson + Environment.NewLine + "\"" + Key + "\" : " + Value + ", ";
                }
                else if (ds.Key.ToString().Equals("renderAt"))
                {
                    strjson = strjson + Environment.NewLine + "\"renderAt\" : \"" + ((Hashtable)json)["id"].ToString() + "_div\", ";
                }
            }
            // remove ending comma
            if (strjson.EndsWith(",")) strjson = strjson.Remove(strjson.Length - 1);

            if (enclosed == true)
            {
                strjson = "{" + strjson + Environment.NewLine + "}";
            }

            return strjson;
        }

        private Hashtable GetConfigurationGroup(string setting)
        {
            if (__CONFIG__.ContainsKey(setting))
            {
                return (Hashtable)__CONFIG__[setting];
            }
            return null;
        }

        #endregion

    }
}



namespace InfoSoftGlobal
{
    /// <summary>
    /// Contains static methods to render FusionCharts in the Page.
    /// 
    /// @version: v3.2.2.2 
    /// @date: 15 August 2012
    /// 
    /// </summary>
    public class FusionCharts
    {

        //private static Hashtable __CONFIG__ = new Hashtable(new CaseInsensitiveHashCodeProvider(), new CaseInsensitiveComparer());
        private static Hashtable __CONFIG__ = new Hashtable(StringComparer.InvariantCultureIgnoreCase);
        private static bool __CONFIG__Initialized = false;

        #region RenderALL methods

        /// <summary>
        /// Generate html code for rendering chart
        /// This function assumes that you've already included the FusionCharts JavaScript class in your page
        /// </summary>
        /// <param name="chartSWF">SWF File Name (and Path) of the chart which you intend to plot</param>
        /// <param name="dataUrl">If you intend to use dataURL method for this chart, pass the URL as this parameter. Else, set it to "" (in case of dataXML method)</param>
        /// <param name="dataStr">If you intend to use dataXML method for this chart, pass the XML data as this parameter. Else, set it to "" (in case of dataURL method)</param>
        /// <param name="chartId">Id for the chart, using which it will be recognized in the HTML page. Each chart on the page needs to have a unique Id.</param>
        /// <param name="chartWidth">Intended width for the chart (in pixels)</param>
        /// <param name="chartHeight">Intended height for the chart (in pixels)</param>
        /// <param name="debugMode">Whether to start the chart in debug mode</param>
        /// <param name="registerWithJS">Whether to ask chart to register itself with JavaScript</param>
        /// <param name="allowTransparent">Whether allowTransparent chart (true / false)</param>
        /// <param name="bgColor">Back Ground Color</param>
        /// <param name="scaleMode">Set Scale Mode</param>
        /// <param name="language">Set SWF file Language</param>
        /// <returns>JavaScript + HTML code required to embed a chart</returns>
        private static string RenderChartALL(string chartSWF, string dataUrl, string dataStr, string chartId, string chartWidth, string chartHeight,
            bool debugMode, bool registerWithJS, bool allowTransparent, string bgColor, string scaleMode, string language)
        {
            __INIT();

            // Creating a local copy of global Configuration.
            Hashtable __CONFIGCLONE__ = (Hashtable)__CONFIG__.Clone();

            // string dataprovider_js_code;
            SetConfiguration(ref __CONFIGCLONE__, "debugMode", boolToNum(debugMode));
            SetConfiguration(ref __CONFIGCLONE__, "registerWithJS", boolToNum(true));

            // setup debug mode js parameter
            int debugMode_js_param = boolToNum(debugMode);
            // setup register with js js parameter
            int registerWithJS_js_param = boolToNum(true);
            string dataFormat = GetConfiguration(ref __CONFIGCLONE__, "dataFormat");
            dataFormat = (dataFormat == "" ? "xml" + (dataStr == "" ? "url" : "") : dataFormat + (dataStr == "" ? "url" : ""));

            if (GetConfiguration(ref __CONFIGCLONE__, "renderAt") == "") SetConfiguration(ref __CONFIGCLONE__, "renderAt", chartId + "Div");

            string wmode = GetConfiguration(ref __CONFIGCLONE__, "wMode");
            if (wmode.Trim() == "" || wmode == null)
            {
                wmode = allowTransparent ? "transparent" : "opaque";
            }

            SetConfiguration(ref __CONFIGCLONE__, "swfUrl", chartSWF);
            SetConfiguration(ref __CONFIGCLONE__, "dataFormat", dataFormat);
            SetConfiguration(ref __CONFIGCLONE__, "id", chartId);
            SetConfiguration(ref __CONFIGCLONE__, "width", chartWidth);
            SetConfiguration(ref __CONFIGCLONE__, "height", chartHeight);
            SetConfiguration(ref __CONFIGCLONE__, "wMode", wmode);

            SetConfiguration(ref __CONFIGCLONE__, "bgColor", bgColor);
            SetConfiguration(ref __CONFIGCLONE__, "scaleMode", scaleMode);
            SetConfiguration(ref __CONFIGCLONE__, "lang", language);


            string dataSource = (dataStr == "" ? dataUrl : dataStr.Replace("\n\r", ""));
            string dataSourceJSON = "\"dataSource\" : " + (dataFormat == "json" ? dataSource : "\"" + dataSource + "\"");
            string chartConfigJSON = "{" + fc_encodeJSON(GetConfigurationGroup(ref __CONFIGCLONE__, "params"), false) + "," + dataSourceJSON + "}";

            StringBuilder builder = new StringBuilder();
            builder.AppendFormat("<!-- Using ASP.NET FusionCharts v3.2.2.1 Wrapper and JavaScript rendering --><!-- START Script Block for Chart {0} -->" + Environment.NewLine, chartId);
            builder.AppendFormat("<div id='{0}Div' >" + Environment.NewLine, chartId);
            builder.Append("Chart." + Environment.NewLine);
            builder.Append("</div>" + Environment.NewLine);
            builder.Append("<script type=\"text/javascript\">" + Environment.NewLine);
            builder.AppendFormat("if (FusionCharts && FusionCharts(\"{0}\") ) FusionCharts(\"{0}\").dispose();\n", chartId);
            builder.AppendFormat("var chart_{0} = new FusionCharts({1}).render();", chartId, chartConfigJSON);
            builder.Append("</script>" + Environment.NewLine);
            builder.AppendFormat("<!-- END Script Block for Chart {0} -->" + Environment.NewLine, chartId);

            // Re-Initializing...
            __fc__initialize__();

            __CONFIGCLONE__ = null;

            return builder.ToString();



        }


        

        /// <summary>
        /// Renders the HTML code for the chart. This
        /// method does NOT embed the chart using JavaScript class. Instead, it uses
        /// direct HTML embedding. So, if you see the charts on IE 6 (or above), you'll
        /// see the "Click to activate..." message on the chart.
        /// </summary>
        /// <param name="chartSWF">SWF File Name (and Path) of the chart which you intend to plot</param>
        /// <param name="dataUrl">If you intend to use dataURL method for this chart, pass the URL as this parameter. Else, set it to "" (in case of dataXML method)</param>
        /// <param name="dataStr">If you intend to use dataXML method for this chart, pass the XML data as this parameter. Else, set it to "" (in case of dataURL method)</param>
        /// <param name="chartId">Id for the chart, using which it will be recognized in the HTML page. Each chart on the page needs to have a unique Id.</param>
        /// <param name="chartWidth">Intended width for the chart (in pixels)</param>
        /// <param name="chartHeight">Intended height for the chart (in pixels)</param>
        /// <param name="debugMode">Whether to start the chart in debug mode</param>
        /// <param name="registerWithJS">Whether to ask chart to register itself with JavaScript</param>
        /// <param name="allowTransparent">Whether allowTransparent chart (true / false)</param>
        /// <param name="bgColor">Back Ground Color</param>
        /// <param name="scaleMode">Set Scale Mode</param>
        /// <param name="language">Set SWF file Language</param>
        /// <returns></returns>
        private static string RenderChartHTMLALL(string chartSWF, string dataUrl, string dataStr, string chartId, string chartWidth, string chartHeight, 
            bool debugMode, bool registerWithJS, bool allowTransparent, string bgColor, string scaleMode, string language)
        {
            __INIT();

            // Creating a local copy of global Configuration.
            Hashtable __CONFIGCLONE__ = (Hashtable)__CONFIG__.Clone();

            string wmode = GetConfiguration(ref __CONFIGCLONE__, "wMode");
            if (wmode.Trim() == "" || wmode == null)
            {
                wmode = allowTransparent ? "transparent" : "opaque";
            }

            SetConfiguration(ref __CONFIGCLONE__, "data", chartSWF);
            SetConfiguration(ref __CONFIGCLONE__, "movie", chartSWF);
            
            SetConfiguration(ref __CONFIGCLONE__, "dataURL", dataUrl);
            SetConfiguration(ref __CONFIGCLONE__, "dataXML", dataStr);

            SetConfiguration(ref __CONFIGCLONE__, "DOMId", chartId);
            SetConfiguration(ref __CONFIGCLONE__, "id", chartId);
            
            SetConfiguration(ref __CONFIGCLONE__, "width", chartWidth);
            SetConfiguration(ref __CONFIGCLONE__, "chartWidth", chartWidth);
            
            SetConfiguration(ref __CONFIGCLONE__, "height", chartHeight);
            SetConfiguration(ref __CONFIGCLONE__, "chartHeight", chartHeight);
            
            SetConfiguration(ref __CONFIGCLONE__, "debugMode", boolToNum(debugMode));
            SetConfiguration(ref __CONFIGCLONE__, "registerWithJS", boolToNum(true));
            
            SetConfiguration(ref __CONFIGCLONE__, "wMode", wmode);

            SetConfiguration(ref __CONFIGCLONE__, "bgColor", bgColor);
            SetConfiguration(ref __CONFIGCLONE__, "scaleMode", scaleMode);
            SetConfiguration(ref __CONFIGCLONE__, "lang", language);
            

            string strFlashVars = FC_Transform(GetConfigurationGroup(ref __CONFIGCLONE__, "fvars"), "&{key}={value}", true);
            SetConfiguration(ref __CONFIGCLONE__, "flashvars", strFlashVars);

            string strObjectNode = FC_Transform(GetConfigurationGroup(ref __CONFIGCLONE__, "object"), " {key}=\"{value}\"", true) ;
            string strObjectParamsNode = FC_Transform(GetConfigurationGroup(ref __CONFIGCLONE__, "objparams"), "\t<param name=\"{key}\" value=\"{value}\">\n", true);


            StringBuilder htmlcodes = new StringBuilder();

            htmlcodes.AppendFormat("<!-- Using ASP.NET FusionCharts v3.2.2.1 Wrapper --><!-- START HTML Code Block for Chart {0} -->\n", chartId);
            htmlcodes.AppendFormat("<object classid='clsid:d27cdb6e-ae6d-11cf-96b8-444553540000' {0}>\n" , strObjectNode);
            htmlcodes.Append(strObjectParamsNode + Environment.NewLine);
            htmlcodes.AppendFormat("<!--[if !IE]>-->\n<object type='application/x-shockwave-flash' {0}>\n{1}</object>\n<!--<![endif]-->\n</object>\n", strObjectNode, strObjectParamsNode); 
            htmlcodes.AppendFormat("<!-- END HTML Code Block for Chart {0} -->\n", chartId);

            // Re-Initializing...
            __fc__initialize__();

            return htmlcodes.ToString();
        }
        #endregion

        /// <summary>
        /// Generate html code for rendering chart
        /// This function assumes that you've already included the FusionCharts JavaScript class in your page
        /// </summary>
        /// <param name="chartSWF">SWF File Name (and Path) of the chart which you intend to plot</param>
        /// <param name="dataUrl">If you intend to use dataURL method for this chart, pass the URL as this parameter. Else, set it to "" (in case of dataXML method)</param>
        /// <param name="dataStr">If you intend to use dataXML method for this chart, pass the XML data as this parameter. Else, set it to "" (in case of dataURL method)</param>
        /// <param name="chartId">Id for the chart, using which it will be recognized in the HTML page. Each chart on the page needs to have a unique Id.</param>
        /// <param name="chartWidth">Intended width for the chart (in pixels)</param>
        /// <param name="chartHeight">Intended height for the chart (in pixels)</param>
        /// <param name="debugMode">Whether to start the chart in debug mode</param>
        /// <param name="registerWithJS">Whether to ask chart to register itself with JavaScript</param>
        /// <returns>JavaScript + HTML code required to embed a chart</returns>
        [Obsolete("")]
        public static string RenderChart(string chartSWF, string dataUrl, string dataStr, string chartId, string chartWidth, string chartHeight, bool debugMode, bool registerWithJS)
        {
            return RenderChartALL(chartSWF, dataUrl, dataStr, chartId, chartWidth, chartHeight, debugMode, registerWithJS, false, "", "noScale", "EN");
        }

        /// <summary>
        /// Generate html code for rendering chart
        /// This function assumes that you've already included the FusionCharts JavaScript class in your page
        /// </summary>
        /// <param name="chartSWF">SWF File Name (and Path) of the chart which you intend to plot</param>
        /// <param name="dataUrl">If you intend to use dataURL method for this chart, pass the URL as this parameter. Else, set it to "" (in case of dataXML method)</param>
        /// <param name="dataStr">If you intend to use dataXML method for this chart, pass the XML data as this parameter. Else, set it to "" (in case of dataURL method)</param>
        /// <param name="chartId">Id for the chart, using which it will be recognized in the HTML page. Each chart on the page needs to have a unique Id.</param>
        /// <param name="chartWidth">Intended width for the chart (in pixels)</param>
        /// <param name="chartHeight">Intended height for the chart (in pixels)</param>
        /// <param name="debugMode">Whether to start the chart in debug mode</param>
        /// <param name="registerWithJS">Whether to ask chart to register itself with JavaScript</param>
        /// <param name="allowTransparent">Whether allowTransparent chart (true / false)</param>
        /// <returns>JavaScript + HTML code required to embed a chart</returns>
        [Obsolete("")]
        public static string RenderChart(string chartSWF, string dataUrl, string dataStr, string chartId, string chartWidth, string chartHeight, bool debugMode, bool registerWithJS, bool allowTransparent)
        {
            return RenderChartALL(chartSWF, dataUrl, dataStr, chartId, chartWidth, chartHeight, debugMode, registerWithJS, allowTransparent, "", "noScale", "EN");
        }

        /// <summary>
        /// Generate html code for rendering chart
        /// This function assumes that you've already included the FusionCharts JavaScript class in your page
        /// </summary>
        /// <param name="chartSWF">SWF File Name (and Path) of the chart which you intend to plot</param>
        /// <param name="dataUrl">If you intend to use dataURL method for this chart, pass the URL as this parameter. Else, set it to "" (in case of dataXML method)</param>
        /// <param name="dataStr">If you intend to use dataXML method for this chart, pass the XML data as this parameter. Else, set it to "" (in case of dataURL method)</param>
        /// <param name="chartId">Id for the chart, using which it will be recognized in the HTML page. Each chart on the page needs to have a unique Id.</param>
        /// <param name="chartWidth">Intended width for the chart (in pixels)</param>
        /// <param name="chartHeight">Intended height for the chart (in pixels)</param>
        /// <param name="debugMode">Whether to start the chart in debug mode</param>
        /// <param name="registerWithJS">Whether to ask chart to register itself with JavaScript</param>
        /// <param name="allowTransparent">Whether allowTransparent chart (true / false)</param>
        /// <param name="bgColor">Back Ground Color</param>
        /// <param name="scaleMode">Set Scale Mode</param>
        /// <param name="language">Set SWF file Language</param>
        /// <returns>JavaScript + HTML code required to embed a chart</returns>
        [Obsolete("")]
        public static string RenderChart(string chartSWF, string dataUrl, string dataStr, string chartId, string chartWidth, string chartHeight, bool debugMode, bool registerWithJS, bool allowTransparent, string bgColor, string scaleMode, string language)
        {
            return RenderChartALL(chartSWF, dataUrl, dataStr, chartId, chartWidth, chartHeight, debugMode, registerWithJS, allowTransparent, bgColor, scaleMode, language);
        }

        /// <summary>
        /// Renders the HTML code for the chart. This
        /// method does NOT embed the chart using JavaScript class. Instead, it uses
        /// direct HTML embedding. So, if you see the charts on IE 6 (or above), you'll
        /// see the "Click to activate..." message on the chart.
        /// </summary>
        /// <param name="chartSWF">SWF File Name (and Path) of the chart which you intend to plot</param>
        /// <param name="dataUrl">If you intend to use dataURL method for this chart, pass the URL as this parameter. Else, set it to "" (in case of dataXML method)</param>
        /// <param name="dataStr">If you intend to use dataXML method for this chart, pass the XML data as this parameter. Else, set it to "" (in case of dataURL method)</param>
        /// <param name="chartId">Id for the chart, using which it will be recognized in the HTML page. Each chart on the page needs to have a unique Id.</param>
        /// <param name="chartWidth">Intended width for the chart (in pixels)</param>
        /// <param name="chartHeight">Intended height for the chart (in pixels)</param>
        /// <param name="debugMode">Whether to start the chart in debug mode</param>
        /// <returns></returns>
        [Obsolete("")]
        public static string RenderChartHTML(string chartSWF, string dataUrl, string dataStr, string chartId, string chartWidth, string chartHeight, bool debugMode)
        {
            return RenderChartHTMLALL(chartSWF, dataUrl, dataStr, chartId, chartWidth, chartHeight, debugMode, false, false, "", "noScale", "EN");
        }

        /// <summary>
        /// Renders the HTML code for the chart. This
        /// method does NOT embed the chart using JavaScript class. Instead, it uses
        /// direct HTML embedding. So, if you see the charts on IE 6 (or above), you'll
        /// see the "Click to activate..." message on the chart.
        /// </summary>
        /// <param name="chartSWF">SWF File Name (and Path) of the chart which you intend to plot</param>
        /// <param name="dataUrl">If you intend to use dataURL method for this chart, pass the URL as this parameter. Else, set it to "" (in case of dataXML method)</param>
        /// <param name="dataStr">If you intend to use dataXML method for this chart, pass the XML data as this parameter. Else, set it to "" (in case of dataURL method)</param>
        /// <param name="chartId">Id for the chart, using which it will be recognized in the HTML page. Each chart on the page needs to have a unique Id.</param>
        /// <param name="chartWidth">Intended width for the chart (in pixels)</param>
        /// <param name="chartHeight">Intended height for the chart (in pixels)</param>
        /// <param name="debugMode">Whether to start the chart in debug mode</param>
        /// <param name="registerWithJS">Whether to ask chart to register itself with JavaScript</param>
        /// <returns></returns>
        [Obsolete("")]
        public static string RenderChartHTML(string chartSWF, string dataUrl, string dataStr, string chartId, string chartWidth, string chartHeight, bool debugMode, bool registerWithJS)
        {
            return RenderChartHTMLALL(chartSWF, dataUrl, dataStr, chartId, chartWidth, chartHeight, debugMode, registerWithJS, false, "", "noScale", "EN");
        }

        /// <summary>
        /// Renders the HTML code for the chart. This
        /// method does NOT embed the chart using JavaScript class. Instead, it uses
        /// direct HTML embedding. So, if you see the charts on IE 6 (or above), you'll
        /// see the "Click to activate..." message on the chart.
        /// </summary>
        /// <param name="chartSWF">SWF File Name (and Path) of the chart which you intend to plot</param>
        /// <param name="dataUrl">If you intend to use dataURL method for this chart, pass the URL as this parameter. Else, set it to "" (in case of dataXML method)</param>
        /// <param name="dataStr">If you intend to use dataXML method for this chart, pass the XML data as this parameter. Else, set it to "" (in case of dataURL method)</param>
        /// <param name="chartId">Id for the chart, using which it will be recognized in the HTML page. Each chart on the page needs to have a unique Id.</param>
        /// <param name="chartWidth">Intended width for the chart (in pixels)</param>
        /// <param name="chartHeight">Intended height for the chart (in pixels)</param>
        /// <param name="debugMode">Whether to start the chart in debug mode</param>
        /// <param name="registerWithJS">Whether to ask chart to register itself with JavaScript</param>
        /// <param name="allowTransparent">Whether allowTransparent chart (true / false)</param>
        /// <returns></returns>
        [Obsolete("")]
        public static string RenderChartHTML(string chartSWF, string dataUrl, string dataStr, string chartId, string chartWidth, string chartHeight, bool debugMode, bool registerWithJS, bool allowTransparent)
        {
            return RenderChartHTMLALL(chartSWF, dataUrl, dataStr, chartId, chartWidth, chartHeight, debugMode, registerWithJS, allowTransparent, "", "noScale", "EN");
        }

        /// <summary>
        /// Renders the HTML code for the chart. This
        /// method does NOT embed the chart using JavaScript class. Instead, it uses
        /// direct HTML embedding. So, if you see the charts on IE 6 (or above), you'll
        /// see the "Click to activate..." message on the chart.
        /// </summary>
        /// <param name="chartSWF">SWF File Name (and Path) of the chart which you intend to plot</param>
        /// <param name="dataUrl">If you intend to use dataURL method for this chart, pass the URL as this parameter. Else, set it to "" (in case of dataXML method)</param>
        /// <param name="dataStr">If you intend to use dataXML method for this chart, pass the XML data as this parameter. Else, set it to "" (in case of dataURL method)</param>
        /// <param name="chartId">Id for the chart, using which it will be recognized in the HTML page. Each chart on the page needs to have a unique Id.</param>
        /// <param name="chartWidth">Intended width for the chart (in pixels)</param>
        /// <param name="chartHeight">Intended height for the chart (in pixels)</param>
        /// <param name="debugMode">Whether to start the chart in debug mode</param>
        /// <param name="registerWithJS">Whether to ask chart to register itself with JavaScript</param>
        /// <param name="allowTransparent">Whether allowTransparent chart (true / false)</param>
        /// <param name="bgColor">Back Ground Color</param>
        /// <param name="scaleMode">Set Scale Mode</param>
        /// <param name="language">Set SWF file Language</param>
        /// <returns></returns>
        [Obsolete("")]
        public static string RenderChartHTML(string chartSWF, string dataUrl, string dataStr, string chartId, string chartWidth, string chartHeight, bool debugMode, bool registerWithJS, bool allowTransparent, string bgColor, string scaleMode, string language)
        {
            return RenderChartHTMLALL(chartSWF, dataUrl, dataStr, chartId, chartWidth, chartHeight, debugMode, registerWithJS, allowTransparent, bgColor, scaleMode, language);
        }


        /// <summary>
        /// encodes the dataURL before it's served to FusionCharts
        /// If you have parameters in your dataURL, you'll necessarily need to encode it
        /// </summary>
        /// <param name="dataUrl">dataURL to be fed to chart</param>
        /// <param name="noCacheStr">Whether to add aditional string to URL to disable caching of data</param>
        /// <returns>Encoded dataURL, ready to be consumed by FusionCharts</returns>
        [Obsolete("")]
        public static string EncodeDataURL(string dataUrl, bool noCacheStr)
        {

            string result = dataUrl;
            if (noCacheStr)
            {
                result += (dataUrl.IndexOf("?") != -1) ? "&" : "?";
                //Replace : in time with _, as FusionCharts cannot handle : in URLs
                result += "FCCurrTime=" + DateTime.Now.ToString().Replace(":", "_");
            }

            return System.Web.HttpUtility.UrlEncode(result);
        }

        /// <summary>
        /// Enables Print Manager for Mozilla browsers
        /// This function returns a small JavaScript snippet which can be added to ClientScript's RegisterClientScriptBlock method
        /// </summary>
        /// <example>ClientScript.RegisterClientScriptBlock(Page.GetType(), "", FusionCharts.enableFCPrintManager());</example>
        /// <returns>String with the JavaScript code</returns>
        [Obsolete("")]
        public static string EnablePrintManager()
        {
            string strHTML = "<script type=\"text/javascript\"><!--\n if(FusionCharts && FusionCharts.printManager) FusionCharts.printManager.enabled(true);\n// --></script>";
            return (strHTML);
        }
        
        
        /// <summary>
        /// Enables Print Manager for Mozilla browsers
        /// </summary>
        /// <param name="CurrentPage">Current page reference</param>
        [Obsolete("")]
        public static void EnablePrintManager(object CurrentPage)
        {
            System.Web.UI.Page HostPage;
            HostPage = (System.Web.UI.Page)CurrentPage;
            string strHTML = "<script type=\"text/javascript\"><!--\n if(FusionCharts && FusionCharts.printManager) FusionCharts.printManager.enabled(true);\n// --></script>";
            HostPage.ClientScript.RegisterClientScriptBlock(HostPage.GetType(), "", strHTML);
        }
        

        private static void __INIT()
        {
            if (__CONFIG__Initialized == false)
            {
                __fc__initialize__();
                __fc__initstatic__();
                __CONFIG__Initialized = true;
            }
        }

        /// <summary>
        /// Sets the dataformat to be provided to charts (json/xml)
        /// </summary>
        /// <param name="format">Data format. Default is 'xml'. Other format is 'json'</param>
        [Obsolete("")]
        public static void SetDataFormat(string format)
        {
            __INIT();

            if (format.Trim().Length == 0)
            {
                format = "xml";
            }
            // Stores the dataformat in global configuration store
            SetConfiguration("dataFormat", format);
        }

        /// <summary>
        /// Sets renderer type (flash/javascript)
        /// </summary>
        /// <param name="renderer"> Name of the renderer. Default is 'flash'. Other possibility is 'javascript'</param>
        [Obsolete("")]
        public static void SetRenderer(string renderer)
        {
            __INIT();

            if (renderer.Trim().Length == 0)
            {
                renderer = "flash";
            }
            // stores the renderer name in global configuration store
            SetConfiguration("renderer", renderer);
        }

        /// <summary>
        /// Explicitely sets window mode (window[detault]/transpatent/opaque)
        /// </summary>
        /// <param name="mode">Name of the mode. Default is 'window'. Other possibilities are 'transparent'/'opaque'</param>
        [Obsolete("")]
        public static void SetWindowMode(string mode)
        {
            __INIT();
            SetConfiguration("wMode", mode);
        }

        /// <summary>
        /// FC_SetConfiguration sets various configurations of FusionCharts
        /// It takes configuration names as first parameter and its value a second parameter
        /// There are config groups which can contain common configuration names. All config names in all groups gets set with this value
        /// unless group is specified explicitly
        /// </summary>
        /// <param name="setting">Name of configuration</param>
        /// <param name="value">Value of configuration</param>
        [Obsolete("")]
        public static void SetConfiguration(string setting, object value)
        {
            foreach (DictionaryEntry de in __CONFIG__)
            {
                if (((Hashtable)__CONFIG__[de.Key]).ContainsKey(setting))
                {
                    ((Hashtable)__CONFIG__[de.Key])[setting] = value;
                }
            }
        }

        /// <summary>
        /// FC_SetConfiguration sets various configurations of FusionCharts
        /// It takes configuration names as first parameter and its value a second parameter
        /// There are config groups which can contain common configuration names. All config names in all groups gets set with this value
        /// unless group is specified explicitly
        /// </summary>
        /// <param name="setting">Name of configuration</param>
        /// <param name="value">Value of configuration</param>
        private static void SetConfiguration(ref Hashtable __TEMPHASH__, string setting, object value)
        {
            foreach (DictionaryEntry de in __TEMPHASH__)
            {
                if (((Hashtable)__TEMPHASH__[de.Key]).ContainsKey(setting))
                {
                    ((Hashtable)__TEMPHASH__[de.Key])[setting] = value;
                }
            }
        }


        #region Helper Private Methods
        private static string GetHTTP()
        {
            //Checks for protocol type.
            string isHTTPS = HttpContext.Current.Request.ServerVariables["HTTPS"];
            //Checks browser type.
            bool isMSIE = HttpContext.Current.Request.ServerVariables["HTTP_USER_AGENT"].Contains("MSIE");
            //Protocol initially sets to http.
            string sHTTP = "http";
            if (isHTTPS.ToLower() == "on")
            {
                sHTTP = "https";
            }
            return sHTTP;
        }

        /// <summary>
        /// Transform the meaning of boolean value in integer value
        /// </summary>
        /// <param name="value">true/false value to be transformed</param>
        /// <returns>1 if the value is true, 0 if the value is false</returns>
        private static int boolToNum(bool value)
        {
            return value ? 1 : 0;
        }

        private static void SetCONSTANTConfiguration(string setting, object value)
        {
            ((Hashtable)__CONFIG__["constants"])[setting] = value;
        }

        private static string GetConfiguration(string setting)
        {
            foreach (DictionaryEntry de in __CONFIG__)
            {
                if (((Hashtable)__CONFIG__[de.Key]).ContainsKey(setting))
                {
                    return ((Hashtable)__CONFIG__[de.Key])[setting].ToString();
                }
            }
            return null;
        }

        private static string GetConfiguration(ref Hashtable __TEMPHASH__, string setting)
        {
            foreach (DictionaryEntry de in __TEMPHASH__)
            {
                if (((Hashtable)__TEMPHASH__[de.Key]).ContainsKey(setting))
                {
                    return ((Hashtable)__TEMPHASH__[de.Key])[setting].ToString();
                }
            }
            return null;
        }

        private static Hashtable GetConfigurationGroup(string setting)
        {
            if (__CONFIG__.ContainsKey(setting))
            {
                return (Hashtable)__CONFIG__[setting];
            }
            return null;
        }

        private static Hashtable GetConfigurationGroup(ref Hashtable __TEMPHASH__, string setting)
        {
            if (__TEMPHASH__.ContainsKey(setting))
            {
                return (Hashtable)__TEMPHASH__[setting];
            }
            return null;
        }

        private static string FC_Transform(Hashtable arr, string tFormat, bool ignoreBlankValues)
        {
            string converted = "";
            string Key = "", Value = "";
            foreach (DictionaryEntry ds in arr)
            {
                if (ignoreBlankValues == true && ds.Value.ToString().Trim() == "") continue;
                Key = ds.Key.ToString();
                Value = ds.Value.ToString();
                if (Key.ToLower().Equals("codebase"))
                {
                    Value = Value.Replace("http", GetHTTP());
                }
                string TFApplied = tFormat.Replace("{key}", Key);
                TFApplied = TFApplied.Replace("{value}", Value);
                converted = converted + TFApplied;
            }
            return converted;
        }

        private static string fc_encodeJSON(Hashtable json, bool enclosed)
        {
            string strjson = "";
            if (enclosed == true) strjson = "{";

            strjson = strjson + FC_Transform(json, "\"{key}\" : \"{value}\", ", true);
            strjson = strjson.Trim();

            if (strjson.EndsWith(",")) strjson = strjson.Remove(strjson.Length - 1);

            return strjson;
        }

        private static void __fc__initstatic__()
        {
            Hashtable constant = new Hashtable(StringComparer.InvariantCultureIgnoreCase);
            constant["scriptbaseUri"] = "";
            __CONFIG__["constants"] = constant;
            constant = null;
        }

        private static void __fc__initialize__()
        {
            __CONFIG__ = null;
            __CONFIG__ = new Hashtable(StringComparer.InvariantCultureIgnoreCase);

            Hashtable param = new Hashtable(StringComparer.InvariantCultureIgnoreCase);
            param["swfUrl"] = "";
            param["width"] = "";
            param["height"] = "";
            param["renderAt"] = "";
            param["renderer"] = "";
            param["dataSource"] = "";
            param["dataFormat"] = "";
            param["id"] = "";
            param["lang"] = "";
            param["debugMode"] = "";
            param["registerWithJS"] = "";
            param["detectFlashVersion"] = "";
            param["autoInstallRedirect"] = "";
            param["wMode"] = "";
            param["scaleMode"] = "";
            param["menu"] = "";
            param["bgColor"] = "";
            param["quality"] = "";


            __CONFIG__["params"] = param;


            Hashtable fvar = new Hashtable(StringComparer.InvariantCultureIgnoreCase);
            fvar["dataURL"] = "";
            fvar["dataXML"] = "";
            fvar["chartWidth"] = "";
            fvar["chartHeight"] = "";
            fvar["DOMId"] = "";
            fvar["registerWithJS"] = "1";
            fvar["debugMode"] = "0";
            fvar["scaleMode"] = "noScale";
            fvar["lang"] = "EN";
            fvar["animation"] = "undefined";
            __CONFIG__["fvars"] = fvar;

            Hashtable oBject = new Hashtable(StringComparer.InvariantCultureIgnoreCase);
            oBject["height"] = "";
            oBject["width"] = "";
            oBject["id"] = "";
            oBject["lang"] = "EN";
            oBject["class"] = "FusionCharts";
            oBject["data"] = "";
            __CONFIG__["object"] = oBject;

            Hashtable objparam = new Hashtable(StringComparer.InvariantCultureIgnoreCase);
            objparam["movie"] = "noScale";
            objparam["scaleMode"] = "noScale";
            objparam["scale"] = "";
            objparam["wMode"] = "";
            objparam["allowScriptAccess"] = "always";
            objparam["quality"] = "best";
            objparam["FlashVars"] = "";
            objparam["bgColor"] = "";
            objparam["swLiveConnect"] = "";
            objparam["base"] = "";
            objparam["align"] = "";
            objparam["salign"] = "";
            objparam["menu"] = "";
            __CONFIG__["objparams"] = objparam;

            Hashtable embeds = new Hashtable(StringComparer.InvariantCultureIgnoreCase);
            embeds["height"] = "";
            embeds["width"] = "";
            embeds["id"] = "";
            embeds["src"] = "";
            embeds["flashvars"] = "";
            embeds["name"] = "";
            embeds["scaleMode"] = "noScale";
            embeds["wMode"] = "";
            embeds["bgColor"] = "";
            embeds["quality"] = "best";
            embeds["allowScriptAccess"] = "always";
            embeds["type"] = "application/x-shockwave-flash";
            embeds["pluginspage"] = "http://www.macromedia.com/go/getflashplayer";
            embeds["swLiveConnect"] = "";
            embeds["base"] = "";
            embeds["align"] = "";
            embeds["salign"] = "";
            embeds["scale"] = "";
            embeds["menu"] = "";
            __CONFIG__["embed"] = embeds;

            param = null;
            fvar = null;
            oBject = null;
            objparam = null;
            embeds = null;
        }
        #endregion
    }
}