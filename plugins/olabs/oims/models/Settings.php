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
        $newDate = date($date_format, strtotime($getDate));
        return $newDate;
    }

}
