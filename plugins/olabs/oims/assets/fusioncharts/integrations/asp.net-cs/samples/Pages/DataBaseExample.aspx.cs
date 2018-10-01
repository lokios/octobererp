using System;
using System.Collections.Generic;
using System.Data;
using System.Data.SqlClient;
using System.Text;
using FusionCharts.Charts;

public partial class Pages_DataBaseExample : System.Web.UI.Page
{
    protected void Page_Load(object sender, EventArgs e)
    {
        DataTable dt = new DataTable();
        string query = "select Region, SUM([Total Sales]) as [Total Sales] from Sales_Record group by Region";
        // establish DB connection and fetch chart data
        GetChartData(ref dt, query);
        // from DB data create chart compatible json
        string chartJsonData = ProcessChartData(dt);
        //Create chart instance
        // charttype, chartID, width, height, data format, data

        Chart chart = new Chart("column2d", "first_chart", "900", "550", "json", chartJsonData);
        Literal1.Text = chart.Render();
    }
    private void GetChartData(ref DataTable dt, string query)
    {

        string connetionString = null;
        string serverName = "POUSHALI-PC\\SHAREPOINT";
        string databaseName = "DrillDownDB";
        //clear previous data from data table
        dt.Clear();
        // we are connectiong by windows authentication so, Trusted_Connection = True;
        connetionString = "Data Source=" + serverName + ";Initial Catalog=" + databaseName + ";Trusted_Connection=True;";

        using (SqlConnection con = new SqlConnection(connetionString))
        {
            con.Open();
            using (SqlCommand command = new SqlCommand(query, con))
            using (SqlDataAdapter da = new SqlDataAdapter(command))
            {
                // fill data table
                da.Fill(dt);

            }

        }
    }
    private string ProcessChartData(DataTable dt)
    {
        StringBuilder jsonData = new StringBuilder();
        StringBuilder data = new StringBuilder();
        // store chart config name-config value pair

        Dictionary<string, string> chartConfig = new Dictionary<string, string>();

        chartConfig.Add("caption", "Total Sales by Region"); 
        chartConfig.Add("xAxisName", "Region");
        chartConfig.Add("yAxisName", "Total Sales");
        chartConfig.Add("numberSuffix", "k");
        chartConfig.Add("theme", "fusion");

        // json data to use as chart data source
        jsonData.Append("{'chart':{");
        foreach (var config in chartConfig)
        {
            jsonData.AppendFormat("'{0}':'{1}',", config.Key, config.Value);
        }
        jsonData.Replace(",", "},", jsonData.Length - 1, 1);
        data.Append("'data':[");

        //iterate through data table to build data object
        if (dt != null && dt.Rows.Count > 0)
        {
            foreach (DataRow row in dt.Rows)
            {
                data.AppendFormat("{{'label':'{0}','value':'{1}'}},", row[0].ToString(), row[1].ToString());
            }
        }
        data.Replace(",", "]", data.Length - 1, 1);

        jsonData.Append(data.ToString());
        jsonData.Append("}");
        return jsonData.ToString();
    }

}