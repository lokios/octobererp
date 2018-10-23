<?php

namespace Olabs\Oims\Classes;

class GanttCharts {

    private $newChartJSON = [];
    private $dataSource = [];
    private $dataSource_chart = [];
    private $dataSource_categories = [];
    private $dataSource_processes = [];
    private $dataSource_datatable = [];
    private $dataSource_tasks = [];
    private $dataSource_connectors = [];
    private $dataSource_milestones = [];
    private $dataSource_legend = [];
    private $dataSource_trendlines = [];

    // constructor
    public function __construct($type, $id, $width = 1000, $height = 500, $renderAt = "chart-container", $dataFormat = "json", $dataSource = []) {
//        type: 'gantt',
//      renderAt: 'chart-container',
//      id: "MyGanttChart",
//      width: '1000',
//      height: '500',
//      dataFormat: 'json',

        isset($type) ? $this->newChartJSON['type'] = $type : '';
        isset($id) ? $this->newChartJSON['id'] = $id : 'php-fc-' . time();
        isset($width) ? $this->newChartJSON['width'] = $width : '';
        isset($height) ? $this->newChartJSON['height'] = $height : '';
        isset($renderAt) ? $this->newChartJSON['renderAt'] = $renderAt : '';
        isset($dataFormat) ? $this->newChartJSON['dataFormat'] = $dataFormat : '';
        isset($dataSource) ? $this->dataSource = $dataSource : '';

        //Set chart default
        $this->set_dataSource_chart("Project Plan", "Planned vs Actual");

        $this->set_dataSource_categories();

        $this->set_dataSource_processes("Task");

        $this->set_dataSource_datatable();

        $this->set_dataSource_tasks();

        $this->set_dataSource_connectors();

        $this->set_dataSource_milestones();

        $this->set_dataSource_legend();

        $this->set_dataSource_trendlines();
    }

    /*
     * dataSource objects #
     * chart -- Done
     * categories -- Done*
     * processes -- Done
     * datatable -- Done
     * tasks -- Done*
     * connectors -- Done*
     * milestones -- Done*
     * legend  -- Done
     * trendlines -- Done*
     */

    public function set_dataSource_tasks() {
        /*
         * "tasks": {
          "task": [{
          "label": "Planned",
          "processid": "1",
          "start": "9/4/2014",
          "end": "12/4/2014",
          "id": "1-1",
          "color": "#008ee4",
          "height": "32%",
          "toppadding": "12%"
          }
         */
        $this->dataSource_tasks = [
            "task" => []
        ];

        $this->dataSource['tasks'] = $this->dataSource_tasks;
    }

    /*
     * $label = Planned, Actual, Delay
     */

    public function set_dataSource_tasks_item($start, $end, $id, $label = "Planned", $tooltext = "") {
        /*
         * {
          "start": "1/4/2014",
          "end": "30/6/2014",
          "label": "Months",
          "align": "middle",
          "fontcolor": "#ffffff",
          "fontsize": "12"
          }
         */
        $item = [];
        $item["start"] = $start;
        $item["end"] = $end;
        $item["label"] = $label;
        $item["processid"] = $id;
        $item["tooltext"] = $tooltext;
        $item["height"] = "32%";
//        "tooltext": "Delayed by 2 days."

        switch (strtolower($label)) {
            case "planned":
                $item["id"] = $id . "-1";
                $item["color"] = "#008ee4";
                $item["toppadding"] = "12%";

                break;
            case "actual":
                $item["id"] = $id . "";
                $item["color"] = "#6baa01";
                $item["toppadding"] = "56%";

                break;

            case "delay":
                $item["id"] = $id . "-2";
                $item["color"] = "#e44a00";
                $item["toppadding"] = "56%";

                break;

            default:
                $item["id"] = $id . "";
                $item["color"] = "#6baa01";
                $item["toppadding"] = "56%";
                break;
        }

        $this->dataSource['tasks']["task"][] = $item;
    }

    public function set_dataSource_categories() {
        /*
         * "categories": ["bgcolor": "#999999",
          "align": "middle",
          "fontcolor": "#ffffff",
          "fontsize": "12",{
          "bgcolor": "#999999",
          "category": [{
          "start": "1/4/2014",
          "end": "30/6/2014",
          "label": "Months",
          "align": "middle",
          "fontcolor": "#ffffff",
          "fontsize": "12"
          }]
          },
         */
        $this->dataSource_categories = [
            "bgcolor" => "#999999",
            "align" => "middle",
            "fontcolor" => "#ffffff",
            "fontsize" => "12",
            "category" => [],
        ];


        $this->dataSource['categories'][0] = $this->dataSource_categories; //Category Year
        $this->dataSource['categories'][1] = $this->dataSource_categories; //Category Month
    }

    /*
     * type = month, year
     */
    public function set_dataSource_categories_item($start, $end, $label, $type = 'month') {
        /*
         * {
          "start": "1/4/2014",
          "end": "30/6/2014",
          "label": "Months",
          "align": "middle",
          "fontcolor": "#ffffff",
          "fontsize": "12"
          }
         */
        $item = [];
        $item["start"] = $start;
        $item["end"] = $end;
        $item["label"] = $label;
        if($type == 'year'){
            $this->dataSource['categories'][0]["category"][] = $item;
        }else{
            $this->dataSource['categories'][1]["category"][] = $item;
        }
        
    }

    public function set_dataSource_connectors() {
        /*
         * "connectors": [{
          "connector": [{
          "fromtaskid": "1",
          "totaskid": "2",
          "color": "#008ee4",
          "thickness": "2",
          "fromtaskconnectstart_": "1"
          }]
         */
        $this->dataSource_connectors = [];

        $this->dataSource['connectors'] = $this->dataSource_connectors;
    }

    public function set_dataSource_milestones() {
        /*
         * "milestones": {
          "milestone": [{
          "date": "2/6/2014",
          "taskid": "12",
          "color": "#f8bd19",
          "shape": "star",
          "tooltext": "Completion of Phase 1"
          }
          /*{
          "date": "21/8/2008",
          "taskid": "10",
          "color": "#f8bd19",
          "shape": "star",
          "tooltext": "New estimated moving date"
          }
          ]
          },
         */

        $this->dataSource_milestones = [];

        $this->dataSource['milestones'] = $this->dataSource_milestones;
    }

    public function set_dataSource_trendlines() {
        /*
         * "trendlines": [{
          "line": [{
          "start": "19/6/2014",
          "displayvalue": "AC Testing",
          "color": "333333",
          "thickness": "2",
          "dashed": "1"
          }]
          }]
         */

        $this->dataSource_trendlines = [];

        $this->dataSource['trendlines'] = $this->dataSource_trendlines;
    }

    public function set_dataSource_legend() {
        /*
         * "legend": {
          "item": [{
          "label": "Planned",
          "color": "#008ee4"
          }, {
          "label": "Actual",
          "color": "#6baa01"
          }, {
          "label": "Slack (Delay)",
          "color": "#e44a00"
          }]
          },
         */
        $this->dataSource_legend["item"][] = [
            "label" => "Planned",
            "color" => "#008ee4"
        ];

        $this->dataSource_legend["item"][] = [
            "label" => "Actual",
            "color" => "#6baa01"
        ];

        $this->dataSource_legend["item"][] = [
            "label" => "Slack (Delay)",
            "color" => "#e44a00"
        ];

        $this->dataSource['legend'] = $this->dataSource_legend;
    }

    public function set_dataSource_datatable() {
        /*
         * "showprocessname": "1",
          "namealign": "left",
          "fontcolor": "#000000",
          "fontsize": "10",
          "valign": "right",
          "align": "center",
          "headervalign": "bottom",
          "headeralign": "center",
          "headerbgcolor": "#999999",
          "headerfontcolor": "#ffffff",
          "headerfontsize": "12",
          "datacolumn": [{
          "bgcolor": "#eeeeee",
          "headertext": "Actual{br}Start{br}Date",
          "text" : []
         * }]
         */
        $this->dataSource_datatable["showprocessname"] = "1";
        $this->dataSource_datatable["namealign"] = "left";
        $this->dataSource_datatable["fontcolor"] = "#000000";
        $this->dataSource_datatable["fontsize"] = "10";
        $this->dataSource_datatable["valign"] = "right";
        $this->dataSource_datatable["align"] = "center";
        $this->dataSource_datatable["headervalign"] = "bottom";
        $this->dataSource_datatable["headeralign"] = "center";
        $this->dataSource_datatable["headerbgcolor"] = "#999999";
        $this->dataSource_datatable["headerfontcolor"] = "#ffffff";
        $this->dataSource_datatable["headerfontsize"] = "12";
        $this->dataSource_datatable["datacolumn"][0] = [
            "bgcolor" => "#eeeeee",
            "headertext" => "Actual{br}Start{br}Date",
            "text" => [],
        ];

        $this->dataSource_datatable["datacolumn"][1] = [
            "bgcolor" => "#eeeeee",
            "headertext" => "Actual{br}End{br}Date",
            "text" => [],
        ];

        $this->dataSource['datatable'] = $this->dataSource_datatable;
    }

    public function set_dataSource_datatable_item($start_label, $end_label, $start_bgcolor = "", $end_bgcolor = "") {
        /*
         * "label": "25/4/2014",
          "bgcolor": "#e44a00",
          "bgAlpha": "40"
         */
        $item_start = [
            "label" => $start_label,
        ];

        if ($start_bgcolor != "") {
            $item_start["bgcolor"] = $start_bgcolor;
            $item_start["bgAlpha"] = "40";
        }
        $this->dataSource['datatable']["datacolumn"][0]["text"][] = $item_start;

        $item_end = [
            "label" => $end_label,
        ];

        if ($end_bgcolor != "") {
            $item_end["bgcolor"] = $end_bgcolor;
            $item_end["bgAlpha"] = "40";
        }
        $this->dataSource['datatable']["datacolumn"][1]["text"][] = $item_end;
    }

    public function set_dataSource_processes($headertext) {
        /*
         * "headertext": "Task",
          "fontcolor": "#000000",
          "fontsize": "11",
          "isanimated": "1",
          "bgcolor": "#6baa01",
          "headervalign": "bottom",
          "headeralign": "left",
          "headerbgcolor": "#999999",
          "headerfontcolor": "#ffffff",
          "headerfontsize": "12",
          "align": "left",
          "isbold": "1",
          "bgalpha": "25",
          "process": [{
          "label": "Clear site",
          "id": "1"
          }]
         */

        $this->dataSource_processes["headertext"] = $headertext;
        $this->dataSource_processes["fontcolor"] = "#000000";
        $this->dataSource_processes["fontsize"] = "11";
        $this->dataSource_processes["isanimated"] = "1";
        $this->dataSource_processes["bgcolor"] = "#6baa01";
        $this->dataSource_processes["headervalign"] = "bottom";
        $this->dataSource_processes["headeralign"] = "left";
        $this->dataSource_processes["headerbgcolor"] = "#999999";
        $this->dataSource_processes["headerfontcolor"] = "#ffffff";
        $this->dataSource_processes["headerfontsize"] = "12";
        $this->dataSource_processes["align"] = "left";
        $this->dataSource_processes["isbold"] = "1";
        $this->dataSource_processes["bgalpha"] = "25";
        $this->dataSource_processes["process"] = [];


        $this->dataSource['processes'] = $this->dataSource_processes;
    }

    public function set_dataSource_processes_item($id, $label, $hoverBandColor = "", $hoverBandAlpha = "") {

        /*
         * "label": "Concrete Foundation",
          "id": "3",
          "hoverBandColor": "#e44a00",
          "hoverBandAlpha": "40"
         */
        $item = [
            "label" => $label,
            "id" => $id
        ];

        if ($hoverBandColor != "") {
            $item["hoverBandColor"] = $hoverBandColor;
        }

        if ($hoverBandAlpha != "") {
            $item["hoverBandAlpha"] = $hoverBandAlpha;
        }

        $this->dataSource['processes']["process"][] = $item;
    }

    public function set_dataSource_chart($caption, $subcaption) {
        /*
         * 
         * https://www.fusioncharts.com/dev/chart-attributes/?chart=gantt&attribute=chart_showTaskStartDate
         * "theme": "fusion",
          "caption": "VSS 001 (AWAS VIKAS KANPUR) - Project Plan",
          "subcaption": "Planned vs Actual",
          "dateformat": "dd/mm/yyyy",
          "outputdateformat": "ddds mns yy",
          "ganttwidthpercent": "60",
          "ganttPaneDuration": "40",
          "ganttPaneDurationUnit": "d",
          "plottooltext": "$processName{br}$label starting date $start{br}$label ending date $end",
          "legendBorderAlpha": "0",
          "legendShadow": "0",
          "usePlotGradientColor": "0",
          "showCanvasBorder": "0",
          "flatScrollBars": "1",
          "gridbordercolor": "#333333",
          "gridborderalpha": "20",
          "slackFillColor": "#e44a00",
          "taskBarFillMix": "light+0"
         */
        $this->dataSource_chart["theme"] = "fusion";
        $this->dataSource_chart["caption"] = $caption; //VSS 001 (AWAS VIKAS KANPUR) - Project Plan
        $this->dataSource_chart["subcaption"] = $subcaption; //Planned vs Actual
        $this->dataSource_chart["dateformat"] = "dd/mm/yyyy";
        $this->dataSource_chart["outputdateformat"] = "ddds mns yy";
//        $this->dataSource_chart["ganttwidthpercent"] = "60";
//        $this->dataSource_chart["ganttPaneDuration"] = "40";
//        $this->dataSource_chart["ganttPaneDurationUnit"] = "d";
        $this->dataSource_chart["plottooltext"] = "\$processName{br}\$label starting date \$start{br}\$label ending date \$end";
        $this->dataSource_chart["legendBorderAlpha"] = "0";
        $this->dataSource_chart["legendShadow"] = "0";
        $this->dataSource_chart["usePlotGradientColor"] = "0";
        $this->dataSource_chart["showCanvasBorder"] = "0";
        
        $this->dataSource_chart["gridbordercolor"] = "#333333";
        $this->dataSource_chart["gridborderalpha"] = "20";
        $this->dataSource_chart["slackFillColor"] = "#e44a00";
        $this->dataSource_chart["taskBarFillMix"] = "light+0";
        
        
        $this->dataSource_chart["flatScrollBars"] = "1";
        
        $this->dataSource_chart["ganttPaneDurationUnit"] = "m";
        $this->dataSource_chart["ganttwidthpercent"] = "10";
        $this->dataSource_chart["ganttPaneDuration"] = "25";
//        $this->dataSource_chart["ganttPaneDurationUnit"] = "d";
        
        $this->dataSource_chart["useVerticalScrolling"] = "1";
        $this->dataSource_chart["showFullDataTable"] = "1";
        $this->dataSource_chart["showTaskStartDate"] = "1";
        $this->dataSource_chart["showTaskEndDate"] = "1";
        $this->dataSource_chart["forceRowHeight"] = "1";
        
        //Export features
        $this->dataSource_chart["exportEnabled"] = "1";
//        $this->dataSource_chart["exportFormats"] = "PNG=Export as High Quality Image|PDF=Export as Printable|XLS=Export Chart Data";
        $this->dataSource_chart["exportFormats"] = "PNG=Export as High Quality Image|PDF=Export as Printable";
//        $this->dataSource_chart["exportMode"] = "server"; //"exportMode": "client",
//        $this->dataSource_chart[""] = "";

        $this->dataSource['chart'] = $this->dataSource_chart;
    }

    /*
     * Render option : json, array
     */

    public function render($option = 'json') {
//        $newChartHTML = preg_replace('/__constructorOptions__/', $jsonEncodedOptions, $this->constructorTemplate);

        $this->newChartJSON['dataSource'] = $this->dataSource;

        if ($option == 'json') {
            return json_encode($this->newChartJSON);
        }

        return $this->newChartJSON;
    }

}

/* * *** Gantt Chart Structure
  {type:'gantt',renderAt:'chart-container',id:"MyGanttChart",width:'1000',height:'500',dataFormat:'json',dataSource:{"chart":{"theme":"fusion","caption":"VSS 001 (AWAS VIKAS KANPUR) - Project Plan","subcaption":"Planned vs Actual","dateformat":"dd/mm/yyyy","outputdateformat":"ddds mns yy","ganttwidthpercent":"60","ganttPaneDuration":"40","ganttPaneDurationUnit":"d","plottooltext":"$processName{br}$label starting date $start{br}$label ending date $end","legendBorderAlpha":"0","legendShadow":"0","usePlotGradientColor":"0","showCanvasBorder":"0","flatScrollBars":"1","gridbordercolor":"#333333","gridborderalpha":"20","slackFillColor":"#e44a00","taskBarFillMix":"light+0"},"categories":[{"bgcolor":"#999999","category":[{"start":"1/4/2014","end":"30/6/2014","label":"Months","align":"middle","fontcolor":"#ffffff","fontsize":"12"}]},{"bgcolor":"#999999","align":"middle","fontcolor":"#ffffff","fontsize":"12","category":[{"start":"1/4/2014","end":"30/4/2014","label":"April"},{"start":"1/5/2014","end":"31/5/2014","label":"May"},{"start":"1/6/2014","end":"30/6/2014","label":"June"}]},{"bgcolor":"#ffffff","fontcolor":"#333333","fontsize":"11","align":"center","category":[{"start":"1/4/2014","end":"5/4/2014","label":"Week 1"},{"start":"6/4/2014","end":"12/4/2014","label":"Week 2"},{"start":"13/4/2014","end":"19/4/2014","label":"Week 3"},{"start":"20/4/2014","end":"26/4/2014","label":"Week 4"},{"start":"27/4/2014","end":"3/5/2014","label":"Week 5"},{"start":"4/5/2014","end":"10/5/2014","label":"Week 6"},{"start":"11/5/2014","end":"17/5/2014","label":"Week 7"},{"start":"18/5/2014","end":"24/5/2014","label":"Week 8"},{"start":"25/5/2014","end":"31/5/2014","label":"Week 9"},{"start":"1/6/2014","end":"7/6/2014","label":"Week 10"},{"start":"8/6/2014","end":"14/6/2014","label":"Week 11"},{"start":"15/6/2014","end":"21/6/2014","label":"Week 12"},{"start":"22/6/2014","end":"28/6/2014","label":"Week 13"}]}],"processes":{"headertext":"Task","fontcolor":"#000000","fontsize":"11","isanimated":"1","bgcolor":"#6baa01","headervalign":"bottom","headeralign":"left","headerbgcolor":"#999999","headerfontcolor":"#ffffff","headerfontsize":"12","align":"left","isbold":"1","bgalpha":"25","process":[{"label":"Clear site","id":"1"},{"label":"Excavate Foundation","id":"2","hoverBandColor":"#e44a00","hoverBandAlpha":"40"},{"label":"Concrete Foundation","id":"3","hoverBandColor":"#e44a00","hoverBandAlpha":"40"},{"label":"Footing to DPC","id":"4","hoverBandColor":"#e44a00","hoverBandAlpha":"40"},{"label":"Drainage Services","id":"5","hoverBandColor":"#e44a00","hoverBandAlpha":"40"},{"label":"Backfill","id":"6","hoverBandColor":"#e44a00","hoverBandAlpha":"40"},{"label":"Ground Floor","id":"7"},{"label":"Walls on First Floor","id":"8"},{"label":"First Floor Carcass","id":"9","hoverBandColor":"#e44a00","hoverBandAlpha":"40"},{"label":"First Floor Deck","id":"10","hoverBandColor":"#e44a00","hoverBandAlpha":"40"},{"label":"Roof Structure","id":"11"},{"label":"Roof Covering","id":"12"},{"label":"Rainwater Gear","id":"13"},{"label":"Windows","id":"14"},{"label":"External Doors","id":"15"},{"label":"Connect Electricity","id":"16"},{"label":"Connect Water Supply","id":"17","hoverBandColor":"#e44a00","hoverBandAlpha":"40"},{"label":"Install Air Conditioning","id":"18","hoverBandColor":"#e44a00","hoverBandAlpha":"40"},{"label":"Interior Decoration","id":"19","hoverBandColor":"#e44a00","hoverBandAlpha":"40"},{"label":"Fencing And signs","id":"20"},{"label":"Exterior Decoration","id":"21","hoverBandColor":"#e44a00","hoverBandAlpha":"40"},{"label":"Setup racks","id":"22"}]},"datatable":{"showprocessname":"1","namealign":"left","fontcolor":"#000000","fontsize":"10","valign":"right","align":"center","headervalign":"bottom","headeralign":"center","headerbgcolor":"#999999","headerfontcolor":"#ffffff","headerfontsize":"12","datacolumn":[{"bgcolor":"#eeeeee","headertext":"Actual{br}Start{br}Date","text":[{"label":"9/4/2014"},{"label":"13/4/2014"},{"label":"26/4/2014","bgcolor":"#e44a00","bgAlpha":"40",},{"label":"4/5/2014","bgcolor":"#e44a00","bgAlpha":"40"},{"label":"6/5/2014"},{"label":"5/5/2014","bgcolor":"#e44a00","bgAlpha":"40"},{"label":"11/5/2014"},{"label":"16/5/2014"},{"label":"16/5/2014"},{"label":"21/5/2014","bgcolor":"#e44a00","bgAlpha":"40"},{"label":"25/5/2014"},{"label":"28/5/2014"},{"label":"4/6/2014"},{"label":"4/6/2014"},{"label":"4/6/2014"},{"label":"2/6/2014"},{"label":"5/6/2014"},{"label":"18/6/2014","bgcolor":"#e44a00","bgAlpha":"40"},{"label":"16/6/2014","bgcolor":"#e44a00","bgAlpha":"40"},{"label":"23/6/2014"},{"label":"18/6/2014"},{"label":"25/6/2014"}]},{"bgcolor":"#eeeeee","headertext":"Actual{br}End{br}Date","text":[{"label":"12/4/2014"},{"label":"25/4/2014","bgcolor":"#e44a00","bgAlpha":"40"},{"label":"4/5/2014","bgcolor":"#e44a00","bgAlpha":"40"},{"label":"10/5/2014"},{"label":"10/5/2014"},{"label":"11/5/2014","bgcolor":"#e44a00","bgAlpha":"40"},{"label":"14/5/2014"},{"label":"19/5/2014"},{"label":"21/5/2014","bgcolor":"#e44a00","bgAlpha":"40"},{"label":"24/5/2014","bgcolor":"#e44a00","bgAlpha":"40"},{"label":"27/5/2014"},{"label":"1/6/2014"},{"label":"6/6/2014"},{"label":"4/6/2014"},{"label":"4/6/2014"},{"label":"7/6/2014"},{"label":"17/6/2014","bgcolor":"#e44a00","bgAlpha":"40"},{"label":"20/6/2014","bgcolor":"#e44a00","bgAlpha":"40"},{"label":"23/6/2014"},{"label":"23/6/2014"},{"label":"23/6/2014","bgcolor":"#e44a00","bgAlpha":"40"},{"label":"28/6/2014"}]}]},"tasks":{"task":[{"label":"Planned","processid":"1","start":"9/4/2014","end":"12/4/2014","id":"1-1","color":"#008ee4","height":"32%","toppadding":"12%"},{"label":"Actual","processid":"1","start":"9/4/2014","end":"12/4/2014","id":"1","color":"#6baa01","toppadding":"56%","height":"32%"},{"label":"Planned","processid":"2","start":"13/4/2014","end":"23/4/2014","id":"2-1","color":"#008ee4","height":"32%","toppadding":"12%"},{"label":"Actual","processid":"2","start":"13/4/2014","end":"25/4/2014","id":"2","color":"#6baa01","toppadding":"56%","height":"32%"},{"label":"Delay","processid":"2","start":"23/4/2014","end":"25/4/2014","id":"2-2","color":"#e44a00","toppadding":"56%","height":"32%","tooltext":"Delayed by 2 days."},{"label":"Planned","processid":"3","start":"23/4/2014","end":"30/4/2014","id":"3-1","color":"#008ee4","height":"32%","toppadding":"12%"},{"label":"Actual","processid":"3","start":"26/4/2014","end":"4/5/2014","id":"3","color":"#6baa01","toppadding":"56%","height":"32%"},{"label":"Delay","processid":"3","start":"3/5/2014","end":"4/5/2014","id":"3-2","color":"#e44a00","toppadding":"56%","height":"32%","tooltext":"Delayed by 1 days."},{"label":"Planned","processid":"4","start":"3/5/2014","end":"10/5/2014","id":"4-1","color":"#008ee4","height":"32%","toppadding":"12%"},{"label":"Actual","processid":"4","start":"4/5/2014","end":"10/5/2014","id":"4","color":"#6baa01","toppadding":"56%","height":"32%"},{"label":"Planned","processid":"5","start":"6/5/2014","end":"11/5/2014","id":"5-1","color":"#008ee4","height":"32%","toppadding":"12%"},{"label":"Actual","processid":"5","start":"6/5/2014","end":"10/5/2014","id":"5","color":"#6baa01","toppadding":"56%","height":"32%"},{"label":"Planned","processid":"6","start":"4/5/2014","end":"7/5/2014","id":"6-1","color":"#008ee4","height":"32%","toppadding":"12%"},{"label":"Actual","processid":"6","start":"5/5/2014","end":"11/5/2014","id":"6","color":"#6baa01","toppadding":"56%","height":"32%"},{"label":"Delay","processid":"6","start":"7/5/2014","end":"11/5/2014","id":"6-2","color":"#e44a00","toppadding":"56%","height":"32%","tooltext":"Delayed by 4 days."},{"label":"Planned","processid":"7","start":"11/5/2014","end":"14/5/2014","id":"7-1","color":"#008ee4","height":"32%","toppadding":"12%"},{"label":"Actual","processid":"7","start":"11/5/2014","end":"14/5/2014","id":"7","color":"#6baa01","toppadding":"56%","height":"32%"},{"label":"Planned","processid":"8","start":"16/5/2014","end":"19/5/2014","id":"8-1","color":"#008ee4","height":"32%","toppadding":"12%"},{"label":"Actual","processid":"8","start":"16/5/2014","end":"19/5/2014","id":"8","color":"#6baa01","toppadding":"56%","height":"32%"},{"label":"Planned","processid":"9","start":"16/5/2014","end":"18/5/2014","id":"9-1","color":"#008ee4","height":"32%","toppadding":"12%"},{"label":"Actual","processid":"9","start":"16/5/2014","end":"21/5/2014","id":"9","color":"#6baa01","toppadding":"56%","height":"32%"},{"label":"Delay","processid":"9","start":"18/5/2014","end":"21/5/2014","id":"9-2","color":"#e44a00","toppadding":"56%","height":"32%","tooltext":"Delayed by 3 days."},{"label":"Planned","processid":"10","start":"20/5/2014","end":"23/5/2014","id":"10-1","color":"#008ee4","height":"32%","toppadding":"12%"},{"label":"Actual","processid":"10","start":"21/5/2014","end":"24/5/2014","id":"10","color":"#6baa01","toppadding":"56%","height":"32%"},{"label":"Delay","toppadding":"56%","height":"32%","tooltext":"Delayed by 1 days."},{"label":"Planned","processid":"11","processid":"10","start":"23/5/2014","end":"24/5/2014","id":"10-2","color":"#e44a00","start":"25/5/2014","end":"27/5/2014","id":"11-1","color":"#008ee4","height":"32%","toppadding":"12%"},{"label":"Actual","processid":"11","start":"25/5/2014","end":"27/5/2014","id":"11","color":"#6baa01","toppadding":"56%","height":"32%"},{"label":"Planned","processid":"12","start":"28/5/2014","end":"1/6/2014","id":"12-1","color":"#008ee4","height":"32%","toppadding":"12%"},{"label":"Actual","processid":"12","start":"28/5/2014","end":"1/6/2014","id":"12","color":"#6baa01","toppadding":"56%","height":"32%"},{"label":"Planned","processid":"13","start":"4/6/2014","end":"6/6/2014","id":"13-1","color":"#008ee4","height":"32%","toppadding":"12%"},{"label":"Actual","processid":"13","start":"4/6/2014","end":"6/6/2014","id":"13","color":"#6baa01","toppadding":"56%","height":"32%"},{"label":"Planned","processid":"14","start":"4/6/2014","end":"4/6/2014","id":"14-1","color":"#008ee4","height":"32%","toppadding":"12%"},{"label":"Actual","processid":"14","start":"4/6/2014","end":"4/6/2014","id":"14","color":"#6baa01","toppadding":"56%","height":"32%"},{"label":"Planned","processid":"15","start":"4/6/2014","end":"4/6/2014","id":"15-1","color":"#008ee4","height":"32%","toppadding":"12%"},{"label":"Actual","processid":"15","start":"4/6/2014","end":"4/6/2014","id":"15","color":"#6baa01","toppadding":"56%","height":"32%"},{"label":"Planned","processid":"16","start":"2/6/2014","end":"7/6/2014","id":"16-1","color":"#008ee4","height":"32%","toppadding":"12%"},{"label":"Actual","processid":"16","start":"2/6/2014","end":"7/6/2014","id":"16","color":"#6baa01","toppadding":"56%","height":"32%"},{"label":"Planned","processid":"17","start":"5/6/2014","end":"10/6/2014","id":"17-1","color":"#008ee4","height":"32%","toppadding":"12%"},{"label":"Actual","processid":"17","start":"5/6/2014","end":"17/6/2014","id":"17","color":"#6baa01","toppadding":"56%","height":"32%"},{"label":"Delay","processid":"17","start":"10/6/2014","end":"17/6/2014","id":"17-2","color":"#e44a00","toppadding":"56%","height":"32%","tooltext":"Delayed by 7 days."},{"label":"Planned","processid":"18","start":"10/6/2014","end":"12/6/2014","id":"18-1","color":"#008ee4","height":"32%","toppadding":"12%"},{"label":"Delay","processid":"18","start":"18/6/2014","end":"20/6/2014","id":"18","color":"#e44a00","toppadding":"56%","height":"32%","tooltext":"Delayed by 8 days."},{"label":"Planned","processid":"19","start":"15/6/2014","end":"23/6/2014","id":"19-1","color":"#008ee4","height":"32%","toppadding":"12%"},{"label":"Actual","processid":"19","start":"16/6/2014","end":"23/6/2014","id":"19","color":"#6baa01","toppadding":"56%","height":"32%"},{"label":"Planned","processid":"20","start":"23/6/2014","end":"23/6/2014","id":"20-1","color":"#008ee4","height":"32%","toppadding":"12%"},{"label":"Actual","processid":"20","start":"23/6/2014","end":"23/6/2014","id":"20","color":"#6baa01","toppadding":"56%","height":"32%"},{"label":"Planned","processid":"21","start":"18/6/2014","end":"21/6/2014","id":"21-1","color":"#008ee4","height":"32%","toppadding":"12%"},{"label":"Actual","processid":"21","start":"18/6/2014","end":"23/6/2014","id":"21","color":"#6baa01","toppadding":"56%","height":"32%"},{"label":"Delay","processid":"21","start":"21/6/2014","end":"23/6/2014","id":"21-2","color":"#e44a00","toppadding":"56%","height":"32%","tooltext":"Delayed by 2 days."},{"label":"Planned","processid":"22","start":"24/6/2014","end":"28/6/2014","id":"22-1","color":"#008ee4","height":"32%","toppadding":"12%"},{"label":"Actual","processid":"22","start":"25/6/2014","end":"28/6/2014","id":"22","color":"#6baa01","toppadding":"56%","height":"32%"}]},"connectors":[{"connector":[{"fromtaskid":"1","totaskid":"2","color":"#008ee4","thickness":"2","fromtaskconnectstart_":"1"},{"fromtaskid":"2-2","totaskid":"3","color":"#008ee4","thickness":"2"},{"fromtaskid":"3-2","totaskid":"4","color":"#008ee4","thickness":"2"},{"fromtaskid":"3-2","totaskid":"6","color":"#008ee4","thickness":"2"},{"fromtaskid":"7","totaskid":"8","color":"#008ee4","thickness":"2"},{"fromtaskid":"7","totaskid":"9","color":"#008ee4","thickness":"2"},{"fromtaskid":"12","totaskid":"16","color":"#008ee4","thickness":"2"},{"fromtaskid":"12","totaskid":"17","color":"#008ee4","thickness":"2"},{"fromtaskid":"17-2","totaskid":"18","color":"#008ee4","thickness":"2"},{"fromtaskid":"19","totaskid":"22","color":"#008ee4","thickness":"2"}]}],"milestones":{"milestone":[{"date":"2/6/2014","taskid":"12","color":"#f8bd19","shape":"star","tooltext":"Completion of Phase 1"}{"date":"21/8/2008","taskid":"10","color":"#f8bd19","shape":"star","tooltext":"New estimated moving date"}]},"legend":{"item":[{"label":"Planned","color":"#008ee4"},{"label":"Actual","color":"#6baa01"},{"label":"Slack (Delay)","color":"#e44a00"}]},"trendlines":[{"line":[{"start":"19/6/2014","displayvalue":"AC Testing","color":"333333","thickness":"2","dashed":"1"}]}]}}

 */
?>
