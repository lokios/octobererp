<%@ WebHandler Language="C#" Class="Handler" %>

using System;
using System.Web;
using System.Collections.Generic;
using System.Data;
using System.Data.SqlClient;
using System.Text;


public class Handler : IHttpHandler
{

    public void ProcessRequest(HttpContext context)
    {
        context.Response.ContentType = "application/json";
        // level mapping for each column
        string[] levelValueMapping = new string[]  { "region","country","city"};
     

        string drillLevel = context.Request["drillLevel"];
        string query = "";
        string label = "";
        if (string.IsNullOrEmpty(drillLevel))
        {
            drillLevel = "0";
            // build custom query 
            // parameter: column to be fetch
            query = BuildQuery(levelValueMapping[(Convert.ToInt16(drillLevel))]);
        }
        else
        {
            drillLevel = (Convert.ToInt16(drillLevel) + 1).ToString();
            label = context.Request["label"];
            // build custom query 
            // parameter: column to be fetch, previously clicked value, previous level column name
            query = BuildQuery(levelValueMapping[(Convert.ToInt16(drillLevel))],label,levelValueMapping[(Convert.ToInt16(drillLevel)-1)]);
        }

        DataTable dt = new DataTable();
        // establish DB connection and fetch chart data
        GetChartData(ref dt, query);
        // from DB data create chart compatible json
        string chartJsonData = ProcessChartData(dt, levelValueMapping[(Convert.ToInt16(drillLevel))], drillLevel, levelValueMapping.Length);
        // send response
        context.Response.Write(chartJsonData);



    }

    public bool IsReusable
    {
        get
        {
            return false;
        }
    }
   private string BuildQuery(string columnName)
    {
        string query;
        query = "select " + columnName + ", SUM([Total Sales]) as [Total Sales]" + "from Sales_Record group by " + columnName;
        return query;
    }
    private string BuildQuery(string columnName, string parentValue,string parentName)
    {
        string query;
        query = "select " + columnName + ", SUM([Total Sales]) as [Total Sales]" + "from Sales_Record where " + parentName + "= '" + parentValue + "'Group by " + columnName;
        return query;

    }
    private string ProcessChartData(DataTable dt, string columnName, string drillLevel, int maxLevel)
    {
        StringBuilder jsonData = new StringBuilder();
        StringBuilder data = new StringBuilder();
        // store chart config name-config value pair

        Dictionary<string, string> chartConfig = new Dictionary<string, string>();

        string linkParam = "newchart-jsonurl-Handler/Handler.ashx?label={0}&drillLevel={1}";

        chartConfig.Add("caption", "Total Sales by " + columnName); // caption will change dynamically based on chart label
        chartConfig.Add("xAxisName", columnName); // xaxis name will chnage dynamically based on chart label
        chartConfig.Add("yAxisName", "Total Sales");
        chartConfig.Add("numberSuffix", "k");
        chartConfig.Add("theme", "fusion");

        // json data to use as chart data source
        jsonData.Append("{\"chart\":{");
        foreach (var config in chartConfig)
        {
            jsonData.AppendFormat("\"{0}\":\"{1}\",", config.Key, config.Value);
        }
        jsonData.Replace(",", "},", jsonData.Length - 1, 1);
        data.Append("\"data\":[");

        //iterate through data table to build data object
        if (dt != null && dt.Rows.Count > 0)
        {
            foreach (DataRow row in dt.Rows)
            {
                if(Convert.ToInt16(drillLevel) < maxLevel - 1)
                {
                    string link = string.Format(linkParam,row[0].ToString(), drillLevel);
                    data.AppendFormat("{{\"label\":\"{0}\",\"value\":\"{1}\", \"link\": \"{2}\"}},", row[0].ToString(), row[1].ToString(), link);
                }
                else // for last level, link attribute will not be added
                {
                    data.AppendFormat("{{\"label\":\"{0}\",\"value\":\"{1}\"}},", row[0].ToString(), row[1].ToString());
                }
            }
        }
        data.Replace(",", "]", data.Length - 1, 1);

        jsonData.Append(data.ToString());
        jsonData.Append("}");
        return jsonData.ToString();
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

}