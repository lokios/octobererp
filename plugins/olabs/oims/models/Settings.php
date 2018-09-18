<?php

namespace Olabs\Oims\Models;

use Model;

class Settings extends Model {

    public $implement = [
        'System.Behaviors.SettingsModel',
        '@RainLab.Translate.Behaviors.TranslatableModel'
    ];

    /**
     * TranslatableModel
     *
     * @var type 
     */
    public $translatable = [
        'invoice_template_content',
    ];
// A unique code
    public $settingsCode = 'olabs_oims_settings';
// Reference to field configuration
    public $settingsFields = 'fields.yaml';
    public $belongsTo = [
        'cash_on_delivery_order_status_before' => [
            'Olabs\Oims\Models\OrderStatus',
        ],
        'cash_on_delivery_order_status_after' => [
            'Olabs\Oims\Models\OrderStatus',
        ],
        'bank_transfer_order_status_before' => [
            'Olabs\Oims\Models\OrderStatus',
        ],
        'bank_transfer_order_status_after' => [
            'Olabs\Oims\Models\OrderStatus',
        ],
        'paypal_order_status_before' => [
            'Olabs\Oims\Models\OrderStatus',
        ],
        'paypal_order_status_after' => [
            'Olabs\Oims\Models\OrderStatus',
        ],
        'stripe_order_status_before' => [
            'Olabs\Oims\Models\OrderStatus',
        ],
        'stripe_order_status_after' => [
            'Olabs\Oims\Models\OrderStatus',
        ],
    ];
    public $attachOne = [
        'productDefaultImage' => 'System\Models\File',
    ];

    /**
     * Get general price formated
     * 
     * @param type $price
     * @return type
     */
    public function getPriceFormatted($price) {
        $fPrice = number_format($price, $this->number_format_decimals, $this->number_format_dec_point, $this->number_format_thousands_sep);
        if ($this->currency_char_position == 1) {
            return $this->currency_char . $fPrice;
        } else {
            return $fPrice . $this->currency_char;
        }
    }

    public function getPriceFormattedWithoutCurrency($price) {
        $fPrice = number_format($price, $this->number_format_decimals, $this->number_format_dec_point, $this->number_format_thousands_sep);
        return $fPrice;
    }

    public function getTableRowContent($html, $attr_type = 'id', $attr_value = '') {
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($html);
        $x = new \DOMXpath($dom);

        $content = false;



        if ($attr_type == 'id') {
            $temp = $x->query("//tr[@id='$attr_value']")->item(0);
            $content = $dom->saveHTML($temp);
            $content = str_replace("\n", "", $content);
        }
        if ($attr_type == 'class') {
            $temp = $x->query("//tr[@class='$attr_value']")->item(0);
            $content = $dom->saveHTML($temp);
            $content = str_replace("\n", "", $content);
        }
        return $content;
    }

    public function get_string_between($string, $startTag, $endTag) {

        $reportTemplate = "";
// get the repeating portion panel template
        $ini = strpos($string, $startTag);
        if ($ini == 0)
            return $reportTemplate; // start tag not found 
        $reportTemplate = substr($string, $ini + strlen($startTag));
        $reportTemplate = substr($reportTemplate, 0, strpos($reportTemplate, $endTag));

        return $reportTemplate;
    }

    /*
     * Function to replace text between two sub strings
     * passed params
     * $string - initial string
     * $startTag - start substring or tag
     * $endTag - end substing or tag
     * $replacement - text need to be replace
     */

    public function replace_string($string, $startTag, $endTag, $replacement) {

        $pos = strpos($string, $startTag);
        $start = $pos === false ? 0 : $pos; // + strlen($startTag);
        $pos = strpos($string, $endTag, $start);
        $end = $start === false ? strlen($string) : $pos + strlen($endTag);
        return substr_replace($string, $replacement, $start, $end - $start);
    }

    public static function convertToDBDate($getDate, $time = '00:00:00') {
        $date_format = 'Y-m-d ' . $time;
        $newDate = date($date_format, strtotime($getDate));
        return $newDate;
    }

    public static function convertToDisplayDate($getDate, $date_format = 'd/m/Y') {
//        $date_format = 'd-m-Y';
        if($getDate  == ''){
            return '';
        }
        $newDate = date($date_format, strtotime($getDate));
        return $newDate;
    }

    /* :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: */
    /* ::                                                                         : */
    /* ::  This routine calculates the distance between two points (given the     : */
    /* ::  latitude/longitude of those points). It is being used to calculate     : */
    /* ::  the distance between two locations using GeoDataSource(TM) Products    : */
    /* ::                                                                         : */
    /* ::  Definitions:                                                           : */
    /* ::    South latitudes are negative, east longitudes are positive           : */
    /* ::                                                                         : */
    /* ::  Passed to function:                                                    : */
    /* ::    lat1, lon1 = Latitude and Longitude of point 1 (in decimal degrees)  : */
    /* ::    lat2, lon2 = Latitude and Longitude of point 2 (in decimal degrees)  : */
    /* ::    unit = the unit you desire for results                               : */
    /* ::           where: 'M' is statute miles (default)                         : */
    /* ::                  'K' is kilometers                                      : */
    /* ::                  'MT' is meters                                         : */
    /* ::                  'N' is nautical miles                                  : */
    /* ::  Worldwide cities and other features databases with latitude longitude  : */
    /* ::  are available at https://www.geodatasource.com                          : */
    /* ::                                                                         : */
    /* ::  For enquiries, please contact sales@geodatasource.com                  : */
    /* ::                                                                         : */
    /* ::  Official Web site: https://www.geodatasource.com                        : */
    /* ::                                                                         : */
    /* ::         GeoDataSource.com (C) All Rights Reserved 2017		   		     : */
    /* ::                                                                         : */
    /* :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: */

//    public static function distance($lat1, $lon1, $lat2, $lon2, $unit = 'MT') {
//
//        $theta = $lon1 - $lon2;
//        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
//        $dist = acos($dist);
//        $dist = rad2deg($dist);
//        $miles = $dist * 60 * 1.1515;
//        $unit = strtoupper($unit);
//
//        if ($unit == "K") {
//            return ($miles * 1.609344);
//        } else if ($unit == "N") {
//            return ($miles * 0.8684);
//        } else if ($unit == "MT") {
//            return ($miles * 1609.344);
//        } else {
//            return $miles;
//        }
//    }

//echo distance(32.9697, -96.80322, 29.46786, -98.53506, "M") . " Miles<br>";
//echo distance(32.9697, -96.80322, 29.46786, -98.53506, "K") . " Kilometers<br>";
//echo distance(32.9697, -96.80322, 29.46786, -98.53506, "N") . " Nautical Miles<br>";

    /**
     * Calculates the great-circle distance between two points, with
     * the Haversine formula.
     * @param float $latitudeFrom Latitude of start point in [deg decimal]
     * @param float $longitudeFrom Longitude of start point in [deg decimal]
     * @param float $latitudeTo Latitude of target point in [deg decimal]
     * @param float $longitudeTo Longitude of target point in [deg decimal]
     * @param float $earthRadius Mean earth radius in [m]
     * @return float Distance between points in [m] (same as earthRadius)
     */
    public static function distance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $unit = 'MT') {
// convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $earthRadius = 6371000;
        $unit = strtoupper($unit);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
                                cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

        $miles = $angle * $earthRadius;
        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else if ($unit == "MT") {
            return ($miles * 1609.344);
        } else {
            return $miles;
        }
    }

}
